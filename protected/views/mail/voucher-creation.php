<?php
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>CBM Global.IO - Voucher Confirmation</title>
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
                            <img src="<?= Yii::app()->getBaseUrl(true).'/images/CBM-Logo.png'; ?>" style="max-width: 100%; margin: 30px 0;"/>
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

            <h1 style="font-size:32px; text-transform:uppercase; color:#005aa0; margin:30px 0 20px; font-family:open sans, arial; font-weight:bold;">Your CBM Voucher has arrived!</h1>

            <p style="font-size:16px;color:#5e5e5f; line-height:30px;font-family:open sans, arial; margin:0 0 20px; ">Dear <?= $first_name; ?>,<br />
                We are sending you a voucher worth 127 CBM Cashback licenses. <br/>
                This voucher is valid for a period of 12 months and can only be redeemed via  <a href="<?= $dashBoardURL; ?>"><span style="color:#d4537d;">my.cbmglobal.io</span></a>
                </p>

            <div style="width=100%; background:#355b9e; color:#fff; line-height:24px; margin:0; font-size:16px; text-align: left; padding: 10px">
                <p>Name: <?= $full_name; ?></p>
                <p>Email: <?= $email; ?></p>
                <p>Voucher code: <?= $voucher_code; ?></p>
                <p>Voucher Validity: <?= $voucher_validity; ?></p>
            </div>
            <strong style="font-family:open sans, arial; margin:20px 0 50px;line-height:24px; display:block; color:#5e5e5f; font-size:16px; line-height:24px; ">Have a nice day,<br>
                Team CBM Global</strong>
        </td>
        <td width="4%"></td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td align="center">
            <div class="bg-grey" style="padding:30px 5% 10px; background-color:#eeeeee; margin:0;">
                <div style="display:block; margin:0 0 10px;font-family:open sans, arial;">
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/icon-fb.png'; ?>" /></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/icon-twit.png'; ?>" /></a>
                </div>
                <p style="font-size:15px;color:#5e5e5f; margin:0 0 10px; font-family:open sans, arial;">Olenseweg 375<br />
                    2260 Westerlo<br />
                    Belgium</p>
                <p style="font-size:15px;color:#5e5e5f;margin:0 0 5px; line-height:24px; font-family:open sans, arial;">Technical Inquiries or Support: <a style="color:#5e5e5f; text-decoration:none;" href="mailto:support@cbmglobal.io">support@cbmglobal.io</a><br />
                    Financial Inquiries: <a style="color:#5e5e5f; text-decoration:none;" href="mailto:accounting@cbmglobal.io">accounting@cbmglobal.io</a><br />
                    IBAN No. EURO: BE63 0689 0467 8308 Swift/BIC Code: GKCCBEBB
                </p>
                <a href="<?= Yii::app()->getBaseUrl(true) . '/Legal/terms-conditions.html'; ?>" target="_blank" style="color:#d4537d; font-family:open sans, arial; text-decoration:none; margin:15px 0 20px; font-size:16px; display:inline-block;"><i style="float:left; margin:2px 5px 0 0;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/icon-pdf.png'; ?>"/></i> Download Terms and Conditions</a>
            </div>
        </td>
        <td width="4%"></td>

    <tr>
        <td width="4%"></td>
        <td align="center" bgcolor="#fff">
            <br /><small style="font-size:12px;color:#5e5e5f; font-family:open sans, arial;">This is an automatically generated email.<br />
                Please do not reply as your message will not be received and will be returned to you by the mail server.</small>
            <p style="font-size:13px;color:#5e5e5f; font-family:open sans, arial;">© <?php echo date('Y');?> CBM Global</p>
        </td>
        <td width="4%"></td>
    </tr>
</table>



</body>

</html>


