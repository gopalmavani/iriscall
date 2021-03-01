<?php
/* @var $this OrderInfoController */
/* @var $model OrderInfo */
/* @var $form CActiveForm */

?>
<style>
    .selected-address {
        padding: 10px 15px;
        border: 1px solid #eee;
        border-radius: 10px;
    }
</style>
<!--Begin loader-->
<div class="overlay overlayhide" style="opacity:0.1 !important;position:unset !important;">
    <div class="loader">
        <p style="font-size: 18px;"><i class="fa fa-cog fa-spin" aria-hidden="true"></i> Loading...</p>
    </div>
</div>
<!--End loader-->
<div class="row createOrderForm">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('orderInfo/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'order-info-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'CreateOrder'),
                )); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group"  id="user">
                                <?php
                                $usersList = CHtml::listData(UserInfo::model()->findAll(["order" => "full_name"]), "user_id",
                                    function ($data){
                                        return "{$data->first_name}  {$data->last_name}";
                                    });
                                echo $form->dropDownListControlGroup($model, "user_id", $usersList, [
                                    "prompt" => "Select User",
                                    "class" => "js-select2 form-control",
                                ]);
                                ?>
                                <div class="help-block" id="user_msg"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
						<div class="col-md-12 ">
							<div class="form-group <?php echo $model->hasErrors('order_comment') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'order_comment', array('autofocus' => 'on', 'autocomplete' => 'off', 'class' => 'form-control')); ?>
							</div>
						</div>
					</div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12 hide" id="address-selector">
                            <div class="form-group">
                                <div class="control-group">
                                    <label class="control-label required" for="OrderInfo_user_id">Addresses <span class="required">*</span></label>
                                    <div class="controls">
                                        <input type="radio" id="homeAddr" name="select_address" class="AddType" value="0" checked/> <label for="homeAddr">Personal</label>&nbsp;&nbsp;
                                        <input type="radio" id="workAddr" name="select_address" class="AddType" value="1"/> <label for="workAddr">Business</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 selected-address hide"></div>
                    </div>
                </div>
                <div class="block hide">
                    <div class="block-header">
                        <!--						<h3 class="block-title">Add Product</h3>-->
                    </div>
                    <h4>Address</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 ">
                                <div class="form-group <?php echo $model->hasErrors('vat_number') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'vat_number', array('autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('company') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'company', array('autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('building') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'building', array('autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('street') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'street', array('autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('city') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'city', array('autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('region') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'region', array('autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('country') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->dropDownListControlGroup($model, 'country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'js-select2 form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('postcode') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'postcode', array('autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="block-header">
                        <!--						<h3 class="block-title">Add Product</h3>-->
                    </div>
                    <div class="">
                        <h4>Product</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th class="text-center" id="quantity">Qty</th>
                                        <th class="text-center">Discount</th>
                                        <th class="text-center">Price</th>
                                        <!--<th class="text-center" id="subscription_check">Action</th>-->
                                    </tr>
                                    </thead>
                                    <tbody class="table" id="productControl">
                                    <tr class="addMoreProduct">
                                        <td class="col-md-6">
                                            <div class="col-md-12">
                                                <div class="form-group" id="product">
                                                    <?php
                                                        $productList = CHtml::listData(ProductInfo::model()->findAll(['order' => 'name']),'product_id','name');
                                                        echo $form->dropDownList($orderItem, 'product_id[]', $productList, [
                                                            'prompt' => 'Select Product',
                                                            'class' => 'js-select2 form-control product',
                                                            'id' => 'selected',
                                                        ]);
                                                    ?>
                                                    <div class="help-block" id="product_msg"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group <?php echo $orderItem->hasErrors('item_qty') ? 'has-error' : ''; ?>" id="qty">
                                                    <?php echo $form->textField($orderItem, 'item_qty[]', [
                                                        'class' => 'form-control product',
                                                        'placeholder' => 'Qty',
                                                        'id' => 'OrderLineItem_item_qty'
                                                    ]); ?>
                                                    <div class="help-block" id="qty_msg"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                            <div class="col-md-12">
                                                <div class="form-group <?php echo $orderItem->hasErrors('item_disc') ? 'has-error' : ''; ?> ">
                                                    <?php echo $form->textField($orderItem, 'item_disc[]', array('autofocus' => 'on', 'value'=>0, 'id' => 'disc', 'class' => 'form-control product', 'placeholder' => 'Discount')); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2 text-center">
                                            <div class="col-md-12">
                                                <div class="form-group <?php echo $orderItem->hasErrors('item_price') ? 'has-error' : ''; ?> ">
                                                    <?php echo $form->textField($orderItem, 'item_price[]', [
                                                        'autofocus' => 'on',
                                                        'readonly' => 'readonly',
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Price',
                                                        'id' => 'itemPrice'
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="display: none;">
											<input style="display: none;" class="form-control hidetotal" readonly="readonly" val="" placeholder="Total Price" type="text">
										</td>
                                        <td style="display: none;">
											<input style="display: none;" class="form-control hidediscount" readonly="readonly" val="" placeholder="Total Discount" type="text">
										</td>
                                        <!--<td class="col-md-2 text-center"  id="plus_button">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-success btn-add-product">
                                                    <span>+</span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="col-md-3" id="subs_check" style="display: none">
                                            <div class="col-md-12">
                                                <div class="form-group <?php /*echo $model->hasErrors('is_subscription_enabled') ? 'has-error' : ''; */?> ">
                                                    <?php /*echo $form->dropDownList($model, 'is_subscription_enabled',array('1' => 'Yes','0' => 'No'),  array('class' => 'form-control','options' => array('0'=>array('selected'=>true)))); */?>
                                                </div>
                                            </div>
                                        </td>-->

                                    </tr>
                                    <tr id="beforePrice">
                                        <td colspan="4" class="text-right"><strong>Total Price:</strong></td>
                                        <td class="text-right"  id="totalPrice">0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Total Discount:</strong></td>
                                        <td class="text-right"  id="totalDiscount">0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong id="vatPercent">Vat:</strong></td>
                                        <td class="text-right"  id="vat-amount">0</td>
                                    </tr>
                                    <tr class="success">
                                        <td colspan="4" class="text-right text-uppercase"><strong>Net Total:</strong></td>
                                        <td class="text-right"><strong  id="netTotalLabel">0</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Subscription code commented out for time being -->
<!--                <div id="subscription_details" class="block" style="display: none">-->
<!--                    <h4>Subscription Details</h4>-->
<!--                    <div class="row">-->
<!--                        <div class="col-md-6">-->
<!--                            <div class="col-md-12">-->
<!--                                <div class="form-group" id="sub_duration">-->
<!--                                    --><?php //echo $form->textFieldControlGroup($productSubscription, 'duration', array('autofocus' => 'on', 'class' => 'form-control', 'placeHolder' => 'Enter number of days, weeks, etc..')); ?>
<!--                                    <div class="help-block" id="duration_sub"></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-12">-->
<!--                                <div class="form-group" id="sub_starting_date">-->
<!--                                    --><?php //echo $form->labelEx($productSubscription, 'starts_at', array('class' => 'control-label')); ?>
<!--                                    --><?php
//                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//                                        'model' => $productSubscription,
//                                        'attribute' => 'starts_at',
//                                        'options' => array(
//                                            'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
//                                            'dateFormat' => 'yy-mm-dd',
//                                            'maxDate' => date('Y-m-d'),
//                                            'changeYear' => true,           // can change year
//                                            'changeMonth' => true,
//                                            'yearRange' => '1900:' . date('Y'),
//                                        ),
//                                        'htmlOptions' => array(
//                                            'class' => 'form-control'
//                                        ),
//                                    ));
//                                    ?>
<!--                                    <span class="help-block" id="starting_date_sub"></span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-6">-->
<!--                            <div class="col-md-12">-->
<!--                                <div class="form-group --><?php //echo $productSubscription->hasErrors('duration_denomination') ? 'has-error' : ''; ?><!--">-->
<!--                                    --><?php
//                                    $fieldId = CylFields::model()->findByAttributes(['field_name' => 'duration_denomination']);
//                                    $statusList = CHtml::listData(CylFieldValues::model()->findAllByAttributes(['field_id' => $fieldId->field_id],['order' => 'predefined_value ASC']), 'predefined_value', 'field_label');
//                                    echo $form->dropDownListControlGroup($productSubscription, 'duration_denomination', $statusList, [
//                                        'prompt' => 'Select Status',
//                                        'class' => 'form-control'
//                                    ]);
//                                    ?>
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-md-12">-->
<!--                                <div class="form-group">-->
<!--                                    <br><br><br>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="block">
                    <div class="">
                        <h4>Payment</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $orderPayment->hasErrors('payment_mode') ? 'has-error' : ''; ?> " id="payment_mode">
                                        <?php
                                        //$modeFieldId = CylFields::model()->findByAttributes([ 'field_name' => 'payment_mode']);
                                        $paymentModeList = CHtml::listData(Payment::model()->findAllByAttributes([]), 'payment_id', 'gateway');
                                        echo $form->dropDownListControlGroup($orderPayment, 'payment_mode', $paymentModeList, [
                                            'prompt' => 'Select Payment Mode',
                                            'class' => 'js-select2 form-control',
                                            'id' => 'OrderPayment_payment_mode'
                                        ]);
                                        ?>
                                        <div class="help-block" id="payment_mode_msg"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $orderPayment->hasErrors('payment_ref_id') ? 'has-error' : ''; ?> " id="payment_ref">
                                        <?php echo $form->textFieldControlGroup($orderPayment, 'payment_ref_id', array('autofocus' => 'on', 'class' => 'form-control', 'id' => 'OrderPayment_payment_ref_id')); ?>
                                        <div class="help-block" id="payment_ref_msg"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $orderPayment->hasErrors('payment_status') ? 'has-error' : ''; ?> ">
                                        <?php
                                        $fieldId = CylFields::model()->findByAttributes(['field_name' => 'order_status']);
                                        $statusList = CHtml::listData(CylFieldValues::model()->findAllByAttributes(['field_id' => $fieldId->field_id]), 'predefined_value', 'field_label');
                                        echo $form->dropDownListControlGroup($orderPayment, 'payment_status', $statusList, [
                                            'prompt' => 'Select Status',
                                            'class' => 'js-select2 form-control',
                                            'disabled' => 'disabled',
                                            'options' => array(1 =>array('selected'=>true))
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $orderPayment->hasErrors('payment_date') ? 'has-error' : ''; ?> " id="payment_date">
                                        <?php echo $form->labelEx($orderPayment, 'paymentDate', array('class' => 'control-label')); ?>
                                        <span class="required" aria-required="true">*</span>
                                        <?php
                                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $orderPayment,
                                            'attribute' => 'payment_date',
                                            'options' => array(
                                                'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                                'dateFormat' => 'yy-mm-dd',
                                                'maxDate' => date('Y-m-d'),
                                                'changeYear' => true,           // can change year
                                                'changeMonth' => true,
                                                'yearRange' => '1900:' . date('Y'),
                                                'class' => 'form-control'
                                            ),
                                            'htmlOptions' => array(
                                                'class' => 'form-control'
                                                //'style'=>'height:20px;background-color:green;color:white;',
                                            ),
                                        ));
                                        ?>
                                        <span class="help-block" id="payment_date_msg"><?php echo $form->error($orderPayment, 'payment_date'); ?></span>
                                    </div>
                                </div>
                                <input type="hidden" name="OrderInfo[vat]" id="vat_amount" value="">
                                <input type="hidden" name="OrderInfo[vat_percent]" id="vat_percent" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" align="right">
                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                            'class' => 'btn btn-primary',
                            'id' => 'submit_button',
                        )); ?>
                        <?php echo CHtml::link('Cancel', array('orderInfo/admin'),
                            array(
                                'class' => 'btn btn-default'
                            )
                        ); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<script>
    // calculate everything
    //$(document).on("keyup", ".product", calcAll);
	$(".product").on("change", calcAll);

	// function for calculating product details
	function calcAll() {
		$(".addMoreProduct").each(function () {
            var product = '<?php echo json_encode($productPrice); ?>';
            var data = JSON.parse(product);
            //console.log(data);
			var qnty = 0;
			var price = 0;
			var discount = 0;
			var total = 0;
            if (!isNaN(parseFloat($(this).find("#selected").val()))) {
				id = parseFloat($(this).find("#selected").val());
                if(id != ''){
                    price = data[id];
                }
			}
			if (!isNaN(parseFloat($(this).find("#OrderLineItem_item_qty").val()))) {
				qnty = parseFloat($(this).find("#OrderLineItem_item_qty").val());
			}
			if (!isNaN(parseFloat($(this).find("#disc").val()))) {
				discount = parseFloat($(this).find("#disc").val());
			}
			disc = qnty * discount;
			total = qnty * price - discount;
            $(this).find("#itemPrice").val(price.toFixed(3));
			$(this).find(".hidetotal").val(total.toFixed(3));
            $(this).find(".hidediscount").val(disc.toFixed(3));
		});

        var sum = $(".hidetotal").val();
        var totalDiscount = $(".hidediscount").val();
		// show values of Total price, Total discount Net total .toFixed(3)
        $("#totalPrice").text(sum);
        $("#totalDiscount").text(totalDiscount);
        $("#netTotalLabel").text(sum);
	}

    $('#order-info-form').on('submit', function (e) {
        //$('#submit_button').attr('disabled', true);
    });

    function ProductPrice(productDetails) {
        $('#product_msg').css('display','none');
        $('#product').removeClass('has-error');
        var validQtyFlag = 0;
        var addrType = $(".AddType:checked").val();
        var UserId = $('#OrderInfo_user_id').val();
        // get selected product
        var productItem = productDetails.find('#OrderLineItem_product_id').val();
        // get entered quantity
        var productQty = productDetails.find('#OrderLineItem_item_qty').val();
        var discount = productDetails.find('#OrderLineItem_item_disc').val();
        var validNum = /[^\d].+/;

        if(productItem != '' && productQty != ''){
            $('#qty_msg').css('display','none');
            $('#qty').removeClass('has-error');
            var data = {qty : productQty,product_id : productItem,address : addrType, user_id : UserId, discount: discount};
            $.ajax({
                type : "POST",
                url : '<?php echo Yii::app()->getUrlManager()->createUrl('admin/OrderInfo/loadprice'); ?>' ,
                data : data,
                success : function(result){
                    var productData = JSON.parse(result);
                    if(productData.result == true){
                        $('#itemPrice').val(productData.productPrice);
                        $("#vatPercent").html('Vat@' + productData.vatpercent + '%');
                        $('#totalPrice').html(productData.totalItemPrice);
                        $('#netTotalLabel').html(productData.netTotal);
                        $('#vat-amount').html(productData.vatAmount);
                        //Set the hidden vat element
                        $('#vat_amount').val(productData.vatAmount);
                        $('#vat_percent').val(productData.vatpercent);
                        $('#totalDiscount').html(productData.totalDiscount);
                    }
                    //Removing subscription code for time being
                    /*var subscription = productData.productSubscription;
                    if(subscription == 1){
                        $('#subs_head').css('display', 'block');
                        $('#subs_check').css('display', 'block');
                        $('#plus_button').css('display','none');
//						$('#quantity').css('display','none');
                        $('#subscription_check').text('SUBSCRIPTION');
                        $('#OrderInfo_is_subscription_enabled').css('width','115px');
                    } else{
                        $('#subs_head').css('display', 'none');
                        $('#subs_check').css('display', 'none');
                        $('#plus_button').css('display','block');
                        $('#subscription_check').val('Action');
                    }*/
                }
            });
        }else{
            productDetails.find('#itemPrice').val('');
        }
    }

    // TODO: Select Address
    $(document).on('change','#OrderInfo_user_id',function (e) {
        $("#vat-amount, #netTotal, #totalPrice, #totalDiscount").html('0');
        $('#user_msg').css('display','none');
        $('#user').removeClass('has-error');

        $("#address-selector").addClass("hide");
        var data = {user_id : $(this).val()};
        $.ajax({
            type : "POST",
            url : '<?php echo Yii::app()->createUrl('admin/OrderInfo/getaddress'); ?>',
            data : data,
            success : function(result){
                var addressData = JSON.parse(result);
                if(addressData.result == true){
                    $('#submit_button').attr("disabled", false);
                    if(addressData['userInfo']['business_name'] != 0) {
                        if(addressData['userInfo']['business_name'] != "") {
                            if(addressData['userInfo']['business_name'] != null){
                                $("#address-selector").removeClass("hide");
                            }
                        }
                    }
                    setAddress(0, addressData);
                }else if(addressData.result == 'false'){
                    $("#address-selector").removeClass("hide");
                    $("#address-selector").html('<span style="color:red;">Address is not Available</span>');
                    // setAddress(0, addressData);
                    $('#submit_button').attr('disabled', true);
                }else {
                    alert("could not load address")
                }
            }
        });
    });

    function changedPrice(){

        var productRow = $('#OrderLineItem_product_id').parents('tr');
        ProductPrice(productRow);
    }

    $('#OrderLineItem_item_qty').on("keyup",function () {
        var productName = $('#OrderLineItem_product_id').val();
        if (productName == '') {
            $('#product_msg').text('Please choose product name');
            $('#product').addClass('has-error');
            return false;
        }
    });

    //On updating item remove defined field
    $('#OrderLineItem_product_id').on("change",function(){
        $('#OrderLineItem_item_qty').val('');
        $('#OrderLineItem_item_disc').val(0);
        $('#totalPrice').html(0);
        $('#netTotalLabel').html(0);
        $('#vat-amount').html(0);
        $('#totalDiscount').html(0);
    });

//    $('#OrderInfo_is_subscription_enabled').change(function () {
//        var val = $(this).val();
//        if(val == 1) {
//            $('#subscription_details').css('display', 'block');
//        }
//        else {
//            $('#subscription_details').css('display', 'none');
//        }
//    });
    $("#homeAddr, #workAddr").change(function () {
        var data = {user_id : $('#OrderInfo_user_id').val()};
        var addressType = $(this).val();
        $.ajax({
            type : "POST",
            url : '<?php echo Yii::app()->createUrl('admin/OrderInfo/getaddress'); ?>',
            data : data,
            success : function(result){
                var addressData = JSON.parse(result);
                if(addressData.result == true){
                    setAddress(addressType, addressData);
                } else {
                    alert("could not load address")
                }
                changedPrice();
            }
        });
    });

    function setAddress(adType, addressData) {
        if(adType == 0) {
            var personalAddress = '';
            personalAddress += (addressData['userInfo']['full_name'] == 'NULL' || addressData['userInfo']['full_name'] == '0' || addressData['userInfo']['full_name'] === 0 || !addressData['userInfo']['full_name'])?'':"<b>" + addressData['userInfo']['full_name']+"</b>,<br/>";
            personalAddress += (addressData['userInfo']['building_num'] == 'NULL' || addressData['userInfo']['building_num'] == '0' || addressData['userInfo']['building_num'] === 0 || !addressData['userInfo']['building_num'] )?'':addressData['userInfo']['building_num']+", ";
            personalAddress += (addressData['userInfo']['street'] == 'NULL' || addressData['userInfo']['street'] == '0' || addressData['userInfo']['street'] === 0 || !addressData['userInfo']['street'])?'':addressData['userInfo']['street'] + ',<br/>';
            personalAddress += (addressData['userInfo']['city'] == 'NULL' || addressData['userInfo']['city'] == '0' || addressData['userInfo']['city'] === 0 || !addressData['userInfo']['city'])?'':addressData['userInfo']['city'] + ' - ';
            personalAddress += (addressData['userInfo']['postcode'] == 'NULL' || addressData['userInfo']['postcode'] == '0' || addressData['userInfo']['postcode'] === 0 || !addressData['userInfo']['postcode'] )?'':addressData['userInfo']['postcode'] + ', ';
            personalAddress += (addressData['userInfo']['region'] == 'NULL' || addressData['userInfo']['region'] == '0' || addressData['userInfo']['region'] === 0 || !addressData['userInfo']['region'] )?'':addressData['userInfo']['region'] + ', ';
            personalAddress += (addressData['userInfo']['country'] == 'NULL' || addressData['userInfo']['country'] == '0' || addressData['userInfo']['country'] === 0 || !addressData['userInfo']['country'] )?'':addressData['userInfo']['country'];

            $(".selected-address").removeClass("hide");
            $(".selected-address").html(personalAddress);

            $('#OrderInfo_vat_number').val('');
            $('#OrderInfo_company').val('');
            $('#OrderInfo_street').val(addressData['userInfo']['street']);
            $('#OrderInfo_city').val(addressData['userInfo']['city']);
            $('#OrderInfo_region').val(addressData['userInfo']['region']);
            $('#OrderInfo_country').val(addressData['userInfo']['country']);
            $('#OrderInfo_postcode').val(addressData['userInfo']['postcode']);

        } else {
            var businessAddr = '';
            businessAddr += (addressData['userInfo']['business_name'] == 'NULL' || addressData['userInfo']['business_name'] == '0' || addressData['userInfo']['business_name'] === 0 || !addressData['userInfo']['business_name'])?'':"<b>" + addressData['userInfo']['business_name']+"</b>,<br/>";
            businessAddr += (addressData['userInfo']['busAddress_building_num'] == 'NULL' || addressData['userInfo']['busAddress_building_num'] == '0' || addressData['userInfo']['busAddress_building_num'] === 0 || !addressData['userInfo']['busAddress_building_num'] )?'':addressData['userInfo']['busAddress_building_num']+", ";
            businessAddr += (addressData['userInfo']['busAddress_street'] == 'NULL' || addressData['userInfo']['busAddress_street'] == '0' || addressData['userInfo']['busAddress_street'] === 0 || !addressData['userInfo']['busAddress_street'] )?'':addressData['userInfo']['busAddress_street'] + ',<br/>';
            businessAddr += (addressData['userInfo']['busAddress_city'] == 'NULL' || addressData['userInfo']['busAddress_city'] == '0' || addressData['userInfo']['busAddress_city'] === 0 || !addressData['userInfo']['busAddress_city'] )?'':addressData['userInfo']['busAddress_city'] + ' - ';
            businessAddr += (addressData['userInfo']['busAddress_postcode'] == 'NULL' || addressData['userInfo']['busAddress_postcode'] == '0' || addressData['userInfo']['busAddress_postcode'] === 0 || !addressData['userInfo']['busAddress_postcode'] )?'':addressData['userInfo']['busAddress_postcode'] + ', ';
            businessAddr += (addressData['userInfo']['busAddress_region'] == 'NULL' || addressData['userInfo']['busAddress_region'] == '0' || addressData['userInfo']['busAddress_region'] === 0 || !addressData['userInfo']['busAddress_region'] )?'':addressData['userInfo']['busAddress_region'] + ', ';
            businessAddr += (addressData['userInfo']['busAddress_country'] == 'NULL' || addressData['userInfo']['busAddress_country'] == '0' || addressData['userInfo']['busAddress_country'] === 0 || !addressData['userInfo']['busAddress_country'] )?'':addressData['userInfo']['busAddress_country'] + ', <br/>';
            businessAddr += (addressData['userInfo']['vat_number'] == 'NULL' || addressData['userInfo']['vat_number'] == '0' || addressData['userInfo']['vat_number'] === 0 || !addressData['userInfo']['vat_number'] )?'':'' + addressData['userInfo']['vat_number'];

            $(".selected-address").removeClass("hide");
            $(".selected-address").html(businessAddr);

            $('#OrderInfo_vat_number').val(addressData['userInfo']['vat_number']);
            $('#OrderInfo_company').val(addressData['userInfo']['business_name']);
            $('#OrderInfo_building').val(addressData['userInfo']['busAddress_building_num']);
            $('#OrderInfo_street').val(addressData['userInfo']['busAddress_street']);
            $('#OrderInfo_city').val(addressData['userInfo']['busAddress_city']);
            $('#OrderInfo_region').val(addressData['userInfo']['busAddress_region']);
            $('#OrderInfo_country').val(addressData['userInfo']['busAddress_country']);
            $('#OrderInfo_postcode').val(addressData['userInfo']['busAddress_postcode']);
        }
    }
</script>