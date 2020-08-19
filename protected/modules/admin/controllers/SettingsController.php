<?php

class SettingsController extends CController
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionSettheme()
    {
        if(isset($_POST))
        {
            if($_POST['theme'][1])
            {
                $model = new Settings();
                $model->user_id = yii::app()->user->id;
                $model->settings_key = $_POST['theme'][0];
                $model->value = $_POST['theme'][1];
                $model->created_date = date('Y-m-d H:i:s');
                $model->modified_date = date('Y-m-d H:i:s');

                if ($model->validate()) {
                    $model->save();
                }
            }

            if($_POST['theme'][2])
            {
                $newmodel = new Settings();
                $newmodel->user_id = yii::app()->user->id;
                $newmodel->settings_key = $_POST['theme'][3];
                $newmodel->value = $_POST['theme'][2];
                $newmodel->created_date = date('Y-m-d H:i:s');
                $newmodel->modified_date = date('Y-m-d H:i:s');
                if($newmodel->validate())
                {
                    $newmodel->save();
                }
            }


        }

    }

    public function actionExport(){
        $folder = Yii::app()->params['basePath'];
        if (strpos($folder, 'cyclone') !== false) {
            $exporteddate = date('Y-m-d H:i:s');
            $appname = Yii::app()->params['applicationName'];
            $exportedonsql = "UPDATE app_management SET exported_on = " . "'$exporteddate'" . " where app_name = " . "'$appname'";
            Yii::app()->sitedb->createCommand($exportedonsql)->execute();
        }


        $framework = Yii::app()->params['basePath'].'/fmexport/';
        $sourceapp = Yii::app()->params['basePath'].'/'.Yii::app()->params['applicationName'];
        $destapp = Yii::app()->params['basePath'].'/'.'exportedapp';
        $frameworkdest = Yii::app()->params['basePath'].'/'.'exportedapp/framework';
        $this->recurse_copy($sourceapp,$destapp);
        $this->recurse_copy($framework,$frameworkdest);

        $file = Yii::app()->params['basePath']."/exportedapp/index.php";
        if(is_file($file)){
            unlink($file);
        }
        $oldname = Yii::app()->params['basePath'].'/'.'exportedapp/index2.php';
        $newname = Yii::app()->params['basePath'].'/'.'exportedapp/index.php';
        if(is_file($oldname)){
            rename($oldname,$newname);
        }

        $oldmain = Yii::app()->params['basePath']."/exportedapp/protected/config/main.php";
        if(is_file($oldmain)){
            unlink($oldmain);
        }
        $reoldmain = Yii::app()->params['basePath']."/exportedapp/protected/config/main2.php";
        $newmain = Yii::app()->params['basePath']."/exportedapp/protected/config/main.php";
        if(is_file($reoldmain)){
            rename($reoldmain,$newmain);
        }

        $adminoldmain = Yii::app()->params['basePath']."/exportedapp/protected/modules/admin/views/layouts/main.php";

        if(is_file($adminoldmain)){
            unlink($adminoldmain);
        }
        $adminreoldmain = Yii::app()->params['basePath']."/exportedapp/protected/modules/admin/views/layouts/main2.php";
        $adminnewmain = Yii::app()->params['basePath']."/exportedapp/protected/modules/admin/views/layouts/main.php";
        if(is_file($adminreoldmain)){
            rename($adminreoldmain,$adminnewmain);
        }


        $dbhost = "localhost";
        $dbuser = 'root';
        $dbpass = Yii::app()->sitedb->password;
        $dbname = Yii::app()->params['basePath']."/exportedapp/".Yii::app()->params['applicationName'];
        $databasename = Yii::app()->params['applicationName'];

        $command = "mysqldump --opt -h $dbhost -u $dbuser -p'$dbpass' $databasename > $dbname.sql";

        exec($command);



        // Get real path for our folder
        $rootPath = realpath(Yii::app()->params['basePath']."/exportedapp");
        $zipfile = Yii::app()->params['basePath']."/website.zip";

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($zipfile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();


        DeleteFolder::deleteDir($destapp);


        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.basename($zipfile).'"');
        header("Content-length: " . filesize($zipfile));
        header("Pragma: no-cache");
        header("Expires: 0");

        ob_clean();
        flush();

        readfile($zipfile);

        unlink($zipfile);

    }

    public function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

}