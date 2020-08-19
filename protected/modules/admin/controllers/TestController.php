<?php

class TestController extends CController
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

    public function actionIndex(){

        $testCases = TestCaseHelper::performTestCases();
        $this->render('index', [
            'testCases' => $testCases
        ]);
    }
}