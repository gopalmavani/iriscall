<?php
/* @var $this UserInfoController */
/* @var $model UserInfo */

$this->pageTitle = 'Edit Crud';
?>
<style>
    #check {
        float: none !important;
        margin-top: 0px;
        position: absolute !important;
        margin-left: 0px !important;
        font-weight: 600 !important;
        color: #646464 !important;
    }
    .add-more-fields .col-sm-3 {
        padding-right: 0px;
        padding-bottom: 10px;
    }
</style>
<script src="<?php echo Yii::app()->createUrl('/'); ?>/plugins/js/core/bootbox.min.js"></script>
<div class="alert alert-success hide" role="alert" id="editHideEffect">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="alert-heading text-center">Your crud is saved successfully.</h4>
</div>
<div class="block">
    <div class="block-header bg-gray-lighter">
        <h3 class="block-title" style="padding-bottom: 10px;">Crud Settings</h3>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3" style="padding-bottom: 10px;">
                    <label>Crud Title</label>
                    <input type="text" class="form-control" name="CrudTitle" id="crud_title" value="<?php echo $table->table_name; ?>" disabled>
                </div>
                <div class="col-md-3" style="padding-bottom: 10px;">
                    <!--<label>Module Name</label>
                    <input type="text" class="form-control" name="ModuleTitle" id="module_name" value="<?php /*echo $table->module_name; */?>" disabled>-->
                    <label>Parent Menu Item</label>
                    <select class="form-control" name="ParentMenuItem" id="parent_menu_item">
                        <option value="0" selected>Optional Selection</option>
                        <?php
                        foreach ($parents as $key => $parent){
                            ?>
                            <option <?= ($parent->table_id == $table->parent_item) ? ' selected ' : '';?>value="<?php echo $parent->table_id; ?>"><?php echo $parent->menu_name; ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="col-md-3" style="padding-bottom: 10px;">
                    <label>Icon</label>
                    <div class="input-group iconpicker-container">
                        <input class="form-control icp icp-auto" value="fa-user" name="MenuIcon" id="menu_icon" value="<?php echo $table->menu_icon; ?>" disabled/>
                        <span class="input-group-addon"></span>
                    </div>
                </div>
                <div class="col-md-3" style="padding-bottom: 10px;">
                    <label>Visual Title</label>
                    <input type="text" class="form-control" name="ParentItem" id="menu_name" value="<?php echo $table->menu_name; ?>">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="fields"></div>
<button id="CreateModal" class="btn btn-default hide" data-toggle="modal" data-target="#modal-terms" type="button">Launch Modal</button>
<div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-hidden="true">

</div>

<hr>
<h2>Permissions :</h2>

    <?php
    $sql = "SELECT * from action_list";
    $actions = Yii::app()->db->createCommand($sql)->queryAll();
    $count = count($actions);

    $sql2 = "SELECT * from roles";
    $roles = Yii::app()->db->createCommand($sql2)->queryAll();

    $controllerarray  =explode("/",$this->uniqueId);
    $controller = Yii::app()->session['controllerName'];
    ?>
    <form id="actionCheck">
        <table class="table">
            <thead>
            <tr>
                <th>Role</th>
                <?php foreach($actions as $key=>$value){?>
                    <th><?php echo $value['action']; ?><input type="checkbox" id="<?php echo $value['action']; ?>" class="headactions"></th>
                <?php } ?>
            </tr>
            </thead>

            <tbody>
            <?php foreach($roles as $key=>$value){ ?>
                <tr>
                    <td><?php echo $value['role_title']; ?><input type="checkbox" id="<?php echo $value['role_title']; ?>" value="<?php echo $value['role_title']; ?>" class="role"> </td>
                    <?php foreach($actions as $key=>$action){

                        $check = Yii::app()->db->createCommand("SELECT * FROM role_mapping WHERE `controller` = '$controller' AND `role` = '$value[role_title]' AND `allowed_actions` = '$action[id]'" )->queryRow();
                    if ($value['role_title'] == 'admin'){ ?>
                        <td><input disabled type="checkbox" id="<?php echo $action['action']; ?>" name="<?php echo $value['role_title']; ?>" value="<?php echo $action['id']; ?>" class="<?php echo $value['role_title']; ?>" checked></td>
                    <?php }else {
                        if (!empty($check)) { ?>
                            <td><input type="checkbox" id="<?php echo $action['action']; ?>"
                                       name="<?php echo $value['role_title']; ?>" value="<?php echo $action['id']; ?>"
                                       class="<?php echo $value['role_title']; ?>" checked></td>
                        <?php } else { ?>
                            <td><input type="checkbox" id="<?php echo $action['action']; ?>"
                                       name="<?php echo $value['role_title']; ?>" value="<?php echo $action['id']; ?>"
                                       class="<?php echo $value['role_title']; ?>"></td>
                        <?php }
                    }

                    } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
    <button id="addpermissions" class="hide btn btn-primary">Add permissions</button>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right m-b-10">
            <input class="btn btn-primary saveCrud" type="button" name="save-crud" value="Save CRUD">
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edits" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div style="width: 60%" class="modal-dialog modal-dialog-popin">
        <div class="modal-content">
            <form class="form-horizontal push-5-t" enctype="multipart/form-data" id="edit-cyl-fields-form" action="" method="post" novalidate="novalidate">
                <div class="block block-themed block-transparent remove-margin-b">
                    <div class="block-header bg-primary-dark">
                        <ul class="block-options">
                            <li>
                                <button data-dismiss="modal" type="button"><i class="si si-close edit-close"></i></button>
                            </li>
                        </ul>
                        <h3 class="block-title">Main settings</h3>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="CylFields_Field_name_in_table_*">Field Name In Table *</label>
                                        <input id="edit_field_name" size="60" maxlength="80" class="form-control" placeholder="Field name in table" name="CylFields[field_name]" type="text" value="">
                                        <div id="CylFields-name-error" class="custom-error help-block text-right"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label id="field_type" for="CylFields_Field_Type">Field  Type</label>
                                        <select class="form-control" id="edit_field_input_type" name="CylFields[field_input_type]">
                                            <option value="text">Textbox</option>
                                            <option value="check">Checkbox</option>
                                            <option value="radio">Radiobutton</option>
                                            <option value="select">Selectbox</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="date">Date</option>
                                            <option value="password">Password</option>
                                            <option value="email">Email</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group hide" id="fieldsedit">
                                    <div class="controls">
                                        <div class="add-more-fields">
                                            <div class="col-sm-5">
                                                <input class="form-control" placeholder="Label" id="edit_CylFieldValues_label" name="CylFieldValues[label][]" type="text">
                                            </div>
                                            <div class="col-sm-5">
                                                <input class="form-control" placeholder="Value" name="CylFieldValues[predefined_value][]" id="edit_CylFieldValues_predefined_value" type="text">
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-success btn-add">
                                                    <span>+</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hide">
                                    <div class="col-sm-12">
                                        <label id="field_type" for="CylFields_Field_Data_Type">Field  Data  Type</label>
                                        <select maxlength="80" class="form-control" placeholder="Field Data Type" name="CylFields[field_type]" id="edit_CylFields_field_type">
                                            <optgroup label="Numeric">
                                                <option value="TINYINT">TINYINT</option>
                                                <option value="SMALLINT">SMALLINT</option>
                                                <option value="MEDIUMINT">MEDIUMINT</option>
                                                <option value="INT">INT</option>
                                                <option value="BIGINT">BIGINT</option>
                                                <option value="DECIMAL">DECIMAL</option>
                                                <option value="FLOAT">FLOAT</option>
                                                <option value="DOUBLE">DOUBLE</option>
                                                <option value="REAL">REAL</option>
                                                <option value="BIT">BIT</option>
                                                <option value="BOOLEAN">BOOLEAN</option>
                                                <option value="SERIAL">SERIAL</option>
                                            </optgroup>
                                            <optgroup label="Date and Time">
                                                <option value="DATE">DATE</option>
                                                <option value="DATETIME">DATETIME</option>
                                                <option value="TIMESTAMP">TIMESTAMP</option>
                                                <option value="TIME">TIME</option>
                                                <option value="YEAR">YEAR</option>
                                            </optgroup>
                                            <optgroup label="String">
                                                <option value="CHAR">CHAR</option>
                                                <option value="VARCHAR">VARCHAR</option>
                                                <option value="TINYTEXT">TINYTEXT</option>
                                                <option value="TEXT">TEXT</option>
                                                <option value="MEDIUMTEXT">MEDIUMTEXT</option>
                                                <option value="LONGTEXT">LONGTEXT</option>
                                                <option value="BINARY">BINARY</option>
                                                <option value="VARBINARY">VARBINARY</option>
                                                <option value="TINYBLOB">TINYBLOB</option>
                                                <option value="MEDIUMBLOB">MEDIUMBLOB</option>
                                                <option value="BLOB">BLOB</option>
                                                <option value="LONGBLOB">LONGBLOB</option>
                                                <option value="ENUM">ENUM</option>
                                                <option value="SET">SET</option>
                                            </optgroup>
                                            <optgroup label="Spatial">
                                                <option value="GEOMETRY">GEOMETRY</option>
                                                <option value="POINT">POINT</option>
                                                <option value="LINESTRING">LINESTRING</option>
                                                <option value="POLYGON">POLYGON</option>
                                                <option value="MULTIPOINT">MULTIPOINT</option>
                                                <option value="MULTILINESTRING">MULTILINESTRING</option>
                                                <option value="MULTIPOLYGON">MULTIPOLYGON</option>
                                                <option value="GEOMETRYCOLLECTION">GEOMETRYCOLLECTION</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group hide">
                                    <div class="col-sm-12">
                                        <label  for="CylFields_Field_Length_*">Field  Length *</label>
                                        <input id="edit_field_length" size="60" maxlength="80" class="form-control" placeholder="Field Length" name="CylFields[field_length]" type="text">
                                        <div id="CylFields-type-error" class="custom-error help-block text-right"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="CylFields_is_unique*">Is Unique*</label>
                                        <select maxlength="80" class="form-control" name="CylFields[is_unique]" id="edit_CylFields_is_unique">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                        <div id="CylFields-type-error" class="custom-error help-block text-right"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label  for="CylFields_admin_input">Admin Input</label>
                                        <input id="edit_admin_input" class="form-control" placeholder="Admin input" name="CylFields[admin_input]" type="text" maxlength="50">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label  required" for="CylFields_admin_rights" aria-required="true">Admin Rights <span class="required" aria-required="true">*</span></label><br>
                                        <?php echo CHtml::radioButtonList('edit_admin_rights', '', array(0 => 'Disabled', 1 => 'View-only', 2 => 'Editable'), array('id' => 'edit_admin_rights','separator' => "  ", 'checked' => 2 )); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label  for="CylFields_Is_it_mandatory_field_?">Is It Mandatory Field ?</label>
                                        <select maxlength="80" class="form-control" name="edit-is-required" id="edit_is_required">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="register1-email">Default value</label>
                                        <input id="edit_default_value" class="form-control" placeholder="Is there are a default value for the field ?" name="CylFields[default_value]" type="text" maxlength="255">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label  for="CylFields_description">Description</label>
                                        <textarea id="edit_description" class="form-control" placeholder="Description" name="CylFields[description]"></textarea>
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
                    <input class="btn btn-success EditSaveBtn" type="submit" id="" name="yt0" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>
<button id="EditModal" class="hide btn btn-default" data-toggle="modal" data-target="#modal-edits" type="button">Launch Modal</button>

<div class="modal fade" id="modal-new" tabindex="-1" role="dialog" aria-hidden="true">
    <div style="width: 60%" class="modal-dialog modal-dialog-popin">
        <div class="modal-content">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'add-cyl-fields-form',
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
                            <button data-dismiss="modal" type="button"><i class="si si-close closNewField"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Main settings</h3>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php echo $form->textField($modelCyl, 'table_id', array('hidden' => 'true', 'value' => $modelCyl->table_id)); ?>
                            <?php echo $form->textField($modelCyl, 'field_id', array('hidden' => 'true', 'value' => $modelCyl->field_id)); ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo $form->labelEx($modelCyl, 'Field name in table *'); ?>
                                    <?php echo $form->textField($modelCyl, 'field_name', array('id' => 'field_name','size' => 60, 'maxlength' => 80, 'class' => 'form-control popup-field-name', 'placeholder' => 'Field name in table')); ?>
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
                                    'class' => 'form-control',
                                    'id' => 'field_input_type',
                                );
                                ?>
                                <div class="col-sm-12">
                                    <?php
                                    echo $form->labelEx($modelCyl, 'Field Type', array('id' => 'field_type'));
                                    echo CHtml::dropDownList('CylFields[field_input_type]', '12', $options, $htmlOptions);
                                    ?>
                                </div>
                            </div>


                            <div class="form-group hide" id="fieldsC">

                                <div class="controlss">
                                    <div class="add-more-fieldss">
                                        <div class="col-sm-5">
                                            <input class="form-control" placeholder="Label" id="CylFieldValues_label" name="CylFieldValues[label][]" type="text"/>
                                        </div>
                                        <div class="col-sm-5">
                                            <input class="form-control" placeholder="Value" name="CylFieldValues[predefined_value][]" id="CylFieldValues_predefined_value" type="text"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-success btn-adds">
                                                <span>+</span>
                                            </button>
                                        </div>
                                    </div><br>
                                </div>
                            </div>

                            <div class="form-group hide">
                                <div class="col-sm-12">
                                    <?php echo $form->labelEx($modelCyl, 'Field Data Type', array('id' => 'field_type','class' => 'col-sm-4')); ?>
                                    <?php echo $form->dropDownList($modelCyl, 'field_type', array(
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
                                    ), array('maxlength' => 80, 'class' => 'form-control popup-field-type', 'placeholder' => 'Field Data Type')); ?>
                                </div>
                            </div>
                            <div class="hide form-group">
                                <div class="col-sm-8">
                                    <?php echo $form->labelEx($modelCyl, 'Field Length *', array('class' => 'col-sm-4')); ?>
                                    <?php echo $form->textField($modelCyl, 'field_length', array('id' => 'field_length','size' => 60, 'maxlength' => 80, 'class' => 'form-control popup-field-length', 'placeholder' => 'Field Length')); ?>
                                    <div id="CylFields-length-error" class="custom-error help-block text-right"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo $form->labelEx($modelCyl, 'is_unique*'); ?>
                                    <?php echo $form->dropDownList($modelCyl, 'is_unique', array('0' => 'No','1' => 'Yes'), array('maxlength' => 80, 'class' => 'form-control')); ?>
                                    <div id="CylFields-isUnique-error" class="custom-error help-block text-right"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo $form->labelEx($modelCyl, 'admin_input'); ?>
                                    <?php echo $form->textField($modelCyl, 'admin_input', array('id' => 'admin_label','class' => 'form-control', 'placeholder' => 'Admin input')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo $form->labelEx($modelCyl, 'admin_rights',array("style" => "padding-bottom: 13px;")); ?><br>
                                    <?php echo $form->radioButtonList($modelCyl, 'admin_rights', array(0 => 'Disabled', 1 => 'View-only', 2 => 'Editable'), array('id' => 'admin_rights','separator' => "  ", 'checked' => 2
                                    )); ?>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo $form->labelEx($modelCyl, 'Is it mandatory field ?'); ?>
                                    <?php echo $form->dropDownList($modelCyl, 'is_required', array('0' => 'No','1' => 'Yes'), array('maxlength' => 80, 'class' => 'form-control')) ;?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label  for="register1-email">Default value</label>
                                    <?php echo $form->textField($modelCyl, 'default_value', array('id' => 'default_value','class' => 'form-control', 'placeholder' => 'Is there are a default value for the field ?')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php echo $form->labelEx($modelCyl, 'description'); ?>
                                    <?php echo $form->textarea($modelCyl, 'description', array('id' => 'admin_label','class' => 'form-control', 'placeholder' => 'Description')); ?>
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
                <?php echo CHtml::submitButton($modelCyl->isNewRecord ? 'Submit' : 'Save', array('class' => 'btn btn-success SaveBtn')); ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<button id="CreateModalNew" class="hide btn btn-default" data-toggle="modal" data-target="#modal-new" type="button">Launch Modal</button>


<script>
    $('body').on('click', '.EditSaveBtn', function (e) {
        e.preventDefault();
        var fieldsvalue = new Array();
        var trId = $(".EditSaveBtn").attr('id');
        $("#"+trId).find("#field_name").html($("#edit_field_name").val());
        $("#"+trId).find("#field_length").html($("#edit_field_length").val());
        $("#"+trId).find("#field_type").html($("#edit_CylFields_field_type").val());
        $("#"+trId).find("#field_input_type").html($("#edit_field_input_type").val());
        $("#"+trId).find("#is_unique").html($("#edit_CylFields_is_unique").val());
        $("#"+trId).find("#is_required").html($("#edit_is_required").val());
        $("#"+trId).find("#default_value").html($("#edit_default_value").val());
        $("#"+trId).find("#admin_rights").html($("#edit_admin_rights_").val());
        $("#"+trId).find("#admin_label").html($("#edit_admin_label").val());
        $("#"+trId).find("#admin_input").html($("#edit_admin_input").val());
        $("#"+trId).find("#description").html($("#edit_description").val());
        $('#edit-cyl-fields-form #fieldsedit .controls .add-more-fields').each(function(i, obj) {
            if ($(this).find( "#CylFieldValues_label" ).val() && $(this).find( "#CylFieldValues_label" ).val()) {
                fieldsvalue.push({
                    'label': $(this).find("#CylFieldValues_label").val(),
                    'value': $(this).find("#CylFieldValues_predefined_value").val()
                });
            }
        });
        var blkstr = [];
        $.each(fieldsvalue, function(idx2,val2) {
            var str = '"'+val2.label + '":"' + val2.value+'"';
            blkstr.push(str);
        });
        var fieldText = "{"+blkstr.join(",")+"}";
        $("#"+trId).find("#fieldData").html(fieldText);
        $(".edit-close").click();
        $("#edit-cyl-fields-form").trigger("reset");
    });

    $('body').on('click', '.deleteRow', function () {
        var str = $(this).attr('id');
        var id = str.split('_');
        var rowId = "row_" + id[1];
        bootbox.confirm("Are you sure you want to delete this field?", function(result){
            if (result === true) {
                $("#current-files").find("#row_" + id[1]).remove();
            }
        });
    });
    $('body').on('click', '.editRow', function () {
        var str = $(this).attr('id');
        var id = str.split('_');
        var rowId = "row_"+id[1];
        var checkId = $("#"+rowId).find("#admin_rights").html();
        $(".EditSaveBtn").attr('id',rowId);
        $("#edit_field_name").val($("#"+rowId).find("#field_name").html());
        $("#edit_field_length").val($("#"+rowId).find("#field_length").html());
        $("#edit_CylFields_field_type").val($("#"+rowId).find("#field_type").html());
        $("#edit_field_input_type").val($("#"+rowId).find("#field_input_type").html());
        $("#edit_CylFields_is_unique").val($("#"+rowId).find("#is_unique").html());
        $("#edit_is_required").val($("#"+rowId).find("#is_required").html());
        $("#edit_default_value").val($("#"+rowId).find("#default_value").html());
        $("#edit_admin_rights").val($("#"+rowId).find("#admin_rights").html());
        $("#edit_admin_rights_" + checkId).attr('checked','checked');
        $("#edit_admin_label").val($("#"+rowId).find("#admin_label").html());
        $("#edit_admin_input").val($("#"+rowId).find("#admin_input").html());
        $("#edit_description").val($("#"+rowId).find("#description").html());
        var fieldData = $("#"+rowId).find("#fieldData").html();
        if (fieldData){
            $("#fieldsedit").removeClass('hide');
            var obj = jQuery.parseJSON(fieldData);
            $("#fieldsedit .controls").html(' ');
            $.each( obj, function( key, val ) {
                $("#fieldsedit .controls").append('<div class="add-more-fields"><div class="col-sm-5"><input class="form-control" placeholder="Label" value="'+key+'" id="CylFieldValues_label"  name="CylFieldValues[label][]" type="text"></div><div class="col-sm-5"><input class="form-control" placeholder="Value" name="CylFieldValues[predefined_value][]" value="'+val+'" id="CylFieldValues_predefined_value" type="text"></div><div class="col-sm-2"><button type="button" class="btn btn-success btn-danger btn-remove"><span>-</span></button></div></div><br>');
            });
            $("#fieldsedit .controls").append('<div class="add-more-fields"><div class="col-sm-5"><input class="form-control" placeholder="Label" id="CylFieldValues_label"  name="CylFieldValues[label][]" type="text"></div><div class="col-sm-5"><input class="form-control" placeholder="Value" name="CylFieldValues[predefined_value][]" value="" id="CylFieldValues_predefined_value" type="text"></div><div class="col-sm-2"><button type="button" class="btn btn-success btn-add"><span>+</span></button></div></div><br>');
        }
        $("#EditModal").click();

    });

    var dataObj = [];
    var dataObjnew = [];
    $(document).ready(function (e) {
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('admin/Builder/FieldList/'.$id)?>',
            type: "post",
            success: function (response) {
                $('#fields').html(response);
            }
        });
    });

    $('body').on('click', '.field-name', function () {
        var data = {'id' : $(this).attr('id')};
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('admin/Builder/EditField')?>',
            type: "post",
            data:data,
            success: function (response) {
                $('#modal-terms').html(response);
                $('#CreateModal').click();
            }
        });
    });
    $('body').on('change', '#field_input_type', function () {
        if($(this).val() == "select" || $(this).val() == "radio" || $(this).val() == "check" ) {
            $("#fieldsC").removeClass('hide');
        } else {
            $("#fieldsC").addClass('hide');
        }
    });

    $(document).on('click', '.btn-add', function (e) {
        e.preventDefault();
        var controlForm = $('.controls:first'),
            currentEntry = $(this).parents('.add-more-fields:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.btn-add:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-add').addClass('btn-remove')

            .html('<span>-</span>');
    }).on('click', '.btn-remove', function (e) {
        $(this).parents('.add-more-fields:first').remove();

        e.preventDefault();
        return false;
    });

    $("body").on('click', '.btn-adds', function (e) {
        console.log("hide");
        e.preventDefault();
        var controlForm = $('.controlss:first'),
            currentEntry = $(this).parents('.add-more-fieldss:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.btn-adds:not(:last)')
            .removeClass('btn-default').addClass('btn-danger')
            .removeClass('btn-adds').addClass('btn-removes')

            .html('<span>-</span>');
    }).on('click', '.btn-removes', function (e) {
        $(this).parents('.add-more-fieldss:first').remove();

        e.preventDefault();
        return false;
    });

    $('body').on('submit','#cyl-fields-form',function(e){
        console.log('hi');
        e.preventDefault();
        var fieldHtml = '';
        var data = $(this).serializeArray();
        console.log(data);
        var field_id = '';
        var field_id_str = $("#cyl-fields-form").find('.SaveBtn').attr('id');
        var id_array = field_id_str.split('_');
        field_id = id_array[1];
        var jsonObj = [];
        var fields = {};
        var Fromfields = {};

        $( data ).each(function( index, item ) {
            $("#"+field_id).find("input[name='"+item.name+"']").val(item.value);
            $("#"+field_id).find("input[name='"+item.name+"']").parent('.text-left').find('label').html(item.value);
        });

        var tableId = $("#current-files").find("#table_id").val();

        var fieldName = $("#"+field_id).find("#field_name").val();
        var fieldLength = $("#"+field_id).find("#field_length").val();
        var fieldType= $("#"+field_id).find("#field_type").val();
        var fieldInputType = $("#"+field_id).find("#field_input_type").val();
        var IsUnique = $("#"+field_id).find("#is_unique").val();
        var IsRequired = $("#"+field_id).find("#is_required").val();
        var Incremental = $("#"+field_id).find("#incremental_start").val();
        var DefaultValue = $("#"+field_id).find("#default_value").val();
        var AdminRight = $("#"+field_id).find("#admin_rights").val();
        var DisplayStatus = $("#"+field_id).find("#display_status").val();
        var AdminLabel = $("#"+field_id).find("#admin_label").val();
        var AdminImput = $("#"+field_id).find("#admin_input").val();
        var ValidationRule = $("#"+field_id).find("#validation_rule").val();
        var IsCustom = $("#"+field_id).find("#is_custom").val();
        var Description = $("#"+field_id).find("#description").val();

        /*Old cyl Field Value*/
        var FromfieldName = $("#"+field_id).find("#from_field_name").val();
        var FromfieldLength = $("#"+field_id).find("#from_field_length").val();
        var FromfieldType= $("#"+field_id).find("#from_field_type").val();
        var FromfieldInputType = $("#"+field_id).find("#from_field_input_type").val();
        var FromIsUnique = $("#"+field_id).find("#from_is_unique").val();
        var FromIsRequired = $("#"+field_id).find("#from_is_required").val();
        var FromIncremental = $("#"+field_id).find("#from_incremental_start").val();
        var FromDefaultValue = $("#"+field_id).find("#from_default_value").val();

        fields = {
            'table_id' : tableId,
            'field_id' : field_id,
            'field_name' : fieldName,
            'field_length' : fieldLength,
            'field_type' : fieldType,
            'field_input_type' : fieldInputType,
            'is_unique' : IsUnique,
            'is_required' : IsRequired,
            'incremental_start' : Incremental,
            'default_value' : DefaultValue,
            'admin_rights' : AdminRight,
            'display_status' : DisplayStatus,
            'admin_label' : AdminLabel,
            'admin_input' : AdminImput,
            'validation_rule' : ValidationRule,
            'is_custom' : IsCustom,
            'description' : Description
        };

        Fromfields = {
            'table_id' : tableId,
            'field_name' : FromfieldName,
            'field_length' : FromfieldLength,
            'field_type' : FromfieldType,
            'field_input_type' : FromfieldInputType,
            'is_unique' : FromIsUnique,
            'is_required' : FromIsRequired,
            'incremental_start' : FromIncremental,
            'default_value' : FromDefaultValue
        };

        dataObj.push({'newField': fields, 'oldField':Fromfields});
        fields = {};
        Fromfields = {};
        $(".si-close").click();
        $("#cyl-fields-form").trigger("reset");
    });

    $('body').on('click','.saveCrud',function(e){
        e.preventDefault();
        $(".overlay").removeClass('hide');
        var dbobj = [];
        $('#current-files > tbody  > .NewField').each(function(key, value) {
            var dataObj1 = {};
            dataObj1['field_name'] = $(this).find("#field_name").html();
            dataObj1['field_length'] = $(this).find("#field_length").html();
            dataObj1['field_type'] = $(this).find("#field_type").html();
            dataObj1['field_input_type'] = $(this).find("#field_input_type").html();
            dataObj1['is_unique'] = $(this).find("#is_unique").html();
            dataObj1['is_required'] = $(this).find("#is_required").html();
            dataObj1['default_value'] = $(this).find("#default_value").html();
            dataObj1['display_status'] = $(this).find("#display_status").html();
            dataObj1['validation_rule'] = $(this).find("#validation_rule").html();
            dataObj1['is_custom'] = $(this).find("#is_custom").html();
            dataObj1['admin_rights'] = $(this).find("#admin_rights").html();
            dataObj1['admin_label'] = $(this).find("#admin_label").html();
            dataObj1['admin_input'] = $(this).find("#admin_input").html();
            dataObj1['description'] = $(this).find("#description").html();
            dataObj1['fieldData'] = $(this).find("#fieldData").html();

            dbobj.push(dataObj1);
        });
        var tableName = $("#crud_title").val();
        var parentItem = $("#parent_menu_item").val();
        var IconName = $("#menu_icon").val();
        var MenuName = $("#menu_name").val();
        var tableid = '<?php echo $id?>';
        if(!jQuery.isEmptyObject(dataObj) || !jQuery.isEmptyObject(dbobj)){
            $.ajax({
                type:"POST",
                url: '<?php echo Yii::app()->createUrl('admin/Builder/SaveCrud/'.$id)?>',
                data: {'newdata' : dbobj,'data' : dataObj , 'table_name' : tableName,'parentItem' : parentItem, 'iconName' : IconName,'menuname' : MenuName},
                success: function (response) {
                    if(!jQuery.isEmptyObject(dataObjnew)) {
                        $.ajax({
                            url: AddNewField,
                            type: 'POST',
                            data: {'data': dataObjnew, 'table_id': tableid},
                            success: function (response) {
                                //$("#addpermissions").click();

                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {

                            }
                        });
                    }else{
                        //alert('field added successfully');
                        localStorage.editCreateMsg = 1;
                        window.location.reload();
                    }
                }
            });
        }else{
            if(!jQuery.isEmptyObject(dataObjnew)){
                $.ajax({
                    url: AddNewField,
                    type: 'POST',
                    data: {'data' : dataObjnew, 'table_id' : tableid},
                    success: function (response) {
                        //window.location.reload();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                    }
                });
            }else{
                $('#addpermissions').click();
            }
        }

    });

    $('body').on('click','#addFields',function(e){
        $("#CreateModalNew").click();
    });

    $(document).ready(function () {
        // field_name regular expression validation
        $.validator.addMethod("fieldNameRegex", function (value, element, regexpr) {
            return regexpr.test(value);
        }, "Only '-'(dash) and '_'(underscore) special characters are allow ");

        $('body').on('submit','#add-cyl-fields-form',function(e){
            e.preventDefault();
            $("#add-cyl-fields-form").validate({
                debug: true,
                errorClass: "help-block text-right",
                errorElement: "div",
                onfocusout: false,
                onkeyup: false,
                rules: {
                    "CylFields[field_name]": {
                        required: true,
                        fieldNameRegex: /^[a-zA-Z0-9-_]+$/
                    },
                    "CylFields[field_type]": {
                        required: true,
                    },
                    "CylFields[field_length]": {
                        required: true,
                        number: true
                    },
                    "CylFields[admin_label]": {
                        required: true,
                    },
                    "CylFields[admin_rights]": {
                        required: true,
                    },
                },
                messages: {
                    "CylFields[field_name]": {
                        required: "Please enter your field name"
                    },
                    "CylFields[field_type]": {
                        required: "Please enter your field type"
                    },
                    "CylFields[field_length]": {
                        required: "Please enter your field length",
                        number: "Please enter only number"
                    },
                    "CylFields[admin_label]": {
                        required: "Please enter your admin label"
                    },
                    "CylFields[admin_rights]": {
                        required: "Please select admin right"
                    },
                    "CylFields[is_required]": {
                        required: "Please select required field"
                    },
                },
                highlight: function (element, errorClass) {
                    $(element).removeClass(errorClass);
                    $(element).parent().parent().addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).parent().parent().removeClass('has-error');
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: saveData,
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function (response) {
                            //console.log(response);
                            dataObj.push(response.data);
                            $(".bg-gray-lighter").parent('tr').remove();
                            var rowCount = $('#current-files tbody tr').length;
                            $("#current-files").find('tbody').append('<tr id="row_'+parseInt(rowCount+1)+'" class="NewField '+response.id+'"><td><a href="javascript:void(0);" <i class="fa fa-pencil editRow" id="edit_'+parseInt(rowCount+1)+'"></i></a> <a href="javascript:void(0);" <i class="fa fa-times deleteRow" id="delete_'+parseInt(rowCount+1)+'"></i></a></td></tr>');
                            var i = 0;
                            $.each(response.htmlData, function (key, value) {
                                i = i+1;
                                if (i < 8 ) {
                                    var tds = '<td class="text-left">';
                                    tds += '<label id="' + key + '">' + value + '</label>';
                                    tds += '</td>';
                                    $("#current-files").find('tbody').find("." + response.id).append(tds);
                                }else{
                                    var tds = '<td class="text-left hide">';
                                    tds += '<label id="' + key + '">' + value + '</label>';
                                    tds += '</td>';
                                    $("#current-files").find('tbody').find("." + response.id).append(tds);
                                }
                            });
                            $("#current-files").find('#row_'+parseInt(rowCount+1)).append('<td class="hide" id="fieldData">'+response.fieldDAta+'</td>');
                            $(".closNewField").click();
                            $("#add-cyl-fields-form").trigger("reset");

                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {

                        }
                    });
                }
            });
        });
    });
    var saveData = '<?php echo Yii::app()->createUrl('admin/Builder/FieldArray'); ?>';
    var AddNewField = '<?php echo Yii::app()->createUrl('admin/Builder/AddNewField'); ?>';

    $('.role').on("change",function () {
        var id = $(this).attr('id');
        if($(this).prop("checked") == true){
            $("."+id).prop('checked',true)
        }
        else if($(this).prop("checked") == false){
            $("."+id).prop('checked',false)
        }
    });


    $('.headactions').on("change",function () {
        var id = $(this).attr('id');
        if($(this).prop("checked") == true){
            $("input[id = "+id+"]" ).prop('checked',true)
        }
        else if($(this).prop("checked") == false){
            $("input[id = "+id+"]" ).prop('checked',false)
        }
    });

    var permissionurl = "<?php echo Yii::app()->createUrl('/admin/Builder/addpermission'); ?>";
    $('#addpermissions').on("click",function(){

        var data = $("#actionCheck").serialize();
        var controllerName = '<?php echo Yii::app()->session['controllerName'] ?>';
        $.ajax({
            url: permissionurl,
            type: 'POST',
            data: {data: data, controller: controllerName},
            success: function (response) {
                localStorage.editCreateMsg = 1;
                window.location.reload();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });

    });

    $('body').on('focusout','.popup-field-name',function(e){
        var data = {'field_name':$(".popup-field-name").val(),'tableId' : $('#table_id').val()};
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('/admin/Builder/CheckField'); ?>',
            type: 'POST',
            data: data,
            success: function (response) {
                console.log(response);
                if (response == 1){
                    $("#CylFields-name-error").html('Field already exists in table');
                    $(".SaveBtn").attr('disabled', 'disabled');
                }else{
                    $("#CylFields-name-error").html(' ');
                    $(".SaveBtn").removeAttr('disabled');
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });

    $('body').on('focusout','.popup-field-length',function(e){
        if( $(".popup-field-type").val() == 'DATETIME' && $(".popup-field-length").val() > 6 ){
            $("#CylFields-length-error").html('Too-big precision ' + $(".popup-field-length").val() +' specified. Maximum is 6.');
            $(".SaveBtn").attr('disabled', 'disabled');
        }else{
            $("#CylFields-length-error").html('');
            $(".SaveBtn").removeAttr('disabled');
        }
    });
    $(function() {
        $('.icp-auto').iconpicker();
    });

    $(document).ready(function(){
        if (localStorage.getItem('editCreateMsg') == 1){
            $("#editHideEffect").removeClass('hide');
            setTimeout(function(){
                $("#editHideEffect").fadeOut(4000);
            }, 3000);
            localStorage.editCreateMsg = 0;
        }
    });

    $(document).ready(function () {
        var type = $("#field_input_type").val();
        if(type == 'text') {
            $('#cyl-fields-form #CylFields_field_type').val('VARCHAR');
            $('#cyl-fields-form input[name="CylFields[field_length]"]').val('80');
        }else if(type == 'check'){
            $('#cyl-fields-form #CylFields_field_type').val('TINYINT');
            $('#cyl-fields-form input[name="CylFields[field_length]"]').val('4');
        }else if(type == 'radio') {
            $('#cyl-fields-form #CylFields_field_type').val('VARCHAR');
            $('#cyl-fields-form input[name="CylFields[field_length]"]').val('80');
        }else if(type == 'select') {
            $('#cyl-fields-form #CylFields_field_type').val('VARCHAR');
            $('#cyl-fields-form input[name="CylFields[field_length]"]').val('80');
        }else if(type == 'textarea') {
            $('#cyl-fields-form #CylFields_field_type').val('TEXT');
            $('#cyl-fields-form input[name="CylFields[field_length]"]').val('');
        }else if(type == 'date') {
            $('#cyl-fields-form #CylFields_field_type').val('DATE');
            $('#cyl-fields-form input[name="CylFields[field_length]"]').val('');
        }else if(type == 'password') {
            $('#cyl-fields-form #CylFields_field_type').val('VARCHAR');
            $('#cyl-fields-form input[name="CylFields[field_length]"]').val('80');
        }else if(type == 'email') {
            $('#cyl-fields-form #CylFields_field_type').val('VARCHAR');
            $('#cyl-fields-form input[name="CylFields[field_length]"]').val('80');
        }

        if($("#field_input_type").val() == "select" || $("#field_input_type").val() == "radio" || $("#field_input_type").val() == "check" ) {
            $("#fieldsC").removeClass('hide');
            $("#fieldsedit").removeClass('hide');
        } else {
            $("#fieldsedit").addClass('hide');
            $("#fieldsC").addClass('hide');
        }
    });

    $(document).ready(function () {
        $("#add-cyl-fields-form #field_input_type").on('change',function () {

            var type = $(this).val();
            if(type == 'text') {
                $('#add-cyl-fields-form #CylFields_field_type').val('VARCHAR');
                $('#add-cyl-fields-form input[name="CylFields[field_length]"]').val('80');
            }else if(type == 'check'){
                $('#add-cyl-fields-form #CylFields_field_type').val('TINYINT');
                $('#add-cyl-fields-form input[name="CylFields[field_length]"]').val('4');
            }else if(type == 'radio') {
                $('#add-cyl-fields-form #CylFields_field_type').val('VARCHAR');
                $('#add-cyl-fields-form input[name="CylFields[field_length]"]').val('80');
            }else if(type == 'select') {
                $('#add-cyl-fields-form #CylFields_field_type').val('VARCHAR');
                $('#add-cyl-fields-form input[name="CylFields[field_length]"]').val('80');
            }else if(type == 'textarea') {
                $('#add-cyl-fields-form #CylFields_field_type').val('TEXT');
                $('#add-cyl-fields-form input[name="CylFields[field_length]"]').val('');
            }else if(type == 'date') {
                $('#add-cyl-fields-form #CylFields_field_type').val('DATE');
                $('#add-cyl-fields-form input[name="CylFields[field_length]"]').val('');
            }else if(type == 'password') {
                $('#add-cyl-fields-form #CylFields_field_type').val('VARCHAR');
                $('#add-cyl-fields-form input[name="CylFields[field_length]"]').val('80');
            }else if(type == 'email') {
                $('#add-cyl-fields-form #CylFields_field_type').val('VARCHAR');
                $('#add-cyl-fields-form input[name="CylFields[field_length]"]').val('80');
            }
        });
    });
    $('body').on('change', '#edit_field_input_type', function () {
        if($(this).val() == "select" || $(this).val() == "radio" || $(this).val() == "check" ) {
            $("#fieldsC").removeClass('hide');
            $("#fieldsedit").removeClass('hide');
        } else {
            $("#fieldsedit").addClass('hide');
            $("#fieldsC").addClass('hide');
        }
    });

    $('body').on('click', '.FieldDelete', function () {
        var Id = $(this).attr('id');
        var data = {'id' : Id };
        bootbox.confirm("Are you sure you want to delete this field?", function(result){
            if (result === true) {
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl('admin/Builder/FieldDelete')?>',
                    type: "post",
                    data: data,
                    success: function (response) {
                        console.log(response);
                        if (response == 1) {
                            $("#" +Id).addClass('hide');
                        }
                    }
                });
            }
        });
    });

</script>

