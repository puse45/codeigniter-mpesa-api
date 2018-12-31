<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('mpesa');
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
        echo json_encode($this->mpesa->STKPushSimulation(
            "174379",
            "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919",
            "CustomerPayBillOnline",
            "1",
            "254703703741",
            "174379",
            "254703703741",
            "http://c28ebe1d.ngrok.io/ci-mpesa/test/callback1",
            "ref",
            "please work",
            "test"
        ));
        echo json_encode($this->mpesa->getDataFromCallback());
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
            "http://c28ebe1d.ngrok.io/ci-mpesa/test/callback1" ,
            "http://c28ebe1d.ngrok.io/ci-mpesa/test/callback1",
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
            "http://c28ebe1d.ngrok.io/ci-mpesa/test/callback1" ,
            "http://c28ebe1d.ngrok.io/ci-mpesa/test/callback1",
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
            "http://c28ebe1d.ngrok.io/ci-mpesa/test/callback1" ,
            "http://c28ebe1d.ngrok.io/ci-mpesa/test/callback1",
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
//            chmod($file, 755);
        }
        fwrite($fh, "\n====".date("d-m-Y H:i:s")."====\n");
        fwrite($fh, $callbackJSONData."\n");
        fclose($fh);
    }
    public function checkbalance(){
        echo json_encode($this->mpesa->accountBalance(
            "AccountBalance",
            "testapi",
            "ostZrScl5W4+5bU7mHacuWrlWUPcwvkxoxJtLPrzmEcEETw0bFLp8jZxB8Xhj6V+hem5oV+8ZlFGWQR/9Co94qemmDWgsAmG2rMphr/24fJlf7irh430uKI5VWU/50AjRQHUfdGFLmXaQcWCLPZuRj+YR8s18qy0eXEakDv4ksJCvyDNjzLKMk5to3RJXXiqQx6DdAwmAjLaful3qI2/1NxUlbNdSQnpKsshjdUBkgF8yU5FD8n+pc1ZDbO5ACRIkc1C6y1G1h4C/j3myiLnDn13TUomprAXEcLpGAS1dBvu8s4vYTtNZ2cmDKGelszbfdd1zpHUMXn4H8ujUpHz/g==",
            "600540",
            "4",
            "Checking Balance",
            "http://c28ebe1d.ngrok.io/ci-mpesa/test/callback1" ,
            "http://c28ebe1d.ngrok.io/ci-mpesa/test/callback1"
            ));
    }
}
