<style>
    .trip-block{
        color: #fff !important;
        background-color: #044e80 !important;
        border-radius: 5px;
        padding: 20px;
    }
    .trip-skip,.trip-next{
        color: yellow;
    }
</style>
<?php
if(count($cartItem) < 1){
    $this->redirect(Yii::app()->createUrl('marketplace/index'));
}?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

            <!-- begin:: Subheader -->
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <div class="kt-container kt-container--fluid ">
                    <div class="kt-subheader__main">
                        <h3 class="kt-subheader__title"> Market Place </h3>
                        <span class="kt-subheader__separator kt-hidden"></span>
                        <div class="kt-subheader__breadcrumbs"> <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a> <span class="kt-subheader__breadcrumbs-separator"></span> <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Product licenses</span> </div>
                    </div>
                </div>
            </div>
            <!-- end:: Subheader -->
            <!-- begin:: Content -->
            <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                <!--Begin::Row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="kt-portlet kt-portlet--height-fluid">
                            <div class="kt-portlet__body">
                                <div class="accordion accordion-solid accordion-toggle-plus accordion-matrix-listviewer" id="accordionExample6">
                                    <div class="card">
                                        <div class="card-header" id="headingOne6">
                                            <div class="card-title" data-toggle="collapse" data-target="#collapseOne6" aria-expanded="true" aria-controls="collapseOne6">
                                                <!--<div class="kt-widget__name-label kt-font-boldest bg-primary kt-font-light mr-3">Trading</div>-->
                                                License Details (Optional)</div>
                                        </div>
                                        <div id="collapseOne6" class="collapse show" aria-labelledby="headingOne6" data-parent="#accordionExample6">
                                            <div class="card-body">
                                                <!-- content here -->
                                                <div class="row">
                                                    <div class="col-sm-4 col-lg-4 col-xl-3 pr-0">
                                                        <div class="table-responsive table-tradingcapital">
                                                            <table role="table" class="table table-wallet" id="trading_capital">
                                                                <thead role="rowgroup" class="thead-dark text-center">
                                                                <tr>
                                                                    <th role="columnheader" colspan="3"><h5 class="mb-0">Trading Capital</h5></th>
                                                                </tr>
                                                                </thead>
                                                                <thead role="rowgroup" class="thead-light">
                                                                <tr>
                                                                    <th role="columnheader"></th>
                                                                    <th role="columnheader">Cluster</th>
                                                                    <th role="columnheader" class="text-right">Capital Deposit</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody role="rowgroup">
                                                                    <?php  foreach ($trading_pricing_array as $value) { ?>
                                                                        <tr role="row" class="treding_rows <?php if($value['present']){?> selected <?php } ?>" data-step="<?= $value['id']; ?>">
                                                                            <td role="cell" class="grp1_<?= $value['id']; ?>">
                                                                                <label class="kt-radio">
                                                                                    <input type="radio" <?php if($value['present']){?> checked <?php } ?> name="group1" data-id="<?= $value['id']; ?>" id="<?= "grp1_radio_" . $value['id']; ?>">
                                                                                    <span></span>
                                                                                </label>
                                                                            </td>
                                                                            <td role="cell"><?= $value['licenses']; ?></td>
                                                                            <td role="cell" class="text-right">€<?= $value['capital_deposit']; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-lg-4 col-xl-4 pl-0">
                                                        <div class="table-responsive table-licenses">
                                                            <table role="table" class="table table-wallet" id="cbm_licenses">
                                                                <thead role="rowgroup" class="thead-dark text-center">
                                                                <tr>
                                                                    <th role="columnheader" colspan="4"><h5 class="mb-0">MMC Licenses</h5></th>
                                                                </tr>
                                                                </thead>
                                                                <thead role="rowgroup" class="thead-light">
                                                                <tr>
                                                                    <th role="columnheader"></th>
                                                                    <th role="columnheader" style="width: 50px;padding-right: 0px;padding-left: 0px;">Licenses</th>
                                                                    <th role="columnheader" class="text-right" style="width: 200px;padding-left: 0px;padding-right: 0px;">License Cost (Excl. VAT)</th>
                                                                    <th role="columnheader" class="text-right" style="width:170px;padding-left: 0px;">Price Per License</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody role="rowgroup">
                                                                    <?php   foreach ($licenses_pricing_array as $value){ ?>
                                                                        <tr role="row" class="license_rows <?php if($value['present']){?> selected <?php } ?>" data-step="<?= $value['id']; ?>">
                                                                            <td role="cell" class="grp2_<?= $value['id']; ?>">
                                                                                <label class="kt-radio">
                                                                                    <input type="radio" name="group2" <?php if($value['present']){?> checked <?php } ?> class="grp1_radio" data-id="<?= $value['id']; ?>" id="<?= "grp2_radio_" . $value['id']; ?>">
                                                                                    <span></span>
                                                                                </label>
                                                                            </td>
                                                                            <td role="cell" id="grp2_<?= $value['id']; ?>_license" class="grp2_<?= $value['id']; ?> license_<?= $value['id']; ?>"><?= $value['licenses']; ?></td>
                                                                            <td role="cell" id="" class="text-right grp2_<?= $value['id']; ?>">€ <?= $value['node_cost']; ?></td>
                                                                            <td role="cell" class="text-right grp2_<?= $value['id']; ?>">€ <span id="grp2_<?= $value['id']; ?>_price"><?= $value['license_price']; ?></span></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::Row-->
                <!--Begin::Row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="kt-portlet kt-portlet--height-fluid">
                            <div class="kt-portlet__body">
                                <div class="table-responsive ">
                                    <form id="product_checkout" name="product_checkout" method="post">
                                    <table role="table" class="table" id="cartDataTable">
                                        <thead role="rowgroup" class="thead-light">
                                        <tr>
                                            <th role="columnheader">Product</th>
                                            <th role="columnheader">Quantity</th>
                                            <th role="columnheader">Unit Price</th>
                                            <th role="columnheader">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody role="rowgroup">
                                            <?php foreach($cartItem as $cart) { ?>
                                                <?php if($cart['product_id'] == $trading_product['product_id']) { ?>
                                                    <tr role="row">
                                                        <td role="cell">
                                                            <div class="d-flex">
                                                                <div class="mr-3"><img src="<?= Yii::app()->baseurl.''.$cart['image']; ?>" style="width: auto !important;max-width: 40px !important; height: 40px !important;"></div>
                                                                <div>
                                                                    <h5><?= $cart['name']; ?></h5>
                                                                    <div><?= $cart['description']; ?></div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="product_id[]" value="<?= $cart['product_id']; ?>">
                                                        </td>
                                                        <td role="cell">
                                                            <div class="d-flex">1</div>
                                                            <input type="hidden" name="step2_qty[]" value="<?= $cart['qty']; ?>">
                                                        </td>
                                                        <td role="cell" >€ <span><?= $cart['amount']/$cart['qty'] ?></span>
                                                            <input type="hidden" name="price[]" value="<?= $cart['amount']/$cart['qty'] ?>">
                                                        </td>
                                                        <td role="cell">€ <span><?= $cart['amount']; ?></span>
                                                            <input type="hidden" name="total_amount[]" value="<?= $cart['amount']; ?>">
                                                        </td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr role="row">
                                                        <td role="cell">
                                                            <div class="d-flex">
                                                                <div class="mr-3"><img src="<?= Yii::app()->baseurl.''.$cart['image']; ?>" style="width: auto !important; height: 40px !important;"></div>
                                                                <div>
                                                                    <h5><?= $cart['name']; ?></h5>
                                                                    <div><?= $cart['description']; ?></div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="product_id[]" value="<?= $cart['product_id']; ?>">
                                                        </td>
                                                        <td role="cell">
                                                            <div class="d-flex">
                                                                <button type="button" id="sub" class="sub btn btn-sm btn-brand mr-1">-</button>
                                                                <input type="text" name="step2_qty[]" id="step2_qty" value="<?= $cart['qty']; ?>" min="1" class="form-control form-control-xs text-center" style="width: 100px;" />
                                                                <button type="button" id="add" class="add btn btn-sm btn-brand ml-1">+</button>
                                                            </div>
                                                        </td>
                                                        <td role="cell" >€ <span id="step2_price"><?= $cart['amount']/$cart['qty'] ?></span>
                                                            <input type="hidden" name="price[]" class="step2_price_input" value="<?= $cart['amount']/$cart['qty'] ?>">
                                                        </td>
                                                        <td role="cell">€ <span id="step2_total"><?= $cart['amount']; ?></span>
                                                            <input type="hidden" name="total_amount[]" class="step2_amount_input" value="<?= $cart['amount']; ?>">
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        <input type="hidden" name="deposit" value="<?= $deposit; ?>">
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary btn-sm pull-right proceed_btn_form" type="submit">Proceed</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::Row-->
            </div>
            <!-- end:: Content -->
        </div>
    </div>
</div>

<script>
    let licenseNum = trip_completed = 0;
    let previous_group_id = is_cluster_selected = 0;
    let license_no = 0;
    let trip_id = '<?= $trip_id; ?>';
    let deposit = '<?= $deposit; ?>';

    let cashback_product_id = '<?= $cashback_product['cashback_product_id']; ?>';
    let trading_product_minimum_self_node_license_count = '<?= $trading_product['self_node_license_count']; ?>';
    let profit_node_balance = '<?= $profit_node_balance; ?>';

    $('#collapseOne6').on('shown.bs.collapse', function () {
        tripStart(trip_id);
    });
    $('#collapseOne6').on('hidden.bs.collapse', function () {
        $('.trip-block').css('display','none');
    });

    $(document).ready(function () {
        if(deposit <= 0){
            $('.card-title').addClass('collapsed');
            $('.card-title').attr("aria-expanded","false");
            $('#collapseOne6').removeClass("show");
            $('#collapseOne6').addClass("hide");
        } else {
            tripStart(trip_id);
        }
        if(trip_id == 'new'){
            $('#trading_capital').find('[data-step=new]').addClass("selected");
            $('#cbm_licenses').find('[data-step=new]').addClass("selected");
            is_cluster_selected = 0;
        } else {
            is_cluster_selected = 1;
        }
        //Select radio button in both tables
        $('#grp1_radio_' + trip_id).prop("checked", true);
        $('#grp2_radio_' + trip_id).prop("checked", true);

        /*
        * Select the background color for the selected rows in both table
        * only if license num is greater than 255 as otherwise
        * colors are updated while the trip is ongoing
        * */
        if (licenseNum >= 255) {
            $('#trading_capital').find('[data-step=' + trip_id + ']').addClass('selected');
            $('#cbm_licenses').find('[data-step=' + trip_id + ']').addClass('selected');
        }

    });

    //Update spinner in the second step of new flow
    function updateSpinnerDetails(licenseQty) {
        $("#step2_qty").val(licenseQty);
        let url = "<?= Yii::app()->createUrl('marketplace/getlicenseprice'); ?>";
        let data = {
            'licenses': licenseQty,
            'product_id': cashback_product_id
        };
        $.ajax({
            type: "get",
            url: url,
            data: data,
            success: function (data) {
                let resp = JSON.parse(data);
                $('#step2_price').html(resp.item_price);
                $('#step2_total').html(resp.subTotal);

                $('.step2_price_input').val(resp.item_price);
                $('.step2_amount_input').val(resp.subTotal);
            }
        });
    }

    //For the user-guidance trip
    function tripStart(stepId) {
        license_no = parseInt($('.license_'+stepId).html());
        let nextStepId = stepId;
        if (trip_completed == 0) {
            let execute_trip = 1;

            //Trip should not be executed if the number of licenses are greater than 255
            if (stepId) {
                if (license_no >= 255) {
                    execute_trip = 0;
                }
            }

            let tripData = [];
            let temp = {
                sel: $('.grp2_' + stepId + ':last-of-type'),
                content: "You have currently selected a deposit amount of € "+ deposit +", which would require "+ license_no +" licenses.\n" +
                "We just wanted to show you some options to optimise your purchase.\n" +
                "\n" +
                "Read carefully!",
                nextLabel: "Let's go",
                skipLabel: "No, Thanks",
                finishLabel: "Yes, I'II get that deal now!",
                position: "e"
            };
            //1st message was added which is common for both situations
            tripData.push(temp);

            //For non-cluster selection
            if (stepId == "new") {
                nextStepId = $('#trading_capital').find("[data-step='new']").next().attr("data-step");
                let next_licese_no = $('grp2_'+nextStepId+'_license').html();
                //2nd message
                temp = {
                    sel: $('.grp2_' + nextStepId + ':last-of-type'),
                    content: "Clustering optimises the amount of cashback you can earn from CBM. The bigger cluster you deposit, " +
                    "the better optimised you are. Based on your previous selection, your optimal next cluster has "+next_licese_no+" cashback nodes.\n" +
                    "Would you like to raise your deposit ?",
                    nextLabel: "Yes, Please",
                    skipLabel: "Not Now",
                    finishLabel: "Yes, I'II get that deal now!",
                    canGoPrev: false,
                    position: "e"
                };
                tripData.push(temp);

                //3rd message
                nextStepId = parseInt(nextStepId) + 1;
                temp = {
                    sel: $('.grp2_' + nextStepId + ':last-of-type'),
                    content: "Your trading capital can generate profits. Every time a profit of "+profit_node_balance+" is made, " +
                    "you automatically receive a new cashback node in CBM if you have an available license. " +
                    "Do you wish to purchase extra licenses to be prepared. Buying more licenses can get you a nice discount.",
                    nextLabel: "Yes, Please",
                    skipLabel: "Not Now",
                    finishLabel: "Yes, I'II get that deal now!",
                    position: "e"
                };
                tripData.push(temp);

            } else {
                nextStepId = parseInt(stepId) + 1;

                //2nd message
                temp = {
                    sel: $('.grp2_' + nextStepId + ':last-of-type'),
                    content: "Your trading capital can generate profits. Every time a profit of € "+profit_node_balance+" is made, " +
                    "you automatically receive a new cashback node in CBM if you have an available license. " +
                    "Do you wish to purchase extra licenses to be prepared. Buying more licenses can get you a nice discount.",
                    nextLabel: "Yes, Please",
                    skipLabel: "Not Now",
                    finishLabel: "Yes, I'II get that deal now!",
                    position: "e"
                };
                tripData.push(temp);
            }

            //Static way to check for 255 licenses
            if (nextStepId < 8) {
                //last message is common for both conditions
                nextStepId = 8;

                temp = {
                    sel: $('.grp2_' + nextStepId + ':last-of-type'),
                    content: "Last question! promise! \n" +
                    "The best deal we can offer you right now is 40% discount. Starting at 255 licenses.\n" +
                    "Remember, buying extra licenses separately will require you to pay full price.",
                    finishLabel: "Yes, I'II get that deal now!",
                    skipLabel: "No, Thanks",
                    position: "e"
                };
                tripData.push(temp);
            }
            let trip = new Trip(
                tripData, {
                    showNavigation: true,
                    showCloseBox: true,
                    delay: -1,
                    onTripChange: function (i, tripData) {
                        let className = tripData.sel[0].className;
                        let grpArr = className.split("_");
                        let grpId = grpArr[1];
                        license_no = parseInt($('.license_'+grpId).html());
                        updateSpinnerDetails(license_no);
                    },
                    onTripStart: function (tripIndex, tripObject) {
                        let className = tripObject.sel[0].className;
                        let grpArr = className.split("_");
                        let grpId = grpArr[1];
                        //Remove Skip from the trip
                        $('.trip-prev').css('display', 'none');

                        $('.treding_rows').removeClass('selected');
                        $('.license_rows').removeClass('selected');
                        if(deposit <= 0){
                            addProductToCart(cashback_product_id, trading_product_minimum_self_node_license_count);
                        }

                        $('#grp1_radio_'+grpId).prop("checked", true);
                        $('#grp2_radio_'+grpId).prop("checked", true);

                        //Selection Criteria for background color
                        if (is_cluster_selected == 0) {
                            if (tripIndex == 0 || tripIndex == 1) {
                                $('#trading_capital').find('[data-step=' + grpId + ']').addClass('selected');
                                $('#cbm_licenses').find('[data-step=' + grpId + ']').addClass('selected');
                            } else if (tripIndex == 2 || tripIndex == 3) {
                                $('#cbm_licenses').find('[data-step=' + grpId + ']').addClass('selected');
                                $('#trading_capital').find('[data-step=' + grpId + ']').addClass('selected');
                            }
                        } else if (is_cluster_selected == 1) {
                            if (tripIndex == 0) {
                                $('#trading_capital').find('[data-step=' + grpId + ']').addClass('selected');
                                $('#cbm_licenses').find('[data-step=' + grpId + ']').addClass('selected');
                            } else if (tripIndex == 1 || tripIndex == 2) {
                                $('#cbm_licenses').find('[data-step=' + grpId + ']').addClass('selected');
                                $('#trading_capital').find('[data-step=' + grpId + ']').addClass('selected');
                            }
                        }
                    },
                    onTripEnd: function (tripIndex, tripObject) {
                        let className = tripObject.sel[0].className;
                        let grpArr = className.split("_");
                        let grpId = grpArr[1];

                        if (grpId != "new") {
                            licenseNum = $('#grp2_'+grpId+'_license').html();
                            sale_price = $('#grp2_'+grpId+'_price').html();
                        } else {
                            licenseNum = $('#grp2_new_license').html();
                            sale_price = $('#grp2_new_price').html();
                        }
                        //updateSpinnerDetails(licenseNum, cashback_product_price);
                        
                        previous_group_id = grpId;
                    },
                    onEnd: function (tripIndex, tripObject) {
                        //Update license number and deposit based upon radio button selection
                        let grp2_radio_btn_id = $('input[type=radio][name=group2]:checked').attr('id');
                        let grp2_id_arr = grp2_radio_btn_id.split('_');
                        let grp2_id = grp2_id_arr[2];

                        if (grp2_id != "new") {
                            licenseNum = $('#grp2_'+grp2_id+'_license').html();
                            sale_price = $('#grp2_'+grp2_id+'_price').html();
                        } else {
                            licenseNum = $('#grp2_new_license').html();
                            sale_price = $('#grp2_new_price').html();
                        }

                        let grp1_radio_btn_id = $('input[type=radio][name=group1]:checked').attr('id');
                        if (typeof  grp1_radio_btn_id == "undefined") {
                            let grp1_id = "new";
                        } else {
                            let grp1_id_arr = grp1_radio_btn_id.split('_');
                            let grp1_id = grp1_id_arr[2];
                        }
                        trip_completed = 1;
                        //On trip completion details will be updated
                        updateSpinnerDetails(licenseNum);
                    }
                },
            );
            //To execute trip only if the number of licenses are less than 255
            if (execute_trip == 1) {
                trip.start();
            }
        }
    }

    $('body').on('change', '#step2_qty', function () {
        license_no = parseInt($("input[name='step2_qty']").val());
        updateSpinnerDetails(license_no);
    });

    $('body').on('click','.add',function () {
        $(this).prev().val(+$(this).prev().val() + 1);
        license_no =  parseInt($('#step2_qty').val());
        updateSpinnerDetails(license_no);
    });
    $('body').on('click','.sub',function () {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
            license_no = parseInt($('#step2_qty').val());
            updateSpinnerDetails(license_no);
        }
    });

    $('body').on('change','input[type=radio][name=group2]',function () {
        $('.license_rows').removeClass('selected');
        let grpId = $(this).attr('data-id');
        $('#cbm_licenses').find('[data-step=' + grpId + ']').addClass('selected');
        license_no = parseInt($('.license_'+grpId).html());
        updateSpinnerDetails(license_no);
    });

    function addProductToCart(product_id, qty){
        let url = "<?= Yii::app()->createUrl('marketplace/addToCart'); ?>";
        let cartData = {
            'product_id': product_id,
            'qty':qty
        };
        $.ajax({
            type: "POST",
            url: url,
            data: cartData,
            success: function (data) {
                let resp = JSON.parse(data);
                if(resp.token){
                    updateProductsCart(resp.cartItem);
                    appendDataItemsToCart(resp.cartData);
                }
            }
        });
    }

    //Product Items section section UI
    function updateProductsCart(cartItem) {
        let tr_row = '<tr role="row">\n' +
                '<td role="cell"><div class="d-flex">\n' +
                '<div class="mr-3"><img src="'+base_url+''+cartItem.image+'" style="width: auto !important;max-width: 40px !important; height: 40px !important;"></div>\n' +
                '<div>\n' +
                '<h5>'+cartItem.name+'</h5>\n' +
                '<div>'+cartItem.description+'</div>\n' +
                '</div>\n' +
                '</div>\n' +
                '<input type="hidden" name="product_id[]" value="'+cartItem.product_id+'">\n' +
                '</td>\n' +
                '<td role="cell">\n' +
                '<div class="d-flex">\n' +
                '<button type="button" id="sub" class="sub btn btn-sm btn-brand mr-1">-</button>\n' +
                '<input type="text" name="step2_qty[]" id="step2_qty" value="1" min="1" class="form-control form-control-xs text-center" style="width: 100px;">\n' +
                '<button type="button" id="add" class="add btn btn-sm btn-brand ml-1">+</button>\n' +
                '</div>\n' +
                '</td>\n' +
                '<td role="cell">€ <span id="step2_price">'+(cartItem.amount/cartItem.qty)+'</span>\n' +
                '<input type="hidden" name="price[]" class="step2_price_input" value="'+(cartItem.amount/cartItem.qty)+'">\n' +
                '</td>\n' +
                '<td role="cell">€ <span id="step2_total">'+cartItem.amount+'</span>\n' +
                '<input type="hidden" name="total_amount[]"  class="step2_amount_input" value="'+cartItem.amount+'">\n' +
                '</td>\n' +
                '</tr>';

        $('#cartDataTable tr:last').after(tr_row);
    }

    $('body').on('change','input[type=radio][name=group1]',function () {
        $('.treding_rows').removeClass('selected');
        let grpId = $(this).attr('data-id');
        $('#trading_capital').find('[data-step=' + grpId + ']').addClass('selected');
    });

</script>