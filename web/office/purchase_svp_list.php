<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2><?=get_msg($select_lang, '구매 내역')?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="/"><?=get_msg($select_lang, '홈')?></a>
                    </li>
                    <li>
                        <a><?=get_msg($select_lang, 'P 추가매출')?></a>
                    </li>
                    <li class="active">
                        <strong><?=get_msg($select_lang, 'P 추가매출 내역')?></strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            
            <div class="row m-b-lg m-t-md">
                <div class="col-md-12">

                    <div class="profile-image text-center">
                        <i class="fa fa-money fa-5x"></i>
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins">
                                    <?=get_msg($select_lang, '구매 정보')?> <span style="font-size: 18px;">(총 구매 수 : <?=$total->cnt?> 개)</span>
                                </h2>
                                <table class="table m-t-md m-b-xs">
                                    <tbody>
                                        <tr>
                                            <td><strong><?=get_msg($select_lang, '재매출 합계')?> :</strong> <?=number_format($total->point)?> P</td>
                                            <td><strong><?=get_msg($select_lang, '재매출 데일리 수당 합계')?> :</strong> <?=number_format($bal->su_day2)?> P</td>
                                            <td><strong><?=get_msg($select_lang, '현재 Staking중인 재매출 합계')?> :</strong> <?=number_format($bal->volume2)?> P</td>
                                            <!-- 재매출 복리 수당 없으면 표시 안함 -->
                                            <?php if($bal->adjust_repurchase != 0) {?>
                                                <td><strong><?=get_msg($select_lang, '복리계산 재매출 수당')?> :</strong> <?=number_format($bal->adjust_repurchase)?> P</td>
                                            <?php } ?>
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
                            <h5><?=get_msg($select_lang, 'P 추가매출 타임라인')?></h5>
                        </div>
                        <div class="ibox-content" id="ibox-content">
                            
                            <div id="vertical-timeline" class="vertical-container dark-timeline center-orientation">
							<? 
                            $i=0;
							foreach($list as $row) {
								$i+=1; 
								$regdate	=  date("y-m-d",strtotime($row->regdate));
							?>
                                <div class="vertical-timeline-block">
                                    <div class="vertical-timeline-icon navy-bg">
                                        <i class="fa fa-bitcoin"></i>
                                    </div>
    
                                    <div class="vertical-timeline-content">
                                        <h3><?=get_msg($select_lang, 'P')?> : <?=number_format($row->point)?></h3>
                                        <spn class="vertical-date">
                                            <strong><?=$row->regdate?></strong><br />
                                            <strong>방출일 : <?=substr(date('Y-m-d' , strtotime($row->appdate.'1 days') ) , 0, 10)  ?></strong><br />
                                        </spn>
                                    </div>
                                </div>
							<?}?>
                                
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>