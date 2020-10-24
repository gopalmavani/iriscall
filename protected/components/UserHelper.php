<?php
class UserHelper extends CApplicationComponent{

    public static function performLogout(){
        $userId = Yii::app()->user->id;
        $user = UserInfo::model()->findByPk($userId);
        $user->api_token = null;
        $user->update('false');

        Yii::app()->user->logout();
    }

    public static function deleteFiles($target){
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                UserHelper::deleteFiles($file);
            }

            //To delete directory of user id only
            if(is_numeric($target))
                rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }

    public static function uploadFiles($user_id, $files)
    {
        $uploadDir = 'protected/runtime/uploads/' . $user_id . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        if (isset($files['passport']['name'])) {
            $uploadFile = $uploadDir . basename($files['passport']['name']);
            $documentId = 1;
            UserHelper::deleteDocumentIfPresent($user_id, $documentId);
            if (move_uploaded_file($files['passport']['tmp_name'], $uploadFile)) {
                $documentPath = $uploadDir . $files['passport']['name'];
                UserHelper::addDocumentPathToDB($user_id, $documentId, $documentPath);
            }
        }
        if (isset($files['sepa']['name'])) {
            $uploadFile = $uploadDir . basename($files['sepa']['name']);
            $documentId = 2;
            UserHelper::deleteDocumentIfPresent($user_id, $documentId);
            if (move_uploaded_file($files['sepa']['tmp_name'], $uploadFile)) {
                $documentPath = $uploadDir . $files['sepa']['name'];
                UserHelper::addDocumentPathToDB($user_id, $documentId, $documentPath);
            }
        }
        if (isset($files['articles_of_association']['name'])) {
            $uploadFile = $uploadDir . basename($files['articles_of_association']['name']);
            $documentId = 3;
            UserHelper::deleteDocumentIfPresent($user_id, $documentId);
            if (move_uploaded_file($files['articles_of_association']['tmp_name'], $uploadFile)) {
                $documentPath = $uploadDir . $files['articles_of_association']['name'];
                UserHelper::addDocumentPathToDB($user_id, $documentId, $documentPath);
            }
        }
    }

    public static function deleteDocumentIfPresent($userId, $documentId){
        $documents = TelecomUserDocuments::model()->findAllByAttributes(['user_id' => $userId, 'document_id' => $documentId]);
        foreach ($documents as $document){
            UserHelper::deleteFiles($document->document_path);
            $document->delete();
        }
    }

    public static function addDocumentPathToDB($userId, $documentId, $documentPath)
    {
        $document = new TelecomUserDocuments();
        $document->user_id = $userId;
        $document->document_id = $documentId;
        $document->document_path = $documentPath;
        $document->save(false);
    }
}
?>