<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
define("AUTHENTICATION", "https://www.paytabs.com/apiv2/validate_secret_key");
define("PAYPAGE_URL", "https://www.paytabs.com/apiv2/create_pay_page");
define("VERIFY_URL", "https://www.paytabs.com/apiv2/verify_payment");
define("VERIFY_TRANSACTION", "https://www.paytabs.com/apiv2/verify_payment_transaction");
define("STCPAY_VERIFY_URL", "https://www.paytabs.com/apiv3/stcpay_verify_transaction");
define("STCPAY_QR_VERIFY_URL", "https://www.paytabs.com/apiv3/stcpayqr_verify_transaction");
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{    
    private $merchant_email;
    private $secret_key;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pt = $this->runPost(AUTHENTICATION, array("merchant_email"=> "sajalkundu02@gmail.com", "secret_key" => "B6BMd06Lk9i5ddHY3MAbGpSNMQLV5VLG1mtfnz0HIjMWxuUAgvMXUEKGuwCArngtKKJ7jJO23BYB5TcmoYjiC4Z7ACH2ZYvKIeR1"));
    $reault = array(
        "merchant_email" => "sajalkundu02@gmail.com",
        "secret_key" => "B6BMd06Lk9i5ddHY3MAbGpSNMQLV5VLG1mtfnz0HIjMWxuUAgvMXUEKGuwCArngtKKJ7jJO23BYB5TcmoYjiC4Z7ACH2ZYvKIeR1",
        'payment_type' => 'stcpay',
        "site_url" => "http://localhost:8000",
        "return_url" => "http://localhost:8000/return",
        "title" => "JohnDoe And Co.",
        "cc_first_name" => "John",
        "cc_last_name" => "Doe",
        "cc_phone_number" => "00973",
        "phone_number" => "123123123456",
        "email" => "johndoe@example.com",
        "products_per_title" => "MobilePhone || Charger || Camera",
        "unit_price" => "12.123 || 21.345 || 35.678 ",
        "quantity" => "2 || 3 || 1",
        "other_charges" => "12.123",
        "amount" => "136.082",
        "discount" => "15.123",
        "currency" => "SAR",
        "reference_no" => "ABC-123",
        "ip_customer" =>"1.1.1.0",
        "ip_merchant" =>"1.1.1.0",
        "billing_address" => "Flat 3021 Manama Bahrain",
        "city" => "Manama",
        "state" => "Manama",
        "postal_code" => "12345",
        "country" => "BHR",
        "shipping_first_name" => "John",
        "shipping_last_name" => "Doe",
        "address_shipping" => "Flat 3021 Manama Bahrain",
        "state_shipping" => "Manama",
        "city_shipping" => "Manama",
        "postal_code_shipping" => "1234",
        "country_shipping" => "BHR",
        "msg_lang" => "English",
        "cms_with_version" => "API USING PHP"
        ); 

        $return_result= $this->runPost(PAYPAGE_URL, $reault);
        $final_result = json_decode($return_result);

        if($final_result->response_code == 4012){
            return redirect($final_result->payment_url);
        }
        return $final_result->result;
    }

    public function return(Request $request)
    {


        $result = json_decode($this->runPost(VERIFY_URL,array("merchant_email"=> "sajalkundu02@gmail.com", "secret_key" => "B6BMd06Lk9i5ddHY3MAbGpSNMQLV5VLG1mtfnz0HIjMWxuUAgvMXUEKGuwCArngtKKJ7jJO23BYB5TcmoYjiC4Z7ACH2ZYvKIeR1",'payment_reference' => $request->payment_reference)));

        $final_result = json_decode($this->runPost(VERIFY_TRANSACTION,array("merchant_email"=> "sajalkundu02@gmail.com", "secret_key" => "B6BMd06Lk9i5ddHY3MAbGpSNMQLV5VLG1mtfnz0HIjMWxuUAgvMXUEKGuwCArngtKKJ7jJO23BYB5TcmoYjiC4Z7ACH2ZYvKIeR1",'transaction_id' => $result->transaction_id)));

        $final_result_1 = $this->runPost(STCPAY_QR_VERIFY_URL,array("merchant_id"=> "10056342", "secret_key" => "B6BMd06Lk9i5ddHY3MAbGpSNMQLV5VLG1mtfnz0HIjMWxuUAgvMXUEKGuwCArngtKKJ7jJO23BYB5TcmoYjiC4Z7ACH2ZYvKIeR1", "transaction_id" => $final_result->transaction_id));
        dd($final_result_1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public static function getInstance($merchant_email, $secret_key)
    // {
    //     static $inst = null;
    //     if ($inst === null) {
    //         $inst = $this->authentication();
    //     }
    //     $inst->setMerchant($merchant_email, $secret_key);
    //     return $inst;
    // }


    function authentication(){
        $obj = json_decode($this->runPost(AUTHENTICATION, array("merchant_email"=> $this->merchant_email, "secret_key"=>  $this->secret_key)));
        if($obj->access == "granted")
            $this->api_key = $obj->api_key;
        else
            $this->api_key = "";
        return $this->api_key;
    }

    function setMerchant($merchant_email, $secret_key) {
        $this->merchant_email = $merchant_email;
        $this->secret_key = $secret_key;
        $this->api_key = "";
    }

    function create_pay_page($values) {
        $values['merchant_email'] = $this->merchant_email;
        $values['merchant_secretKey'] = $this->secret_key;
        $values['ip_customer'] = $_SERVER['REMOTE_ADDR'];
        $values['ip_merchant'] = isset($_SERVER['SERVER_ADDR'])? $_SERVER['SERVER_ADDR'] : '::1';
        return json_decode($this->runPost(PAYPAGE_URL, $values));
    }

    public function payment()
    {
        // $url = "https://b2btest.stcpay.com.sa/B2B.MerchantWebApi/";
        // $result = $this->runPost($url, array('username' => '0544418733', 'password'=> 'Lovetomy123','RefNum' => 'V1RN3'));
            

            $url = "https://b2btest.stcpay.com.sa/B2B.MerchantTransactionsWebApi/MerchantTransactions/v3/PaymentInquiry";
            $method = "POST";
            $headers = [
				          'Accept'        => 'application/json',
				      ];
			$params = [
				'RefNum' => 'V1RN3',
			];

        	$response = $this->callApi($method, $url, $params, $headers);
        	dd($response);
    }

    function runPost($url, $fields) {
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        $ip = $_SERVER['REMOTE_ADDR'];

        $ip_address = array(
            "REMOTE_ADDR" => $ip,
            "HTTP_X_FORWARDED_FOR" => $ip
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ip_address);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }



}
