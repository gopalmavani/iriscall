<?php

class ReportController extends CController
{

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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @param string $modelName the Name of the model to be loaded
     * @return UserInfo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $modelName)
    {
        $model = $modelName::model()->findByPk($id);
        if ($model === null) {
            ApiResponse::json(false, 404, [], "The requested page does not exist.");
            exit;
        }
        return $model;
    }

    /**
     * Generates pdf of view page of report.
     */
    public function actionGenerateinvoice($id)
    {
        $data['orderInfo'] = OrderInfo::model()->findByAttributes(array('order_info_id' => $id));
        $data['orderLineitem'] = OrderLineItem::model()->findAllByAttributes(array('order_info_id' => $id));
        $data['orderPayment'] = OrderPayment::model()->findAllByAttributes(array('order_info_id' => $id));
        $data['userInfo'] = UserInfo::model()->findByAttributes(array('user_id' => $data['orderInfo']->user_id));

        $html = $this->render('invoice', array('data' => $data), true);

        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('utf-8', 'A4', 9, 'dejavusans');

        $mPDF1->SetHTMLHeader('<div style="text-align: right; font-weight: bold;">Invoice</div>');

        $mPDF1->SetHTMLFooter('

        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;"><tr>
        
        <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
        
        <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
        
        <td width="33%" style="text-align: right; ">My document</td>
        
        </tr></table>
        
        ');
        $mPDF1->WriteHTML($html);

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/style.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        //$mPDF1->WriteHTML($this->renderPartial('admin', array(), true));

        # Renders image
        //$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/CYL Logo.png'));

        # Outputs ready PDF
        $mPDF1->Output();

        ////////////////////////////////////////////////////////////////////////////////////

        # HTML2PDF has very similar syntax
        $html2pdf = Yii::app()->ePdf->HTML2PDF();

        $html2pdf->SetHTMLHeader('<div style="text-align: right; color: #646464; font-weight: bold;">Invoice</div>');

        $html2pdf->SetHTMLFooter('
        
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #646464; font-weight: bold;"><tr>
        
        <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
        
        <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
        
        <td width="33%" style="text-align: right; ">My document</td>
        
        </tr></table>
        
        ');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/style.css');
        $html2pdf->WriteHTML($stylesheet, 1);

        $html2pdf->WriteHTML($html);
        $html2pdf->Output();

        ////////////////////////////////////////////////////////////////////////////////////

        # Example from HTML2PDF wiki: Send PDF by email
        $content_PDF = $html2pdf->Output('', EYiiPdf::OUTPUT_TO_STRING);
        require_once(dirname(__FILE__) . '/pjmail/pjmail.class.php');
        $mail = new PJmail();
        $mail->setAllFrom('webmaster@my_site.net', "My personal site");
        $mail->addrecipient('deepakvisani@gmail.com');
        $mail->addsubject("Example sending PDF");
        $mail->text = "This is an example of sending a PDF file";
        $mail->addbinattachement("my_document.pdf", $content_PDF);
        $res = $mail->sendmail();
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
