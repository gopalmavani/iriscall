
<?php
setlocale(LC_MONETARY, 'nl_NL.UTF-8');
?>
<table width="100%" style="margin:0 auto; font-family: Helvetica;" border="0" cellspacing="0" cellpadding="0">
    <tr><td style="background: #eee;padding: 15px; color:#000; font-size: 14px">
        We kindly request you to transfer the amount owed of <span>&euro; <b><?php echo round($data['orderInfo']->netTotal, 3); ?></b></span> within the due date to IBAN BE85 0689 0467 8106 in the name of IrisCall, stating the invoice number.<br><br>
        In case of non-payment by the due date, IrisCall will send you or the paying third party designated by you a reminder. From the second reminder, the customer will owe a reminder fee of EUR 12.10 including VAT to IrisCall. In addition, after termination of the services, the invoices that are not paid on time will be increased with conventional default interest at 10% on an annual basis, calculated from the due date until full payment, as well as with a 15% damage clause on the outstanding amounts with a minimum of 50.00 euros incl. VAT, without prejudice to IrisCall's right to claim a higher compensation, subject to proof of higher actual damage.<br><br>
        If you have any questions about the invoice or payment, please contact ilka.vandebroeck@iriscall.be.<br><br>
        IrisCall is a trade name of Force International CVBA.
    </td></tr>
    <tr>
        <td align="center" style="padding-top:77%;"><p style="color: #2f61a6;font-size: 18px;line-height: 28px;">THANK YOU VERY MUCH FOR DOING BUSINESS WITH US.</p></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" style="padding:10px 0; border-top:1px solid #b8babe;" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td width="35%" align="center" style="padding:20px;">
                    <img src="<?php echo Yii::app()->baseUrl.'/images/misc/icon-map.jpg'; ?>" width="80px"/><br/><span style="display:block; font-size: 14px">Olenseweg 375 2260 Westerlo Belgium</span></td>
                    <td width="28%" align="center"><img src="<?php echo Yii::app()->baseUrl.'/images/misc/icon-phone.jpg';?>"  width="80px" /><br/><span style="display:block; font-size: 14px">+32 14 24 85 11</span>	</td>
                    <td width="35%" align="center"><img src="<?php echo Yii::app()->baseUrl.'/images/misc/icon-msg.jpg'; ?>"  width="80px" /><br/><a  style="display:block; font-size: 14px color:#000; text-decoration:none;" href="mailto:accounting@cbm.net">accounting@cbmglobal.io</a> </td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    <tr><td style="background: #eee;padding: 20px; text-align:center; color:#000; font-size: 14px">
            Iriscall is a brand name of <a href="http://force.international/" style="font-weight:bold; color:#000; text-decoration:none;" target="_blank">Force International CVBA</a>
        </td></tr>
</table>