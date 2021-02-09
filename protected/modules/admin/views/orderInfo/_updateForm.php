<?php
/* @var $this OrderInfoController */
/* @var $model OrderInfo */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo CHtml::link('Go to list', array('orderInfo/admin'), array('class' => 'btn btn-minw btn-square btn-warning')); ?>
        </div>
    </div>
	<div class="col-lg-12">
		<div class="block">
			<div class="block-content block-content-narrow">
				<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'order-update-form',
				'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
				'enableAjaxValidation'=>false,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)); ?>
				<?php echo $form->errorSummary($model); ?>
				<div class="form-material has-error">
					<p id="productError" class="help-block has-error" style="display: none;"></p>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="col-md-12">
							<div class="form-group">
								<?php
								$usersList = CHtml::listData(UserInfo::model()->findAll(["order" => "full_name"]), "user_id",
									function ($data){
										return "{$data->first_name}  {$data->last_name}";
									});
								echo $form->dropDownListControlGroup($model, "user_id", $usersList, [
									"prompt" => "Select User",
									"class" => "js-select2 form-control",
									'disabled'=>'disabled',
							
								]);
								?>
							</div>
						</div>

					</div>
				</div>
				<h4>Address</h4>
				<div class="row">
					<div class="col-md-6">
						<div class="col-md-12 ">
							<div class="form-group <?php echo $model->hasErrors('vat_number') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'vat_number', array('autofocus' => 'on', 'class' => 'form-control')); ?>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('company') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'company', array('autofocus' => 'on', 'class' => 'form-control')); ?>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('building') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'building', array('autofocus' => 'on', 'class' => 'form-control')); ?>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('street') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'street', array('autofocus' => 'on', 'class' => 'form-control')); ?>
							</div>
						</div>
					</div>
					<div class="col-md-6">

						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('city') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'city', array('autofocus' => 'on', 'class' => 'form-control')); ?>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('region') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'region', array('autofocus' => 'on', 'class' => 'form-control')); ?>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('country') ? 'has-error' : ''; ?>">
								<?php echo $form->dropDownListControlGroup($model, 'country', Yii::app()->ServiceHelper->getCountry(), array('prompt' => 'Select Country', 'class' => 'js-select2 form-control')); ?>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group <?php echo $model->hasErrors('postcode') ? 'has-error' : ''; ?>">
								<?php echo $form->textFieldControlGroup($model, 'postcode', array('autofocus' => 'on', 'class' => 'form-control')); ?>
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
								<table class="table">
									<thead>
									<tr>
										<th>Product Name</th>
										<th class="text-center">Qty</th>
										<th class="text-center">Discount</th>
										<th class="text-center">Price</th>
										<th class="text-center">Total</th>
									</tr>
									</thead>
									<tbody class="table" id="productControl">
									<?php
									$count = 1;
									foreach($orderItem as $key => $item){
										$count++;
									?>
										<tr class="addMoreProduct">
										<!-- <td class="col-md-6">
											<div class="col-md-12">
												<div class="form-group">
													<?php
													$productList = CHtml::listData(ProductInfo::model()->findAll(['order' => 'name']), 'product_id', 'name');
													echo $form->dropDownList($item, 'product_id[]', $productList, [
														'prompt' => 'Select Product',
														'class' => 'form-control',
														//'disabled'=>'disabled',
                                                        'options' => array($item['product_id'] =>array('selected'=>true))
													]);
													?>
												</div>
											</div>
										</td> -->
										
											<td class="col-md-5">
											<div class="col-md-12">
												<div class="form-group <?php echo $item->hasErrors('product_name') ? 'has-error' : ''; ?>">
													<input autofocus="autofocus" readonly="readonly" class="form-control" placeholder="Product name" name="OrderLineItem[product_name][]" id="OrderLineItem_product_id" value="<?php  echo $item->attributes['product_name']; ?>" type="text">
<!--													-->												</div>
											</div>
										</td>
										
										<td class="col-md-2">
											<div class="col-md-12">
												<div class="form-group <?php echo $item->hasErrors('item_qty') ? 'has-error' : ''; ?>">
													<input autocomplete="off" autofocus="autofocus" class="form-control" placeholder="Qty" name="OrderLineItem[item_qty][]" id="OrderLineItem_item_qty" value="<?php echo $item->attributes['item_qty'];  ?>" type="text">
<!--													-->												</div>
											</div>
										</td>
										<td class="col-md-1">
											<div class="col-md-12">
												<div class="form-group ">
													<input autocomplete="off" autofocus="autofocus" class="form-control" placeholder="Discount" name="OrderLineItem[item_disc][]" id="OrderLineItem_item_disc" value="<?php echo $item->attributes['item_disc'];  ?>" type="text">
													<?php //echo $form->textField($orderItem, 'item_disc[]', array('autofocus' => 'on','readonly' => 'readonly', 'class' => 'form-control', 'placeholder' => 'Discount')); ?>
												</div>
											</div>
										</td>
										<td class="col-md-2">
											<div class="col-md-12">
												<div class="form-group ">
													<input autocomplete="off" autofocus="autofocus" class="form-control" placeholder="Price" id="itemPrice" name="OrderLineItem[item_price][]" value="<?php echo $item->attributes['item_price'];  ?>" type="text">
<!--													-->												</div>
											</div>
										</td>
										<?php
											$qty = $item->attributes['item_qty'];
											$price =  $item->attributes['item_price'];
											$total = $qty * $price;
										?>
										<td class="col-md-2">
											<div class="col-md-12">
												<div class="form-group ">
													<input autofocus="autofocus" class="form-control" style="width: 100%;" readonly="readonly" placeholder="Total Price" value="<?php echo $total;  ?>" type="text">
<!--													-->												</div>
											</div>
										</td>
										<!-- <td class="col-md-2 text-center">
											<div class="col-md-12">
												<?php
                                            end($orderItem);
                                            if($key == key($orderItem)){ ?>
                                                <button type="button" class="btn btn-success btn-add-product">
                                                    <span>+</span>
                                                </button>
												<?php }else{ ?>
                                                <button type="button" class="btn btn-danger btn-remove-product">
                                                    <span>-</span>
                                                </button>
												<?php } ?>
											</div>
										</td> -->
									</tr>
									<?php } ?>
									<tr id="beforePrice">
										<td colspan="4" class="text-right"><strong>Total Price:</strong></td>
										<td class="text-right"  id="totalPrice"><?php echo $model['orderTotal']; ?></td>
									</tr>
									<tr>
										<td colspan="4" class="text-right"><strong>Total Discount:</strong></td>
										<td class="text-right"  id="totalDiscount"><?php echo $model['discount']; ?></td>
									</tr>
									<tr>
                                        <td colspan="4" class="text-right"><strong>Vat@<?php echo  $model['vat_percentage']; ?>%:</strong></td>
                                        <td class="text-right"  id="vat_amount"><?php echo $model['vat']; ?></td>
                                    </tr>
									<tr class="success">
										<td colspan="4" class="text-right text-uppercase"><strong>Net Total:</strong></td>
										<td class="text-right"><strong  id="net_amount"><?php echo $model['netTotal']; ?></strong></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="block">
					<div class="">
						<h4>Payment</h4>
						<div class="row">
								<div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Payment Id</th>
                                            <th>Payment Mode</th>
                                            <th class="text-center">Payment Status</th>
                                            <th class="text-center">Payment Ref</th>
                                            <th class="text-center">Payment Date</th>
                                            <th class="text-center">Payment Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $paymentModeList = CHtml::listData(Payment::model()->findAllByAttributes([]), 'payment_id', 'gateway'); ?>
                                            <?php foreach ($orderPayment as $key => $item) { ?>
                                                <tr>
                                                    <td class="col-md-1">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input autofocus="autofocus" class="form-control" placeholder="Id" name="OrderPayment[payment_id][]" id="OrderPayment_payment_id" value="<?php echo $item->attributes['payment_id'];  ?>" type="text" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="col-md-3">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <?php
                                                                echo $form->dropDownList($item, 'payment_mode[]', $paymentModeList, [
                                                                    'prompt' => 'Select Payment Mode',
                                                                    'class' => 'js-select2 form-control',
                                                                    'options' => array($item['payment_mode'] =>array('selected'=>true))
                                                                ]);
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="col-md-3">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <?php
                                                                $fieldId = CylFields::model()->findByAttributes(['field_name' => 'payment_status']);
                                                                $statusList = CHtml::listData(CylFieldValues::model()->findAllByAttributes(['field_id' => $fieldId->field_id]), 'predefined_value', 'field_label');
                                                                if($item['payment_status'] == 1){
                                                                    echo $form->dropDownList($item, 'payment_status[]', $statusList, [
                                                                        'prompt' => 'Select Status',
                                                                        'class' => 'js-select2  form-control',
                                                                        'options' => array($item['payment_status'] =>array('selected'=>true))
                                                                        //'options' => array(1 =>array('selected'=>true))
                                                                    ]);
                                                                } else {
                                                                    echo $form->dropDownList($item, 'payment_status[]', $statusList, [
                                                                        'prompt' => 'Select Status',
                                                                        'class' => 'js-select2 form-control',
                                                                        'options' => array($item['payment_status'] =>array('selected'=>true))
                                                                        //'options' => array(1 =>array('selected'=>true))
                                                                    ]);
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="col-md-2">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input autocomplete="off" autofocus="autofocus" class="form-control" placeholder="Reference" name="OrderPayment[ref_id][]" id="OrderPayment_ref_id" value="<?php echo $item->attributes['payment_ref_id'];  ?>" type="text">
                                                                <?php /*echo $form->textFieldControlGroup($orderPayment, 'payment_ref_id', array('autofocus' => 'on', 'class' => 'form-control')); */?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="col-md-2">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <?php /*echo $form->labelEx($item, 'paymentDate[]', array('class' => 'control-label')); */?>
                                                                <?php
                                                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                    'model' => $item,
                                                                    'attribute' => 'payment_date',
                                                                    'options' => array(
                                                                        'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                                                        'dateFormat' => 'yy-mm-dd',
                                                                        'maxDate' => date('Y-m-d'),
                                                                        'changeYear' => true,           // can change year
                                                                        'changeMonth' => true,
                                                                        'yearRange' => '1900:' . date('Y'),
                                                                    ),
                                                                    'htmlOptions' => array(
                                                                        'class' => 'form-control'
                                                                        //'style'=>'height:20px;background-color:green;color:white;',
                                                                    ),
                                                                ));
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="col-md-2">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input autofocus="autofocus" class="form-control" placeholder="Amount" name="OrderPayment[amount][]" id="OrderPayment_amount" value="<?php echo $item->attributes['total'];  ?>" type="text">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
								</div>
                        </div>
					</div>
				</div>
			</div>
            <div class="col-md-12" align="right">
                <div class="form-group">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', [
							'class' => 'btn btn-primary',
                            'id' => 'submit_button'
                            ]
                    ); ?>
                    <?php echo CHtml::link('Cancel', array('orderInfo/admin'),
							['class' => 'btn btn-default']
                    ); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
		</div>
	</div>
</div>

<script>
	/*

	 */
    /*$("#submit_button").click(function(){
        $("#order-update-form").submit(); // Submit the form
    });*/

	function ProductPrice(productDetails) {
		var country = $("#OrderInfo_country").val();
		var validQtyFlag = 0;
		// get selected product
		var productItem = productDetails.find('#OrderLineItem_product_id').val();
		// get entered quantity
		var UserId = $('#OrderInfo_user_id').val();
		var productQty = productDetails.find('#OrderLineItem_item_qty').val();
		var validNum = /[^\d].+/;

		if(productItem != '' && productQty != ''){
			var data = {qty : productQty,productname : productItem,User_id : UserId,country:country};
			$.ajax({
				type : "POST",
				url : '<?php echo Yii::app()->getUrlManager()->createUrl('admin/OrderInfo/loadprice'); ?>',
				data : data,
				success : function(result){
					var productData = JSON.parse(result);
					if(productData.result == true){
						console.info(productData.vatAmount);
						productDetails.find('#itemPrice').val(productData.productPrice);
                        setPriceTotal();
					}
				}
			});
		}else{
			productDetails.find('#itemPrice').val('');
		}
	}

	// Select Address
	$(document).on('change','#orderAddress',function (e) {
		var data = {addressMapId : $(this).val()};
		$.ajax({
			type : "POST",
			url : '<?php echo Yii::app()->createUrl('admin/OrderInfo/getaddress'); ?>',
			data : data,
			success : function(result){
				var addressData = JSON.parse(result);
				if(addressData.result == true){
					$('#OrderInfo_vat_number').val(addressData['orderAddress']['vat_number']);
					$('#OrderInfo_company').val(addressData['orderAddress']['company_name']);
					$('#OrderInfo_building').val(addressData['orderAddress']['building_no']);
					$('#OrderInfo_street').val(addressData['orderAddress']['street']);
					$('#OrderInfo_city').val(addressData['orderAddress']['city']);
					$('#OrderInfo_region').val(addressData['orderAddress']['region']);
					$('#OrderInfo_country').val(addressData['orderAddress']['country']);
					$('#OrderInfo_postcode').val(addressData['orderAddress']['postcode']);
				}
			}
		});
	});

	//    function checkQty(productName,productQty){
	//        console.info();
	//        var data = {sku : productName,qty : productQty};
	//        $.ajax({
	//            type : "POST",
	//            url : '//',
	//            data : data,
	//            success : function(result){
	//                var productData = JSON.parse(result);
	//                if(productData.result == true){
	//                    productDetails.find('#itemPrice').val(productData.productPrice);
	//                    console.info('true');
	//                }else{
	//                    console.info('false');
	//                }
	//            },
	//        });
	//    }
</script>