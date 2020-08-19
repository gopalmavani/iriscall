<?php
/* @var $this ProductInfoController */
/* @var $model ProductInfo */
/* @var $form CActiveForm */
?>

<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="pull-right" style="margin: 0px 15px 15px 0px;">
        <?php echo CHtml::link('Go to list', array('productInfo/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
            </div>
    <div class="col-lg-12">
        <div class="block">
            <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
                <li id="product_tab" class="active">
                    <a href="#btabs-alt-static-justified-home"> Product</a>
                </li>
                <li id="affiliate_tab">
                    <a href="#btabs-alt-static-justified-profile"  > Affiliates</a>
                </li>
                <li id="license_tab">
                    <a href="#btabs-alt-static-justified-settings" > Licenses</a>
                </li>
            </ul>
            <div class="block-content tab-content">
                <div class="tab-pane active" id="btabs-alt-static-justified-home">
                     <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'=>'product-info-form',
                        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                        'enableAjaxValidation'=>false,
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'name' => 'product-info-form',
                            // 'onSubmit' => 'return(false)',
                        ),
                    )); ?>

                    <div class="row">
                        <h4>Update Product</h4>
                        <div class="row">
                            <div style="margin-left: 50px; width: fit-content;">
                                <div class="alert alert-success" style="display: none;" id="productUpdate" align="center">
                                    <h4 id="productUpdateSuccess">Product updated successfully</h4>
                                </div>
                                <div class="row">
                                    <div class="form-group <?php echo $productCategory->hasErrors('category_id') ? 'has-error' : ''; ?> ">
                                        <?php
                                        $categoryList = CHtml::listData(Categories::model()->findAll(['order' => 'category_name']), 'category_id', 'category_name');
                                        if (count($categoryList) > 1) {
                                            echo $form->dropDownListControlGroup($productCategory, 'category_id', $categoryList, [
                                                'class' => 'form-control',
                                            ]);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('name') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'name', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Product Name')); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('sku') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'sku', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Product Sku')); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('short_description') ? 'has-error' : ''; ?> ">
                                    <label class="">
                                        <?php echo $form->labelEx($model, 'short_description', array('class' => 'control-label')); ?>
                                    </label>
                                    <?php echo $form->textArea($model, 'short_description', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Product Short Description')); ?>
                                    <span class="help-block"><?php echo $form->error($model, 'short_description'); ?> </span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?> ">
                                    <label class="">
                                        <?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
                                    </label>
                                    <?php echo $form->textArea($model, 'description', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Product Description')); ?>
                                    <span class="help-block"><?php echo $form->error($model, 'description'); ?> </span>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('price') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'price', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Product Price')); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('sale_price') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'sale_price', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Sale Price')); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group" id="sale_start_date">
                                    <?php echo $form->labelEx($model, 'sale_start_date', array('class' => 'control-label')); ?>
                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model' => $model,
                                        'attribute' => 'sale_start_date',
                                        'options' => array(
                                            'showAnim' => '',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                            'dateFormat' => 'yy-mm-dd',
                                            'minDate' => date('Y-m-d'),
                                            'changeYear' => true,           // can change year
                                            'changeMonth' => true,
                                            'yearRange' => '1900:2100',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'form-control'
                                        ),
                                    ));
                                    ?>
                                    <span class="help-block" id="sale_start_date"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('sale_end_date') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->textFieldControlGroup($model, 'sale_end_date', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control')); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('is_active') ? 'has-error' : ''; ?> ">
                                    <?php echo $form->dropDownListControlGroup($model, 'is_active', array('1' => 'Yes', '0' => 'No'), array('class' => 'form-control')); ?>
                                    <?php echo $form->error($model, 'is_active'); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('image') ? 'has-error' : ''; ?> ">
                                    <label class="">
                                        <?php echo $form->labelEx($model, 'image', array('class' => 'control-label')); ?>
                                    </label><br/>
                                    <?php if(!empty($model->image)) { ?>
                                    <div class="col-xs-4 m-b-10 image-preview-box-update"  id="imgPreviewBox" >
                                        <img src="<?php echo Yii::app()->baseUrl . $model->image; ?> " class="image-preview" id="imagePreview" data-holder-rendered="true" >
                                    </div>
                                    <?php echo $form->fileField($model, 'image', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Product Image')); ?>
                                    <?php }else{ ?>
                                    <div class="col-xs-4 m-b-10 image-preview-box" id="imgPreviewBox">
                                        <img src="<?php echo Yii::app()->baseUrl . $model->image; ?> " class="image-preview" id="imagePreview" data-holder-rendered="true" >
                                    </div><br/>
                                    <?php echo $form->fileField($model, 'image', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Product Image')); ?>
                                    <div class="help-block" id="imageTypeError"></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" align="right">
                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save and Continue', array(
                                    'class' => 'btn btn-primary',
                                )); ?>
                                <?php echo CHtml::link('Cancel', array('orderInfo/admin'),
                                    array(
                                        'class' => 'btn btn-default'
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>

                <div class="tab-pane" id="btabs-alt-static-justified-profile">
                    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'=>'affiliateForm',
                        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                        'enableAjaxValidation'=>false,
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'name' => 'affiliate-form',
                        ),
                    )); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Update Affiliate Amount</h4>
                            <div class="form-material has-error">
                                <p id="affiliateError" class="help-block has-error" style="display: none;"></p>
                                <input type="hidden" name="ProductAffiliate[pid]" value="<?php echo $model->product_id; ?>" id="ProductAffiliate_pid">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info" style="display: none;" id="affiliateUpdate" align="center">
                                <h4 id="affiliateMessage">Product affiliate amount updated successfully</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="table" id="fields">
                                <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Amount</th>
                                    <th>ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody class="controls affiliate-control">
                                <div>
                                    <div class="" id="fields">
                                        <?php
                                        if(empty($productAffiliate)){ ?>
                                            <tr class="add-more-fields">
                                                <td>
                                                    <div class="form-group ">
                                                        <input class="form-control affiliate_count" placeholder="Product Level" id="ProductAffiliate_aff_level" name="ProductAffiliate[aff_level][]" type="text">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="form-control ProductAffiliate_amount" placeholder="Product Amount" id="ProductAffiliate_amount" name="ProductAffiliate[amount][]" type="text">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-add">
                                                        <span>+</span>
                                                    </button>
                                                </td>

                                            </tr>
                                        <?php }else{
                                            $count = 1;
                                            foreach ($productAffiliate as $key => $Affiliate) {
                                                $count++;
                                                ?>
                                                <tr class="add-more-fields">
                                                    <td>
                                                        <div class="">
                                                            <input class="form-control affiliate_count" placeholder="Level" name="ProductAffiliate[aff_level][]" id="ProductAffiliate_aff_level" type="text" value="<?php echo $Affiliate['aff_level'];?>"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input class="form-control ProductAffiliate_amount" placeholder="Amount" name="ProductAffiliate[amount][]" id="ProductAffiliate_amount" type="text" value="<?php echo $Affiliate['amount'];?>"/>
                                                    </td>
                                                    <td>
                                                        <?php if(end($productAffiliate)['aff_level'] == $Affiliate['aff_level']){ ?>
                                                            <button type="button" class="btn btn-success btn-add ">
                                                                <span>+</span>
                                                            </button>
                                                        <?php }else{ ?>
                                                            <button type='button' class='btn btn-danger btn-remove '>
                                                                <span>-</span>
                                                            </button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } } ?>
                                    </div>
                                </div>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" align="right">
                                <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array(
                                    'class' => 'btn btn-primary',
                                )); ?>
                                <?php echo CHtml::link('Cancel', array('productInfo/admin'),
                                    array(
                                        'class' => 'btn btn-default'
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>

                <div class="tab-pane" id="btabs-alt-static-justified-settings">
                    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'=>'licenseForm',
                        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                        'enableAjaxValidation'=>false,
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'name' => 'license-form',
                        ),
                    )); ?>
                    <div class="col-md-8">
                        <h4>Update Product Licenses</h4>
                        <div class="form-material has-error">
                            <p id="licenseError" class="help-block has-error" style="display: none;"></p>
                            <input type="hidden" name="ProductLicenses[pid]" value="<?php echo $model->product_id; ?>" id="ProductLicenses_pid">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-info" style="display: none;" id="licenseUpdate" align="center">
                            <h4 id="licenseMessage">Product licenses updated successfully</h4>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>License</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="controls license-control">
                            <?php
                            if(empty($productLicense)){ ?>
                                <tr class="add-more-license">
                                    <td>
                                        <div class="form-group">
                                            <?php
                                            $productList = CHtml::listData(ProductInfo::model()->findAll(['order' => 'name']), 'product_id', 'name');
                                            echo CHtml::dropDownList('ProductLicenses[product_id][]', $productLicense, $productList, [
                                                'prompt' => 'Select Product',
                                                'class' => 'form-control Product-List',
                                            ]);
                                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input class="form-control Product-License-No" placeholder="Product License" name="ProductLicenses[license_no][]" id="ProductLicenses_license_no" type="text">                                        </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-add-license">
                                            <span>+</span>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }else{
                                $count = 1;
                                foreach ($productLicense as $key => $licenses) {
                                    $count++;
                                    ?>
                                    <tr class="add-more-license">
                                        <td>
                                            <div class="form-group">
                                                <?php
                                                $productList = CHtml::listData(ProductInfo::model()->findAll(['order' => 'name']), 'product_id', 'name');
                                                echo $form->dropDownList($licenses, 'product_id[]', $productList, [
                                                    'prompt' => 'Select Product',
                                                    'class' => 'form-control Product-List',
                                                    'options' => array($licenses['product_id'] =>array('selected'=>true))
                                                ]);
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <?php
                                                    echo $form->textField($licenses,'license_no[]', array(
                                                        'class' => 'form-control Product-License-No',
                                                        'placeholder' => 'Product License',
                                                        'value' => $licenses['license_no'],
                                                    ));
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            end($productLicense);
                                            if($key == key($productLicense)){ ?>
                                                <button type="button" class="btn btn-success btn-add-license">
                                                    <span>+</span>
                                                </button>
                                            <?php }else{ ?>
                                                <button type="button" class="btn btn-danger btn-remove-license">
                                                    <span>-</span>
                                                </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12 col-md-offset-10">
                        <div class="form-group">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array(
                                'class' => 'btn btn-primary',
                            )); ?>
                            <?php echo CHtml::link('Cancel', array('productInfo/admin'),
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
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/ckeditor/ckeditor.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/ckeditor/config.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js', CClientScript::POS_HEAD);
?>
<script>
    $(function () {
        CKEDITOR.editorConfig = function (config) {
            config.language = 'es';
            config.uiColor = '#F7B42C';
            config.height = 300;
            config.toolbarCanCollapse = true;

        };
        CKEDITOR.replace('ProductInfo_description');
        // valid and submit product-info-form
        $("form[id='product-info-form']").validate({
            debug: true,
            errorClass: "help-block",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            rules:{
                'ProductCategory[category_id]' : {
                    required: true
                },
                'ProductInfo[name]': {
                    required: true
                },
                'ProductInfo[sku]': {
                    required: true,
                    remote: {
                        url: '<?php  echo Yii::app()->createUrl('admin/productInfo/checkSku1');  ?>',
                        type: "post",
                        data: {
                            'ProductInfo[sku]': function () {
                                return $('#ProductInfo_sku').val();
                            },
                            'ProductInfo[id]': function () {
                                return '<?php echo $model->product_id; ?>';
                            }
                        }
                    }
                },
                'ProductInfo[price]': {
                    required: true,
                    number: true
                },
                'ProductInfo[sale_price]': {
                    number: true
                },
                'ProductInfo[short_description]': {
                    required: true
                }
            },
            messages:{
                'ProductCategory[category_id]' : {
                    required: "Please select category"
                },
                'ProductInfo[name]': {
                    required: "Please enter product name username"
                },
                'ProductInfo[sku]': {
                    required: "Please enter product sku",
                    remote: jQuery.validator.format("Sku Already Exist in System")
                },
                'ProductInfo[price]': {
                    required: "Please enter product price",
                    number: "Please enter only numeric value"
                },
                'ProductInfo[sale_price]': {
                    number: "Please enter only numeric value"
                },
                'ProductInfo[short_description]': {
                    required: "Please enter Short Description",
                }

            },
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
                $(element).parent().parent().addClass('has-error');
                //$('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).parent().parent().removeClass('has-error');
            },
            submitHandler:function (form) {
                $(".overlay").removeClass("hide");
                var formData = new FormData($(form)[0]);
                $.ajax({
                    url: '<?php  echo Yii::app()->createUrl('admin/productInfo/update').'/'.$model->product_id;  ?>',
                    type: "post",
                    data: formData, //$(form).serializeArray(),
                    success: function(response) {
                        var Result = JSON.parse(response);
                        if(Result.result == true){
                            /*Product_id = response['productId'];
                             $('#affiliate_tab a').attr('href', '#btabs-alt-static-justified-profile');
                             $('#license_tab a').attr('href', '#btabs-alt-static-justified-settings');
                             $('#affiliate_tab a').removeClass('inactive');
                             $('#license_tab a').removeClass('inactive');
                             $('#ProductAffiliate_pid').val(response['productId']);
                             $('#product_tab').removeClass('active');
                             $('#btabs-alt-static-justified-home').removeClass('active');
                             $('#affiliate_tab').addClass('active');
                             $('#btabs-alt-static-justified-profile').addClass('active');*/
                            $('#productUpdate').show().delay(5000).fadeOut();
                            $(".overlay").addClass("hide");
                            window.scrollTo(0,0);
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            }
        });

        // product affiliate level submit
        $("form[id='affiliateForm']").validate({
            debug: true,
            errorClass: "help-block",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            onclick:false,
            rules:{},
            messages:{},
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
                $(element).parent().parent().addClass('has-error');
                //$('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).parent().parent().removeClass('has-error');
            },
            submitHandler:function (form) {
                var data = $(form).serializeArray();
                $.ajax({
                    url: '<?php  echo Yii::app()->createUrl('admin/productInfo/update').'/'.$model->product_id;  ?>',
                    type: "post",
                    data: data,
                    success: function(response) {
                        var databaseRes = JSON.parse(response);
                        if(databaseRes.result == true){
                            $('#affiliateError').css('display','none');
                            $('#affiliateUpdate').show().delay(5000).fadeOut();
                        }
                    }
                });
            }
        });

        // product affiliate level submit
        $("form[id='licenseForm']").validate({
            debug: true,
            errorClass: "help-block",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            onclick:false,
            rules:{},
            messages:{},
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
                $(element).parent().parent().addClass('has-error');
                //$('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).parent().parent().removeClass('has-error');
            },
            submitHandler:function (form) {

                $.ajax({
                    url: '<?php  echo Yii::app()->createUrl('admin/productInfo/update').'/'.$model->product_id;  ?>',
                    type: "post",
                    data: $(form).serializeArray(),
                    success: function(response) {
                        var databaseRes = JSON.parse(response);
                        if(databaseRes.result == true){
                            $('#licenseError').css('display','none');
                            $('#licenseUpdate').show().delay(5000).fadeOut();
                        }
                    }
                });
            }
        });


        // Upload file preview on Application form
        $("#ProductInfo_image").on("change", function()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) {
                $("#imgPreviewBox").css("display","none");
                return;
            } // no file selected, or no FileReader support
            $("#imgPreviewBox").css("display","none");
            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(e){ // set image data
                    $("#imagePreview").attr('src', e.target.result);
                    $("#imgPreviewBox").css("display","block");
                }
            }
        });
        $("#ProductInfo_sale_start_date").on("change", function()
        {
            $('#ProductInfo_sale_end_date').datepicker({
                dateFormat: 'yy-mm-dd',
                //showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: '1999:2030',
                //showOn: "button",
                //buttonImage: "images/calendar.gif",
                //buttonImageOnly: true,
                minDate: /*new Date(1999, 10 - 1, 25)*/ $("#ProductInfo_sale_start_date").val(),
                maxDate: '+30Y',
                inline: true
            });
        });
    });
</script>