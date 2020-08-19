<?php

class BuildhtmlController extends CController
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
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->layout = 'builder';
        $this->render('index');
    }

    public function actionElements() {
        header('Content-type: application/json');
        $elements = Yii::app()->baseUrl.'/plugins/builder/elements';
        $elements = array (
            'elements' =>
                array (
                    'Headers' =>
                        array (
                            0 =>
                                array (
                                    'url' => $elements . '/original/header10.html',
                                    'height' => 567,
                                    'thumbnail' => $elements . '/thumbs/header10.png',
                                ),
                            1 =>
                                array (
                                    'url' => $elements . '/original/header5.html',
                                    'height' => 694,
                                    'thumbnail' => $elements . '/thumbs/header5.png',
                                ),
                            2 =>
                                array (
                                    'url' => $elements . '/original/header11.html',
                                    'height' => 708,
                                    'thumbnail' => $elements . '/thumbs/header11.png',
                                ),
                            3 =>
                                array (
                                    'url' => $elements . '/original/header1.html',
                                    'height' => 481,
                                    'thumbnail' => $elements . '/thumbs/header1.png',
                                ),
                            4 =>
                                array (
                                    'url' => $elements . '/original/header6.html',
                                    'height' => 491,
                                    'thumbnail' => $elements . '/thumbs/header6.png',
                                ),
                            5 =>
                                array (
                                    'url' => $elements . '/original/header2.html',
                                    'height' => 498,
                                    'thumbnail' => $elements . '/thumbs/header2.png',
                                ),
                            6 =>
                                array (
                                    'url' => $elements . '/original/header8.html',
                                    'height' => 633,
                                    'thumbnail' => $elements . '/thumbs/header8.png',
                                ),
                            7 =>
                                array (
                                    'url' => $elements . '/original/header9.html',
                                    'height' => 633,
                                    'thumbnail' => $elements . '/thumbs/header9.png',
                                ),
                            8 =>
                                array (
                                    'url' => $elements . '/original/header3.html',
                                    'height' => 959,
                                    'thumbnail' => $elements . '/thumbs/header3.png',
                                ),
                            9 =>
                                array (
                                    'url' => $elements . '/original/header4.html',
                                    'height' => 660,
                                    'thumbnail' => $elements . '/thumbs/header4.png',
                                ),
                            10 =>
                                array (
                                    'url' => $elements . '/original/header7.html',
                                    'height' => 715,
                                    'thumbnail' => $elements . '/thumbs/header7.png',
                                ),
                        ),
                    'Content Sections' =>
                        array (
                            0 =>
                                array (
                                    'url' => $elements . '/original/content_section1.html',
                                    'height' => 481,
                                    'thumbnail' => $elements . '/thumbs/content_section1.png',
                                ),
                            1 =>
                                array (
                                    'url' => $elements . '/original/content_section2.html',
                                    'height' => 520,
                                    'thumbnail' => $elements . '/thumbs/content_section2.png',
                                ),
                            2 =>
                                array (
                                    'url' => $elements . '/original/content_section3.html',
                                    'height' => 774,
                                    'thumbnail' => $elements . '/thumbs/content_section3.png',
                                ),
                            3 =>
                                array (
                                    'url' => $elements . '/original/content_section4.html',
                                    'height' => 331,
                                    'thumbnail' => $elements . '/thumbs/content_section4.png',
                                ),
                            4 =>
                                array (
                                    'url' => $elements . '/original/content_section5.html',
                                    'height' => 846,
                                    'thumbnail' => $elements . '/thumbs/content_section5.png',
                                ),
                            5 =>
                                array (
                                    'url' => $elements . '/original/content_section6.html',
                                    'height' => 344,
                                    'thumbnail' => $elements . '/thumbs/content_section6.png',
                                ),
                            6 =>
                                array (
                                    'url' => $elements . '/original/content_section7.html',
                                    'height' => 344,
                                    'thumbnail' => $elements . '/thumbs/content_section7.png',
                                ),
                            7 =>
                                array (
                                    'url' => $elements . '/original/content_section8.html',
                                    'height' => 725,
                                    'thumbnail' => $elements . '/thumbs/content_section8.png',
                                ),
                            8 =>
                                array (
                                    'url' => $elements . '/original/content_section9.html',
                                    'height' => 567,
                                    'thumbnail' => $elements . '/thumbs/content_section9.png',
                                ),
                            9 =>
                                array (
                                    'url' => $elements . '/original/content_section10.html',
                                    'height' => 376,
                                    'thumbnail' => $elements . '/thumbs/content_section10.png',
                                ),
                            10 =>
                                array (
                                    'url' => $elements . '/original/content_section11.html',
                                    'height' => 376,
                                    'thumbnail' => $elements . '/thumbs/content_section11.png',
                                ),
                        ),
                    'Dividers' =>
                        array (
                            0 =>
                                array (
                                    'url' => $elements . '/original/divider1.html',
                                    'height' => 163,
                                    'thumbnail' => $elements . '/thumbs/divider1.png',
                                ),
                            1 =>
                                array (
                                    'url' => $elements . '/original/divider2.html',
                                    'height' => 163,
                                    'thumbnail' => $elements . '/thumbs/divider2.png',
                                ),
                            2 =>
                                array (
                                    'url' => $elements . '/original/divider3.html',
                                    'height' => 163,
                                    'thumbnail' => $elements . '/thumbs/divider3.png',
                                ),
                            3 =>
                                array (
                                    'url' => $elements . '/original/divider4.html',
                                    'height' => 183,
                                    'thumbnail' => $elements . '/thumbs/divider4.png',
                                ),
                            4 =>
                                array (
                                    'url' => $elements . '/original/divider5.html',
                                    'height' => 123,
                                    'thumbnail' => $elements . '/thumbs/divider5.png',
                                ),
                            5 =>
                                array (
                                    'url' => $elements . '/original/divider6.html',
                                    'height' => 60,
                                    'thumbnail' => $elements . '/thumbs/divider6.png',
                                ),
                            6 =>
                                array (
                                    'url' => $elements . '/original/divider7.html',
                                    'height' => 120,
                                    'thumbnail' => $elements . '/thumbs/divider7.png',
                                ),
                        ),
                    'Portfolios' =>
                        array (
                            0 =>
                                array (
                                    'url' => $elements . '/original/portfolio1.html',
                                    'height' => 701,
                                    'thumbnail' => $elements . '/thumbs/portfolio1.png',
                                ),
                            1 =>
                                array (
                                    'url' => $elements . '/original/portfolio2.html',
                                    'height' => 799,
                                    'thumbnail' => $elements . '/thumbs/portfolio2.png',
                                ),
                            2 =>
                                array (
                                    'url' => $elements . '/original/portfolio3.html',
                                    'height' => 516,
                                    'thumbnail' => $elements . '/thumbs/portfolio3.png',
                                ),
                        ),
                    'Team' =>
                        array (
                            0 =>
                                array (
                                    'url' => $elements . '/original/team1.html',
                                    'height' => 644,
                                    'thumbnail' => $elements . '/thumbs/team1.png',
                                ),
                            1 =>
                                array (
                                    'url' => $elements . '/original/team2.html',
                                    'height' => 810,
                                    'thumbnail' => $elements . '/thumbs/team2.png',
                                ),
                            2 =>
                                array (
                                    'url' => $elements . '/original/team3.html',
                                    'height' => 752,
                                    'thumbnail' => $elements . '/thumbs/team3.png',
                                ),
                        ),
                    'Pricing Tables' =>
                        array (
                            0 =>
                                array (
                                    'url' => $elements . '/original/pricing_table1.html',
                                    'height' => 628,
                                    'thumbnail' => $elements . '/thumbs/pricing_table1.png',
                                ),
                            1 =>
                                array (
                                    'url' => $elements . '/original/pricing_table2.html',
                                    'height' => 750,
                                    'thumbnail' => $elements . '/thumbs/pricing_table2.png',
                                ),
                            2 =>
                                array (
                                    'url' => $elements . '/original/pricing_table3.html',
                                    'height' => 721,
                                    'thumbnail' => $elements . '/thumbs/pricing_table3.png',
                                ),
                        ),
                    'Contact' =>
                        array (
                            0 =>
                                array (
                                    'url' => $elements . '/original/contact1.html',
                                    'height' => 691,
                                    'thumbnail' => $elements . '/thumbs/contact1.png',
                                ),
                            1 =>
                                array (
                                    'url' => $elements . '/original/contact2.html',
                                    'height' => 477,
                                    'thumbnail' => $elements . '/thumbs/contact2.png',
                                ),
                        ),
                    'Footers' =>
                        array (
                            0 =>
                                array (
                                    'url' => $elements . '/original/footer1.html',
                                    'height' => 294,
                                    'thumbnail' => $elements . '/thumbs/footer1.png',
                                ),
                            1 =>
                                array (
                                    'url' => $elements . '/original/footer2.html',
                                    'height' => 107,
                                    'thumbnail' => $elements . '/thumbs/footer2.png',
                                ),
                            2 =>
                                array (
                                    'url' => $elements . '/original/footer3.html',
                                    'height' => 260,
                                    'thumbnail' => $elements . '/thumbs/footer3.png',
                                ),
                        ),
                ),
        );

        echo json_encode($elements);
    }

    public function actionSite() {
        if(isset($_COOKIE['version']))
        {
            header('Content-type: application/json');
            echo file_get_contents(Yii::getPathOfAlias('webroot').'/plugins/builder/versions/'.$_COOKIE['version']);
        }
        else{
            $verson_files = scandir(Yii::getPathOfAlias('webroot')."/plugins/builder/versions/",SCANDIR_SORT_DESCENDING);
            if($verson_files[0] != '..' and $verson_files[0] != '.' and count($verson_files)>3)
            {
                header('Content-type: application/json');
                echo file_get_contents(Yii::getPathOfAlias('webroot').'/plugins/builder/versions/'.$verson_files[0]);
            }
            else{
                if(count($verson_files)==3)
                {
                    header('Content-type: application/json');
                    echo file_get_contents(Yii::getPathOfAlias('webroot').'/plugins/builder/site.json');
                }
            }
        }
    }


    public function actionSave(){
        $return = [];
//        $site = Yii::getPathOfAlias('webroot')."/plugins/builder/site.json";
        $stamp = time();
        $newsite = Yii::getPathOfAlias('webroot')."/plugins/builder/versions/site_".$stamp.".json";
//        echo $newsite;die;
        $mynewfile = fopen($newsite,"w");
        fwrite($mynewfile,"{}");

        if( isset($_POST['data']) && $_POST['data'] != '' ) {

            if( isset($_POST['data']['delete']) ) {

                $myfile = fopen($newsite, "w");
                fwrite($myfile, '{}');
                fclose($myfile);

            } else {

                $myfile = fopen($newsite, "w");
                fwrite($myfile, json_encode($_POST['data']));
                fclose($myfile);

            }

            $return['responseCode'] = 1;
            $return['responseHTML'] = '<h5>Hooray!</h5> <p>The site was saved successfully!</p>';

        } else {

            $return['responseCode'] = 0;
            $return['responseHTML'] = '<h5>Ouch!</h5> <p>Something went wrong and the site could not be saved :(</p>';

        }
        if(isset($_COOKIE['version']))
        {
            setcookie('version','',time()-3600);
        }
        echo json_encode($return);

    }

    public function actionPreview(){
//        echo "hii";die;
        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }


        $filename = Yii::getPathOfAlias('webroot')."/plugins/builder/elements/preview_".generateRandomString(20).".html";

        $previewFile = fopen($filename, "w");

        $pageContent = stripcslashes($_POST['page']);

        $pageContent = str_replace("../bundles/", "bundles/", $pageContent);

        fwrite($previewFile, stripcslashes($pageContent));

        fclose($previewFile);

        $name = explode("/",$filename);

        $url = Yii::app()->baseUrl.'/plugins/builder/elements/'.end($name);

        header('Location: '.$url);
    }

    public function actionExport(){

        $pathToAssets = Yii::getPathOfAlias('webroot')."/plugins/builder/elements/bundles";

        $destinationfolder = Yii::getPathOfAlias('webroot')."/plugins/builder/tmp/website/bundles";

        $this->copyfolder($pathToAssets, $destinationfolder);

    }


    protected function copyfolder($source, $destination)
    {
        $directory = scandir($source);

        //Create the copy folder location
        if(file_exists(Yii::getPathOfAlias('webroot')."/plugins/builder/tmp/website"))
        {
            if(!file_exists($destination))
                mkdir($destination);
        }
        else
        {
            mkdir(Yii::getPathOfAlias('webroot')."/plugins/builder/tmp/website");
            if(!file_exists($destination))
                mkdir($destination);
        }


        //Scan through the folder one file at a time

        foreach($directory as $file)
        {
            if($file != '.' and $file != '..'){
                copy($source.'/' .$file, $destination.'/'.$file);
            }
        }

        foreach( $_POST['pages'] as $page=>$content ) {

            $pageContent = stripslashes($content);
            $pageContent = str_replace("cursor: inherit;", " ", $pageContent);
            $pageContent = str_replace("../bundles/", "bundles/", $pageContent);
            $myfile = fopen(Yii::getPathOfAlias('webroot')."/plugins/builder/tmp/website/".$page.".html", "w") or die("Unable to open file!");
            fwrite($myfile, $pageContent);
            fclose($myfile);
        }

        // Get real path for our folder
        $rootPath = realpath(Yii::getPathOfAlias('webroot')."/plugins/builder/tmp/website");
        $zipfile = Yii::getPathOfAlias('webroot').'/plugins/builder/tmp/website.zip';

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

        $deletefolderurl = Yii::getPathOfAlias('webroot').'/plugins/builder/tmp/website';
        DeleteFolder::deleteDir($deletefolderurl);

        $url = Yii::app()->baseUrl.'/plugins/builder/tmp/website.zip';

        header('Location:'.$url);

    }

}