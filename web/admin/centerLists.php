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
                        <h4 class="text-themecolor">센타관리</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <!--
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
     <li class="breadcrumb-item active">대시보드</li>
</ol>
-->
                            <button type="button" class="btn btn-dark d-none d-lg-block m-l-15" data-toggle="modal" data-target="#add-contact"><i class="fa fa-plus-circle"></i> 센타추가하기</button>
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
                                <h4 class="card-title">센타관리</h4>
                                <h6 class="card-subtitle">센타정보를 파악하실 수 있습니다.</h6>
                                
                                <!-- Add Contact Popup Model -->        
                                <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	                                
								<script type="text/javascript" src="<?=$skin_dir?>/assets/js/register.js?<?=nowdate()?>"></script>
									
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
												<form name="reg_form" action="/admin/center/addCenter" method="post" onsubmit="return formCheck();">
												<input type="hidden" name="member_id_enabled" id="member_id_enabled" value="" >
												<input type="hidden" name="re_id_enabled" id="re_id_enabled" value="" >
                                                    <div class="form-group">
                                    					                                                    
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-3 col-form-label">센타명</label>
															<div class="col-8">
	                                                        	<input type="text" class="form-control" id="office" name="office" required itemname="센타명">
                                        					</div>
                                                        </div>
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-3 col-form-label">센타장아이디</label>
															<div class="col-8">
	                                                        	<input type="text" class="form-control" name="member_id" id="member_id" required itemname="센타장아이디" onblur='mbcheck();'>
																<div class="reg-error"  id='msg_member_id' class="msg"></div>
                                        					</div>
                                                        </div>
                                                        <!--
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-3 col-form-label">센타추천인</label>
															<div class="col-8">
	                                                        	<input type="text" class="form-control" name="recommend_id" id='recommend_id' required onblur='recheck();'>
																<a href="#" onClick="javascript:window.open('/admin/popreg/repop','popup','scrollbars=yes, resizable=no, width=600,height=600')"> 
																<div class="reg-error"  id='msg_re_id' class="msg"></div>
																<span class="blue">이름으로 찾기</span> </a>
                                        					</div>
                                                        </div>
                                                        -->
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-3 col-form-label">센타연락처</label>
															<div class="col-8">
	                                                        	<input type="text" class="form-control" name="mobile" id="mobile" required itemname="센타연락처">
                                        					</div>
                                                        </div>
                                                        
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-3 col-form-label">센타FAX</label>
															<div class="col-8">
	                                                        	<input type="text" class="form-control" name="fax" id="fax" itemname="센타FAX">
                                        					</div>
                                                        </div>
                                                        
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-3 col-form-label">센타주소지</label>
															<div class="col-8">
	                                                        	<input type="text" class="form-control" name="addr1" id="addr1" itemname="센타주소지">
                                        					</div>
                                                        </div>
                                                    </div>
													<div class="modal-footer">
														<input type="submit" class="btn btn-info waves-effect" value="등록하기" id="btn_submit">
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

										// 회원아이디 검사
										mbcheck();
										if (document.getElementById('member_id_enabled').value != '000') {
											alert('아이디를 입력하세요');
											document.getElementById('member_id').select();
											return false;
										}
										
										/*
										recheck();        
										if (document.getElementById('re_id_enabled').value != '000') {
											alert('추천인 아이디를 입력하세요');
											document.getElementById('recommend_id').select();
											return false;
   										}
   										*/
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
												<option value='office_recommend_id'  <?if($st == 'office_recommend_id'){?>selected<?}?>>센터소개인</option>
												<option value='member_id'  <?if($st == 'member_id'){?>selected<?}?>>센터장</option>
												<option value='office'  <?if($st == 'office'){?>selected<?}?>>센터명</option>
                                    		</select>
											<input type="text" class="form-control form-control-sm" style="width: 200px;" name="sc" value="<?=$search?>">
											<input type="submit" class="btn1 btn-dark" style="height: 28px;" value=" 검색 ">
											<button type="button" class="btn1 btn-primary" style="height: 28px;"><a href="/admin/excel/center/<?=@$search?>"style="color: #ffffff;">Excel</a></span>
											</form>
				                        </div>
				                    </div>
				                    <div class="col-sm-12 col-md-6">
					                    <div class="dataTables_filter">
						                    <?$list_per = $this->session->userdata('list_page');?>
			                                <select name="list" class="form-control form-control-sm" onchange="location.href=this.value">
				                                <option value="">0</option>
				                                <option value="/admin/config/page/10/center" <?if($list_per == 10){?>selected<?}?>>10</option>
				                                <option value="/admin/config/page/25/center" <?if($list_per == 25){?>selected<?}?>>25</option>
				                                <option value="/admin/config/page/50/center" <?if($list_per == 50){?>selected<?}?>>50</option>
				                                <option value="/admin/config/page/100/center" <?if($list_per == 100){?>selected<?}?>>100</option>
				                            </select>
						                </div>
						            </div>
						        </div>
						        <br>
						        <table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>센타명</th>
                                        <th>센타장 아이디</th>
                                        <th>센타장 이름</th>
                                        <th>센타장 연락처</th>
                                        <th>소속 회원수</th>
                                        <th>비고</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?
								$i = $total_count;
								foreach ($item as $row) :
    							?>
                                    <tr>
                                        <td><?=$row->office?></td>
                                        <td><?=$row->member_id?></td>
                                        <td><?=$row->name?></td>
                                        <td><?=$row->mobile?></td>
                                        <td><?=$row->member_cnt?></td>
                                        <td>
	                                        <a href="/admin/center/write/<?=$row->center_no?>" class="btn btn-secondary footable-edit">
		                                        <span class="fas fa-pencil-alt" aria-hidden="true"></span></a>
	                                    </td>
                                    </tr>
								<?
								$i--;
								endforeach
    							?>
                                </tbody>
                                </table>
								<div id="pages"><?=PAGE_URL?></div>
								<br><br>
								* 센타를 검색하신 후에 엑셀버튼을 누르시면 센타 소속의 회원들 정보가 다운됩니다<br>
								* 센타 검색 없이 엑셀 버튼을 누르시면 센타 리스트가 다운됩니다.<br>
								* 센타 추가하실 경우 센타 추천인이 없는 경우 admin을 입력하세요.
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
    $(document).ready(function() {
        $('#editable-datatable').DataTable();
    });
    </script>