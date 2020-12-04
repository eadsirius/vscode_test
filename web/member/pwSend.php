<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Send Email</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h3 class="font-bold"><?=get_msg($select_lang, '메일이 발송 되었습니다.')?></h3>

        <div class="error-desc">
            <?=$email?><br><br> <?=get_msg($select_lang, '이메일을 확인하십시오.')?><br><?=get_msg($select_lang, '암호를 재설정하십시오.')?>
        </div>
    </div>

</body>

</html>