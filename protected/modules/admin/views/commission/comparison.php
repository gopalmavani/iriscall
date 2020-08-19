<?php
$this->pageTitle = 'Cash-Back Commission Comparison';
?>
<div class="table-responsive" id="orderTable">
    <table id="demo-foo-addrow" class="table" data-page-size="10">
        <thead>
        <tr>
            <th>User Details</th>
            <th><?= $minus_two_month_text." Commission"; ?></th>
            <th><?= $minus_one_month_text." Commission"; ?></th>
            <th><?= $last_month_text. " Commission"; ?></th>
        </tr>
        </thead>
        <tbody class="list">
        <?php foreach ($details as $detail) { ?>
            <tr>
                <td>
                    <strong><?php echo $detail['name']; ?></strong>
                    <span class="text-muted"><?= $detail['email'] ?></span>
                </td>
                <?php foreach ($detail['month_details'] as $month_detail=>$mnt) { ?>
                    <?php $current_element = $mnt['commission'];?>
                    <td>
                        <?= $mnt['commission']; ?>
                        <?php if(isset($previous_element) && (($current_element != 0) && ($previous_element != 0))) { ?>
                            <?php
                            $difference = $current_element - $previous_element;
                            $percentage = abs($difference)/$previous_element * 100;
                            if($difference < 0) {?>
                                <span class="text-muted text-danger"><?= "-".round($percentage, 2)."%"; ?></span>
                            <?php } else { ?>
                                <span class="text-muted text-success"><?= "+".round($percentage, 2)."%"; ?></span>
                            <?php }?>
                        <?php } else { ?>
                            <br><br>
                        <?php } ?>
                        <span class="text-warning">
                            <?= $mnt['Self Funded']; ?>
                            <?php $current_self_funded = $mnt['Self Funded']; ?>
                            <?php if(isset($previous_self_funded)) { ?>
                                <?php
                                    $difference_in_self_funded = $current_self_funded - $previous_self_funded;
                                ?>
                                (<?= $difference_in_self_funded; ?>)
                            <?php }
                            $previous_self_funded = $current_self_funded;
                            ?>
                        </span>
                        <span class="text-info">
                            <?= $mnt['Profit Funded']; ?>
                            <?php $current_profit_funded = $mnt['Profit Funded']; ?>
                            <?php if(isset($previous_profit_funded)) { ?>
                                <?php
                                $difference_in_profit_funded = $current_profit_funded - $previous_profit_funded;
                                ?>
                                (<?= $difference_in_profit_funded; ?>)
                            <?php }
                            $previous_profit_funded = $current_profit_funded;
                            ?>
                        </span>
                        <span class="text-success">
                            <?= $mnt['earning_nodes']; ?>
                            <?php $current_earning_nodes = $mnt['earning_nodes']; ?>
                            <?php if(isset($previous_earning_nodes)) { ?>
                                <?php
                                $difference_in_earning_nodes = $current_earning_nodes - $previous_earning_nodes;
                                ?>
                                (<?= $difference_in_earning_nodes; ?>)
                            <?php }
                            $previous_earning_nodes = $current_earning_nodes;
                            ?>
                        </span>
                    </td>
                    <?php $previous_element = $mnt['commission'];?>
                <?php } ?>
                <?php unset($current_element); unset($previous_element); ?>
                <?php unset($current_self_funded); unset($previous_self_funded); ?>
                <?php unset($current_profit_funded); unset($previous_profit_funded); ?>
                <?php unset($current_earning_nodes); unset($previous_earning_nodes); ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "num-html-pre": function ( a ) {
            var x = String(a).replace(/(?!^-)[^0-9.]/g, "");
            return parseFloat( x );
        },

        "num-html-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "num-html-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );
    var table = $('#demo-foo-addrow').DataTable({
        "aoColumns":[
            null,
            {"sType":"num-html"},
            {"sType":"num-html"},
            {"sType":"num-html"}
        ]
    });
</script>