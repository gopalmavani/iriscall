<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Micromaxcash - Order Confirmation</title>
    <link rel="icon" type="image/png" href="<?= Yii::app()->getBaseUrl(true).'/images/logos/favicon.ico'?>" sizes="16x16" />
</head>
<body style="margin:0; padding:0;background-color:#ffffff;">
<style>
    table.table tr + tr td{border-top:5px solid #fff;}
</style>
<table style="width:740px; margin:0 auto;" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3" style="background:#fff url(<?= Yii::app()->getBaseUrl(true).'/images/bg-home.jpg'?>) no-repeat right;background-size:cover;padding:0;" align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="4%">&nbsp;</td>
                    <td align="center">
                        <a href="javascript:void()"  style="display:inline-block;">
                            <img src="<?= Yii::app()->getBaseUrl(true).'/images/logos/logo-8-inverse.png'; ?>" style="max-width: 100%; margin: 30px 0;"/>
                        </a>
                    </td>
                    <td width="4%">&nbsp;</td>
                </tr>
            </table>

        </td>
    </tr>

    <tr>
        <td width="4%"></td>
        <td align="center">

            <h1 style="font-size:32px; text-transform:uppercase; color:#005aa0; margin:30px 0 20px; font-family:open sans, arial; font-weight:bold;">Order Confirmation</h1>

            <p style="font-size:16px;color:#5e5e5f; line-height:30px;font-family:open sans, arial; margin:0 0 20px; ">Dear <?= $first_name; ?>,<br />
                All information about your order can be found in <a href="<?= $dashBoardURL; ?>"><span style="color:#d4537d;">your account.</span></a></p>

            <h2 style="font-size:24px; text-transform:uppercase; color:#5e5e5f; margin:0 0 20px; font-family:open sans, arial; font-weight:normal;">Your Invoice number: <strong style="color:#d4537d;"><?= $order->invoice_number; ?></strong></h2>

            <p style="font-size:16px;color:#5e5e5f;font-family:open sans, arial; margin:0 0 20px; ">Today, you've ordered:</p>

            <table width="100%" class="table" style="font-family:open sans, arial; color:#5e5e5f;" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th colspan="2" align="left" style="padding:16px; font-size:16px; color:#fff; font-weight:bold;" bgcolor="#0a5ba2">Item</th>
                    <th width="18%" align="right"  style="padding:16px; font-size:16px; color:#fff; font-weight:bold;" bgcolor="#0a5ba2">Price</th>
                    <th align="right" style="padding:16px; font-size:16px; color:#fff; font-weight:bold;" bgcolor="#0a5ba2">Qty</th>
                    <th  align="right" style="padding:16px; font-size:16px; color:#fff; font-weight:bold;" bgcolor="#0a5ba2">Total</th>
                </tr>

                <?php foreach ($orderItems as $item) { ?>
                    <tr>
                        <td width="50" style="padding:16px; border-bottom:1px solid #eaeef5;" bgcolor="#f9fafc"><img src="<?= $item['image'] ?>" style="max-width: 64px"/></td>
                        <td width="210" style="padding:16px; border-bottom:1px solid #eaeef5;" bgcolor="#f9fafc"><h2 style="color:#355b9e; font-size:20px; text-transform:uppercase;"><?= $item['name'] ?></h2></td>
                        <td align="right" style="padding:16px;  border-bottom:1px solid #eaeef5; font-size:16px;" bgcolor="#f9fafc">€ <?= $item['price'] ?></td>
                        <td align="right" style="padding:16px; border-bottom:1px solid #eaeef5; font-size:16px;" bgcolor="#f9fafc"><?= $item['quantity'] ?></td>
                        <td style="padding:16px; border-bottom:1px solid #eaeef5; font-size:16px;" bgcolor="#f9fafc" align="right"><strong>€ <?= $item['price'] * $item['quantity']; ?></strong></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td align="right" style="padding:8px 12px 0 0;font-size:16px;">Total excl. VAT</td>
                    <td>&nbsp;</td>
                    <td align="right" style="padding:8px 12px 0 0;font-size:16px;"><strong>€ <?= $order->orderTotal; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td align="right" style="padding:8px 12px 0 0;font-size:16px;">Discount</td>
                    <td>&nbsp;</td>
                    <td align="right" style="padding:8px 12px 0 0;font-size:16px;"><strong><?= $order->discount; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td align="right" style="padding:5px 12px 5px 0;font-size:16px;">BTW (<?= $order->vat_percentage; ?> %)</td>
                    <td>&nbsp;</td>
                    <td align="right" style="padding:5px 12px 5px 0;font-size:16px;"><strong>€ <?= $order->vat; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td colspan="3" style="padding:16px; border-bottom:1px solid #eaeef5;font-size:16px;" bgcolor="#f9fafc" align="right">
                        <strong>Total incl. VAT</strong>
                        <h1 style="color:#d4537d; margin:0; font-size:24px;">€ <?= $order->netTotal; ?></h1>
                    </td>
                </tr>
            </table>

            <table style="margin-top:30px;" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><div style="width:340px;float:left;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/misc/make-payment.jpg'?>"  style="margin:0 30px 30px 0; "/></div>
                        <div style="width:330px; float:left; text-align:left;">
                            <strong style="color:#5e5e5f; font-size:16px; margin:0 0 5px; display:block; font-family:open sans, arial; text-transform:uppercase;">Payment details</strong>
                            <?php foreach ($orderPayment as $payment) { ?>
                            <p style="color:#5e5e5f;font-size:15px; font-family:open sans, arial;  margin:0 0 16px; line-height:24px;">You have chosen to pay <?= $payment->total ?> via <?= $payment->transaction_mode; ?>.<br>
                            <?php } ?>
                            The order is carried out only after receiving the deposited amount.</p>

                            <!--<p style="color:#5e5e5f;font-size:15px; font-family:open sans, arial;  margin:0 0 16px; line-height:24px;">Within 14 days the bank transfer needs to be done and the payment needs to be on our account. If not, the order expires.</p>-->
                            <strong style="color:#5e5e5f; font-size:16px; font-family:open sans, arial; margin:0 0 5px;  text-transform:uppercase;">Billing Address</strong>
                            <p style="color:#5e5e5f;font-size:15px; font-family:open sans, arial;  margin:0 0 16px; line-height:24px;"><?= $full_name; ?><br />
                                <?= $order->building.', ',$order->street; ?><br />
                                <?= $order->city.'- '.$order->postcode ?><br />
                                <?= ServiceHelper::getCountryNameFromId($order->country); ?></p>
                        </div></td>
                </tr>
            </table>



            <div style="padding:4%; color:#5e5e5f;line-height:22px; text-align:left; border:1px solid #efefef;  font-size:14px; font-family:open sans, arial;">
                <strong style="text-transform:uppercase; margin:0;font-size:14px; display:block;">Cancel or change</strong>
                <p style="font-size:13px; margin:0 0 20px;">You can not change this order at this time because it is already in the order process.
                    Do you want to cancel? Please read refund policy.</p>

                <strong style="text-transform:uppercase; margin:0;font-size:14px; display:block;">Do you have any questions?</strong>
                <p style="font-size:13px; margin:0 0 20px;">Call or e-mail with our customer service. We are happy to help you.</p>

                <strong style="text-transform:uppercase; margin:0; font-size:14px;display:block;">Refund policy</strong>
                <p style="font-size:13px; margin:0 0 20px;">MMC offers automatic trading software licences for the forex market, in other words software, which means digital content on a non-material carrier.</p>
                <p style="font-size:13px; margin:0 0 20px;">Before the product acquisition, the customer has given his explicit and prior permission to confirm that the service implementation can start immediately and that the customer loses the right to ask for a refund once the service implementation has started.</p>
                <p style="font-size:13px; margin:0 0 20px;">If MMC didn’t receive a prior, explicit permission of the customer, the customer keeps his right to ask for a refund for 14 calendar days, counting from the order day, even if the customer got access to his digital acquisition.</p>

                <strong style="text-transform:uppercase; margin:0; font-size:14px;display:block;">Exceptional situations</strong>
                <p style="font-size:13px; margin:0 0 20px;">In the following exceptional situations, the product cannot be taken into service during the refund period:<br />
                    - When the client is refused by the broker<br />
                    - When the client does not fulfil a deposit of trading capital to the broker</p>

                <p style="font-size:13px; margin:0 0 20px;font-size:13px;">In these exceptional situations, the customer can dissolve the agreement of the leverage of this digital content - which is not provided on a material carrier - during 14 calendar days.<br />
                    Refunds are only possible when you live in the EU.<br />
                    Promotional and/or incentive product offers are non-refundable.</p>

                <strong style="text-transform:uppercase; margin:0;font-size:14px; display:block;">Execution of the right to ask for a refund by the customer</strong>
                <p style="font-size:13px; margin:0;">If the customer in above exceptional situations wishes to use his right to ask for a refund, he then reports it unambiguously within the refund period of 14 calendar days,  in an e-mail or by registered letter through this <a href="<?= Yii::app()->getBaseUrl(true).'/uploads/cbm-refund-request-form.pdf' ?>" download>refund document.</a></p>
            </div>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center"><h1 style="color:#355b9e; font-family:open sans, arial; font-size:24px; text-transform:uppercase; font-weight:normal;">Enjoy your purchase and see you next time!</h1></td>
                </tr>
                <tr>
                    <td bgcolor="#355b9e" style="padding:25px 30px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="60" align="left"><img src="<?= Yii::app()->getBaseUrl(true).'/images/misc/icon-support.png'?>"/></td>
                                <td ><p style="color:#fff; font-family:open sans, arial; line-height:24px; margin:0; font-size:16px;">If you have any further questions, please don't hesitate to contact our support desk at <a style="color:#d4537d; font-weight:bold; text-decoration:none;" href="mailto:support@micromaxcash.com">support@micromaxcash.com</a></p></td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
            <strong style="font-family:open sans, arial; margin:20px 0 50px;line-height:24px; display:block; color:#5e5e5f; font-size:16px; line-height:24px; ">Have a nice day,<br>
                Team Micromaxcash</strong>
        </td>
        <td width="4%"></td>
    </tr>


    <tr>
        <td width="4%"></td>
        <td align="center">
            <div class="bg-grey" style="padding:30px 5% 10px; background-color:#eeeeee; margin:0;">
                <div style="display:block; margin:0 0 10px;font-family:open sans, arial;">
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/misc/icon-fb.png'; ?>" /></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/misc/icon-twit.png'; ?>" /></a>
                </div>
                <p style="font-size:15px;color:#5e5e5f; margin:0 0 10px; font-family:open sans, arial;">Olenseweg 375<br />
                    2260 Westerlo<br />
                    Belgium</p>
                <p style="font-size:15px;color:#5e5e5f;margin:0 0 10px; font-family:open sans, arial;">Technical Inquiries or Support: <a style="color:#5e5e5f; text-decoration:none;" href="mailto:support@micromaxcash.com">support@micromaxcash.com</a><br />
                    Financial Inquiries: <a style="color:#5e5e5f; text-decoration:none;" href="mailto:mail@micromaxcash.com">mail@micromaxcash.com</a></p><br />
                    IBAN No. EURO: BE63 0689 0467 8308 Swift/BIC Code: GKCCBEBB
                </p>
                <a href="<?= Yii::app()->getBaseUrl(true) . '/Legal/terms-conditions.html'; ?>" target="_blank" style="color:#d4537d; font-family:open sans, arial; text-decoration:none; margin:15px 0 20px; font-size:16px; display:inline-block;"><i style="float:left; margin:2px 5px 0 0;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/misc/icon-pdf.png'; ?>"/></i> Download Terms and Conditions</a>
            </div>
        </td>
        <td width="4%"></td>

    <tr>
        <td width="4%"></td>
        <td align="center" bgcolor="#fff">
            <br /><small style="font-size:12px;color:#5e5e5f; font-family:open sans, arial;">This is an automatically generated email.<br />
                Please do not reply as your message will not be received and will be returned to you by the mail server.</small>
            <p style="font-size:13px;color:#5e5e5f; font-family:open sans, arial;">© <?php echo date('Y');?> Micromaxcash</p>
        </td>
        <td width="4%"></td>
    </tr>
</table>



</body>

</html>


