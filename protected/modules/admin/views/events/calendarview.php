<?php
/**
 * Created by PhpStorm.
 * User: kushal
 * Date: 5/3/18
 * Time: 7:18 PM
 */
$this->pageTitle = "Events Calendar View";
?>


<style>
    .fc-icon-left-single-arrow:after {
        content: "\02039";
        font-weight: 700;
        font-size: 150%;
        top: -7%;
    }
    .fc-icon-right-single-arrow:after {
        content: "\0203A";
        font-weight: 700;
        font-size: 150%;
        top: -7%;
    }
    .fc-list-item-title a {
        text-decoration: underline;
        color: #5c90d2;
        outline: 0;
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <?php
        $sql = "SELECT * FROM events";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        if(!empty($result)){ ?>

            <!-- Block Tabs Animated Slide Left -->
            <div class="block">
                <ul class="nav nav-tabs">
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('/admin/events/view'); ?>">All</a>
                    </li>
                    <li class="active">
                        <a href="#">Calendar</a>
                    </li>
                </ul>
            </div>
            <!-- END Block Tabs Animated Slide Left -->

            <!--Begin Calendar view-->
            <!--<h3 class="push">Events Calendar</h3>-->
            <?php  if(!empty($hosts) && Yii::app()->user->role == "admin") { ?>
                <div class="pull-right">
                    <label class="control-label" style="font-size:18px;">Event host</label>
                    <div class="btn-group">
                        <button style="padding-left:5px!important;margin-bottom:5px;margin-left:5px;" class="btn btn-default btn-image dropdown-toggle" data-toggle="dropdown" type="button">
                            <span><?php if(isset($selectedhost)){ echo $selectedhost; }else { echo "All"; } ?></span>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" style="min-width:100px!important;">
                            <li><a href="<?php echo Yii::app()->createUrl("/admin/events/calendarview"); ?>">All</a></li>
                            <?php foreach ($hosts as $key=>$value) {
                                if($value['event_host'] != ""){?>
                                    <?php $url =  Yii::app()->createUrl("/admin/events/eventhosts/")."/".$value['event_host']; ?>
                                    <li><a tabindex="-1" href="<?php echo $url; ?>"><?php echo $value['full_name']; ?></a></li>
                                <?php }
                            } ?>
                        </ul>
                    </div>
                    <p></p>
                </div>
            <?php } ?>


            <div class="row" style="margin-bottom: 30px;">
                <div class="row" style="margin-bottom: 30px; margin-left: 5px">
                    <aside class="col-lg-12 col-md-12" id="rightPanel">
                        <?php $this->widget('ext.fullcalendar.EFullCalendarHeart', array(
                            //'themeCssFile'=>'cupertino/jquery-ui.min.css',
                            'options' => array(
                                'header' => array(
                                    'right' => 'prev,next,today',
                                    'center' => 'title',
                                    'left' => 'month,agendaWeek,agendaDay,listWeek'
                                ),
                                'events' => $events,
                                'eventClick' => 'js:function(event){
                           window.location.href = "eventview/" + event.id;
                            if (!$("#DeletePanel").hasClass("hide")) {
                                
                            }else{ 
                                
                                $("#updateLabel").addClass("hide");
                                $("#updateform").removeClass("hide");
                                
                                $("#update_title").attr("value", event.title);
                                $("#update_start").attr("value", event.start.format("YYYY-MM-DD"));
                                $("#update_end").attr("value",  event.end.format("YYYY-MM-DD"));
                                $("#update_user_list").attr("value",  event.end.format("YYYY-MM-DD"));
                            }
                        }',
                                'eventDrop' => 'js:function(event, delta, revertFunc) {
                                        var startDate = event.start.format("YYYY-MM-DD"),
                                        endDate = event.start.format("YYYY-MM-DD"),
                                        params = {"from":startDate, "to":endDate, "title":event.title};
                                            if (confirm("Are you sure about this change?")) {
                                                $.ajax({
                                                    url: "UpdateEvent",
                                                    type: "POST",
                                                    data: params,
                                                    success: function (response) {
                                                        
                                                    },
                                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                    
                                                    }
                                                });
                                            }else{
                                                revertFunc();
                                            }
                        }',
                                'startEditable' => true,
                                'dayClick' => "js:function(date, allDay, jsEvent, view) {
                            $(\"#AddPanel\").removeClass(\"hide\");
                            var cur_time = new Date();
                            var check = date.format();
                            var today = moment(cur_time).format(\"YYYY-MM-DD\");
                            
                            if(check >= today){
                                var currentTime = new Date($.now()); 
                                var retVal = formatAMPM(currentTime);
                                //console.info(retVal); return false;
                                //var cur_time = currentTime.getHours() +':'+ (currentTime.getMinutes()<10?'0':'') + currentTime.getMinutes() +':'+ (currentTime.getSeconds()<10?'0':'') + currentTime.getSeconds();
                                $('#leftPanel').slideDown('slow');
                                $('#event_title').val('');
                                $('#event_start').val(date.format('MM/DD/YYYY') + ' ' + retVal );
                                $('#event_end').val('');
                                $('#user_list').val('');
                            }
                        }",
                                'defaultDate' =>  date('Y-m-d'),
                                'navLinks' => true, // can click day/week names to navigate views
                                'editable' => true,
                                'eventLimit' => true, // allow "more" link when too many events
                                'defaultView' => 'listWeek',
                                'selectable' => true,   //permite sa selectezi mai multe zile
                                'selectHelper' => true,  //coloreaza selctia ta
                            )));

                        ?>
                    </aside>
                </div>
            </div>
            <!--End calender view-->
        <?php } ?>
    </div>
</div>


<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/fullcalendar/moment.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/fullcalendar/fullcalendar.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/js/plugins/fullcalendar/gcal.min.js', CClientScript::POS_END);
?>

<script>
    $('#host').on("change",function () {
        var host = $('#host').val();
        console.info(host);
        var url = "<?php echo Yii::app()->createUrl("/admin/events/eventhosts"); ?>";
        $.ajax({
            url: "<?php echo Yii::app()->createUrl("/admin/events/eventhosts"); ?>",
            type: "POST",
            data: {'event_host': host},
            success: function (response) {
                window.location.href = url;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    });
</script>
