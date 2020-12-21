<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="row mb9 mb6-md">
        <div class="col-md-12 text-center">
            <div class="logo mb-3 wow fadeInUp" data-wow-delay="100ms"><img src="<?= Yii::app()->baseUrl . '/images/logos/iriscall_logo_white.png' ?>" class="img-fluid" style="width: 200px; height: 100px;"></div>
        </div>
    </div>
    <div class="card card-custom" style="width:60%; margin: auto">
        <div class="card-header" style="margin: auto">
            <div class="card-title">
                <h3 class="card-label">Welcome to <?= Yii::app()->params['applicationName'] ?></h3>
            </div>
        </div>
        <div class="card-body">
            <p class="mb3 mbsm2 font24 wow fadeInUp text-center" data-wow-delay="250ms">Please enter your email address</p>
            <div class="form-group row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <input type="email" class="form-control" id="email" required="required" placeholder="Enter email here">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="button" onclick="verifyEmail()" class="btn btn-primary">Verify <i class="fa fa-angle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="sio-flex text-center mt-5">
        <div class="sio-logo">
            <img src="<?= Yii::app()->baseUrl. '/images/logo-sio-icon.png'; ?>" alt="">
        </div>
        <div class="sio-text">
            <p class="sio-heading">Iriscall registration is powered by Sign In Once</p>
            <p class="sio-sub-heading">By continuing with registration, you agree to the
                <a target="_blank" href="#">terms & conditions.</a></p>
        </div>
    </div>
</div>
<!-- Sidebar Toggle Script -->
<script type="text/javascript">
    $(document).ready(function () {});
    function verifyEmail() {
        var email = $("#email").val();
        if(email == ''){
            toastr.error("Invalid email");
        } else {
            var registration_email_verification_url = "<?= Yii::app()->createUrl('home/verifyEmail'); ?>";
            $.ajax({
                url: registration_email_verification_url,
                type: "POST",
                data: {
                    email: email
                },
                success: function (response) {
                    var resp = JSON.parse(response);
                    /*
                    * 0 - Error
                    * 1 - Registration can begin
                    * 2 - Email exists in Iriscall itself. Kindly login
                    * 3 - User is already registered at SIO. Please proceed registration with some necessary data.
                    * */
                    if(resp['status'] == 2){
                        toastr.warning(resp['message']);
                    } else if(resp['status'] == 3){
                        toastr.warning(resp['message']);
                        console.log(resp['verification_url']);
                        //$('#proceed_registration').css('display', 'block');
                    }  else if(resp['status'] == 1){
                        toastr.success(resp['message']);
                        proceed_step_initial();
                        //$('#proceed_registration').css('display', 'block');
                    } else {
                        toastr.error(resp['message']);
                    }
                }
            })
        }
    }

    function proceed_step_initial() {
        window.location = "<?= Yii::app()->createUrl('account/createguestaccount'); ?>";
    }
</script>