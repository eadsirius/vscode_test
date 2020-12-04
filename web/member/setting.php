<?php
$select_lang = 'kr';

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
                
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Login Password</h5>
                        </div>
                        <div class="ibox-content ibox-heading bg-danger">
                            <h3><i class="fa fa-lock"></i> **********</h3>
                            <small style="font-size:14px"><?=get_msg($select_lang, 'For login, account')?></small>
                        </div>
                        <div class="ibox-content text-center">
                            <button type="text" class="btn btn-default" onclick="location.href='/member/profile'"><?=get_msg($select_lang, '비밀번호 변경')?></button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, '핸드폰 설정')?></h5>
                        </div>
                        <div class="ibox-content ibox-heading bg-info">
                            <h3><i class="fa fa-mobile"></i> <?=$mb->mobile?></h3>
                            <small style="font-size:14px"><?=get_msg($select_lang, '로그인, 출금, 비밀번호 변경 등')?></small>
                        </div>
                        <div class="ibox-content text-center">
                            <button type="text" class="btn btn-default" data-toggle="modal" data-target="#edMobile" onclick="location.href='/member/profile'">
                                <?if($mb->mobile != ''){?>
                                    <?=get_msg($select_lang, '핸드폰 수정')?>
                                <?}else{?>
                                    <?=get_msg($select_lang, '핸드폰 등록')?>
                                <?}?>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, '이메일 설정')?></h5>
                        </div>
                        <div class="ibox-content ibox-heading bg-primary">
                            <h3><i class="fa fa-envelope-o"></i> <?=$mb->email?></h3>
                            <small style="font-size:14px"><?=get_msg($select_lang, 'For receiving notifications, prompts, etc')?></small>
                        </div>
                        <div class="ibox-content text-center">
                            <button type="text" class="btn btn-default" onclick="location.href='/member/profile'">
                            <?if($mb->email != ''){?>
                                <?=get_msg($select_lang, '이메일 수정')?>
                            <?}else{?>
                                <?=get_msg($select_lang, '이메일 등록')?>
                            <?}?>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, 'Google Authenticator')?></h5>
                        </div>
                        <div class="ibox-content ibox-heading bg-success">
                            <h3><i class="fa fa-google-plus"></i> <?=get_msg($select_lang, '보안 절차')?></h3>
                            <small style="font-size:14px"><?=get_msg($select_lang, '로그인, 출금, 비밀번호 변경 등')?></small>
                        </div>
                        <div class="ibox-content text-center">
                            <button type="text" class="btn btn-default" onclick="location.href='/member/profile/auth'"><?=get_msg($select_lang, '보안 절차')?></button>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>