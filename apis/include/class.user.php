<?php

include_once 'common/db.class.msi.obj.php';

class Users extends DB {

    function __construct($db) {
        parent::DB($db);
    }

    public function login($params) {
        global $comm;
        $username = (!empty($params['username'])) ? trim(urldecode($params['username'])) : '';
        $password = (!empty($params['password'])) ? trim(urldecode($params['password'])) : '';
//			$isApp = (!empty($params['isApp'])) ? trim(urldecode($params['isApp'])) : '';

        $vsql = "SELECT 
                    *
                FROM
                    tbl_user_master
                WHERE
                    password=MD5(\"" . $password . "\")
                AND
                    email=\"" . $username . "\"
                AND
                    active_flag=1";
        $vres = $this->query($vsql);

        $row = $this->fetchData($vres);
        $cnt1 = $this->numRows($vres);

        if ($cnt1 > 0) {
            $arr = array('id' => $row['id'], 'fname' => $row['fname'], 'lname' => $row['lname'], 'usertype' => $row['usertype'], 'email' => $row['email']);
            $err = array('errCode' => 0, 'errMsg' => 'Login Successful');
        } else {
            $arr = array();
            $err = array('errCode' => 1, 'errMsg' => 'Invalid Username Password');
        }

        $result = array('results' => $arr, 'error' => $err);
        return $result;
    }

    public function allusers() {
        $vsql = "SELECT * FROM tbl_user_master";
        $vres = $this->query($vsql);
        //$row = $this->fetchData($vres);
        $cnt1 = $this->numRows($vres);

        if ($cnt1 > 0) {
            while ($row = $this->fetchData($vres)) {
                $arr[] = $row;
            }
            //$arr = array('id' => $row['id'], 'fname' => $row['fname'], 'lname' => $row['lname'], 'usertype' => $row['usertype'], 'email' => $row['email']);
            $err = array('errCode' => 0, 'errMsg' => 'data found successfully');
        } else {
            $arr = array();
            $err = array('errCode' => 1, 'errMsg' => 'no data found');
        }

        $result = array('results' => $arr, 'error' => $err);
        return $result;
    }

    public function activeUsers($params) {
        $actflag = (!empty($params['activeflag'])) ? trim($params['activeflag']) : '';

        $vsql = "SELECT * fROM tbl_user_master where active_flag=\"" . $actflag . "\"";

        $vres = $this->query($vsql);
        $cnt1 = $this->numRows($vres);
        if ($cnt1 > 0) {
            while ($row = $this->fetchData($vres)) {
                $arr[] = $row;
            }
            $err = array('errCode' => 0, 'errMsg' => 'data found successfully');
        } else {
            $arr = array();
            $err = array('errCode' => 1, 'errMsg' => 'no data found');
        }

        $result = array('results' => $arr, 'error' => $err);
        return $result;
    }

    public function addUser($params) {
        $actflag = (!empty($params['activeflag'])) ? trim($params['activeflag']) : '';
        $email = (!empty($params['email'])) ? trim($params['email']) : '';
        $username = (!empty($params['username'])) ? trim($params['username']) : '';
        $fname = (!empty($params['fname'])) ? trim($params['fname']) : '';
        $lname = (!empty($params['lname'])) ? trim($params['lname']) : '';
        $password = (!empty($params['password'])) ? trim($params['password']) : '';

        if (!$email) {
            $err = array('errCode' => 1, 'errMsg' => 'Email is mandatory');
            $result = array('results' => array(), 'error' => $err);
            return $result;
        }



        $vsql = "INSERT INTO 
                        tbl_user_master 
                    SET 
                        active_flag=\"" . $actflag . "\", 
                        email = '" . $email . "',
                        username = '" . $username . "',
                        fname = '" . $fname . "',
                        lname = '" . $lname . "',
                        password = MD5('" . $password . "')
                ";

        $vres = $this->query($vsql);

        $insertId = $this->lastInsertedId();

        if ($vres) {
            $arr = array('id' => strval($insertId));
            $err = array('errCode' => 0, 'errMsg' => 'data inserted successfully');
        } else {
            $arr = array();
            $err = array('errCode' => 1, 'errMsg' => 'data failed to insert');
        }

        $result = array('results' => $arr, 'error' => $err);
        return $result;
    }

    public function updateUser($params) {
        $id = (!empty($params['id'])) ? trim($params['id']) : '';
        $actflag = (!empty($params['activeflag'])) ? trim($params['activeflag']) : '';
        $email = (!empty($params['email'])) ? trim($params['email']) : '';
        $username = (!empty($params['username'])) ? trim($params['username']) : '';
        $fname = (!empty($params['fname'])) ? trim($params['fname']) : '';
        $lname = (!empty($params['lname'])) ? trim($params['lname']) : '';
        $password = (!empty($params['password'])) ? trim($params['password']) : '';
//        UPDATE tbl_user_master SET lname="hhh" WHERE id=2

        $vsql = "UPDATE 
                        tbl_user_master 
                    SET 
                        active_flag=\"" . $actflag . "\", 
                        email = '" . $email . "',
                        username = '" . $username . "',
                        fname = '" . $fname . "',
                        lname = '" . $lname . "',
                        password = MD5('" . $password . "')
                            WHERE 
                        id=\"" . $id . "\"     
                ";

        $vres = $this->query($vsql);

        $upadatuser = "SELECT * FROM tbl_user_master 
                        WHERE 
                        id=\"" . $id . "\"";
        $upadatuser = $this->query($upadatuser);
        $row = $this->fetchData($upadatuser);
        if ($vres) {
//            $arr = array();
            $arr = array('id' => $row['id'], 'fname' => $row['fname'], 'lname' => $row['lname'], 'usertype' => $row['usertype'], 'email' => $row['email']);
            $err = array('errCode' => 0, 'errMsg' => 'data update successfully');
        } else {
            $arr = array();
            $err = array('errCode' => 1, 'errMsg' => 'data failed to update');
        }

        $result = array('results' => $arr, 'error' => $err);
        return $result;
    }

    public function userdetails($params) {
        global $comm;
        $id = (!empty($params['id'])) ? trim(urldecode($params['id'])) : '';

//			SELECT * FROM `user_details` ,tbl_user_master WHERE user_details.id=1 AND tbl_user_master.id=1

        $vsql = "SELECT 
                    *
                FROM
                    tbl_user_master,user_details 
                WHERE
                    tbl_user_master.id=\"" . $id . "\"
                AND
                    user_details.id=\"" . $id . "\"";

        $vres = $this->query($vsql);
        $row = $this->fetchData($vres);
        $cnt1 = $this->numRows($vres);

        if ($cnt1 > 0) {
            $arr = array('id' => $row['id'], 'fname' => $row['fname'], 'lname' => $row['lname'],
                'usertype' => $row['usertype'], 'email' => $row['email'], 'address' => $row['address'],
                'designation' => $row['designation']);
            $err = array('errCode' => 0, 'errMsg' => 'data found successfully');
        } else {
            $arr = array();
            $err = array('errCode' => 1, 'errMsg' => 'no data found');
        }

        $result = array('results' => $arr, 'error' => $err);
        return $result;
    }

    public function allactiveUsers($params) {
        $actflag = (!empty($params['activeflag'])) ? trim($params['activeflag']) : '';

        $vsql = "SELECT * fROM tbl_user_master um,user_details ud where ud.id=um.id and  active_flag=\"" . $actflag . "\"";

        $vres = $this->query($vsql);
        $cnt1 = $this->numRows($vres);
        if ($cnt1 > 0) {
            while ($row = $this->fetchData($vres)) {
                $arr[] = $row;
            }
            $err = array('errCode' => 0, 'errMsg' => 'data found successfully');
        } else {
            $arr = array();
            $err = array('errCode' => 1, 'errMsg' => 'no data found');
        }

        $result = array('results' => $arr, 'error' => $err);
        return $result;
    }

    public function companyDetails() {
//        $actflag = (!empty($params['activeflag'])) ? trim($params['activeflag']) : '';

        $vsql = "SELECT * fROM companydetails";

        $vres = $this->query($vsql);
        $cnt1 = $this->numRows($vres);
        if ($cnt1 > 0) {
            while ($row = $this->fetchData($vres)) {
                $cid = $row['id'];
                $det = "SELECT * FROM user_details WHERE id in (SELECT Userid from companyMap WHERE companyid=$cid)";
                $vresone = $this->query($det);
                $cnt2 = $this->numRows($vresone);
                if ($cnt2 > 0) {


                    while ($row1 = $this->fetchData($vresone)) {
                        $row['users'][] = $row1;
                    }
                }

                $arr[] = $row;
            }
            $err = array('errCode' => 0, 'errMsg' => 'data found successfully');
        } else {
            $arr = array();
            $err = array('errCode' => 1, 'errMsg' => 'no data found');
        }

        $result = array('results' => $arr, 'error' => $err);
        return $result;
    }
    
    
        public function companyDetailsWithEmail() {
//        $actflag = (!empty($params['activeflag'])) ? trim($params['activeflag']) : '';

        $vsql = "SELECT * fROM companydetails";

        $vres = $this->query($vsql);
        $cnt1 = $this->numRows($vres);
        if ($cnt1 > 0) {
            while ($row = $this->fetchData($vres)) {
                $cid = $row['id'];
                $det = "SELECT * FROM user_details,tbl_user_master WHERE user_details.id = tbl_user_master.id AND tbl_user_master.id in (SELECT Userid from companyMap WHERE companyid=$cid)";
                $vresone = $this->query($det);
                $cnt2 = $this->numRows($vresone);
                if ($cnt2 > 0) {


                    while ($row1 = $this->fetchData($vresone)) {
                        $row['users'][] = $row1;
                    }
                }

                $arr[] = $row;
            }
            $err = array('errCode' => 0, 'errMsg' => 'data found successfully');
        } else {
            $arr = array();
            $err = array('errCode' => 1, 'errMsg' => 'no data found');
        }

        $result = array('results' => $arr, 'error' => $err);
        return $result;
    }

}

?>
