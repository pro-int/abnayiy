<?php

namespace App\Http\Traits;

use App\Services\OdooCURLServices;
use Illuminate\Support\Facades\DB;

trait OdooIntegrationTrait
{
    public function createStudentInOdoo($student){
        info("student object body = " . json_encode($student));
        $service = new OdooCURLServices();
        $result = $service->sendStudentToOdoo($student);
        info("odoo student response = " . json_encode($result));

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
        info("payment object body = " . json_encode($payment));
        $service = new OdooCURLServices();
        $result = $service->sendPaymentToOdoo($payment);
        info("odd payment response result = " . json_encode($result));
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

    public function createInvoiceInOdoo($invoice, $transInvoice=null, $contract_id, $contract_odoo_sync_study_status=null, $contract_odoo_sync_transportation_status=null){
        info("contract object body = " . json_encode($invoice));
        $service = new OdooCURLServices();
        $result = $service->sendInvoiceToOdoo($invoice, $transInvoice, $contract_odoo_sync_study_status, $contract_odoo_sync_transportation_status);
        info("odoo invoice response result = " . json_encode($result));

        if(isset($result["resultStudy"]["code"]) && $result["resultStudy"]["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["resultStudy"]["message"]);
        }

        if(isset($result["resultTransportation"]["code"]) && $result["resultTransportation"]["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["resultTransportation"]["message"]);
        }

        $httpStudyCode = $result["resultStudy"]["code"] ?? null;
        $responseStudy = $result["resultStudy"]["response"]?? null;

        $httpTransportationCode = $result["resultTransportation"]["code"]?? null;
        $responseTransportation = $result["resultTransportation"]["response"]?? null;

        $msgStudy = (isset($responseStudy->result))?$responseStudy->result->message: '';
        $msgTransportation = (isset($responseTransportation->result))?$responseTransportation->result->message: '';

        DB::transaction(function () use ($responseStudy, $responseTransportation, $msgStudy, $msgTransportation, $contract_id, $httpStudyCode, $httpTransportationCode){
            DB::table('contracts')->where("id",$contract_id)->update([
                "odoo_record_study_id" => ($httpStudyCode == 200  && $responseStudy)?$responseStudy->result->ID:null,
                "odoo_sync_study_status" => ($httpStudyCode == 200 && $responseStudy && $responseStudy->result->success) ? 1 : 0,
                "odoo_message_study" => $msgStudy,
                "odoo_record_transportation_id" => ($httpTransportationCode == 200  && $responseTransportation)?$responseTransportation->result->ID:null,
                "odoo_sync_transportation_status" => ($httpTransportationCode == 200 && $responseTransportation && $responseTransportation->result->success) ? 1 : 0,
                "odoo_message_transportation" => $msgTransportation
            ]);
        });

        if($httpStudyCode == 200 && isset($responseStudy->result) && isset($responseStudy->result->success) && $responseStudy->result->success){
            return redirect()->back()
                ->with('alert-info', 'تم اضافه تعاقد الرسوم الدراسيه في odoo بنجاح');
        }

        if($httpTransportationCode == 200 && isset($responseTransportation->result) && isset($responseTransportation->result->success) && $responseTransportation->result->success){
            return redirect()->back()
                ->with('alert-secondary', 'تم اضافه تعاقد الرسوم النقل في odoo بنجاح');
        }

        return redirect()->back()
            ->with(['alert-danger' => $msgStudy, 'alert-warning' => $msgTransportation != ''? $msgTransportation:null]);
    }

}
