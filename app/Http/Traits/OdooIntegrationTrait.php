<?php

namespace App\Http\Traits;

use App\Services\OdooCURLServices;
use Carbon\Carbon;
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

    public function createInvoiceInOdoo($invoice,
                                        $contract_id,
                                        $transInvoice=null,
                                        $journalInvoice=null,
                                        $contract_odoo_sync_study_status=null,
                                        $contract_odoo_sync_transportation_status=null,
                                        $contract_odoo_sync_journal_status=null){
        info("contract object body = " . json_encode($invoice));
        $service = new OdooCURLServices();
        $result = $service->sendInvoiceToOdoo($invoice, $transInvoice, $journalInvoice, $contract_odoo_sync_study_status, $contract_odoo_sync_transportation_status, $contract_odoo_sync_journal_status);
        info("odoo invoice response result = " . json_encode($result));

        if(isset($result["resultStudy"]["code"]) && $result["resultStudy"]["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["resultStudy"]["message"]);
        }

        if(isset($result["resultTransportation"]["code"]) && $result["resultTransportation"]["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["resultTransportation"]["message"]);
        }

        if(isset($result["resultJournal"]["code"]) && $result["resultJournal"]["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["resultJournal"]["message"]);
        }

        $httpStudyCode = $result["resultStudy"]["code"] ?? null;
        $responseStudy = $result["resultStudy"]["response"]?? null;

        $httpTransportationCode = $result["resultTransportation"]["code"]?? null;
        $responseTransportation = $result["resultTransportation"]["response"]?? null;

        $httpJournalCode = $result["resultJournal"]["code"]?? null;
        $responseJournal = $result["resultJournal"]["response"]?? null;

        $msgStudy = (isset($responseStudy->result) && $contract_odoo_sync_study_status ==0 )?$responseStudy->result->message: '';
        $msgTransportation = (isset($responseTransportation->result) && $contract_odoo_sync_transportation_status == 0)?$responseTransportation->result->message: '';
        $msgJournal = (isset($responseJournal->result) && $contract_odoo_sync_journal_status == 0)?$responseJournal->result->message: '';

        if($contract_odoo_sync_study_status == 0 || $httpStudyCode == 200){
            DB::transaction(function () use ($responseStudy, $msgStudy, $contract_id, $httpStudyCode){
                DB::table('contracts')->where("id",$contract_id)->update([
                    "odoo_record_study_id" => ($httpStudyCode == 200  && $responseStudy)?$responseStudy->result->ID:null,
                    "odoo_sync_study_status" => ($httpStudyCode == 200 && $responseStudy && $responseStudy->result->success) ? 1 : 0,
                    "odoo_message_study" => $msgStudy,
                ]);
            });
        }

        if($contract_odoo_sync_transportation_status == 0 || $httpTransportationCode == 200){
            DB::transaction(function () use ($responseTransportation, $msgTransportation, $contract_id, $httpTransportationCode, $contract_odoo_sync_transportation_status){
                DB::table('contracts')->where("id",$contract_id)->update([
                    "odoo_record_transportation_id" => ($contract_odoo_sync_transportation_status ==0 && $httpTransportationCode == 200  && $responseTransportation)?$responseTransportation->result->ID:null,
                    "odoo_sync_transportation_status" => ($contract_odoo_sync_transportation_status == 0 && $httpTransportationCode == 200 && $responseTransportation && $responseTransportation->result->success) ? 1 : 0,
                    "odoo_message_transportation" => $msgTransportation
                ]);
            });
        }


        if($contract_odoo_sync_journal_status == 0 || $httpJournalCode == 200){
            DB::transaction(function () use ($responseJournal, $msgJournal, $contract_id, $httpJournalCode, $contract_odoo_sync_journal_status){
                DB::table('contracts')->where("id",$contract_id)->update([
                    "odoo_record_journal_id" => ($contract_odoo_sync_journal_status ==0 && $httpJournalCode == 200  && $responseJournal)?$responseJournal->result->ID:null,
                    "odoo_sync_journal_status" => ($contract_odoo_sync_journal_status == 0 && $httpJournalCode == 200 && $responseJournal && $responseJournal->result->success) ? 1 : 0,
                    "odoo_message_journal" => $msgJournal
                ]);
            });
        }

        if($httpStudyCode == 200 && isset($responseStudy->result) && isset($responseStudy->result->success) && $responseStudy->result->success){
            return redirect()->back()
                ->with('alert-info', 'تم اضافه تعاقد الرسوم الدراسيه في odoo بنجاح');
        }

        if($httpTransportationCode == 200 && isset($responseTransportation->result) && isset($responseTransportation->result->success) && $responseTransportation->result->success){
            return redirect()->back()
                ->with('alert-secondary', 'تم اضافه تعاقد الرسوم النقل في odoo بنجاح');
        }

        if($httpJournalCode == 200 && isset($responseJournal->result) && isset($responseJournal->result->success) && $responseJournal->result->success){
            return redirect()->back()
                ->with('alert-light', 'تم اضافه المديونيات في odoo بنجاح');
        }

        return redirect()->back()
            ->with(['alert-danger' => $msgStudy != '' ? $msgStudy:null, 'alert-warning' => $msgTransportation != ''? $msgTransportation:null,  'alert-dark' => $msgJournal != ''? $msgJournal:null]);
    }

    public function updateInvoiceInOdoo($invoice){
        info("Update Invoice Body = " . json_encode($invoice));
        $service = new OdooCURLServices();
        $result = $service->updateInvoiceToOdoo($invoice);
        info("odoo update invoice response = " . json_encode($result));

        if(isset($result["code"]) && $result["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["message"]);
        }

        $httpcode = $result["code"];
        $response = $result["response"];

        $msg = (isset($response->result)) ? $response->result->message : '';
        $invoice_id = $invoice["invoice_code_abnai"];

        DB::transaction(function () use ($response, $msg, $invoice_id, $httpcode) {
            DB::table('contracts')->where("id", $invoice_id)->update([
                "odoo_sync_update_invoice_status" => ($httpcode == 200 && isset($response->result) && $response->result->success) ? 1 : 0,
                "odoo_message_update_invoice" => $msg
            ]);
        });


        if ($httpcode == 200 && isset($response->result) && isset($response->result->success) && $response->result->success) {
            return redirect()->back()
                ->with('alert-info', 'تم تعديل العقد بنجاح في odoo');
        }

        return redirect()->back()
            ->with('alert-danger', $msg);
    }

    public function createInverseTransactionInOdoo($invoice, $newValue){
        $inverseArray = array(
            "date" => Carbon::parse($invoice->created_at)->toDateString(),
            "ref" => "مديونيات الطالب",
            "journal_id" => 3,
            "journals" =>[
                [
                    "account_id" => config("odoo_configuration")['db'] == "Live" ? 7686:7684,
                    "student_id" => $invoice->student_id,
                    "name" => "new",
                    "debit" => 0,
                    "credit" => $newValue,
                ],
                [
                    "account_id" => config("odoo_configuration")['db'] == "Live" ? 7687:7685,
                    "student_id" => "0000",
                    "name" => "new",
                    "debit" => $newValue,
                    "credit" => 0,
                ]
            ]
        );
        info("inverse  Body = " . json_encode($inverseArray));
        $service = new OdooCURLServices();
        $result = $service->createInverseTransactionToOdoo($inverseArray);
        info("odoo inverse response = " . json_encode($result));

        if(isset($result["code"]) && $result["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["message"]);
        }

        $httpcode = $result["code"];
        $response = $result["response"];

        $msg = (isset($response->result)) ? $response->result->message : '';
        $invoice_id = $invoice->id;

        DB::transaction(function () use ($response, $msg, $invoice_id, $httpcode) {
            DB::table('contracts')->where("id", $invoice_id)->update([
                "odoo_record_inverse_journal_id" => ($httpcode == 200 && isset($response->result)) ? $response->result->ID : null,
                "odoo_sync_inverse_journal_status" => ($httpcode == 200 && isset($response->result) && $response->result->success) ? 1 : 0,
                "odoo_message_inverse_journal" => $msg
            ]);
        });


        if ($httpcode == 200 && isset($response->result) && isset($response->result->success) && $response->result->success) {
            return redirect()->back()
                ->with('alert-info', 'تم اضافه الدفعه العكسيه بنجاح في odoo');
        }

        return redirect()->back()
            ->with('alert-danger', $msg);
    }

    public function deletePaymentInOdoo($payment){
        info("delete payment body = " . json_encode($payment));
        $service = new OdooCURLServices();
        $result = $service->deletePaymentToOdoo($payment);
        info("odd delete payment result = " . json_encode($result));

        if(isset($result["code"]) && $result["code"] == 401){
            return redirect()->back()
                ->with('alert-danger', $result["message"]);
        }

        $httpcode = $result["code"];
        $response = $result["response"];

        $msg = (isset($response->result))?$response->result->message:'';
        $payment_id = $payment['payment_code_abnai'];

        DB::transaction(function () use ($response,$msg,$payment_id,$httpcode){
            DB::table('payment_attempts')->where("id",$payment_id)->update([
                "odoo_sync_delete_status" => ($httpcode == 200 && isset($response->result) && $response->result->success) ? 1 : 0,
                "odoo_delete_message" => $msg
            ]);
        });

        if($httpcode == 200 && isset($response->result) && isset($response->result->success) && $response->result->success){
            return [
                "status" => true,
                "message" => 'تم مسح الدفعه في odoo بنجاح'
            ];
        }

        return [
            "status" => false,
            "message" => $msg
        ];

    }


}
