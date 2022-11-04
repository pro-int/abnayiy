<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\meeting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\UsedSlots1MeetingRequest;
use App\Http\Requests\UsedSlotsMeetingRequest;
use App\Http\Requests\NewMeetingRequest;
use App\Http\Traits\ManageAppointments;
use App\Models\AppointmentSection;
use App\Models\Grade;

class MeetingController extends Controller
{
    use ManageAppointments;

    public function used_slots(UsedSlotsMeetingRequest $request)
    {
        $section_id =  Grade::select('appointment_section_id')->findOrFail($request->grade_id)->appointment_section_id;

        $response = $this->CheckAvailableAppointments($request->selected_date, $section_id);
        return $this->ApiSuccessResponse($response);
    }
    public function new_meeting(NewMeetingRequest $request)
    {
        # book new slot


        $new_meetig = meeting::whereDate('day', $request->selected_date)->whereTime('time', $request->selected_time)->first();
        if (!$new_meetig) {
            $new_meetig = new meeting();
            $new_meetig->day = $request->selected_date;
            $new_meetig->time = $request->selected_time;
            $new_meetig->online = $request->online;
            $new_meetig->application_id = $request->application_id;
            if ($new_meetig->save()) {
                //                return $this->ApiSuccessResponse($new_meetig);
                return response()->json([
                    'done' => true,
                    'success' => true,
                    'meetig' => $new_meetig
                ]);
            } else {
                return $this->ApiErrorResponse('حدث خطأ غير متوقع اثناء عملية حجز الميعاد .. حاول مرة اخري');
            }
        } else {

            return $this->ApiErrorResponse('هذا الميعاد غير متاح .. رحاء اختيار موعد اخر');
        }
    }
}
