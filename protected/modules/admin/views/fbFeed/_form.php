<?php
?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('fbFeed/index'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'fb-updates-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'fbFeed-form',
                    )
                )); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('title') ? 'has-error' : ''; ?>">
                                <label class=control-label"><?php echo $form->labelEx($model, 'title'); ?></label>
                                <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control', 'placeholder' => 'Title')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
                                <label
                                        class="control-label"><?php echo $form->labelEx($model, 'description'); ?></label>
                                <?php echo $form->textField($model, 'description', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Description')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('is_enabled') ? 'has-error' : ''; ?>"><label class="control-label"><?php echo $form->labelEx($model, 'is_enabled'); ?></label>
                                <?php echo $form->dropDownList($model, 'is_enabled', [1 =>'Yes', 0=> 'No' ],['class' => 'form-control']);?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="col-md-8 <?php echo $model->hasErrors('image_url') ? 'has-error' : ''; ?>">
                                <label class="control-label">
                                    <?php echo $form->labelEx($model, 'image_url', array('class' => 'control-label')); ?>
                                </label><br/>
                                <?php if(!empty($model->image_url)) { ?>
                                    <div class="col-xs-4 m-b-10 image-preview-box-update"  id="imgPreviewBox" >
                                        <img src="<?php echo Yii::app()->baseUrl . $model->image_url; ?>" class="image-preview" id="imagePreview" data-holder-rendered="true" >
                                    </div>
                                    <?php echo $form->fileField($model, 'image_url', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Image')); ?>
                                <?php }else{ ?>
                                    <div class="col-xs-4 m-b-10 image-preview-box" id="imgPreviewBox">
                                        <img src="<?php echo Yii::app()->baseUrl . $model->image_url; ?>" class="image-preview" id="imagePreview" data-holder-rendered="true" >
                                    </div><br/>
                                    <?php echo $form->fileField($model, 'image_url', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Image')); ?>
                                    <div class="help-block" id="imageTypeError"></div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group col-md-12" align="right">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
            'class' => 'btn btn-primary col-md-offset-2',
            'id' => 'create_fb'
        )); ?>
        <?php echo CHtml::link('Cancel', array('fbFeed/Index'),
            array(
                'class' => 'btn btn-default'
            )
        );
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    $(function () {
        $("form[id='fb-updates-form']").validate({
            debug: true,
            errorClass: "help-block",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            rules: {
                'FbFeed[title]': {
                    required: true
                },
                'FbFeed[description]': {
                    required: true
                },
            },
            messages: {
                'FbFeed[title]': {
                    required: "Please enter title"
                },
                'FbFeed[description]': {
                    required: "Please enter description"
                }
            },
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
                $(element).parent().parent().addClass('has-error');
                //$('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).parent().parent().removeClass('has-error');
            },
            submitHandler:function (form) {
                form.submit();
            }
        });
    });

    $("#FbFeed_image_url").on("change", function()
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
</script>
