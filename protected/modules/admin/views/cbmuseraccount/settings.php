<?php
$this->pageTitle = 'Email Settings';
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!--<div class="box-header">
                <h4 class="box-title">CBM User Accounts Overview</h4>
            </div>-->
            <div class="card-body">
                <div class="row" style="margin-bottom: 12px">
                    <div class="col-md-10">
                        <h4 class="card-title">CBM User Accounts Overview</h4>
                    </div>
                    <div class="col-md-2 pull-right">
                        <button type="button" class="btn waves-effect waves-light btn-primary" onclick="sendEmailToAll()">Send To All</button>
                    </div>
                </div>
                <div class="loader" id="mainLoader" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                    <i class="fa fa-4x fa-cog fa-spin text-success"></i>
                </div>
                <div class="table-responsive" id="mainTable">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>#</th>
                            <th>User Details</th>
                            <th>Pending Accounts</th>
                            <th>Last Sent Date</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($result as $item=>$value) { ?>
                            <tr style="height: 20px">
                                <td style="vertical-align: middle;"><?= $item+1; ?></td>
                                <td style="vertical-align: middle;"><?= $value['email']; ?></td>
                                <td style="vertical-align: middle;"><?= $value['pendingAccounts']; ?></td>
                                <td style="vertical-align: middle;">
                                    <div class="loader" id="loader-<?= $value['userId']; ?>" style="display: none; margin-left: auto; margin-right: auto; padding: inherit; width: 100px;">
                                        <i class="fa fa-4x fa-cog fa-spin text-success"></i>
                                    </div>
                                    <span id="message-<?= $value['userId']; ?>"><?= $value['lastSent']; ?></span>
                                </td>
                                <td style="vertical-align: middle;">
                                    <?php if($value['userId'] != 0) { ?>
                                        <button type="button" id="<?= $value['email']; ?>" class="btn waves-effect waves-light btn-primary" onclick="sendEmail('<?= $value['mailUrl']; ?>')">Send Email</button>
                                    <?php } else { ?>
                                        <span class="label label-danger" style="font-size: small">Invalid User</span>
                                    <?php } ?>

                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
<script>
    function sendEmail(url) {
        var urlDet = url.split('/');
        var userId = urlDet[urlDet.length-1];
        $.ajax({
           "type":"GET",
           "url": url,
            "beforeSend" : function () {
               $('#loader-'+userId).css('display','block');
               $('#message-'+userId).css('display','none');
            },
            "success" : function (data) {
                $('#loader-'+userId).css('display','none');
                $('#message-'+userId).html(data);
                $('#message-'+userId).css('display','block');
            }
        });
    }
    function sendEmailToAll() {
        var url = '<?= Yii::app()->createUrl('admin/Cbmuseraccount/sendMailToAll'); ?>';
        $.ajax({
            "type":"GET",
            "url": url,
            "beforeSend" : function () {
                $('#MainLoader').css('display','block');
                $('#mainTable').css('display','none');
            },
            "success" : function (data) {
                $('#MainLoader').css('display','none');
                $('#mainTable').css('display','block');
                window.location.reload();
            }
        });
    }
</script>
