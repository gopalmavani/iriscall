<style>
    /* basic positioning */
    .legend { list-style: none; }
    .legend li { float: left; margin-right: 10px; }
    .legend span { border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 2px; border-radius: 10px}
    /* your colors */
    .legend .self_nodes { background-color: #4BBFF8; }
    .legend .else_nodes { background-color: #F4A540; }
    .table td, .table th{
        padding: 6px 5px;
    }
</style>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/fibonacci/style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/switchery/dist/switchery.min.css');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12"> <a href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
            <div id="wrapper" class="toggled">
                <!-- Popover content -->
                <div id="sidebar-wrapper">
                    <div class="card">
                        <div class="card-body" style="margin-top: 60px">
                            <!-- Nav tabs start -->
                            <ul class="nav nav-tabs customtab2" role="tablist">
                                <li class="nav-item"><a class="nav-link link-all" data-toggle="tab" href="#tab-all" role="tab"><span>All 100%</span></a></li>
                                <li class="nav-item"><a class="nav-link active link-cb" data-toggle="tab" href="#tab-cb" role="tab"><span data-toggle="tooltip" data-placement="top" title="Cashback Matrix (85.72%)">CB</span></a></li>
                                <li class="nav-item"><a class="nav-link link-ca" data-toggle="tab" href="#tab-ca" role="tab"><span data-toggle="tooltip" data-placement="top" title="Corporate Account (0.0053%)">CA</span></a></li>
                                <li class="nav-item"><a class="nav-link link-ic" data-toggle="tab" href="#tab-ic" role="tab"><span data-toggle="tooltip" data-placement="top" title="Incubator Chain (0.0021%)">IC</span></a></li>
                                <li class="nav-item"><a class="nav-link link-bc" data-toggle="tab" href="#tab-bc" role="tab"><span data-toggle="tooltip" data-placement="top" title="Backup Cycle (0.0053%)">BC</span></a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- tab 1 start -->
                                <div class="tab-pane" id="tab-all" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-striped color-bordered-table primary-bordered-table table-all">
                                            <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>
                                                    Volume</th>
                                                <th class="col-dark">CB%</th>
                                                <th class="col-dark" colspan="2">Cashback
                                                    <div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                            ?>
                                            <?php foreach ($matrixPercentageArray as  $key=>$value) { ?>
                                                <?php
                                                    $comm_value =  0.25 * $matrixSchemeArray[$key];
                                                    $projected_value = $comm_value * $value/100;
                                                    $actual_value = 0.25 * $nodeLevelCounter[$key] * $value / 100;
                                                    $total_projected_value += $projected_value;
                                                    $total_actual_value += $actual_value;
                                                ?>
                                                <tr>
                                                    <td class="col-dark"><?= round($comm_value, 5); ?> ‎&euro;</td>
                                                    <td class="col-dark"><?= round($value, 5); ?>%</td>
                                                    <td class="col-light"><?= round($projected_value, 5); ?> ‎&euro;</td>
                                                    <td><?= round($actual_value, 5); ?> ‎&euro;</td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light"><?= round($total_projected_value, 5) ?> ‎&euro;</td>
                                                <td><?= round($total_actual_value, 5); ?> &euro;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped color-bordered-table primary-bordered-table table-info">
                                            <thead>
                                            <tr>
                                                <th class="col-dark">Swimlane Distribution</th>
                                                <th class="col-dark text-right">11,665 ‎&euro;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Cashback matrix</td>
                                                <td class="text-right">10 ‎&euro;</td>
                                            </tr>
                                            <tr>
                                                <td>PS</td>
                                                <td class="text-right">0,165 ‎&euro;</td>
                                            </tr>
                                            <tr>
                                                <td>Corporate account</td>
                                                <td class="text-right">0,25 ‎&euro;</td>
                                            </tr>
                                            <tr>
                                                <td>Incubator Chain</td>
                                                <td class="text-right">1 ‎&euro;</td>
                                            </tr>
                                            <tr>
                                                <td>Backup cycle</td>
                                                <td class="text-right">0,25 ‎&euro;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- tab 1 end -->
                                <!-- tab2 start -->
                                <div class="tab-pane active" id="tab-cb" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-striped color-bordered-table primary-bordered-table table-cb">
                                            <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>
                                                    Volume</th>
                                                <th class="col-dark">CB%</th>
                                                <th class="col-dark" colspan="2">Cashback
                                                    <div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                            ?>
                                            <?php foreach ($matrixPercentageArray as  $key=>$value) { ?>
                                                <?php
                                                $cashback_percentage = 85.72/100;
                                                $comm_value =  0.25 * $matrixSchemeArray[$key] * $cashback_percentage;
                                                $projected_value = $comm_value * $value/100;
                                                $actual_value = 0.25 * $nodeLevelCounter[$key] * $value/100 * $cashback_percentage;
                                                $total_projected_value += $projected_value;
                                                $total_actual_value += $actual_value;
                                                ?>
                                                <tr>
                                                    <td class="col-dark"><?= round($comm_value, 5); ?> ‎&euro;</td>
                                                    <td class="col-dark"><?= round($value, 5); ?>%</td>
                                                    <td class="col-light"><?= round($projected_value, 5); ?> ‎&euro;</td>
                                                    <td><?= round($actual_value, 5); ?> ‎&euro;</td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light"><?= round($total_projected_value, 2) ?> ‎&euro;</td>
                                                <td><?= round($total_actual_value, 2); ?> &euro;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- tab 2 end -->
                                <!-- tab 3 start -->
                                <div class="tab-pane" id="tab-ca" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-striped color-bordered-table primary-bordered-table table-ca">
                                            <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>
                                                    Volume</th>
                                                <th class="col-dark">CA%</th>
                                                <th class="col-dark" colspan="2">Cashback
                                                    <div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                            ?>
                                            <?php foreach ($matrixPercentageArray as  $key=>$value) { ?>
                                                <?php
                                                $cashback_percentage = 2.1432/100;
                                                $comm_value =  0.25 * $matrixSchemeArray[$key] * $cashback_percentage;
                                                $projected_value = $comm_value * $value/100;
                                                $actual_value = 0.25 * $nodeLevelCounter[$key] * $value/100 * $cashback_percentage;
                                                $total_projected_value += $projected_value;
                                                $total_actual_value += $actual_value;
                                                ?>
                                                <tr>
                                                    <td class="col-dark"><?= round($comm_value, 5); ?> ‎&euro;</td>
                                                    <td class="col-dark"><?= round($value, 5); ?>%</td>
                                                    <td class="col-light"><?= round($projected_value, 5); ?> ‎&euro;</td>
                                                    <td><?= round($actual_value, 5); ?> ‎&euro;</td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light"><?= round($total_projected_value, 5) ?> ‎&euro;</td>
                                                <td><?= round($total_actual_value, 5); ?> &euro;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- tab 3 end -->
                                <!-- tab 4 start -->
                                <div class="tab-pane" id="tab-ic" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-striped color-bordered-table primary-bordered-table table-ic">
                                            <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>
                                                    Volume</th>
                                                <th class="col-dark">IC%</th>
                                                <th class="col-dark" colspan="2">Cashback
                                                    <div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                            ?>
                                            <?php foreach ($matrixPercentageArray as  $key=>$value) { ?>
                                                <?php
                                                $cashback_percentage = 8.5726/100;
                                                $comm_value =  0.25 * $matrixSchemeArray[$key] * $cashback_percentage;
                                                $projected_value = $comm_value * $value/100;
                                                $actual_value = 0.25 * $nodeLevelCounter[$key] * $value/100 * $cashback_percentage;
                                                $total_projected_value += $projected_value;
                                                $total_actual_value += $actual_value;
                                                ?>
                                                <tr>
                                                    <td class="col-dark"><?= round($comm_value, 5); ?> ‎&euro;</td>
                                                    <td class="col-dark"><?= round($value, 5); ?>%</td>
                                                    <td class="col-light"><?= round($projected_value, 5); ?> ‎&euro;</td>
                                                    <td><?= round($actual_value, 5); ?> ‎&euro;</td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light"><?= round($total_projected_value, 2) ?> ‎&euro;</td>
                                                <td><?= round($total_actual_value, 2); ?> &euro;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- tab 4 end -->
                                <!-- tab 5 start -->
                                <div class="tab-pane" id="tab-bc" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-striped color-bordered-table primary-bordered-table table-bc">
                                            <thead>
                                            <tr>
                                                <th class="col-dark">Comms<br>
                                                    Volume</th>
                                                <th class="col-dark">BC%</th>
                                                <th class="col-dark" colspan="2">Cashback
                                                    <div class="text-xs">(if volume are met)</div></th>
                                            </tr>
                                            <tr class="subheading">
                                                <th class="col-dark"></th>
                                                <th class="col-dark"></th>
                                                <th class="col-dark">Potential</th>
                                                <th class="col-dark">Filled</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $total_projected_value = 0;
                                            $total_actual_value = 0;
                                            ?>
                                            <?php foreach ($matrixPercentageArray as  $key=>$value) { ?>
                                                <?php
                                                $cashback_percentage = 2.1432/100;
                                                $comm_value =  0.25 * $matrixSchemeArray[$key] * $cashback_percentage;
                                                $projected_value = $comm_value * $value/100;
                                                $actual_value = 0.25 * $nodeLevelCounter[$key] * $value/100 * $cashback_percentage;
                                                $total_projected_value += $projected_value;
                                                $total_actual_value += $actual_value;
                                                ?>
                                                <tr>
                                                    <td class="col-dark"><?= round($comm_value, 5); ?> ‎&euro;</td>
                                                    <td class="col-dark"><?= round($value, 5); ?>%</td>
                                                    <td class="col-light"><?= round($projected_value, 5); ?> ‎&euro;</td>
                                                    <td><?= round($actual_value, 5); ?> ‎&euro;</td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td class="col-dark"></td>
                                                <td class="col-dark">100%</td>
                                                <td class="col-light"><?= round($total_projected_value, 5) ?> ‎&euro;</td>
                                                <td><?= round($total_actual_value, 5); ?> &euro;</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- tab 5 end -->
                            </div>
                            <!-- Nav tabs end -->
                        </div>
                    </div>
                </div>
                <!-- Popover content -->
                <div id="page-content-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#level_tab"
                                                                role="tab"><span
                                                        class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                                        class="hidden-xs-down">Matrix Viewer</span></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#software_license_tab" id="software_license_link"
                                                                role="tab"><span
                                                        class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                                        class="hidden-xs-down">Software License</span></a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active" id="level_tab" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-8 col-xl-9">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-sm-flex">
                                                                <div class="switchery-demo mb2-xs text-center"> 8
                                                                    <span class="ml-2 mr-2"><input type="checkbox" class="js-switch" data-color="#ee5ea6" data-secondary-color="#1ca3ff" /></span> 12
                                                                </div>
                                                                <div class="ml-auto button-bl">
                                                                    <div class="mb1">
                                                                        <!--<div class="btn-group">
                                                                            <button type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select Nodes <i class="fa fa-circle icon-node node1 ml-2"></i> </button>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="#">Show second available position <i class="fa fa-circle icon-node node2 ml-2"></i></a>
                                                                                <a class="dropdown-item" href="#">Show third available position <i class="fa fa-circle icon-node node3 ml-2"></i></a>
                                                                            </div>
                                                                        </div>-->
                                                                        <select class="js-example-basic-single dropdown-menu" name="state">
                                                                            <?php foreach ($allNodes as $value) { ?>
                                                                                <?php if(!is_null($radialTreeAccountNum) && $radialTreeAccountNum==$value) { ?>
                                                                                    <option value="<?=$value?>" selected="selected"><?= $value; ?></option>
                                                                                <?php } else { ?>
                                                                                    <option value="<?=$value?>"><?= $value; ?></option>
                                                                                <?php } ?>

                                                                                <!--<a class="dropdown-item" href="#"><?/*= $value; */?><i class="fa fa-circle icon-node node1 ml-2"></i></a>-->
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                   <!-- <div>
                                                                        <div class="btn-group">
                                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select node in center position </button>
                                                                            <div class="dropdown-menu"> <a class="dropdown-item" href="#">Select node in center position</a> <a class="dropdown-item" href="#">Select node in left position</a> <a class="dropdown-item" href="#">Select node in right position</a> </div>
                                                                        </div>
                                                                    </div>-->
                                                                </div>
                                                            </div>
                                                            <div class="matrixviewer">
                                                                <div class="fibonacci">
                                                                    <svg class="fibonacci__svg fibonacci__svg--radial" width="600" height="600"></svg>
                                                                    <div class="fibonacci__tooltip"></div>
                                                                    <ul class="legend">
                                                                        <li><span class="self_nodes"></span>User Nodes</li>
                                                                        <li><span class="else_nodes"></span>Empty Nodes</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <!--<div class="legends">
                                                                        <div class="row m0 d-flex">
                                                                            <div class="col-sm-3 p0">
                                                                                <ul>
                                                                                    <li><i class="fa fa-circle icon-node node1"></i>My nodes</li>
                                                                                    <li><i class="fa fa-circle icon-node node2"></i>My profit nodes</li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-sm-3 p0">
                                                                                <ul>
                                                                                    <li><i class="fa fa-circle icon-node node3"></i>Personal referrals</li>
                                                                                    <li><i class="fa fa-circle icon-node node4"></i>Referral profit nodes</li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-sm-3 p0">
                                                                                <ul>
                                                                                    <li><i class="fa fa-circle icon-node node5"></i>Multi tier referrals</li>
                                                                                    <li><i class="fa fa-circle icon-node node6"></i>MTR profit node</li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-sm-3 p0">
                                                                                <ul class="noborder">
                                                                                    <li><i class="fa fa-circle icon-node node7"></i>Overflow customers</li>
                                                                                    <li><i class="fa fa-circle icon-node node8"></i>Overflow profit nodes</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped color-bordered-table primary-bordered-table table-matrixviewer">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="col-dark">Level</th>
                                                                        <th class="col-dark" colspan="2">Nodes</th>
                                                                    </tr>
                                                                    <tr class="subheading">
                                                                        <th class="col-dark"></th>
                                                                        <th class="col-dark">Total</th>
                                                                        <th class="col-dark">Filled</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php foreach ($matrixSchemeArray as $i=>$value) { ?>
                                                                        <tr>
                                                                            <td class="col-dark"><?= $i; ?></td>
                                                                            <td class="col-light"><?= $value; ?></td>
                                                                            <td id="level_<?= $i; ?>"><?= $nodeLevelCounter[$i]; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <tr>
                                                                        <td class="col-dark"></td>
                                                                        <td class="col-light">376</td>
                                                                        <td><?= array_sum($nodeLevelCounter); ?></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="software_license_tab" role="tabpanel">
                                            <div class="row mt-2">
                                                <div class="col-md-8">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="card-title">First Level Users</h4>
                                                            <h6 class="card-subtitle">Users that were directly registered through your affiliate link</h6>
                                                            <table id="demo-foo-row-toggler" class="table toggle-circle table-hover">
                                                                <thead>
                                                                <tr>
                                                                    <th data-toggle="true"> Name</th>
                                                                    <th>Clients</th>
                                                                    <th>Licenses</th>
                                                                    <th data-hide="all"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php foreach ($finalDataArr as $item) { ?>
                                                                    <tr>
                                                                        <td><?= $item['name']; ?><br>
                                                                            <small class="text-muted" style="margin-left: 25px"><?= $item['email']; ?></small>
                                                                        </td>
                                                                        <td><?= $item['client_count']; ?></td>
                                                                        <td><?= $item['license_count']; ?>/<span style="font-size: larger; color: #28a745"><?= $item['active_license_count']; ?></span></td>
                                                                        <td>
                                                                            <div class="row" style="margin-left: 15px;">
                                                                                <?php if(!empty($item['inner_level'])) { ?>
                                                                                    <div class="col-md-12">
                                                                                        <div class="card">
                                                                                            <div class="card-body">
                                                                                                <h4 class="card-title">Level 2 Node Details</h4>
                                                                                                <h6 class="card-subtitle">Level 1 users of <?= $item['name']; ?></h6>
                                                                                                <div class="profiletimeline m-t-40">
                                                                                                    <?php foreach ($item['inner_level'] as $levelTwo) { ?>
                                                                                                        <div class="sl-item">
                                                                                                            <div class="sl-left">
                                                                                                                <img src="<?php echo Yii::app()->request->baseUrl ?>/images/male-user.png" alt="user" class="img-circle">
                                                                                                            </div>
                                                                                                            <div class="sl-right">
                                                                                                                <div><a href="#" class="link"><?= $levelTwo['name']; ?></a>
                                                                                                                    <div class="like-comm" style="margin: 20px">
                                                                                                                        <span class="m-b-10" style="font-size: larger; padding-right: 30px"><i class="fa fa-users text-danger fa-lg"></i> Total Clients: <?= $levelTwo['client_count']; ?></span>
                                                                                                                        <span class="m-b-10" style="font-size: larger; padding-right: 30px"><i class="fa fa-id-card text-warning fa-lg"></i> Total Licenses: <?= $levelTwo['license_count']; ?></span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } else { ?>
                                                                                    <p>No Clients have been added yet.</p>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                                <?php if(count($finalDataArr) > 10) { ?>
                                                                    <tfoot>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <div class="text-right">
                                                                                <ul class="pagination pagination-split m-t-30"> </ul>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tfoot>
                                                                <?php } ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="card card-outline-info">
                                                        <div class="card-header">
                                                            <h4 class="m-b-0 text-white text-center">CBM Licenses</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <blockquote>
                                                                <p class="card-text text-primary" style="font-size: large">First Tier Clients: <strong style="font-size: larger"><?= $firstTierClients; ?></strong></p>
                                                                <p class="card-text" style="font-size: large; color: #28a745">First Tier Licenses: <strong style="font-size: larger"><?= $firstTierLicenses; ?></strong></p>
                                                            </blockquote>
                                                            <blockquote>
                                                                <p class="card-text text-primary" style="font-size: large">Second Tier Clients: <strong style="font-size: larger"><?= $secondTierClients; ?></strong></p>
                                                                <p class="card-text" style="font-size: large; color: #28a745">Second Tier Licenses: <strong style="font-size: larger"><?= $secondTierLicenses; ?></strong></p>
                                                            </blockquote>
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
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#demo-foo-row-toggler').footable();
    $('#demo-foo-row-toggler').change(function (e) {
        e.preventDefault();
        let pageSize = 10;
        $('#demo-foo-row-toggler').data('page-size', pageSize);
        $('#demo-foo-row-toggler').trigger('footable_initialized');
    });
    $('.nav-tabs a').on('shown.bs.tab', function () {
        $('.footable').trigger('footable_resize');
    });
</script>
<script type="text/javascript" src="https://d3js.org/d3.v5.min.js"></script>
<script type="text/javascript" src="https://d3js.org/d3-dsv.v1.min.js"></script>
<script type="text/javascript" src="https://d3js.org/d3-fetch.v1.min.js"></script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/fibonacci/js/fibonacci-tree.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/fibonacci/js/tree-generator.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/switchery/dist/switchery.min.js');
?>
<script type="text/javascript">
    const matrixData = '<?= json_encode($matrixData); ?>';
    const matrixDataJson = JSON.parse(matrixData);

    /*
    * Fibonacci tree development
    * */
    function developRadialTree(developLevels) {
        if(matrixDataJson.length > 0){
            const toCsvArray = (d) => ({
                id: +d.id,
                accountNo: d.cbm_account_num,
                userId: d.user_id,
                email: d.email,
                lchild: +d.lchild,
                rchild: +d.rchild,
            });

            /*const svgHierarchical = d3.select(".fibonacci__svg--hierarchical")
                .call(d3.zoom().on("zoom", () =>
                    svgHierarchical.select("g").attr("transform", d3.event.transform)));*/

            const svgRadial = d3.select(".fibonacci__svg--radial")
                /*.call(d3.zoom().on("zoom", () =>
                    svgRadial.select("g").attr("transform", d3.event.transform)))*/;

            const tooltip = d3.select(".fibonacci__tooltip");

            const margin = { x: 50, y: 50 };

            //new FibonacciTree(matrixDataJson, svgHierarchical, tooltip, { levels: 12, isRadial: false, margin });
            new FibonacciTree(matrixDataJson, svgRadial, tooltip, { levels: developLevels, isRadial: true, margin });
            /*d3.csv("sample-data.csv", toCsvArray).then(data => {
                new FibonacciTree(data, svgHierarchical, tooltip, { levels: 12, isRadial: false, margin });
                new FibonacciTree(data, svgRadial, tooltip, { levels: 12, isRadial: true, margin });
            });*/
        }
    }

    $(document).ready(function () {

        $('.js-example-basic-single').select2();

        //Default radial tree
        developRadialTree(9);

        // Switchery
        let nextLevels = 13;
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-switch').on('change', function () {
            //remove the tree first
            $('.fibonacci__svg').empty();
            developRadialTree(nextLevels);
            if(nextLevels == 9){
                nextLevels = 13;
            } else {
                nextLevels = 9;
            }

        });

        //To maintain left panel state
        if(localStorage['leftPanel'] == 0){
            setTimeout(function() {
                $(".sidebartoggler")[0].click();
            },2000);
        }

        //To maintain right panel state
        if(localStorage['rightPanel'] == 1){
            $("#wrapper").toggleClass("toggled");
        }

        $('.sidebartoggler').on('click', function () {
            if($('#logo2').is(':visible')){
                localStorage['leftPanel'] = 1;
            } else {
                localStorage['leftPanel'] = 0;
            }
        });
    });

    $(document).on('change', '.js-example-basic-single', function () {
        let newNode = $(this).val();
        let genealogyUrl = "<?= Yii::app()->createUrl('genealogy/index') ?>";
        window.location = genealogyUrl+"?accountNum="+newNode;
    });

    //After d3 functionality, nodeClick would be called for updating the table
    function nodeClick(e) {
        let nodeLevelCounterUrl = "<?= Yii::app()->createUrl('genealogy/calculateNodeChild'); ?>";
        $.ajax({
            type: "POST",
            url: nodeLevelCounterUrl,
            data: {
                'nodeId':e
            },
            success: function (data) {
                let response = JSON.parse(data);
                if(response['status'] == 1){
                    let nodeLevelData = response['data'];
                    $.each(nodeLevelData, function (key, value) {
                        $('#level_'+key).html(value);
                    })
                }
            }
        });
    }

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        if($('#wrapper').hasClass('toggled')){
            //Closed state
            localStorage['rightPanel'] = 0;
        } else {
            //Open state
            localStorage['rightPanel'] = 1;
        }
    });

    //Do not remove this code
    /*$(window).resize(function(e) {
        if($(window).width()<=1024){
            $("#wrapper").removeClass("toggled");
        }else{
            $("#wrapper").addClass("toggled");
        }
    });*/
</script>
