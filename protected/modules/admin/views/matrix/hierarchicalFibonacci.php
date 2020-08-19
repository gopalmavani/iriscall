<?php
$this->pageTitle = 'Hierarchical Fifty Euro Matrix';
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/plugins/fibonacci/style.css');
?>
<div class="fibonacci">
    <svg class="fibonacci__svg fibonacci__svg--hierarchical" width="1200" height="600"></svg>
    <div class="fibonacci__tooltip"></div>
</div>
<script type="text/javascript" src="https://d3js.org/d3.v5.min.js"></script>
<script type="text/javascript" src="https://d3js.org/d3-dsv.v1.min.js"></script>
<script type="text/javascript" src="https://d3js.org/d3-fetch.v1.min.js"></script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/fibonacci/js/fibonacci-tree.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/plugins/fibonacci/js/tree-generator.min.js');
?>
<script type="text/javascript">
    const matrixData = '<?= $matrix_data; ?>';
    const matrixDataJson = JSON.parse(matrixData);
    const toCsvArray = (d) => ({
        id: +d.id,
        accountNo: d.cbm_account_num,
        userId: d.user_id,
        email: d.email,
        lchild: +d.lchild,
        rchild: +d.rchild,
    });

    const svgHierarchical = d3.select(".fibonacci__svg--hierarchical")
        .call(d3.zoom().on("zoom", () =>
            svgHierarchical.select("g").attr("transform", d3.event.transform)));

    const svgRadial = d3.select(".fibonacci__svg--radial")
        .call(d3.zoom().on("zoom", () =>
            svgRadial.select("g").attr("transform", d3.event.transform)));

    const tooltip = d3.select(".fibonacci__tooltip");

    const margin = { x: 50, y: 50 };

    new FibonacciTree(matrixDataJson, svgHierarchical, tooltip, { levels: 12, isRadial: false, margin });
    //new FibonacciTree(matrixDataJson, svgRadial, tooltip, { levels: 12, isRadial: true, margin });
    /*d3.csv("sample-data.csv", toCsvArray).then(data => {
        new FibonacciTree(data, svgHierarchical, tooltip, { levels: 12, isRadial: false, margin });
        new FibonacciTree(data, svgRadial, tooltip, { levels: 12, isRadial: true, margin });
    });*/
</script>