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
                        <h4 class="text-themecolor">그룹관리</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <!--
<ol class="breadcrumb">
     <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
     <li class="breadcrumb-item active">대시보드</li>
</ol>
-->
                            <button type="button" class="btn btn-dark d-none d-lg-block m-l-15" data-toggle="modal" data-target="#add-contact"><i class="fa fa-plus-circle"></i> 그룹추가하기</button></a>
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
                                <h4 class="card-title">그룹관리</h4>
                                <h6 class="card-subtitle">그룹별 소속 지점을 파악하실 수 있습니다.</h6>
                                
                                <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<script type="text/javascript" src="<?=$skin_dir?>/assets/js/register.js?<?=nowdate()?>"></script>
									
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
												<form name="reg_form" action="/admin/center/addGroup" method="post" onsubmit="return formCheck();">
												<input type="hidden" name="member_id_enabled" id="member_id_enabled" value="" >
												<input type="hidden" name="re_id_enabled" id="re_id_enabled" value="" >
                                                    <div class="form-group">    
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-3 col-form-label">접속국가</label>
															<div class="col-8">
																<select  name="country" class="custom-select col-12" required itemname="온라인 접속 국가">
																<option value='USA' >United States</option>
																<option value='ENG' >England</option>
																<option value='CAN' > Canada (Français)</option>
																<option value='JAP' >日本</option>
																<option value='KOR' selected="selected" >대한민국</option>
																<option value='CHA' >中国</option>
																<option value='THA' >ฉันจะจำค</option>
        														</select>
                                        					</div>
                                                        </div>
                                    					                                                    
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-3 col-form-label">그룹명</label>
															<div class="col-8">
	                                                        	<input type="text" class="form-control" id="group_name" name="group_name" required itemname="센타명">
                                        					</div>
                                                        </div>
        												<div class="form-group10 row">
															<label for="example-text-input" class="col-3 col-form-label">그룹장아이디</label>
															<div class="col-8">
	                                                        	<input type="text" class="form-control" name="member_id" id="member_id" required itemname="센타장아이디" onblur='mbcheck();'>
																<div class="reg-error"  id='msg_member_id' class="msg"></div>
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
   										
   										//$("#form").hide();
   										//$(".wait").show();      
   										//document.getElementById("btn_submit").disabled = "disabled";
        
   										return true;
									}
									</script>
                                </div>

                                <div class="row">
	                                <div class="col-sm-12 col-md-6">
		                                <div class="dataTables_length">
											<form name='fsearch' method='post' action="<?=SEARCH_URL?>">
											<select class="custom-select col-12" id="inlineFormCustomSelect" style="width: 100px; height: 28px;" id='st' name='st'>
												<option value='group_name' <?if($st == 'group_name'){?>selected<?}?>>그룹명</option>
												<option value='member_id'  <?if($st == 'member_id'){?>selected<?}?>>그룹장</option>
                                    		</select>
											<input type="text" class="form-control form-control-sm" style="width: 200px;" name="sc" value="<?=$search?>">
											<input type="submit" class="btn1 btn-dark" style="height: 28px;" value=" 검색 ">
											<button type="button" class="btn1 btn-primary" style="height: 28px;"><a href="/admin/excel/group/<?=@$search?>"style="color: #ffffff;">Excel</a></span>
											</form>
				                        </div>
				                    </div>
				                    <div class="col-sm-12 col-md-6">
					                    <div class="dataTables_filter">
						                    <?$list_per = $this->session->userdata('list_page');?>
			                                <select name="list" class="form-control form-control-sm" onchange="location.href=this.value">
				                                <option value="">0</option>
				                                <option value="/admin/config/page/10/group" <?if($list_per == 10){?>selected<?}?>>10</option>
				                                <option value="/admin/config/page/25/group" <?if($list_per == 25){?>selected<?}?>>25</option>
				                                <option value="/admin/config/page/50/group" <?if($list_per == 50){?>selected<?}?>>50</option>
				                                <option value="/admin/config/page/100/group" <?if($list_per == 100){?>selected<?}?>>100</option>
				                            </select>
						                </div>
						            </div>
						        </div>
						        <br>
								
								<table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
                                <thead>
								<colgroup>
									<col width="15%" />
									<col width="10%" />
									<col width="20%" />
									<col width="20%" />
									<col width="20%" />
									<col width="15%" />
								</colgroup>
                                    <tr>
                                        <th>그룹명</th>
                                        <th>그룹장 아이디</th>
                                        <th>그룹장 이름</th>
                                        <th>소속지점 수</th>
                                        <th>소속회원 수</th>
                                        <th>비고</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?
								$i = $total_count;
								foreach ($item as $row) :
    							?>
                                    <tr>
                                        <td><?=$row->group_name?></td>
                                        <td><?=$row->member_id?></td>
                                        <td><?=$row->name?></td>
                                        <td><?=$row->center_count?></td>
                                        <td><?=$row->member_count?></td>
                                        <td>
	                                        <a href="/admin/center/groupWrite/<?=$row->group_no?>" class="btn btn-secondary footable-edit">
		                                        <span class="fas fa-pencil-alt" aria-hidden="true"></span></a>
	                                    </td>
                                    </tr>
								<?
								$i--;
								endforeach
    							?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th><strong>TOTAL</strong></th>
                                        <th></th>
                                        <th></th>
                                        <th><?=$total_center?></th>
                                        <th><?=$total_member?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                </table>
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