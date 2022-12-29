<?php

namespace App\Models;

use App\Events\UpdateDiscount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contract extends Model
{
    use HasFactory;

    const STATUS = [
        0 => 'بانتظار سداد مبلغ التعاقد',
        1 => 'تم التعاقد',
        2 => 'تعاقد منتهي',
        3 => 'الغاء التعاقد'
    ];
    const EXAM_RESULT = [
        'pass' => 'ناجح',
        'fail' => 'راسب',
    ];

    protected $fillable = [
        'student_id',
        'application_id',
        'academic_year_id',
        'plan_id',
        'level_id',
        'applied_semesters',
        'tuition_fees',
        'period_discounts',
        'coupon_discounts',
        'vat_rate',
        'vat_amount',
        'bus_fees',
        'debt',
        'total_fees',
        'total_paid',
        'terms_id',
        'admin_id',
        'exam_result',
        'classRoomId',
        'old_contract_id',
        'class_id',
        'status',
        'odoo_record_study_id',
        'odoo_sync_study_status',
        'odoo_message_study',
        'odoo_record_transportation_id',
        'odoo_sync_transportation_status',
        'odoo_message_transportation',
        'odoo_record_journal_id',
        'odoo_sync_journal_status',
        'odoo_message_journal'
    ];

    protected $casts = [
        'applied_semesters' => 'array'
    ];



    public static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            dispatch(new UpdateDiscount($item->level_id, $item->academic_year_id));
            $item->update_total_payments();
        });

        static::updated(function ($item) {
            if ($item->isDirty('exam_result')) {
                $item->updateGuardianPointsBalance();
            } else {
                dispatch(new UpdateDiscount($item->level_id, $item->academic_year_id));
            }
        });

        static::deleting(function ($item) {
            $contracts = Contract::where('student_id', $item->student_id)->where('id', '!=', $item->id)->get();
            if (!count($contracts)) {
                # delete student
                $application = Application::find($item->application_id);
                if ($application) {
                    # application founded
                    $application->status_id = 1;
                    $application->save();
                }
                $item->student()->delete();
            }
            $item->transactions()->delete();
            $item->transportation()->delete();
            $item->transfare()->delete();
            $item->files()->delete();
        });

        static::deleted(function ($item) {
            dispatch(new UpdateDiscount($item->level_id, $item->academic_year_id));
        });
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function transportation()
    {
        return $this->hasMany(StudentTransportation::class);
    }

    public function transfare()
    {
        return $this->hasOne(TransferRequest::class,'contract_id','old_contract_id');
    }

    public function files()
    {
        return $this->hasMany(ContractFile::class);
    }

    public function getStatus()
    {
        $class = '';
        switch ($this->status) {
            case 0:
                $class = 'warning';
                break;
            case 1:
                $class = 'success';
                break;
            case 2:
            case 3:
                $class = 'danger';
                break;
            default:
                $class = 'default';
                break;
        }

        return '<span class="badge bg-' . $class . '">' . self::STATUS[$this->status] ?? 'غير محدد' . '</span>';
    }

    public function getStudentStatus($graduated = false)
    {

        if ($graduated) {
            $class = 'secondary';
            $key = 'graduated';
        } else {

            if ($this->application_id) {
                $class = 'success';
                $key = 'new';
            } else {
                $class = 'warning';
                $key = 'old';
            }
        }
        return getBadge([$class, getStudentStatus($key)]);
    }
    public function getExamResult()
    {
        switch ($this->exam_result) {
            case 'pass':
                $class = 'success';
                $text =  self::EXAM_RESULT[$this->exam_result];
                break;
            case 'fail':
                $class = 'danger';
                $text =  self::EXAM_RESULT[$this->exam_result];
                break;
            default:
                $class = 'secondary';
                $text = 'غير محدد';
                break;
        }
        return '<span class="badge bg-' . $class . '">' . $text . '</span>';
    }

    public function GetContractSpan()
    {
        # calculate payment persent
        $percent = $this->getContractPaidPersent();
        if (!$percent) {
            $spna = '<abbr title="الرسوم الدراسية  ' . ($this->tuition_fees - $this->period_discounts - $this->coupon_discounts) . '- رسوم النقل  ' . ($this->bus_fees > 0 ? $this->bus_fees : ' غير مشترك ')  . ' - الضرائب ' . $this->vat_amount . ' "><span class="badge bg-danger">لم يسدد</span></abbr>';
        } else if (($this->total_fees - $this->total_paid == 0) || $this->total_fees == 0) {
            $spna = '<span class="badge bg-success">تم السداد</span>';
        } else {
            $spna = '<abbr title="مدفوع ' . $this->total_paid . ' من اصل ' . $this->total_fees . ' - رسوم النقل  ' . ($this->bus_fees > 0 ? $this->bus_fees : ' غير مشترك ')  . '"><span class="badge bg-warning">تم سداد ' . $this->getContractPaidPersent() . ' %</span></abbr>';
        }

        return $spna;
    }

    /**
     * @return int
     */
    public function getContractPaidPersent()
    {
        return $this->total_fees == 0 ? 100 : round($this->total_paid / $this->total_fees * 100, 2);
    }

    protected function updateGuardianPointsBalance()
    {
        $guardianPoints = GuardianPoints::where('academic_year_id', $this->academic_year_id)->where('guardian_id', $this->guardian_id)->first();
        if (!$guardianPoints) {

            $guardianPoints = new GuardianPoints();
            $guardianPoints->guardian_id = $this->guardian_id;
            $guardianPoints->academic_year_id = $this->academic_year_id;

            $contracts = Contract::select('contracts.id', 'contracts.total_fees', 'contracts.total_paid')
                ->leftJoin('students', 'students.id', 'contracts.student_id')
                ->where('students.guardian_id', $this->guardian_id)
                ->where('contracts.academic_year_id', $this->academic_year_id)
                ->get();

            $total_fees = $contracts->sum('total_fees');
            $total_paid = $contracts->sum('total_paid');

            if ($total_fees > 0) {
                $paid_percent = $total_paid / $total_fees * 100;

                if ($paid_percent < 99) {
                    $guardianPoints->points = -2;
                    $guardianPoints->reason = sprintf('قام ولي الأمر بتسديد %s فقط من اصل %s', $total_paid, $total_fees);
                } else {
                    $contracts_ids = $contracts->pluck('id')->toArray();
                    $payment = PaymentAttempt::select('payment_attempts.id', 'payment_attempts.period_id', 'periods.points_effect', 'periods.period_name')
                        ->leftJoin('transactions', 'transactions.id', 'payment_attempts.transaction_id')
                        ->leftJoin('periods', 'periods.id', 'payment_attempts.period_id')
                        ->where('transactions.transaction_type', 'tuition')
                        ->whereIn('transactions.contract_id', $contracts_ids)
                        ->latest('payment_attempts.id')->first();

                    $guardianPoints->points =  $payment->points_effect ?? 0;
                    $guardianPoints->period_id =  $payment->period_id;
                    $guardianPoints->reason = sprintf('قام ولي الأمر بتسديد مبلغ  %s من اجمالي %s في الفترة (%s)', $total_paid, $total_fees, $payment->period_name);
                }
            } else {
                $guardianPoints->points = 0;
                $guardianPoints->reason = sprintf('لا توجد رسوم مستحقة علي ولي الأمر');
            }

            $guardianPoints->save();
        }
    }
    public function update_total_payments($withdrawal = null)
    {
        $transaction = $this->transactions();

        $period_discounts = $transaction->sum('period_discount');
        $coupon_discounts = $transaction->sum('coupon_discount');
        $vat_amount = $transaction->sum('vat_amount');
        $total_paid = $transaction->sum('paid_amount');

        $buss_fees = $transaction->where('transaction_type', 'bus')->sum('amount_before_discount');
        $tuition_fees = $this->transactions()->where('transaction_type', 'tuition')->sum('amount_before_discount');
        $debt = $this->transactions()->where('transaction_type', 'debt')->sum('amount_before_discount');

        $this->tuition_fees = $tuition_fees;
        $this->period_discounts = round($period_discounts, 2);
        $this->coupon_discounts = round($coupon_discounts, 2);
        $this->vat_amount = round($vat_amount, 2);
        $this->bus_fees = round($buss_fees, 2);

        $withdrawal_fees = 0;
        if($withdrawal != null || $withdrawal === 0.0){
            $this->status = 3;
            $withdrawal_fees = $this->transactions()->where('transaction_type', 'withdrawal') ? $withdrawal : 0;
        }

        $this->total_fees = round(($tuition_fees - $period_discounts - $coupon_discounts) + $buss_fees + $vat_amount + $debt + $withdrawal_fees, 2);

        $this->total_paid = round($total_paid, 2);
        $this->debt = $debt;

        return $this->save();
    }

}
