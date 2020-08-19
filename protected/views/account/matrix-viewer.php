<?php $this->pageTitle = "Micromaxcash | Matrix Viewer";
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/fibonacci/style.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/switchery/dist/switchery.min.css'); ?>
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
                                <a href="<?= Yii::app()->createUrl('account/matrixviewer'); ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link">Cashback Nodes</span>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Matrix Viewer</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Subheader -->
                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    <div class="kt-portlet">
                        <!--begin: Side panel toggler -->
                        <!--<div class="icon-sidebar-toggle" data-toggle="kt-tooltip" title="" data-placement="top">
                            <span class="kt-header__topbar-icon" id="kt_quick_panel_toggler_btn"><i class="fa fa-bars"></i></span>
                        </div>-->
                        <!--end: Side panel toggler -->
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="d-flex align-items-center"> <span class="mr-2">Show Node</span>
                                    <select class="form-control js-example-basic-single">
                                        <?php foreach ($allNodes as $value) { ?>
                                            <?php if(!is_null($radialTreeAccountNum) && $radialTreeAccountNum==$value) { ?>
                                                <option value="<?=$value?>" selected="selected" ><?=$value?></option>
                                            <?php } else { ?>
                                                <option value="<?=$value?>" ><?=$value?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="d-flex align-items-center">
                                    <div class="mr-2">12</div>
                                    <div class="kt-switch kt-switch--sm mt-2">
                                        <label>
                                            <input type="checkbox" class="js-switch" name="" />
                                            <span></span> </label>
                                    </div>
                                    <div class="ml-2">8</div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <!--begin::Section-->
                            <div class="kt-section">
                                <div class="kt-section__content">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="matrixviewer">
                                                <div class="table-responsive table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="table-matrixviewer" style="width: 100%">
                                                                    <div class="row thead">
                                                                        <div class="col-4 th">Level</div>
                                                                        <div class="col-8 th">Nodes</div>
                                                                    </div>
                                                                    <div class="row thead">
                                                                        <div class="col-4 th"></div>
                                                                        <div class="col-4 th">Total</div>
                                                                        <div class="col-4 th">Filled</div>
                                                                    </div>
                                                                    <?php foreach ($matrixSchemeArray as $i=>$value) { ?>
                                                                        <div class="row tr">
                                                                            <div class="col-4 td"><?= $i; ?></div>
                                                                            <div class="col-4 td"><?= $value; ?></div>
                                                                            <div class="col-4 td" id="level_<?= $i; ?>"><?= $nodeLevelCounter[$i]; ?></div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="fibonacci">
                                                <svg class="fibonacci__svg fibonacci__svg--radial" width="600" height="600"></svg>
                                                <div class="fibonacci__tooltip"></div>
                                                <ul class="legends">
                                                    <li><i class="fas fa-circle icon-node6"></i>User Nodes</li>
                                                    <li><i class="fas fa-circle icon-node5"></i>Empty Nodes</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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
            const svgRadial = d3.select(".fibonacci__svg--radial");
            const tooltip = d3.select(".fibonacci__tooltip");
            const margin = { x: 50, y: 50 };

            new FibonacciTree(matrixDataJson, svgRadial, tooltip, { levels: developLevels, isRadial: true, margin });
        }
    }

    $(document).ready(function () {
        //Default radial tree
        developRadialTree(13);

        let nextLevels = 9;
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
    });

    $(document).on('change', '.js-example-basic-single', function () {
        let newNode = $(this).val();
        let genealogyUrl = "<?= Yii::app()->createUrl('account/matrixviewer') ?>";
        window.location = genealogyUrl+"?accountNum="+newNode;
    });
</script>
