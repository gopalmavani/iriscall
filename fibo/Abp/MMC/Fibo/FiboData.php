<?php

namespace Abp\MMC\Fibo;

class FiboData {

    public $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getNodesByEmail($emailAddress) {
        $sql = "SELECT id, accountNum " .
                "FROM fibo " .
                "WHERE email LIKE '$emailAddress'";
        $query = $this->db->query($sql);
        if ($query === false) {
            return false;
        }
        $nodes = [];
        // modified
        foreach ($query->fetchAll() as $row) {
            $nodes[] = [
                "id" => $row["id"],
                "accountNum" => $row["accountNum"]
            ];
        }
        return $nodes;
    }

    public function getFirstNode($accountNum, $table_name) {
        $sql = "SELECT id " .
                "FROM ". $table_name ." ".
                "WHERE cbm_account_num LIKE '$accountNum' " .
                "ORDER BY id";
        $query = $this->db->query($sql);
        if ($query === false) {
            return false;
        }
        if ($row = $query->fetch()) {
            return $row["id"];
        } else {
            return false;
        }
    }

    public function getNodeByAccountNum($accountNum) {
        $sql = "SELECT id " .
                " FROM fibo " .
                "WHERE accountNum = $accountNum";
        if ($row = $this->db->query($sql)->fetch()) {
            return $row["id"];
        } else {
            return false;
        }
    }

    public function addNode($parent, $child_type, $email, $accountNum, $table_name) {
        $sth = $this->db->prepare("INSERT INTO $table_name (email, user_id) values(?, ?)");
        $sth->execute([$email, $accountNum]);
        $id = $this->db->lastInsertId();
        if ($child_type === "L") {
            $sth = $this->db->prepare("UPDATE $table_name SET lchild=? WHERE id=?");
        } else {
            $sth = $this->db->prepare("UPDATE $table_name SET rchild=? WHERE id=?");
        }
        $sth->execute([$id, $parent]);
        return $id;
    }

    public function addCluster($parent, $child_type, $email, $accounts, $table_name) {
        if (count($accounts) === 0) {
            return [];
        }
        $curr_level = [];
        $curr_level[] = $this->addNode($parent, $child_type, $email, $accounts[0], $table_name);

        $left = true;
        $next_level = [];
        $j = 0;
        $nodes = $curr_level;
        for ($i = 1; $i < count($accounts); $i++) {
            if ($left) {
                $next_level[] = $this->addNode($curr_level[$j], "L", $email, $accounts[$i], $table_name);
                $left = false;
            } else {
                $next_level[] = $this->addNode($curr_level[$j], "R", $email, $accounts[$i], $table_name);
                $left = true;
                if (++$j >= count($curr_level)) {
                    $j = 0;
                    $curr_level = $next_level;
                    $nodes = array_merge($nodes, $curr_level);
                    $next_level = [];
                }
            }
        }
        $nodes = array_merge($nodes, $next_level);
        return $nodes;
    }

    public function findFreePos($nodeId, $table_name) {

        $level2 = $this->getNodesFromDb([$nodeId], $table_name);

        if (empty($level2)) {
            return [null, null];
        }

        if ($level2[0]["lchild"] == 0) {
            return [$nodeId, "L"];
        }

        $level1 = $this->getNodesFromDb([$level2[0]["lchild"]], $table_name);

        $order = "LR";
        $order_old = "L";
        $level = 2;

        while (true) {
            $level++;
            $nextlevel = [];
            $lc = 0;
            $rc = 0;
            foreach (str_split($order) as $child_type) {
                if ($child_type == 'L') {
                    if (!isset($level1[$lc])) {
                        return [null, null];
                    }
                    if ($level1[$lc]["lchild"] == 0) {
                        return [$level1[$lc]["id"], "L"];
                    } else {
                        $nextlevel[] = $level1[$lc]["lchild"];
                    }
                    $lc++;
                } else {
                    if (!isset($level2[$rc])) {
                        return [null, null];
                    }
                    if ($level2[$rc]["rchild"] == 0) {
                        return [$level2[$rc]["id"], "R"];
                    } else {
                        $nextlevel[] = $level2[$rc]["rchild"];
                    }
                    $rc++;
                }
            }
            $level2 = $level1;
            $level1 = $this->getNodesFromDb($nextlevel, $table_name);

            $order_temp = $order;
            $order = $order . $order_old;
            $order_old = $order_temp;
        }
    }

    private function getNodesFromDb(array $nodes, $table_name) {

        if (empty($nodes)) {
            return [];
        }

        $sql = "SELECT id, lchild, rchild " .
                "FROM ". $table_name ." ".
                " WHERE id in (" . join(", ", $nodes) . ")";

        $db_nodes = $this->db->query($sql)->fetchAll();
        usort($db_nodes, function($a, $b) use ($nodes) {
            return array_search($a["id"], $nodes) > array_search($b["id"], $nodes);
        });
        return $db_nodes;
    }

    public function removeNode($accountNum) {
        if ($this->db->exec("UPDATE fibo SET active=0 WHERE accountNum=$accountNum") === false) {
            return false;
        } else {
            return true;
        }
    }

    public function removeNodes($emailAddress) {
        if ($this->db->exec("UPDATE fibo SET active=0 WHERE email ilike '$emailAddress'") === false) {
            return false;
        } else {
            return true;
        }
    }

}
