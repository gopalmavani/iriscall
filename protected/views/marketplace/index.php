<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

            <!-- begin:: Subheader -->
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-container kt-container--fluid ">
                    <div class="kt-subheader__main">
                        <h3 class="kt-subheader__title"> Market Place </h3>
                        <span class="kt-subheader__separator kt-hidden"></span>
                        <div class="kt-subheader__breadcrumbs"> <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Products</span> </div>
                    </div>
                </div>
            </div>
            <!-- end:: Subheader -->
            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <?php if(count($products) > 0){ ?>
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <h5 class="text-center mb-5">Select a product to link with your account:</h5>
                        </div>
                        <div class="col-lg-12">
                            <div class="products mb-5">
                                <!--<form id="productslist" name="productlist" method="post">-->
                                <div class="selectproduct linkproduct" data-toggle="buttons">
                                    <?php if($products){
                                        foreach ($products as $product){?>
                                            <div class="btn"><!--default-->
                                                <img src="<?php echo Yii::app()->baseurl.''.$product['image']; ?>" class="img">
                                                <h6><?= $product['name'] ?></h6>
                                                <p class="mb1"><?= $product['description'] ?></p>
                                                <table class="table table-striped mb3">
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-left">Leverage</td>
                                                        <td class="text-right">1:30</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Account Type :</td>
                                                        <td class="text-right">REAL (€)</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Platform :</td>
                                                        <td class="text-right">MetaTrader 4</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Broker :</td>
                                                        <td class="text-right">INFINOX Capital</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div><img src="<?= Yii::app()->baseurl ?>/images/graph-product1.jpg" class="img-graph"></div>
                                                <input type="checkbox" name="product">
                                                <button type="submit" class="btn btn-primary deposit_modal" data-toggle="modal" data-min-deposit="<?= $product['minimum_deposit']; ?>" data-id="<?= $product['product_id']; ?>" data-target="#exampleModal" >Select Product</button>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>
                                <!--</form>-->
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="kt-portlet kt-portlet--height-fluid w-info">
                                <div class="kt-portlet__body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-12 col-sm-12">
                                            <p class="text-center">Congratulations!! All MMC related agents are successfully linked to your account
                                            <br>
                                                Kindly move to <strong><a href="<?= Yii::app()->createUrl('product/index'); ?>">Grid Licenses</a></strong> page to buy some cashback licenses
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- end:: Content -->
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cashback License</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form name="productlist" method="post" id="productlist">
                <div class="modal-body">
                    <p>Would you like to purchase some Cashback Licenses?</p>
                    <label class="radio">
                        <input name="buy_license" type="radio" value="yes">
                        <span></span>
                        Yes
                    </label>
                    <label class="radio">
                        <input name="buy_license" type="radio" value="no">
                        <span></span>
                        No
                    </label>
                    <input type="hidden" id="product_id" name="product_id" value="" >
                    <br>
                    <div id="deposit_row" style="margin-top: 10px;">
                        <div class="form-group">
                            <label>Deposit Amount</label>
                            <div id="deposit_error_msg" class="text-danger" style="display: none;">Please enter deposit</div>
                            <input type="number" id="deposit_val" name="deposit" min="500" class="form-control" placeholder="Your intended deposit amount">
                            <span class="form-text text-muted">We would suggest best license offers upon your deposit</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#deposit_row').hide();
    });
    $('.deposit_modal').click(function(){
        var product_id = $(this).attr('data-id');
        var min_deposit = $(this).attr('data-min-deposit');
        $('#product_id').val(product_id);
        $("#deposit_val").attr({
            "min" : min_deposit          // values (or variables) here
        });
        $('#deposit_row').hide();
    });
    $('body').on('change', 'input[type=radio][name=buy_license]', function () {
        var buy_licenses = $(this).val();
        if(buy_licenses == 'yes'){
            $('#deposit_row').show();
        }else{
            $('#deposit_row').hide();
        }
    });

    $("#productlist").validate({
        ignore: ".ignore",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function (element, errorClass) {
            $(element).addClass(errorClass);
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function (error, element) {
            error.insertBefore(element)
        },
        rules: {
            buy_license: {
                required: true,
            }
        },
        messages: {
            buy_license: 'Please select an option',
        },
        submitHandler: function(form) {

            var buy_licenses = $("input[name='buy_license']:checked").val();
            var deposit_min = $(".deposit_modal").attr('data-min-deposit');
            if(buy_licenses == 'yes'){
                var deposit_amount = $('#deposit_val').val();
                if(deposit_amount >= deposit_min){
                    form.submit();
                }else{
                    $('#deposit_error_msg').html('Please enter deposit amount');
                    $('#deposit_error_msg').css('display','block');
                    return false;
                }
            }else{
                $('#deposit_val').val('');
                form.submit();
            }
            return false;
            //$(form).ajaxSubmit();
        }
    });

</script>