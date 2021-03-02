
<?php
setlocale(LC_MONETARY, 'nl_NL.UTF-8');
if ($data == 0) { ?>
    <div class="block">
        <div class="block-content block-content-narrow">
            <div class="h1 text-center push-30-t push-30 hidden-print">NO INVOICE FOUND</div>
            <hr class="hidden-print">
        </div>
    </div>
    <?php
} else { $id = $data['orderInfo']->order_info_id; ?>
    <table width="100%" style="font-family: Helvetica;" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" width="50%">
                            <img style="width: 300px" src="<?php echo Yii::app()->getBaseUrl(true).'/images/logos/iriscall-logo.svg';?>"/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 0;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="45%">
                            <h4 style="margin:10px; font-size:28px; color: #0b0b0b;">Customer:</h4>
                            <!-- <p style="font-size: 24px; line-height: 20px;">OrderID : <?= $data['orderInfo']->order_id; ?></p>
                            <p style="font-size: 24px; line-height: 20px;">Order Date : <?php /* echo date('d-M-Y', strtotime($data['orderInfo']->invoice_date)); */?></p> -->
                            <p style="font-size:18px;line-height: 20px"><?php echo $data['userInfo']->full_name; ?></p>
                            <p style="font-size:18px;line-height: 20px;">
                                <?php echo $data['userInfo']->email;?><br>
                                <?php
                                if(!empty($data['orderInfo']->company)) echo "Company: ".$data['orderInfo']->company;?><br>
                                <?php echo $data['orderInfo']->building; ?> <?php echo $data['orderInfo']->street; ?> <br>
                                <?php echo $data['orderInfo']->region; ?><br>
                                <?php echo $data['orderInfo']->postcode; ?> <?php echo $data['orderInfo']->city; ?><br>
                                <?php echo ServiceHelper::getCountryNameFromId($data['orderInfo']->country); ?><br><br>
                                <?php if(!empty($data['orderInfo']->company) && !empty($data['orderInfo']->vat_number)) echo "VATnr = ".$data['orderInfo']->vat_number;?><br>
                                <?php if(!empty($data['userInfo']->phone)) echo "Phone No: ".$data['userInfo']->phone; ?>
                            </p>
                        </td>
                        <?php if (!empty($data['orderInfo']->invoice_date)) {
                            $convert = $data['orderInfo']->invoice_date;
                            $invoiceDate = date("d-m-Y", strtotime($convert));
                            $expirationDate = date("d-m-Y", strtotime($convert. ' + 20 days'));
                        } ?>
                        <td>
                            <table width="100%" style="border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe; border-right: 1px solid #b8babe; border-left: 1px solid #b8babe;">
                                <tr>
                                    <td style="padding-left: 130px; padding-top: 10px; padding-bottom: 10px;border-bottom: 1px solid #b8babe;">
                                        <h4 style="padding: 20px;border: 1px solid #4CAF50;color: #fff; font-size: 18px; background-color: #1a9e5a;">OUTSTANDING</h4>
                                    </td>
                                    <td style="padding:10px;border-bottom: 1px solid #b8babe;"><img style="border: 1px solid #80ced6;background-color: #00acee;" src="<?php echo Yii::app()->baseUrl.'/images/misc/send.png'; ?>" width="20px"/></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 18px;">Invoice No</td>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe; font-size: 18px; font-weight: bold;"><?= $data['orderInfo']->invoice_number; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 18px;">Invoice Date</td>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe; font-size: 18px; font-weight: bold;"><?= $invoiceDate; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 18px;">Expiration Date</td>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe; font-size: 18px; font-weight: bold;"><?= $expirationDate ; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 18px;">Structured Communication</td>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe; font-size: 18px; font-weight: bold;"><?= $data['orderInfo']->order_comment; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 18px;">Reference</td>
                                    <td style="padding:5px; font-size: 18px; font-weight: bold;"><?= $data['orderInfo']->order_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- <tr>
            <td>
                <table style="padding:40px 0;" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="50%">
                            <h3 style="color: #2f61a6;font-size: 40px;margin-bottom: 18px;">Iricall</h3>
                            <p style="font-size:24px;line-height: 20px;">
                                Force International CVBA<br>
                                Olenseweg 375<br>
                                2260 Westerlo<br>
                                +32 (0) 14/ 24 85 11<br><br>
                                VATnr = BE0647 631485<br>
                                BankAccountNr = BE63 0689 0467 8308<br>
                                BIC = GKCCBEBB<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr> -->
        <tr>
            <td>
                <div class="table-responsive invoice-grid">
                    <table class="table" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px;">
                        <thead>
                        <?php $disc = [];
                            foreach ($data['orderLineitem'] as $value) {
                                if(!empty($value->item_disc)) $disc[] = $value->item_disc;
                            }
                        if (!empty($disc)) { ?>
                        <tr>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;border-left: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" width="30%" align="left">Product</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" align="center">Price</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" align="center">Unit</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" align="center">Discount</th> 
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" align="center">vat</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;border-right: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" align="center">Amount</th>
                        </tr>
                        <?php }else{ ?>
                        <tr>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;border-left: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" width="45%" align="left">Product</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" width="15%" align="center">Price</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" width="10%" align="center">Unit</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;background-color: #f5f5f5;display: none;"></th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" align="center">vat</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;border-right: 1px solid #b8babe;background-color: #f5f5f5;font-size: 20px;" width="20%" align="center">Amount</th>
                        </tr>
                        <?php } ?>
                        </thead>
                        <tbody>
                        <?php foreach ($data['orderLineitem'] as $item) { ?>
                            <tr>
                                <td align="left" style="padding:10px;border-left: 1px solid #b8babe;border-bottom: 1px solid #b8babe;">
                                    <h4 style="font-size: 19px;color: #2f61a6;margin-bottom:5px;">
                                        <?php echo $item->product_name; ?>
                                    </h4>
                                </td>
                                <td align="center" style="font-size: 19px;border-bottom: 1px solid #b8babe;">&euro; <?= $item->item_price; ?></td>
                                <td align="center" style="font-size: 19px;border-bottom: 1px solid #b8babe;"><?= round($item->item_qty, 3) ?></td>    
                                <?php
                                    if(!empty($disc)) { ?>
                                    <td align="center" style="font-size: 19px;border-bottom: 1px solid #b8babe;">&euro; <?= (!empty($item->item_disc)) ? $item->item_disc : 0; ?></td>
                                <?php }else{ ?>
                                    <td style="padding:10px;border-bottom: 1px solid #b8babe;display: none;"></td>
                                <?php }
                                    $discount = (!empty($item->item_disc)) ? $item->item_disc : 0;
                                    $total = $item->item_qty * $item->item_price - $discount;
                                ?>
                                <td align="center" style="font-size: 19px;border-bottom: 1px solid #b8babe;">21%</td>
                                <td align="center" style="font-size: 19px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe;" ><strong>&euro; <?= round($total, 3) ?></strong></td>
                                <?php $subtotal = $data['orderInfo']->orderTotal - $data['orderInfo']->discount + $data['orderInfo']->voucher_discount?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <table align= "right" width="40%" style="margin-bottom: 20px;">
                        <tbody>
                            <tr class="sub-total">
                                <td class="col-label" colspan="2" style="background-color: #f5f5f5; border-top: 1px solid #e3e3e3; border-left: 1px solid #e3e3e3; padding:5px; color:#495b65;font-size:18px;font-weight: bold;">Discount:</td>
                                <td class="col-value" style="background-color: #f5f5f5; border-top: 1px solid #e3e3e3; border-right: 1px solid #e3e3e3;" align="center"><strong style="font-size: 18px;">&euro; <?= money_format('%(#1n',($data['orderInfo']->discount + $data['orderInfo']->voucher_discount)); ?></strong></td>
                            </tr>
                            <tr class="sub-total">
                                <td class="col-label" colspan="2" style="background-color: #f5f5f5; border-left: 1px solid #e3e3e3; padding:5px; color:#495b65;font-size:18px;font-weight: bold;">Sub Total:</td>
                                <td class="col-value" style="background-color: #f5f5f5; border-right: 1px solid #e3e3e3;" align="center"><strong style="font-size: 18px;">&euro; <?= round(money_format('%(#1n',($subtotal)), 3); ?></strong></td>
                            </tr>
                            <tr class="sub-total">
                                <?php $vatAmount = $subtotal * 21 / 100; 
                                      $finalTotal = $subtotal + $vatAmount;
                                ?>
                                <td class="col-label" colspan="2" style="background-color: #f5f5f5; border-left: 1px solid #e3e3e3; padding:5px; color:#495b65;font-size:18px;font-weight: bold;">Vat Rate(21%):</td>
                                <td class="col-value" style="background-color: #f5f5f5; border-right: 1px solid #e3e3e3;" align="center"><strong style="font-size: 18px;">&euro; <?php echo round(money_format('%(#1n',$vatAmount),3); ?></strong></td>
                            </tr>
                            <tr class="total">
                                <td class="col-label" colspan="2" style="background-color: #f5f5f5; border-left: 1px solid #e3e3e3; border-bottom: 1px solid #e3e3e3; padding:5px; color:#495b65;font-size:18px;font-weight: bold;">Total:</td>
                                <td class="col-value" style="background-color: #f5f5f5; border-bottom: 1px solid #e3e3e3; border-right: 1px solid #e3e3e3;" align="center"><strong style="font-size:18px;">&euro; <?php echo round(money_format('%(#1n',$finalTotal), 3); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr><td style="background: #eee;padding: 15px; color:#000; font-size: 18px;">
            We kindly request you to transfer the amount owed of <span>&euro; <b><?php echo round($finalTotal, 3); ?></b></span> within the due date to IBAN BE85 0689 0467 8106 in the name of IrisCall, stating the invoice number.<br><br>
            In case of non-payment by the due date, IrisCall will send you or the paying third party designated by you a reminder. From the second reminder, the customer will owe a reminder fee of EUR 12.10 including VAT to IrisCall. In addition, after termination of the services, the invoices that are not paid on time will be increased with conventional default interest at 10% on an annual basis, calculated from the due date until full payment, as well as with a 15% damage clause on the outstanding amounts with a minimum of 50.00 euros incl. VAT, without prejudice to IrisCall's right to claim a higher compensation, subject to proof of higher actual damage.<br><br>
            If you have any questions about the invoice or payment, please contact ilka.vandebroeck@iriscall.be.<br><br>
            IrisCall is a trade name of Force International CVBA.
        </td></tr>
        <!-- <tr>
            <td align="center" style="padding-top:77%;"><p style="color: #2f61a6;font-size: 18px;line-height: 28px;">THANK YOU VERY MUCH FOR DOING BUSINESS WITH US.</p></td>
        </tr>
        <tr>
            <td>
                <table width="100%" border="0" style="padding:10px 0; border-top:1px solid #b8babe;" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr>
                        <td width="35%" align="center" style="padding:20px;">
                        <img src="<?php /* echo Yii::app()->baseUrl.'/images/misc/icon-map.jpg'; ?>" width="80px"/><br/><span style="display:block; font-size: 14px">Olenseweg 375 2260 Westerlo Belgium</span></td>
                        <td width="28%" align="center"><img src="<?php echo Yii::app()->baseUrl.'/images/misc/icon-phone.jpg';?>"  width="80px" /><br/><span style="display:block; font-size: 14px">+32 14 24 85 11</span>	</td>
                        <td width="35%" align="center"><img src="<?php echo Yii::app()->baseUrl.'/images/misc/icon-msg.jpg'; */ ?>"  width="80px" /><br/><a  style="display:block; font-size: 14px color:#000; text-decoration:none;" href="mailto:accounting@cbm.net">accounting@cbmglobal.io</a> </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        <tr><td style="background: #eee;padding: 20px; text-align:center; color:#000; font-size: 14px">
                Iriscall is a brand name of <a href="http://force.international/" style="font-weight:bold; color:#000; text-decoration:none;" target="_blank">Force International CVBA</a>
        </td></tr> -->
    </table>
<?php } ?>