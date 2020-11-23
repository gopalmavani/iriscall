<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="row mb9 mb6-md">
        <div class="col-md-12 text-center">
            <div class="logo mb3 wow fadeInUp" data-wow-delay="100ms"><img src="<?= Yii::app()->baseUrl. '/images/logos/iriscall-logo.svg'; ?>" class="img-fluid"></div>
        </div>
    </div>
    <div class="card card-custom" style="width:60%; margin: auto">
        <div class="card-header" style="margin: auto">
            <div class="card-title">
                <?php if (isset($success)){ ?>
                    <h3 class="card-label"><?php echo $success; ?></h3>
                <?php }?>
                <?php if (isset($error)){ ?>
                    <h3 class="card-label"><?php echo $error; ?></h3>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="sio-flex text-center">
        <div class="sio-logo">
            <img src="<?= Yii::app()->baseUrl. '/images/logo-sio-icon.png'; ?>" alt="">
        </div>
        <div class="sio-text">
            <p class="sio-heading">Iriscall registration is powered by Sign In Once</p>
        </div>
    </div>
</div>