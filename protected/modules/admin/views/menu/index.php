<?php
/* @var $this MenuController */
/* @var $model CylTables*/

$this->pageTitle = 'Menu';
?>
<style>
    .edit{
        float: right;
    }
</style>
<div class="row" style="margin-left: 59%;">
    <div class="col-md-12">
        <div class="col-md-3" style="padding: 0px 0px 10px 0px;" >
            <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('admin/builder/create'); ?>">Create CRUD menu item</a>
        </div>
        <!--<div class="col-md-3" style="padding: 0px 0px 10px 0px; width: 24%;">
                <a class="btn btn-primary" href="<?php /*echo Yii::app()->createUrl('admin/menu/create/1'); */?>">Create non-CRUD menu item</a>
            </div>-->
        <div class="col-md-3" style=" padding: 0px 0px 10px 0px; margin-left: 26%;">
            <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('admin/menu/create/2'); ?>">Create Parent menu item</a>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <h3 class="block-title" style="padding-bottom: 10px">Menu</h3>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="block">
                            <div id="tree1"></div>
                        </div>
                        <div class="alert successMsgC hide alert-success fade in">
                            <strong id="successMsg"></strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="button" id="treeData" class="btn btn-primary" value="Save Menu" style="float: right;">
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var data1 = [];
    <?php foreach ($menu as $key => $value):?>
    var Grandchildrens = [];
    var childrens = [];
    <?php
    //$model = CylTables::model()->findAllByAttributes(['parent_item' => $value['table_id']]);
    $model = Yii::app()->db->createCommand('SELECT * FROM `cyl_tables` WHERE `parent_item` = '.$value['table_id'].'  ORDER BY `menu_order`')->queryAll();
    if(count($model) > 0): ?>
    <?php foreach ($model as $child): ?>
    <?php
    //$model2 = CylTables::model()->findAllByAttributes(['parent_item' => $child->table_id]);
    $model2 = Yii::app()->db->createCommand('SELECT * FROM `cyl_tables` WHERE `parent_item` = '.$child['table_id'].'  ORDER BY `menu_order`')->queryAll();
    if(count($model2) > 0): ?>
    <?php foreach ($model2 as $chld): ?>
    Grandchildrens.push({
        'name':'<?php echo $chld['menu_name']; ?>', 'id' : '<?php echo $chld['menu_icon']; ?>'
    });
    <?php endforeach; ?>
    childrens.push({
        'name':'<?php echo $child['menu_name']; ?>', 'id' : '<?php echo $child['menu_icon']; ?>'
        'children' : Grandchildrens
    });
    <?php else: ?>
    childrens.push({
        'name':'<?php echo $child['menu_name']; ?>', 'id' : '<?php echo $child['menu_icon']; ?>'
    });
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>

    data1.push({
        name: '<?= $value['menu_name']; ?>',id:'<?php echo $value['menu_icon']; ?>',
        children: childrens
    });
    <?php endforeach; ?>

    $(function () {
        $('#tree1').tree({
            data: data1,
            onCanMoveTo: function(moved_node, target_node, position) {
                if(moved_node.children && target_node.children && position == 'inside'){
                    // Example: can move inside menu, not before or after
                    return false;
                }
                else {
                    return true;
                }
            },
            //autoOpen: true,
            dragAndDrop: true,
            autoOpen: 1,
            onCreateLi: function(node, $li, is_selected) {
                $li.find('.jqtree-title').before('<span class="spanClass '+ node.id +'"></span> ');
                $li.find('.jqtree-element').append(
                    '<a href="javascript:void(0);" class="edit btn btn-xs btn-warning" data-node-id="' + node.name + '">Edit</a>'
                );

            }
        });

        /*$('#tree1').bind(
         'tree.click',
         function(event) {
         // The clicked node is 'event.node'
         var node = event.node;
         console.log(node);
         }
         );*/

        $('#tree1').on(
            'click', '.edit',
            function(e) {
                var node_id = $(e.target).data('node-id');
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl('admin/menu/Redirect')?>',
                    type: "POST",
                    data: {tableName: node_id},
                    success: function (response) {
                        var res = JSON.parse(response);
                        if(res.token == 1){
                            window.location.href = '<?php echo Yii::app()->createUrl('admin/menu/update/') ?>/'+res.table_id;
                        }else{
                            window.location.href = '<?php echo Yii::app()->createUrl('admin/Builder/editCrud/') ?>/'+res.table_id;
                        }

                    }
                });

            }
        );

        $("#treeData").on('click',function () {
            $.ajax({
                url: 'SaveMenu',
                type: "POST",
                data: {tree: $("#tree1").tree('toJson')},
                success: function (response) {
                    var Result = JSON.parse(response);
                    if (Result.token == 1) {
                        $('.successMsgC').removeClass('hide');
                        $('#successMsg').html(Result.msg);
                        setTimeout(
                            function () {
                                $('.successMsgC').addClass('hide');
                            },3000);
                    }
                }
            });

            //$.post('SaveMenu', ,$('#successMsg').html(res)));
        });
    });


</script>