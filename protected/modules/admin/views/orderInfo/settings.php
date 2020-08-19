<?php
/**
 * Created by PhpStorm.
 * User: kushal
 * Date: 9/2/18
 * Time: 6:23 PM
 */
$this->PageTitle = "Order Settings";
$firstsql = "SELECT value from settings where module_name = 'order_email' and settings_key = 'email_permission'";
$result = Yii::app()->db->createCommand($firstsql)->queryAll();
if(!empty($result)){
    $enabled = $result[0]['value'];
}
?>

<form method="POST" action="<?php echo Yii::app()->createUrl('/admin/OrderInfo/settings'); ?>">
    <div class="row">
        <div class="form-group">
            <div class="checkbox">
                <label for="example-checkbox1">
                    <h4>Enable invoice email to users</h4>
                    <div style="margin-left:10%;margin-top:5%">
                    <input type="checkbox" name="email" id="email" value="enabled" <?php if(isset($enabled)){ if($enabled == "enabled"){ echo "checked";};} ?>>Enable
                    <input type="text" name="hidden_email" id="hidden_email" value="<?php if(isset($enabled)){ echo $enabled;} ?>" hidden>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group" align="right">
        <input type="submit" value="Save" class="btn btn-primary">
        <button type="reset" onclick="history.go(-1);"  class="btn btn-default">Cancel</button>
    </div>
</form>

<script>
    $('#email').on("change",function(){
        if($("#email").prop('checked') == true){
            $('#hidden_email').val('enabled');
        }
        else{
            $('#hidden_email').val('disabled');
        }

    });
</script>