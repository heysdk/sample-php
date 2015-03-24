<?php

error_log("onpayment " . json_encode($_REQUEST));

$appkey = 'b379fb9529aba1aa0a1c693282ec780f';

function echoErr($info) {
    $retobj = array('ret' => 0, 'info' => $info);
    echo json_encode($retobj);
    exit();
}

function echoOK() {
    $retobj = array('ret' => 1);
    echo json_encode($retobj);
    exit();
}

if (!isset($_REQUEST['appid']) ||
    !isset($_REQUEST['orderid']) ||
    !isset($_REQUEST['extra']) ||
    !isset($_REQUEST['platform']) ||
    !isset($_REQUEST['channel']) ||
    !isset($_REQUEST['channelorderid']) ||
    !isset($_REQUEST['ts']) ||
    !isset($_REQUEST['sign'])) {

    echoErr('参数不完整！');
}

$param = array(
    'appid' => $_REQUEST['appid'],
    'orderid' => $_REQUEST['orderid'],
    'extra' => $_REQUEST['extra'],
    'platform' => $_REQUEST['platform'],
    'channel' => $_REQUEST['channel'],
    'channelorderid' => $_REQUEST['channelorderid'],
    'ts' => $_REQUEST['ts']
);

ksort($param);

$i = 0;
$signsrc = '';
ksort($param);
foreach($param as $key => $val) {
    if ($i > 0) {
        $signsrc = "$signsrc&$key=$val";
    }
    else {
        $signsrc = "$key=$val";
    }
}

$signsrc .= $appkey;
$sign = md5($signsrc);

if ($sign != $_REQUEST['sign']) {
    echoErr('sign验证失败！');
}

echoOK();