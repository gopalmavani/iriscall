<?php
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Micromaxcash - Welcome to Micromaxcash</title>
    <link rel="icon" type="image/png" href="http://my.cbmglobal.io/images/favicon.png" sizes="16x16" />
</head>
<body style="margin:0; padding:0;background-color:#ffffff;">
<style>
    @media (max-width: 767px) {
        big {font-size:36px !Important;}
        .blue-content {margin:0 !important;}
        h2 {font-size:16px !Important; line-height:22px !important; margin-left:0 !Important; margin-right:0 !important;}
        .bg-grey{margin:0 !important;}
        h1 {font-size:24px !Important;margin:30px 0 !Important;}
        strong, p {font-size:14px !Important;}
    }
</style>

<table style="max-width:750px; margin:0 auto;" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3" style="background:#fff <?= Yii::app()->getBaseUrl(true).'/images/bg-home.jpg'; ?> no-repeat right;background-size:cover;padding:0;" align="center">
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
        <td align="center"><div style="padding:0 3%">

                <p style="font-size:16px;margin:0 0 10px; color:#5e5e5f;font-family:open sans, arial;">You told us you forgot your password.
                    If you really did, please choose a new one..</p>
                <div style="width: 300px; height: 30px;margin-bottom: 10px; background-color: #4ecdc4;border-color: #4c5764;border: 2px solid #45b7af;padding: 10px;text-align: center;">
                    <a style="display: block;color: #ffffff;font-size: 23px;text-decoration: none;" href="<?= $resetUrl; ?>" type="button">Choose a new Password</a>
                </div>

                <p style="font-size:16px;margin:0 0 10px; color:#5e5e5f;font-family:open sans, arial;">If you didn't mean to change your password, ignore this email.
                Your password will not change.</p>

                <strong style="font-size:16px;margin:0; color:#5e5e5f;font-family:open sans, arial; display:block; font-weight:bold;margin-bottom:40px;">Kind regards,<br />
                    The Micromaxcash Team!</strong>
            </div>
        </td>
        <td width="4%"></td>
    </tr>

    <tr>
        <td width="4%"></td>
        <td bgcolor="#eeeeee" align="center">
            <div style="padding:30px 5% 10px;">
                <div style="display:block; margin:0 0 10px;font-family:open sans, arial;">
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="http://my.cbmglobal.io/images/icon-fb.png" /></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="http://my.cbmglobal.io/images/icon-twit.png" /></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="http://my.cbmglobal.io/images/icon-in.png" /></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="http://my.cbmglobal.io/images/icon-yt.png" /></a>
                </div>
                <p style="font-size:15px;color:#5e5e5f; margin:0 0 10px; font-family:open sans, arial;">Olenseweg 375<br />
                    2260 Westerlo<br />
                    Belgium</p>
                <p style="font-size:15px;color:#5e5e5f;margin:0 0 10px; font-family:open sans, arial;">Technical Inquiries or Support: <a style="color:#5e5e5f; text-decoration:none;" href="mailto:support@cbmglobal.io">support@cbmglobal.io</a><br />
                    Financial Inquiries: <a style="color:#5e5e5f; text-decoration:none;" href="mailto:accounting@cbmglobal.io">accounting@cbmglobal.io</a></p>
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


