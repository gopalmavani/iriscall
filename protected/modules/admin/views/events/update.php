<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */

$this->pageTitle = 'Update Event';
?>
<style>
    .pac-container:after {
        /* Disclaimer: not needed to show 'powered by Google' if also a Google Map is shown */

        background-image: none !important;
        height: 0px;
    }
</style>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-12">
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Go to list', array('Events/view'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="block">
            <div class="block-content tab-content">
                <div class="tab-pane active" id="btabs-alt-static-justified-home">
                    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'=>'event-form',
                        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                        'enableAjaxValidation'=>false,
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'name' => 'event-form',
                        ),
                    )); ?>
                    <div class="row">
                        <div class="form-material has-success">
                            <p id="eventUpdateSuccess" class="help-block " style="display: none;">Event updated successfully</p>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('event_title') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'event_title', array('size' => 50, 'maxlength' => 50, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Event Title')); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('event_description') ? 'has-error' : ''; ?> ">
                                    <label class="">
                                        <?php echo $form->labelEx($model, 'event_description', array('class' => 'control-label')); ?>
                                    </label>
                                    <?php echo $form->textArea($model, 'event_description', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Event Description')); ?>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label id="check_box">Select all users &nbsp<input type="checkbox" id="all_user"></label>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12"id="user">
                                    <?php
                                    $usersList = CHtml::listData(UserInfo::model()->findAll(["order" => "full_name"]), "user_id",
                                        function ($data){
                                            return "{$data->first_name}  {$data->last_name}";
                                        });
                                    echo $form->dropDownListControlGroup($model, "user_id", $usersList, [
                                        "prompt" => "Select User",
                                        "class" => "js-select2-multiple form-control",
                                        "multiple" => "multiple"
                                    ]);
                                    ?>
                                    <div class="help-block" id="user_msg"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('event_host') ? 'has-error' : ''; ?>">
                                    <?php
                                    $usersList = CHtml::listData(UserInfo::model()->findAll(["order" => "full_name"]), "user_id",
                                        function ($data){
                                            return "{$data->first_name}  {$data->last_name}";
                                        });
                                    echo $form->dropDownListControlGroup($model, "event_host", $usersList, [
                                        "prompt" => "Select Host",
                                        "class" => "js-select2 form-control",
                                    ]);
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('event_location') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'event_location', array('size' => 255, 'maxlength' => 255, 'autofocus' => 'on','id' => 'event_location','class' => 'form-control', 'placeholder' => 'Event Location')); ?>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group <?php echo $model->hasErrors('event_image') ? 'has-error' : ''; ?>">
                                    <label class="">
                                        <?php echo $form->labelEx($model, 'event_image', array('class' => 'control-label')); ?>
                                    </label><br/>
                                    <?php if(!empty($model->event_image)) { ?>
                                        <div class="col-xs-4 m-b-10 image-preview-box-update"  id="imgPreviewBox" >
                                            <img src="<?php echo Yii::app()->baseUrl . $model->event_image; ?>" class="image-preview" id="imagePreview" data-holder-rendered="true" >
                                        </div>
                                        <?php echo $form->fileField($model, 'event_image', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Event Image')); ?>
                                    <?php }else{ ?>
                                        <div class="col-xs-4 m-b-10 image-preview-box" id="imgPreviewBox">
                                            <img src="<?php echo Yii::app()->baseUrl . $model->event_image; ?>" class="image-preview" id="imagePreview" data-holder-rendered="true" >
                                        </div><br/>
                                        <?php echo $form->fileField($model, 'event_image', array('autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Event Image')); ?>
                                        <div class="help-block" id="imageTypeError"></div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group <?php echo $model->hasErrors('event_url') ? 'has-error' : ''; ?>">
                                    <?php echo $form->textFieldControlGroup($model, 'event_url', array('size' => 255, 'maxlength' => 255, 'autofocus' => 'on', 'class' => 'form-control', 'placeholder' => 'Event Url')); ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="event_start">Start Time <span class="required" aria-required="true">*</span></label>
                                </div>
                                <div class="col-md-12">
                                    <div class='input-group date' id='event_start'>
                                        <input type='text' class="form-control"  name="Events[event_start]" value="<?php echo date('m/d/Y h:i A',strtotime(str_replace('/','-',$model->event_start))) ?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="event_end">End Time</label>
                                </div>
                                <div class="col-md-12">
                                    <div class='input-group date' id='event_end'>
                                        <input type='text' class="form-control" name="Events[event_end]" value="<?php echo date('m/d/Y h:i A',strtotime(str_replace('/','-',$model->event_end))) ?>" />
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <h3>Ticket Details</h3>
                            <div class="col-md-6">

                                <!--begin booking start date-->
                                <div class="form-group" id="bookingstartdate" style="margin-top:10%">
                                    <div class="col-md-12">
                                        <label for="booking_start">Booking start date </label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class='input-group date' id='booking_start_date'>
                                            <input type='text' class="form-control" name="Events[booking_start_date]" value="<?php echo date('m/d/Y h:i A',strtotime(str_replace('/','-',$model->booking_start_date))) ?>" />
                                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <!--End booking start date-->

                                <!--begin total ticketing-->
                                <div class="col-md-12" style="margin-top:3%">
                                    <div class="form-group <?php echo $model->hasErrors('total_tickets') ? 'has-error' : ''; ?>">
                                        <?php echo $form->textFieldControlGroup($model, 'total_tickets', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Total number of tickets','value'=>$model->total_tickets)); ?>
                                    </div>
                                </div>
                                <!--end total ticketing-->

                                <!--begin max_num_bookings-->
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('max_num_bookings') ? 'has-error' : ''; ?>">
                                        <?php echo $form->textFieldControlGroup($model, 'max_num_bookings', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Max number of bookings per person','value'=>$model->max_num_bookings)); ?>
                                    </div>
                                </div>
                                <!--end max_num_bookings-->

                                <!--begin price-->
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('price') ? 'has-error' : ''; ?>">
                                        <?php echo $form->textFieldControlGroup($model, 'price', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'price per ticket','value'=>$model->price)); ?>
                                    </div>
                                </div>
                                <!--end price-->

                            </div>
                            <div class="col-md-6" style="margin-top:40px">
                                <!--begin coupon code-->
                                <div class="col-md-12">
                                    <div class="form-group <?php echo $model->hasErrors('coupon_code') ? 'has-error' : ''; ?>">
                                        <?php echo $form->textFieldControlGroup($model, 'coupon_code', array('size' => 50, 'maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Coupon code')); ?>
                                    </div>
                                </div>
                                <!--end coupon code-->

                                <!--begin coupon start date-->
                                <div class="form-group" id="couponstartdate" style="margin-top:95px;">
                                    <div class="col-md-12">
                                        <label for="event_end">Coupon start date </label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class='input-group date' id='coupon_start_date'>
                                            <input type='text' class="form-control" name="Events[coupon_start_date]" value="<?php echo date('m/d/Y h:i A',strtotime(str_replace('/','-',$model->coupon_start_date))) ?>" />
                                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <!--End coupong start date-->


                                <!--begin booking coupon end date-->
                                <div class="form-group" id="couponenddate" style="margin-top:22px;">
                                    <div class="col-md-12">
                                        <label for="event_end">Coupon end date </label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class='input-group date' id='coupon_end_date'>
                                            <input type='text' class="form-control" name="Events[coupon_end_date]" value="<?php echo date('m/d/Y h:i A',strtotime(str_replace('/','-',$model->coupon_end_date))) ?>" />
                                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <!--end  coupon end date-->
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <label>Apply this chages to all events of this group &nbsp;&nbsp;<input type="checkbox" name="Events[applyall]" id="applyall"></label>
    </div>
    <div class="col-md-12" align="right">
        <div class="form-group">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array(
                'class' => 'btn btn-primary',
                'id' => 'submit_button',
            )); ?>
            <?php echo CHtml::link('Cancel', array('events/view'),
                array(
                    'class' => 'btn btn-default'
                )
            );
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/ckeditor.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/config.js', CClientScript::POS_HEAD);
?>
<script src="<?php echo Yii::app()->createUrl('../'); ?>/plugins/js/plugins/bootstrap-datetimepicker/moment.min.js"></script>
<script src="<?php echo Yii::app()->createUrl('../'); ?>/plugins/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
<script src="<?php echo Yii::app()->createUrl('../'); ?>/plugins/js/select2.min.js"></script>
<script src="<?php echo Yii::app()->createUrl('../'); ?>/plugins/js/core/jquery.slimscroll.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?&libraries=places&key=AIzaSyBU1sstLYM9RgAjxmJE7bLNZxEiisiDnJI"></script>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/jquery.geocomplete.js"></script>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/logger.js"></script>
<script>

    CKEDITOR.editorConfig = function (config) {
        config.language = 'es';
        config.uiColor = '#F7B42C';
        config.height = 300;
        config.toolbarCanCollapse = true;

    };
    CKEDITOR.replace('Events_event_description');

    jQuery(function () {
        App.initHelpers(['datetimepicker']);
        App.initHelpers('slimscroll');
    });
    $(".select2Search").select2();

    $(function () {

    });

    $(document).ready(function () {
        $('.js-select2-multiple').select2();
        //$('#Events_event_host').val(<?php echo $model->event_host; ?>).trigger('change');
        if("<?php echo $model->user_id; ?>" == 'all'){
            $("#all_user").prop('checked', true);
            $("#Events_user_id").prop('disabled', true);
        }
        else{
            $('#Events_user_id').val([<?php echo $model->user_id; ?>]).trigger('change');
        }

        $('.select2-container').css('width', '271px');
        /* initialize the external events*/
        /* initialize the calendar*/
        $('#external-events .fc-event').each(function () {
            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
    });

    $('#all_user').change(function(){
        if($("#all_user").is(':checked') ){
            $("#Events_user_id").prop('disabled', true);
            $('#Events_user_id').val('all');
        }else{
            $("#Events_user_id").prop('disabled', false);
        }

    });


    $(function () {
        $("#event_start").datetimepicker({
//            minDate: new Date()
        });

        $('#event_end').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#event_start").on("dp.change", function (e) {
            $('#event_end').data("DateTimePicker").minDate(e.date);
        });
        $("#event_end").on("dp.change", function (e) {
            $('#event_start').data("DateTimePicker").maxDate(e.date);
        });

        $('#booking_start_date').datetimepicker({
//            minDate: new Date()
        });
        $('#coupon_start_date').datetimepicker({
//            minDate: new Date()
        });
        $('#coupon_end_date').datetimepicker({
//            minDate: new Date()
        });

    });
    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
    $(function () {
        $("form[id='event-form']").validate({
            debug: true,
            errorClass: "help-block",
            errorElement: "div",
            onfocusout: false,
            onkeyup: false,
            rules: {
            },
            messages: {
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

                $.ajax({
                    success: function(response) {
                        var Result = JSON.parse(response);
                        if(Result.result == true){
                            $('#eventUpdateSuccess').show().delay(5000).fadeOut();
                        }
                    },
                });

            }
        });
    });
    $(function(){
        $("#event_location").geocomplete()
            .bind("geocode:result", function(event, result){
                $.log("Result: " + result.formatted_address);
            })
            .bind("geocode:error", function(event, status){
                $.log("ERROR: " + status);
            })
            .bind("geocode:multiple", function(event, results){
                $.log("Multiple: " + results.length + " results found");
            });
    });
</script>
