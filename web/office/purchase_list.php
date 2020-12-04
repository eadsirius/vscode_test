<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-12">
				<h2><?=get_msg($select_lang, '매출 내역')?></h2>
				<ol class="breadcrumb">
					<li>
						<a href="/"><?=get_msg($select_lang, '홈')?></a>
					</li>
					<li>
						<a><?=get_msg($select_lang, '매출관리')?></a>
					</li>
					<li class="active">
						<strong><?=get_msg($select_lang, '매출 내역')?></strong>
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
											<td><strong><?=get_msg($select_lang, '매출내역 합계')?> :</strong> <?=number_format($bal->total_sales,0)?> P</td>
											<td><strong><?=get_msg($select_lang, '매출 데일리 수당 합계')?> :</strong> <?=number_format($bal->day_point,0)?> P</td>
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
							<h5><?=get_msg($select_lang, '구매 타임라인')?></h5>
						</div>
						<div class="ibox-content" id="ibox-content">
							
							<div id="vertical-timeline" class="vertical-container dark-timeline center-orientation">
							<? 
							$i=0;
							foreach($item as $row) 
							{
								$i+=1; 
								$regdate	=  date("y-m-d",strtotime($row->regdate));
								
								// 프리미엄수당 계산								
								$price_first 	= $row->msg ; // 진입시
								$price_end 		= $site->cfg_won; // 현시세
								$price_chk = 0;
								$price_today = 0;
								if($price_first > 0) $price_chk 		= $row->point * ($price_end / $price_first);
								if($price_chk > 0) 	$price_today = $price_chk / $row->point;
							
								if($price_today <= 2){
									$price_up = 0;				
								}
								else
								{
									if($price_today > $site->cfg_vip1_start or $price_today <= $site->cfg_vip1_end){
										$price_persent = $site->cfg_vip1_present;
									}
									else if($price_today > $site->cfg_vip2_start or $price_today <= $site->cfg_vip2_end){
										$price_persent = $site->cfg_vip2_present;
									}
									else if($price_today > $site->cfg_vip3_start or $price_today <= $site->cfg_vip3_end){
										$price_persent = $site->cfg_vip3_present;
									}
									else if($price_today > $site->cfg_vip4_start or $price_today <= $site->cfg_vip4_end){
										$price_persent = $site->cfg_vip4_present;
									}
									else if($price_today > $site->cfg_vip5_start or $price_today <= $site->cfg_vip5_end){
										$price_persent = $site->cfg_vip5_present;
									}
									else if($price_today > $site->cfg_vip6_start or $price_today <= $site->cfg_vip6_end){
										$price_persent = $site->cfg_vip6_present;
									}
									else if($price_today > $site->cfg_vip7_start or $price_today <= $site->cfg_vip7_end){
										$price_persent = $site->cfg_vip7_present;
									}
									else if($price_today > $site->cfg_vip8_start or $price_today <= $site->cfg_vip8_end){
										$price_persent = $site->cfg_vip8_present;
									}
									else if($price_today > $site->cfg_vip9_start){
										$price_persent = $site->cfg_vip9_present;
									}

									// $price_up = $first->point * $price_persent;
								}
								
							?>
								<div class="vertical-timeline-block">
									<div class="vertical-timeline-icon navy-bg">
										<i class="fa fa-bitcoin"></i>
									</div>
	
									<div class="vertical-timeline-content">
										<h3><?=get_msg($select_lang, 'P')?> : <?=number_format($row->point,0)?></h3>
										
										<spn class="vertical-date">
											<strong><?=date("Y-m-d H:i:s",strtotime($row->regdate." +9 hours"))?></strong><br />
											<!-- <small><?=get_msg($select_lang, '패키지')?> : <?=$row->type?>Level</small> -->
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