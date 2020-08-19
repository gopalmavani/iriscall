<?php
/**
 * Created by PhpStorm.
 * User: kushal
 * Date: 30/1/18
 * Time: 4:18 PM
 */
$this->pageTitle = $model->title;

?>


<!-- Page Content -->
<div class="content content-boxed">
    <!-- Main Content -->
    <div class="row">
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Go to list', array('ticketing/admin'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
        <div class="col-lg-12">
            <!-- Social Timeline -->
            <!-- Update 1 -->
            <?php
            $name = '';
            $image = '';
            $sql = "SELECT full_name,image from user_info where user_id = "."'$model->user_id'";
            $result = yii::app()->db->createCommand($sql)->queryAll();
            if(isset($result)) {
                $name = $result[0]['full_name'];
                $image = $result[0]['image'];
            }
            ?>
            <div class="block">
                <div class="block-header">
                    <div class="clearfix">
                        <div class="pull-left push-15-r">
                            <?php if($image == '' || $image == 0){ ?>
                                <img class="img-avatar img-avatar48" src="<?php echo Yii::app()->baseUrl . '/plugins/img/avatars/avatar10.jpg' ?>" alt="">
                            <?php } else { ?>
                                <img class="img-avatar img-avatar48" src="<?php echo Yii::app()->baseUrl . $image ?>" alt="">
                            <?php } ?>
                        </div>
                        <div class="push-5-t">
                            <a class="font-w600" href="javascript:void(0)"><?php echo $name; ?></a><br>
                            <span class="font-s12 text-muted"><?php echo DeleteFolder::time_elapsed_string($model->created_at); ?></span>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <p></p>
                    <?php echo $model->description; ?>
                    <hr>
                </div>
                <div class="block-content block-content-full bg-gray-lighter">
                    <!-- Comments -->
                    <?php
                    $sql = "SELECT * from comment_mapping where ticket_id = "."'$model->ticket_id'";
                    $result = Yii::app()->db->createCommand($sql)->queryAll();
                    if(!empty($result)) {
                        foreach ($result as $key => $comment) {
                            $username = '';
                            $userprofile = '';
                            $usersql = "SELECT full_name,image from user_info where user_id = " . "'$comment[user_id]'";
                            $userresult = Yii::app()->db->createCommand($usersql)->queryAll();
                            $username = $userresult[0]['full_name'];
                            $userprofile = $userresult[0]['image'];
                            ?>
                            <div class="media push-15">
                                <div class="media-left">
                                    <a href="javascript:void(0)">
                                        <?php if ($userprofile == '' || $userprofile == 0) { ?>
                                            <img class="img-avatar img-avatar32"
                                                 src="<?php echo Yii::app()->baseUrl . '/plugins/img/avatars/avatar10.jpg' ?>"
                                                 alt="">
                                        <?php } else { ?>
                                            <img class="img-avatar img-avatar32"
                                                 src="<?php echo Yii::app()->baseUrl . $userprofile ?>" alt="">
                                        <?php } ?>
                                    </a>
                                </div>
                                <div class="media-body font-s13">
                                    <a class="font-w600" href="javascript:void(0)"><?php echo $username; ?></a>
                                    <div class="font-s12">
                                        <span class="text-muted"><em><?php echo DeleteFolder::time_elapsed_string($comment['created_at']); ?></em></span>
                                    </div><br/>
                                    <div class="push-5"><?php echo $comment['comment']; ?></div>
                                    <div class="push-5"><?php
                                        if(!empty($comment['attachment'])) {
                                            $images = json_decode($comment['attachment']);
                                            foreach ($images as $image) {
                                                $ext = array_pop(explode('.',$image));
                                                $ext1 = array_pop(explode('/tickets/',$image));
                                                if($ext == 'jpg' || $ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif'){
                                                    ?>
                                                    <div style="margin-right:5px!important;" class="col-xs-4 image-preview-box-update" id="imgPreviewBox">
                                                        <img src="<?php echo Yii::app()->baseUrl . $image; ?>"
                                                             class="image-preview" id="imagePreview" data-holder-rendered="true">
                                                    </div>
                                                <?php }
                                                else{ ?><div class="col-xs-4">
                                                    <a href="<?php echo Yii::app()->baseUrl.$image; ?>" target="_blank"><img src="<?php echo Yii::app()->baseUrl . '/uploads/tickets/file.png'; ?>" style="max-height: 150px; max-width: 150px;"/><br/><?php echo $ext1;?></a></div>
                                                <?php }
                                            }
                                        }?>
                                    </div><br/>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <!-- END Comments -->

                    <!-- Post Comment -->
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <button class="text-right btn btn-primary" type="submit" name="createBtn" id="btnCreate">Add Comment</button>
                        </div>
                    </div>
                    <!-- END Post Comment -->
                </div>
            </div>
            <!-- END Update 1 -->
        </div>
    </div>
    <!-- END Main Content -->
    <div class="modal fade bd-example-modal-lg" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-md-11">
                        <h3 class="modal-title" align="center">Add Comment</h3>
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
                            <form method="POST" id="comment_modal" action="<?php echo Yii::app()->createUrl('/admin/ticketing/forum')."/".$model->ticket_id ?>" enctype="multipart/form-data">
                                <div class="block-content block-content-narrow">
                                    <div class="col-md-12">
                                        <label>Comment Description: </label><br/>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="comment_description" id="comment_description"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Attachments: </label><br/>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="file" name="images[]" multiple/><br/>
                                    </div>
                                </div>
                                <div class="col-md-12" align="right">
                                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
                                    <p></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->
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
    CKEDITOR.replace('comment_description');


    $('.reply').on('click',function () {
        var str = $(this).attr('id');
        var id  = str.split("_");
        id = id[1];
        $("#form_"+id).removeClass('hide');
        $("#input_"+id).focus();
        return false;
    });
    $("#btnCreate").on("click", function() {
        $('#modal1').modal('show');
    });

    $('#submit').on("click",function(){
        console.info('hii');
        $('#comment_modal').submit();
    });
</script>
