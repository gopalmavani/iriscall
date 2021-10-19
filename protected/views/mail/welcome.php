<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>IrisCall</title>
    <link rel="icon" type="image/png" href="<?= Yii::app()->getBaseUrl(true).'/images/logos/iriscall-favicon.png'?>" sizes="16x16" />
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
        <td colspan="3" style="background:#096c9e; no-repeat right;background-size:cover;padding:0;" align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="4%">&nbsp;</td>
                    <td align="left">
                        <a href="javascript:void()"  style="display:inline-block;">
                            <img src="<?= Yii::app()->getBaseUrl(true).'/images/logos/iriscall-logo-white.png'; ?>" style="max-width: 30%; margin: 10px 0;"/>
                        </a>
                    </td>
                    <td width="4%">&nbsp;</td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td align="left"><div style="padding:0 3%"> <h1 style="font-size:22px; margin:30px 0 30px; font-family:open sans, arial; font-weight:bold; text-transform:uppercase;">WELKOM!</h1>

                <p style="font-size:16px;margin:0 0 10px; color:#5e5e5f;font-family:open sans, arial;">Je ontvangt dit bericht omdat je je met <?= $email ?> registreerde op de  <a href="http://iriscall.be/" type="button">iriscall.be</a> website.</p>
                <p style="font-size:16px;margin:0 0 10px; color:#5e5e5f;font-family:open sans, arial;">Gelieve op de link te klikken om te bevestigen dat dit je e-mailadres is. Zo voltooien we het registratieproces en weten we zeker dat we je accountgegevens naar het juiste adres sturen.</p>
                <div style="width: 250px; height: 20px;margin-bottom: 10px; background-color: #FDCF4A;border-color: #FDCF4A;border: 2px solid #FDCF4A;border-radius: 25px;padding: 10px;text-align: center;">
                <?php if(isset($activationUrl)) { ?>
                    <a style="display: block;color: #ffffff;font-size: 18px;text-decoration: none;" href="<?= $activationUrl; ?>" type="button">VERIFIEER MIJN E-MAIL</a>
                <?php } else { ?>
                    <a style="display: block;color: #ffffff;font-size: 18px;text-decoration: none;" href="<?= $resetUrl; ?>" type="button">Join Us Now!!</a>
                <?php } ?>
            </div>
                <p style="font-size:16px;margin:0 0 10px; color:#5e5e5f;font-family:open sans, arial;">Dankjewel</p>

                <p style="font-size:16px;margin:0 0 10px; color:#5e5e5f;font-family:open sans, arial;">Met vriendelijke groet,<br />IrisCall</p>
            </div>
        </td>
        <td width="4%"></td>
    </tr>
    <tr>
        <td colspan="3" bgcolor="#096C9E" align="left">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left">
                        <div style="padding:20px;">
                            <div style="display:block;font-family:open sans, arial;">
                                <a href="javascript:void()" style="font-size:16px;color:#fff;text-decoration: none;margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/misc/question-mark.png'; ?>" width="60px;" /><strong>Vragen?</strong><br /><span style="margin-left: 60px;">> klantenservice<span></a>
                            </div>
                        </div>
                    </td>
                    <td align="left">
                        <div style="padding:20px;">
                            <div style="display:block;font-family:open sans, arial;">
                                <a href="javascript:void()" style="font-size:16px;color:#fff;text-decoration: none;margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/misc/shopping-basket.png'; ?>" width="60px;" /><strong>Online winkelen?</strong><br /><span style="margin-left: 60px;">> Bezoek onze webshop<span></a>
                            </div>
                        </div>
                    </td>
                    <td align="left">
                        <div style="padding:20px;">
                            <div style="display:block;font-family:open sans, arial;">
                                <a href="javascript:void()" style="font-size:16px;color:#fff;text-decoration: none;margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true). '/images/misc/user.png';?>" width="60px;" /><strong>Aanpassingen?</strong><br /><span style="margin-left: 60px;">> Wijzig je profiel<span></a>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td align="center" bgcolor="#fff">
            <br /><p style="font-size:16px;color:#096C9E; font-family:open sans, arial;">Algemene voorwaarden | Privacybeleid</p>
        </td>
        <td width="4%"></td>
    </tr>
</table>
</body>
</html>