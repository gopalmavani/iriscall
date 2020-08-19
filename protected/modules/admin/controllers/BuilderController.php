<?php

class BuilderController extends CController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    public function accessRules()
    {
        return UserIdentity::accessRules();
    }
    /**
     * Edit crud field of given table id .
     */
    public function actionCreate(){
        $parents=CylTables::model()->findAll(
            array(
                'condition'=>'isParent="1" AND display_status = "1"',
                'order'=>'menu_order'
            ));
        $model = new CylFields();
        $this->render('new-field', array('model' => $model,'parents' => $parents));
    }

    /**
     * Edit crud field of given table id .
     */
    public function actionEditCrud($id){
        $modelCyl = new CylFields();
        $parents=CylTables::model()->findAll(
            array(
                'condition'=>'isParent="1" AND display_status = "1"',
                'order'=>'menu_order'
            ));
        $table = CylTables::model()->findByAttributes(['table_id' => $id]);
        $this->render('edit-crud',array('id'=>$id, 'table' => $table,'parents' => $parents,'modelCyl'=>$modelCyl));
    }

    /**
     * Displays fields of crud.
     */
    public function actionFieldList($id){

        $fields= Yii::app()->db->createCommand()
            //->select('*')
            ->select('field_name,field_length,field_type,field_input_type,is_unique,is_required,default_value')
            ->from('cyl_fields')
            ->where('table_id = '.$id)
            ->queryRow();

        $field_values = Yii::app()->db->createCommand()
            //->select('field_id,field_name,field_length,field_type,field_input_type,is_unique,is_required,incremental_start,default_value')
            ->select('*')
            ->from('cyl_fields')
            ->where('table_id = '.$id)
            ->queryAll();

        foreach ($fields as $key => $field){
            $field_title[] = $key;
        }
        $this->renderPartial('field-list',array('fields'=>$field_title,'fields_value' => $field_values,'id'=>$id));
    }

    /**
     * Displays fields of crud.
     */
    public function actionEditField(){
        $model = CylFields::model()->findByAttributes(['field_id' => $_POST['id']]);
        $this->renderPartial('edit-field',array('model' => $model));
    }

    /**
     * Saves Altered CRUD.
     */
    public function actionSaveCrud($id){
        $field_lengthCyl = $field_input_type = $is_unique = $is_required = $incremental_start = $default_value = $admin_rights = $display_status = $admin_label = $admin_input = $validation_rule = $is_custom = $description = 'NULL';
        $table = CylTables::model()->findByAttributes(['table_id' => $id]);
        $table->parent_item = $_POST['parentItem'];
        ($table->validate()) ? $table->save() : print_r($table->getErrors());
        if (isset($_POST['data'])) {
            foreach ($_POST['data'] as $data) {
                if(isset($data['newField']) && isset($data['oldField'])){
                    $field_length = $unique = $oldFieldName = $auto_incre = $mandatory = $auto_incre = $table_name = $ptimary = $default = "";

                    $table = CylTables::model()->findByAttributes(['table_id' => $data['newField']['table_id']]);
                    $field_name = $data['newField']['field_name'];
                    $field_type = $data['newField']['field_type'];
                    $field_id = $data['newField']['field_id'];

                    $table_id = $data['newField']['table_id'];
                    $field_lengthCyl = ($data['newField']['field_length']) ? $data['newField']['field_length'] : 'NULL';
                    $field_input_type = ($data['newField']['field_input_type']) ? $data['newField']['field_input_type'] : 'NULL';
                    $is_unique = ($data['newField']['is_unique']) ? $data['newField']['is_unique'] : 0;
                    $is_required = ($data['newField']['is_required']) ? $data['newField']['is_required'] : 0;
                    /*$incremental_start = ($data['newField']['incremental_start']) ? $data['newField']['incremental_start'] : 0;*/
                    $default_value = ($data['newField']['default_value']) ? $data['newField']['default_value'] : 'NULL';
                    $admin_rights = ($data['newField']['admin_rights']) ? $data['newField']['admin_rights'] : 0;
                    $display_status = ($data['newField']['display_status']) ? $data['newField']['display_status'] : 0;
                    $admin_label = ($data['newField']['admin_label']) ? $data['newField']['admin_label'] : 'NULL';
                    $admin_input = ($data['newField']['admin_input']) ? $data['newField']['admin_input'] : 'NULL';
                    $validation_rule = ($data['newField']['validation_rule']) ? $data['newField']['validation_rule'] : 'NULL';
                    $is_custom = ($data['newField']['is_custom']) ? $data['newField']['is_custom'] : 0;
                    $description = ($data['newField']['description']) ? $data['newField']['description'] : 'NULL';

                    $oldFieldName = $data['oldField']['field_name'];
                    if ($data['newField']['field_length']) {
                        $field_length = "(" . $data['newField']['field_length'] . ")";
                    }

                    if ($data['newField']['is_required'] == 1) {
                        $mandatory = "NOT NULL";
                    } else {
                        $mandatory = "NULL";
                    }

                    if ($data['newField']['is_unique'] == 1) {
                        $unique = "UNIQUE";
                    }

                    $field_data = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('cyl_field_values')
                        ->where("field_id=" . $field_id)
                        ->queryall();

                    $label = $value = "";
                    if ($field_data) {
                        foreach ($field_data as $field) {
                            if ($field['field_label']) {

                                $label[] = [
                                    'label' => $field['field_label'],
                                    'value' => $field['predefined_value']
                                ];
                            }
                        }
                    }

                    $comment = array(
                        'label' => $admin_label,
                        'name' => $field_name,
                        'admin_right' => $admin_rights,
                        'display_status' => $display_status,
                        'data_type' => $field_type,
                        'default_value' => $default_value,
                        'is_custom' => $is_custom,
                        'length' => $field_length,
                        'field_input_type' => $field_input_type,
                        'field_data' => $label
                    );

                    $comment_json = "COMMENT '" . CJSON::encode($comment) . "'";

                    $nquery[] = "CHANGE $oldFieldName $field_name $field_type$field_length $default $mandatory $ptimary $comment_json";
                    $nq = implode(", ", $nquery);

                    Yii::app()->db->createCommand("ALTER TABLE $table->table_name $nq")->execute();

                    $UpdateCylField = "UPDATE cyl_fields SET 
                    `field_length` = '$field_lengthCyl',
                    `field_name` = '$field_name',
                    `field_type` = '$field_type',
                    `field_input_type` = '$field_input_type',
                    `is_unique` = $is_unique,
                    `is_required` = $is_required,
                    `incremental_start` = $incremental_start,
                    `default_value` = '$default_value',
                    `admin_rights` = $admin_rights,
                    `display_status` = '$display_status',
                    `admin_label` = '$admin_label',
                    `admin_input` = '$admin_input',
                    `validation_rule` = '$validation_rule',
                    `is_custom` = 1,
                    `description` = '$description' WHERE  `field_id` = $field_id AND `table_id` = $table_id";

                    Yii::app()->db->createCommand($UpdateCylField)->execute();
                }
            }
        }
        if(isset($_POST['newdata'])){
            $field_length = $unique = $oldFieldName = $auto_incre = $mandatory = $auto_incre = $table_name = $ptimary = $default = "";
            foreach ($_POST['newdata'] as $newField) {
                $CylField = new CylFields();
                $CylField->attributes = $newField;
                $CylField->table_id = $table->table_id;
                $CylField->incremental_start = 0;
                $CylField->created_date = date('Y-m-d H:i:s');
                ($CylField->validate()) ? $CylField->save() : print_r($CylField->getErrors());
                if(isset($newField['fieldData'])){
                    $fielddata = json_decode($newField['fieldData']);
                    foreach ($fielddata as $key => $val){
                        $cylFieldValue = new CylFieldValues();
                        $cylFieldValue->predefined_value = $val;
                        $cylFieldValue->field_label = $key;
                        $cylFieldValue->field_id = $CylField->field_id;
                        $cylFieldValue->save();
                    }
                }

                $field_name = $newField['field_name'];
                $field_type = $newField['field_type'];
                if ($newField['field_length']) {
                    $field_length = "(" . $newField['field_length'] . ")";
                }

                if ($newField['is_required'] == 1) {
                    $mandatory = "NOT NULL";
                } else {
                    $mandatory = "NULL";
                }

                /*if ($newField['incremental_start'] == 1) {
                    $auto_incre = "AUTO_INCREMENT";
                }*/

                if ($newField['is_unique'] == 1) {
                    $unique = "UNIQUE";
                }

                $field_data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('cyl_field_values')
                    ->where("field_id=" . $CylField->field_id)
                    ->queryall();

                $label = $value = "";
                if ($field_data) {
                    foreach ($field_data as $field) {
                        if ($field['field_label']) {

                            $label[] = [
                                'label' => $field['field_label'],
                                'value' => $field['predefined_value']
                            ];
                        }
                    }
                }

                $comment = array(
                    'label' => $newField['admin_label'],
                    'name' => $newField['field_name'],
                    'admin_right' => $newField['admin_rights'],
                    'display_status' => $newField['display_status'],
                    'data_type' => $newField['field_type'],
                    'default_value' => $newField['default_value'],
                    'is_custom' => $newField['is_custom'],
                    'length' => $newField['field_length'],
                    'field_input_type' => $newField['field_input_type'],
                    'field_data' => $label
                );

                $comment_json = "COMMENT '" . CJSON::encode($comment) . "'";
                $add = "$field_name $field_type$field_length $default $mandatory $ptimary $comment_json";

                Yii::app()->db->createCommand("ALTER TABLE $table->table_name ADD $add")->execute();
            }
        }
        $modelName = ucfirst(str_replace(" ", " ",$table->table_name));


        $model = CycloneHelper::gii('model', [
            "tableName" => $table->table_name
        ]);
        if ($model){
            $template = CycloneHelper::gii('admin', [
                "template" => str_replace(" ","",$modelName)
            ]);
            if ($template){
                echo json_encode([
                    'token'=>1,
                    'msg'=>'success'
                ]);
            }
        }
    }

    public function actionFieldArray(){
        header("Content-type: application/json");
        if (isset($_POST['CylFields'])) {
            $CylField['field_name'] = ($_POST['CylFields']['field_name']) ? $_POST['CylFields']['field_name'] : 0;
            $CylField['field_length'] = ($_POST['CylFields']['field_length']) ? $_POST['CylFields']['field_length'] : 0;
            $CylField['field_type'] = ($_POST['CylFields']['field_type']) ? $_POST['CylFields']['field_type'] : 0;
            $CylField['field_input_type'] = ($_POST['CylFields']['field_input_type']) ? $_POST['CylFields']['field_input_type'] : 0;
            $CylField['is_unique'] = ($_POST['CylFields']['is_unique']) ? $_POST['CylFields']['is_unique'] : 0;
            $CylField['is_required'] = ($_POST['CylFields']['is_required']) ? $_POST['CylFields']['is_required'] : 0;
            $CylField['default_value'] = ($_POST['CylFields']['default_value']) ? $_POST['CylFields']['default_value'] : 0;
            $CylField['display_status'] = 1;
            $CylField['validation_rule'] = NULL;
            $CylField['is_custom'] = 1;
            $CylField['admin_rights'] = ($_POST['CylFields']['admin_rights']) ? $_POST['CylFields']['admin_rights'] : 0;
            $CylField['admin_label'] = (isset($_POST['CylFields']['admin_label'])) ? $_POST['CylFields']['admin_label'] : 0;
            $CylField['admin_input'] = ($_POST['CylFields']['admin_input']) ? $_POST['CylFields']['admin_input'] : 0;
            $CylField['description'] = ($_POST['CylFields']['description']) ? $_POST['CylFields']['description'] : 0;

            if ($_POST['CylFieldValues']) {
                foreach (array_combine($_POST['CylFieldValues']['predefined_value'], $_POST['CylFieldValues']['label']) as $predefined_value => $label) {
                    if ($predefined_value) {
                        $CylField['CylFieldValues'][$label] = $predefined_value;
                    }
                }
            }
            $fieldDAta = [];
            if (isset($CylField['CylFieldValues']) && !empty($CylField['CylFieldValues'])){
                $fieldDAta = $CylField['CylFieldValues'];
            }
            $TrData = [
                'field_name' => $CylField['field_name'],
                'field_length' => $CylField['field_length'],
                'field_type' => $CylField['field_type'],
                'field_input_type' => $CylField['field_input_type'],
                'is_unique' => $CylField['is_unique'],
                'is_required' => $CylField['is_required'],
                'default_value' => $CylField['default_value'],
                'display_status' => $CylField['display_status'],
                'validation_rule'=> $CylField['validation_rule'],
                'is_custom' => $CylField['is_custom'],
                'admin_rights'=> $CylField['admin_rights'],
                'admin_label'=> $CylField['admin_label'],
                'admin_input'=> $CylField['admin_input'],
                'description'=> $CylField['description'],
            ];

            echo json_encode([
                'id'=>$CylField['field_name'],
                'data' => $CylField,
                'htmlData' => $TrData,
                'fieldDAta' => json_encode($fieldDAta)
            ]); die;
        }
    }

    public function actionCreateCrud(){
        if ($_POST){
            $id = array
            (
                'field_length' => 11,
                'field_name' => 'id',
                'field_type' => 'INT',
                'field_input_type' => 'text',
                'is_unique' => 0,
                'incremental_start' => 1,
                'is_required' => 1,
                'default_value' => '',
                'admin_rights' => '1',
                'display_status' => '1',
                'admin_label' => 'Id',
                'admin_input' => 'id',
                'validation_rule' => '',
                'is_custom' => '1',
                'description' => 'id');

            array_unshift($_POST['data'],$id);

            $table_name = str_replace(" ","_",strtolower($_POST['table_name']));
            $parentItem = (isset($_POST['parentItem'])) ? $_POST['parentItem'] : 0 ;
            $modelName = ucwords(str_replace("_", " ", $table_name));
            $module_name = ucwords(str_replace("_", " ", $table_name));;
            $menu_name = $_POST['menuname'];
            $menu_icon = "fa ".$_POST['iconName'];

            $CylTable = new CylTables();
            $CylTable->table_name = $table_name;
            $CylTable->module_name = $module_name;
            $CylTable->menu_icon = $menu_icon;
            $CylTable->menu_name = $menu_name;
            $CylTable->is_editable = 1;
            $CylTable->action = lcfirst(str_replace(" ","",$modelName)).'/admin';
            $CylTable->display_status = 1;
            $CylTable->parent_item = $parentItem;
            if ($parentItem > 0 ) {
                $CylTable->isMenu = 0;
            }else{
                $CylTable->isMenu = 1;
            }
            $CylTable->created_date = date('Y-m-d H:i:s');
            $CylTable->modified_date = date('Y-m-d H:i:s');
            if($CylTable->validate()) {
                if ($CylTable->save()) {
                    foreach ($_POST['data'] as $value) {
                        $model = new CylFields;
                        $model->attributes = $value;
                        $model->table_id = $CylTable->table_id;
                        $model->created_date = date('Y-m-d H:i:s');
                        $model->modified_date = date('Y-m-d H:i:s');
                        if ($model->validate()) {
                            if ($model->save()) {
                                if(isset($value['field_data'])){
                                    $fielddata = json_decode($value['field_data']);
                                    foreach ($fielddata as $key => $val){
                                        $cylFieldValue = new CylFieldValues();
                                        $cylFieldValue->predefined_value = $val;
                                        $cylFieldValue->field_label = $key;
                                        $cylFieldValue->field_id = $model->field_id;
                                        $cylFieldValue->save();
                                    }
                                }

                                if ($model->incremental_start == 1){
                                    Yii::app()->db->createCommand('INSERT INTO  `cyl_pk_fk` 
                                    (`field_id`,`key_type`,`fk_field_id`,`table_id`,`create_date`,`modified_date`) VALUES  
                                    ("'.$model->field_id.'", 1,NULL,"'.$model->table_id.'","'.date('Y-m-d H:i:s').'","'.date('Y-m-d H:i:s').'")')->execute();
                                }
                            }
                        }
                    }
                }
            }else{
                print_r($CylTable->getErrors()); die;
            }
            $tables = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cyl_fields f')
                ->leftjoin('cyl_tables t', 't.table_id=f.table_id')
                ->where("f.table_id=$model->table_id")
                ->queryall();

            $chk_pk_fk = Yii::app()->db->createCommand()
                ->select('pk.field_id, pk.key_type, f.field_name, t.table_name, pk.fk_field_id, (select t2.table_name from cyl_fields f2 join cyl_tables t2 on t2.table_id = f2.table_id where f2.field_id = pk.fk_field_id) as ref_table ')
                ->from('cyl_pk_fk pk')
                ->join('cyl_fields f', 'f.field_id = pk.field_id')
                ->join('cyl_tables t', 't.table_id = pk.table_id')
                ->where("pk.table_id=$model->table_id")
                ->queryall();

            //print_r($chk_pk_fk); die;

            $pk = $fk = $dfk = $fk_token = $pk_token = "";
            foreach ($chk_pk_fk as $key => $pk_fk) {
                $random_const = rand(9999, 99999);
                if ($pk_fk['key_type'] == 2) {
                    $fk_token = 1;
                    $fk .= " CONSTRAINT fk_" . $pk_fk['field_name'] . "_on_" . $pk_fk['ref_table'] . $random_const . " FOREIGN KEY (" . $pk_fk['field_name'] . ") REFERENCES " . $pk_fk['ref_table'] . "(" . $pk_fk['field_name'] . "),";
                    $dfk = "DROP FOREIGN KEY fk_" . $pk_fk['ref_table'] . ", ADD CONSTRAINT fk_" . $pk_fk['ref_table'] . " FOREIGN KEY (" . $pk_fk['field_name'] . ") REFERENCES " . $pk_fk['ref_table'] . "(" . $pk_fk['field_name'] . ") ON DELETE CASCADE";
                } else {
                    $pk_token = 1;
                    $pk = "PRIMARY KEY (" . $pk_fk['field_name'] . ")";
                }
            }
            $tables_col = Yii::app()->db->createCommand()
                ->select('*')
                ->from('cyl_fields')
                ->where('table_id=:id', array(':id' => $model->table_id))
                ->queryall();
            $alter_q = $table_name = "";
            $comment = array();

            foreach ($tables as $table) {

                $field_length = $unique = $auto_incre = $mandatory = $auto_incre = $table_name = $ptimary = $default = "";

                $field_name = "`".$table['field_name']."`";
                $field_type = $table['field_type'];
                $table_name = $table['table_name'];
                if ($table['field_length']) {
                    $field_length = "(" . $table['field_length'] . ")";
                }

                if ($table['is_required'] == 1) {
                    $mandatory = "NOT NULL";
                }else{
                    $mandatory = "NULL";
                }

                if ($table['incremental_start'] == 1) {
                    $auto_incre = "AUTO_INCREMENT";
                }

                if ($table['is_unique'] == 1) {
                    $unique = "UNIQUE";
                }


                $field_data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('cyl_field_values')
                    ->where("field_id=" . $table['field_id'])
                    ->queryall();
                $label = $value = "";
                if ($field_data) {
                    foreach ($field_data as $field) {
                        if ($field['field_label']) {

                            $label[] = [
                                'label' => $field['field_label'],
                                'value' => $field['predefined_value']
                            ];
                        }
                    }
                }
                $comment = array(
                    'label' => $table['admin_label'],
                    'name' => $table['field_name'],
                    'admin_right' => $table['admin_rights'],
                    'display_status' => $table['display_status'],
                    'data_type' => $table['field_type'],
                    'default_value' => $table['default_value'],
                    'is_custom' => $table['is_custom'],
                    'length' => $table['field_length'],
                    'field_input_type' => $table['field_input_type'],
                    'field_data' => $label
                );

                $comment_json = "COMMENT '" . CJSON::encode($comment) . "'";
                $query[] = "$field_name $field_type$field_length $default $mandatory $auto_incre $unique $comment_json";
                $change_query[] = "change $field_name $field_name $field_type$field_length $default $mandatory $auto_incre $comment_json";
            }
            $q = implode(", ", $query);

//        echo $q;die;


            if ($pk_token == 1) {
                $q = $q . ", " . $pk;
            }

            if ($fk_token == 1) {
                $q = $q . ", " . $fk;
            }

            $cq = implode(", ", $change_query);
            $alter_q = $cq;
            $new_fields1 = "";

//        echo $table_name;die;
            $table = Yii::app()->db->schema->getTable($table_name);

            $q = rtrim($q, ',');
            if (!$table) {
                $num2 = Yii::app()->db->createCommand(" CREATE TABLE $table_name($q) ENGINE=InnoDB ; ")->execute();

                if (Yii::app()->db->schema->getTable("categories") && $table_name == "categories") {
                    Yii::app()->db->createCommand("INSERT INTO `categories` (category_name, description, is_active, created_at, modified_at, is_delete) VALUES ('Default', 'default description', '1','$current_time', NULL, '0');")->execute();
                }
                $msg = [];
                $result = true;
                if (!$num2 == 0) {
                    $msg [] = [
                        "error" => CycloneHelper::codes(513),
                        "result" => 'false',
                    ];
                } else {
                    CycloneHelper::jsonResponse(200);
                }
            } else {
                //If exists check columns and if new columns are added create new columns
                $exist = Yii::app()->db->schema->getTable($table_name)->columns;
                foreach ($exist as $exit) {
                    $exist_column[] = $exit->name;
                }
                foreach ($tables_col as $tab) {
                    $table_column[] = $tab['field_name'];
                }
                $new_fields = array_diff($table_column, $exist_column);

                $new_fields1 = array_diff($exist_column, $table_column);

                if ($new_fields) {
                    foreach ($new_fields as $key => $new_field) {
                        $new_tab_col = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('cyl_fields')
                            ->where("field_name='$new_field' AND table_id=$model->table_id")
                            ->queryall();


                        foreach ($new_tab_col as $new_table) {

                            $field_length = $mandatory = $auto_incre = $ptimary = "";

                            $field_name = "'".$new_table['field_name']."'";
                            $field_type = $new_table['field_type'];

                            if ($new_table['field_length']) {
                                $field_length = "(" . $new_table['field_length'] . ")";
                            }

                            if ($new_table['is_required'] == 1) {
                                $mandatory = "NOT NULL";
                            }else{
                                $mandatory = "NULL";
                            }

                            if ($new_table['incremental_start'] == 1) {
                                $auto_incre = "AUTO_INCREMENT";
                            }

                            $nquery[] = "$field_name $field_type$field_length $default $mandatory $ptimary";
                            $change_new_query[] = "$field_name $field_name $field_type$field_length $default $mandatory $ptimary";
                        }
                        $nq = implode(", ", $nquery);
                        $cnq = implode(", ", $change_new_query);
                    }
                    $num1 = Yii::app()->db->createCommand("ALTER TABLE $table_name ADD ($nq);")->execute();
                    $msg = [];
                    $result = true;
                    if (!$num1 == 0) {
                        $msg [] = [
                            "error" => CycloneHelper::codes(513),
                            "result" => 'false',
                        ];
                    } else {
                        CycloneHelper::jsonResponse(200);
                    }
                }
            }
            if ($new_fields1) {
                foreach ($new_fields1 as $key => $new_field) {
                    $delete_query = "ALTER TABLE $table_name DROP $new_field;";
                    Yii::app()->db->createCommand($delete_query)->execute();

                }
            }
            $num = Yii::app()->db->createCommand("ALTER TABLE $table_name $alter_q;")->execute();
            if ($num == 0) {
                $return = true;
            } else {
                $return = false;
            }

            if ($return === true){
                $model = CycloneHelper::gii('model', [
                    "tableName" => $table_name
                ]);


                $template = CycloneHelper::gii('admin', [
                    "template" => str_replace(" ","",$modelName)
                ]);
                if ($model && $template){
                    echo json_encode([
                        'result' => true,
                    ]);
                }
            }else{
                echo $return;
            }

        }
    }

    public function actionAddNewField(){
        if ($_POST) {
            $tableId = $_POST['table_id'];
            $tableName = CylTables::model()->findByAttributes(['table_id' => $tableId]);
            foreach ($_POST['data'] as $value) {
                $IsNull = ($value['is_required']) ? 'NOT NULL' : 'NULL';

                $comment = array(
                    'label' => $value['admin_label'],
                    'name' => $value['field_name'],
                    'admin_right' => $value['admin_rights'],
                    'display_status' => $value['display_status'],
                    'data_type' => $value['field_type'],
                    'default_value' => $value['default_value'],
                    'is_custom' => $value['is_custom'],
                    'length' => $value['field_length'],
                    'field_input_type' => $value['field_input_type'],
                    /*'field_data' => $label*/
                );
                $comment_json = "COMMENT '" . CJSON::encode($comment) . "'";
                $AlterTable = "ALTER TABLE ".$tableName->table_name." ADD COLUMN ".$value['field_name'] ." ". $value['field_type']."(".$value['field_length'].") ". $IsNull . " " .$comment_json." ";
                $model = new CylFields;
                $model->attributes = $value;
                $model->table_id = $tableId;
                $model->created_date = date('Y-m-d H:i:s');
                $model->modified_date = date('Y-m-d H:i:s');
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::app()->db->createCommand($AlterTable)->execute();

                        $model = CycloneHelper::gii('model', [
                            "tableName" => $tableName->table_name
                        ]);

                        $modelName = ucwords(str_replace("_", " ", $tableName->table_name));


                        $template = CycloneHelper::gii('admin', [
                            "template" => str_replace(" ","",$modelName)
                        ]);
                        if ($model && $template){
                            echo json_encode([
                                'result' => true,
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function actionAddpermission(){
        $created_at = date('Y-m-d H:i:s');
        $modified_at = date('Y-m-d H:i:s');
        $controller = $_POST['controller'];

        if(isset($_POST['data'])){
            /*            echo "<pre>";
                        print_r($_POST['data']); die;*/
            Yii::app()->db->createCommand("DELETE  FROM role_mapping WHERE `controller` = '$controller'")->execute();
            if (!empty($_POST['data'])) {
                $data = explode("&", $_POST['data']);
                foreach ($data as $key => $value) {
                    $role = explode('=', $value);
                    $sql = "INSERT into role_mapping (`controller`,`role`,`allowed_actions`,`created_at`,`modified_at`) VALUES('$controller','$role[0]','$role[1]','$created_at','$modified_at')";
                    Yii::app()->db->createCommand($sql)->execute();

                }
            }
        }
    }

    public function actionCheckField(){
        $model = CylFields::model()->findByAttributes(['table_id' => $_POST['tableId'], 'field_name' => $_POST['field_name']]);
        if ($model){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function actionFieldDelete(){
        $model = CylFields::model()->findByAttributes(['field_id' => $_POST['id']]);
        $table_name = CylTables::model()->findByAttributes(['table_id' => $model->table_id]);
        $drop = Yii::app()->db->createCommand("ALTER TABLE ".$table_name->table_name." DROP COLUMN ".$model->field_name)->execute();
        $drop1 = Yii::app()->db->createCommand("DELETE FROM cyl_fields WHERE field_name = '".$model->field_name."'")->execute();
        if ($drop && $drop1){
            echo 0;
        }else{
            echo 1;
        }
    }

    public function actionIconLst(){
        if(isset($_GET)){
            $users = Yii::app()->db->createCommand()
                ->select('user_id, full_name')
                ->from('user_info')
                ->where('full_name LIKE "%'.($_GET['q']).'%"')
                ->queryAll();
            foreach ($users as $user){
                $data[] = ['text' => $user['full_name'], 'id' => $user['user_id']];
            }
            echo json_encode($data);
        }
    }
}