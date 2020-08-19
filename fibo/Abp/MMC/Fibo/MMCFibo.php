<?php

namespace Abp\MMC\Fibo;

class MMCFibo {

    public $fiboData;

    public function __construct($db) {
        $this->fiboData = new FiboData($db);
    }

    public function getNodes($emailAddress) {
        return $this->fiboData->getNodesByEmail($emailAddress);
    }

    public function getNode($accountNum) {
        return $this->fiboData->getNodeByAccountNum($accountNum);
    }

    public function addNodes($refParentAccountNum, $numberOfAccounts, $accountNumArray, $isCluster, $emailAddress, $table_name) {
        /*$userRoot = $this->fiboData->getFirstNode($emailAddress, $table_name);
        if ($userRoot === false) {
            $parentNode = $this->fiboData->getFirstNode($refParentEmailAddress, $table_name);
            if ($parentNode === false) {
                return false;
            }
        } else {
            $parentNode = $userRoot;
        }*/
        $parentNode = $this->fiboData->getFirstNode($refParentAccountNum, $table_name);

        $nodes = [];

        if (count($accountNumArray) < 1) {
            return false;
        }

        if ($isCluster) {
            $nodes = $this->addCluster($parentNode, $emailAddress, $accountNumArray, $table_name);
        } else {
            for ($i = 0; $i < count($accountNumArray); $i++) {
                $nodes[] = $this->addNode($parentNode, $emailAddress, $accountNumArray[$i], $table_name);
            }
        }
        return $nodes;
    }

    private function addCluster($parent, $email, $accountNumArray, $table_name) {
        list($directParent, $child_type) = $this->fiboData->findFreePos($parent, $table_name);
        if ($directParent !== null) {
            return $this->fiboData->addCluster($directParent, $child_type, $email, $accountNumArray, $table_name);
        } else {
            return [];
        }
    }

    private function addNode($parent, $email, $accountNum, $table_name) {
        list($directParent, $child_type) = $this->fiboData->findFreePos($parent, $table_name);
        if ($directParent !== null) {
            return $this->fiboData->addNode($directParent, $child_type, $email, $accountNum, $table_name);
        } else {
            return false;
        }
    }

    public function removeNode($accountNum) {
        return $this->fiboData->removeNode($accountNum);
    }

    public function removeNodes($emailAddress) {
        return $this->fiboData->removeNodes($emailAddress);
    }

}
