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
				<h4 class="text-themecolor">Dashboard</h4>
			</div>
			<?php if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {?>
			<div class="col-md-2 align-self-center">
				<a href="http://winners.web-wallet.info/cron5/start" style="padding: 3px; font-weight:bold; background:green;">마감 돌리기</a>
			</div>
			<?}?>
			<div class="col-md-7 align-self-center text-right">
				<div class="d-flex justify-content-end align-items-center">
					<!-- <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol> -->
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title m-b-0 align-self-center" style="margin-bottom: 10px;">오늘 매출 회원명단</h6>
						<ul id="webticker-5">
							<?
								foreach ($sale as $row) :
    							?>
							<li><i class="fas fa-check"></i><span class="text-info"> <?=$row->member_id?> </span><span
									class="text-warning"> <?=number_format($row->point)?> POINT</span></li>
							<?
								endforeach
    							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- Yearly Sales -->
		<!-- ============================================================== -->
		<div class="row">


			<div class="col-lg-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">신규회원</h5>
						<h6 class="card-subtitle">신규회원 명단 최근것을 보여드립니다.</h6>
						<div class="steamline m-t-30">
							<? foreach($laster as $row) { ?>
							<div class="sl-item">
								<div class="sl-right">
									<div class="font-medium"> <?=$row->member_id?> <span class="sl-date"> <?=$row->name?></span></div>
									<div class="desc"><i class="fa fa-plus text-success"></i>추천: <?=$row->recommend_id?> </div>
								</div>
							</div>
							<?}?>
						</div>
						<br><a href="/admin/member/lists" class="btn m-r-5 btn-rounded btn-outline-success">회원관리 바로가기</a>
					</div>
				</div>
			</div>

			<div class="col-lg-8">
				<div class="card">
					<div class="card-body">
						<div class="d-flex m-b-30 align-items-center no-block">
							<h5 class="card-title">WNS 코인 시세 설정</h5>
						</div>
						<div class="ml-auto">
							<form name="reg_form" action="/admin/start/setCfgwon" method="post" class="tab-wizard wizard-circle">
								<label for="title">WNS WON 시세 :</label>
								<input type="hidden" id="cfg_no" name="cfg_no" value="1">
								<input type="hidden" id="before_cfg_won" name="before_cfg_won" value="<?=number_format($site->cfg_won,2)?>">
								<input type="hidden" id="inputid" name="inputid" value="<?=@$this->session->userdata('member_id')?>">
								<input type="hidden" id="inputip" name="inputip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
								<input type="text" class="form-control" id="cfg_won" name="cfg_won" maxlength="5" style="width: 100px;"
									value="<?=number_format($site->cfg_won,2)?>"
									oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
								<?php if(date("H",strtotime("+9 hours")) >= 9 && date("H",strtotime("+9 hours")) < 18){?>
								<input type="submit" class="btn btn-info" value="변경하기" id="btn_submit" style="margin: 10px 0;">
								<?}else{?>
								<input type="button" class="btn btn-info" value="변경하기" onclick="alert('오전 9시부터 오후 18시 까지만 변경 가능합니다.')" style="margin: 10px 0;">
								<?}?>
								
								<h3 style="color: red; font-size:14px; font-weight:bold;">시세는 0이하로 설정할수 없으며, 시세를 정확한 값으로 설정하지 않으시면 매출이나 출금금액등에 문제가 발생합니다.</h3>
							</form>
						</div>
						<div style="height: 365px;">
							<div class="message-widget message-scroll">
								<table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
									<thead>
										<tr>
											<th>변경 전 WNS WON 시세</th>
											<th>변경 후 WNS WON 시세</th>
											<th>변경 시간</th>
										</tr>
									</thead>
									<tbody>
										<?php if(!empty($change_list)) {
                                            foreach($change_list as $val) {
                                        ?>
										<tr>
											<td><?=number_format($val->before_amount,2)?></td>
											<td><?=number_format($val->after_amount,2)?></td>
											<td><?=$val->inputdttm?></td>
										</tr>
										<?php }
                                        }else{?>
										<tr>
											<td colspan="3" align="center">등록(검색)된 정보가 없습니다.</td>
										</tr>
										<?php
                                        }?>
									</tbody>
								</table>

							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

		<!-- ============================================================== -->
		<!-- 오늘의 그룹별 매출 -->
		<!-- ============================================================== -->

		<!-- ============================================================== -->
		<!-- To do chat and message -->
		<!-- ============================================================== -->
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title" style="font-size: 18px; font-weight:bold;">Today</h5>
						<h6 class="card-title">매출 회원명단</h6>
						<div class="message-box" id="task2" style="height: 400px;position: relative;">
							<div class="message-widget message-scroll">
								<?
									foreach ($sale as $row) :
    								?>
								<a href="javascript:void(0)">
									<div class="mail-contnet">
										<h5><?=$row->member_id?> </h5> <span class="mail-desc"><?=number_format($row->point)?></span>
									</div>
								</a>
								<?
									endforeach
    								?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title" style="font-size: 18px; font-weight:bold;">Today</h5>
						<h6 class="card-title">출금신청한 회원</h6>
						<div class="message-box" id="task1" style="height: 400px;position: relative;">
							<div class="message-widget message-scroll">
								<?
									foreach ($laster_out as $row) :
    								?>
								<a href="javascript:void(0)">
									<div class="mail-contnet">
										<h5><?=$row->member_id?> </h5> <span class="mail-desc"><?=number_format($row->point)?></span>
									</div>
								</a>
								<?
									endforeach
    								?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title" style="font-size: 18px; font-weight:bold;">Today</h5>
						<h6 class="card-title">WNS Send 회원</h6>
						<div class="message-box" id="task3" style="height: 400px;position: relative;">
							<div class="message-widget message-scroll">
								<?
									foreach ($laster_coin as $row) :
    								?>
								<a href="javascript:void(0)">
									<div class="mail-contnet">
										<h5><?=$row->member_id?> </h5> <span class="mail-desc"><?=number_format($row->point,4)?></span>
									</div>
								</a>
								<?
									endforeach
    								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Page Content -->
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
<!-- Bootstrap popper Core JavaScript -->
<script src="<?=$skin_dir?>/assets/node_modules/popper/popper.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?=$skin_dir?>/assets/dist/js/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="<?=$skin_dir?>/assets/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?=$skin_dir?>/assets/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="<?=$skin_dir?>/assets/dist/js/custom.min.js"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!--morris JavaScript -->
<script src="<?=$skin_dir?>/assets/node_modules/raphael/raphael-min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/morrisjs/morris.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
<!-- Popup message jquery -->
<script src="<?=$skin_dir?>/assets/node_modules/d3/d3.min.js"></script>
<script src="<?=$skin_dir?>/assets/node_modules/c3-master/c3.min.js"></script>
<!-- Chart JS -->
<script src="<?=$skin_dir?>/assets/dist/js/dashboard1.js?"></script>
<!-- datatable -->
<script src="<?=$skin_dir?>/assets/node_modules/datatables/datatables.min.js"></script>
<!-- Tickers -->
<script src="<?=$skin_dir?>/assets/dist/js/jquery.webticker.min.js"></script>
<script src="<?=$skin_dir?>/assets/dist/js/fastclick.js"></script>
<script src="<?=$skin_dir?>/assets/dist/js/web-ticker.js"></script>
<script type="text/javascript">
	$(function () {
		$('#cc-table').DataTable({
			"displayLength": 10
		});
		$("#live").perfectScrollbar();
		$("#task1").perfectScrollbar();
		$("#task2").perfectScrollbar();
		$("#task3").perfectScrollbar();
	});

	$('#btn_submit').click(function () {
		var before_cfg_won = <?=$site->cfg_won?>;
		var cfg_won = $('#cfg_won').val();
		if (before_cfg_won == cfg_won) {
			alert("시세를 변경해 주세요.");
			return false;
		}
		if (cfg_won <= 0) {
			alert("시세는 0 이하로 설정할 수 없습니다.");
			return false;
		}

	})
</script>