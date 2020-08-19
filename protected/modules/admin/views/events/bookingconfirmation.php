<?php
/**
 * Created by PhpStorm.
 * User: kushal
 * Date: 22/2/18
 * Time: 4:20 PM
 */
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/js/plugins/bootstrap-treeview/bootstrap-treeview.css');
$this->pageTitle = $model->event_title."- &euro;".$model->price;

?>
<input type="hidden" id="stop" value="<?php echo $stop; ?>">
<div class="row">
    <!--<h4 style="margin-left:5%;margin-bottom:3%">Price of this event is  &euro; <?php /*echo $model->price; */?></h4>-->
    <!-- Form -->
    <div class="row">
        <form class="form-horizontal" action="<?php echo Yii::app()->createUrl('/admin/Events/booking')."/".$model->event_id; ?>" method="POST" style="width:100%">
            <input type="hidden" name="booking[price]" value="<?php echo $model->price; ?>">
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="form-material">
                        <select class="form-control" name="booking[user_id]" id="booking_user_id">
                            <option value="">Select user</option>
                            <?php
                            $i = 0;
                            foreach ($users as $key=>$user){
                                if($i=0){ ?>
                                    <option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>
                                <?php } else{ ?>
                                    <option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>
                                <?php  } ?>
                            <?php } ?>
                        </select>
                        <span class="help-block hide" id="user_id_error">Please select user</span>
                    </div>
                    <p></p>
                    <label><span style="font-size:18px">New user</span>&nbsp;&nbsp;<input type="checkbox" id="newusercheck"></label>
                </div>
            </div>


            <div class="newmemberform hide">
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-material">
                            <input class="form-control" type="text" id="booking_username" name="booking[username]" placeholder="Please enter your fullname">
                            <label for="simple-firstname">Full Name</label>
                            <span class="help-block hide" id="username_error">Please enter username</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-material">
                            <input class="form-control" type="text" id="booking_email" name="booking[email]" placeholder="Please enter your email">
                            <label for="simple-firstname">Email</label>
                            <span class="help-block hide" id="email_error">Please enter email</span>
                        </div>
                    </div>
                </div>
                <!--<div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-material">
                            <input class="form-control" type="text" id="booking_mobile_number" name="booking[mobile_number]" placeholder="Please enter your mobile number">
                            <label for="simple-firstname">Mobile Number</label>
                            <span class="help-block hide" id="mobile_error">Please enter mobile</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-material">
                            <textarea class="form-control" id="booking_address" name="booking[address]" rows="4" placeholder="Enter your address here"></textarea>
                            <label for="simple-details">Address</label>
                            <span class="help-block hide" id="address_error">Please enter address</span>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="form-material">
                        <input class="form-control" type="text" id="booking_coupon_code" name="booking[coupon_code]" placeholder="If you have coupon code enter it here">
                        <a class="btn btn-warning pull-right" href="javascript:void(0);" id="applycoupon" style="margin-right:-59px;margin-top:-6%;font-size:10px">Apply</a>
                        <label for="simple-details">Coupon Code</label>
                    </div>
                    <span id="wrong_code" class="help-block hide">Wrong coupon code applied</span>
                    <span id="right_code" class="hide" style="color:#46c37b;">Coupon code applied</span>
                </div>
            </div>

            <div align="right" style="margin-right:2%;margin-bottom:2%">
                <button type="button" class="btn btn-secondary" onClick="history.go(-1);">Cancel</button>
                <button id="submitbutton" class="wizard-finish btn btn-primary" type="submit"><i class="fa fa-check-circle-o"></i> Submit</button>
            </div>
        </form>
        <!-- END Form -->
    </div>
</div>

<!--Begin stop booking modal-->
<div class="modal fade shop-login-modal" id="bookingdone" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Event booked up.</h5>
            </div>
            <div class="modal-body">
                This Event is booked up , you can not book this event now.
                <p></p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" onclick="history.go(-1)">Go back</a>
            </div>
        </div>
    </div>
</div>
<!--End stop booking modal-->
<script>
    $(document).ready(function () {
        $value = $('#stop').val();
        if($value == "stop"){
            $('#bookingdone').modal('show');
        }
    });
    /*$('#booking_user_id').change(function(){
        $('#newusercheck').parent().addClass('hide');
    });*/
    $('#newusercheck').on("click",function () {
        if($(this).is(':checked')){
            $('.newmemberform').removeClass('hide');
        }
        else{
            $('.newmemberform').addClass('hide');
        }
    });

    $('#submitbutton').on("click",function(){
        var userid = $('#booking_user_id').val();
        if(userid == "") {
            $('#booking_user_id').parent().parent().parent().removeClass("has-error");
            $("#user_id_error").addClass('hide');

            var email = $('#booking_email').val();
            var username = $('#booking_username').val();
            var check = 0;
            var mobno = $('#booking_mobile_number').val();
            var address = $('#booking_address').val();


            if (username == "") {
                $('#booking_username').parent().parent().parent().addClass('has-error');
                $('#username_error').removeClass('hide');
                check = 1;
            }

            if (email == "") {
                $('#booking_email').parent().parent().parent().addClass('has-error');
                $('#email_error').removeClass('hide');
                check = 1;
            }
            else {
                if (emailcheck(email) == false) {
                    check = 1;
                    $('#booking_email').parent().parent().parent().addClass('has-error');
                    $('#email_error').removeClass('hide');
                    $('#email_error').html('Please enter correct email');
                }
            }

            if (check == 1) {
                return false;
            }
            /*if(mobno == ""){
                $('#booking_mobile_number').parent().parent().parent().addClass('has-error');
                $('#mobile_error').removeClass('hide');
                return false;
            }
            if(address == ""){
                $('#booking_address').parent().parent().parent().addClass('has-error');
                $('#address_error').removeClass('hide');
                return false;
            }*/
        }

    });

    function emailcheck(value) {
        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
    }

    $('#applycoupon').on("click",function(){
        var coupon = $('#booking_coupon_code').val();
        var couponurl = "<?php if(isset($model)){echo Yii::app()->createUrl("/admin/events/checkcoupon/")."/".$model->event_id;} ?>";

        $.ajax({
            url: couponurl,
            type: 'POST',
            data: {coupon: coupon},
            success:function(response){
                console.info()
                var res = JSON.parse(response);
                if(res.token == 0){
                    $('#wrong_code').parent().parent().addClass('has-error');
                    $('#wrong_code').removeClass('hide');
                }
                if(res.token == 1){
                    $('#wrong_code').parent().parent().removeClass('has-error');
                    $('#wrong_code').addClass('hide');
                    $('#right_code').removeClass('hide');
                    $("#booking_coupon_code").prop("readonly", true);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
</script>