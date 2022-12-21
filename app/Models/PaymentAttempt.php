<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PaymentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'payment_method_id',
        'requested_ammount',
        'received_ammount',
        'approved',
        'reference',
        'reason',
        'coupon',
        'coupon_discount',
        'period_id',
        'bank_id',
        'payment_network_id',
        'period_discount',
        'attach_pathh',
        'guardian_id',
        'admin_id',
        'odoo_record_id',
        'odoo_sync_status',
        'odoo_message',
    ];

    private $odooIntegrationKeys = [];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            if (! is_null($item->reference) && Storage::exists($item->reference)) {
                Storage::unlink($item->reference);
            }
        });
    }

    public function getInternalUrl()
    {
        $transaction = transaction::select('transactions.id', 'transactions.contract_id','contracts.student_id')
            ->leftjoin('contracts', 'contracts.id', 'transactions.contract_id')
            ->where('transactions.id', $this->transaction_id)
            ->first();

        if ($transaction) {
            return route('students.contracts.transactions.attempts.index', ['student' => $transaction->student_id, 'contract' => $transaction->contract_id, 'transaction' => $transaction->id]);
        } else {
            return '';
        }
    }

    public function approved()
    {
        $status = [
            'بأنتظار التأكيد',
            'مدفوع',
            'فشل الدفع',
        ];

        return isset($status[$this->approved]) ? $status[$this->approved] : 'غير معروف';
    }

    public static function PindngPayments()
    {
        return Cache::remember('PindngPayments', 30, function () {
            return PaymentAttempt::where('approved', 0)->whereIn('payment_method_id', PaymentMethod::where('require_approval', 1)->pluck('id')->toArray())->count();
        });
    }

    public function getOdooKeys()
    {
        if($this->approved == 1){

            $transaction = Transaction::select('transactions.id', 'transactions.contract_id','contracts.student_id',)
                ->leftjoin('contracts', 'contracts.id', 'transactions.contract_id')
                ->where('transactions.id', $this->transaction_id)
                ->first();

            if($this->bank_id){
                $bankObject = Bank::select("journal_id")->where("id",$this->bank_id)->first();
                $bankJournalID = $bankObject->journal_id;
            }else if($this->payment_network_id){
                $bankJournalID = 9;
            }else{
                // static el riad bank
                $bankObject = Bank::select("journal_id")->where("id",8)->first();
                $bankJournalID = $bankObject->journal_id;
            }

            $this->odooIntegrationKeys["student_id"] = $transaction->student_id;
            $this->odooIntegrationKeys["amount"] =  $this->received_ammount;
            $this->odooIntegrationKeys["date"] = Carbon::parse($this->updated_at)->toDateString();
            $this->odooIntegrationKeys["journal_id"] = (int)$bankJournalID;

            return $this->odooIntegrationKeys;
        }

    }
}
