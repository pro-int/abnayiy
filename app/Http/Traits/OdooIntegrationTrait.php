<?php

namespace App\Http\Traits;

use App\Services\OdooCURLServices;
use Illuminate\Support\Facades\DB;

trait OdooIntegrationTrait
{
    public function createStudentInOdoo($student){
        info("student object body = " .$student);
        $service = new OdooCURLServices();
        $result = $service->sendStudentToOdoo($student);
        info("odoo student response result = ", $result);

        if(isset($result["code"]) && $result["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["message"]);
        }

        $httpcode = $result["code"];
        $response = $result["response"];

        $msg = (isset($response->result)) ? $response->result->message : '';
        $student_id = $student["student_id"];

        DB::transaction(function () use ($response, $msg, $student_id, $httpcode) {
            DB::table('students')->where("id", $student_id)->update([
                "odoo_record_id" => ($httpcode == 200 && isset($response->result)) ? $response->result->ID : null,
                "odoo_sync_status" => ($httpcode == 200 && isset($response->result) && $response->result->success) ? 1 : 0,
                "odoo_message" => $msg
            ]);
        });


        if ($httpcode == 200 && isset($response->result) && isset($response->result->success) && $response->result->success) {
            return redirect()->back()
                ->with('alert-info', 'تم اضافه الطالب في odoo بنجاح');
        }

        return redirect()->back()
            ->with('alert-danger', $msg);

    }

    public function createParentInOdoo($parent){
        $service = new OdooCURLServices();
        $result = $service->sendParentToOdoo($parent);

        if(isset($result["error"])){
            return redirect()->back()
                ->with('alert-danger', $result["message"]);
        }

        $httpcode = $result["code"];
        $response = $result["response"];

        $msg = (isset($response->result))?$response->result->message:'';
        $guardian_id = $parent["guardian_id"];

        DB::transaction(function () use ($response,$msg,$guardian_id,$httpcode){
            DB::table('guardians')->where("guardian_id",$guardian_id)->update([
                "odoo_record_id" => ($httpcode == 200 && isset($response->result))?$response->result->ID:null,
                "odoo_sync_status" => ($httpcode == 200 && isset($response->result) && $response->result->success) ? 1 : 0,
                "odoo_message" => $msg
            ]);
        });

        if($httpcode == 200 && isset($response->result) && isset($response->result->success) && $response->result->success){
            return redirect()->back()
                ->with('alert-info', 'تم اضافه ولي الامر في odoo بنجاح');
        }

        return redirect()->back()
            ->with('alert-danger', $msg);

    }

    public function createPaymentInOdoo($payment, $payment_id){
        info($payment);
        $service = new OdooCURLServices();
        $result = $service->sendPaymentToOdoo($payment);
        info("odd payment response result = " . $result);
        if(isset($result["code"]) && $result["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["message"]);
        }

        $httpcode = $result["code"];
        $response = $result["response"];

        $msg = (isset($response->result))?$response->result->message:'';

        DB::transaction(function () use ($response,$msg,$payment_id,$httpcode){
            DB::table('payment_attempts')->where("id",$payment_id)->update([
                "odoo_record_id" => ($httpcode == 200 && isset($response->result))?$response->result->ID:null,
                "odoo_sync_status" => ($httpcode == 200 && isset($response->result) && $response->result->success) ? 1 : 0,
                "odoo_message" => $msg
            ]);
        });

        if($httpcode == 200 && isset($response->result) && isset($response->result->success) && $response->result->success){
            return redirect()->back()
                ->with('alert-info', 'تم اضافه دفعه التعاقد في odoo بنجاح');
        }

        return redirect()->back()
            ->with('alert-danger', $msg);

    }

    public function createInvoiceInOdoo($invoice, $contract_id){
        info("contract object body = " . $invoice);
        $service = new OdooCURLServices();
        $result = $service->sendInvoiceToOdoo($invoice);
        info("odoo invoice response result = " . $result);
        if(isset($result["code"]) && $result["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["message"]);
        }

        $httpcode = $result["code"];
        $response = $result["response"];

        $msg = (isset($response->result))?$response->result->message: '';

        DB::transaction(function () use ($response,$msg,$contract_id,$httpcode){
            DB::table('contracts')->where("id",$contract_id)->update([
                "odoo_record_id" => ($httpcode == 200 && isset($response->result))?$response->result->ID:null,
                "odoo_sync_status" => ($httpcode == 200 && isset($response->result) && $response->result->success) ? 1 : 0,
                "odoo_message" => $msg
            ]);
        });

        if($httpcode == 200 && isset($response->result) && isset($response->result->success) && $response->result->success){
            return redirect()->back()
                ->with('alert-info', 'تم اضافه التعاقد في odoo بنجاح');
        }

        return redirect()->back()
            ->with('alert-danger', $msg);
    }

}
