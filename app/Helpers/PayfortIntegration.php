<?php

/**
 * @copyright Copyright PayFort 2012-2016
 *
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class PayfortIntegration
{

    public $gatewayHost        = 'https://checkout.payfort.com/';
    public $gatewaySandboxHost = 'https://sbcheckout.payfort.com/';
    public $language           = 'ar';
    /**
     * @var string your Merchant Identifier account (mid)
     */
    public $merchantIdentifier = '';

    /**
     * @var string your access code
     */
    public $accessCode         = '';

    /**
     * @var string SHA Request passphrase
     */
    public $SHARequestPhrase   = '';

    /**
     * @var string SHA Response passphrase
     */
    public $SHAResponsePhrase = '';

    /**
     * @var string SHA Type (Hash Algorith)
     * expected Values ("sha1", "sha256", "sha512")
     */
    public $SHAType       = 'sha256';

    /**
     * @var string  command
     * expected Values ("AUTHORIZATION", "PURCHASE")
     */
    public $command       = 'PURCHASE';

    /**
     * @var decimal order amount
     */
    public $amount             = 1;

    /**
     * @var string order currency
     */
    public $currency           = 'SAR';

    /**
     * @var string item name
     */
    public $itemName           = 'Apple iPhone 6s Plus';

    /**
     * @var string you can change it to your email
     */
    public $customerEmail      = 'test@test.com';

    /**
     * @var boolean for live account change it to false
     */
    public $sandboxMode        = false;
    /**
     * @var string  project root folder
     * change it if the project is not on root folder.
     */
    public $projectUrlPath     = '/public/api/';

    /**
     * @var string  return url for this transaction
     * will be changed base on transacion.
     */
    public $return_url     = 'APP_URL';


    public function __construct($sandboxMode = true)
    {
        $this->sandboxMode = $sandboxMode;

        if ($sandboxMode) {
            $this->merchantIdentifier = 'bd9b3e6f';
            $this->accessCode         = 'STICYCDt6nGAAt5bFwtk';
            $this->SHARequestPhrase   = '83yn6se8/AfhyUQZL7zSmI{(';
            $this->SHAResponsePhrase = '13RkLYOwQ3ZRiw5/CYCtj9${';
        } else {
            $this->merchantIdentifier = 'uBiiVtOi';
            $this->accessCode         = '2bS0vDRusW3Ebrdoymm1';
            $this->SHARequestPhrase   = '94V7pZW9z1pHxIfbaFV7hF]{';
            $this->SHAResponsePhrase =  '17Zh5QCnefIk.uM3NpKW2n{#';
        }
    }

    public function processRequest($merchantReference, $paymentMethod = 'creditcard')
    {
        if ($paymentMethod == 'cc_merchantpage' || $paymentMethod == 'cc_merchantpage2' || $paymentMethod == 'installments_merchantpage') {
            $merchantPageData = $this->getMerchantPageData($paymentMethod);
            $postData = $merchantPageData['params'];
            $gatewayUrl = $merchantPageData['url'];
        } else {
            $data = $this->getRedirectionData($paymentMethod, $merchantReference);
            $postData = $data['params'];
            $gatewayUrl = $data['url'];
        }
        return array('url' => $gatewayUrl, 'params' => $postData, 'paymentMethod' => $paymentMethod);
    }

    public function getRedirectionData($paymentMethod, $merchantReference = null)
    {
        if (null == $merchantReference) {
            $merchantReference = $this->generateMerchantReference();
        }

        if ($this->sandboxMode) {
            $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';
        } else {
            $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
        }

        if ($paymentMethod == 'sadad') {
            $this->currency = 'SAR';
        }
        $postData = array(
            'amount'              => $this->convertFortAmount($this->amount, $this->currency),
            'currency'            => strtoupper($this->currency),
            'merchant_identifier' => $this->merchantIdentifier,
            'access_code'         => $this->accessCode,
            'merchant_reference'  => $merchantReference,
            'customer_email'      => $this->customerEmail,
            //'customer_name'         => trim($order_info['b_firstname'].' '.$order_info['b_lastname']),
            'command'             => $this->command,
            'language'            => $this->language,
            'return_url'          => $this->return_url,
        );

        if ($paymentMethod == 'sadad') {
            $postData['payment_option'] = 'SADAD';
        } elseif ($paymentMethod == 'naps') {
            $postData['payment_option']    = 'NAPS';
            $postData['order_description'] = $this->itemName;
        } elseif ($paymentMethod == 'installments') {
            $postData['installments']    = 'STANDALONE';
            $postData['command']         = 'PURCHASE';
        }
        $postData['signature'] = $this->calculateSignature($postData, 'request');
        $debugMsg = "Fort Redirect Request Parameters \n" . print_r($postData, 1);
        $this->log($debugMsg);
        return array('url' => $gatewayUrl, 'params' => $postData);
    }

    public function getMerchantPageData($paymentMethod)
    {
        $merchantReference = $this->generateMerchantReference();
        $returnUrl = $this->getUrl('route.php?r=merchantPageReturn');
        if (isset($_GET['3ds']) && $_GET['3ds'] == 'no') {
            $returnUrl = $this->getUrl('route.php?r=merchantPageReturn&3ds=no');
        }
        $iframeParams              = array(
            'merchant_identifier' => $this->merchantIdentifier,
            'access_code'         => $this->accessCode,
            'merchant_reference'  => $merchantReference,
            'service_command'     => 'TOKENIZATION',
            'language'            => $this->language,
            'return_url'          => $returnUrl,
        );

        if ($paymentMethod == 'installments_merchantpage') {
            $iframeParams['currency']       = strtoupper($this->currency);
            $iframeParams['installments']   = 'STANDALONE';
            $iframeParams['amount']         = $this->convertFortAmount($this->amount, $this->currency);
        }


        $iframeParams['signature'] = $this->calculateSignature($iframeParams, 'request');

        if ($this->sandboxMode) {
            $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';
        } else {
            $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
        }
        $debugMsg = "Fort Merchant Page Request Parameters \n" . print_r($iframeParams, 1);
        $this->log($debugMsg);

        return array('url' => $gatewayUrl, 'params' => $iframeParams);
    }

    public function getPaymentForm($gatewayUrl, $postData)
    {
        $form = '<form name="payfort_payment_form" id="payfort_payment_form" method="post" action="' . $gatewayUrl . '">';
        foreach ($postData as $k => $v) {
            $form .= '<input type="hidden" name="' . $k . '" value="' . $v . '">';
        }
        $form .= '<input type="submit" id="submit">';
        return $form;
    }

    public function processResponse()
    {
        $fortParams = array_merge($_GET, $_POST);

        $debugMsg = "Fort Redirect Response Parameters \n" . print_r($fortParams, 1);
        $this->log($debugMsg);

        $reason        = '';
        $response_code = '';
        $success = true;
        if (empty($fortParams)) {
            $success = false;
            $reason = "?????? ?????? ?????????? ?????????? ?????????? ??????????";
            $debugMsg = $reason;
            $this->log($debugMsg);
        } else {
            //validate payfort response
            $params        = $fortParams;
            $responseSignature     = $fortParams['signature'];
            $merchantReference = $params['merchant_reference'];
            unset($params['r']);
            unset($params['signature']);
            unset($params['integration_type']);
            $calculatedSignature = $this->calculateSignature($params, 'response');
            $params = $this->castAmountFromFort($params);
            $success       = true;
            $reason        = '';

            if ($responseSignature != $calculatedSignature) {
                $success = false;
                $reason  = 'Invalid signature.';
                $debugMsg = sprintf('Invalid Signature. Calculated Signature: %1s, Response Signature: %2s', $responseSignature, $calculatedSignature);
                $this->log($debugMsg);
            } else {
                $response_code    = $params['response_code'];
                $response_message = $params['response_message'];
                $status           = $params['status'];
                if (substr($response_code, 2) != '000') {
                    $success = false;
                    $reason  = $response_message;
                    $debugMsg = $reason;
                    $this->log($debugMsg);
                }
            }
        }
        if (!$success) {
            $p = $params;
            $p['error_msg'] = $reason;
            $response = $p;
        } else {
            $response = $params;
        }
        return  $response;
    }

    public function processMerchantPageResponse()
    {
        $fortParams = array_merge($_GET, $_POST);

        $debugMsg = "Fort Merchant Page Response Parameters \n" . print_r($fortParams, 1);
        $this->log($debugMsg);
        $reason = '';
        $response_code = '';
        $success = true;
        if (empty($fortParams)) {
            $success = false;
            $reason = "Invalid Response Parameters";
            $debugMsg = $reason;
            $this->log($debugMsg);
        } else {
            //validate payfort response
            $params        = $fortParams;
            $responseSignature     = $fortParams['signature'];
            unset($params['r']);
            unset($params['signature']);
            unset($params['integration_type']);
            unset($params['3ds']);
            $merchantReference = $params['merchant_reference'];
            $calculatedSignature = $this->calculateSignature($params, 'response');
            $success       = true;
            $reason        = '';

            if ($responseSignature != $calculatedSignature) {
                $success = false;
                $reason  = 'Invalid signature.';
                $debugMsg = sprintf('Invalid Signature. Calculated Signature: %1s, Response Signature: %2s', $responseSignature, $calculatedSignature);
                $this->log($debugMsg);
            } else {
                $response_code    = $params['response_code'];
                $response_message = $params['response_message'];
                $status           = $params['status'];
                if (substr($response_code, 2) != '000') {
                    $success = false;
                    $reason  = $response_message;
                    $debugMsg = $reason;
                    $this->log($debugMsg);
                } else {
                    $success         = true;
                    $host2HostParams = $this->merchantPageNotifyFort($fortParams);
                    $debugMsg = "Fort Merchant Page Host2Hots Response Parameters \n" . print_r($fortParams, 1);
                    $this->log($debugMsg);
                    if (!$host2HostParams) {
                        $success = false;
                        $reason  = 'Invalid response parameters.';
                        $debugMsg = $reason;
                        $this->log($debugMsg);
                    } else {
                        $params    = $host2HostParams;
                        $responseSignature = $host2HostParams['signature'];
                        $merchantReference = $params['merchant_reference'];
                        unset($params['r']);
                        unset($params['signature']);
                        unset($params['integration_type']);
                        $calculatedSignature = $this->calculateSignature($params, 'response');
                        if ($responseSignature != $calculatedSignature) {
                            $success = false;
                            $reason  = 'Invalid signature.';
                            $debugMsg = sprintf('Invalid Signature. Calculated Signature: %1s, Response Signature: %2s', $responseSignature, $calculatedSignature);
                            $this->log($debugMsg);
                        } else {
                            $response_code = $params['response_code'];
                            if ($response_code == '20064' && isset($params['3ds_url'])) {
                                $success = true;
                                $debugMsg = 'Redirect to 3DS URL : ' . $params['3ds_url'];
                                $this->log($debugMsg);
                                echo "<html><body onLoad=\"javascript: window.top.location.href='" . $params['3ds_url'] . "'\"></body></html>";
                                exit;
                                //header('location:'.$params['3ds_url']);
                            } else {
                                if (substr($response_code, 2) != '000') {
                                    $success = false;
                                    $reason  = $host2HostParams['response_message'];
                                    $debugMsg = $reason;
                                    $this->log($debugMsg);
                                }
                            }
                        }
                    }
                }
            }

            if (!$success) {
                $p = $params;
                $p['error_msg'] = $reason;
                $return_url = $this->getUrl('error.php?' . http_build_query($p));
            } else {
                $return_url = $this->getUrl('success.php?' . http_build_query($params));
            }
            echo "<html><body onLoad=\"javascript: window.top.location.href='" . $return_url . "'\"></body></html>";
            exit;
        }
    }

    public function merchantPageNotifyFort($fortParams)
    {
        //send host to host
        if ($this->sandboxMode) {
            $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';
        } else {
            $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
        }

        $postData      = array(
            'merchant_reference'  => $fortParams['merchant_reference'],
            'access_code'         => $this->accessCode,
            'command'             => $this->command,
            'merchant_identifier' => $this->merchantIdentifier,
            'customer_ip'         => $_SERVER['REMOTE_ADDR'],
            'amount'              => $this->convertFortAmount($this->amount, $this->currency),
            'currency'            => strtoupper($this->currency),
            'customer_email'      => $this->customerEmail,
            'customer_name'       => 'John Doe',
            'token_name'          => $fortParams['token_name'],
            'language'            => $this->language,
            'return_url'          => $this->getUrl('route.php?r=processResponse'),
        );

        if (!empty($merchantPageData['paymentMethod']) && $merchantPageData['paymentMethod'] == 'installments_merchantpage') {
            $postData['installments']            = 'YES';
            $postData['plan_code']               = $fortParams['plan_code'];
            $postData['issuer_code']             = $fortParams['issuer_code'];
            $postData['command']                 = 'PURCHASE';
        }

        if (isset($fortParams['3ds']) && $fortParams['3ds'] == 'no') {
            $postData['check_3ds'] = 'NO';
        }

        //calculate request signature
        $signature             = $this->calculateSignature($postData, 'request');
        $postData['signature'] = $signature;

        $debugMsg = "Fort Host2Host Request Parameters \n" . print_r($postData, 1);
        $this->log($debugMsg);

        if ($this->sandboxMode) {
            $gatewayUrl = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
        } else {
            $gatewayUrl = 'https://paymentservices.payfort.com/FortAPI/paymentApi';
        }

        $array_result = $this->callApi($postData, $gatewayUrl);

        $debugMsg = "Fort Host2Host Response Parameters \n" . print_r($array_result, 1);
        $this->log($debugMsg);

        return  $array_result;
    }

    /**
     * Send host to host request to the Fort
     * @param array $postData
     * @param string $gatewayUrl
     * @return mixed
     */
    public function callApi($postData, $gatewayUrl)
    {
        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        $useragent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0";
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json;charset=UTF-8',
            //'Accept: application/json, application/*+json',
            //'Connection:keep-alive'
        ));
        curl_setopt($ch, CURLOPT_URL, $gatewayUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "compress, gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); // The number of seconds to wait while trying to connect
        //curl_setopt($ch, CURLOPT_TIMEOUT, Yii::app()->params['apiCallTimeout']); // timeout in seconds
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);

        //$response_data = array();
        //parse_str($response, $response_data);
        curl_close($ch);

        $array_result = json_decode($response, true);

        if (!$response || empty($array_result)) {
            return false;
        }
        return $array_result;
    }

    /**
     * calculate fort signature
     * @param array $arrData
     * @param string $signType request or response
     * @return string fort signature
     */
    public function calculateSignature($arrData, $signType = 'request')
    {
        $shaString             = '';
        ksort($arrData);
        foreach ($arrData as $k => $v) {
            $shaString .= "$k=$v";
        }
        if ($signType == 'request') {
            $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        } else {
            $shaString = $this->SHAResponsePhrase . $shaString . $this->SHAResponsePhrase;
        }
        $signature = hash($this->SHAType, $shaString);

        return $signature;
    }

    /**
     * Convert Amount with dicemal points
     * @param  decimal $amount
     * @param string  $currencyCode
     * @return decimal
     */
    public function convertFortAmount($amount, $currencyCode)
    {
        $total = $amount;
        $decimalPoints = $this->getCurrencyDecimalPoints($currencyCode);
        //return round((float) $total, $decimalPoints) * (pow(10, $decimalPoints));
        return (int)ceil($total) * (pow(10, $decimalPoints));
    }

    public  function castAmountFromFort($params)
    {
        $decimalPoints = $this->getCurrencyDecimalPoints($params['currency']);
        $params['amount'] = round($params['amount'], $decimalPoints) / (pow(10, $decimalPoints));
        return $params;
    }

    /**
     *
     * @param string $currency
     * @param integer
     */
    public function getCurrencyDecimalPoints($currency)
    {
        $decimalPoint  = 2;
        $arrCurrencies = array(
            'JOD' => 3,
            'KWD' => 3,
            'OMR' => 3,
            'TND' => 3,
            'BHD' => 3,
            'LYD' => 3,
            'IQD' => 3,
        );
        if (isset($arrCurrencies[$currency])) {
            $decimalPoint = $arrCurrencies[$currency];
        }
        return $decimalPoint;
    }

    public function getUrl($path)
    {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $url = $scheme . $_SERVER['HTTP_HOST'] . $this->projectUrlPath . '/payment_result';
        return $url;
    }

    public function generateMerchantReference()
    {
        return rand(0, getrandmax());
    }

    /**
     * Log the error on the disk
     */
    public function log($messages)
    {

        info('========================================================');
        Log::debug($messages);
    }


    /**
     *
     * @param type $po payment option
     * @return string payment option name
     */
    function getPaymentOptionName($po)
    {
        switch ($po) {
            case 'creditcard':
                $method = 'Credit Cards';
                break;
            case 'cc_merchantpage':
                $method = 'Credit Cards (Merchant Page)';
                break;
            case 'installments_merchantpage':
                $method = 'Installments (Merchant Page)';
                break;
            case 'installments':
                $method = 'Installments';
                break;
            case 'sadad':
                $method = 'SADAD';
                break;
            case 'naps':
                $method = 'NAPS';
                break;
            default:
                $method = '';
                break;
        }
        return $method;
    }
}
