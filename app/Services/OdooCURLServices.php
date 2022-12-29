<?php

namespace App\Services;



class OdooCURLServices
{
    private string $GET_ACCESS_API = '/web/session/authenticate';
    private string $CREATE_STUDENT_API = '/api/create/student';
    private string $CREATE_STUDY_INVOICE_API = '/api/create/invoice/study';
    private string $CREATE_TRANSPORTATION_INVOICE_API = '/api/create/invoice/transportation';
    private string $CREATE_JOURNAL_INVOICE_API = '/api/create/journal';
    private string $CREATE_PARENT_API = '/api/create/parent';
    private string $CREATE_PAYMENT_API = '/api/create/payment';

    public function getAccessServerOdoo(): bool{
        $db = config("odoo_configuration")['db'];
        $username = config("odoo_configuration")['username'];
        $password = config("odoo_configuration")['password'];

        $body = [
            "db" => $db ,
            "login" => $username ,
            "password" =>  $password
        ];

        $result = $this->sendCURLRequestToOdoo($body, $this->GET_ACCESS_API, "GET", "getAccess");

        if(isset($result["response"]->result) && session()->has("odoo_session_id")){
            return true;
        }

        return false;
    }

    public function sendCURLRequestToOdoo($data, $url, $method, $methodName=null): array{
        $body = [
            "jasonrpc" => "2.0",
            "params" => $data
        ];

        $curl = curl_init();

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
            session()->has("odoo_session_id") ? 'Cookie: frontend_lang=en_US; session_id=' . session()->get("odoo_session_id") : null
        );

        curl_setopt($curl, CURLOPT_URL, config("odoo_configuration")['url'] . $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        if($methodName == "getAccess"){
            curl_setopt($curl, CURLOPT_HEADER, 1);
        }

        $response = curl_exec($curl);

        if($methodName == "getAccess"){
            $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $this->getCoockies($response);
            $body = substr($response, $header_size);
            $response = json_decode($body);
        }else{
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $response = json_decode($response);
        }

        curl_close($curl); // Close the connection

        return [
            "code" => $httpcode??null,
            "response" => $response
        ];
    }

    private function getCoockies($response): void{
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        session()->put("odoo_session_id", $cookies['session_id']);
    }

    private function checkOdooAuth(): array{
        if($this->getAccessServerOdoo()){
            return [
                "code" => 200
            ];
        }
        return ["code" => 401, "message" => "يرجي الرجوع لحسابات odoo للتاكد من صلاحيات الدخول"];
    }

    public function sendStudentToOdoo($student): array{
        if(session()->has('odoo_session_id')){
            $result = $this->sendCURLRequestToOdoo($student, $this->CREATE_STUDENT_API, "POST");
            if($result["code"] == 401){
                $authResult= $this->checkOdooAuth();
                if($authResult["code"] == 200){
                    return $this->sendStudentToOdoo($student);
                }else{
                    return $authResult;
                }
            }
            return $result;
        }else{
           $result = $this->checkOdooAuth();
           if($result["code"] == 401){
               return $result;
           }
           return $this->sendStudentToOdoo($student);
        }

    }

    public function sendInvoiceToOdoo($invoice, $transInvoice=null, $journalInvoice=null, $contract_odoo_sync_study_status=null, $contract_odoo_sync_transportation_status=null, $contract_odoo_sync_journal_status=null): array{
        if(session()->has('odoo_session_id')){
            $urlStudy = (isset($invoice["name"]) && $invoice["name"] == 'رسوم دراسية')? $this->CREATE_STUDY_INVOICE_API : null;
            $urlTransportation = ($transInvoice && $transInvoice["name"] == 'رسوم نقل')? $this->CREATE_TRANSPORTATION_INVOICE_API : null;
            $urlJournal = $journalInvoice? $this->CREATE_JOURNAL_INVOICE_API : null;

            $resultStudy = null;
            $resultTransportation = null;
            $resultJournal = null;

            if($urlStudy && $contract_odoo_sync_study_status == 0){
                $resultStudy = $this->sendCURLRequestToOdoo($invoice, $urlStudy, "POST");
            }
            info($resultStudy);
            if($urlTransportation && $contract_odoo_sync_transportation_status==0){
                $invoice["product_id"] = $transInvoice["product_id"];
                $invoice["name"] = $transInvoice["name"];
                $invoice["account_code"] = $transInvoice["account_code"];
                $invoice["price_unit"] = $transInvoice["price_unit"];
                $invoice["is_fees_transport"] = $transInvoice["is_fees_transport"];
                $resultTransportation = $this->sendCURLRequestToOdoo($invoice, $urlTransportation, "POST");
            }
            info($resultTransportation);

            if($urlJournal && $contract_odoo_sync_journal_status == 0){
                $resultJournal = $this->sendCURLRequestToOdoo($journalInvoice, $urlJournal, "POST");
            }
            info($resultJournal);

            if(($resultStudy && $resultStudy["code"] == 401) || ($resultTransportation && $resultTransportation["code"] == 401) || ($resultJournal && $resultJournal["code"] == 401)){
                $authResult= $this->checkOdooAuth();
                if($authResult["code"] == 200){
                    return $this->sendInvoiceToOdoo($invoice);
                }else{
                    return $authResult;
                }
            }
            return [
                "resultStudy" => $resultStudy,
                "resultTransportation" => $resultTransportation,
                "resultJournal" => $resultJournal
            ];
        }else{
            $result = $this->checkOdooAuth();
            if($result["code"] == 401){
                return $result;
            }
            return $this->sendInvoiceToOdoo($invoice);
        }
    }

    public function sendPaymentToOdoo($payment): array{
        if(session()->has('odoo_session_id')){
            $result = $this->sendCURLRequestToOdoo($payment, $this->CREATE_PAYMENT_API, "POST");
            if($result["code"] == 401){
                $authResult= $this->checkOdooAuth();
                if($authResult["code"] == 200){
                    return $this->sendPaymentToOdoo($payment);
                }else{
                    return $authResult;
                }
            }
            return $result;
        }else{
            $result = $this->checkOdooAuth();
            if($result["code"] == 401){
                return $result;
            }
            return $this->sendPaymentToOdoo($payment);
        }
    }

    public function sendParentToOdoo($parent): array{
        if(session()->has('odoo_session_id')){
            $result = $this->sendCURLRequestToOdoo($parent, $this->CREATE_PARENT_API, "POST");
            if($result["code"] == 401){
                $authResult= $this->checkOdooAuth();
                if($authResult["code"] == 200){
                    return $this->sendParentToOdoo($parent);
                }else{
                    return $authResult;
                }
            }
            return $result;
        }else{
            $result = $this->checkOdooAuth();
            if($result["code"] == 401){
                return $result;
            }
            return $this->sendParentToOdoo($parent);
        }
    }

}
