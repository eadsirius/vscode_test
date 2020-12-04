<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2><?=get_msg($select_lang, '구매')?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="/"><?=get_msg($select_lang, '홈')?></a>
                    </li>
                    <li>
                        <a><?=get_msg($select_lang, '추가매출')?></a>
                    </li>
                    <li class="active">
                        <strong><?=get_msg($select_lang, '추가 P')?></strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row m-b">
                <div class="col-lg-3 col-md-6">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-bitcoin fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span><?=get_msg($select_lang, 'WNS Token')?></span>
                                <h2 class="font-bold"><?=number_format($bal->token,4)?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-exchange fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span><?=get_msg($select_lang, '전환포인트')?></span>
                                <h2 class="font-bold"><?=number_format($bal->point)?>P</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-history fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span><?=get_msg($select_lang, 'WNS Stakes')?></span>
                                <h2 class="font-bold"></i><?=number_format($bal->volume)?>P</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-sitemap fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span><?=get_msg($select_lang, '총 수당')?></span>
                                <h2 class="font-bold"><?=number_format($bal->total_point,4)?>P</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-b-lg m-t-md">
                <div class="col-md-12">

                    <div class="profile-image text-center">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins">
                                    <?=get_msg($select_lang, 'USNS Stakes')?>
                                </h2>
                                <table class="table m-t-md m-b-xs">
                                    <tbody>
                                        <tr>
                                            <td><strong><?=get_msg($select_lang, '누적 추가매출')?> :</strong> <span class="font-bold text-primary"><?=number_format($bal->loan)?> P</span></td>
                                            <td><strong><?=get_msg($select_lang, '누적 적립금액')?> :</strong> <?=number_format($bal->volume)?> P</td>
                                            <td><strong><?=get_msg($select_lang, '레벨')?> :</strong> <?=$bal->level?> Lv.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, '구매 결과')?></h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form method="get" class="form-horizontal">                                        
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label"><?=get_msg($select_lang, '추가매출')?> :</label>
                                            <div class="col-lg-10"><p class="form-control-static font-bold text-primary"><?=number_format($count)?> P</p></div>
                                        </div>
                                        <hr class="hr-line-dashed" style="margin:10px 0" />
                                        
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label"><?=get_msg($select_lang, '누적적립 P')?> :</label>
                                            <div class="col-lg-10"><p class="form-control-static font-bold text-primary"><?=number_format($cash,2)?> P</p></div>
                                        </div>
                                        <hr class="hr-line-solid" style="margin:15px 0" />
                                        
                                        <div class="form-group">
                                            <div class="col-lg-12 text-center">
                                                <a href="/office" class="btn btn-primary"><i class="fa fa-check"></i> <?=get_msg($select_lang, '추가매출 P 완료')?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>