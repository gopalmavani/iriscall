<?php $this->pageTitle = "Micromaxcash | List Viewer"; ?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/fibonacci/style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/switchery/dist/switchery.min.css');
?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
    <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
        <div class="kt-container kt-container--fit  kt-container--fluid  kt-grid kt-grid--ver">
            <?php echo $this->renderPartial('/account/account-aside');  ?>

            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                <!-- begin:: Subheader -->
                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
                            <h3 class="kt-subheader__title">Cashback </h3>
                            <span class="kt-subheader__separator kt-hidden"></span>
                            <div class="kt-subheader__breadcrumbs">
                                <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link">Cashback Nodes</span>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">List Viewer</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

                    <div class="accordion accordion-solid accordion-toggle-plus accordion-matrix-listviewer" id="accordionExample6">
                        <div class="card">
                            <div class="card-header" id="headingOne6">
                                <div class="card-title" data-toggle="collapse" data-target="#collapseOne6" aria-expanded="true" aria-controls="collapseOne6">
                                    <div class="kt-widget__name-label kt-font-boldest bg-primary kt-font-light mr-3">CCL</div>
                                    CCL Nodes (<?= $typeOneNodes; ?>)</div>
                            </div>
                            <div id="collapseOne6" class="collapse show" aria-labelledby="headingOne6" data-parent="#accordionExample6">
                                <div class="card-body">
                                    <div class="table-responsive table-responsive3">
                                        <table role="table" class="table table-matrix-listviewer">
                                            <thead role="rowgroup">
                                            <tr>
                                                <th width="20%" role="columnheader">Account Number</th>
                                                <th width="15%" role="columnheader">Node Number</th>
                                                <th width="15%" role="columnheader">Associated Product</th>
                                                <th width="10%" role="columnheader">Matrix Fill-up</th>
                                                <th width="10%" role="columnheader">Node Fill-up</th>
                                                <th width="30%" role="columnheader">&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody role="rowgroup">
                                                <?php foreach ($node_specific_response as $accountNum=>$node) {
                                                    if($node['type'] == 1){ ?>
                                                        <tr role="row">
                                                            <td role="cell"><?= $accountNum; ?></td>
                                                            <?php if($node['activated'] == 1) { ?>
                                                                <td role="cell"><i class="fas fa-circle icon-node1 mr-2"></i><?= $node['nodeNumber']; ?></td>
                                                            <?php } else { ?>
                                                                <td role="cell"><i class="fas fa-circle icon-node2 mr-2"></i>-</td>
                                                            <?php } ?>
                                                            <td role="cell"><?= $node['associatedProduct']; ?></td>
                                                            <td role="cell"><?= $node['totalNodes']; ?>/376</td>
                                                            <td role="cell">
                                                            <?php if($node['activated'] == 1) { ?>
                                                                <div id="node_fill_up_container_<?= $node['nodeNumber']; ?>"></div>
                                                            <?php } else { ?>
                                                                <div id="node_fill_up_container_<?= 0; ?>"></div>
                                                            <?php } ?>
                                                            </td>
                                                            <td role="cell" class="col-action">
                                                                <!--<a href="#" class="btn btn-label btn-label-brand btn-sm btn-bold" data-toggle="modal" data-target="#modal-matrixviewer"> <i class="fas fa-toggle-on"></i><span>Progress<br> Viewer</span> </a>-->
                                                                <button onclick="matrixViewer('<?= $accountNum; ?>',1)" class="btn btn-label btn-label-brand btn-sm btn-bold"> <i class="fas fa-sitemap"></i><span>Hierarchy<br>Viewer</span> </button>
                                                                <button onclick="matrixViewer('<?= $accountNum; ?>',2)" class="btn btn-label btn-label-brand btn-sm btn-bold"> <i class="fas fa-snowflake"></i><span>Radial<br>Viewer</span> </button>
                                                            </td>
                                                        </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <ul class="legends">
                                        <li><i class="fas fa-circle icon-node1"></i>Active Node</li>
                                        <li><i class="fas fa-circle icon-node2"></i>Deactivated Node</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo6">
                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseTwo6" aria-expanded="false" aria-controls="collapseTwo6">
                                    <div class="kt-widget__name-label kt-font-boldest bg-secondary kt-font-light mr-3">M</div>
                                    M Nodes (<?= $typeTwoNodes; ?>) </div>
                            </div>
                            <div id="collapseTwo6" class="collapse" aria-labelledby="headingTwo6" data-parent="#accordionExample6">
                                <div class="card-body">
                                    <div class="table-responsive table-responsive3">
                                        <table role="table" class="table table-matrix-listviewer">
                                            <thead role="rowgroup">
                                            <tr>
                                                <th width="20%" role="columnheader">Account Number</th>
                                                <th width="15%" role="columnheader">Node Number</th>
                                                <th width="15%" role="columnheader">Associated Product</th>
                                                <th width="10%" role="columnheader">Matrix Fill-up</th>
                                                <th width="10%" role="columnheader">Node Fill-up</th>
                                                <th width="30%" role="columnheader">&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody role="rowgroup">
                                            <?php foreach ($node_specific_response as $accountNum=>$node) {
                                                if($node['type'] == 2){ ?>
                                                    <tr role="row">
                                                        <td role="cell"><?= $accountNum; ?></td>
                                                        <?php if($node['activated'] == 1) { ?>
                                                            <td role="cell"><i class="fas fa-circle icon-node1 mr-2"></i><?= $node['nodeNumber']; ?></td>
                                                        <?php } else { ?>
                                                            <td role="cell"><i class="fas fa-circle icon-node2 mr-2"></i>-</td>
                                                        <?php } ?>
                                                        <td role="cell"><?= $node['associatedProduct']; ?></td>
                                                        <td role="cell"><?= $node['totalNodes']; ?>/376</td>
                                                        <td role="cell">
                                                            <?php if($node['activated'] == 1) { ?>
                                                                <div id="node_fill_up_container_<?= $node['nodeNumber']; ?>"></div>
                                                            <?php } else { ?>
                                                                <div id="node_fill_up_container_<?= 0; ?>"></div>
                                                            <?php } ?>
                                                        </td>
                                                        <td role="cell" class="col-action">
                                                            <!--<a href="#" class="btn btn-label btn-label-brand btn-sm btn-bold" data-toggle="modal" data-target="#modal-matrixviewer"> <i class="fas fa-toggle-on"></i><span>Progress<br> Viewer</span> </a>-->
                                                            <button onclick="matrixViewer('<?= $accountNum; ?>',1)" class="btn btn-label btn-label-brand btn-sm btn-bold"> <i class="fas fa-sitemap"></i><span>Hierarchy<br>Viewer</span> </button>
                                                            <button onclick="matrixViewer('<?= $accountNum; ?>',2)" class="btn btn-label btn-label-brand btn-sm btn-bold"> <i class="fas fa-snowflake"></i><span>Radial<br>Viewer</span> </button>
                                                        </td>
                                                    </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <ul class="legends">
                                        <li><i class="fas fa-circle icon-node1"></i>Active Node</li>
                                        <li><i class="fas fa-circle icon-node2"></i>Deactivated Node</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-matrixviewer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Matrix Viewer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body text-center">
                <div class="matrixviewer svg_radial" style="display: none">
                    <svg class="fibonacci__svg fibonacci__svg--radial" width="700" height="700"></svg>
                </div>
                <div class="matrixviewer svg_hierarchical" style="display: none">
                    <svg class="fibonacci__svg fibonacci__svg--hierarchical" width="1300" height="700"></svg>
                </div>
                <div class="text-center">
                    <ul class="legends">
                        <li><i class="fas fa-circle icon-node6"></i>User Nodes</li>
                        <li><i class="fas fa-circle icon-node3"></i>Empty Nodes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo Yii::app()->baseUrl ?>/js/highstock.js"></script>
<script type="text/javascript" src="https://d3js.org/d3.v5.min.js"></script>
<script type="text/javascript" src="https://d3js.org/d3-dsv.v1.min.js"></script>
<script type="text/javascript" src="https://d3js.org/d3-fetch.v1.min.js"></script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/fibonacci/js/fibonacci-tree.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/fibonacci/js/tree-generator.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/switchery/dist/switchery.min.js');
?>
<script type="text/javascript">

    function matrixViewer(accountNum, type) {
        let radialTreeGeneratorURL = "<?= Yii::app()->createUrl('account/generateradialtree'); ?>";
        $.ajax({
            type: "POST",
            url: radialTreeGeneratorURL,
            data: {
                'accountNum':accountNum
            },
            beforeSend: function () {
                $(".se-pre-con").css('display','block');
            },
            success: function (data) {
                //remove the tree first
                $('.fibonacci__svg').empty();
                let matrixDataJson = JSON.parse(data);
                if(matrixDataJson.length > 0){
                    const toCsvArray = (d) => ({
                        id: +d.id,
                        accountNo: d.cbm_account_num,
                        userId: d.user_id,
                        email: d.email,
                        lchild: +d.lchild,
                        rchild: +d.rchild,
                    });

                    if(type == 1){
                        $('.svg_radial').css('display','none');
                        $('.svg_hierarchical').css('display','block');
                        const svgHierarchical = d3.select(".fibonacci__svg--hierarchical");
                        /*.call(d3.zoom().on("zoom", () =>
                            svgHierarchical.select("g").attr("transform", d3.event.transform)));*/
                        const tooltip = d3.select(".fibonacci__tooltip");
                        const margin = { x: 50, y: 50 };
                        new FibonacciTree(matrixDataJson, svgHierarchical, tooltip, { levels: 13, isRadial: false, margin });
                    } else {
                        $('.svg_radial').css('display','block');
                        $('.svg_hierarchical').css('display','none');
                        const svgRadial = d3.select(".fibonacci__svg--radial")
                            /*.call(d3.zoom().on("zoom", () =>
                                svgRadial.select("g").attr("transform", d3.event.transform)))*/;
                        const tooltip = d3.select(".fibonacci__tooltip");
                        const margin = { x: 50, y: 50 };
                        new FibonacciTree(matrixDataJson, svgRadial, tooltip, { levels: 13, isRadial: true, margin });
                    }

                    $(".se-pre-con").css('display','none');
                    $('#modal-matrixviewer').modal('show');
                }
            }
        });
    }

    let node_specific_data = $.parseJSON('<?= json_encode($node_specific_response); ?>');
    $.each(node_specific_data, function(item, index){
        let filledPercentage = 100*(index.totalNodes)/376;
        let remainingPercentage = 100 - filledPercentage;
        Highcharts.chart('node_fill_up_container_'+index.nodeNumber, {
            chart: {
                type: 'pie',
                height: 80
            },
            title: false,
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            tooltip: false,
            series: [ {
                data: [['filled', filledPercentage], ['empty', remainingPercentage]],
                size: '80%',
                innerSize: '60%',
                dataLabels: false
            }]
        });
    });
</script>
