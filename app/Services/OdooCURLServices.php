<?php

namespace App\Services;



class OdooCURLServices
{
    private string $GET_ACCESS_API = '/web/session/authenticate';
    private string $CREATE_STUDENT_API = '/api/create/student';
    private string $CREATE_INVOICE_API = '/api/create/invoice';
    private string $CREATE_PARENT_API = '/api/create/parent';
    private string $CREATE_PAYMENT_API = '/api/create/payment';

    private $SESSION_ID = null;

    private string $odoo_db;
    private string $odoo_url;
    private string $odoo_password;

    public function getAccessServerOdoo(): bool{
        $db = config("odoo_configuration")['db'];
        $username = config("odoo_configuration")['username'];
        $password = config("odoo_configuration")['password'];
        $url = config("odoo_configuration")['url'];

        $this->odoo_url = $url;
        $this->odoo_db = $db;
        $this->odoo_password = $password;

        $body = [
            "db" => $db ,
            "login" => $username ,
            "password" =>  $password
        ];

        $result = $this->sendCURLRequestToOdoo($body, $this->GET_ACCESS_API, "GET", "getAccess");

        if(isset($result["response"]->result) && $this->SESSION_ID != null){
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
            $this->SESSION_ID ? 'Cookie: frontend_lang=en_US; session_id=' . $this->SESSION_ID : null
        );

        curl_setopt($curl, CURLOPT_URL, $this->odoo_url . $url);
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
            "status_code" => $httpcode??null,
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
        $this->SESSION_ID = $cookies['session_id'];
    }

    private function checkOdooAuth(): array{
        if(!$this->SESSION_ID && !$this->getAccessServerOdoo()){
            return [
                "error" => true,
                "message" => "يرجي الرجوع لحسابات odoo للتاكد من صلاحيات الدخول"
            ];
        }
        return ["error" => false];
    }

    public function sendStudentToOdoo($student): array{
        $result = $this->checkOdooAuth();
        if($result["error"]){
            return $result;
        }
        return $this->sendCURLRequestToOdoo($student, $this->CREATE_STUDENT_API, "POST");
    }

    public function sendInvoiceToOdoo($invoice): array{
        $result = $this->checkOdooAuth();
        if($result["error"]){
            return $result;
        }

        return $this->sendCURLRequestToOdoo($invoice, $this->CREATE_INVOICE_API, "POST");
    }

    public function sendPaymentToOdoo($payment): array{
        $result = $this->checkOdooAuth();
        if($result["error"]){
            return $result;
        }

        return $this->sendCURLRequestToOdoo($payment, $this->CREATE_PAYMENT_API, "POST");
    }

    public function sendParentToOdoo($parent): array{
        $result = $this->checkOdooAuth();
        if($result["error"]){
            return $result;
        }

        return $this->sendCURLRequestToOdoo($parent, $this->CREATE_PARENT_API, "POST");
    }

}
