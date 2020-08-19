
<!-- Hero Content -->
<div class="bg-image" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/plugins/img/photos/photo3@2x.jpg.jpg');">
    <div class="bg-primary-dark-op">
        <section class="content content-full content-boxed overflow-hidden">
            <!-- Section Content -->
            <div class="push-30-t push-30 text-center">
                <h1 class="h2 text-white push-10 visibility-hidden" data-toggle="appear" data-class="animated fadeInDown">Events</h1>
            </div>
            <!-- END Section Content -->
        </section>
    </div>
</div>
<!-- Page Content -->
<div class="content bg-white">
    <!-- Calendar and Events functionality (initialized in js/pages/base_comp_calendar.js), for more info and examples you can check out http://fullcalendar.io/ -->
    <div class="row items-push">
        <div class="col-md-12">
            <!-- Calendar Container -->
            <div id="calendar"></div>
        </div>
    </div>
    <!-- END Calendar -->
</div>
<button style="display: none;" id="modal-btn" class="btn btn-default" data-toggle="modal" data-target="#modal-popout" type="button">Launch Modal</button>
<!-- END Page Content -->
<div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul></iframe>
                    <h3 class="block-title">Event Details</h3>
                </div>
                <div class="block-content">

                    <div class="block">
                        <div class="block-content">
                            <table class="table">

                                <tbody>

                                <tr>
                                    <td width="50%" >Event Name</td>
                                    <td id="e_title" width="50%"></td>
                                </tr>
                                <!--<tr>
                                    <td width="50%" >Event Host</td>
                                    <td id="e_host" width="50%"></td>
                                </tr>-->
                                <tr>
                                    <td width="50%" >Event Starts</td>
                                    <td id="e_start" width="50%"></td>
                                </tr>
                                <tr>
                                    <td width="50%" >Event Ends</td>
                                    <td id="e_end" width="50%"></td>
                                </tr>
                                <tr>
                                    <td width="50%" >Event Description</td>
                                    <td id="e_desc" width="50%"></td>
                                </tr>
                                <tr>
                                    <td width="50%" >Event Location</td>
                                    <td id="e_location" width="50%"></td>
                                </tr>
                                <tr>
                                    <td width="50%" >Event Users</td>
                                    <td id="e_users" width="50%"></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    $('#calendar').fullCalendar({ //re-initialize the calendar
        disableDragging : false,
        header: {
            left: 'title',
            center: '',
            right: 'prev,next,today,agendaWeek,month'
        },
        eventClick: function(event) {
            var data = {'event_id' : event._id};
            $.ajax({
                url: "ViewEvent",
                type: "POST",
                data: data,
                success: function (response) {
                    var Result = JSON.parse(response);
                    console.info(Result.token);
                    if (Result.token == 1) {
                        $('#e_title').html(Result.data.title);
                        $('#e_host').html(Result.data.host);
                        $('#e_start').html(Result.data.start);
                        $('#e_end').html(Result.data.end);
                        $('#e_desc').html(Result.data.description);
                        $('#e_location').html(Result.data.location);
                        $('#e_users').html(Result.data.users);
                        $('.eventshow').removeClass('hide');
                        $('.eventloaders').removeClass('hide');
                        $('#modal-btn').click();
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }
            });
            $(this).css('border-color', 'red');

        },
        editable: true,
        events: [
            <?php foreach ($events as $event){
            $invited_user = explode(',',$event->user_id); ?>
            {
                _id : '<?php echo $event->event_id; ?>',
                title: '<?php echo $event->event_title; ?>',
                start:  '<?php echo $event->event_start; ?>',
                end: '<?php if($event->event_type == "regular" || $event->event_type=="specific"){ echo $event->event_start;}else {echo $event->event_end;};?>',
                backgroundColor: '<?php if($event->event_type == "single"){echo "yellow";} if($event->event_type == "regular"){ echo "coral";} if($event->event_type == "specific"){ echo "#92a8d1";} ?>',
                url: false,
                allDay: false
            },
            <?php } ?>
        ],
    });
    $('.close-event').click(function () {
        $('.eventshow').addClass('hide');
        $('.eventloaders').addClass('hide');
    })
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/fullcalendar/moment.min.js', CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/fullcalendar/fullcalendar.min.js', CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/fullcalendar/gcal.min.js', CClientScript::POS_BEGIN);
?>