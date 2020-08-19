<?php
/**
 * Created by PhpStorm.
 * User: imyuvii
 * Date: 01/03/17
 * Time: 6:00 PM
 */
/* @var $this SiteController */

$this->pageTitle = "My Tickets";
$this->breadcrumbs = array(
    'Ticket',
    'View Ticket',
);
?>

<div class="bg-image" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/plugins/img/photos/photo3@2x.jpg.jpg');">
    <div class="bg-primary-dark-op">
        <section class="content content-full content-boxed overflow-hidden">
            <!-- Section Content -->
            <div class="push-30-t push-30 text-center">
                <h1 class="h2 text-white push-10 animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">Tickets</h1>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</div>

<div class="block" style="margin-bottom:0px;">
    <div class="block-header bg-gray-lighter">
        <div class="col-md-10">
            <h3 class="block-title">My Tickets</h3>
        </div>
        <div class="col-md-2" align="right">
            <button class="text-right btn btn-primary" type="submit" name="createBtn" id="btnCreate">Create</button>
            <p></p>
        </div>
    </div>
    <section class="content content-boxed">
        <div class="block-content">
            <?php
            if ($model) {
                ?>
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>

                    <tr>
                        <th class="text-center" style="width: 50px;">Ticket-ID</th>
                        <th class="text-center" style="width: 150px;">Title</th>
                        <th class="text-center" style="width: 100px;">Status</th>
                        <th class="text-center" style="width: 100px;">Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php
                    foreach ($model as $model) {
                        ?>
                        <tr>
                            <td class="text-center">
                                <strong><?php echo $model['ticket_id']; ?></strong>
                            </td>
                            <td class="text-center"><strong><?php echo $model['title']; ?></strong></td>
                            <td class="text-center">
                                <?php
                                if ($model['status'] == 'done') { ?>

                                    <span class="label label-success">Success</span>

                                <?php } elseif($model['status'] == 'inprogress') { ?>

                                    <span class="label label-danger">In Progress</span>

                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="<?php echo Yii::app()->createUrl('ticketing/detail/' . $model['ticket_id']); ?>"
                                       data-toggle="tooltip" title="View" class="btn btn-default"><i class="fa fa-comments"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php  }
            else{ ?>
                <table class="table table-borderless table-striped table-vcenter">
                    <tr>
                        <td class="text-center">

                        </td>
                        <td class="hidden-xs text-center"></td>
                        <td width="15%" class="text-right">No records found!</td>
                        <td class="text-right hidden-xs">
                            <strong></strong>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">

                            </div>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-11">
                    <h3 class="modal-title" align="center">Create Ticket</h3>
                </div>
                <div class="col-md-1">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="block">
                        <div class="block-content block-content-narrow">
                            <?php
                            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                'id'=>'ticketing-form',
                                'action' => Yii::app()->createUrl('/ticketing/create'),
                                'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                                'enableAjaxValidation' => false,
                                'htmlOptions' => array(
                                    'enctype' => 'multipart/form-data',
                                    'name' => 'UserCreate'
                                )
                            ));
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class=" <?php echo $model2->hasErrors('title') ? 'has-error' : ''; ?>">
                                        <?php echo $form->textFieldControlGroup($model2, 'title', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control','autofocus'=>'true')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class=" <?php echo $model2->hasErrors('description') ? 'has-error' : ''; ?>">
                                        <label class=""> <?php echo $form->labelEx($model2, 'description', array('class' => 'control-label')); ?></label>
                                        <?php echo $form->textArea($model2,'description', array('class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="<?php echo $model2->hasErrors('attachment') ? 'has-error' : ''; ?>">
                                        <label class=""><?php echo $form->labelEx($model2,'attachment', array('class' => 'control-label')); ?>
                                        </label><br/>
                                        <?php if(!empty($model2->attachment)) {
                                            $images = json_decode($model2->attachment);
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
                                            'model'=>$model2,
                                            'name' => 'images[]',
                                            'attribute'=>'photos',
                                            'accept'=>'jpg|gif|png',
                                            'denied'=>'File is not allowed',
                                            'max'=>10,
                                            'htmlOptions' => array( 'multiple' => 'multiple'),
                                        ));
                                        ?>
                                    </div>
                                    <div class="help-block" id="imageTypeError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" align="right">
                            <?php echo CHtml::submitButton($model2->isNewRecord ? 'Create' : 'Save', array(
                                'class' => 'btn btn-primary',
                            )); ?>
                            <?php echo CHtml::link('Cancel', array('ticketing/admin'),
                                array(
                                    'class' => 'btn btn-default'
                                )
                            );
                            ?>
                        </div><br/>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
<!-- END All Tickets -->
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/ckeditor.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/config.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/jquery-validation/jquery.validate.min.js', CClientScript::POS_END);

?>
<script>
    CKEDITOR.editorConfig = function (config) {
        config.language = 'es';
        config.uiColor = '#F7B42C';
        config.height = 300;
        config.toolbarCanCollapse = true;

    };
    CKEDITOR.replace('Ticketing_description');

    $(function () {
        $("form[id='ticketing-form']").validate({
            debug: true,
            errorClass: "help-block",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            rules: {
                'Ticketing[title]': {
                    required: true
                },
            },
            messages: {
                'Ticketing[title]': {
                    required: "Please enter title"
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

    $("#btnCreate").on("click", function() {
        $('#modal1').modal('show');
    });
</script>
