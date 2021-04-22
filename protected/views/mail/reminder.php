<?php
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Iriscall - Payment Reminder</title>
    <link rel="icon" type="image/png" href="<?= Yii::app()->getBaseUrl(true).'/images/logos/favicon.ico'?>" sizes="16x16" />
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
<table style="max-width:800px; margin:0 auto;" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3" style="background:#fff url(<?= Yii::app()->getBaseUrl(true).'/images/bg-home.jpg'?>) no-repeat right;background-size:cover;padding:0;" align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="4%">&nbsp;</td>
                    <td align="center">
                        <a href="javascript:void()"  style="display:inline-block;">
                            <img src="<?= Yii::app()->getBaseUrl(true).'/images/logos/iriscall-logo.svg'; ?>" style="max-width: 100%; margin: 30px 0;"/>
                        </a>
                    </td>
                    <td width="4%">&nbsp;</td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td>
            <h1 align="center" style="font-size:32px; text-transform:uppercase; color:#005aa0; margin:30px 0 50px; font-family:open sans, arial; font-weight:bold;">Payment Reminder</h1>
            <?php if($reminder == '1st Reminder'){
                $dueDate = date("d/m/Y", strtotime($orders['invoice_date'].' + 7 days')); ?>
                <p style="font-size:16px;color:#5e5e5f;font-family:open sans, arial; margin:0 0 20px;">Beste <?= $orders['user_name'] ?>,<br/><br/>
                    Wij willen u erop wijzen dat de betalingstermijn van onze factuur met factuurnummer <?= $orders['invoice_number'] ?> en vervaldatum <?= $dueDate; ?> verstreken is. Helaas hebben wij nog geen betaling van u mogen ontvangen. Wellicht is de factuur aan uw aandacht ontsnapt.<br/><br/>
                    Wij verzoeken u het openstaande bedrag van € <?= round($orders['orderTotal'],3) ?> binnen 7 dagen aan ons over te maken. Wij hebben een kopie van de betreffende factuur meegestuurd. Bij een volgende herinnering zijn wij genoodzaakt extra kosten aan te rekenen.<br/><br/>
                    Indien het bedrag inmiddels is overgemaakt dan kunt u deze e-mail uiteraard negeren.<br/><br/>
                    Met vriendelijke groeten,<br/>Admin
                </p>
            <?php }elseif($reminder == '2nd Reminder'){ 
                $amount = $orders['orderTotal'] + 12.10; ?>
                <p style="font-size:16px;color:#5e5e5f;font-family:open sans, arial; margin:0 0 20px;">Beste <?= $orders['user_name'] ?> attention,<br/><br/>
                    Uit onze administratie is gebleken dat factuurnummer <?= $orders['invoice_number'] ?> na onze eerste herinnering nog steeds niet door u is voldaan.<br/><br/>
                    Wij verzoeken u vriendelijk doch dringend het verschuldigde bedrag van <?= round($amount,3) ?> alsnog zo spoedig mogelijk, doch uiterlijk binnen 5 dagen, over te maken op onze rekening met vermelding van het factuurnummer <?= $orders['invoice_number'] ?>.<br/><br/>
                    Voor deze tweede herinnering word een administratieve kost van 12,10 euro aangerekend inclusief btw.<br/><br/>
                    Indien het bedrag inmiddels is overgemaakt dan kunt u deze e-mail negeren.<br/><br/>
                    Met vriendelijke groet,<br/>Admin
                </p>
            <?php }elseif($reminder == '3rd Reminder'){ 
                $amount = $orders['orderTotal'] + 12.10; ?>
                <p style="font-size:16px;color:#5e5e5f;font-family:open sans, arial; margin:0 0 20px;">Beste <?= $orders['user_name'] ?> attention,<br/><br/>
                    Ondanks eerdere herinneringen hebben wij uw betaling van factuurnummer <?= $orders['invoice_number'] ?> nog niet mogen ontvangen.<br/><br/>
                    Wij verzoeken u met klem het verschuldigde bedrag van <?= round($amount,3) ?> onmiddellijk en uiterlijk binnen 5 dagen over te maken op onze rekening onder vermelding van het factuurnummer <?= $orders['invoice_number'] ?>.<br/><br/>
                    Voor deze derde herinnering word een extra kost aangerekend van 12,10 euro inclusief btw.<br/><br/>
                    Mocht uw betaling wederom uitblijven, dan zijn wij genoodzaakt het factuurbedrag te verhogen met nalatigheidsintrest van 10%.<br/><br/>
                    Indien het bedrag inmiddels is overgemaakt dan kunt u deze e-mail negeren.<br/><br/>
                    Met de meeste hoogachting,<br/>Admin
                </p>
            <?php }elseif ($reminder == 'By Admin') { ?>
                <p style="font-size:16px;color:#5e5e5f;font-family:open sans, arial; margin:0 0 20px;"><?= $description ?><p>
            <?php } ?>
        </td>
        <td width="4%"></td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td align="center">
            <div class="bg-grey" style="padding:30px 5% 10px; background-color:#eeeeee; margin:0 4%;">
                <div style="display:block; margin:0 0 10px;font-family:open sans, arial;">
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/misc/icon-fb.png'; ?>" /></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true).'/images/misc/icon-twit.png'; ?>" /></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true). 'images/misc/icon-in.png';?>" /></a>
                    <a href="javascript:void()" style="margin:0 2px; display:inline-block;"><img src="<?= Yii::app()->getBaseUrl(true). 'images/misc/icon-yt.png';?>" /></a>
                </div>
                <p style="font-size:15px;color:#5e5e5f; margin:0 0 10px; font-family:open sans, arial;">Olenseweg 375<br />
                    2260 Westerlo<br />
                    Belgium</p>
                <p style="font-size:15px;color:#5e5e5f;margin:0 0 10px; font-family:open sans, arial;">Technical Inquiries or Support: <a style="color:#5e5e5f; text-decoration:none;" href="mailto:support@cbmglobal.io">support@cbmglobal.io</a><br />
                    Financial Inquiries: <a style="color:#5e5e5f; text-decoration:none;" href="mailto:accounting@cbmglobal.io">accounting@cbmglobal.io</a></p>
            </div>
        </td>
        <td width="4%"></td>
    </tr>
    <tr>
        <td width="4%"></td>
        <td align="center" bgcolor="#fff">
            <br /><small style="font-size:12px;color:#5e5e5f; font-family:open sans, arial;">This is an automatically generated email.<br />
                Please do not reply as your message will not be received and will be returned to you by the mail server.</small>
            <p style="font-size:13px;color:#5e5e5f; font-family:open sans, arial;">© <?php echo date('Y');?> Iriscall</p>
        </td>
        <td width="4%"></td>
    </tr>
</table>
</body>
</html>