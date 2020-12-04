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
								<?php if($this->uri->segment(3,0) == 'su_day') {?>
									<h6 class="card-subtitle">데일리 수당은 본인 기준으로 지급되는 수당입니다. </h6>
								<?}elseif($this->uri->segment(3,0) == 'su_mc'){?>
									<h6 class="card-subtitle">추천매칭 수단은 하위 1대 ~ 3대에 지급되는 수당입니다. </h6>
								<?}else{?>
									<h6 class="card-subtitle">공유 수당은 본인 기준으로 하위 4대 ~ 10대가 전날 매출 등록한것으로 1회만 지급되는 수당입니다. </h6>
								<?}?>

								<span style="font-weight: bold; font-size:16px; color:red;">1 Point = 10 원</span>
							</div>
							<div class="col-sm-12 col-md-6">
								<table class="table editable-table table-bordered table-striped m-b-0">
								<thead>
										<tr>
											<th></th>
											<th class="txt_center">총 매출 (P)</th>
										<?php if($this->uri->segment(3,0) == 'su_day') {?>
											<th class="txt_center">총 데일리 (P)</th>
										<?}elseif($this->uri->segment(3,0) == 'su_mc'){?>
											<th class="txt_center">총 추천 (P)</th>
										<?}else{?>
											<th class="txt_center">총 공유 (P)</th>
										<?}?>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th>전체기간별 금액</th>
											<td class="txt_right"><?=number_format($all_su->total,0)?></td>
										<?php if($this->uri->segment(3,0) == 'su_day') {?>
											<td class="txt_right"><?=number_format($all_su->day,0)?></td>
										<?}elseif($this->uri->segment(3,0) == 'su_mc'){?>
											<td class="txt_right"><?=number_format($all_su->mc,0)?></td>
										<?}else{?>
											<td class="txt_right"><?=number_format($all_su->re,0)?></td>
										<?}?>
										</tr>
										<tr>
											<th>검색기간별 금액</th>
											<td class="txt_center"> - </td>
										<?php if($this->uri->segment(3,0) == 'su_day') {?>
											<td class="txt_right"><?=number_format($all_ssu->s_day,0)?></td>
										<?}elseif($this->uri->segment(3,0) == 'su_mc'){?>
											<td class="txt_right"><?=number_format($all_ssu->s_mc,0)?></td>
										<?}else{?>
											<td class="txt_right"><?=number_format($all_ssu->s_re,0)?></td>
										<?}?>
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
											<option value='event_id' <?if($st=='event_id' ){?>selected
												<?}?>>이벤트아이디</option>
											<option value='member_id' <?if($st=='member_id' ){?>selected
												<?}?>>아이디</option>
										</select>
										<input type="text" class="form-control form-control-sm" style="width: 200px;" name="sc"
											value="<?=$search?>">

										수당 지급 일자 : <input type="text" class="form-control form-control-sm" style="width: 120px;" name="sdate"
											id="sdate" value="<?=(empty($sdate))? date('2020-11-24',strtotime("+9 hours")):$sdate ?>"> -
										<input type="text" class="form-control form-control-sm" style="width: 120px;" name="edate"
											id="edate" value="<?=(empty($edate))? date('Y-m-d',strtotime("+9 hours")):$edate ?>">

										<input type="submit" class="btn1 btn-dark" style="height: 28px;" value=" 검색 ">
										<button type="button" class="btn1 btn-primary"
											style="height: 28px;background:#2962FF;border-color:#2962FF"
											onclick="location.href='/admin/point/<?=$this->uri->segment(3,0)?>'">초기화</button>
										<!--
                    <button type="button" class="btn1 btn-primary" style="height: 28px;">
                      <a href="/admin/excel/pointSu/<?=@$search?>/<?=@$st?>" style="color: #ffffff;">Excel</a>
                    </button>
-->
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

						<form name='del' method='post'>
							<input type='hidden' name='start'>
							<input type='hidden' name='end'>
						</form>
						<script>
							function Delete(url) {
								var del = document.del;

								var sdate = document.getElementById('sdate').value;
								var edate = document.getElementById('edate').value;
								del.start.value = sdate;
								del.end.value = edate;

								if (confirm("기간별 수당을 다운으시겠습니까?")) {
									del.action = url;
									del.submit();
								}
							}
						</script>
						<style>
							.bg_red {
								background: #ff00001a;
							}

							.bg_blue {
								background: #0000ff1a;
							}
						</style>
						<table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
							<thead>
								<tr class="txt_center">
									<?php if($this->uri->segment(3,0) == 'su_mc') {?>
									<th>번호</th>
									<th class="bg_blue">수당 받는 아이디</th>
									<th class="bg_blue">수당 받는자 이름</th>
									<th class="bg_red">매출등록아이디</th>
									<th>하위 대수</th>
									<th class="bg_red">데일리수당액 (P)</th>
									<th>지급율</th>
									<th class="bg_blue">추천매칭수당액 (P)</th>
									<?}elseif($this->uri->segment(3,0) == 'su_re'){?>
									<th>번호</th>
									<th class="bg_blue">수당 받는 아이디</th>
									<th class="bg_blue">수당 받는자 이름</th>
									<th class="bg_red">매출등록아이디 / 이름</th>
									<th>하위 대수</th>
									<th class="bg_blue">수당 받는자의 매출금액 (P)</th>
									<th class="bg_red">전날 매출한 금액 (P)</th>
									<th>지급율</th>
									<th class="bg_blue">실수당 (P)</th>
									<?}else{?>
									<th>번호</th>
									<th class="bg_blue">수당 받는 아이디</th>
									<th class="bg_blue">수당 받는자 이름</th>
									<th class="bg_blue">매출금액 (P)</th>
									<th>지급율</th>
									<th class="bg_blue">실수당 (P)</th>
									<?}?>
									<th>수당종류</th>
									<th>Date</th>
									<!-- <th>비고</th> -->
								</tr>
							</thead>
							<tbody>
								<?
								$i = $total_count;
								foreach ($item as $row) :
    							?>
								<tr>
									<?php if($this->uri->segment(3,0) == 'su_mc') {?>
									<td class="txt_right"><?=number_format($i)?></td>
									<td class="txt_left bg_blue"><span class="bold" style="color: blue;"><?=$row->member_id?></span></td>
									<td class="txt_left bg_blue"><?=@$row->name?></td>
									<td class="txt_left bg_red"><span class="bold"><?=$row->event_id?></span></td>
									<td class="txt_right"><?=number_format($row->dep)?></td>
									<td class="txt_right bg_red"><?=number_format($row->saved_point,0)?></td>
									<td class="txt_right"><?=number_format($row->msg*100,0)?> %</td>
									<td class="txt_right bg_blue"><?=number_format($row->point,0)?></td>
									<?}elseif($this->uri->segment(3,0) == 'su_re'){?>
									<td class="txt_right"><?=number_format($i)?></td>
									<td class="txt_left bg_blue"><span class="bold" style="color: blue;"><?=$row->member_id?></span></td>
									<td class="txt_left bg_blue"><?=@$row->name?></td>
									<td class="txt_left bg_red"><span class="bold"><?=$row->event_id?> / <?=$row->event_id?></span></td>
									<td class="txt_right"><?=$row->protg?></td>
									<td class="txt_right bg_blue"><?=number_format($row->re_sp,0)?></td>
									<td class="txt_right bg_red"><?=number_format($row->saved_point,0)?></td>
									<td class="txt_right"><?=number_format($row->msg*100,1)?> %</td>
									<td class="txt_right bg_blue"><?=number_format($row->point,0)?></td>
									<?}else{?>
									<td class="txt_right "><?=number_format($i)?></td>
									<td class="txt_left bg_blue"><span class="bold" style="color: blue;"><?=$row->member_id?></span></td>
									<td class="txt_left bg_blue"><?=@$row->name?></td>
									<td class="txt_right bg_blue"><?=number_format($row->saved_point,0)?></td>
									<td class="txt_right "><?=number_format($row->msg*100,0)?> %</td>
									<td class="txt_right bg_blue"><?=number_format($row->point,0)?></td>
									<?}?>

									<td class="txt_left"><?php 
										switch ($row->kind) {
											case 'day' : echo '데일리';
											break;
											case 'mc' : echo '추천매칭';
											break;
											case 're' : echo '공유';
											break;
										}?></td>
									<td class="txt_center"><?=date("Y-m-d H:i:s",strtotime($row->regdate." +9 hours"))?></td>

								</tr>
								<?
								$i--;
								endforeach
    							?>
							</tbody>
						</table>
						<div id="pages"><?=PAGE_URL?></div>
						<br><br>
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