<div style="width:60%;" class="modal-dialog modal-dialog-popin">
	<div class="modal-content">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id' => 'cyl-fields-form',
            'action' => false,
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation' => false,
			'htmlOptions' => array(
				'class' => 'form-horizontal push-5-t',
				'enctype' => 'multipart/form-data'
			)
		)); ?>

		<div class="block block-themed block-transparent remove-margin-b">
			<div class="block-header bg-primary-dark">
				<ul class="block-options">
					<li>
						<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
					</li>
				</ul>
				<h3 class="block-title">Main settings</h3>
			</div>
			<div class="block-content">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $form->textField($model, 'table_id', array('hidden' => 'true', 'value' => $model->table_id)); ?>
                        <?php echo $form->textField($model, 'field_id', array('hidden' => 'true', 'value' => $model->field_id)); ?>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $form->labelEx($model, 'Field name in table *'); ?>
                                <?php echo $form->textField($model, 'field_name', array('id' => 'field_name','size' => 60, 'maxlength' => 80, 'class' => 'form-control', 'disabled' => 'disabled', 'placeholder' => 'Field name in table')); ?>
                                <div id="CylFields-name-error" class="custom-error help-block text-right"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            $options = array(
                                'text' => 'Textbox',
                                'check' => 'Checkbox',
                                'radio' => 'Radiobutton',
                                'select' => 'Selectbox',
                                'textarea' => 'Textarea',
                                'date' => 'Date',
                                'password' => 'Password',
                                'email' => 'Email',

                            );

                            $htmlOptions = array(
                                'disabled' => 'disabled',
                                'class' => 'form-control',
                                'id' => 'field_input_type',

                            );
                            ?>
                            <div class="col-sm-12">
                                <?php
                                echo $form->labelEx($model, 'Field Type', array('id' => 'field_type'));
                                echo CHtml::dropDownList('CylFields[field_input_type]', $model->field_input_type, $options, $htmlOptions);
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($model->field_input_type == 'radio' || $model->field_input_type == 'check' || $model->field_input_type == 'select'){
                            $hide = "";
                        }else{
                            $hide = "hide";
                        }
                        ?>
                        <?php $fieldData = CylFieldValues::model()->findAllByAttributes(['field_id' => $model->field_id]);
                        if ($fieldData){
                        ?>
                            <div class="form-group <?= $hide; ?>" id="fieldsC">
                                <div class="controls">
                                    <?php foreach ($fieldData as $key => $value){ ?>
                                        <div class="add-more-fields">
                                            <div class="col-sm-5">
                                                <input class="form-control" placeholder="Label" value="<?= $value->field_label; ?>" id="CylFieldValues_label" name="CylFieldValues[label]" disabled type="text"/>
                                            </div>
                                            <div class="col-sm-5">
                                                <input class="form-control" placeholder="Value" value="<?= $value->predefined_value; ?>" name="CylFieldValues[predefined_value]" disabled id="CylFieldValues_predefined_value" type="text"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" disabled class="btn btn-success btn-danger btn-remove">
                                                    <span>-</span>
                                                </button>
                                            </div>
                                        </div><br><br>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group hide">
                            <?php echo $form->labelEx($model, 'Field Data Type', array('id' => 'field_type','class' => 'col-sm-4')); ?>
                            <div class="col-sm-8">
                                <?php echo $form->dropDownList($model, 'field_type', array(
                                    'Numeric' => array(
                                        'TINYINT' => 'TINYINT',
                                        'SMALLINT' => 'SMALLINT',
                                        'MEDIUMINT' => 'MEDIUMINT',
                                        'INT' => 'INT',
                                        'BIGINT' => 'BIGINT',
                                        'DECIMAL' => 'DECIMAL',
                                        'FLOAT' => 'FLOAT',
                                        'DOUBLE' => 'DOUBLE',
                                        'REAL' => 'REAL',
                                        'BIT' => 'BIT',
                                        'BOOLEAN' => 'BOOLEAN',
                                        'SERIAL' => 'SERIAL'
                                    ),
                                    'Date and Time' => array(
                                        'DATE' => 'DATE',
                                        'DATETIME' => 'DATETIME',
                                        'TIMESTAMP' => 'TIMESTAMP',
                                        'TIME' => 'TIME',
                                        'YEAR' => 'YEAR'
                                    ),
                                    'String' => array(
                                        'CHAR' => 'CHAR',
                                        'VARCHAR' => 'VARCHAR',
                                        'TINYTEXT' => 'TINYTEXT',
                                        'TEXT' => 'TEXT',
                                        'MEDIUMTEXT' => 'MEDIUMTEXT',
                                        'LONGTEXT' => 'LONGTEXT',
                                        'BINARY' => 'BINARY',
                                        'VARBINARY' => 'VARBINARY',
                                        'TINYBLOB' => 'TINYBLOB',
                                        'MEDIUMBLOB' => 'MEDIUMBLOB',
                                        'BLOB' => 'BLOB',
                                        'LONGBLOB' => 'LONGBLOB',
                                        'ENUM' => 'ENUM',
                                        'SET' => 'SET'
                                    ),
                                    'Spatial' => array(
                                        'GEOMETRY' => 'GEOMETRY',
                                        'POINT' => 'POINT',
                                        'LINESTRING' => 'LINESTRING',
                                        'POLYGON' => 'POLYGON',
                                        'MULTIPOINT' => 'MULTIPOINT',
                                        'MULTILINESTRING' => 'MULTILINESTRING',
                                        'MULTIPOLYGON' => 'MULTIPOLYGON',
                                        'GEOMETRYCOLLECTION' => 'GEOMETRYCOLLECTION'
                                    )
                                ), array('maxlength' => 80, 'disabled' => 'disabled', 'class' => 'form-control', 'placeholder' => 'Field Data Type')); ?>
                            </div>
                        </div>
                        <div class="form-group hide">
                            <?php echo $form->labelEx($model, 'Field Length *', array('class' => 'col-sm-4')); ?>
                            <div class="col-sm-8">
                                <?php echo $form->textField($model, 'field_length', array('id' => 'field_length','size' => 60, 'maxlength' => 80, 'class' => 'form-control', 'placeholder' => 'Field Length', 'disabled' => 'disabled')); ?>
                                <div id="CylFields-type-error" class="custom-error help-block text-right"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $form->labelEx($model, 'is_unique*'); ?>
                                <?php echo $form->dropDownList($model, 'is_unique', array('0' => 'No','1' => 'Yes'), array('maxlength' => 80, 'class' => 'form-control', 'disabled' => 'disabled')); ?>
                                <div id="CylFields-type-error" class="custom-error help-block text-right"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $form->labelEx($model, 'admin_input'); ?>
                                <?php echo $form->textField($model, 'admin_input', array('id' => 'admin_label','class' => 'form-control', 'placeholder' => 'Admin input')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $form->labelEx($model, 'admin_rights'); ?>
                                <?php echo $form->radioButtonList($model, 'admin_rights', array(0 => 'Disabled', 1 => 'View-only', 2 => 'Editable'), array('disabled'=>'disabled', 'id' => 'admin_rights','separator' => "  ", 'checked' => $model->admin_rights)); ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $form->labelEx($model, 'Is it mandatory field ?'); ?>
                                <?php echo $form->dropDownList($model, 'is_required', array('0' => 'No','1' => 'Yes'), array('maxlength' => 80, 'class' => 'form-control')) ;?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="register1-email">Default value</label>
                                <?php echo $form->textField($model, 'default_value', array('id' => 'default_value','class' => 'form-control', 'placeholder' => 'Is there are a default value for the field ?')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php echo $form->labelEx($model, 'description'); ?>
                                <?php echo $form->textarea($model, 'description', array('id' => 'admin_label','class' => 'form-control', 'placeholder' => 'Description')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <p class="col-sm-8" style="color: #ff0000"> <i> Note : Fields marked with asterisk <b>(*)</b> are required. </i></p>
                </div>
			</div>
		</div>
		<div class="modal-footer">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save', array('class' => 'btn btn-success SaveBtn', 'id'=>'save_'.$model->field_id)); ?>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</div>