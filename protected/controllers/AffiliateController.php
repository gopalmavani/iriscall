<?php

class AffiliateController extends Controller
{
    public $layout = 'main';
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    protected function beforeAction($action)
    {
        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('home/login'));
        }
        return parent::beforeAction($action);
    }

    /**
     * Software Sales affiliate details
     */
    public function actionSoftwaresales()
    {
        setlocale(LC_MONETARY, 'nl_NL.UTF-8');
        $user = UserInfo::model()->findByPk(Yii::app()->user->getId());

        //Level One and two child count
        $levelOneChild = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('user_info')
            ->where('sponsor_id=:sId', [':sId'=>$user->user_id])
            ->queryColumn();
        $levelOneChildCount = count($levelOneChild);
        $levelTwoChild = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('user_info')
            ->where(['in', 'sponsor_id', $levelOneChild])
            ->queryColumn();
        $levelTwoChildCount = count($levelTwoChild);

        $levelOneLicenseCount = Yii::app()->db->createCommand()
            ->select('sum(total_licenses) as total')
            ->from('cbm_user_licenses')
            ->where(['in', 'user_id', $levelOneChild])
            ->queryRow();
        $levelTwoLicenseCount = Yii::app()->db->createCommand()
            ->select('sum(total_licenses) as total')
            ->from('cbm_user_licenses')
            ->where(['in', 'user_id', $levelTwoChild])
            ->queryRow();

        $affiliateEarnings = WalletHelper::getAffiliateWalletEarnings($user->user_id);

        $levelOneChilds = UserInfo::model()->findAllByAttributes(['sponsor_id'=>$user->user_id]);

        $finalArr = array();

        $firstTierClients = 0;
        $firstTierLicenses = 0;
        $secondTierClients = 0;
        $secondTierLicenses = 0;
        foreach ($levelOneChilds as $levelOneChild){
            $firstTierClients++;
            $temp = [];
            if($levelOneChild->privacy_disclosure == 0){
                $temp['name'] = $levelOneChild->full_name;
                $temp['email'] = $levelOneChild->email;
            } else {
                $temp['name'] = ServiceHelper::hideStringGenealogy($levelOneChild->user_id);
                $temp['email'] = ServiceHelper::hideEmailGenealogy($levelOneChild->user_id);
            }
            $levelOneUserLicenses = CbmUserLicenses::model()->findByAttributes(['email'=>$levelOneChild->email]);
            if(isset($levelOneUserLicenses->email)){
                $temp['license_count'] = $levelOneUserLicenses->total_licenses;
                $temp['active_license_count'] = $levelOneUserLicenses->total_licenses - $levelOneUserLicenses->available_licenses;
            }
            else {
                $temp['license_count'] = 0;
                $temp['active_license_count'] = 0;
            }
            $firstTierLicenses += $temp['license_count'];

            $levelTwoChilds = UserInfo::model()->findAllByAttributes(['sponsor_id'=>$levelOneChild->user_id]);
            $levelOneClientCount = 0;
            $levelTwo = array();
            foreach ($levelTwoChilds as $levelTwoChild){
                $secondTierClients++;
                $temp2 = [];
                $levelOneClientCount++;
                if($levelTwoChild->privacy_disclosure == 0){
                    $temp2['name'] = $levelTwoChild->full_name;
                } else {
                    $temp2['name'] = ServiceHelper::hideStringGenealogy($levelTwoChild->user_id);
                }
                $levelTwoUserLicenses = CbmUserLicenses::model()->findByAttributes(['email'=>$levelTwoChild->email]);
                if(isset($levelTwoUserLicenses->email)){
                    $temp2['license_count'] = $levelTwoUserLicenses->total_licenses;
                    $temp2['active_license_count'] = $levelTwoUserLicenses->total_licenses - $levelTwoUserLicenses->available_licenses;
                } else{
                    $temp2['license_count'] = 0;
                    $temp2['active_license_count'] = 0;
                }
                $secondTierLicenses += $temp2['license_count'];
                $countQuery = Yii::app()->db->createCommand()
                    ->select('count(*) as cnt')
                    ->from('user_info')
                    ->where('sponsor_id=:sId',[':sId'=>$levelTwoChild->user_id])
                    ->queryRow();
                $temp2['client_count'] = $countQuery['cnt'];
                array_push($levelTwo, $temp2);
            }
            $temp['inner_level'] = $levelTwo;
            $temp['client_count'] = $levelOneClientCount;
            array_push($finalArr, $temp);
        }

        $this->render('softwareSales', [
            'levelOneChildCount' => $levelOneChildCount,
            'levelTwoChildCount' => $levelTwoChildCount,
            'levelOneChildLicenseCount' => $levelOneLicenseCount['total'],
            'levelTwoChildLicenseCount' => $levelTwoLicenseCount['total'],
            'affiliateEarnings' => $affiliateEarnings,
            'finalArr' => $finalArr
        ]);
    }

    /*
     * Promotion tools
     * */
    public function actionPromotiontools(){
        $userId = Yii::app()->user->getId();
        $this->render('promotionTools', [
            'userId' => $userId
        ]);
    }
}
