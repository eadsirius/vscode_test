<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?=get_msg($select_lang, '출금이력')?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="/"><?=get_msg($select_lang, '홈')?></a>
			</li>
			<li>
				<a><?=get_msg($select_lang, '출금')?></a>
			</li>
			<li class="active">
				<strong><?=get_msg($select_lang, '출금내역')?></strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row m-b-lg m-t-md">
		<div class="col-md-12">

			<div class="profile-image text-center">
				<i class="fa fa-exchange fa-5x"></i>
			</div>
			<div class="profile-info">
				<div class="">
					<div>
						<h2 class="no-margins">
							<?=get_msg($select_lang, '출금 정보')?>
						</h2>
						<table class="table m-t-md m-b-xs">
							<tbody>
								<tr>
									<td><strong><?=get_msg($select_lang, '총 출금 POINT')?> :</strong> <?=number_format($sum->sp_sum,0)?> P
									</td>
									<td><strong><?=get_msg($select_lang, '총 출금 지급 POINT')?> :</strong> <?=number_format($sum->point_sum,0)?> P
									</td>
									<td><strong><?=get_msg($select_lang, '총 출금 수수료 POINT')?> :</strong>
										<?=number_format($sum->fee_sum,0)?> P</td>
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
					<h5><?=get_msg($select_lang, '출금 목록')?></h5>
				</div>
				<div class="ibox-content">

					<div class="row">
						<div class="col-lg-12">
							<div class="table-responsive">
								<table class="table table-hover table-striped m-b-xs text-center">
									<thead>
										<tr>
											<th width="20%" class="text-center"><?=get_msg($select_lang, '구분')?></th>
											<th width="" class="text-center"><?=get_msg($select_lang, '출금신청 POINT')?></th>
											<th width="10%" class="text-center"><?=get_msg($select_lang, '수수료 POINT')?></th>
											<th width="" class="text-center"><?=get_msg($select_lang, '출금지급 원화')?></th>
											<th width="20%" class="text-center"><?=get_msg($select_lang, '날짜')?></th>
										</tr>
									</thead>
									<tbody>
										<? 
											$i=0;
											foreach($item as $row) {
													$i+=1; 
													$regdate	=  date("Y-m-d",strtotime($row->regdate));
													if($row->state == '1'){
														$type = '요청중';
													}
													else{
														$type = '승인';
													}
											?>
										<tr>
											<td><?=$type?></td>
											<td><?=number_format($row->saved_point,0)?></td>
											<td><?=number_format($row->bank_fee,0)?></td>
											<td><?=number_format($row->point,0)?></td>
											<td><?=$regdate?></td>
										</tr>
										<? } ?>
										<?if($i==0){?>
										<tr>
											<td colspan="5" class="text-center" style="background-color:#fff">
												<?=get_msg($select_lang, '내역 없음')?></td>
										</tr>
										<?}?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5">
												<ul class="pagination" style="margin-top:10px">
													<?=PAGE_URL?>
												</ul>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>