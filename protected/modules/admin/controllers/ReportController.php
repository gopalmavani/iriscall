<?php

class ReportController extends CController
{

    public function actionIndex(){
        $this->render('index');
    }

    public function actionDownloadinvoices(){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        if(isset($_GET['start_date'])){
            $myDateTime = DateTime::createFromFormat('F, Y', $_GET['start_date']);
            $start_month = $myDateTime->format('m');
            $start_year = $myDateTime->format('Y');
        } else {
            $start_month = date('m');
            $start_year = date('Y');
        }
        $orders = Yii::app()->db->createCommand()
            ->select('order_info_id')
            ->from('order_info')
            ->where('month(invoice_date)=:mId', [':mId'=>$start_month])
            ->andWhere('year(invoice_date)=:yId', [':yId'=>$start_year])
            ->queryColumn();

        $filePaths = [];
        foreach ($orders as $orderInfoId){
            $filePaths[] = $this->generateinvoice($orderInfoId);
        }

        $zipFileName = 'invoices_'.$start_year.'_'.$start_month.'.zip';
        $result = $this->createZipArchive($filePaths, $zipFileName);

        foreach ($filePaths as $path){
            unlink($path);
        }

        header("Content-Disposition: attachment; filename=\"".$zipFileName."\"");
        header("Content-Length: ".filesize($zipFileName));
        readfile($zipFileName);
        /*$data = [];
        foreach ($orders as $orderInfoId){
            $temp = [];
            $temp['orderInfo'] = OrderInfo::model()->findByAttributes(array('order_info_id' => $orderInfoId));
            $temp['orderLineitem'] = OrderLineItem::model()->findAllByAttributes(array('order_info_id' => $orderInfoId));
            $temp['orderPayment'] = OrderPayment::model()->findAllByAttributes(array('order_info_id' => $orderInfoId));
            $temp['userInfo'] = UserInfo::model()->findByAttributes(array('user_id' => $data['orderInfo']->user_id));
            $data[$orderInfoId] = $temp;
        }*/
    }

    /**
     * Generates pdf of view page of report.
     */
    public function generateinvoice($id)
    {
        $this->layout = 'invoice';
        $data['orderInfo'] = OrderInfo::model()->findByAttributes(array('order_info_id' => $id));
        $data['orderLineitem'] = OrderLineItem::model()->findAllByAttributes(array('order_info_id' => $id));
        $data['orderPayment'] = OrderPayment::model()->findAllByAttributes(array('order_info_id' => $id));
        $data['userInfo'] = UserInfo::model()->findByAttributes(array('user_id' => $data['orderInfo']->user_id));

        $html = $this->render('generateinvoice', array('data' => $data), true);

        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('utf-8', 'A4', 9, 'oswald');

        //$mPDF1->SetHTMLHeader('<div style="text-align: right; font-weight: bold;">Invoice - OD'.$data['orderInfo']->order_id.'</div>');

        $mPDF1->SetHTMLFooter('

        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;"><tr>
        
        <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
        
        <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
        
        <td width="33%" style="text-align: right; ">CBM Global</td>
        
        </tr></table>
        
        ');
        $mPDF1->WriteHTML($html);

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/invoiceStyle.css');

        $mPDF1->WriteHTML($stylesheet, 1);

        $filelocation = "protected/runtime/uploads/invoices/"; //Linux
        if (!is_dir($filelocation)) {
            mkdir($filelocation, 0755, true);
        }
        $filename = $data['orderInfo']->invoice_number.'-'.$data['orderInfo']->user_name.'.pdf';
        $relative_file_path = 'protected/runtime/uploads/invoices/'.$filename;
        $fileNL = getcwd() .'/'. $relative_file_path; //Linux
        # Outputs ready PDF
        $mPDF1->Output($fileNL, 'F');

        return $fileNL;
    }


    /* create a compressed zip file */
    function createZipArchive($files = array(), $destination = '', $overwrite = false) {

        if(file_exists($destination) && !$overwrite) { return false; }

        $validFiles = array();
        if(is_array($files)) {
            foreach($files as $file) {
                if(file_exists($file)) {
                    $validFiles[] = $file;
                }
            }
        }

        if(count($validFiles)) {
            $zip = new ZipArchive();
            if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) == true) {
                foreach($validFiles as $file) {
                    $zip->addFile($file, pathinfo($file, PATHINFO_BASENAME));
                }
                $zip->close();
                return file_exists($destination);
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function actionInvoice($id)
    {
        if (OrderInfo::model()->findByAttributes(array('order_info_id' => $id))){
            $data['orderInfo'] = OrderInfo::model()->findByAttributes(array('order_info_id' => $id));
            $data['orderLineitem'] = OrderLineItem::model()->findAllByAttributes(array('order_info_id' => $id));
            $data['orderPayment'] = OrderPayment::model()->findAllByAttributes(array('order_info_id' => $id));
            $data['userInfo'] = UserInfo::model()->findByAttributes(array('user_id' => $data['orderInfo']->user_id));
            $this->render('invoice', array('data' => $data));
        }else{
            $data = 0;
            $this->render('invoice', array('data' => $data));
        }
    }

    /**
     * all report list
     */
    public function actionUserReport(){
        $this->render('userReport',[]);
    }
}
