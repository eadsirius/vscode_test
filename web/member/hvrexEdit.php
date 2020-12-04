<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><?=get_msg($select_lang, '사용자 정보')?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="/"><?=get_msg($select_lang, '홈')?></a>
            </li>
            <li>
                <a><?=get_msg($select_lang, '프로필')?></a>
            </li>
            <li class="active">
                <strong><?=get_msg($select_lang, '헤븐렉스 정보')?></strong>
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
                                <h2><?=get_msg($select_lang, '헤븐렉스 가입정보')?></h2>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <dl class="dl-horizontal xm">
                                <dt><?=get_msg($select_lang, '회원 ID')?> :</dt> <dd class="text-primary"><?=$this->session->userdata('member_id')?></dd>
                                <dt><?=get_msg($select_lang, '이름')?> :</dt> <dd><?=$mb->name?></dd>
								<hr class="hr-line-dashed" />
                                <dt><?=get_msg($select_lang, '헤븐렉스 추천코드')?> :</dt> <dd class="text-danger"><?=$site->cfg_admin?></dd>
                                <dt><?=get_msg($select_lang, '헤븐렉스 계정ID')?> :</dt> <dd><?=$mb->bank_code?></dd>
                                <dt><?=get_msg($select_lang, '헤븐렉스 가입날짜')?> :</dt> <dd><?=$mb->give_regdate?></dd>
                            </dl>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
	    
	    <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
	                <h5><?=get_msg($select_lang, '헤븐렉스 등록하기')?></h5>
                </div>
                <div class="ibox-content">
	                <form id="reg_form2" name="reg_form2" action="/member/hvrex/add" method="post" class="form-horizontal">
		                <div class="form-group">
                            <label class="col-lg-3 control-label"><?=get_msg($select_lang, '헤븐렉스 계정ID')?> :</label>
                            <div class="col-lg-9"><input type="text" id="hvrex_id" name="hvrex_id" class="form-control" required /></div>
                        </div>
                        <hr class="hr-line-dashed" style="margin:10px 0" />
		                <div class="form-group">
                            <label class="col-lg-3 control-label"><?=get_msg($select_lang, '헤븐렉스 가입날짜')?> :</label>
                            <div class="col-lg-9"><input type="text" id="give_regdate" name="give_regdate" class="form-control" required /></div>
                        </div>
                        <hr class="hr-line-dashed" style="margin:10px 0" />
                        
                        <button type="submit" class="btn btn-danger block full-width m-b-xxs" id='btn_submit2'><?=get_msg($select_lang, '가입하기')?></button>
                    </form>
                </div>
            </div>
        </div>
        
	    <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
	                <h5><?=get_msg($select_lang, '헤븐렉스 등록안내')?></h5>
                </div>
                <div class="ibox-content">
		                <div class="form-group">
                            <label class="col-lg-12 control-label"><?=get_msg($select_lang, '1. 헤븐렉스에 먼저 헤븐렉스 추천코드를 입력하여 회원가입을 합니다.')?></label>
                        </div>
                        <hr class="hr-line-dashed" style="margin:10px 0" />
		                <div class="form-group">
                            <label class="col-lg-12 control-label"><?=get_msg($select_lang, '2. 헤븐렉스에 가입하신 계정아이디 및 가입날짜를 Keyfin.net에서 입력하세요')?></label>
                        </div>
                        <hr class="hr-line-dashed" style="margin:10px 0" />
		                <div class="form-group">
                            <label class="col-lg-12 control-label"><?=get_msg($select_lang, '3. 헤븐렉스 가입하신 계정아이디를 입력하지 않으시면 헤븐렉스 관련 수당이 발생하지 않습니다.')?></label>
                        </div>
                        <hr class="hr-line-dashed" style="margin:10px 0" />
                </div>
            </div>
        </div>
    </div>
           
</div>