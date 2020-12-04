<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>UPS</title>
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	
	<link href="/assets/css/style.css" rel="stylesheet">
	<script src="/assets/js/jquery-3.1.1.min.js"></script>
	<script>
		function useState(member_id,gubn,url){
			if(member_id=="")
			{
				return;
			}
			console.log(url);
			$.post(url, { "member_id": member_id, "gubn":gubn },  function(data){
				if (data.status !="200")
				{
					alert(data.message);
				}else{
					alert('확인처리되었습니다.');
					location.reload();
				}
				console.log(data.status);
			}, "json");  
		}

	// function hcn_click() {
	// 	$('.hcn_click').hide();
	// 	$('.hcn_com').show();
	// }
	// function moca_click() {
	// 	$('.hcn_click').hide();
	// 	$('.hcn_com').show();
	// }

</script>
	<style>
		.clear {
			content: '';
			display: block;
			clear: both;
		}
	
		table th {
			text-align: center;
		}
		table tbody tr {
			color : #333;
			background: white;
		}
		table tbody tr td:first-child{
			background: #ddd;
		}
		.hcn_com, .moca_com {
			display: none;
		}
		.display_none {
			display: none;
		}
		.tx_right{
			text-align: right;
		}
		.tx_center{
			text-align: center;
		}
	</style>
</head>
<body>
	<section style="width:95%; margin:0 auto;"  >
		<div class="tb_top clear" style="margin-top: 100px;">
				<table class="table table-bordered" style="float:right; width:30%; color: black; text-align:center;">
				<colgroup>
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
				</colgroup>
					<thead>
						<tr>
							<th>전체</th>
							<th>HCN 미확인</th>
							<th>HCN 확인</th>
							<th>MOCA 미확인</th>
							<th>MOCA 확인</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?=$chkyn->member_count?></td>
							<td><?=$chkyn->chn?></td>
							<td><?=$chkyn->chy?></td>
							<td><?=$chkyn->mcn?></td>
							<td><?=$chkyn->mcy?></td>
						</tr>
					</tbody>
				</table>
	
		</div>
		<table class="table table-bordered" style="margin: 40px auto; width:100%; color: black;">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>가입일</th>
					<th>매출 합</th>
					<th>첫매출일자</th>
					<th>방출일</th>
					<th>데일리수당 일수</th>
					<th>데일리수당</th>
					<th>추천인 수</th>
					<th>내하위1대 매출합</th>
					<th>내하위2대 매출합</th>
					<th>추천수당 1대 합</th>
					<th>추천수당 2대 합</th>
					<th>추천매칭 1대 합</th>
					<th>추천매칭 2대 합</th>
					<th>총수당</th>
					<th>총출금액</th>
					<th>사용가능 SVP</th>
					<th>HCN</th>
					<th>Moca</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php
					$i=0;
					$page = $input["page"];
					$size = $input["size"];
					$num = $total_count - (($page -1) * $size);
					if(!empty($list)){
					foreach($list as $row) {
					?>
					<td class="tx_center"><?=$num--;?></td>
					<td class="tx_center"><?=$row->member_id?></td>
					<td class="tx_right"><?=$row->regdate?></td>
					<td class="tx_right"><?=number_format($row->point)?></td>
					<td class="tx_right"><?=$row->basic_date?></td>
					<td class="tx_right"><?=$row->appdate?></td>
					<td class="tx_right"><?=$row->elapsed_date?></td>
					<td class="tx_right"><?=number_format($row->su_day)?></td>
					<td class="tx_right"><?=$row->re_cnt?></td>
					<td class="tx_right"><?=number_format($row->basic_re_sum)?></td>
					<td class="tx_right"><?=number_format($row->basic_re2_sum)?></td>
					<td class="tx_right"><?=number_format($row->su_re)?></td>
					<td class="tx_right"><?=number_format($row->su_re2)?></td>
					<td class="tx_right"><?=number_format($row->su_mc)?></td>
					<td class="tx_right"><?=number_format($row->su_mc2)?></td>
					<td class="tx_right"><?=number_format($row->sum_basic)?></td>
					<td class="tx_right"><?=number_format($row->total_point)?></td>
					<td class="tx_right"><?=number_format($row->basic_using_svp)?></td>
					<td class="tx_center">
						<?php if($row->check_hcn =="N"){?>
							<button class="" onclick="useState('<?=$row->member_id?>','hcn','/member/checkmoca/state')">미확인</button>
						<?}ELSE{?>
						<span style="color:red">확인완료</span>
						<?}?>
					</td>
					<td class="tx_center">
					<?php if($row->check_moca =="N"){?>
						<button class="" onclick="useState('<?=$row->member_id?>','hcn','/member/checkmoca/state')">미확인</button>
					<?}ELSE{?>
						<span style="color:red">확인완료</span>
					<?}?>
					</td>
				</tr>
				<? }
				}else{?>
					<tr>
						<td colspan="18" class="text-center">내역 없음</td>
					</tr>
				<?}?>
			</tbody>
		</table>
		<tfoot>
				<tr>
					<td colspan="18">
						<ul class="pagination" style="margin-top:10px">
							<?php 
							if((!empty($list))) {
								paging("/member/complate",$total_count,$page,$size,"");
							}?>
						</ul>
					</td>
				</tr>
			</tfoot>
	</section>
</body>
</body>
</html>