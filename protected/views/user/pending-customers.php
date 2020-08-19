<?php
    $pendingUsers = 0;
    $completedUsers = 0;
?>
<?php if(!empty($level1UserRegistrations)) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#incomplete" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Pending status</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#complete" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Finished status</span></a> </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" id="incomplete" role="tabpanel">
                            <?php foreach ($level1UserRegistrations as $userRegistration) { ?>
                                <?php if($userRegistration['step_number'] != 8) { ?>
                                    <?php $pendingUsers++; ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card card-outline-success">
                                                <div class="card-header">
                                                    <?php if($userRegistration['privacy_disclosure'] == 0) { ?>
                                                        <h4 class="m-b-0 text-white"><?= $userRegistration['full_name'] ?></h4>
                                                    <?php } else { ?>
                                                        <h4 class="m-b-0 text-white"><?= ServiceHelper::hideStringGenealogy($userRegistration['user_id']); ?></h4>
                                                    <?php } ?>
                                                </div>
                                                <div class="card-body wizard-content">
                                                    <form action="#" class='tab-wizard wizard-circle form_<?= $userRegistration['user_id']; ?>'>
                                                        <?php foreach ($registrationSteps as $step) { ?>
                                                            <!-- Step -->
                                                            <h6><?= $step->status_name; ?></h6>
                                                            <section style="display: none;"></section>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php if($pendingUsers == 0) { ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline-success text-center " style="margin: 50px;">
                                            <div class="card-header">
                                                <h4 class="text-white">All Good here</h4>
                                            </div>
                                            <div class="card-body">
                                                <p>All your first level users have successfully completed their registrations!!!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane  p-20" id="complete" role="tabpanel">
                            <?php foreach ($level1UserRegistrations as $userRegistration) { ?>
                                <?php if($userRegistration['step_number'] == 8) { ?>
                                    <?php $completedUsers++; ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card card-outline-success">
                                                <div class="card-header">
                                                    <?php if($userRegistration['privacy_disclosure'] == 0) { ?>
                                                        <h4 class="m-b-0 text-white"><?= $userRegistration['full_name'] ?></h4>
                                                    <?php } else { ?>
                                                        <h4 class="m-b-0 text-white"><?= ServiceHelper::hideStringGenealogy($userRegistration['user_id']); ?></h4>
                                                    <?php } ?>
                                                </div>
                                                <div class="card-body wizard-content">
                                                    <form action="#" class='tab-wizard wizard-circle form_<?= $userRegistration['user_id']; ?>'>
                                                        <?php foreach ($registrationSteps as $step) { ?>
                                                            <!-- Step -->
                                                            <h6><?= $step->status_name; ?></h6>
                                                            <section style="display: none;"></section>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php if($completedUsers == 0) { ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline-danger text-center ">
                                            <div class="card-body">
                                                <p>No in your first level has completed their registrations.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
<div class="row">
    <div class="col-12">
        <div class="card card-outline-danger text-center ">
            <div class="card-body">
                <p>You need to grow your network for maximum earnings!!!</p>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script type="text/javascript" src="<?= Yii::app()->baseUrl.'/plugins/wizard/jquery.steps.min.js' ?>"></script>
<script type="text/javascript">
    $(".tab-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#'
    });
    $('.actions').css('display','none');
    var level1Users = "<?= addslashes(json_encode($level1UserRegistrations)); ?>";
    var level1 = JSON.parse(level1Users);
    $.each(level1,function (index, val) {
        var step_number = val.step_number;
        var user_id = val.user_id;
        for(var i=1; i<=step_number; i++){
            $('.form_'+user_id).steps("next");
        }
        if(step_number == 8){
            $('.form_'+user_id).steps("finish");
        }
    });
</script>
<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/wizard/jquery.steps.min.js', CClientScript::POS_END);
?>
