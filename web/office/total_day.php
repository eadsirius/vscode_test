<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
$select_lang = 'kr';

?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2>
			<?=get_msg($select_lang, '일일 수당 합계')?>
		</h2>
		<ol class="breadcrumb">
			<li>
				<a href="/"><?=get_msg($select_lang, '홈')?></a>
			</li>
			<li>
				<a><?=get_msg($select_lang, '수당')?></a>
			</li>
			<li class="active">
				<a><?=get_msg($select_lang, '일일 수당 합계')?></a>
			</li>
		</ol>
	</div>
</div>
<div id="Allowance" class="wrapper wrapper-content animated fadeInRight">

	<div class="row m-b-lg m-t-md">
		<div class="col-md-12">

			<div class="profile-image text-center">
				<i class="fa fa-dollar fa-5x"></i>
			</div>
			<div class="profile-info">
				<div class="">
					<div>
						<h2 class="no-margins">
							<?=get_msg($select_lang, '일일 수당 합계 정보')?>
						</h2>
						<table class="table m-t-md m-b-xs">
							<tbody>
								<tr>
									<td><strong><?=get_msg($select_lang, '총 수당')?> :</strong> <span class="font-bold text-primary">
											<?=number_format($mb->total_point)?></span>
									</td>
									<td><strong><?=get_msg($select_lang, '데일리 수당')?> :</strong> <?=number_format($mb->day_point)?></td>
								</tr>
								<tr>
									<td><strong><?=get_msg($select_lang, '추천매칭 수당')?> :</strong> <?=number_format($mb->mc_point)?>
									</td>
									<td><strong><?=get_msg($select_lang, '공유 수당')?> :</strong> <?=number_format($mb->re_point)?>
									</td>

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
					<h5><?=get_msg($select_lang, '수당 목록')?></h5>
				</div>
				<div class="ibox-content">

					<div class="row">
						<div class="col-lg-12">
							<!-- <div class="alert alert-info">
								<strong><?=get_msg($select_lang, '총횟수')?> :</strong> <?=number_format($total_rows)?>
							</div> -->
							<div class="table-responsive">
								<table class="table table-hover table-striped m-b-xs text-center">
									<thead>
										<tr>
											<th width="5%" class="text-center"><?=get_msg($select_lang, 'Num')?></th>
											<th width="" class="text-center"><?=get_msg($select_lang, '날짜')?></th>
											<th width="" class="text-center"><?=get_msg($select_lang, '데일리')?></th>
											<th width="" class="text-center"><?=get_msg($select_lang, '추천매칭')?></th>
											<th width="" class="text-center"><?=get_msg($select_lang, '공유')?></th>
											<!-- <th width="" class="text-center"><?=get_msg($select_lang, '직접추천')?></th> -->
											<!-- <th width="" class="text-center"><?=get_msg($select_lang, '간접추천')?></th> -->
											<th width="" class="text-center"><?=get_msg($select_lang, '합계')?></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$i=0;
											$page = $input["page"];
											$size = $input["size"];
											$num = $total_count - (($page -1) * $size);
											if(!empty($list)){
											foreach($list as $row) {
										?>
										<tr>
											<td><?=number_format($num--)?></td>
											<td><?=$row->regdate?></td>
											<td><?=number_format($row->DaySudang,0)?></td>
											<td><?=number_format($row->McSudang,0)?></td>
											<td><?=number_format($row->ReSudang,0)?></td>
											<!-- <td><?=$row->Mc2Sudang?></td> -->
											<!-- <td><?=$row->Re2Sudang?></td> -->
											<!-- <td><?=$row->DaySudang+$row->ReSudang+$row->Re2Sudang+$row->McSudang+$row->Mc2Sudang?></td> -->
											<td><?=number_format($row->DaySudang+$row->ReSudang+$row->McSudang)?></td>
										</tr>
										<? } ?>
										<?}else{?>
										<tr>
											<td colspan="8" style="background-color:#fff"><?=get_msg($select_lang, '내역 없음')?></td>
										</tr>
										<?}?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="18">
												<ul class="pagination" style="margin-top:10px">
													<?php 
													if((!empty($list))) {
														paging("/office/allowance/totaldaysu",$total_count,$page,$size,"");
													}?>
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
<style>
	.pagination span {
		margin: 3px;
	}
</style>
<script>
	var ShowDetail = function (kind, regdate) {
		Common.Dialog({
			url: '/office/allowance/detail',
			param: {
				kind: kind,
				regdate: regdate
			}
		});
	}

	$(document).ready(function () {
		window.setTimeout(function () {
			feeChange('0.03', $("#btnSelectFee"));
			$("#Allowance").removeClass("fadeInRight");
		}, 1000);
	});
</script>


<link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
<!-- iCheck -->
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<script>
	$(document).ready(function () {
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
	});
</script>

<script type="text/javascript">
	function formCheck() {
		var f = document.reg_form;

		if ($("#reg_form").find("input:radio[name=radio_btn]:checked").length == 0) {
			alert(Common.Lang['Please select an authentication method']);
			return false;
		}

		var con = $("#reg_form").find("input:radio[name=radio_btn]:checked").val();
		$("#reg_form").find("input[name=confing]").val(con);

		if ($("#feeArea").find("button.active").length == 0) {
			document.getElementById('fee').value = "";
		}

		if (f.confing.value == '') {
			alert(Common.Lang['Please select an authentication method']);
			return false;

		}
		if (f.fee.value == '') {
			alert(Common.Lang['Please click the withdrawal fee button']);
			return false;

		}
		return true;
	}


	function feeChange(fee, obj) {
		obj.parent().find("button").removeClass("active");
		obj.addClass("active");
		document.getElementById('fee').value = fee;
	}


	function formCheck2() {
		var f = document.reg_form2;

		if ($("#reg_form2").find("input:radio[name=radio_btn2]:checked").length == 0) {
			alert(Common.Lang['Please select an authentication method']);
			return false;
		}

		var con = $("#reg_form2").find("input:radio[name=radio_btn2]:checked").val();
		$("#reg_form2").find("input[name=confing]").val(con);

		if (f.confing.value == '') {
			alert(Common.Lang['Please select an authentication method']);
			return false;

		}
		return true;
	}


	function formCheck3() {
		var f = document.reg_form3;

		if ($("#reg_form3").find("input:radio[name=radio_btn3]:checked").length == 0) {
			alert(Common.Lang['Please select an authentication method']);
			return false;
		}

		var con = $("#reg_form3").find("input:radio[name=radio_btn3]:checked").val();
		$("#reg_form3").find("input[name=confing]").val(con);

		if (f.confing.value == '') {
			alert(Common.Lang['Please select an authentication method']);
			return false;

		}
		return true;
	}
</script>