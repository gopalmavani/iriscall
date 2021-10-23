<?php $plan = isset($_GET['plan']) ? $_GET['plan'] : null ?>
<style>
    .row{
        margin-right: -15px;
        margin-left: -15px;
    }
    .col-md-12{
        width: 100%;
        float: left;
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .col-md-6{
        width: 50%;
        float: left;
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .font-b{
        color: #096c9e;
    }
    .form-group{
        margin-bottom: 1.75rem;
    }
    .form-group label{
        font-size: 1rem;
        font-weight: 400;
        color: #3F4254;
        margin-bottom: 0.5rem;
    }
    .input-group{
        position: relative;
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }
    .input-group.input-group-solid{
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        background-color: #F3F6F9;
        border-radius: 0.42rem;
    }
    .input-group.input-group-solid .form-control{
        border: 0;
        background-color: transparent;
        outline: none !important;
        -webkit-box-shadow: none;
        box-shadow: none;
    }
    .input-group > .form-control, .input-group > .form-control-plaintext, .input-group > .custom-select, .input-group > .custom-file{
        position: relative;
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        width: 1%;
        min-width: 0;
        margin-bottom: 0;
    }
    .form-control{
        display: block;
        height: calc(1.5em + 1.3rem + 2px);
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #3F4254;
        background-clip: padding-box;

    }
    .btn:not(:disabled):not(.disabled){
        cursor: pointer;
    }
    .btn.btn-primary{
        color: #FFFFFF;
        border-color: #0BB783;
    }
    .btn{
        outline: none !important;
        vertical-align: middle;
    }
    .btn-primary{
        box-shadow: none;
    }
    .alert.alert-success{
        background-color: #1BC5BD;
        border-color: #1BC5BD;
        color: #ffffff;
    }
    .alert-dismissible{
        padding-right: 4rem;
    }
    .alert{
        position: relative;
        padding: 0.25rem 1.25rem;
        border: 1px solid transparent;
        border-radius: 0.42rem;
    }
    .alert-dismissible .close{
        position: absolute;
        top: 0;
        right: 0;
        padding: 0.75rem 1.25rem;
        color: inherit;
    }
    button.close{
        background-color: transparent;
        border: 0;
    }
    .close{
        float: right;
        line-height: 1;
        text-shadow: 0 1px 0 #ffffff;
        opacity: .5;
    }
    body button{
        outline: none !important;
    }
    .error{
        color: red;
    }
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-radius: 50%;
        width: 10px;
        height: 10px;
        animation: spin 2s linear infinite;
        border-top: 16px solid #FDCF4A;
        border-bottom: 16px solid #FDCF4A;
        display: none;
    }

    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="logo mb6" data-aos="fade-down">
            <a href="https://mobiel.iriscall.com/"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/logos/iriscall-logo.svg" alt="" style="width: 30%" /></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="login-box mb6">
                <div class="login-form" style="min-height: 300px">
                    <h4 class="mb5">Login To <?= Yii::app()->params['applicationName']; ?></h4>
                    <form class="mb1" style="margin-top: 70px">
                        <a href="<?= Yii::app()->params['SSO_URL'].'login?application='.Yii::app()->params['applicationName'].'&plan='.$plan ?>" class="signInBtn">
                            Sign in using Sign In Once
                            <img src="<?= Yii::app()->request->baseUrl ?>/images/sio/logo-sio-icon.png" alt="" />
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h4 class="mb5 font-b" align="center">Ik ben een nieuwe klant</h4>
            <div class="alert alert-dismissible" role="alert" style="display: none;">
                <span id="msg"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h5 class="mb5 font-b">Zakelijk account aanmaken</h5>
            <form name="register" action="<?php  echo Yii::app()->createUrl('home/createUserSignup');  ?>" method="post" class="mb1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">E-mailadres<span class="error">*</span></label>
                            <div class="input-group input-group-solid">
                                <input type="email" id="email" class="form-control" name="email" required="required" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">Naam<span class="error">*</span></label>
                            <div class="input-group input-group-solid">
                                <input style="height:45px;" type="text" id="first_name" class="form-control" name="first_name" required="required" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 password">
                        <div class="form-group">
                            <label>Wachtwoord<span class="error">*</span></label>
                            <div class="input-group input-group-solid">
                                <input style="height:43px;" type="password" id="password" class="form-control" name="password" required="required" autocomplete="new-password" autocomplete="off">
                                <div class="input-group-append">
                                    <i style="margin-right: 0.50rem" class="far fa-eye-slash" id="togglePassword"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 password">
                        <div class="form-group">
                            <label for="confirm_password">Wachtwoord bevestigen<span class="error">*</span></label>
                            <div class="input-group input-group-solid">
                                <input style="height:43px;" type="password" id="confirm_password" class="form-control" name="confirm_password" required="required" autocomplete="off">
                                <div class="input-group-append">
                                    <i style="margin-right: 0.50rem" class="far fa-eye-slash" id="toggle-password"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group" id="hide" align="center">
                        <button type="submit" id="submit" class="btn btn-primary col-md-offset-2" style="background-color: #096c9e;"><span id="text">Account aanmaken</span><div class="loader"></div></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    //show and hide password
    $("body").on('click', '#togglePassword', function() {
		$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $("#password");
			if (input.attr("type") === "password") {
			input.attr("type", "text");
			} else {
			input.attr("type", "password");
		}
	});

    //show and hide confirm password
	$("body").on('click', '#toggle-password', function() {
		$(this).toggleClass("fa-eye fa-eye-slash");
		var input = $("#confirm_password");
		if (input.attr("type") === "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});

    //match password
    var password = document.getElementById("password")
    var confirm_password = document.getElementById("confirm_password");

    function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Voer hetzelfde wachtwoord in.");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;

    $("#email").change(function(){
        let email = $("#email").val();
        $.ajax({
            url:  "<?php  echo Yii::app()->createUrl('home/verifyEmail');  ?>",
            type: "POST",
            data: {
                email: email
            },
            beforeSend:function () {
                before();
            },
            success: function (data) {
                after();
                var resp = JSON.parse(data);
                if(resp['status'] == 0){
                    $('.password').show();
                    $('#msg').html(resp['message']);
                    $('#hide').show();
                }else if(resp['status'] == 1){
                    $('.password').show();
                    $('#hide').show();
                    $('.alert').hide();
                }else if(resp['status'] == 2){
                    $('#msg').html(resp['message']);
                    $("form[name='register']").empty();
                }else if(resp['status'] == 3){
                    $('.password').remove();
                    $('#hide').show();
                    $('#msg').html(resp['message']);
                }
            }
        });
    });

    //before send
    function before() {
        $('.alert').hide();
        $('#text').hide();
        $('.loader').show();
        $('#submit').removeClass('btn btn-primary');
        $('#submit').prop('disabled', true);
    }

    //on success
    function after() {
        $('.alert').show();
        $('.alert').removeClass('alert-danger');
        $('.alert').addClass('alert-success');
        $('#text').show();
        $('.loader').hide();
        $('#submit').addClass('btn btn-primary');
        $('#submit').prop('disabled', false);
    }
});
</script>