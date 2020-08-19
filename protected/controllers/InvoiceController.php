<?php

class InvoiceController extends CController
{

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
        
        <td width="33%" style="text-align: right; ">MMC Global</td>
        
        </tr></table>
        
        ');
        $mPDF1->WriteHTML($html);

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/invoiceStyle.css');

        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        //$mPDF1->WriteHTML($this->renderPartial('admin', array(), true));

        # Renders image
        //$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/CYL Logo.png'));

        # Outputs ready PDF
        $mPDF1->Output('OD'.$data['orderInfo']->order_id.'_invoice.pdf', 'I');

    }

    public function actionView($id)
    {
        $this->layout = 'invoice';
        if (OrderInfo::model()->findByAttributes(array('order_info_id' => $id))){
            $data['orderInfo'] = OrderInfo::model()->findByAttributes(array('order_info_id' => $id));
            $data['orderLineitem'] = OrderLineItem::model()->findAllByAttributes(array('order_info_id' => $id));
            $data['orderPayment'] = OrderPayment::model()->findAllByAttributes(array('order_info_id' => $id));
            $data['userInfo'] = UserInfo::model()->findByAttributes(array('user_id' => $data['orderInfo']->user_id));

            $this->render('generateinvoice', array('data' => $data));
        }else{
            $data = 0;
            $this->render('generateinvoice', array('data' => $data));
        }
    }

}
