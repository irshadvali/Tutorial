<?php

error_reporting(0);
set_time_limit(0);
include_once '../config.php';
$params = array_merge($_GET, $_POST);
$params = array_merge($params, $_FILES);
$action = (!empty($params['action'])) ? trim(urldecode($params['action'])) : '';

if (empty($action)) {
    $resp = array();
    $error = array('errCode' => 1, 'errMsg' => 'Please mention action');
    $result = array('results' => $resp, 'error' => $error);
    echo json_encode($result);
    exit;
}

switch ($action) {

    case 'login' :
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->login($params);
        $res = $result;
        break;
    case 'allusers':
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->allusers();
        $res = $result;
        break;
    case 'activeUsers':
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->activeUsers($params);
        $res = $result;
        break;
    case 'addUser':
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->addUser($params);
        $res = $result;
        break;
    case 'updateUser':
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->updateUser($params);
        $res = $result;
        break;

    case 'userdetails':
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->userdetails($params);
        $res = $result;
        break;
    case 'allactiveUsers':
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->allactiveUsers($params);
        $res = $result;
        break;

    case 'companyDetails':
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->companyDetails();
        $res = $result;
        break;
    case 'companyDetailsWithEmail':
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->companyDetailsWithEmail();
        $res = $result;
        break;
    
        case 'companyDetailsWithEmailAndProject':
        include APICLUDE . 'class.user.php';
        $obj = new Users($db['testdb']);
        $result = $obj->companyDetailsWithEmailAndProject();
        $res = $result;
        break;
    default:
        $resp = array();
        $error = array('errCode' => 1, 'errMsg' => 'specified action not found');
        $result = array('results' => $resp, 'error' => $error);
        break;
}
unset($obj);
echo json_encode($result);
exit;
?>





