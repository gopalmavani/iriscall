<?php
$this->pageTitle = 'Save credentials';
$model = Settings::model()->findByAttributes(['module_name' => "Facebook Feed", 'settings_key' => "clientId"]);
$model1 = Settings::model()->findByAttributes(['module_name' => "Facebook Feed", 'settings_key' => "clientSecretId"]);
$model2 = Settings::model()->findByAttributes(['module_name' => "Facebook Feed", 'settings_key' => "pageId"]);
?>
<div class="row">
    <div class="block">
        <form id="sync-fb-form" method="POST" action="<?php echo Yii::app()->createUrl('/admin/fbFeed/saveCredentials');?>">
            <div class="block-content block-content-narrow">
                <div class="col-md-12" id="c_id">
                    <label class="control-label">Client Id: </label><br/>
                    <input class="form-control" type="text" name="clientId" id="clientId" value="<?php if($model != null){echo $model->value;}?>"/>
                    <p class="hide" id="c_error" style="color: #d26a5c">Please enter client id</p><br/>
                </div>
                <div class="col-md-12" id="cs_id">
                    <label class="control-label">Client secret Id: </label><br/>
                    <input class="form-control" type="text" name="clientSecretId" id="clientSecretId" value="<?php if($model != null){ echo $model1->value;}?>"/>
                    <p class="hide" id="cs_error" style="color: #d26a5c">Please enter client secret id</p><br/>
                </div>
                <div class="col-md-12" id="p_id">
                    <label class="control-label">Page Id: </label><br/>
                    <input class="form-control" type="text" name="pageId" id="pageId" value="<?php if($model != null){ echo $model2->value;}?>"/>
                    <p class="hide" id="p_error" style="color: #d26a5c">Please enter page id</p><br/>
                </div>
            </div>
            <div class="col-md-12" align="right">
                <button id="submit" type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default">Cancel</button>
                <p></p>
            </div>
        </form>
    </div>
</div>
<script>
    $("#submit").on("click" , function () {
        var x = document.getElementById("clientId").value;
        var y = document.getElementById("clientSecretId").value;
        var z = document.getElementById("pageId").value;
        if(x == ""){
            $("#c_id").addClass('has-error');
            $("#c_error").removeClass('hide');
        }if(y == ""){
            $("#cs_id").addClass('has-error');
            $("#cs_error").removeClass('hide');
        }if(z == ""){
            $("#p_id").addClass('has-error');
            $("#p_error").removeClass('hide');
        }
        if(x == "" || y == "" ||z == ""){
            return false;
        }
    });
</script>
