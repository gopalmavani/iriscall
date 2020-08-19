<div class="row">
	<div class="col-lg-12">
		<!-- Striped Table -->
		<div class="block">
			<div class="block-header">
                <em><b>Notice:</b> you <strong>don't</strong> need to add <b>ID</b> and <b>Timestamps</b> fields - they are added automatically.</em>
			</div>
			<!--<form id="field_list" name="field-list">-->
				<div class="block-content">
				<table class="table table-striped" id="current-files">
					<thead>
					<tr>
                        <th class="text-left">Edit</th>
						<?php foreach ($fields as $field){
                            ?>
                            <th class="text-left"><?php echo str_replace('_', ' ', $field); ?></th>
                            <?php
                        }?>
					</tr>
					</thead>
                    <input type="hidden" id="table_id" name="CylFields[table_id]" value="<?php echo $id;?>">
                    <tbody>
                    <?php foreach ($fields_value as $key => $value){
                        if ($value['field_name'] != 'id'){
                        ?>
                        <tr class="field-id" id="<?php echo $value['field_id']; ?>">

                            <td class="text-center">
                                <?php if ($value['is_custom'] == 1){?>
                                    <a class="field-name" id="<?php echo $value['field_id'];?>" href="javascript:void(0);"><span class="fa fa-pencil"></span></a>
									<a class="FieldDelete" id="<?php echo $value['field_id'];?>" href="javascript:void(0);"><span class="fa fa-times"></span></a>
                                <?php } ?>
                            </td>
                            <?php
                            $count = 0;
                            foreach ($value as $k => $v ){
                                $count++;
						        if ( $k == 'field_name' || $k == 'field_length' || $k == 'field_type' || $k == 'field_input_type' || $k == 'is_unique' || $k == 'is_required' || $k == 'default_value') {
                                    ?>
                                    <td class="text-left">
										<label id="<?php echo $v; ?>"><?php echo $v; ?></label>
										<input type="hidden" id="<?php echo $k; ?>" name="CylFields[<?php echo $k; ?>]"  value="<?php echo $v; ?>">
										<input type="hidden" id="from_<?php echo $k; ?>" name="<?php echo $k; ?>"  value="<?php echo $v; ?>">
									</td>
                                    <?php
                                }else{ ?>
                                        <input type="hidden" id="<?php echo $k; ?>" name="CylFields[<?php echo $k; ?>]"  value="<?php echo $v; ?>">
                                        <input type="hidden" id="from_<?php echo $k; ?>" name="<?php echo $k; ?>"  value="<?php echo $v; ?>">
                                <?php }
						    }?>
                        </tr>
                    <?php }
                        } ?>
					</tbody>
				</table>
					<input type="button" class="btn btn-danger" id="addFields" value="Add Field">
            </div>
            <!--</form>-->
		</div>
		<!-- END Striped Table -->
	</div>
</div>
<form hidden id="edit_fields" name="field-edit">
    <input class="btn btn-primary hide" type="button" id="hidden_form">
</form>
