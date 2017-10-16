<?php

    date_default_timezone_set('Asia/Calcutta');

    if ($_SERVER['HTTPS']) {
        $httpReq = 'https://';
    } else {
        $httpReq = 'http://';
    }

    define('WEBROOT', $_SERVER['DOCUMENT_ROOT'].'/Tutorial/');
    define('DOMAIN', $httpReq . $_SERVER['HTTP_HOST']);
    define('INCLUDES', $_SERVER['DOCUMENT_ROOT'] . '/Tutorial/');
    define('APIDOMAIN', $httpReq . $_SERVER['HTTP_HOST'] . 'apis/');
    define('APICLUDE', WEBROOT . 'apis/include/');
    define('MAPKEY', '');



    $db['testdb'] = array('localhost', 'root', '', 'basic_sample_db');


    include APICLUDE . 'class.common.php';

    $comm = new Common();
    $comm->clearParam($_GET);
    $comm->clearParam($_POST, 1);
?>
