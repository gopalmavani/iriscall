<?php function money_format($x,$y){
    return $y;
} ?>
<?php
setlocale(LC_MONETARY, 'nl_NL.UTF-8');
if ($data == 0) { ?>
    <div class="block">
        <div class="block-content block-content-narrow">
            <div class="h1 text-center push-30-t push-30 hidden-print">Geen Factuur Gevonden</div>
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
                            <img style="width: 230px" src="<?php echo Yii::app()->getBaseUrl(true).'/images/logos/iriscall-logo.svg';?>"/>
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
                            <h4 style="margin:10px; font-size:22px; color: #0b0b0b;">Klant:</h4>
                            <!-- <p style="font-size: 24px; line-height: 20px;">OrderID : <?= $data['orderInfo']->order_id; ?></p>
                            <p style="font-size: 24px; line-height: 20px;">Order Date : <?php /* echo date('d-M-Y', strtotime($data['orderInfo']->invoice_date)); */?></p> -->
                            <p style="font-size:14px;line-height: 20px"><?php echo $data['userInfo']->full_name; ?></p>
                            <p style="font-size:14px;line-height: 20px;">
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
                            <table width="100%" style="border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe; border-right: 1px solid #b8babe; border-left: 1px solid #b8babe;margin-bottom: 20px;">
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 14px;">Factuur nr</td>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe; font-size: 14px; font-weight: bold;"><?= $data['orderInfo']->invoice_number; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 14px;">Factuur datum</td>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe; font-size: 14px; font-weight: bold;"><?= $invoiceDate; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 14px;">Vervaldatum</td>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe; font-size: 14px; font-weight: bold;"><?= $expirationDate ; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 14px;">Gestructureerde communicatie</td>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe; font-size: 14px; font-weight: bold;"><?= $data['orderInfo']->order_comment; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:5px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe; font-size: 14px;">Referentie</td>
                                    <td style="padding:5px; font-size: 14px; font-weight: bold;"><?= $data['orderInfo']->order_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="table-responsive invoice-grid">
                    <table class="table" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                        <?php $disc = [];
                              $product = [];
                            foreach ($data['orderLineitem'] as $value) {
                                if(!empty($value->item_disc)) $disc[] = $value->item_disc;
                                if(in_array($value->product_name, ['Number Of Users','External Numbers'])) $product['Periode Februari 2021: Abonnement'][] = $value;
                                if($value->product_name != 'Number Of Users' && $value->product_name != 'External Numbers') $product['Periode Januari 2021: Verbruik'][] = $value;
                            }
                        if (!empty($disc)) { ?>
                        <tr>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;border-left: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" width="45%" align="left">Product</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" align="center">Prijs</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" align="center">Eenheid</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" align="center">Korting</th> 
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" align="center">vat</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;border-right: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" align="center">Bedrag</th>
                        </tr>
                        <?php }else{ ?>
                        <tr>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;border-left: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" width="45%" align="left">Product</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" width="15%" align="center">Prijs</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe; border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" width="10%" align="center">Eenheid</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;background-color: #f5f5f5;display: none;"></th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" align="center">vat</th>
                            <th style="padding:10px;border-bottom: 1px solid #b8babe;border-top: 1px solid #b8babe;border-right: 1px solid #b8babe;background-color: #f5f5f5;font-size: 16px;" width="20%" align="center">Bedrag</th>
                        </tr>
                        <?php } ?>
                        </thead>
                        <tbody>
                        <?php foreach ($product as $key=>$items) { ?>
                            <tr>
                                <td align="left" style="padding:10px;font-size: 14px;border-left: 1px solid #b8babe;border-bottom: 1px solid #b8babe;font-weight: bold;"><?php echo $key ?></td>
                                <td style="border-bottom: 1px solid #b8babe;"></td>
                                <td style="border-bottom: 1px solid #b8babe;"></td>
                                <td style="border-bottom: 1px solid #b8babe;"></td>
                                <td style="border-bottom: 1px solid #b8babe;"></td>
                                <td style="border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe;"></td>
                            </tr>
                            <?php foreach ($items as $item) { ?>
                                <tr>
                                    <td align="left" style="padding:10px;border-left: 1px solid #b8babe;border-bottom: 1px solid #b8babe;">
                                        <h4 style="font-size: 14px;color: #2f61a6;">
                                            <?php echo $item->product_name; ?>
                                        </h4>
                                    </td>
                                    <td align="center" style="font-size: 14px;border-bottom: 1px solid #b8babe;">&euro; <?= $item->item_price; ?></td>
                                    <td align="center" style="font-size: 14px;border-bottom: 1px solid #b8babe;"><?= round($item->item_qty, 3) ?></td>    
                                    <?php
                                        if(!empty($disc)) { ?>
                                        <td align="center" style="font-size: 14px;border-bottom: 1px solid #b8babe;">&euro; <?= (!empty($item->item_disc)) ? $item->item_disc : 0; ?></td>
                                    <?php }else{ ?>
                                        <td style="padding:10px;border-bottom: 1px solid #b8babe;display: none;"></td>
                                    <?php }
                                        $discount = (!empty($item->item_disc)) ? $item->item_disc : 0;
                                        $total = $item->item_qty * $item->item_price - $discount;
                                    ?>
                                    <td align="center" style="font-size: 14px;border-bottom: 1px solid #b8babe;">21%</td>
                                    <td align="center" style="font-size: 14px;border-bottom: 1px solid #b8babe;border-right: 1px solid #b8babe;" ><strong>&euro; <?= round($total, 3) ?></strong></td>
                                </tr>
                        <?php } }?>
                        </tbody>
                    </table>
                    <?php
                        $count = 0;
                        foreach ($order_info_meta as $reminders){
                        if(in_array($reminders['action'], ['2nd Reminder sent', '3rd Reminder sent'])){
                            $count++; ?>
                        <?php } }
                        if(in_array($action, ['2nd Reminder sent', '3rd Reminder sent'])){
                            $count += 1;
                        }
                        $addAmount = $count * 12.10; 
                        if(isset($addAmount) && $addAmount > 0){ ?>
                        <p style="font-size: 14px;"><b>Note:-</b> Total number of 2nd and 3rd reminders sent are <?= $count ?>, so total additional amount &euro; <?= $addAmount ?> added in order total.</p>
                    <?php } ?>
                    <?php $subtotal = $data['orderInfo']->orderTotal - $data['orderInfo']->discount + $data['orderInfo']->voucher_discount?>
                    <table align= "right" width="40%" style="margin-bottom: 20px;margin-top: 10px;">
                        <tbody>
                            <tr class="sub-total">
                                <td class="col-label" colspan="2" style="background-color: #f5f5f5; border-top: 1px solid #e3e3e3; border-left: 1px solid #e3e3e3; padding:5px; color:#495b65;font-size:14px;font-weight: bold;">Korting:</td>
                                <td class="col-value" style="background-color: #f5f5f5; border-top: 1px solid #e3e3e3; border-right: 1px solid #e3e3e3;" align="center"><strong style="font-size: 14px;">&euro; <?= money_format('%(#1n',($data['orderInfo']->discount + $data['orderInfo']->voucher_discount)); ?></strong></td>
                            </tr>
                            <tr class="sub-total">
                                <td class="col-label" colspan="2" style="background-color: #f5f5f5; border-left: 1px solid #e3e3e3; padding:5px; color:#495b65;font-size:14px;font-weight: bold;">Subtotaal:</td>
                                <td class="col-value" style="background-color: #f5f5f5; border-right: 1px solid #e3e3e3;" align="center"><strong style="font-size: 14px;">&euro; <?= round(money_format('%(#1n',($subtotal)), 3); ?></strong></td>
                            </tr>
                            <tr class="sub-total">
                                <?php $vatAmount = $subtotal * 21 / 100; 
                                      $finalTotal = $subtotal + $vatAmount;
                                ?>
                                <td class="col-label" colspan="2" style="background-color: #f5f5f5; border-left: 1px solid #e3e3e3; padding:5px; color:#495b65;font-size:14px;font-weight: bold;">BTW-tarief(21%):</td>
                                <td class="col-value" style="background-color: #f5f5f5; border-right: 1px solid #e3e3e3;" align="center"><strong style="font-size: 14px;">&euro; <?php echo round(money_format('%(#1n',$vatAmount),3); ?></strong></td>
                            </tr>
                            <tr class="total">
                                <td class="col-label" colspan="2" style="background-color: #f5f5f5; border-left: 1px solid #e3e3e3; border-bottom: 1px solid #e3e3e3; padding:5px; color:#495b65;font-size:14px;font-weight: bold;">Totaal:</td>
                                <td class="col-value" style="background-color: #f5f5f5; border-bottom: 1px solid #e3e3e3; border-right: 1px solid #e3e3e3;" align="center"><strong style="font-size:14px;">&euro; <?php echo round(money_format('%(#1n',$finalTotal), 3); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        <tr><td style="background: #eee;padding: 10px; color:#000; font-size: 14px;">
            Wij verzoeken u vriendelijk het verschuldigde bedrag over te maken <span>&euro; <b><?php echo round($finalTotal, 3); ?></b></span> binnen de vervaldag op IBAN BE85 0689 0467 8106 ten name van IrisCall met vermelding van het factuurnummer.<br><br>
            In geval van niet-betaling op de vervaldag, zal IrisCall u of de door u aangewezen betalende derde een herinnering sturen. Vanaf de tweede herinnering is de klant aan IrisCall een herinneringsvergoeding van 12,10 euro inclusief btw verschuldigd. Bovendien worden na beëindiging van de diensten de facturen die niet op tijd betaald zijn, verhoogd met conventionele vertragingsrente van 10% op jaarbasis, gerekend vanaf de vervaldag tot volledige betaling, evenals met een schadeclausule van 15%. over de openstaande bedragen met een minimum van € 50,00 incl. BTW, onverminderd het recht van IrisCall om een ​​hogere vergoeding te vorderen, behoudens bewijs van hogere werkelijke schade.<br><br>
            Indien je vragen hebt over de factuur of betaling, gelieve ilka.vandebroeck@iriscall.be te contacteren..<br><br>
            IrisCall is een handelsnaam van Force International CVBA..
        </td></tr>
    </table>
<?php } ?>