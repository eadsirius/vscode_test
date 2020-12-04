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
					<!-- <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">대시보드</li> -->
					<!--
								<a href="/admin/plan/token_full"><button type="button" class="btn btn-dark d-none d-lg-block m-l-15" data-toggle="modal" data-target="#add-contact">
                                    <i class="fa fa-plus-circle"></i> 토큰옮기기</button></a>
                                -->
					<!-- </ol> -->
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
								<h4 class="card-title"><?=$title?> | 총회원수 <?=number_format($total_count)?>명</h4>
								<h6 class="card-subtitle">회원별 매출과 받은 수당항목을 볼 수 있습니다.</h6>
								<span style="font-weight: bold; font-size:16px; color:red;">1 Point = 10 원</span>
							</div>

							<div class="col-sm-12 col-md-6">
								<table class="table editable-table table-bordered table-striped m-b-0">
									<thead>
										<tr>
											<th class="txt_center">총 매출 (P)</th>
											<th class="txt_center">총 수당 (P)</th>
											<th class="txt_center">총 데일리 (P)</th>
											<th class="txt_center">총 추천 (P)</th>
											<th class="txt_center">총 공유 (P)</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="txt_right"><?=number_format($all_su->total,0)?></td>
											<td class="txt_right"><?=number_format($all_su->all,0)?></td>
											<td class="txt_right"><?=number_format($all_su->day,0)?></td>
											<td class="txt_right"><?=number_format($all_su->mc,0)?></td>
											<td class="txt_right"><?=number_format($all_su->re,0)?></td>
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
										<input type="text" class="form-control form-control-sm" style="width: 200px;" name="sc"
											value="<?=$search?>">
										<input type="submit" class="btn1 btn-dark" style="height: 28px;" value=" 검색 ">
										<button type="button" class="btn1 btn-primary"
											style="height: 28px;background:#2962FF;border-color:#2962FF"
											onclick="location.href='/admin/plan/planPoint'">초기화</button>
										<!--<button type="button" class="btn1 btn-primary" style="height: 28px;"><a href="/admin/excel/balance"style="color: #ffffff;">Excel</a></span>-->
									</form>
								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="dataTables_filter">
									<?$list_per = $this->session->userdata('list_page');?>
									<select name="list" class="form-control form-control-sm" onchange="location.href=this.value">
										<option value="">0</option>
										<option value="/admin/config/page/10/planPoint" <?if($list_per==10){?>selected
											<?}?>>10</option>
										<option value="/admin/config/page/25/planPoint" <?if($list_per==25){?>selected
											<?}?>>25</option>
										<option value="/admin/config/page/50/planPoint" <?if($list_per==50){?>selected
											<?}?>>50</option>
										<option value="/admin/config/page/100/planPoint" <?if($list_per==100){?>selected
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
									<th>이름</th>
									<th>Depth</th>

									<th>매출</th>

									<th>수당합계 (P)</th>
									<th>데일리수당 (P)</th>
									<th>추천매칭수당 (P)</th>
									<th>공유수당 (P)</th>
								</tr>
							</thead>
							<tbody>
								<?
								$i = $total_count;
								foreach ($item as $row) :
    							?>
								<tr>
									<td class="txt_right"><?=number_format($i)?></td>
									<td class="txt_left"><span class="bold"><?=$row->member_id?></span></td>
									<td class="left"><?=@$row->name?></td>
									<td class="txt_right"><?=$row->dep?></td>

									<td class="txt_right">&#8361; <?=number_format($row->volume*10)?> 원</td>

									<td class="txt_right"><?=number_format($row->total_point,0)?></td>
									<td class="txt_right"><?=number_format($row->su_day,0)?></td>
									<td class="txt_right"><?=number_format($row->su_mc,0)?></td>
									<td class="txt_right"><?=number_format($row->su_re,0)?></td>
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
	$('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
	$('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
	$(document).ready(function () {
		$('#editable-datatable').DataTable();
	});
</script>