<?php
/**
 * Created by PhpStorm.
 * User: kushal
 * Date: 9/2/18
 * Time: 6:23 PM
 */
$this->PageTitle = "Event Settings";
$firstsql = "SELECT value from settings where module_name = 'events' and settings_key = 'event_email_permission'";
$result = Yii::app()->db->createCommand($firstsql)->queryAll();
if(!empty($result)){
    $enabled = $result[0]['value'];
}

$firstsql1 = "SELECT * from settings where module_name='events' and settings_key = 'event_host_role'";
$result1 = Yii::app()->db->createCommand($firstsql1)->queryAll();
$rolevalue = "";
if(!empty($result1)){
    $rolevalue = $result1[0]['value'];
}

?>

<form method="POST" action="<?php echo Yii::app()->createUrl('/admin/events/settings'); ?>">
    <?php if(Yii::app()->user->role == "admin"){ ?>
        <div class="row">
            <div class="form-group">
                <div class="checkbox">
                    <label for="example-checkbox1">
                        <h4>Enable email to Participants of events</h4>
                        <div style="margin-left:10%;margin-top:5%">
                            <input type="checkbox" name="email" id="email" value="enabled" <?php if(isset($enabled)){ if($enabled == "enabled"){ echo "checked";};} ?>>Enable
                            <input type="text" name="hidden_email" id="hidden_email" value="<?php if(isset($enabled)){ echo $enabled;} ?>" hidden>
                        </div>
                    </label>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="form-group">
                <div class="checkbox">
                    <label for="example-checkbox1">
                        <h4>Which role would you like as event host?</h4>
                        <div style="margin-top:5%">
                            <select name="host_role" class="form-control">
                                <?php
                                foreach($roles as $key=>$role){
                                    if($rolevalue != ""){
                                        if($role['role_title'] == $rolevalue){ ?>
                                            <option selected><?php echo $role['role_title']; ?></option>
                                        <?php }
                                        else{ ?>
                                            <option><?php echo $role['role_title']; ?></option>
                                        <?php }
                                    }
                                    else{
                                        if($role['role_title'] == "Employee"){
                                            ?>
                                            <option selected><?php echo $role['role_title']; ?></option>
                                            <?php
                                        }
                                        else{ ?>
                                            <option><?php echo $role['role_title']; ?></option>
                                        <?php }
                                    }
                                } ?>
                            </select>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group" align="right">
            <input type="submit" value="Save" class="btn btn-primary">
            <button type="reset" onclick="history.go(-1);"  class="btn btn-default">Cancel</button>
        </div>
    <?php } ?>
</form>

<?php if(!empty($events)){ ?>
    <div class="row" style="background-color:#eee">
        <div class="col-md-10" style="margin-left:3%;margin-top:2%">
            <h4 class="push">Widget</h4>
            <span class="text">Take bookings directly from your site by embedding the BookingBug widget. To embed the widget, you need to copy the text below and add it to the HTML code of your website.</span>
            <p></p>
            <textarea rows="1" style="width:800px;" readonly><script type="text/javascript" src="<?php echo Yii::app()->params['siteUrl']."/".Yii::app()->params['applicationName']."/event/eventwidget"; ?>"></script></textarea>
            <p></p>
        </div>
    </div>
    <p></p>
<?php } ?>




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