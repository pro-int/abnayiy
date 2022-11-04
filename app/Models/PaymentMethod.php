<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    public static function paymentMethods($returnArray = true, $payment_method_id = null)
    {  
        $paymentMethods = PaymentMethod::where('active',1)->orderBy('id');

        if (null !== $payment_method_id) {
            if (is_array($payment_method_id)) {
                $paymentMethods = $paymentMethods->whereIn('id',$payment_method_id);
            } else {
                $paymentMethods = $paymentMethods->where('id',$payment_method_id);
            }
        }
        
        if ($returnArray) {
            return $paymentMethods->pluck('method_name','id')->toArray();
        }
        
        return PaymentMethod::select('method_name','id')->get();
    }
}
