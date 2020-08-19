<?php
/**
 * Created by PhpStorm.
 * User: kushal
 * Date: 1/2/18
 * Time: 4:46 PM
 */
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h5 class="modal-title" id="exampleModalLabel"><b>Create Jira issue</b></h5>
</div>

<div class="modal-body">
    <form id="createjiraissue" method="POST" action="<?php echo Yii::app()->createUrl('/admin/ticketing/createjiraissue'); ?>" enctype="multipart/form-data">
        <input name="ticketid" value="<?php echo $model->ticket_id ?>" hidden>
        <div class="form-group">
            <label class="control-label">Project*</label>
            <div>
                <input type="text" class="form-control" name="project_name" value="<?php echo Yii::app()->params['applicationName']; ?>" readonly>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">Issue Type*</label>
            <div>
                <input type="text" class="form-control" name="issue_type" value="Task" readonly>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">Ticket Detail*</label>
            <div>
                <input type="text" id="summary" class="form-control" name="summary" value="<?php echo $model->ticket_detail; ?>">
                <span class="help-block hide" id="ticketerror">Please enter ticket detail.</span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">Due date*</label>
            <div>
                <input type="date" id="duedate" class="form-control datefield" name="duedate">
                <span class="help-block hide" id="duedateerror">Please enter due date.</span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">Description</label>
            <div>
                <textarea name="description" id="description"><?php echo $model->description; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">Attachment</label>
            <input type="file" name="images[]" multiple>
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
            <br /><br /><br /><br /><br /><br /><br />
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel">Cancel</button>
            <button type="submit" id="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>






<script>
    CKEDITOR.editorConfig = function (config) {
        config.language = 'es';
        config.uiColor = '#F7B42C';
        config.height = 300;
        config.toolbarCanCollapse = true;

    };
    CKEDITOR.replace('description');

    $(".datefield").datepicker({
        format : "yyyy-mm-dd",
        autoclose : true
    });

    $("body").on("click","#submit",function () {
        $("#cancel").attr("disabled","disabled");
        $("#submit").attr("disabled","disabled");
        $("#createjiraissue").submit();
    });

</script>