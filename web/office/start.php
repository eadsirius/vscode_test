<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$select_lang = 'kr';
?>
<style>
	p,
	span {
		font-size: 16px;
	}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?=get_msg($select_lang, '대시보드')?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="/"><?=get_msg($select_lang, '홈')?></a>
			</li>
			<li>
				<a><?=get_msg($select_lang, '메인')?></a>
			</li>
			<li class="active">
				<strong><?=get_msg($select_lang, '대시보드')?></strong>
			</li>
		</ol>
	</div>
</div>
<div class="row alert-success dashboard-header border-bottom">
	<!-- <i class="fa fa-exclamation-circle"></i> <?=get_msg($select_lang, '거래소에서 WNS Token을 회원님의 WPC토큰 전자지갑주소로 보내신 경우
	            <br> 매 시간 30분마다 입금된 수량을 파악하여 자동으로 포인트로 전환처리 합니다.')?> -->
	<p>ID : <?=@$this->session->userdata('member_id')?> | NAME : <?=@$mb->name?></p>
	<p>지급율은 총포인트 ÷ (Active 매출 X 2) X 100 입니다. </p>
	<!-- <p>300% 달성 후에는 수당 지급 안됨. 추가 매출을 하면 다시 수당이 발생함. </p> -->
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row m-b">
		<!-- <div class="col-lg-3 col-md-6">
			<div class="widget style1 blue-bg">
				<div class="row">
					<div class="col-xs-12 text-center">
						<span>본인투자금</span>
					</div>
					<div class="col-xs-12 text-right">
						<h3 class="font-bold" style="font-size:20px;">$ <?=number_format($investment->dollar_amt)?></h3>
						<p>&nbsp;</p>
					</div>
				</div>
			</div>
		</div> -->

		<div class="col-lg-3 col-md-6">
			<div class="widget style1" style="background: #23d25d; color:white;">
				<div class="row">
					<div class="col-xs-12 text-center">
						<span>Active 매출</span>
					</div>
					<div class="col-xs-12 text-right">
						<h3 class="font-bold" style="font-size:20px;"><?=number_format($total_balance->active_point)?> P</h3>
						<p><?=number_format($total_balance->active_point * 10) ?>원</p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-6">
			<div class="widget style1 lazur-bg">
				<div class="row">
					<div class="col-xs-12 text-center">
						<span><i style="font-size: 10px;font-style:normal;"></i>총포인트 (지급율)</span>
					</div>
					<div class="col-xs-12 text-right">
						<h3 class="font-bold" style="font-size:20px; ">
							<?=number_format($total_balance->active_total_point)?> P (<?=$total_percent?>%)</h3>
						<p><?=number_format($total_balance->active_total_point*10 )?>원 (<?=$total_percent?>%)</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="widget style1 red-bg">
				<div class="row">
					<div class="col-xs-12 text-center">
						<span>데일리 수당</span>
					</div>
					<div class="col-xs-12 text-right">
						<h3 class="font-bold" style="font-size:20px;"><?=number_format($total_balance->active_daily_point)?> P</h3>
						<p><?=number_format($total_balance->active_daily_point * 10)?>원 (<?=$daily_percent?>%)</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="widget style1" style="background: #343A40; color: #ffffff;">
				<div class="row">
					<div class="col-xs-12 text-center">
						<span>추천매칭 수당</span>
					</div>
					<div class="col-xs-12 text-right">
						<h3 class="font-bold" style="font-size:20px;"><?=number_format($total_balance->active_mc_point)?> P</h3>
						<p><?=number_format($total_balance->active_mc_point * 10)?>원 (<?=$mc_percent?>%)</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6" >
			<div class="widget style1" style="background: #ffbc00; color: #fff;">
				<div class="row">
					<div class="col-xs-12 text-center">
						<span>공유 수당</span>
					</div>
						<div class="col-xs-12 text-right">
							<h3 class="font-bold" style="font-size:20px;"><?=number_format($total_balance->active_re_point)?> P</h3>
						<p><?=number_format($total_balance->active_re_point * 10)?>원 (<?=$re_percent?>%)</p>
						</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6" >
			<div class="widget style1" style="background: #467FFA; color: #fff;">
				<div class="row">
					<div class="col-xs-12 text-center">
						<span>현재 포인트</span>
					</div>
						<div class="col-xs-12 text-right">
							<h3 class="font-bold" style="font-size:20px;"><?=number_format($total_balance->total_point)?> P</h3>
						<p>출금신청 포인트 (<?=number_format($total_balance->withdraw_point)?>P)</p>
						</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6" style="margin:0; padding:0">

			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<div class="pull-right">
							<button class="btn btn-primary btn-xs" title=""
								onclick="location.href='/office/purchase/lists'"><?=get_msg($select_lang, '더보기')?></button>
						</div>
						<h5><?=get_msg($select_lang, '총 매출')?></h5>
					</div>
					<div class="ibox-content">
						<h3><?=number_format($total_balance->total_sales)?> P</h3>
						<h3>&#8361 <?=number_format($total_balance->total_sales*10)?> 원</h3>
					</div>
				</div>
			</div>



			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><?=get_msg($select_lang, '총 출금')?></h5>
					</div>
					<div class="ibox-content">
						<h3><?=number_format(abs($total_balance->total_out_point))?> P</h3>
					</div>
				</div>
			</div>

		</div>

		<div class="col-lg-6" style="margin:0; padding:0">


			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><?=get_msg($select_lang, '시세')?></h5>
					</div>
					<div class="ibox-content">
						<h3>1 WNS = <?=number_format($USNS_WON,0)?> 원</h3>
						<h3>1 Point = <?=number_format($POINT_WON,0)?> 원</h3>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><?=get_msg($select_lang, '추천인')?></h5>
					</div>
					<div class="ibox-content">
						<div class="pull-right">
							<button class="btn btn-circle btn-sm" type="button"
								style="margin-left:0; background-color:#CDCDCD; border:4px solid #FFFFFF">&nbsp;</button>
							<button class="btn black-bg btn-circle btn-sm" type="button"
								style="margin-left:-15px; background-color:#CDCDCD; border:4px solid #FFFFFF">&nbsp;</button>
							<button class="btn black-bg btn-circle btn-sm" type="button"
								style="margin-left:-15px; background-color:#CDCDCD; border:4px solid #FFFFFF">&nbsp;</button>
							<button class="btn black-bg btn-circle btn-sm" type="button"
								style="margin-left:-15px; background-color:#CDCDCD; border:4px solid #FFFFFF">&nbsp;</button>
							<button class="btn btn-success btn-circle btn-sm" type="button"
								style="margin-left:-15px; padding-top:3px;  border:4px solid #FFFFFF">+<?=$Recnt?></button>
						</div>
						<h3><?=get_msg($select_lang, '추천 수')?> +<?=$Recnt?></h3>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><?=get_msg($select_lang, '추천 코드 주소')?></h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="form-group">
								<label class="col-lg-2 control-label h5 text-right"><?=get_msg($select_lang, '추천코드')?></label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="text" class="form-control" id='left'
											value="http://winners.web-wallet.info/member/referral/<?=$this->session->userdata('member_id')?>"
											readonly />
										<span class="input-group-btn"> <button type="button" class="btn btn-info"
												onclick="copyToClipboard('#left')"><?=get_msg($select_lang, '추천 코드 복사')?></button> </span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>




	<script>
		function copyToClipboard(element) {
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val($(element).val()).select();
			document.execCommand("copy");
			$temp.remove();
			alert("추천코드 주소가 복사 되었습니다.");
			//Optional Alert, 삭제해도 됨
		}
	</script>

</div>
<!-- <div class="notic_popup" style="height:560px">
<div class="np_inner">
	<div class="np_tp">
		<img src="/assets/img/logo.png" alt="">
		<h3>공지사항</h3>
	</div>
	<div class="np_co" style="overflow-y: scroll; ">
		<table>
			<tbody>
				<tr>
					<td>
						<p style="text-align: right;"> 2020. 09. 01</p>
					</td>
				</tr>
				<tr>
					<th>
						<p style="text-align: left; color: red; font-weight:bold; font-size:17px"> WNS(월드펫) Staking Reward Plan</p>
					</th>
				</tr>
				<tr >
					<td style="padding:0 10%;">
						<img style="width: 100%; display: block;" src="/assets/img/popup_notice/notice_1.png" alt="">
					</td>
				</tr>
				<tr >
					<td style="padding:0 10%;">
						<img style="width: 100%; display: block;" src="/assets/img/popup_notice/notice_2.png" alt="">
					</td>
				</tr>
				<tr >
					<td style="padding:0 10%;">
						<img style="width: 100%; display: block;" src="/assets/img/popup_notice/notice_3.png" alt="">
					</td>
				</tr>
				<tr>
					<td style="padding:20px 0;">
						<p style="text-align: left; color: red; font-weight:bold; font-size:16px">모든 수당은 300% 순환 </p>
						<p style="text-align: left; color: blue; font-weight:bold; font-size:14px">- 모든 참여자는 달성요건 충족 시, UP Grade Incentive를 지급 받습니다.</p>
						<p style="text-align: left; color: blue; font-weight:bold; font-size:14px">- 직급 수당 300% 제약 없이 초과 수령이 가능합니다.</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="np_bt">
		<button class="btn btn-info np_close">닫기</button>
	</div>
</div>
</div>
<script>
	$('.np_close').click(function(){
	$('.notic_popup').hide();
	});
</script> -->