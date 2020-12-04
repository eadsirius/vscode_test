<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XMINING | BTC Consulting</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="/js/common.js?<?=today()?>"></script>
    <script src="/js/lang_<?=$select_lang?>.js?<?=today()?>"></script>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper" class="gray-bg dashbard-1" style="margin:0px;">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row m-b-lg m-t-md">
                <div class="col-md-12">
                    <div class="profile-image text-center">
                        <i class="fa fa-refresh fa-5x"></i>
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h1 class="m-t-xs">
                                    <?=get_msg($select_lang, '비밀번호 재설정')?>
                                </h1>
                                <p class="m-t-sm m-b-xs">
                                    <?=get_msg($select_lang, '비밀번호 재설정을 요청하려면 이메일 주소를 입력하십시오.')?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <form name="reg_form" action="<?=current_url()?>" method="post" onsubmit="return formCheck(this);" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=get_msg($select_lang, '새 비밀번호')?> :</label>
                                    <div class="col-lg-9"><input type="password" id="new_password" name="new_password" class="form-control" /></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label"><?=get_msg($select_lang, '비밀번호 확인')?> :</label>
                                    <div class="col-lg-9"><input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" /></div>
                                </div>
                                <hr class="hr-line-dashed" style="margin:15px 0" />
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger block full-width"><?=get_msg($select_lang, '암호 생성')?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

</body>

</html>