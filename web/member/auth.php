<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2><?=get_msg($select_lang, '보안 설정')?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="/"><?=get_msg($select_lang, '홈')?></a>
                    </li>
                    <li>
                        <a><?=get_msg($select_lang, '프로필')?></a>
                    </li>
                    <li class="active">
                        <strong><?=get_msg($select_lang, '보안 설정')?></strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            
            <div class="row animated fadeInRight">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2><?=get_msg($select_lang, '회원 기본 정보')?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal xm">
                                        <dt><?=get_msg($select_lang, '회원 ID')?> :</dt> <dd class="text-primary"><?=$this->session->userdata('member_id')?></dd>
                                        <dt><?=get_msg($select_lang, '이름')?> :</dt> <dd><?=$mb->name?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, 'OTP 인증')?></h5>
                        </div>
                        <div class="ibox-content">
                            <div class="well">
                                <h3>
									<?=get_msg($select_lang, '이 기능은 아이폰 OS와 안드로이드 스마트폰 기기에서 지원됩니다.')?>
                                </h3>
								<?=get_msg($select_lang, '먼저 스마트폰 (Android, iOS) App 프로그램을 설치해야합니다.')?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <ol>
                                        <li class="m-b-sm" style="font-size:15px; line-height:1.6em">
                                            <?=get_msg($select_lang, 'PlayStore(Android) 또는 AppStore(iPhone)에서 Google Authenticator 앱을 다운로드하여 설치하십시오.')?>
                                        </li>
                                        <li class="m-b-sm" style="font-size:15px; line-height:1.6em">
                                            <?=get_msg($select_lang, '스마트폰의 시간 업데이트가 자동으로 작동하지 않으면 구글 인증 앱이 정확한 코드를 생성하지 못하므로 아래 이미지를 확인하여 정확한지 확인하십시오.')?><br />
                                            <br />
                                            <ul>
                                                <li class="m-b-sm">
                                                    <strong><?=get_msg($select_lang, 'IOS : 설정 -> 일반- 날짜/시간')?></strong><br />
                                                    <img class="m-t" src="/assets/img/otp_img01.jpg" />
                                                </li>
                                                <li class="m-b-sm">
                                                    <strong><?=get_msg($select_lang, '안드로이드 : 설정 ->일반- 날짜/시간')?></strong><br />
                                                    <img class="m-t" src="/assets/img/otp_img02.jpg" />
                                                </li>
                                            </ul>
                                        </li>
<?php if($mb->is_auth > 0) {?>
                                        <li class="m-b-sm" style="font-size:15px; line-height:1.6em">
											<form name="reg_form" action="<?=current_url()?>" method="post" onsubmit="return formCheck();">				
												<div class="mainText"><?=get_msg($select_lang, 'OTP 인증을 사용하세요.')?></div>					
												<input type="hidden" name="dataType" value="json"/>					
												<div class="input-group">						
													<input type="password" name="confirm" value="" autocomplete="off" placeholder="<?=get_msg($select_lang, '비밀번호를 입력하세요')?>" maxlength="40" class="form-control"/>						
													<span class="input-group-btn"><button type="submit" class="btn btn-danger"><?=get_msg($select_lang, 'OTP 삭제')?></button></span>					
												</div>				
											</form>
                                        </li>
<?php } else {?>
                                        <li class="m-b-sm" style="font-size:15px; line-height:1.6em">
                                            <?=get_msg($select_lang, 'Google Authenticator 설치가 완료 되었으면 다음 단계로 이동합니다.')?>
                                        </li>
<?php }?>
                                    </ol>
<?php if($mb->is_auth > 0) {?>
<?php } else {?>
                                    <hr class="hr-line-solid m-t-md" />
                                    <button class="btn btn-primary"  onclick="location.href='/member/profile/authReg'"><i class="fa fa-arrow-right"></i> Next Step</button>
<?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<script>
function formCheck() 
{	
	var f = document.reg_form;

    if (f.confirm.value == "") {
        alert("Input Login password! ");
        f.confirm.focus();
        return false;
    }
}
</script>