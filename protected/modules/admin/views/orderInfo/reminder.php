<?php
$this->PageTitle = "Send Reminder";
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('orderInfo/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'mail-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'mail-form',
                    )
                ));
                if(empty($model->email)){
                    $user = UserInfo::model()->findByPk($model->user_id);
                    $email = $user->email;
                }else{
                    $email = $model->email;
                } ?>
                <div class="col-md-10">
                    <div class="form-group">
                        <label>To Email</label>
                        <input type="text" class="form-control form-control-lg" name="email" placeholder="To Email" value="<?= $email; ?>" />
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label>Message</label>
                        <input type="text" class="form-control form-control-lg" name="message" placeholder="Message" value="<?= 'Iriscall : '. $model->user_name; ?>" />
                    </div>
                </div>
                <?php if(empty($order_info_meta)){ 
                    $dueDate = date("d/m/Y", strtotime($model->invoice_date.' + 7 days')); ?>
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control form-control-lg" name="description" placeholder="Description..." rows="10">Beste <?= $model->user_name; ?>,&#13;&#10;
Wij willen u erop wijzen dat de betalingstermijn van onze factuur met <?= $model->user_name; ?> en vervaldatum <?= $dueDate; ?> verstreken is. Helaas hebben wij nog geen betaling van u mogen ontvangen. Wellicht is de factuur aan uw aandacht ontsnapt.&#13;&#10;
Wij verzoeken u het openstaande bedrag van € <?= round($model->orderTotal,3) ?> binnen 7 dagen aan ons over te maken. Wij hebben een kopie van de betreffende factuur meegestuurd. Bij een volgende herinnering zijn wij genoodzaakt extra kosten aan te rekenen.&#13;&#10;
Indien het bedrag inmiddels is overgemaakt dan kunt u deze e-mail uiteraard negeren.&#13;&#10;
Met vriendelijke groeten,&#13;&#10;admin</textarea>
                        </div>
                    </div>
                    <input type="text" style="display: none;" class="form-control form-control-lg" name="subject" value="Payment Reminder"/>
                <?php }else {
                        if($order_info_meta[0]['action'] == '1st Reminder sent'){
                            $amount = $model->orderTotal + 12.10; ?>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control form-control-lg" name="description" placeholder="Description..." rows="10">Beste <?= $model->user_name; ?> attention,&#13;&#10;
Uit onze administratie is gebleken dat factuurnummer <?= $model->invoice_number; ?> na onze eerste herinnering nog steeds niet door u is voldaan.&#13;&#10;
Wij verzoeken u vriendelijk doch dringend het verschuldigde bedrag van <?= round($amount,3) ?> alsnog zo spoedig mogelijk, doch uiterlijk binnen 5 dagen, over te maken op onze rekening met vermelding van het factuurnummer <?= $model->invoice_number; ?>.&#13;&#10;
Voor deze tweede herinnering word een administratieve kost van 12,10 euro aangerekend inclusief btw.&#13;&#10;
Indien het bedrag inmiddels is overgemaakt dan kunt u deze e-mail negeren.&#13;&#10;
Met vriendelijke groet,&#13;&#10;Admin</textarea>
                            </div>
                        </div>
                        <input type="text" style="display: none;" class="form-control form-control-lg" name="subject" value="Second Reminder"/>
                    <?php }elseif($order_info_meta[0]['action'] == '2nd Reminder sent'){
                        $amount = $model->orderTotal + 12.10; ?>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control form-control-lg" name="description" placeholder="Description..." rows="10">Beste <?= $model->user_name; ?> attention,&#13;&#10;
Ondanks eerdere herinneringen hebben wij uw betaling van factuurnummer <?= $model->invoice_number; ?> nog niet mogen ontvangen.&#13;&#10;
Wij verzoeken u met klem het verschuldigde bedrag van <?= round($amount,3) ?> onmiddellijk en uiterlijk binnen 5 dagen over te maken op onze rekening onder vermelding van het factuurnummer <?= $model->invoice_number; ?>.&#13;&#10;
Voor deze derde herinnering word een extra kost aangerekend van 12,10 euro inclusief btw.&#13;&#10;
Mocht uw betaling wederom uitblijven, dan zijn wij genoodzaakt het factuurbedrag te verhogen met nalatigheidsintrest van 10%.&#13;&#10;
Indien het bedrag inmiddels is overgemaakt dan kunt u deze e-mail negeren.&#13;&#10;
Met de meeste hoogachting,&#13;&#10;Admin</textarea>
                            </div>
                        </div>
                        <input type="text" style="display: none;" class="form-control form-control-lg" name="subject" value="Third Reminder"/>
                <?php }else { ?>
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control form-control-lg" name="description" placeholder="Description..." rows="10"></textarea>
                        </div>
                    </div>
                    <input type="text" style="display: none;" class="form-control form-control-lg" name="subject" value="Reminder"/>
                <?php } } ?>
                <div class="col-md-10">
                    <div class="form-group">
                        <span class="switch switch-outline switch-icon switch-success">
                            <label>
                                <input type="checkbox" name="attachment">
                                <span></span>
                            </label>
                        </span>
                        <label class="col-8 col-form-label col-form-label-new">Attach invoice to the email.</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group" align="right">
                <?php echo CHtml::submitButton('send', array(
                    'class' => 'btn btn-primary col-md-offset-2',
                )); ?>
                <?php echo CHtml::link('Cancel', array('orderInfo/admin'),
                    array(
                        'class' => 'btn btn-default'
                    )
                );
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>