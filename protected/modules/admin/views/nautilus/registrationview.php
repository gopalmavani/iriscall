<?php
/* @var $this NautilusController */
/* @var $model NuRegistrations */
/* @var $kyc NuKyc */

    $this->pageTitle = 'View Registration';
?>
<div class="tab-content">
    <div class="tab-pane active">
        <div class="row">
            <div class="pull-right">
                <?php echo CHtml::link('Go to list', array('nautilus/registration'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
                <p></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2>Registration Detail</h2>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="block block-bordered" style="border-color: #f3c200;">
                    <div class="block-header" style="background-color: #f3c200">
                        <h3 class="block-title"><font color="white"><i class="fa fa-cogs"></i> Personal Details</font></h3><br/>
                    </div>
                    <div class="block-content block-content-full">
                        <?php $userName = UserInfo::model()->findByAttributes(['user_id' => $model->user_id]); ?>
                        <div class="row">
                            <div class="col-md-6"> <b>Customer Name:</b> </div>
                            <div class="col-md-6"><?php echo $userName->full_name; ?></div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-md-6"><b>Fund Registration's Customer Name:</b></div>
                            <div class="col-md-6"><?php echo $model->fullname_user1; ?></div>
                        </div>
                        <p></p>
                        <?php if(!empty($model->fullname_user2)){?>
                        <div class="row">
                            <div class="col-md-6"><b>Fund Registration's Nominee Name:</b></div>
                            <div class="col-md-6"><?php echo $model->fullname_user2; ?></div>
                        </div>
                        <p></p>
                        <?php }?>
                        <?php if(!empty($model->fund_sources)){?>
                        <div class="row">
                            <div class="col-md-6"><b>Fund Sources:</b></div>
                            <div class="col-md-6"><?php echo $model->fund_sources; ?></div>
                        </div>
                        <p></p>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="block block-bordered" style="border-color: #E26A6A;">
                    <div class="block-header" style="background-color: #E26A6A">
                        <h3 class="block-title"><font color="white"><i class="fa fa-cogs"></i> Address</font> </h3><br/>
                    </div>
                    <div class="block-content block-content-full">
                        <address>
                            <?php if($model->house_num){echo $model->house_num.",";} if($model->street){echo $model->street.","."<br>";}?>
                            <?php if($model->region){echo $model->region.","."<br>" ;}?>
                            <?php if($model->city){echo $model->city.",".$model->postcode.".";} ?>
                            <?= ServiceHelper::getCountryNameFromId($model->country); ?>
                        </address>
                    </div>
                </div>
            </div>
        </div>
        <?php foreach ($kyc as $item){
            if($item->type == "idproof_user1"){
                $idpath1 = $item->path;
            }
            if($item->type == "addressproof_user1"){
                $addresspath1 = $item->path;
            }
            if($item->type == "idproof_user2"){
                $idpath2 = $item->path;
            }
            if($item->type == "addressproof_user2"){
                $addresspath2 = $item->path;
            }
        } ?>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2>KYC Detail</h2>
            </div>
            <?php if(isset($idpath1)){?>
            <div class="col-md-6">
                <?php if(isset($idpath1)){?>
                    <div class="block block-bordered" style="border-color: #67809F;">
                        <div class="block-header" style="background-color: #67809F">
                            <h3 class="block-title"><font color="white"><i class="fa fa-cogs"></i> <?php echo $model->firstname_user1 . " " . $model->middlename_user1 . " " . $model->lastname_user1 ." KYC Detail";?></font> </h3><br/>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-md-6">
                                    <span><b>Id Proof: </b></span>
                                </div>
                                <div class="col-md-6" style="display: block; width: 150px; height: 150px; position: relative; overflow: hidden; border: 1px solid; text-align: center;">
                                    <img src="<?php echo $idpath1; ?> " class="image-preview" id="idPreview1" data-holder-rendered="true" >
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <span><b>Address Proof: </b></span>
                                </div>
                                <div class="col-md-6" style="display: block; width: 150px; height: 150px; position: relative; overflow: hidden; border: 1px solid; text-align: center;">
                                    <img src="<?php echo $addresspath1; ?> " class="image-preview" id="addressPreview1" data-holder-rendered="true" >
                                </div>
                            </div>
                            <p></p>
                        </div>
                    </div>
                <?php }?>
            </div>
            <div class="col-md-6">
                <?php if(isset($idpath2)){?>
                    <div class="block block-bordered" style="border-color: #67809F;">
                        <div class="block-header" style="background-color: #67809F;">
                            <h3 class="block-title"><font color="white"><i class="fa fa-cogs"></i> <?php echo $model->firstname_user2 . " " . $model->middlename_user2 . " " . $model->lastname_user2 ." KYC Detail";?></font> </h3><br/>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">
                                <div class="col-md-6">
                                    <span><b>Id Proof: </b></span>
                                </div>
                                <div class="col-md-6" style="display: block; width: 150px; height: 150px; position: relative; overflow: hidden; border: 1px solid; text-align: center;">
                                    <img src="<?php echo $idpath2; ?> " class="image-preview" id="idPreview1" data-holder-rendered="true" >
                                </div>
                            </div>
                            <p></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <span><b>Address Proof: </b></span>
                                </div>
                                <div class="col-md-6" style="display: block; width: 150px; height: 150px; position: relative; overflow: hidden; border: 1px solid; text-align: center;">
                                    <img src="<?php echo $addresspath2; ?> " class="image-preview" id="addressPreview1" data-holder-rendered="true" >
                                </div>
                            </div>
                            <p></p>
                        </div>
                    </div>
                <?php }?>
            </div>
            <?php }else{?>
            <div  class="col-md-12">
                <h3 style="color:red;" align="center">No KYC Done.</h3>
            </div>
            <?php }?>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2>Deposit/Withdraw</h2>
            </div>
            <div class="col-md-12">
                <?php if(!empty($deposit)){ ?>
                <table class="table m-table m-table--head" id="booking-detail-table">
                    <thead style="background-color: #e00049!important;color: #fff;">
                    <tr>
                        <th>

                        </th>
                        <th>
                            Username
                        </th>
                        <th>
                            amount
                        </th>
                        <th>
                            type
                        </th>
                        <th>
                            status
                        </th>
                        <th>
                            Date
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($deposit as $data){$i =1; ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $userName->full_name; ?></td>
                            <td><?php echo $data->amount;?></td>
                            <td><?php echo $data->type;?></td>
                            <td><?php if($data->status == 0){ echo "Pending";}elseif($data->status == 1){ echo "Aprooved";}else{echo "Processed";}?></td>
                            <td><?php echo date('d/m/Y H:i a',strtotime($data->created_at));?></td>
                        </tr>
                    <?php $i++;}?>
                    </tbody>
                </table>
                <?php }else{?>
                <h3 style="color:red;" align="center">No Deposit/Withdraw Done.</h3>
                <?php }?>
            </div>
        </div>
    </div>
</div>