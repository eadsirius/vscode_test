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
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">대시보드</li>
                            <button type="button" class="btn btn-dark d-none d-lg-block m-l-15" data-toggle="modal" data-target="#add-contact"><i class="fa fa-plus-circle"></i> 수동마감</button>
                            </ol>
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
                                <h4 class="card-title"><?=$title?> | 총 건수  <?=$total_count?>건</h4>
                                <h6 class="card-subtitle">주마감 시 데일리수당 | 일마감 시 - 추천, 센터, 센터소개, 리더쉽 발생</h6>
                                
                                <!-- Add Contact Popup Model -->        
                                <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
												<form name="reg_form" action="/admin/deadline/start" method="post" onsubmit="return formCheck();">
                                                    <div class="form-group">
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-2 col-form-label">마감일</label>
															<div class="col-9">
	                                                        	<input type="text" class="form-control popup-date-picker-end" id="count_date" name="count_date" required itemname="이름">
                                        					</div>
                                                        </div>
                                                    </div>
													<div class="modal-footer">
														<input type="submit" class="btn btn-info waves-effect" value="마감하기" id="btn_submit">
                                            		</div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
									<script type="text/javascript">
									function formCheck() 
									{	
										var f = document.reg_form;
   										
   										$("#form").hide();
   										//$(".wait").show();      
   										document.getElementById("btn_submit").disabled = "disabled";
        
   										return true;
									}
									</script>
                                </div>

                                <div class="row">
	                                <div class="col-sm-12 col-md-6">
		                                <div class="dataTables_length">
											<form name='fsearch' method='post' action="<?=SEARCH_URL?>">
											<select class="custom-select col-12" id="inlineFormCustomSelect" style="width: 100px; height: 28px;" id='st' name='st'>
												<option value='regdate' <?if($st == 'regdate'){?>selected<?}?>>날짜</option>
                                    		</select>
											<input type="text" class="form-control form-control-sm" style="width: 200px;" name="sc" value="<?=$search?>">
											<input type="submit" class="btn1 btn-dark" style="height: 28px;" value=" 검색 ">
											</form>
				                        </div>
				                    </div>
				                    <div class="col-sm-12 col-md-6">
					                    <div class="dataTables_filter">
						                    <?$list_per = $this->session->userdata('list_page');?>
			                                <select name="list" class="form-control form-control-sm" onchange="location.href=this.value">
				                                <option value="">0</option>
				                                <option value="/admin/config/page/10/member" <?if($list_per == 10){?>selected<?}?>>10</option>
				                                <option value="/admin/config/page/25/member" <?if($list_per == 25){?>selected<?}?>>25</option>
				                                <option value="/admin/config/page/50/member" <?if($list_per == 50){?>selected<?}?>>50</option>
				                                <option value="/admin/config/page/100/member" <?if($list_per == 100){?>selected<?}?>>100</option>
				                            </select>
						                </div>
						            </div>
						        </div>
								<br>
                                
                                <table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>마감일</th>
                                        <th>매출금액</th>
                                        <th>출금금액</th>
                                        
                                        <th>데일리보너스</th>
                                        <th>데일리매칭보너스</th>
                                        <th>데일리매칭2보너스</th>
                                        <th>직접추천보너스</th>
                                        <th>간접추천보너스</th>
                                        <th>프리미엄보너스</th>
                                        <th>관리</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?
								$i = $total_count;
								foreach ($item as $row) :
									$regdate	=  date("Y-m-d",strtotime($row->regdate));	
									$write_date = date("Y-m-d", strtotime($regdate."+1day")); // 지급일은 다음날
    							?>
                                    <tr>
										<td><?=$i?></th>
										<td><span class="bold">
											<?=substr($row->regdate,0,10)?></span>
										</td>
										<td><?=number_format($row->in_point )?>  </td>
										<td><?=number_format($row->out_point )?>  </td>
										
										<td><?=number_format($row->day_point )?>  </td>
										<td><?=number_format($row->mc_point )?>  </td>
										<td><?=number_format($row->mc2_point )?>  </td>
										<td><?=number_format($row->re_point )?>  </td>
										<td><?=number_format($row->re2_point )?>  </td>
										<td><?=number_format($row->leader_point )?>  </td>
										
										<? if($i == $total_count) { ?>
										<td>
											<a href="javascript:Delete('/admin/deadline/delete', '<?=urlencode($row->order_code)?>');" class="btn btn-secondary footable-delete">
													<span class="fas fa-trash-alt" aria-hidden="true"></span></a>
											<!--<button class="btn1 btn-primary mr-1" style="height: 28px;" ><a href="/admin/excel/deadline/<?=$write_date?>"style="color: #ffffff;">Excel</a></button>-->
										</td>
										<? } else { ?>
										<td>
											<!--<button class="btn1 btn-primary mr-1" style="height: 28px;" ><a href="/admin/excel/deadline/<?=$write_date?>"style="color: #ffffff;">Excel</a></button>-->
										</td>
										<? } ?>
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
<form name='del' method='post'>
<input type='hidden' name='order_code'>
</form>

<script>
function Delete(url, order_code)
{
	var del = document.del;

	if(confirm("수당정보/볼륨정보 모두 삭제 합니다.(복구불가)\n\n정말 삭제 하시겠습니까?")) {
		del.order_code.value 	= order_code;
		del.action				= url;
		del.submit();
	}
}
</script>
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




    <style>
        .wait {
            font-size: 22px;
            display: none;
        }
        .loding {width: 200px; margin: 0 auto}
    </style>


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
    $(document).ready(function() {
        $('#editable-datatable').DataTable();
    });


    </script>

<!--
2019.06.23 ddan
jquery 3.x.x에 따른
datepick 버전 업데이트
-->
<link href="/assets/css/datepick/jquery.datepick.css" rel="stylesheet">
<style>
    .datepick-popup {
        z-index:1500;
    }
</style>

<script type="text/javascript" src="/assets/js/jquery.plugin.js"></script>
<script type="text/javascript" src="/assets/js/jquery.datepick.js"></script>
<script type="text/javascript" src="/assets/js/jquery.datepick-ko.js"></script>
<script type="text/javascript">
    $(function() {

        $('.popup-date-picker-end').datepick();
    });

    function showDate(date) {
        alert('The date chosen is ' + date);
    }
</script>