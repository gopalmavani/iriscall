<?php

class DefaultController extends Controller
{
    public $layout = false;

    public function beforeAction($action)
    {
        //$this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /*
     * Preparing MMC Licence order for NetellerGo, This method accepts Post back only.
     */
    public function actionIndex()
    {
        header('Content-type: application/json');
        set_time_limit(700);


        $model = new OrderInfo();
        $orderItem = new OrderLineItem;
        $orderPayment = new OrderPayment;
        $request = Yii::app()->request->getRawBody();
        if ($request) {
            $result = CJSON::decode($request);

            $qty = $result['order']['order_line_item']['item_qty'];
            $vat = $result['order']['order_line_item']['vat'];
            $discount = $result['order']['order_arr']['discount'];
            $licenceFee = $result['order']['order_arr']['netTotal'];
            $payableAmount = $result['order']['order_arr']['netTotal'];
            $products = $result['order']['order_arr']['vat'];

            //$model->save(false);
            $reference = $model->order_info_id;
            $model->attributes = $result['order']['order_arr'];
            $orderItem->attributes = $result['order']['order_line_item'];
            $orderPayment->attributes = $result['order']['order_payment'];

            // getting access token from Neteller, refer document for more info
            $Access = $this->doNetellerAuth(Yii::app()->params['netellerAppId'], Yii::app()->params['netellerSecret']);    // Authorization API Call
            //print_r($Access); die;
            if ($Access && array_key_exists("accessToken", $Access)) { // if token recieved
                $orderArray = [
                    'order' => [
                        "merchantRefId" => (string)$reference,
                        "totalAmount" => intval($payableAmount * 100),
                        "currency" => "EUR",
                        "lang" => "en_US",
                        "items" => [
                            [
                                "quantity" => intval($qty),
                                "name" => "Licence Fee",
                                "description" => "Tradeland Licence fee",
                                "amount" => intval(($licenceFee / $qty) * 100)
                            ]
                        ],
                        "fees" => [
                            [
                                "feeName" => "Setup Fee",
                                "feeAmount" => 0
                            ]
                        ],
                        "discount" => [
                            [
                                "discountName" => "Discount",
                                "discountAmount" => $discount
                            ]
                        ],
                        "taxes" => [
                            [
                                "taxName" => "VAT",
                                "taxAmount" => intval((($licenceFee * $vat) / 100) * 100)
                            ]
                        ],
                        "redirects" => [
                            [
                                "rel" => "on_success",
                                "returnKeys" => ["id"],
                                "uri" => Yii::app()->getBaseUrl(true) . '/index.php/products/summary?payment=1&ref=' . $reference
                            ],
                            [
                                "rel" => "on_cancel",
                                "returnKeys" => ["id"],
                                "uri" => Yii::app()->getBaseUrl(true) . '/index.php/products/summary?payment=0&ref=' . $reference
                            ],
                        ]
                    ]
                ];

                // calling NetellerGo orders API
                $neteller = $this->executeNetellerCall(
                    "orders",
                    CJSON::encode($orderArray),
                    ['Authorization: ' . $Access['tokenType'] . ' ' . $Access['accessToken']]
                );
                if ($neteller && array_key_exists('links', $neteller)) {
                    $paymentRefId = $neteller['orderId'];
                    $url = '';
                    foreach ($neteller['links'] as $net) {
                        if ($net['rel'] == 'hosted_payment') {
                            $url = $net['url'];
                        }
                        if ($net['rel'] == 'self') {
                            $netellerOrderUrl = $net['url'];
                        }
                    }

                    $result = [
                        "result" => true,
                        "url" => $url
                    ];
                } else {
                    // error handler if API Fails
                    $result = [
                        "result" => false,
                        "error" => "Neteller Go api failed to response, Kindly try after sometime",
                        "description" => CJSON::encode($neteller)
                    ];
                }
            } else {
                // error handler if token not recieved
                $result = [
                    "result" => false,
                    "error" => "Token could not generated",
                    "description" => CJSON::encode($Access)
                ];
            }
        } else {
            // error handler if nothing posted
            $result = [
                "result" => false,
                "error" => "Invalid request",
                "description" => ""
            ];
        }

        if ($result['result'] == true) {
            $model = OrderInfo::model()->findByAttributes(['order_info_id' => $reference]);
            $model->netellerOrderUrl = $url;
            $model->paymentRefId = $paymentRefId;
            $model->netellerOrderUrl = $netellerOrderUrl;

        } else {
            $model = OrderInfo::model()->findByAttributes(['order_info_id' => $reference]);
            echo "failed"; die;
            $model->status = 0;
            $model->info = $result['error'];
            $model->save(false);
        }
        echo CJSON::encode($result);
    }

    protected function doNetellerPayment($amount, $net_account, $secure_id, $currency, $merch_transid, $language_code = "en", $custom_1 = "", $custom_2 = "", $custom_3 = "")
    {
        $Data = array(
            "paymentMethod" => array(
                "type" => "neteller",
                "value" => $net_account
            ),
            "transaction" => array(
                "merchantRefId" => "v1_" . $merch_transid,
                "amount" => $amount,
                "currency" => $currency
            ),
            "verificationCode" => $secure_id
        );

        $Access = $this->doNetellerAuth(Yii::app()->params['netellerAppId'], Yii::app()->params['netellerSecret']);    // Authorization API Call
        if ($Access && array_key_exists("accessToken", $Access)) {
            return $this->processNetellerResponse($this->executeNetellerCall("transferIn", json_encode($Data), array('Authorization: Bearer ' . $Access["accessToken"])));
        } else {
            return $this->processNetellerResponse($Access);
        }
    }

    protected function doNetellerAuth($client_id, $client_secret)
    {
        return $this->executeNetellerCall(
            "oauth2/token?grant_type=client_credentials",
            "",
            array('Authorization: Basic ' . base64_encode(sprintf("%s:%s", $client_id, $client_secret)))
        );
    }

    protected function processNetellerResponse($retData)
    {


        $message = array(
            'error' => 0,
            'error_message' => '',

            'trans_id' => 0,
            'client_amount' => 0
        );


        if ($retData) {
            if (array_key_exists("transaction", $retData) && array_key_exists('status', $retData["transaction"]) && $retData["transaction"]['status'] == 'accepted') {
                $message['trans_id'] = $retData["transaction"]['id'];
                $message['client_amount'] = $retData["transaction"]['amount'];
            } elseif (array_key_exists('error', $retData)) {
                $message['error'] = 1000002;
                //$message['error_message'] = $retData['error']['message'];
                $message['error_message'] = $retData['error'];
            } else {
                $message['error'] = 1000002;
                $message['error_message'] = "Internal error in processNetellerResponse";
            }
        } else {    // No response
            $message['error'] = 1000001;
            $message['error_message'] = "Curl internal error!";
        }

        return $message;
    }

    protected function executeNetellerCall($url = "", $data_string = "", $header_optional = array())
    {
        $ch = curl_init(Yii::app()->params['netellerURL'] . Yii::app()->params['netellerAPIversion'] . "/" . $url);


        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);    // Need in auth call?
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    // New - same as next?
        curl_setopt($ch, CURLOPT_POST, 0);

        if ($data_string) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        }

        $header = array(
            'Content-Type: application/json',
            'Cache-Control: no-cache'//,
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($header_optional, $header));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, true);
    }

}