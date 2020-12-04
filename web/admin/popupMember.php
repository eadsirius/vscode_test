<?=$this->load->view('admin/layout/windowHead')?>

<SCRIPT LANGUAGE="JavaScript">
<!--
function sendopener(a,b,c,d,e) {

    //opener.document.form.name.value = a;
    window.opener.document.getElementById("send_id").value = a;

     self.close();
}
/*
// 추천인 산하 두명으로 제한할 경우 추가
function sendopener2() {
	alert("직계회원이 2명이 존재합니다.");
	return;
}
*/
//-->
</SCRIPT>

<? echo form_open(current_url(), array('name' => 'member_pop'));?>

<table id="write">
<colgroup></colgroup>
<tbody>
<tr>
	<td>
		<input type="text" name="name" STYLE="ime-mode:active;" required itemname="이름" value=""> <input type="submit" class="btn_01" value="검색하기" id="btn_submit">
	</td>
</tr>
</table>

</form>


<table id="list">
<colgroup></colgroup>
<tbody>

<? if (@$item)  { ?>
<? foreach ($item as $row) { ?>
<tr>
	<td>
		<h3><a href="javascript:sendopener('<?=$row->member_id?>');"> <span class="blue"><?=$row->name?></span> | <?=$row->member_id?>  </a></h3>
	</td>
</tr>
<? } ?>
<? } ?>
</table>




<?=$this->load->view('admin/layout/windowFoot')?>