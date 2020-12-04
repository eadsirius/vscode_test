<style>
	.widget {
		border-radius: 10px;
		padding: 15px 20px;
		margin-bottom: 10px;
		margin-top: 10px;
	}

	.blue-bg,
	.bg-success {
		background-color: #1c84c6;
		color: #ffffff;
	}

	.col-lg-3 {
		float: left;
	}

	.text-center {
		margin: 0 auto;
	}

	button {
		border: none;
		background: none;
	}

	.clear::after {
		content: '';
		display: block;
		clear: both;
	}
</style>
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
						<h4 class="card-title"><?=$title?></h4>
						<h6 class="card-subtitle">매출을 등록 하실 수 있습니다.</h6>
						<h6 class="card-subtitle" style="color: red;font-weight: bold;">매출을 수동 등록 하실려면 아이디를 정확히 검색 후 찾은후 하단의 금액을
							선택하시고 매출 등록을 누르시면 등록됩니다.</h6>
						<span style="font-weight: bold; font-size:20px; color:red; margin-right:30px;">1 WNS = 100원</span><span
							style="font-weight: bold; font-size:20px; color:red;margin-right:30px;">1 Point = 10 원</span>
						<!-- <span style="font-weight: bold; font-size:20px; color:red;">$ 1 = 1200 원</span> -->
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="dataTables_length">
									<form name='fsearch' method='post' action="<?=SEARCH_URL?>">
										<select class="custom-select col-12" id="inlineFormCustomSelect" style="width: 100px; height: 28px;"
											id='st' name='st'>
											<option value='member_id' <?if($st=='member_id' ){?>selected
												<?}?>>아이디</option>
										</select>
										<input type="text" class="form-control form-control-sm" style="width: 200px;" name="sc"
											value="<?=$search?>">
										<input type="submit" class="btn1 btn-dark" style="height: 28px;" value=" 검색 ">
										<a class="btn1 btn-primary" style="padding: 3px 10px;" href="/admin/point/purchase">리셋</a>
										<!-- <button type="button" class="btn1 btn-primary" style="height: 28px;"><a href="/admin/excel/purchase"style="color: #ffffff;">Excel</a></span> -->
									</form>
								</div>
							</div>

						</div>
						<br>

						<table id="mainTable" class="table table-bordered table-striped m-b-0">
							<thead>
								<tr class="txt_center">
									<th>회원번호</th>
									<th>아이디</th>
									<th>이름</th>
									<th>Depth(대)</th>
									<th>추천인</th>
									
									<th>총매출액</th>
									<th>총수당 (P)</th>
									<th>매출액</th>
									<th>총수당 (P)</th>
									<th>지급율</th>
									<th>가입일</th>
								</tr>
							</thead>
							<tbody>
								<?if($total_count > 0) {?>
								<?
								$i = $total_count;
								foreach ($item as $row) :
								?>
								<tr>
									<td class="txt_right"><?=$row->member_no?></td>
									<td class="txt_left"><span class="bold"><?=$row->member_id?></span></td>
									<td class="txt_left"><?=@$row->name?></td>
									<td class="txt_right"><?=$row->dep?></td>
									<td class="txt_left"><?=$row->recommend_id?></td>
									
									<td class="txt_right" style="color: red;">&#8361; <?=number_format($row->total_sales*10,0)?> 원</td>
									<td class="txt_right"><?=number_format($row->total_all_point,0)?></td>
									<td class="txt_right" style="color: red;">&#8361; <?=number_format($row->active_point*10,0)?> 원</td>
									<td class="txt_right"><?=number_format($row->active_total_point,0)?></td>
									<td class="txt_right"><?=number_format($row->total_percent,2)?> %</td>
									<td class="txt_center"><?=$row->regdate?></td>
								</tr>
								<?
								$i--;
								endforeach
    							?>
								<? } ?>
							</tbody>
						</table>
						<br>

						<div class="row">
							<button class="col-lg-2 col-md-6" class="dollar_btn" data-amount='100000' onclick="btn(100000)">
								<div class="widget style1 blue-bg">
									<div class="row">
										<div class="col-xs-10 text-center">
											<h3 class="font-bold" style="font-size:18px;">100,000 P</h3>
											<h3 class="font-bold" style="font-size:18px; color:#0f0;">&#8361 1,100,000 원</h3>
										</div>
									</div>
								</div>
							</button>
							<button class="col-lg-2 col-md-6" class="dollar_btn" data-amount='300000' onclick="btn(300000)">
								<div class="widget style1 blue-bg">
									<div class="row">
										<div class="col-xs-10 text-center">
											<h3 class="font-bold" style="font-size:18px;">300,000 P</h3>
											<h3 class="font-bold" style="font-size:18px; color:#0f0;">&#8361 3,300,000 원</h3>
										</div>
									</div>
								</div>
							</button>
							<button class="col-lg-2 col-md-6" class="dollar_btn" data-amount='700000' onclick="btn(700000)">
								<div class="widget style1 blue-bg">
									<div class="row">
										<div class="col-xs-10 text-center">
											<h3 class="font-bold" style="font-size:18px;">700,000 P</h3>
											<h3 class="font-bold" style="font-size:18px; color:#0f0;">&#8361 7,700,000 원</h3>
										</div>
									</div>
								</div>
							</button>
							<button class="col-lg-2 col-md-6" class="dollar_btn" data-amount='1000000' onclick="btn(1000000)">
								<div class="widget style1 blue-bg">
									<div class="row">
										<div class="col-xs-10 text-center">
											<h3 class="font-bold" style="font-size:18px;">1,000,000 P</h3>
											<h3 class="font-bold" style="font-size:18px; color:#0f0;">&#8361 11,000,000 원</h3>
										</div>
									</div>
								</div>
							</button>
							<button class="col-lg-2 col-md-6" class="dollar_btn" data-amount='3000000' onclick="btn(3000000)">
								<div class="widget style1 blue-bg">
									<div class="row">
										<div class="col-xs-10 text-center">
											<h3 class="font-bold" style="font-size:18px;">3,000,000 P</h3>
											<h3 class="font-bold" style="font-size:18px; color:#0f0;">&#8361 33,000,000 원</h3>
										</div>
									</div>
								</div>
							</button>
						</div>
						<div class="row">
							<form name="form_purchase" id="form_purchase" action="/admin/point/adminPurchase" method="post"
								style="margin: 0 auto;">
								<input type="hidden" name="member_no" id="member_no" value="<?= (empty($row->member_no) )? '' : $row->member_no ?>" />
								<input type="hidden" name="member_id" id="member_id" value="<?= (empty($row->member_id) )? '' : $row->member_id ?>" />
								<input type="hidden" name="count" id="count" value="" />
								<input type="hidden" name="type" id="type" value="1" />

								<div>
									<div class="clear" style="margin-top: 30px">
										<h3 style="float: left; margin-right:30px">매출Point</h3>
										<h3 style="float: left; width: 170px; margin-right:30px" class="amount"></h3>
										<h3 style="float: left; width: 170px; color:#0f0; font-weight:bold;" class="amount_0"></h3>
									</div>
									<div style="width: 100%; margin: 20px 0; text-align: center;">
										<input type="submit" class="btn btn-info" value="매출 등록하기" style="width:120px; height:60px;"
											id="btn_submit">
									</div>
								</div>
							</form>
						</div>
						<!-- <p style="text-align: center; font-size:20px;">OR</p>
						<div class="row">
							<form name="form_purchase_free" id="form_purchase_free" action="/admin/point/adminPurchaseFree" method="post"
								style="margin: 0 auto;">
								<input type="hidden" name="member_no" id="member_no" value="<?= (empty($row->member_no) )? '' : $row->member_no ?>" />
								<input type="hidden" name="member_id" id="member_id" value="<?= (empty($row->member_id) )? '' : $row->member_id ?>" />
								<input type="hidden" name="count1" id="count1" value="" />
								<input type="hidden" name="type" id="type" value="2" />

								<div>
									<div class="clear" style="margin-top: 30px">
										<h3 style="float: left; margin-right:30px">외상 매출Point</h3>
										<h3 style="float: left; width: 170px; margin-right:30px" class="amount"></h3>
										<h3 style="float: left; width: 170px; color:#0f0; font-weight:bold;" class="amount_0"></h3>
									</div>
									<div style="width: 100%; margin: 20px 0; text-align: center;">
										<input type="submit" class="btn btn-info" value="외상 매출 등록하기" style="width:150px; height:60px; background:red;"
											id="btn_submit1">
									</div>
								</div>
							</form>
						</div> -->

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

	function btn(str) {
		var member_id = $('#member_id').val();
		var clickAmount = str;

		if (member_id == '') {
			alert("아이디를 검색 후 이용해 주세요.");
			return false;
		} else {
			$("#count").val(parseInt(clickAmount));
			$("#count1").val(parseInt(clickAmount));
			$(".amount").text(comma(clickAmount) + " P");
			$(".amount_0").text(comma(clickAmount*11) + " 원");
		}

	}

	function comma(str) {
		str = String(str);
		return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
	}

	$('#btn_submit').click(function () {
		var member_id = $('#member_id').val();
		var amount = $('#count').val();
		if (member_id == '') {
			alert("아이디를 검색 후 이용해 주세요.");
			return false;
		}
		if (amount == '') {
			alert("금액을 선택해 주세요.");
			return false;
		}

	});
	$('#btn_submit1').click(function () {
		var member_id = $('#member_id').val();
		var amount = $('#count1').val();
		if (member_id == '') {
			alert("아이디를 검색 후 이용해 주세요.");
			return false;
		}
		if (amount == '') {
			alert("금액을 선택해 주세요.");
			return false;
		}

	});
</script>