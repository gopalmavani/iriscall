<?php
/* @var $this NotificationManagerController */
/* @var $model NotificationManager */
?>
<style>

    .notice {
        position: relative;
        margin: 1em;
        background: #F9F9F9;
        padding: 1em 1em 1em 2em;
        border-left: 4px solid #DDD;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.125);
    }

    .notice:before {
        position: absolute;
        top: 50%;
        margin-top: -17px;
        left: -17px;
        background-color: #DDD;
        color: #FFF;
        width: 30px;
        height: 30px;
        border-radius: 100%;
        text-align: center;
        line-height: 30px;
        font-weight: bold;
        font-family: Georgia;
        text-shadow: 1px 1px rgba(0, 0, 0, 0.5);
    }
    .title{
        display: inline-flex;
    }
</style>

<div class="row">
	<div class="col-lg-12">
		<!-- Activity Timeline -->
		<div class="block-header bg-primary">
			<h3 class="block-title">Notifications</h3>
		</div>
		<div class="block">
			<div class="block-content">
                <div class="row">
                <?php
                if($notifications) {
                    foreach ($notifications as $notification) {
                        ?>
                        <div class="notice col-md-12" style="width:97%;">
                            <div class="col-md-11">
                                <a href="<?= $notification->url; ?>">
                                    <div class="font-w600"><?= $notification->title_html; ?></div>
                                </a><!--</div>-->
                                <div><?= $notification->body_html; ?></div>
                                <div>
                                    <small
                                        class="text-muted"><?php echo NotificationHelper::time_elapsed_string($notification->created_at); ?></small>
                                </div>
                            </div>
                            <div class="col-md-1" style="margin-top: 20px;">
                                <a href="javascript:void(0);"><i class="fa fa-times delete"
                                                                 id="notify_<?= $notification->id; ?>"></i></a>
                            </div>
                        </div>
                    <?php }
                }else{?>
                    <div class="notice col-md-12" style=" width:97%;">
                        <div class="col-md-7 pull-right">
                            <b>No notification</b>
                        </div>
                    </div>
                <?php } ?>
                    </div>
			</div>
		</div>
		<!-- END Activity Timeline -->
	</div>
</div>

<script>
    $(".delete").on('click',function () {
        var attrId = $(this).attr('id');
        var id = attrId.split('_');
        $.ajax({
            url: "<?= Yii::app()->createUrl('admin/notificationManager/Delete')?>",
            type: "POST",
            data:{'id' : id},
            success: function (response) {
                var Result = JSON.parse(response);
                if (Result.token == 1){
                    window.location.reload();
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    });



</script>