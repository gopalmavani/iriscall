<div class="error-body text-center">
    <h1><?php echo $error['code']; ?></h1>
    <?php if($error['code'] == '500'){ ?>
    <h3 class="text-uppercase">Internal Server Error !</h3>
    <?php }elseif($error['code'] == '400'){?>
     <h3 class="text-uppercase">Page Not Found !</h3>
    <?php }elseif($error['code'] == '403'){?>
    <h3 class="text-uppercase">Forbiddon Error!</h3>
    <?php }else { ?> 
    <h3 class="text-uppercase">Page Not Found !</h3>
    <?php } ?>
    <p class="text-muted m-t-30 m-b-30"><?= $error['message']; 	?></p>
    <?php if(Yii::app()->user->isGuest){ ?>
    <a href="<?php echo Yii::app()->createUrl('home/login'); ?>" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Login</a>
    <?php }else{ ?>
    <a href="<?php echo Yii::app()->createUrl('home/index'); ?>" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a>
   <?php } ?>
</div>