<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('mpesa');
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('RequestModel');
    }

    public function c2b()
    {
        $status = $this->mpesa->c2b(
            "600540",
            "CustomerPayBillOnline",
            "100",
            "254708374149",
            "ORDER/001"
        );
        if($status->ResponseDescription){
            echo json_encode($status);
        }
    }

    public function c2b1()
    {
        $result = $this->mpesa->STKPushSimulation(
            "174379",
            "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919",
            "CustomerPayBillOnline",
            "1",
            "254708374149",
            "174379",
            "254708374149",
            "".base_url("test/callback1")."",
//            "http://6f21c7b5.ngrok.io/ci-mpesa/test/callback1",
            "ref",
            "please work",
            "test");
        echo json_encode($result);
        $table = 'transaction';
        $data = array(
            'MerchantRequestID' => $result->MerchantRequestID,
            'CheckoutRequestID' => $result->CheckoutRequestID,
            'ResponseCode' => $result->ResponseCode,
            'ResponseDescription' => $result->ResponseDescription,
            'CustomerMessage' => $result->CustomerMessage,
        );
        $this->RequestModel->insert($table,$data);

        $file = 'mpesa_c2b1_log.txt'; //Please make sure that this file exists and is writable
        if (file_exists($file)) {
            $fh = fopen($file, 'a');
        } else {
            $fh = fopen($file, 'w');
//            chmod($file, 755);
        }
        fwrite($fh, "\n====".date("d-m-Y H:i:s")."====\n");
        fwrite($fh, json_encode($result)."\n");
        fclose($fh);
        $this->mpesa->getDataFromCallback();
    }

    public function b2c()
    {
        echo json_encode($this->mpesa->b2c(
            "testapi",
            "Y7mTY+ymS7H85tE3AClOyBdBuklKc4+vLl7sl8piK/dS5kR3OFQY1YzFZPFw4kBaHe5fIhWKNswmjOXpGR8cB9sJDPD+GmNqd07o5EFYHhJrgwp5OsXM+Q+Zx7Y65NPR5iMatF55UvrPq0rTPqiwwCCwh5CmNHPuf7fgnlZpdr8/lzkCEwpAbJ1dBxri23cBGPDXcIo1jkFDS3i/1i/jtUZpf27NBKvZyFEtot4kxK89QqRdBvZ62beilmaOvihhvwDcjsDM9aCxNstJtIkvrMYmatA7ls6LZliW+S/NfO93ZTS7gwQTRWa59x/olaFzHW2f94JtqQT+KVR+ce0KsQ==",
            "SalaryPayment",
            "1000",
            "600540",
            "254708374149",
            "Endyear",
            "".base_url("test/callback1")."",
            "".base_url("test/callback1")."",
            ""));
    }

    public function b2b()
    {
        echo json_encode($this->mpesa->b2b(
            "testapi",
            "ostZrScl5W4+5bU7mHacuWrlWUPcwvkxoxJtLPrzmEcEETw0bFLp8jZxB8Xhj6V+hem5oV+8ZlFGWQR/9Co94qemmDWgsAmG2rMphr/24fJlf7irh430uKI5VWU/50AjRQHUfdGFLmXaQcWCLPZuRj+YR8s18qy0eXEakDv4ksJCvyDNjzLKMk5to3RJXXiqQx6DdAwmAjLaful3qI2/1NxUlbNdSQnpKsshjdUBkgF8yU5FD8n+pc1ZDbO5ACRIkc1C6y1G1h4C/j3myiLnDn13TUomprAXEcLpGAS1dBvu8s4vYTtNZ2cmDKGelszbfdd1zpHUMXn4H8ujUpHz/g==",
            "10",
            "600540",
            "254708374149",
            "ref",
            "".base_url("test/callback1")."",
            "".base_url("test/callback1")."",
            "SettlingDebt",
            "BusinessPayBill",
            "4",
            "4"
        ));
    }

    public function transactionstatus()
    {
        echo json_encode($this->mpesa->transactionStatus(
            "testapi",
            "ostZrScl5W4+5bU7mHacuWrlWUPcwvkxoxJtLPrzmEcEETw0bFLp8jZxB8Xhj6V+hem5oV+8ZlFGWQR/9Co94qemmDWgsAmG2rMphr/24fJlf7irh430uKI5VWU/50AjRQHUfdGFLmXaQcWCLPZuRj+YR8s18qy0eXEakDv4ksJCvyDNjzLKMk5to3RJXXiqQx6DdAwmAjLaful3qI2/1NxUlbNdSQnpKsshjdUBkgF8yU5FD8n+pc1ZDbO5ACRIkc1C6y1G1h4C/j3myiLnDn13TUomprAXEcLpGAS1dBvu8s4vYTtNZ2cmDKGelszbfdd1zpHUMXn4H8ujUpHz/g==",
            "TransactionStatusQuery",
            "AG_20181231_00007945e7ed4426d8ce",
            "600540",
            "4",
            "".site_url()."test/callback1" ,
            "".base_url("test/callback1")."",
            "Status",
            ""
        ));
    }

    public function callback1(){
        $callbackJSONData = $this->mpesa->getDataFromCallback();
        $file = 'mpesa_callback_log.txt'; //Please make sure that this file exists and is writable
        if (file_exists($file)) {
            $fh = fopen($file, 'a');
        } else {
            $fh = fopen($file, 'w');
        }
        fwrite($fh, "\n====".date("d-m-Y H:i:s")."====\n");
        fwrite($fh, json_encode($callbackJSONData)."\n");
//        fwrite($fh, json_encode($callbackJSONData->Body->stkCallback->MerchantRequestID)."\n");
//        fwrite($fh, json_encode($callbackJSONData->Body->stkCallback->CallbackMetadata->Item[0])."\n");
//        fwrite($fh, json_encode($callbackJSONData->Body->stkCallback->CallbackMetadata->Item[1])."\n");
//        fwrite($fh, json_encode($callbackJSONData->Body->stkCallback->CallbackMetadata->Item[2])."\n");
//        fwrite($fh, json_encode($callbackJSONData->Body->stkCallback->CallbackMetadata->Item[3])."\n");
//        fwrite($fh, json_encode($callbackJSONData->Body->stkCallback->CallbackMetadata->Item[4])."\n");
//        fwrite($fh, json_encode($callbackJSONData->Body->stkCallback->CallbackMetadata->Item[4]->Value)."\n");
        fclose($fh);
        $where = array(
            'MerchantRequestID' => $callbackJSONData->Body->stkCallback->MerchantRequestID,
            'CheckoutRequestID' => $callbackJSONData->Body->stkCallback->CheckoutRequestID,
        );
        $data = array(
            'ReceiptNumber'=>$callbackJSONData->Body->stkCallback->CallbackMetadata->Item[1]->Value,
            'TransactionDate'=>$callbackJSONData->Body->stkCallback->CallbackMetadata->Item[3]->Value,
            'PhoneNumber'=>$callbackJSONData->Body->stkCallback->CallbackMetadata->Item[4]->Value
        );
        $table = 'transaction';
        $this->RequestModel->update($where, $data,$table);

    }
    public function checkbalance(){
        echo json_encode($this->mpesa->accountBalance(
            "AccountBalance",
            "testapi",
            "ostZrScl5W4+5bU7mHacuWrlWUPcwvkxoxJtLPrzmEcEETw0bFLp8jZxB8Xhj6V+hem5oV+8ZlFGWQR/9Co94qemmDWgsAmG2rMphr/24fJlf7irh430uKI5VWU/50AjRQHUfdGFLmXaQcWCLPZuRj+YR8s18qy0eXEakDv4ksJCvyDNjzLKMk5to3RJXXiqQx6DdAwmAjLaful3qI2/1NxUlbNdSQnpKsshjdUBkgF8yU5FD8n+pc1ZDbO5ACRIkc1C6y1G1h4C/j3myiLnDn13TUomprAXEcLpGAS1dBvu8s4vYTtNZ2cmDKGelszbfdd1zpHUMXn4H8ujUpHz/g==",
            "600540",
            "4",
            "Checking Balance",
            "".base_url("test/callback1")."",
            "".base_url("test/callback1").""
            ));
    }
}
