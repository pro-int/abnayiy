<?php

namespace App\Http\Traits;

use App\Models\guardian;
use App\Models\Contract;
use App\Models\PaymentAttempt;
use Illuminate\Support\Facades\DB;
use Ripcord\Ripcord as RipcordRipcord;
use Ripcord\Client\Client as Client;

trait OdooIntegrationTrait
{
    private string $GET_ACCESS_API = '/web/session/authenticate';
    private string $CREATE_STUDENT_API = '/api/create/student';
    private string $CREATE_PARENT_API = '/api/create/parent';
    private string $CREATE_PAYMENT_API = '/api/create/payment';
    private string $CREATE_INVOICE_API = '/api/create/invoice';


    private $SESSION_ID = null;

    private string $odoo_db;
    private string $odoo_url;
    private string $odoo_password;
    private string $odoo_username;


    private function getAccessServerOdoo(){
        $db = config("odoo_configuration")['db'];
        $username = config("odoo_configuration")['username'];
        $password = config("odoo_configuration")['password'];
        $url = config("odoo_configuration")['url'];

        $this->odoo_url = $url;
        $this->odoo_db = $db;
        $this->odoo_password = $password;

        $body = [
            "jasonrpc" => "2.0",
            "params" => [
                    "db" => $db ,
                    "login" => $username ,
                    "password" =>  $password
                ]
        ];

        $curl = curl_init();

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        curl_setopt($curl, CURLOPT_URL, $url . $this->GET_ACCESS_API);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($body));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Timeout in seconds
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($curl);

        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        $this->SESSION_ID = $cookies['session_id'];

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);

        $response = json_decode($body);

        curl_close($curl); // Close the connection

        if(isset($response->result) && $this->SESSION_ID != null){
            return true;
        }

        return false;
    }

    public function createStudentInOdoo($student){
         if($this->getAccessServerOdoo()){
             $body = [
                "jasonrpc" => "2.0",
                 "params" => $student
             ];

             $curl = curl_init();

             $headers = array(
                 'Accept: application/json',
                 'Content-Type: application/json',
                 'Cookie: frontend_lang=en_US; session_id=' . $this->SESSION_ID
             );

             curl_setopt($curl, CURLOPT_URL, $this->odoo_url . $this->CREATE_STUDENT_API);
             curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
             curl_setopt($curl, CURLOPT_POST, true);
             curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($curl, CURLOPT_TIMEOUT, 30);

             $response = curl_exec($curl);

             $response = json_decode($response);
             curl_close($curl); // Close the connection

             if(isset($response->result) && isset($response->result->success) && $response->result->success){
                 return true;
             }
             return false;
         }
    }

    public function createParentInOdoo($parent){
        if($this->getAccessServerOdoo()){
            $body = [
                "jasonrpc" => "2.0",
                "params" => $parent
            ];

            $curl = curl_init();

            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Cookie: frontend_lang=en_US; session_id=' . $this->SESSION_ID
            );

            curl_setopt($curl, CURLOPT_URL, $this->odoo_url . $this->CREATE_PARENT_API);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $response = json_decode($response);
            curl_close($curl); // Close the connection

            $msg = ($httpcode == 200 && isset($response->result))?$response->result->message:'';
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
    }

    public function createPaymentInOdoo($payment, $payment_id){

        if($this->getAccessServerOdoo() && $payment){
            $body = [
                "jasonrpc" => "2.0",
                "params" => $payment
            ];

            $curl = curl_init();

            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Cookie: frontend_lang=en_US; session_id=' . $this->SESSION_ID
            );

            curl_setopt($curl, CURLOPT_URL, $this->odoo_url . $this->CREATE_PAYMENT_API);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $response = json_decode($response);
            curl_close($curl); // Close the connection

            $msg = ($httpcode == 200 && isset($response->result))?$response->result->message:'';

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
    }

    public function createInvoiceInOdoo($invoice, $contract_id){

        if($this->getAccessServerOdoo() && $invoice){
            $body = [
                "jasonrpc" => "2.0",
                "params" => $invoice
            ];

            $curl = curl_init();

            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Cookie: frontend_lang=en_US; session_id=' . $this->SESSION_ID
            );

            curl_setopt($curl, CURLOPT_URL, $this->odoo_url . $this->CREATE_INVOICE_API);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $response = json_decode($response);
            curl_close($curl); // Close the connection

            $msg = ($httpcode == 200 && isset($response->result))?$response->result->message:'';

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


}
