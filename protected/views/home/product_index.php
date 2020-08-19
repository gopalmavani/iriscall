<?php
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">
                    WELCOME TO <span style="color: #185DA5">CBM GLOBAL</span>
                </h1>
                <div class="reg_steps" style="max-width: 50%; margin: auto">
                    <?php foreach ($registration_steps as $step) { ?>
                        <?php if($step->step_number <= $achieved_till) { ?>
                            <div class="row" style="color: #82C736;">
                                <div class="col-md-1">
                                    <span><i class="<?= $step->font_icon_class; ?>"></i></span>
                                </div>
                                <div class="col-md-11">
                                    <span>Step <?= $step->step_number; ?>:</span><br>
                                    <span><?= $step->status_name; ?></span>
                                </div>
                            </div>
                        <?php } elseif ($step->step_number == $achieved_till+1) { ?>
                            <div class="row" style="color: #EC843A;">
                                <div class="col-md-1">
                                    <span><i class="<?= $step->font_icon_class; ?>"></i></span>
                                </div>
                                <div class="col-md-11">
                                    <span>Step <?= $step->step_number; ?>:</span><br>
                                    <span><?= $step->status_name; ?></span>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="row text-muted">
                                <div class="col-md-1">
                                    <span><i class="<?= $step->font_icon_class; ?>"></i></span>
                                </div>
                                <div class="col-md-11">
                                    <span>Step <?= $step->step_number; ?>:</span><br>
                                    <span><?= $step->status_name; ?></span>
                                </div>
                            </div>
                        <?php } ?>
                        <hr style="margin: 12px 0">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
