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
                            <?if($mb->give_regdate == '0000-00-00 00:00:00'){?>
                                <hr class="hr-line-dashed" />
                                <a href="/member/hvrex/add" class="btn btn-primary block full-width m-b-xxs"><?=get_msg($select_lang, '가입하기')?></a>
                            <?}?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
           
</div>