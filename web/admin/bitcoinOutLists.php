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
                                <h4 class="card-title"><?=$title?> | 총건수  <?=$total_count?>건</h4>
                                <h6 class="card-subtitle">수당을 개인 지갑으로 이동한 내역을 파악하실 수 있습니다.</h6>
                                
                                <div class="row">
	                                <div class="col-sm-12 col-md-6">
		                                <div class="dataTables_length">
											<form name='fsearch' method='post' action="<?=SEARCH_URL?>">
											<select class="custom-select col-12" id="inlineFormCustomSelect" style="width: 100px; height: 28px;" id='st' name='st'>
												<option value='member_id' <?if($st == 'member_id'){?>selected<?}?>>아이디</option>
                                    		</select>
											<input type="text" class="form-control form-control-sm" style="width: 200px;" name="sc" value="<?=$search?>">
											
											날짜 : <input type="text" class="form-control form-control-sm" style="width: 120px;" name="sdate" value="<?=$nowday?>"> -
											<input type="text" class="form-control form-control-sm" style="width: 120px;" name="edate" value="<?=$nowday?>">
											
											<input type="submit" class="btn1 btn-dark" style="height: 28px;" value=" 검색 ">
											<button type="button" class="btn1 btn-primary" style="height: 28px;"><a href="/admin/excel/pointEx"style="color: #ffffff;">Excel</a></span>
											</form>
				                        </div>
				                    </div>
				                    <div class="col-sm-12 col-md-6">
					                    <div class="dataTables_filter">
						                    <?$list_per = $this->session->userdata('list_page');?>
			                                <select name="list" class="form-control form-control-sm" onchange="location.href=this.value">
				                                <option value="">0</option>
				                                <option value="/admin/config/page/10/point" <?if($list_per == 10){?>selected<?}?>>10</option>
				                                <option value="/admin/config/page/25/point" <?if($list_per == 25){?>selected<?}?>>25</option>
				                                <option value="/admin/config/page/50/point" <?if($list_per == 50){?>selected<?}?>>50</option>
				                                <option value="/admin/config/page/100/point" <?if($list_per == 100){?>selected<?}?>>100</option>
				                            </select>
						                </div>
						            </div>
						        </div>						        
								<br>
                                
                                <table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <!--<th>센터</th>-->
                                        <th>아이디</th>
                                        <th>출금지갑주소</th>
                                        <th>신청수량</th>
                                        <th>수수료</th>
                                        <th>실제출금수량</th>
                                        <th>처리상태</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?
								$i = $total_count;
								foreach ($item as $row) :
    							?>
                                    <tr>
										<!--<td><?=$row->office?></td>-->
										<td><span class="bold"><?=$row->member_id?></span></td>
										<td><?=@$row->app_address?></td>
										<td><?=number_format($row->app_count*-1,4)?></td>
										<td><?=number_format($row->fee,4)?></td>
										<td><?=number_format($row->all_count*-1,4)?></td>
										<td><?=$row->flgs?></td>
										<td><?=$row->regdate?></td>
										<td>
	                                    <?if($this->session->userdata('level') > 9){?>
	                                        <a href="/admin/point/bitcoinOut_write/<?=$row->coin_no?>/<?=$table?>" class="btn btn-secondary footable-edit">
		                                        <span class="fas fa-pencil-alt" aria-hidden="true"></span></a>		                                        
										<?}?>
	                                    <?if($this->session->userdata('level') > 9){?>
											<a href="/admin/point/delete/<?=$row->coin_no?>/<?=$table?>" class="btn btn-secondary footable-delete">
												<span class="fas fa-trash-alt" aria-hidden="true"></span></a>		                                        
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
    $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
    $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
    $(document).ready(function() {
        $('#editable-datatable').DataTable();
    });
    </script>