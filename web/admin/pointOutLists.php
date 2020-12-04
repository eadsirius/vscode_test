<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="row page-titles">
			<div class="col-md-5 align-self-center">
				<h4 class="text-themecolor"><?=$title?></h4>
			</div>
			<div class="col-md-7 align-self-center text-right">
				<div class="d-flex justify-content-end align-items-center">
					<!--
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
     <li class="breadcrumb-item active">대시보드</li>
</ol>
-->
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<h4 class="card-title"><?=$title?> | 총건수 <?=number_format($total_count)?>건</h4>
								<h6 class="card-subtitle">수당을 개인 지갑으로 이동한 내역을 파악하실 수 있습니다.</h6>
								<h6 class="card-subtitle" style="color:red">9월 1일 이후 출금 수수료는 기존 5%에서 10%로 변경됨</h6>
								<span style="font-weight: bold; font-size:16px; color:red;">1 Point = 10 원</span>
							</div>
							<div class="col-sm-12 col-md-6">
								<table class="table editable-table table-bordered table-striped m-b-0">
									<thead>
										<tr>
											<th class="txt_center">총 출금신청 (P)</th>
											<th class="txt_center">총 출금요청 (P)</th>
											<th class="txt_center">총 출금완료 (P)</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="txt_right"><?=number_format($all_out->all,0)?></td>
											<td class="txt_right"><?=number_format($all_out->req,0)?></td>
											<td class="txt_right"><?=number_format($all_out->com,0)?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="dataTables_length">
									<form name='fsearch' method='post' action="<?=SEARCH_URL?>">
										<select class="custom-select col-12" id="inlineFormCustomSelect" style="width: 100px; height: 28px;"
											id='st' name='st'>
											<option value='member_id' <?if($st=='member_id' ){?>selected
												<?}?>>아이디</option>
										</select>
										<input type="text" class="form-control form-control-sm" style="width: 140px;" name="sc"
											value="<?=$search?>">
										<select class="custom-select" style="width: 130px; height: 28px;" id='kind' name='kind'>
											<option value='' <?if($kind=="" ){?>selected
												<?}?>>출금상태</option>
											<option value='request' <?if($kind=="request" ){?>selected
												<?}?>>출금신청</option>
											<option value='Pending' <?if($kind=="Pending" ){?>selected
												<?}?>>출금중</option>
											<option value='company' <?if($kind=="company" ){?>selected
												<?}?>>출금완료</option>

										</select>>
										날짜 : <input type="text" class="form-control form-control-sm" style="width: 120px;" name="sdate"
											id="sdate" value="<?=(empty($sdate))? '2020-07-31':$sdate ?>"> -
										<input type="text" class="form-control form-control-sm" style="width: 120px;" name="edate"
											id="edate" value="<?=(empty($edate))? date('Y-m-d'):$edate ?>">

										<input type="submit" class="btn1 btn-dark" style="height: 28px;" value=" 검색 ">
										<button type="button" class="btn1 btn-primary" style="height: 28px;"><a href="/admin/excel/pointEx"
												style="color: #ffffff;">Excel</a></span>
									</form>
								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="dataTables_filter">
									<?$list_per = $this->session->userdata('list_page');?>
									<select name="list" class="form-control form-control-sm" onchange="location.href=this.value">
										<option value="">0</option>
										<option value="/admin/config/page/10/point" <?if($list_per==10){?>selected
											<?}?>>10</option>
										<option value="/admin/config/page/25/point" <?if($list_per==25){?>selected
											<?}?>>25</option>
										<option value="/admin/config/page/50/point" <?if($list_per==50){?>selected
											<?}?>>50</option>
										<option value="/admin/config/page/100/point" <?if($list_per==100){?>selected
											<?}?>>100</option>
									</select>
								</div>
							</div>
						</div>
						<br>

						<table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
							<thead>
								<tr class="txt_center">
									<th>번호</th>
									<th>아이디</th>
									<th>은행 정보</th>
									<th>실지급 (P)</th>
									<th>수수료 (P)</th>
									<th>출금신청 (P)</th>
									<th>출금상태</th>
									<th>신청일 / 전송(완료/취소)일시</th>
									<th>관리</th>
								</tr>
							</thead>
							<form id='formTxid' method="post" action="/admin/point/exSend/">
								<input type="hidden" name="point_no" id='point_no' value="">
								<input type="hidden" name="tx_id" id='tx_id' value="">
								<input type="hidden" name="appdate" id='appdate' value="">
								<input type="hidden" name="member_id" id='member_id' value="">
								<input type="hidden" name="bank_holder" id='bank_holder' value="">
								<input type="hidden" name="bank_number" id='bank_number' value="">
								<input type="hidden" name="bank_name" id='bank_name' value="">
							</form>
							<tbody>
								<?
								$i = $total_count;
								foreach ($item as $row) :
    							?>
								<tr>
									<td class="txt_right"><?=number_format($i)?></td>
									<td class="txt_left">
										<?php if($row->type == 'send') { ?>
										<span style="color:red; font-weight:bold;">취소완료</span>
										<?} else {?>
										<span><?=@$row->member_id?></span>
										<?}?>
									</td>
									<!-- <td>
										<span><?=@$row->event_id?></span>
										<input type="hidden" class="out_wallet" id='<?=$i?>' value="<?=@$row->event_id?>"style="border: none;">
										<?php if($row->type != 'send') { ?>
										<button class="copy_btn" onclick="copyToClipboard('#<?=$i?>')">주소복사</button>
										<?}?>
										<br>
										<?php if(empty($row->tx_id)) {?>
										<p style="color : #ff3f07; margin:0; font-weight:bold;">Transaction Hash:</p>
										<input type="text" id="txid_<?=$row->point_no?>" value="" placeholder="Transaction Hash를 입력해주세요."
											style="width: 90%;">
										<?} else {?>
										<a href="http://etherscan.io/tx/<?=$row->tx_id?>" target="_blank">
											<?=@$row->tx_id?>
										</a>
										<?}?>
										<?php if($row->kind == 'request') {?>
										<br>
										<p style="color : #ff3f07; margin:0; font-weight:bold;">전송일시:</p><input type="text"
											id="sendate_<?=$row->point_no?>" placeholder="0000-00-00 00:00:00">
										<?}?>
									</td> -->
									<td class="txt_left">
										<p style="margin: 0;">은행 : <?=$row->bank_name?></p>
										<p style="margin: 0;">계좌 : <?=$row->bank_number?></p>
										<p style="margin: 0;">이름 : <?=$row->bank_holder?></p>
									</td>
									<td class="txt_right"><?=number_format($row->point,0)?></td>
									<td class="txt_right"><?=number_format($row->bank_fee,0)?></td>
									<td class="txt_right"><?=number_format($row->saved_point,0)?></td>
									<td class="txt_left"><?=$row->state=='1'?'요청':'완료'?></td>
									<td class="txt_center">
										<?=$row->regdate?><br>
										<?php if($row->type == 'send') { ?>
										<p style="color:red;"><?=$row->appdate?></p>
										<?}else {?>
										<p style="color:black;"><?=$row->appdate?></p>
										<?}?>
									</td>
									<td>
										<?if($row->state == '1'){?>
										<button type="button"
											onclick="walletSet(<?=$row->point_no?>,'<?=@$row->member_id?>','<?=$row->bank_name?>','<?=$row->bank_number?>','<?=$row->bank_holder?>');"
											class="btn waves-effect waves-light btn-rounded btn-xs btn-info">완료하기</button>
										<p style="margin-top: 5px;"><a href="/admin/point/delete/<?=$row->point_no?>/<?=$table?>"
												class="btn waves-effect waves-light btn-rounded btn-xs btn-info"
												style="background:#f30324; border-color:#f30324;">
												<span>취소하기</span>
											</a></p>
										<?}else	{?>
										<button type="button" class="btn waves-effect waves-light btn-rounded btn-xs btn-info"
											style="background: #28a932;">출금완료</button>
										<?}?>
									</td>
								</tr>
								<?
								$i--;
								endforeach
    							?>
							</tbody>
						</table>
						<div id="pages"><?=PAGE_URL?></div>
					</div>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End PAge Content -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Right sidebar -->
		<!-- ============================================================== -->
		<!-- .right-sidebar -->
		<div class="right-sidebar">
			<div class="slimscrollright">
				<div class="rpanel-title"> Service Panel <span><i class="fas fa-times right-side-toggle"></i></span> </div>
				<div class="r-panel-body">
					<ul id="themecolors" class="m-t-20">
						<li><b>With Light sidebar</b></li>
						<li><a href="javascript:void(0)" data-skin="skin-default" class="default-theme working">1</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-green" class="green-theme">2</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-red" class="red-theme">3</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-blue" class="blue-theme">4</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-purple" class="purple-theme">5</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-megna" class="megna-theme">6</a></li>
						<li class="d-block m-t-30"><b>With Dark sidebar</b></li>
						<li><a href="javascript:void(0)" data-skin="skin-default-dark" class="default-dark-theme ">7</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-green-dark" class="green-dark-theme">8</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-red-dark" class="red-dark-theme">9</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-blue-dark" class="blue-dark-theme">10</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-purple-dark" class="purple-dark-theme">11</a></li>
						<li><a href="javascript:void(0)" data-skin="skin-megna-dark" class="megna-dark-theme ">12</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Right sidebar -->
		<!-- ============================================================== -->
	</div>
	<!-- ============================================================== -->
	<!-- End Container fluid  -->
	<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<footer class="footer">
	© 2020 WNS © All Rights Reserved
</footer>
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?=$skin_dir?>/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?=$skin_dir?>/assets/node_modules/popper/popper.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?=$skin_dir?>/assets/dist/js/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="<?=$skin_dir?>/assets/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?=$skin_dir?>/assets/dist/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="<?=$skin_dir?>/assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="<?=$skin_dir?>/assets/dist/js/custom.min.js"></script>
<!-- Editable -->
<script src="<?=$skin_dir?>/assets/node_modules/jquery-datatables-editable/jquery.dataTables.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/tiny-editable/mindmup-editabletable.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/tiny-editable/numeric-input-example.js"></script>
<script>
	// $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
	// $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
	$(document).ready(function () {
		$('#editable-datatable').DataTable();
	});

	function copyToClipboard(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).val()).select();
		document.execCommand("copy");
		$temp.remove();
		alert("출금 지갑 주소가 복사 되었습니다.");
		//Optional Alert, 삭제해도 됨
	}

	function walletSet(pointNo, memberId, bankHolder, bankNumber, bankName) {
		var txid = $("#txid_" + pointNo).val();
		var appdate = $("#sendate_" + pointNo).val();

		// if (!txid) {
		// 	alert('Transaction Hash 값을 입력하세요.');
		// 	return false;
		// }
		// if (txid.length != 66) {
		// 	alert('Transaction Hash 값을 잘못 입력하셨습니다.');
		// 	return false;
		// }
		// if (!appdate) {
		// 	alert('전송일시를 입력하세요.');
		// 	return false;
		// }
		// if (appdate.length != 19) {
		// 	alert('전송일시를 잘못 입력하셨습니다.');
		// 	return false;
		// }

		$("#point_no").val(pointNo);
		$("#tx_id").val(txid);
		$("#appdate").val(appdate);
		$("#member_id").val(memberId);

		$("#bank_holder").val(bankHolder);
		$("#bank_number").val(bankNumber);
		$("#bank_name").val(bankName);

		if (confirm("완료 하시겠습니까? ")) {
			$("#formTxid").submit();
			return true;
		} else {
			return false;
		}
	}
</script>
<style>
	.copy_btn {
		padding: .25rem .5rem;
		font-size: 10px;
		color: #fff;
		background-color: #03a9f3;
		border-color: #03a9f3;
		border-radius: 60px;
		border: none;
	}
</style>