<?php
/* @var $this TicketingController */
/* @var $model Ticketing */
/* @var $form CActiveForm */
?>
<div class="pull-right m-b-10">
    <?php echo CHtml::link('Go to list', array('ticketing/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content block-content-narrow">
                <?php
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'ticketing-form',
                    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'UserCreate'
                    )
                ));
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class=" <?php echo $model->hasErrors('title') ? 'has-error' : ''; ?>">
                            <?php echo $form->textFieldControlGroup($model, 'title', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','autofocus'=>'true')); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class=" <?php echo $model->hasErrors('ticket_detail') ? 'has-error' : ''; ?>">
                            <?php echo $form->textFieldControlGroup($model, 'ticket_detail', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control')); ?>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class=" <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
                            <label class=""> <?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?></label>
                            <?php echo $form->textArea($model,'description', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top:5%">
                        <div class=" <?php echo $model->hasErrors('status') ? 'has-error' : ''; ?>">
                            <?php echo $form->dropDownListControlGroup($model,'status', array('inprogress'=>'In progress', 'done'=>'Done'), array('prompt' => 'Choose', 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group <?php echo $model->hasErrors('attachment') ? 'has-error' : ''; ?>">
                            <label class="" style="margin-left : 4%;margin-bottom:0%;margin-top:5%">
                                <?php echo $form->labelEx($model, 'attachment', array('class' => 'control-label')); ?>
                            </label><br/>
                            <?php if(!empty($model->attachment)) {
                                $images = json_decode($model->attachment);
                                foreach ($images as $image) {
                                    ?>
                                    <div class="col-xs-4 image-preview-box-update" id="imgPreviewBox">
                                        <img src="<?php echo Yii::app()->baseUrl . $image; ?>"
                                             class="image-preview" id="imagePreview" data-holder-rendered="true">
                                    </div>
                                <?php }
                            }?>
                            <?php
                            $this->widget('CMultiFileUpload', array(
                                'model'=>$model,
                                'name' => 'images[]',
                                'attribute'=>'photos',
                                'accept'=>'jpg|gif|png',
                                'denied'=>'File is not allowed',
                                'max'=>10,
                                'htmlOptions' => array( 'multiple' => 'multiple'),
                            ));
                            ?>
                            <div class="help-block" id="imageTypeError"></div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-12" align="right">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
                            'class' => 'btn btn-primary',
                        )); ?>
                        <?php echo CHtml::link('Cancel', array('ticketing/admin'),
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

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/ckeditor.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/config.js', CClientScript::POS_HEAD);
?>

<script>
    CKEDITOR.editorConfig = function (config) {
        config.language = 'es';
        config.uiColor = '#F7B42C';
        config.height = 300;
        config.toolbarCanCollapse = true;

    };
    CKEDITOR.replace('Ticketing_description');

    // Upload file preview on Application form
    $("#Ticketing_attachment").on("change", function()
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