<?php
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="map-box">
                    <h5 style="margin-left: 12px;">First step done! Now there are a few more steps to go before we can start you in the cashback matrix. We invite you to take the next step to buy your first licenses.</h5>
                    <br>
                    <h5 style="margin-left: 12px;">You’ll be guided step by step though this registration procedure. Please take your time to go through this process, because there are some important choices to be made.</h5>
                    <div class="row" style="margin-top: 63px">
                        <div class="col-md-1"></div>
                        <div class="col-md-4" style="max-width: 27%">
                            <span>Step 1</span>
                            <div style=" background: white url('<?= Yii::app()->baseUrl.'/images/greenStep1.png';?>') no-repeat center; text-align: center">
                                <h3 style="color: white; padding: 32px">REGISTRATION<br>FINISHED</h3>
                            </div>
                        </div>
                        <div class="col-md-4" style="max-width: 27%; cursor: pointer;" onclick="openProductPage()">
                            <span>Step 2</span>
                            <div style=" background: white url('<?= Yii::app()->baseUrl.'/images/orangeStep2.png';?>') no-repeat center; text-align: center">
                                <h3 style="color: white; padding: 30px">BUY Licenses<br>Click here to proceed</h3>
                            </div>
                        </div>
                        <div class="col-md-4" style="max-width: 26%">
                            <span>Step 3</span>
                            <div class="row" style=" background: white url('<?= Yii::app()->baseUrl.'/images/greyStep3_1.png';?>') no-repeat center; text-align: center; margin-bottom: 5px">
                                <div class="col-md-10" style="padding-right: 0; max-width: 70%; margin: 5px">
                                    <span style="color: white;">MANAGED ACCOUNT<br>NAUTILIUS EA</span>
                                </div>
                                <div class="col-md-2" style="padding-left: 0; margin-top: 8px">
                                    <?= CHtml::image(Yii::app()->baseUrl.'/images/packimg.png','Packlogo', ['width' => '30px']) ?>
                                </div>
                            </div>
                            <div class="row" style=" background: white url('<?= Yii::app()->baseUrl.'/images/greyStep3_2.png';?>') no-repeat center; text-align: center">
                                <div class="col-md-10" style="padding-right: 0; max-width: 70%; margin: 5px">
                                    <span style="color: white;">FUND<br>NAUTILUS UNITY</span>
                                </div>
                                <div class="col-md-2" style="padding-left: 0; margin-top: 8px">
                                    <?= CHtml::image(Yii::app()->baseUrl.'/images/unityimg.png','Unitylogo', ['width' => '30px']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function openProductPage() {
        location.href = "<?= Yii::app()->createUrl('product/index'); ?>";
    }
</script> 