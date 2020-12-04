<?php
$select_lang = 'kr';
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?=get_msg($select_lang, '출금')?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="/"><?=get_msg($select_lang, '홈')?></a>
			</li>
			<li>
				<a><?=get_msg($select_lang, '출금')?></a>
			</li>
			<li class="active">
				<strong><?=get_msg($select_lang, '출금')?></strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row m-b-lg m-t-md">
		<div class="col-md-12">

			<div class="profile-image text-center">
				<i class="fa fa-dollar fa-5x"></i>
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
									<td><strong><?=get_msg($select_lang, '수당 총액')?> :</strong> <span
											class="font-bold text-primary"><?=number_format($bal->total_point)?> P</span></td>
									<td><strong><?=get_msg($select_lang, '총 출금 Point')?> :</strong> <?=number_format($bal->point_out,0)?>
										P</td>
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
					<h5><?=get_msg($select_lang, '출금 결과')?></h5>
				</div>
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-12">
							<form method="get" class="form-horizontal">
								<div class="form-group">
									<label class="col-lg-2 control-label"><?=get_msg($select_lang, '출금 신청')?> :</label>
									<div class="col-lg-10">
										<p class="form-control-static font-bold text-primary"><?=number_format($send_count)?> P</p>
									</div>
								</div>
								<hr class="hr-line-dashed" style="margin:10px 0" />
								<div class="form-group">
									<label class="col-lg-2 control-label"><?=get_msg($select_lang, '출금 수수료')?> :</label>
									<div class="col-lg-10">
										<p class="form-control-static font-bold text-primary"><?=number_format($send_fee)?> P</p>
									</div>
								</div>
								<hr class="hr-line-dashed" style="margin:10px 0" />
								<div class="form-group">
									<label class="col-lg-2 control-label"><?=get_msg($select_lang, '출금 지급')?> :</label>
									<div class="col-lg-10">
										<p class="form-control-static font-bold text-primary"><?=number_format($send_amount,0)?> P</p>
									</div>
								</div>
								<hr class="hr-line-solid" style="margin:15px 0" />
								<div class="form-group">
									<div class="col-lg-12 text-center">
										<a href="/office/withdraw/lists" class="btn btn-primary"><i class="fa fa-check"></i>
											<?=get_msg($select_lang, '완료')?></a>
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