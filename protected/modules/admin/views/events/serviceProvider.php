<?php
/* @var $this EventsController */
/* @var $model ServiceProvider */
/* @var $form CActiveForm */

$this->pageTitle = 'Service Provider';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'ServiceProvider-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'UserCreate'
                    )
                ));
                ?>
                <?php echo $form->errorSummary($model); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class=" <?php echo $model->hasErrors('name') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'name', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    <span class="help-block"><?php echo $form->error($model, 'name'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="<?php echo $model->hasErrors('description') ? 'has-error' : ''; ?> ">
                                    <label><?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?></label>
                                    <?php echo $form->textArea($model, 'description', array('autofocus' => 'on', 'class' => 'js-summernote form-control', 'placeholder' => 'Event Description')); ?>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class=" <?php echo $model->hasErrors('email') ? 'has-error' : ''; ?>">
                                    <?php echo $form->emailFieldControlGroup($model, 'email', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    <span class="help-block"><?php echo $form->error($model, 'email'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class=" <?php echo $model->hasErrors('phone_no') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'phone_no', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    <span class="help-block"><?php echo $form->error($model, 'phone_no'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-top:5%">
                                <div class="<?php echo $model->hasErrors('image') ? 'has-error' : ''; ?>">
                                    <label class="">
                                        <?php echo $form->labelEx($model, 'image', array('class' => 'control-label')); ?>
                                    </label><br/>
                                    <?php if(!empty($model->image)) { ?>
                                        <div class="col-xs-4 m-b-10 image-preview-box-update"  id="imgPreviewBox" >
                                            <img src="<?php echo Yii::app()->baseUrl . $model->image; ?>" class="image-preview" id="imagePreview" data-holder-rendered="true" >
                                        </div>
                                        <?php echo $form->fileField($model, 'image', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Service Provider Image')); ?>
                                    <?php }else{ ?>
                                        <div class="col-xs-4 m-b-10 image-preview-box" id="imgPreviewBox">
                                            <img src="<?php echo Yii::app()->baseUrl . $model->image; ?>" class="image-preview" id="imagePreview" data-holder-rendered="true" >
                                        </div><br/>
                                        <?php echo $form->fileField($model, 'image', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Service Provider Image')); ?>
                                        <div class="help-block" id="imageTypeError"></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class=" <?php echo $model->hasErrors('no_of_clients_sametime') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'no_of_clients_sametime', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>
                                    <span class="help-block"><?php echo $form->error($model, 'no_of_clients_sametime'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12" align="right">
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                                'class' => 'btn btn-primary',
                            )); ?>
                            <?php echo CHtml::link('Cancel', array('provider/admin'),
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/ckeditor.js', CClientScript::POS_HEAD);
?>

<script>
    CKEDITOR.editorConfig = function (config) {
        config.language = 'es';
        config.uiColor = '#F7B42C';
        config.height = 300;
        config.toolbarCanCollapse = true;

    };
    CKEDITOR.replace('ServiceProvider_description');

    // Upload file preview on Application form
    $("#ServiceProvider_image").on("change", function()
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