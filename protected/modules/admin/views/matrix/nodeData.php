<?php
?>
<style>
    .panel-content-name {
        font-size: 14px;
        font-family: 'Montserrat';
        font-weight: 600;
        text-transform: uppercase;
        text-align: center;
    }
    .panel-content-bal {
        font-size: 33px;
        font-weight: 300;
        font-family: "Segoe UI","Helvetica Neue",Helvetica,Arial,sans-serif;
        color: #2c2c2c;
        text-align: center;
    }
    .panel-content-accnt {
        color: #626262;
        font-family: "Segoe UI",Arial,sans-serif;;
        font-weight: 600;
        text-align: center;
        font-size: large;
    }
</style>
<div class="panel panel-default">
    <div class="panel-body">
        <div class = "panel-content-name">
            <?= $data['account_num']; ?>
        </div>
        <div class = "panel-content-accnt">
            <?= "Balance: ".$data['balance']; ?>
        </div>
        <div class = "panel-content-accnt">
            <?= 'Equity: ' . $data['equity']; ?>
        </div>
    </div>
</div>

