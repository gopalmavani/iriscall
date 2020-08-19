<?php

class DocumentationController extends CController
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return UserIdentity::accessRules();
    }

    public function actionUserApi(){
        $this->pageTitle = 'User API Documentation';
        $this->render('userApi', array(
            'UserAddArray' => $this->UserApiAdd(),
            'UserUpdateArray' => $this->UserApiUpdate(),
            'UserViewRequest' => $this->UserApiViewRequest(),
            'UserSingle' => $this->UserApiViewSingle(),
            'UserAddResponnse' => $this->AddSuccessUnsuccess(),
            'UserUpdateResponnse' => $this->UpdateSuccessUnsuccess(),
            'UserDeleteResponnse' => $this->DeleteSuccessUnsuccess(),
        ));
    }

    protected function UserApiAdd()
    {
        $new_user_data = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 1 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'user')")
            ->queryall();

        $user_data = [
            "first_name" => "Deepak",
            "last_name" => "Visani",
            "email" => "deepakvisani@gmail.com",
            "password" => "admin123",
            "date_of_birth" => "06-09-1990",
            "gender" => "1",
            "passport_no" => "123456",
            "sponsor_id" => "321654",
            "is_enabled" => "1",
            "is_active" => "1",
            "business_name" => "Business",
            "vat_number" => "123456",
            "busAddress_building_num" => "g-106",
            "busAddress_street" => "Anand Nagar",
            "busAddress_region" => "VejalPur",
            "busAddress_city" => "Ahmedabad",
            "busAddress_postcode" => "380059",
            "busAddress_country" => "India",
            "business_phone" => "123456789",
            "building_num" => "321",
            "street" => "Anandnagar Road",
            "region" => "Vejal pur ",
            "city" => "Ahmedabad",
            "postcode" => "380059",
            "country" => "India",
            "phone" => "789456123",
            "is_delete" => "0"
        ];
        foreach ($new_user_data as $new_user) {
            $field_key = $new_user['field_name'];
            $user_data[$field_key] = "Null";
        }
        return $user_data;
    }

    protected function UserApiUpdate()
    {

        $new_user_data = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 1 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'user')")
            ->queryall();

        $update_data = [

            "first_name" => "Deepak",
            "last_name" => "Visani",
            "email" => "deepakvisani@gmail.com",
            "password" => "admin123",
            "date_of_birth" => "06-09-1990",
            "gender" => "1",
            "passport_no" => "123456",
            "sponsor_id" => "321654",
            "is_enabled" => "1",
            "is_active" => "1",
            "business_name" => "Business",
            "vat_number" => "123456",
            "busAddress_building_num" => "g-106",
            "busAddress_street" => "Anand Nagar",
            "busAddress_region" => "VejalPur",
            "busAddress_city" => "Ahmedabad",
            "busAddress_postcode" => "380059",
            "busAddress_country" => "India",
            "business_phone" => "123456789",
            "building_num" => "321",
            "street" => "Anandnagar Road",
            "region" => "Vejal pur ",
            "city" => "Ahmedabad",
            "postcode" => "380059",
            "country" => "India",
            "phone" => "789456123",
            "is_delete" => "0"
        ];
        foreach ($new_user_data as $new_user) {
            $field_key = $new_user['field_name'];
            $update_data[$field_key] = "Null";
        }
        return $update_data;
    }

    protected function UserApiViewRequest()
    {

        $update_req_data =
            [
                "user_id" => "",
                "is_active" => "",
                "sponsor_id" => "",
                "start_date"  => "2017-02-08",
                "end_date"	=> "2017-02-08"
            ];

        return $update_req_data;
    }

    protected function UserApiViewSingle()
    {

        $ViewSingleUser = [
            "result" => true,
            "code" => 200,
            "message" => "Total 1 Records fetched",
            "data" => [
                [
                    "user_id" => 1,
                    "full_name" => "Super Admin",
                    "first_name" => "Super",
                    "last_name" => "Admin",
                    "email" => "admin@admin.com",
                    "password" => "admin@123",
                    "date_of_birth" => "1990-09-06 08:00:00",
                    "gender" => 1,
                    "passport_no" => "0",
                    "sponsor_id" => "0",
                    "is_enabled" => 1,
                    "is_active" => 1,
                    "created_at" => "2017-01-11 19:31:24",
                    "modified_at" => "2017-01-11 19:31:24",
                    "business_name" => "0",
                    "vat_number" => "0",
                    "busAddress_building_num" => "0",
                    "busAddress_street" => "0",
                    "busAddress_region" => "0",
                    "busAddress_city" => "0",
                    "busAddress_postcode" => 0,
                    "busAddress_country" => "0",
                    "business_phone" => "0",
                    "building_num" => 0,
                    "street" => "0",
                    "region" => "0",
                    "city" => "0",
                    "postcode" => 0,
                    "country" => "0",
                    "phone" => "987456123",
                    "is_delete" => 0,
                    "test" => "0"
                ]
            ]
        ];
        return $ViewSingleUser;
    }

    protected function AddSuccessUnsuccess()
    {
        $success =
            ["result" => true, "code" => 200, "message" => "saved successfully", "data" => []];
        $unsuccess =
            ["result" => false, "mesg" => "model could not save"];

        $UserAddResponse['success'] = $success;
        $UserAddResponse['unsuccess'] = $unsuccess;
        return $UserAddResponse;
    }

    protected function UpdateSuccessUnsuccess()
    {
        $success =
            ["result" => true, "code" => 200, "message" => "Saved successfully", "data" => ["user_id" => 1]];
        $unsuccess =
            ["result" => false, "code" => 404, "message" => "The requested page does not exist.", "data" => []];

        $UserUpdateResponse['success'] = $success;
        $UserUpdateResponse['unsuccess'] = $unsuccess;
        return $UserUpdateResponse;
    }

    protected function DeleteSuccessUnsuccess()
    {
        $success =
            ["result" => true, "code" => 200, "message" => "Successfully deleted", "data" => ["user_id" => "1"]];
        $unsuccess =
            ["result" => false, "code" => 404, "message" => "The requested page does not exist.", "data" => []];

        $UserDeleteResponse['success'] = $success;
        $UserDeleteResponse['unsuccess'] = $unsuccess;
        return $UserDeleteResponse;
    }


    public function actionProductApi(){
        $this->pageTitle = 'Product API Documentation';
        $this->render('productApi', array(
            'ProductAddArray' => $this->ProductApiAdd(),
            'ProductUpdateArray' => $this->ProductApiUpdate(),
            'ProductViewAll' => $this->ProductApiViewAll(),
            'ProductSingle' => $this->ProductApiViewSingle(),
            'ProductAddResponnse' => $this->AddSuccessUnsuccess(),
            'ProductUpdateResponnse' => $this->UpdateSuccessUnsuccess(),
            'ProductDeleteResponnse' => $this->DeleteSuccessUnsuccess(),

            'userLicense_add' => $this->UserLicenseAdd(),
            'userLicense_update' => $this->UserLicenseUpdate(),
            'userLicense_viewall' => $this->UserLicenseViewAll(),
            'userLicense_viewsingle' => $this->UserLicenseViewSingle(),
        ));
    }

    protected function ProductApiAdd()
    {

        $new_custom_field = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 9 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'product')")
            ->queryall();

        $productLicense_add = [
            "purchase_product_id" => "1",
            "purchase_product_sku" => "sku-1",
            "product_id" => "001",
            "license_no" => "123456"
        ];

        foreach ($new_custom_field as $new_field) {
            $field_key = $new_field['field_name'];
            $productLicense_add[$field_key] = "Null";
        }

        return $productLicense_add;
    }

    protected function ProductApiUpdate()
    {
        $new_custom_field = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 9 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'product')")
            ->queryall();

        $productLicenseUpdate_data = [
            "purchase_product_id" => "1",
            "purchase_product_sku" => "sku-1",
            "product_id" => "001",
            "license_no" => "654321"
        ];

        foreach ($new_custom_field as $new_field) {
            $field_key = $new_field['field_name'];
            $productLicenseUpdate_data [$field_key] = "Null";
        }

        return $productLicenseUpdate_data;
    }

    protected function ProductApiViewAll()
    {
        $productLicense_viewall =

            [
                "result" => true,
                "code" => 200,
                "message" => "All licenses fetched",
                "data" => [
                    [
                        "id" => 2,
                        "purchase_product_sku" => "sku-3",
                        "product_id" => 4,
                        "license_no" => 654,
                        "created_at" => "2016-12-30 07:49:10",
                        "modified_at" => "2016-12-30 07:49:10"
                    ],
                    [
                        "id" => 3,
                        "purchase_product_sku" => "sku-5",
                        "product_id" => 5,
                        "license_no" => 654,
                        "created_at" => "2016-12-30 07:50:23",
                        "modified_at" => "2016-12-30 07:50:23"
                    ],
                ]


            ];

        return $productLicense_viewall;
    }

    protected function ProductApiViewSingle()
    {
        $productLicense_viewsingle =
            [

                "result" => true,
                "code" => 200,
                "message" => "License id number 2 data fetched",
                "data" => [
                    "id" => 2,
                    "purchase_product_sku" => "sku-3",
                    "product_id" => 4,
                    "license_no" => 654,
                    "created_at" => "2016-12-30 07:49:10",
                    "modified_at" => "2016-12-30 07:49:10"
                ]

            ];

        return $productLicense_viewsingle;
    }

    protected function ProductInfoAdd()
    {

        $productInfo_add = [
            "sku" => "sku-3",
            "name" => "pro",
            "price" => "46.00",
            "description" => "this is desc",
            "is_active" => "0",
            "image" => "path/to/image"

        ];

        return $productInfo_add;
    }

    protected function ProductInfoUpdate()
    {

        $productUpdate_data = [
            "sku" => "sku-3",
            "name" => "pro",
            "price" => "46.00",
            "description" => "this is desc",
            "is_active" => "0",
            "image" => "path/to/image"
        ];

        return $productUpdate_data;
    }

    protected function ProductInfoViewAll()
    {

        $productInfo_viewall =

            [
                "result" => true,
                "code" => 200,
                "message" => "products fetched",
                "data" => [
                    [
                        "product_id" => 1,
                        "sku" => "sku-1",
                        "name" => "pro5",
                        "price" => "76",
                        "description" => "this is desc",
                        "is_active" => 0,
                        "image" => "path/to/image",
                        "created_at" => "2016-12-30 07:33:43",
                        "modified_at" => "2016-12-30 07:33:43",
                        "is_delete" => 1
                    ],
                    [
                        "product_id" => 2,
                        "sku" => "2",
                        "name" => "pro2",
                        "price" => "57",
                        "description" => "this is desc",
                        "is_active" => 1,
                        "image" => "path/to/image",
                        "created_at" => "2016-12-30 07:29:15",
                        "modified_at" => "2016-12-30 07:29:15",
                        "is_delete" => 1
                    ]
                ]
            ];

        return $productInfo_viewall;
    }

    protected function ProductInfoViewSingle()
    {

        $productInfo_viewsingle = [

            "result" => true,
            "code" => 200,
            "message" => "products fetched",
            "data" => [
                "product_id" => 1,
                "sku" => "sku-1",
                "name" => "pro5",
                "price" => "76",
                "description" => "this is desc",
                "is_active" => 0,
                "image" => "path/to/image",
                "created_at" => "2016-12-30 07:33:43",
                "modified_at" => "2016-12-30 07:33:43",
                "is_delete" => 1
            ]


        ];

        return $productInfo_viewsingle;
    }

    protected function UserLicenseAdd()
    {
        $app = Yii::app()->params['applicationName'];
        $table = Yii::app()->db->createCommand()
            ->select('table_for_userlicense')
            ->from('sys_settings')
            ->where("app_name = '$app'")
            ->queryRow();
        $chk = $table['table_for_userlicense'];

        if ($chk == 1) {

            $new_custom_field = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cyl_fields')
                ->where("table_id = 10 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'product')")
                ->queryall();

            $userLicense_data = [
                "user_id" => "4",
                "sku" => "slu_1",
                "total_licenses" => "8",
                "product_id" => "1"
            ];
            foreach ($new_custom_field as $new_field) {
                $field_key = $new_field['field_name'];
                $userLicense_data[$field_key] = "Null";
            }
        } else {
            $new_custom_field = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cyl_fields')
                ->where("table_id = 11 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'product')")
                ->queryall();

            $userLicense_data = [
                "license_no" => "4",
                "product_id" => "1",
                "user_id" => "1",
                "is_used" => "4"
            ];

            foreach ($new_custom_field as $new_field) {
                $field_key = $new_field['field_name'];
                $userLicense_data[$field_key] = "Null";
            }
        }

        return $userLicense_data;
    }

    protected function UserLicenseUpdate()
    {
        $app = Yii::app()->params['applicationName'];
        $table = Yii::app()->db->createCommand()
            ->select('table_for_userlicense')
            ->from('sys_settings')
            ->where("app_name = '$app'")
            ->queryRow();
        $chk = $table['table_for_userlicense'];
        //print_r($chk); die;
        if ($chk == 1) {
            $new_custom_field = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cyl_fields')
                ->where("table_id = 10 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'product')")
                ->queryall();

            $userLicense_update_data = [
                "user_id" => "4",
                "sku" => "slu_1",
                "total_licenses" => "8",
                "product_id" => "1"
            ];

            foreach ($new_custom_field as $new_field) {
                $field_key = $new_field['field_name'];
                $userLicense_update_data[$field_key] = "Null";
            }

        } else {
            $new_custom_field = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cyl_fields')
                ->where("table_id = 11 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'product')")
                ->queryall();

            $userLicense_update_data = [
                "license_no" => "4",
                "product_id" => "1",
                "user_id" => "1",
                "is_used" => "4"

            ];
            foreach ($new_custom_field as $new_field) {
                $field_key = $new_field['field_name'];
                $userLicense_update_data[$field_key] = "Null";
            }
        }

        return $userLicense_update_data;
    }

    protected function UserLicenseViewAll()
    {
        $app = Yii::app()->params['applicationName'];
        $table = Yii::app()->db->createCommand()
            ->select('table_for_userlicense')
            ->from('sys_settings')
            ->where("app_name = '$app'")
            ->queryRow();
        $chk = $table['table_for_userlicense'];
        //print_r($chk); die;
        if ($chk == 1) {
            $userLicense_view_data =

                [
                    "result" => true,
                    "code" => 200,
                    "message" => "All license fetched",
                    "data" => [
                        [
                            "license_id" => 1,
                            "user_id" => 1,
                            "total_licenses" => 18,
                            "available_licenses" => 18,
                            "product_id" => 3,
                            "created_at" => "2017-01-03 04:38:52",
                            "modified_at" => "2017-01-03 04:38:52"
                        ],
                        [
                            "license_id" => 2,
                            "user_id" => 2,
                            "total_licenses" => 18,
                            "available_licenses" => 18,
                            "product_id" => 3,
                            "created_at" => "2017-01-03 04:38:52",
                            "modified_at" => "2017-01-03 04:38:52"
                        ]
                    ]
                ];

        } else {
            $userLicense_view_data =

                [
                    "result" => true,
                    "code" => 200,
                    "message" => "All license fetched",
                    "data" => [
                        [
                            "license_id" => 1,
                            "license_no" => 4,
                            "product_id" => 1,
                            "user_id" => 1,
                            "is_used" => 4,
                            "funded_on" => "2017-01-03 04:44:26",
                            "created_at" => "2017-01-03 04:44:26",
                            "is_delete" => 1
                        ],
                        [
                            "license_id" => 2,
                            "license_no" => 4,
                            "product_id" => 2,
                            "user_id" => 2,
                            "is_used" => 4,
                            "funded_on" => "2017-01-03 04:44:26",
                            "created_at" => "2017-01-03 04:44:26",
                            "is_delete" => 1
                        ]
                    ]
                ];
        }
        return $userLicense_view_data;
    }

    protected function UserLicenseViewSingle()
    {
        $app = Yii::app()->params['applicationName'];
        $table = Yii::app()->db->createCommand()
            ->select('table_for_userlicense')
            ->from('sys_settings')
            ->where("app_name = '$app'")
            ->queryRow();
        $chk = $table['table_for_userlicense'];
        //print_r($chk); die;
        if ($chk == 1) {

            $userLicense_view_data =
                [
                    "result" => true,
                    "code" => 200,
                    "message" => "users id number 10 data fetched",
                    "data" => [
                        "license_id" => 10,
                        "user_id" => 2,
                        "total_licenses" => 18,
                        "available_licenses" => 18,
                        "product_id" => 3,
                        "created_at" => "2017-01-03 04:38:52",
                        "modified_at" => "2017-01-03 04:38:52",
                        "product" => []
                    ]
                ];
        } else {
            $userLicense_view_data =
                [
                    "result" => true,
                    "code" => 200,
                    "message" => "License id number 2 data fetched",
                    "data" => [
                        "license_id" => 2,
                        "license_no" => 4,
                        "product_id" => 1,
                        "user_id" => 1,
                        "is_used" => 4,
                        "funded_on" => "2017-01-03 04:44:26",
                        "created_at" => "2017-01-03 04:44:26",
                        "is_delete" => 1
                    ]
                ];
        }
        return $userLicense_view_data;
    }

    public function actionOrderApi(){
        $this->pageTitle = 'Order API Documentation';
        $this->render('orderApi', array(
            'OrderAddArray' => $this->OrderApiAdd(),
            'OrderUpdateArray' => $this->OrderApiUpdate(),
            'OrderViewRequest' => $this->OrderApiViewRequest(),
            'OrderSingle' => $this->OrderApiViewSingle(),
            'OrderAddResponnse' => $this->AddSuccessUnsuccess(),
            'OrderUpdateResponnse' => $this->UpdateSuccessUnsuccess(),
            'OrderDeleteResponnse' => $this->DeleteSuccessUnsuccess(),
            'CartAddArray' => $this->CartApiAdd(),
            'CartViewAll' => $this->CartApiViewAll(),
            'CartSingle' => $this->CartApiViewSingle(),
            'MemoAddArray' => $this->MemoApiAdd(),
            'MemoUpdateArray'=> $this->MemoApiUpdate(),
            'MemoViewallArray'=> $this->MemoApiViewAll(),
            'MemoViewsingleArray'=> $this->MemoApiViewSingle(),
        ));
    }

    protected function OrderApiAdd()
    {
        $orderdata = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 12 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'order')")
            ->queryall();

        $orderLineItem = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 13 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'order')")
            ->queryall();

        $orderPayment = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 15 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'order')")
            ->queryall();

        $order_data =
            [
                "order_arr" =>
                    [
                        "order_id" => "3",
                        "user_id" => "1",
                        "vat" => "1%",
                        "vat_number" => "vat_123",
                        "company" => "scrumwheel",
                        "order_status" => "0",
                        "building" => "g-106",
                        "street" => "anand nagar",
                        "city" => "ahmedabad",
                        "region" => "gujrat",
                        "country" => "india",
                        "postcode" => "380051",
                        "orderTotal" => "10000",
                        "discount" => "15%",
                        "netTotal" => "8500",
                        "invoice_number" => "#3"
                    ],
                "order_line_item" =>
                    [
                        "product_id" => "1",
                        "vat" => "12%",
                        "item_qty" => "vat_123",
                        "item_disc" => "scrumwheel",
                        "item_price" => "0"
                    ],

                "order_payment" =>
                    [
                        "total" => "8500",
                        "payment_mode" => "netteler",
                        "payment_ref_id" => "ref_01",
                        "payment_status" => "1"
                    ]
            ];

        foreach ($orderdata as $neworder) {
            $field_key = $neworder['field_name'];
            $order_data['order_arr'][$field_key] = "Null";
        }
        foreach ($orderLineItem as $newItem) {
            $field_key = $newItem['field_name'];
            $order_data['order_line_item'][$field_key] = "Null";
        }
        foreach ($orderPayment as $newpayment) {
            $field_key = $newpayment['field_name'];
            $order_data['order_payment'][$field_key] = "Null";
        }
        return $order_data;
    }

    protected function OrderApiUpdate()
    {
        $orderdata = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 12 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'order')")
            ->queryall();

        $orderLineItem = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 13 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'order')")
            ->queryall();

        $orderPayment = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 14 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'order')")
            ->queryall();

        $order_update_data =
            [
                "order_arr" =>
                    [
                        "order_id" => "3",
                        "user_id" => "1",
                        "vat" => "1%",
                        "vat_number" => "vat_123",
                        "company" => "scrumwheel",
                        "order_status" => "0",
                        "building" => "g-106",
                        "street" => "anand nagar",
                        "city" => "ahmedabad",
                        "region" => "gujrat",
                        "country" => "india",
                        "postcode" => "380051",
                        "orderTotal" => "10000",
                        "discount" => "15%",
                        "netTotal" => "8500",
                        "invoice_number" => "#3"
                    ],
                "order_line_item" =>
                    [
                        "product_id" => "1",
                        "vat" => "12%",
                        "item_qty" => "vat_123",
                        "item_disc" => "scrumwheel",
                        "item_price" => "0"
                    ],

                "order_payment" =>
                    [
                        "total" => "8500",
                        "payment_mode" => "netteler",
                        "payment_ref_id" => "ref_01",
                        "payment_status" => "1"
                    ]
            ];

        foreach ($orderdata as $neworder) {
            $field_key = $neworder['field_name'];
            $order_update_data['order_arr'][$field_key] = "Null";
        }
        foreach ($orderLineItem as $newItem) {
            $field_key = $newItem['field_name'];
            $order_update_data['order_line_item'][$field_key] = "Null";
        }
        foreach ($orderPayment as $newpayment) {
            $field_key = $newpayment['field_name'];
            $order_update_data['order_payment'][$field_key] = "Null";
        }
        return $order_update_data;
    }

    protected function OrderApiViewRequest()
    {

        $update_view_data =
            [
                "user_id" =>  "",
                "order_id" => "",
                "start_date"  => "2017-02-08",
                "end_date"	=> "2017-02-08"
            ];

        return $update_view_data;
    }

    protected function OrderApiViewSingle()
    {
        $ViewSingleOrder = [
            [
                "result" => true,
                "code" => 200,
                "message" => "orders fetched",
                "data" =>
                    [
                        [
                            "order_info_id" => 1,
                            "order_id" => 1,
                            "user_id" => 1,
                            "vat" => "1%",
                            "vat_number" => "vat_123",
                            "company" => "scrumwheel",
                            "order_status" => 0,
                            "building" => "g-106",
                            "street" => "anand nagar",
                            "city" => "ahmedabad",
                            "region" => "gujrat",
                            "country" => "india",
                            "postcode" => 380051,
                            "orderTotal" => 10000,
                            "discount" => "15%",
                            "netTotal" => "8500",
                            "invoice_number" => "#11",
                            "invoice_date" => "2017-01-04 12:24:25",
                            "created_date" => "2017-01-04 12:24:25",
                            "modified_date" => "2017-01-04 12:24:25"
                        ]
                    ]
            ]
        ];
        return $ViewSingleOrder;
    }

    protected function CartApiAdd()
    {
        $cartdata = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 14 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'order')")
            ->queryall();

        $cart_data =
            [
                "user_id" => "1",
                "product_id" => "2",
                "item_qty" => "1"
            ];

        foreach ($cartdata as $cartField) {
            $field_key = $cartField['field_name'];
            $cart_data[$field_key] = "Null";
        }
        return $cart_data;
    }

    protected function CartApiViewAll()
    {

        $update_view_data =
            [
                "result" => true,
                "code" => 200,
                "message" => "cart item fetched",
                "data" => [
                    [
                        "cart_id" => 1,
                        "user_id" => 2,
                        "product_id" => 1,
                        "item_qty" => "2",
                        "created_at" => "2017-01-04 01:19:19",
                        "modified_at" => "2017-01-04 01:19:19"
                    ],
                    [
                        "cart_id" => 2,
                        "user_id" => 3,
                        "product_id" => 1,
                        "item_qty" => "2",
                        "created_at" => "2017-01-04 01:19:19",
                        "modified_at" => "2017-01-04 01:19:19"
                    ],
                    [
                        "cart_id" => 3,
                        "user_id" => 4,
                        "product_id" => 1,
                        "item_qty" => "2",
                        "created_at" => "2017-01-04 01:19:19",
                        "modified_at" => "2017-01-04 01:19:19"
                    ]
                ]
            ];

        return $update_view_data;
    }

    protected function CartApiViewSingle()
    {
        $ViewSingleOrder = [
            "result" => true,
            "code" => 200,
            "message" => "cart item fetched",
            "data" => [
                [
                    "cart_id" => 1,
                    "user_id" => 2,
                    "product_id" => 1,
                    "item_qty" => "2",
                    "created_at" => "2017-01-04 01:19:19",
                    "modified_at" => "2017-01-04 01:19:19"
                ]
            ]
        ];
        return $ViewSingleOrder;
    }

    protected function MemoApiAdd(){

        $orderdata = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 16 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'order')")
            ->queryall();

        $order_data =
            [
                "order_info_id" => "30",
                "product_id" => "1",
                "qty_refunded" => "1",
                "amount_to_refund" => "250",
                "invoice_number" => "#1",
                "memo_status" => "0"
            ];

        foreach ($orderdata as $neworder) {
            $field_key = $neworder['field_name'];
            $order_data[$field_key] = "Null";
        }
        return $order_data;

    }


    protected function MemoApiUpdate(){

        $orderdata = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 16 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'order')")
            ->queryall();

        $order_data =
            [
                "order_info_id" => "30",
                "product_id" => "1",
                "qty_refunded" => "1",
                "amount_to_refund" => "250",
                "invoice_number" => "#1",
                "memo_status" => "0"
            ];

        foreach ($orderdata as $neworder) {
            $field_key = $neworder['field_name'];
            $order_data[$field_key] = "Null";
        }
        return $order_data;

    }

    protected function MemoApiViewAll()
    {

        $memo_view_data =
            [
                "result" => true,
                "code" => 200,
                "message" => "credit memo fetched",
                "data" => [
                    [
                        "credit_memo_id" => 1,
                        "order_info_id" => 1,
                        "product_id" => 1,
                        "qty_refunded" => 1,
                        "amount_to_refund" => 250,
                        "invoice_number" => "#1",
                        "memo_status" => 0,
                        "created_at" => "2017-01-04 05:11:01",
                        "modified_at" => "2017-01-04 05:11:01"
                    ],
                    [
                        "credit_memo_id" => 2,
                        "order_info_id" => 2,
                        "product_id" => 2,
                        "qty_refunded" => 3,
                        "amount_to_refund" => 250,
                        "invoice_number" => "#2",
                        "memo_status" => 0,
                        "created_at" => "2017-01-04 05:11:01",
                        "modified_at" => "2017-01-04 05:11:01"
                    ],
                    [
                        "credit_memo_id" => 3,
                        "order_info_id" => 3,
                        "product_id" => 2,
                        "qty_refunded" => 4,
                        "amount_to_refund" => 250,
                        "invoice_number" => "#3",
                        "memo_status" => 0,
                        "created_at" => "2017-01-04 05:11:01",
                        "modified_at" => "2017-01-04 05:11:01"
                    ]
                ]
            ];

        return $memo_view_data;
    }

    protected function MemoApiViewSingle()
    {

        $memo_view_data =
            [
                "result" => true,
                "code" => 200,
                "message" => "credit memo fetched",
                "data" => [
                    [
                        "credit_memo_id" => 1,
                        "order_info_id" => 1,
                        "product_id" => 1,
                        "qty_refunded" => 1,
                        "amount_to_refund" => 250,
                        "invoice_number" => "#1",
                        "memo_status" => 0,
                        "created_at" => "2017-01-04 05:11:01",
                        "modified_at" => "2017-01-04 05:11:01"
                    ]
                ]
            ];

        return $memo_view_data;
    }

    protected function WalletApiAdd()
    {
        $this->pageTitle = 'Wallet API Documentation';
        $new_wallet_column = Yii::app()->db->createCommand()
            ->select('*')
            ->from('cyl_fields')
            ->where("table_id = 22 AND is_custom = 1 AND table_id IN (select table_id from cyl_tables where module_name = 'wallet')")
            ->queryall();

        $wallet_data = [
            "user_id" =>  "2",
            "wallet_type_id" =>  "2",
            "transaction_type" =>  "debit",
            "reference_id" =>  "3",
            "reference_num" =>  "#order-001",
            "transaction_comment" =>  "amount debited for #order transaction",
            "denomination_id" =>  "2",
            "transaction_status" =>  "1",
            "portal_id" =>  "2",
            "amount" =>  "4500"
        ];
        foreach ($new_wallet_column as $new_wallet) {
            $field_key = $new_wallet['field_name'];
            $wallet_data[$field_key] = "Null";
        }
        return $wallet_data;
    }

    protected function WalletApiViewPortals()
    {

        $wallet_view =
            [
                "result" => true,
                "code" => 200,
                "message" => "Portal name fetched",
                "data" => [
                    "1" => "IrisCall",
                    "2" => "CherryFile",
                    "3" => "MMC",
                    "4" => "Tradeland"
                ]
            ];

        return $wallet_view;
    }

    protected function WalletApiWalletType()
    {

        $WalletType = [
            "result" => true,
            "code" => 200,
            "message" => "Wallet type fetched",
            "data" => [
                "1" => "USER-WALLET",
                "2" => "FAN-WALLET"
            ]
        ];
        return $WalletType;
    }

    protected function getDenominationType()
    {

        $WalletType = [
            "result" => true,
            "code" => 200,
            "message" => "Wallet type fetched",
            "data" => [
                "1" => "USER-WALLET",
                "2" => "FAN-WALLET"
            ]
        ];
        return $WalletType;
    }

    protected function getCurrencyTypes()
    {

        $CurrencyType = [
            "result" => true,
            "code" => 200,
            "message" => "Currency type fetched",
            "data" => [
                "1" => "USD",
                "2" => "EURO",
                "3" => "GBP",
                "4" => "INR"
            ]
        ];
        return $CurrencyType;
    }

    protected function ViewWallet(){
        $view_reuqest = [
            "portal_id" => "",
            "wallet_type_id" => "",
            "denomination_id" => "5",
            "transaction_type" => "credit",
            "start_date"  => "2017-02-08",
            "end_date"	=> "2017-02-08"
        ];

        return $view_reuqest;
    }

    protected function ViewWalletResponse(){
        $success = [
            "result" => true,
            "code" => 200,
            "message" => "Total 3 Transactin of users id 2 fetched",
            "data" => [
                [
                    "wallet_id" => 38,
                    "user_id" => 2,
                    "wallet_type_id" => 2,
                    "transaction_type" => "credit",
                    "reference_id" => 3,
                    "reference_num" => "#order-001",
                    "transaction_comment" => "amount debited for #order transaction",
                    "denomination_id" => 5,
                    "transaction_status" => 1,
                    "portal_id" => 2,
                    "amount" => "1800",
                    "updated_balance" => "1800",
                    "created_at" => "2017-01-04 00:00:00",
                    "modified_at" => null
                ],
                [
                    "wallet_id" => 39,
                    "user_id" => 2,
                    "wallet_type_id" => 2,
                    "transaction_type" => "credit",
                    "reference_id" => 3,
                    "reference_num" => "#order-001",
                    "transaction_comment" => "amount debited for #order transaction",
                    "denomination_id" => 5,
                    "transaction_status" => 1,
                    "portal_id" => 2,
                    "amount" => "1800",
                    "updated_balance" => "1800",
                    "created_at" => "2017-01-09 00:00:00",
                    "modified_at" => null
                ],
                [
                    "wallet_id" => 41,
                    "user_id" => 2,
                    "wallet_type_id" => 2,
                    "transaction_type" => "credit",
                    "reference_id" => 3,
                    "reference_num" => "#order-001",
                    "transaction_comment" => "amount debited for #order transaction",
                    "denomination_id" => 5,
                    "transaction_status" => 1,
                    "portal_id" => 2,
                    "amount" => "1800",
                    "updated_balance" => "0",
                    "created_at" => "2017-01-16 00:00:00",
                    "modified_at" => null
                ]
            ]
        ];

        $unsuccess = [
            [
                "result" => false,
                "code" => 404,
                "message" => "The requested page does not exist.",
                "data" => []
            ]
        ];

        $WalletViewResponse['success'] = $success;
        $WalletViewResponse['unsuccess'] = $unsuccess;

        return $WalletViewResponse;
    }

    public function actionWalletApi(){
        $this->render('walletApi', array(
            'WalletAddArray' => $this->WalletApiAdd(),
            'WalletViewPortals' => $this->WalletApiViewPortals(),
            'WalletType' => $this->WalletApiWalletType(),
            'WalletAddResponnse' => $this->AddSuccessUnsuccess(),
            'GetDenomination' => $this->getDenominationType(),
            'GetCurrency' => $this->getCurrencyTypes(),
            'WalletView' => $this->ViewWallet(),
            'WalletResponse' => $this->ViewWalletResponse(),
        ));
    }
}