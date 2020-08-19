<?php
$fibo = [1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144];
$this->pageTitle = 'Matrix Tree';
?>
<style>
    .fiboNames{
        position: absolute;
        color: #a00c67;
        margin-top: 25px;
        margin-left: -45px;
        line-height: normal;
        width: min-content;
    }
</style>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseurl . '/css/myfibo.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseurl . '/plugins/webui-popover/src/jquery.webui-popover.css'); ?>
<div id="formodal">

    <hr/>
    <div id="myFibo">
    </div>
    <table class="levels">
        <tr style="background: none;">
            <th class="level-td">No of Users</th>
            <th class="level-td">Level</th>
            <th class="level-td">% Profit Share</th>
            <th>
                <div style="padding-left:40px;">
                    <i class="user-fb-account" style="background: #ED8422;"></i>&nbsp;User's Account
                    &nbsp;&nbsp;&nbsp;<i class="other-fb-account empty-node"></i>&nbsp;Empty
                    &nbsp;
                </div>
                <div class="clearfix"></div>
            </th>
        </tr>
        <tr>
            <td class="level-td">1</td>
            <td class="level-td">1</td>
            <td class="level-td">2</td>
            <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
        </tr>
        <tr>
            <td class="level-td">1</td>
            <td class="level-td">2</td>
            <td class="level-td">3</td>
            <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
        </tr>
        <tr>
            <td class="level-td">2</td>
            <td class="level-td">3</td>
            <td class="level-td">5</td>
            <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
        </tr>
        <tr>
            <td class="level-td">3</td>
            <td class="level-td">4</td>
            <td class="level-td">6</td>
            <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
        </tr>
        <tr>
            <td class="level-td">5</td>
            <td class="level-td">5</td>
            <td class="level-td">7</td>
            <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
        </tr>
        <tr>
            <td class="level-td">8</td>
            <td class="level-td">6</td>
            <td class="level-td">8</td>
            <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
        </tr>
        <tr>
            <td class="level-td">13</td>
            <td class="level-td">7</td>
            <td class="level-td">9</td>
            <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
        </tr>
        <tr>
            <td class="level-td">21</td>
            <td class="level-td">8</td>
            <td class="level-td">10</td>
            <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
        </tr>
        <?php if ($level == 12) { ?>
            <tr>
                <td class="level-td">34</td>
                <td class="level-td">9</td>
                <td class="level-td">11</td>
                <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
            </tr>
            <tr>
                <td class="level-td">55</td>
                <td class="level-td">10</td>
                <td class="level-td">12</td>
                <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
            </tr>
            <tr>
                <td class="level-td">89</td>
                <td class="level-td">11</td>
                <td class="level-td">13</td>
                <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
            </tr>
            <tr>
                <td class="level-td">144</td>
                <td class="level-td">12</td>
                <td class="level-td">14</td>
                <td style="color:#ccc; font-size: 16px;"><i class="fa fa-play"></i></td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseurl . '/plugins/webui-popover/src/jquery.webui-popover.js'); ?>
<script>
    var table_name = '<?= $table_name; ?>';
    $(document).ready(function () {
        $(".page-content-wrapper").css('overflow', 'hidden');
        <?php if($level == 12){ ?>
        $(".page-content-wrapper").css('width', '3145px');
        <?php } else { ?>
        if ($(window).width() < 1368) {
            $(".page-content-wrapper").css('width', 1368);
        } else {
            $(".page-content-wrapper").css('width', $(window).width() - 72);
        }
        <?php } ?>

        // adding node 'id' as a key to the existing Object
        // getting values from database
        var fiboData = jQuery.parseJSON('<?= $fiboData ?>');
        var fiboArray = [];
        $.each(fiboData, function (k, v) {
            fiboArray[v.id] = {
                lchild: v.lchild,
                rchild: v.rchild
            }
        });

        var fiboNames = <?= $fiboNames ?>;

        // this loop will render static FIBO
        for (var i = 1; i <=<?= ($level==8?64:1024) ?>; i++) {
            // rendering first node

            var firstName = '<?= $firstName; ?>';
            if ($('li[node-id="' + i + '"]').length == 0) {
                $("#myFibo").append('<ul class="top"><li style="padding-left:<?= ($level==8?570:1500) ?>px;" node-id="' + i + '" data-id="' + fiboData[0]['id'] + '"><span data-url="<?= Yii::app()->createUrl('admin/matrix/nodedata')?>?nodeId=' + fiboData[0]['id'] + '&table_name=' + table_name +'" class="node user-node"></span></li><li style="margin-left: -570px; color: #a00c67;"><label>' + firstName + '</label></li></ul>');
            }
            // generating left and right node number
            var left = i * 2;
            var right = left + 1;

            // getting values of left and right node from fiboArray which has key and value combination
            var dataKey = $("li[node-id=" + i + "]").attr('data-id');
            if (typeof fiboArray[dataKey] != 'undefined') {
                var leftDataId = fiboArray[dataKey].lchild;
                var rightDataId = fiboArray[dataKey].rchild;
            } else {
                var leftDataId = null;
                var rightDataId = null;
            }

            var leftName = '';
            var rightName = '';

            var leftColorClass = 'empty-node';
            var rightColorClass = 'empty-node';
            if(leftDataId != null){
                leftColorClass = 'user-node';
                leftName = fiboNames[leftDataId];
            }

            if(rightDataId != null) {
                rightColorClass = 'user-node';
                rightName = fiboNames[rightDataId];
            }

            $('li[node-id="' + i + '"]').append(
                '<ul class="child<?= '-'.$level ?>">' +
                '<li parent-node="' + dataKey + '" class="left" node-id="' + left + '" data-id="' + leftDataId + '"><span data-url="<?= Yii::app()->createUrl('admin/matrix/nodedata') ?>?nodeId=' + leftDataId + '&table_name=' + table_name +'" class="node ' + leftColorClass + '"><i class="fiboNames" >'+ leftName +'</i></span></li>' +
                '<li parent-node="' + dataKey + '" class="right" node-id="' + right + '" data-id="' + rightDataId + '"><span data-url="<?= Yii::app()->createUrl('admin/matrix/nodedata') ?>?nodeId=' + rightDataId + '&table_name=' + table_name +'" class="node ' + rightColorClass + '"><i class="fiboNames" >'+ rightName +'</i></span></li>' +
                '</ul>'
            );
        }

        // removing additionally generated node
        $(".node").each(function (k, v) {
            var elPotition = $(v).position();
            <?php if($level==8){ ?>
            if (elPotition.top > 550) {
                <?php } else if($level == 12) { ?>
                if (elPotition.top > 840) {
                    <?php } ?>
                    $(v).remove();
                }
            }
        );


        $("span").hover(function () {
            var nodeId = $(this).parent().attr('node-id');
            $('li[node-id="' + nodeId + '"]').find('span').css('box-shadow', '0px 0px 8px 1px #000');
        }, function () {
            var nodeId = $(this).parent().attr('node-id');
            $('li[node-id="' + nodeId + '"]').find('span').css('box-shadow', 'none');
        });

        // adding fibo bg image
        $('#myFibo').fadeTo('slow', 0.3, function () {
            $(this).addClass('fibo-bg-<?=$level?>');
        }).fadeTo('slow', 1);

        // launching popover on user node
        $('.user-node').webuiPopover({
            type: 'async',
            trigger: 'hover',
            placement: 'auto',
            width: 200,
            height: 80
        });

        $("#myFibo").css('width', '2943');

    });
</script>