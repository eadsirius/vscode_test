<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
	<!-- Sidebar scroll-->
	<div class="scroll-sidebar">

		<nav class="sidebar-nav">
			<ul id="sidebarnav">
				<li>
					<a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
						<i class="icon-speedometer"></i><span class="hide-menu">Dashboard </span></a>
					<?if($this->session->userdata('level') > 9){?>
					<ul aria-expanded="false" class="collapse">
						<li><a href="/admin/config">환경설정</a></li>
						
                        <!-- <li><a href="/admin/config/logdate">로그관리</a></li>
                        <li><a href="http://ndpayg.com/data/NDPay_company.pdf">회사소개자료</a></li>
                        <li><a href="http://ndpayg.com/data/NDPay_plan.pdf">마케팅자료</a></li>
                        <li><a href="http://ndpayg.com/data/NDPayManual.pdf">지문인증메뉴얼</a></li> -->
                       
					</ul>
					<?}?>
				</li>
				<hr>
				<!--
				<li>
					<a class="waves-effect waves-dark" href="/admin/center/lists" aria-expanded="false">
						<i class="icon-globe"></i><span class="hide-menu">센터관리</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/admin/center/lists">센터관리</a></li>
                    </ul>
                </li>    
                <hr>
                -->
				<li>
					<a class="waves-effect waves-dark" href="/admin/member/lists" aria-expanded="false">
						<i class="icon-people"></i><span class="hide-menu">회원관리</span></a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="/admin/member/lists">회원관리</a></li>
						<!-- <li><a href="/admin/member/finish">활동중지회원</a></li> -->
						<!-- <li><a href="/admin/member/out">출금중지회원</a></li> -->
						<!-- <li><a href="/admin/member/stop">P2P가능회원</a></li> -->
					</ul>
				</li>
				<hr>

				<li>
					<a class="waves-effect waves-dark" href="/admin/plan/planPoint" aria-expanded="false">
						<i class="icon-user-following"></i><span class="hide-menu">회원별 매출관리</span></a>
				</li>
				<hr>

				<li>
					<a class="waves-effect waves-dark" href="/admin/point/lists" aria-expanded="false">
						<i class="icon-calculator"></i><span class="hide-menu">매출관리</span></a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="/admin/point/lists">매출관리</a></li>
						<li><a href="/admin/point/purchase">매출등록</a></li>
						<li><a href="/admin/point/del_lists">매출 삭제 리스트</a></li>
						<?php if($_SERVER['REMOTE_ADDR'] == "218.52.155.147") {?>
						<?}?>
						<!-- <li><a href="/admin/point/lists"></a></li> -->
						<!-- <li><a href="/admin/point/pointRev">POINT 신청관리</a></li> -->
						<!-- <li><a href="/admin/point/pointSpc">POINT 인정관리</a></li> -->
					</ul>
				</li>
				<hr>

				<li>
					<a class="waves-effect waves-dark" href="/admin/point/pointOut" aria-expanded="false">
						<i class="icon-calculator"></i><span class="hide-menu">출금관리</span></a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="/admin/point/pointOut">수당 출금 관리</a></li>
					</ul>
				</li>
				<hr>

				<li>
					<a class="waves-effect waves-dark" href="/admin/point/su_day" aria-expanded="false">
					<!-- <a class="waves-effect waves-dark" href="javascript:alert('준비중입니다.');" aria-expanded="false"> -->
						<i class="icon-calculator"></i><span class="hide-menu">수당관리</span></a>
					<ul aria-expanded="false" class="collapse">
						<!-- <li><a href="javascript:alert('준비중입니다.');">데일리수당</a></li>
						<li><a href="javascript:alert('준비중입니다.');">추천수당</a></li>
						<li><a href="javascript:alert('준비중입니다.');">직급수당</a></li> -->
						<li><a href="/admin/point/su_day">데일리수당</a></li>
						<li><a href="/admin/point/su_mc">추천매칭수당</a></li>
						<li><a href="/admin/point/su_re">공유수당</a></li>
						<!-- <li><a href="/admin/point/su_mc">추천매칭수당</a></li> -->
						<!-- <li><a href="/admin/point/su_mc2">데일리매칭2수당</a></li> -->
						<!-- <li><a href="/admin/point/su_re">직접추천수당</a></li> -->
						<!-- <li><a href="/admin/point/su_re2">간접추천수당</a></li> -->
						<!-- <li><a href="/admin/point/su_lv">프리미엄 수당</a></li> -->
					</ul>
				</li>
				<!-- <hr> -->

				<li>
					<!-- <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
	                	<i class="fas fa-th-large"></i><span class="hide-menu">코인&지갑관리</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/admin/token/wallet">지갑관리</a></li>
                        <li><a href="/admin/token/wallet2">반품가능</a></li> -->
					<!-- <li><a href="/admin/token/return_wallet">반품리스트</a></li> -->
					<!-- <li><a href="/admin/token/lists">코인내역</a></li>
                        <li><a href="/admin/token/getTransList">코인전송내역</a></li>
                    </ul> -->
				</li>
				<!-- <hr> -->

				<!-- <li> 
                	<a class="waves-effect waves-dark" href="/admin/plan/volume" aria-expanded="false">
	                	<i class="fas fa-th-large"></i><span class="hide-menu">볼륨관리</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/admin/plan/lists">구좌관리</a></li>
                        <li><a href="/admin/plan/volume1">추천볼륨관리</a></li>
                        <li><a href="/admin/plan/volume">후원볼륨관리</a></li>
                    </ul>
                </li> -->
				<hr>

				<li>
					<a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
						<i class="icon-layers"></i><span class="hide-menu">게시판관리</span></a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="/admin/bbs/lists/notice">공지사항</a></li>
						<!--<li><a href="/admin/bbs/lists/qna">일대일문의</a></li>-->
					</ul>
				</li>
				<hr>

				<!-- <?if($this->session->userdata('level') >= 9){?> -->
				<!-- <li> 
                	<a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
	                	<i class="icon-directions"></i><span class="hide-menu">마감관리</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="/admin/deadline/lists">마감관리</a></li>
                    </ul>
                </li>                 -->
				<!-- <hr> -->
				<!-- <?}?> -->

				<li>
					<a class="waves-effect waves-dark" href="/member/login/out" aria-expanded="false">
						<i class="icon-login"></i><span class="hide-menu">로그아웃</span></a></li>
				</li>
			</ul>
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>