<?php

class MenuController extends CController
{
    var $all_childs = array();
    var $level = array();
    var $item_list_field_name;

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column1';

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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionIndex()
    {
        /*$menu=CylTables::model()->findAll(
            array(
                'condition'=>'isMenu="1" AND display_status = "1"',
                'order'=>'menu_order desc'
            ));*/

        $menu = Yii::app()->db->createCommand('SELECT * FROM `cyl_tables` WHERE `isMenu` = 1  AND `display_status` =  1 ORDER BY `menu_order`')->queryAll();

        $this->render('index',array('menu' => $menu));
    }

    /**
     * Save menu order.
     */
    public function actionSaveMenu()
    {
        $tree = json_decode($_POST['tree'], True);
        $i = 0;
        /*echo "<pre>";
        print_r($tree); die;*/
        foreach ($tree as $key => $value){
            $i++;
            $parent = CylTables::model()->findByAttributes(['menu_name' => $value['name']]);
            $parent->menu_order = $i;
            ($parent->validate()) ? $parent->save() : print_r($parent->getErrors());
            if (isset($value['children']) && is_array($value['children'])) {
                foreach ($value['children'] as $ke => $val) {
                    $i++;
                    $child = CylTables::model()->findByAttributes(['menu_name' => $val['name']]);
                    $child->parent_item = $parent->table_id;
                    $child->isMenu = 0;
                    $child->menu_order = $i;
                    ($child->validate()) ? $child->save() : print_r($child->getErrors());
                    if (isset($val['children']) && is_array($val['children'])) {
                        foreach ($val['children'] as $k => $v) {
                            $i++;
                            $grandChild = CylTables::model()->findByAttributes(['menu_name' => $v['name']]);
                            $grandChild->parent_item = $child->table_id;
                            $grandChild->isMenu = 0;
                            $grandChild->menu_order = $i;
                            ($grandChild->validate()) ? $grandChild->save() : print_r($grandChild->getErrors());
                        }
                    } else {
                        Yii::app()->db->createCommand('UPDATE  `cyl_tables` SET isMenu = 1 , parent_item = 0, menu_order = '.$i.' WHERE parent_item = ' . $child->table_id)->execute();
                    }

                }
            } else {
                $parent->isMenu = 1;
                $parent->parent_item = 0;
                ($parent->validate()) ? $parent->save() : print_r($parent->getErrors());
                /*echo "<pre>";
                print_r($parent->attributes); die;
                Yii::app()->db->createCommand('UPDATE  `cyl_tables` SET isMenu = 1 , parent_item = 0,  menu_order = '.$i.' WHERE parent_item = ' . $parent->table_id)->execute();*/
            }
        }
        echo json_encode([
            'token' => 1,
            'msg' => 'Menu saved successfully'
        ]);
    }

    public function actionAllChilds($id, $start=true) { // get all the childs of all the levels under a parent as a tree
        $immediate_childs = $this->actionImmediateChilds($id);
        $i =0;
        if(count($immediate_childs)>0) {
            $i++;
            foreach($immediate_childs as $chld) {
                $child = $chld->attributes;
                array_push($this->all_childs,$child['table_id']);
                $this->actionAllChilds($child['table_id'], false);
            }
        }
        if ($start){
            return $this->all_childs;
        }
    }

    public function actionImmediateChilds($id) { // get only the direct/immediate childs under a parent
        $user = CylTables::model()->findAllByAttributes(['parent_item' => $id]);

        $childs=array();
        if($user) {
            foreach ($user as $val){
                $Html = [
                    'name' => $val->table_name
                ];
                array_push($childs,$val);
            }
        }
        return $childs;
    }

    public function actionTree(){
        $tables = CylTables::model()->findAll();
        $user_array = array();
        foreach ($tables as $table) {
            $tableDetails = CylTables::model()->findAllByAttributes(['parent_item' => $table->table_id]);
            foreach($tableDetails as $key => $value) {
                array_push($user_array, array(
                    'id' => $value->table_id,
                    'parent_id' => ($value->parent_item == NULL) ? 0 : $value->parent_item,
                    'data' => ($value) ? $value->attributes : 'No data available',
                ));
            }
        }

        return $this->actionbuildTree($user_array);
    }

    public function actionbuildTree(array $elements)
    {
        echo "<pre>";
        print_r($elements); die;
        $branch = array();

        foreach ($elements as $element) {
            $children = $this->actionbuildTree($elements);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
        return $branch;
    }

    /**
     * create menu item
     */
    public function actionCreate($id)
    {
        if ($id == 1){
            $parents=CylTables::model()->findAll(
                array(
                    'condition'=>'isMenu="1"',
                    'order'=>'menu_order'
                ));
            if (isset($_POST['NonCrud'])){
                $order = Yii::app()->db->createCommand('SELECT MAX(menu_order) as topOrder FROM `cyl_tables`')->queryRow();
                $cylTeble = new CylTables();
                $cylTeble->parent_item = 0;
                $cylTeble->isMenu = 1;
                if (isset($_POST['NonCrud']['ParentMenuItem'])) {
                    $cylTeble->parent_item = $_POST['NonCrud']['ParentMenuItem'];
                    $cylTeble->isMenu = 0;
                }
                $cylTeble->menu_icon = $_POST['NonCrud']['MenuIcon'];
                $cylTeble->table_name = $_POST['NonCrud']['Title'];
                $cylTeble->module_name = $_POST['NonCrud']['Title'];
                $cylTeble->menu_name = $_POST['NonCrud']['Visual-Title'];
                $cylTeble->display_status= 1;
                $cylTeble->action= 'index';
                $cylTeble->menu_order = $order['topOrder'];

                if ($cylTeble->validate()){
                    if ($cylTeble->save()){
                        $this->redirect(array('menu/index'));
                    }
                }else{
                    print_r($cylTeble->getErrors());
                }

            }else {
                $this->render('non-crud',array('parents' => $parents));
            }
        }
        if ($id == 2){

            if (isset($_POST['ParentItem'])){
                $order = Yii::app()->db->createCommand('SELECT MAX(menu_order) as topOrder FROM `cyl_tables`')->queryRow();
                $cylTeble = new CylTables();
                $cylTeble->parent_item = 0;
                $cylTeble->isMenu = 1;
                $cylTeble->isParent = 1;
                $cylTeble->menu_icon = 'fa '.$_POST['ParentItem']['MenuIcon'];
                $cylTeble->table_name = $_POST['ParentItem']['Title'];
                $cylTeble->module_name = $_POST['ParentItem']['Title'];
                $cylTeble->menu_name = $_POST['ParentItem']['Visual-Title'];
                $cylTeble->display_status= 1;
                $cylTeble->action= 'index';
                $cylTeble->menu_order = $order['topOrder'];
                if ($cylTeble->validate()){
                    if ($cylTeble->save()){
                        $this->redirect(array('menu/index'));
                    }
                }else{
                    print_r($cylTeble->getErrors());
                }

            }else {
                $this->render('parent-menu');
            }
        }
    }

    /**
     * Update Menu name.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionUpdate($id)
    {
        if (isset($_POST['ParentItem'])){
            $model = CylTables::model()->findByAttributes(['table_id' => $id]);
            $model->menu_icon = 'fa '.$_POST['ParentItem']['MenuIcon'];
            $model->menu_name = $_POST['ParentItem']['Visual-Title'];
            $model->save();
            $this->redirect(array('menu/index'));
        }else{
            $model = CylTables::model()->findByAttributes(['table_id' => $id]);
            $this->render('update',array('model' => $model));
        }

    }

    public function actionRedirect()
    {
        $model = CylTables::model()->findByAttributes(['menu_name' => $_POST['tableName']]);
        if ($model->isMenu == 1 && $model->isParent == 1){
            echo json_encode([
                'token' => 1,
                'table_id' => $model->table_id,
            ]);
        }else{
            echo json_encode([
                'token' => 0,
                'table_id' => $model->table_id,
            ]);
        }
    }


}
