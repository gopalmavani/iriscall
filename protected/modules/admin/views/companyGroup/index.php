<?php
$this->pageTitle = 'Company Groups';
?>
<div class="overlay" style="opacity:0.1 !important;position:unset !important;">
    <div class="loader">
        <p style="font-size: 18px;"><i class="fa fa-cog fa-spin" aria-hidden="true"></i> Loading...</p>
    </div>
</div>
<div class="row hide" id="mydatatable">
    <div class="alert alert-success hide" id="delete" align="center">
        <h4>Company group deleted successfully</h4>
    </div>
    <div class="col-md-12">
        <?php
			$sql = "SELECT * FROM company_group_info";
			$result = Yii::app()->db->createCommand($sql)->queryAll();
			if(!empty($result)){ ?>
        <div class="pull-right m-b-10">
            <?php echo CHtml::link('Create', array('companyGroup/create'), array('class' => 'btn btn-minw btn-square btn-primary')); ?>
        </div>
        <div style="margin-right:10px;" class="pull-right m-b-10">
            <a class="btn btn-outline-primary" id="clearfilters">Clear Filters <i class="fa fa-times"></i></a>
        </div>
        <div id="company-group-grid">
            <table id="company-group-table" class="table table-striped table-bordered" width="100%" style="font-size:13px;" cellspacing="0" cellpadding="0">
                <thead class="custom-table-head">
                <tr>
                    <th class="custom-table-head">Action</th>
                    <?php
						$array_cols = Yii::app()->db->schema->getTable('company_group_info')->columns;
						foreach($array_cols as $key=>$col){
					?>
                    <th class="custom-table-head"><?php echo ucfirst(str_replace('_',' ',$col->name)); ?></th>
                    <?php
						}
					?>
                </tr>
                </thead>

                <thead>
                <tr>
                    <?php
						$arr = array_values($array_cols);
						foreach($arr as $key=>$col){
							switch($col->name)
							{
                                case 'company_id':
                                    echo "<td></td>";
                                    $codesql = "select id, name from company_info";
                                    $rank = Yii::app()->db->createCommand($codesql)->queryAll();
                                    ?><td><select class='drop-box' data-column='1' style='width:100%'>
                                        <option value="">Select</option>
                                    <?php foreach($rank as $key=>$value){ ?>
                                            <option value='<?php echo $value['id']; ?>'><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </td>
                                    <?php break;
    
                                case 'group_name':
                                    echo "<td><input type='text' data-column='2' class='text-box' style='width:100%'></td>";
                                    break;
    
                                case 'external_number':
                                    echo "<td><input type='text' data-column='3' class='text-box' style='width:100%'></td>";
                                    break;
    
                                case 'group_id_mytelephony':
                                    echo "<td><input type='text' data-column='4' class='text-box' style='width:100%'></td>";
                                    break;
                                
                                case 'comment':
                                    echo "<td><input type='text' data-column='5' class='text-box' style='width:100%'></td>";
                                    break;

								default :
									break;
							}
						}
						?>
                </tr>
                </thead>
            </table>
        </div>
        <div class="row"><br/></div>
        <?php } else { ?>
        <div class="row">
            <div align="center">
                <img src="<?php echo Yii::app()->baseUrl."/plugins/img/product.png"; ?>" height="20%" width="10%"><br /><br />
                <h2>No Company group</h2>
                <p></p>
                <div class="row">
                    <?php echo CHtml::link('Create', array('companyGroup/create'), array('class' => 'btn btn-minw btn-square btn-primary','style'=>'width:270px;font-size:18px')); ?>
                </div>
                <br />
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<script>
    $(document).ready(function() {
        if (localStorage.getItem('msg')){
            $("#delete").removeClass("hide");
            setTimeout(
                function(){
                    $("#delete").addClass("hide");
                },5000
            );
            localStorage.removeItem('msg');
        }
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var currentDate = d.getFullYear() + '/' +
            ((''+month).length<2 ? '0' : '') + month + '/' +
            ((''+day).length<2 ? '0' : '') + day;

        var datatable = $('#company-group-table').DataTable({
            "fnDrawCallback":function(){
                if($('#company-group-table td').hasClass('dataTables_empty')){
                    $('div.dataTables_paginate').hide();
                    $('div#company-group-table').hide();
                } else {
                    $('div#company-group-table').show();
                    $('div.dataTables_paginate').show();
                }
            },
            "order" : [[0,"ASC"]],
            "pageLength":20,
            "lengthMenu": [[20,50,100,200], [20,50,100,200]],
            "processing": true,
            "bFilter": false,
            "searching": true,
            "dom":'l,B,t,i,p',
            "buttons": [
                {
                    extend: 'copyHtml5',
                    title: 'CDR Cost Rules Data export '+currentDate
                },
                {
                    extend: 'excelHtml5',
                    title: 'CDR Cost Rules Data export '+currentDate
                },
                {
                    extend: 'csvHtml5',
                    title: 'CDR Cost Rules Data export '+currentDate
                },
                {
                    extend: 'pdfHtml5',
                    title: 'CDR Cost Rules Data export '+currentDate
                },
                {
                    extend: 'print',
                    title: 'CDR Cost Rules Data export '+currentDate
                }
            ],
            "serverSide": true,
            "ajax": {
                "type" : "GET",
                "url" : "datatable",
                "dataSrc": function ( json ) {
                    $('.overlay').addClass("overlayhide");
                    $("#mydatatable").removeClass("hide");
                    return json.data;
                }
            },
            "columnDefs": [ {
                "targets": 0,
                "data": null,
                "render" : function(data, type, row) {
                    return '<a href="<?php echo Yii::app()->createUrl("admin/companyGroup/view").'/'; ?>'+data[1]+'"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl("admin/companyGroup/update/").'/'; ?>'+data[1]+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a id='+data[1]+' class="groupdelete" href="javascript:void(0)"><i class="fa fa-times"></i></a>';
                }
            },{
                "visible":false,
                "targets":[1,7,8]
            } ]
        });

        $('.text-box').on('keyup', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            console.info(i);
            var v =$(this).val();  // getting search input value
            datatable.columns(i).search(v).draw();
        } );

        $('.date-field').on('change', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            console.info(i);
            var v =$(this).val();  // getting search input value
            datatable.columns(i).search(v).draw();
        } );

        $('.drop-box').on('change', function () {   // for text boxes
            var i =$(this).attr('data-column');  // getting column index
            console.info(i);
            var v =$(this).val();  // getting search input value
            datatable.columns(i).search(v).draw();
        } );

        $('#clearfilters').on('click',function() {
            datatable.columns().search('').draw();
            datatable.search('').draw();
            $('input[type=text]').val('');
            $('.drop-box').val('');
            $('.date-field').val('');
        });

        $(' body ').on('click','.groupdelete',function() {
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure you want to delete this Company group?", function(result){
                if (result === true){
                    $.ajax({
                        url: "Delete",
                        type: "POST",
                        data: {'id': id},
                        beforeSend: function () {
                            $(".overlay").removeClass("hide");
                        },
                        success: function (response) {
                            var Result = JSON.parse(response);
                            if (Result.token == 1){
                                localStorage.setItem('msg','success');
                                window.location.reload();
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                        }
                    });
                }
            });
        });
    });
</script>