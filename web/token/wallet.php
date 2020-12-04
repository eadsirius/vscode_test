<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2><?=get_msg($select_lang, '출금 지갑 주소')?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="/"><?=get_msg($select_lang, '홈')?></a>
                    </li>
                    <li>
                        <a><?=get_msg($select_lang, '내지갑')?></a>
                    </li>
                    <li class="active">
                        <strong><?=get_msg($select_lang, '출금 WNS 주소')?></strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            
            <div class="row">
                <!-- <div class="col-lg-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h2>QRCODE</h2>
                            <div class="row text-center">
                                <img src="/data/member/<?=$mb->member_id?>.png" class="img-flex" width="100%" height="auto" alt="" style="max-width:420px;" />
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, '출금지갑 정보')?></h5>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?=get_msg($select_lang, '회원 ID')?> :</label>
                                    <div class="col-lg-10"><p class="form-control-static font-bold text-primary"><?=$mb->member_id?></p></div>
                                </div>
                                <hr class="hr-line-dashed" style="margin:10px 0" />
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"><?=get_msg($select_lang, '지갑 주소')?> :</label>
                                    <div class="col-lg-10"><p class="form-control-static"><span id="addr"><?=$wallet?></span></p></div>
                                </div>
                                <hr class="hr-line-dashed" />
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="/token/coinregister/edit" class="btn btn-white"><i class="fa fa-pencil"></i> <?=get_msg($select_lang, '주소 수정')?></a>
                                        <a href="#" class="btn btn-primary" onclick="copyToClipboard('#addr');return;"><i class="fa fa-copy"></i> <?=get_msg($select_lang, '주소 복사')?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


<script>
function copyToClipboard(element) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($(element).text()).select();
	document.execCommand("copy");
	$temp.remove();
	alert("Copied Wallet Address"); 
	//Optional Alert, 삭제해도 됨
}
</script>