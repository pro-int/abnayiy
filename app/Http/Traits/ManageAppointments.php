<?php

namespace App\Http\Traits;

use App\Models\AppointmentOffice;
use App\Models\ReservedAppointment;
use App\Models\AppointmentSection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait ManageAppointments
{
    protected $duration_time = 30;
    protected $requested_appointment;
    protected $user_id;
    protected $selected_date;
    protected $onlyTimeSlot = true;
    protected $appointment_section_id;
    protected $select_office = null;

    /**
     * if true return all appointments  unique time only -  no duplication
     * @param $onlyTimeSlot boolean 
     */
    public function CheckAvailableAppointments($selected_date, $appointment_section_id)
    {
        //--validate date from user
        $this->selected_date = $selected_date;
        $this->onlyTimeSlot = true;
        $this->appointment_section_id = $appointment_section_id;

        return $this->validateDate();
    }

    public function UpdateAppointments($request, $appointment)
    {
        //--validate date from user
        $this->selected_date = $request->selected_date;
        $this->onlyTimeSlot = false;
        $this->select_office = $appointment->office_id;
        $this->appointment_section_id = $appointment->section_id;
        $this->requested_appointment = $request->selected_time;

        $time_updated = $request->filled('change_appointment')  && (($appointment->appointment_time !== $this->requested_appointment) || ($appointment->selected_date !== $this->selected_date));
        // $result = $this->validateDate();
        // if ($result['success']) {

        //     $office_id = $this->getFreeOffice($result['slots']);

        // if (Null !== $office_id) {
        return $this->updatenAppointment($appointment, $request, $time_updated);
      
        // }
        // return [
        //     'success' => false,
        //     'message' => 'فشل اسناد الموعد الي مكتب محدد .. حاول مرة اخري',
        // ];
        // }
        // return $result;
    }

    public function bookNewAppointment($request, $appointment_section_id, $guardian_id)
    {
        $this->selected_date = $request->selected_date;
        $this->onlyTimeSlot = false;
        $this->requested_appointment = $request->selected_time;
        $this->appointment_section_id = $appointment_section_id;
        $this->user_id = $guardian_id;

        $result = $this->validateDate();
        if ($result['success']) {
            $office_id = $this->getFreeOffice($result['slots']);

            if (Null !== $office_id) {
                $new_appointment = $this->assignAppointmentToOffice($request, $office_id);
                if ($new_appointment) {
                    return [
                        'success' => true,
                        'appointment' => $new_appointment,
                    ];
                }
                return [
                    'success' => false,
                    'message' => 'خطأ اثناء اضافة الموعد',
                ];
            }
            return [
                'success' => false,
                'message' => 'الموعد المحدد لم يعد متاح',
            ];
        }
        return $result;
        # --Call busyOffice and matching appointments to assign appointment to busy office
    }

    public function getAvailableAppointments()
    {
        $day_of_week = (string) Carbon::parse($this->selected_date)->dayOfWeek;

        # get all appointments contains reserved
        $appointments = $this->allAppointments($this->appointment_section_id, $day_of_week);

        # get all reserved appointments by parents
        $reserved_appointments = ReservedAppointment::select(DB::raw('TIME_FORMAT(appointment_time ,"%H:%i") as appointment_time'), 'office_id')
            ->where('selected_date', $this->selected_date);
        if (null !== $this->select_office) {
            $reserved_appointments = $reserved_appointments->where('office_id', $this->select_office);
        }

        $reserved_appointments = $reserved_appointments->get()
            ->toArray();


        # remove reserved appointments
        foreach ($appointments as $key => $Appointment) {
            if (in_array($Appointment, $reserved_appointments)) {
                unset($appointments[$key]);
            }
        }

        if ($this->onlyTimeSlot) {
            $appointments = array_unique(array_column($appointments, 'appointment_time'));
            sort($appointments);

            $times = [];
            foreach ($appointments as $key => $value) {
                array_push($times, ['id' => $value, 'time' => str_replace('am', 'ص', str_replace('pm', 'م', Carbon::parse($value)->format('h:i a')))]);
            }
            $appointments = $times;
        }

        if ($appointments) {
            return  [
                'success' => true,
                'slots' => $appointments
            ];
        } else {
            return  [
                'success' => false,
                'slots' => [],
                'message' => 'لا توجد مواعيد متاحة في التاريخ المخدد'
            ];
        }
    }

    public function allAppointments($appointment_section_id, $day_of_week)
    {
        // $ araays = select pilottable select office_id , where section_id = appointment_section_id pluck office_id tArray
        // in select down === wherein ('office_id , $araays)
        $appointment = 'appointment_offices.id';
        $offices_ids = DB::table('section_has_offices')->where('appointment_section_id', $appointment_section_id)->pluck('appointment_office_id')->toArray();
        $offices = AppointmentOffice::select('office_schedules.time_from', 'office_schedules.time_to', $appointment)
            ->leftjoin('office_schedules', 'office_schedules.office_id', $appointment)
            ->whereIn($appointment, $offices_ids)
            ->where('office_schedules.day_of_week', $day_of_week)
            ->where('office_schedules.active', 1)
            ->orderBy($appointment)
            ->get();

        $available_slot = array();
        foreach ($offices as $office) {

            $time_from = Carbon::parse($office->time_from)->format('H:i');
            $time_to = Carbon::parse($office->time_to)->format('H:i');

            while ($time_from < $time_to) {
                array_push($available_slot, ['appointment_time' => $time_from, 'office_id' => $office->id]);
                $time_from = Carbon::parse($time_from)->addMinutes($this->duration_time)->format('H:i');
            }
        }
        return $available_slot;
    }

    public function getFreeOffice($free_times)
    {
        # -- get free office from all available appointments
        $offices_ids = array_count_values(array_column($free_times, 'office_id'));
        arsort($offices_ids);

        return $this->getMatchingAppointments($free_times, $offices_ids);
    }

    public function getMatchingAppointments($free_times, $offices_ids)
    {
        $matching_appointments = array_merge(array_filter($free_times, function ($element) {
            return isset($element['appointment_time']) && $element['appointment_time'] == $this->requested_appointment;
        }));

        $office_id = null;
        if (!empty($matching_appointments)) {

            foreach ($offices_ids as $key => $value) {
                if (in_array($key, array_column($matching_appointments, 'office_id'))) {
                    $office_id = $key;
                    break;
                }
            }
        }
        return $office_id;
    }

    public function assignAppointmentToOffice($request, $office_id)
    {
        $new_appointment = new ReservedAppointment();
        $new_appointment->appointment_time = Carbon::parse($this->requested_appointment)->format('H:i');
        $new_appointment->selected_date = $this->selected_date;
        $new_appointment->office_id = $office_id;
        $new_appointment->guardian_id = $this->user_id;
        $new_appointment->section_id = $this->appointment_section_id;
        $new_appointment->online = (bool) $request->online;
        $new_appointment->online_url = $request->online_url ?? null;

        $new_appointment->save();
        return $new_appointment;
    }

    public function updatenAppointment($appointment, $request, $time_updated)
    {
        if ($time_updated) {
            $result = $this->validateDate();
            if ($result['success']) {

                $office_id = $this->getFreeOffice($result['slots']);
                if (Null !== $office_id) {
                    $appointment->appointment_time = Carbon::parse($this->requested_appointment)->format('H:i');
                    $appointment->selected_date = $this->selected_date;
                    $appointment->office_id = $office_id;
                } else {
                    return [
                        'success' => false,
                        'message' => 'فشل اسناد الموعد الي مكتب محدد .. حاول مرة اخري',
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'لا توجد مواعيد متاحة',
                ];
            }
        }

        $appointment->online = (bool) $request->online;
        $appointment->online_url = $request->online_url;
        $appointment->save();
        return [
            'success' => true,
            'message' => "تم تعديل موعد المقابلة بنجاح ",
            'appointment' => $appointment
        ];
    }
    public function validateDate()
    {
        $message = null;
        $user_date_time =  Carbon::parse($this->selected_date);

        if ($user_date_time < Carbon::now()->format('Y-m-d')) {

            $message = 'رجاء اختيار تاريخ ابتداء من ' . Carbon::now()->addDay()->format('d-m-Y');
        } else {
            $appointment_section = AppointmentSection::select('max_day_to_reservation')->where('id', $this->appointment_section_id)->first();
            if ($appointment_section) {
                $limited_date_time = Carbon::now()->addDays($appointment_section->max_day_to_reservation)->format('Y-m-d');
                if ($limited_date_time < $user_date_time) {
                    $message = 'اقصي موعد يمكن حجزة هو ' . $limited_date_time;
                } 
            } else {
                $message = 'لا توجد مواعيد متاحة';
            }
        }
        if ($message) {
            return [
                'success' => false,
                'slots' => [],
                'errors' => ['selected_date' => ['لا توجد مواعيد متاحة']],
                'message' => $message,
            ];
        }

        return $this->getAvailableAppointments();
    }
}
