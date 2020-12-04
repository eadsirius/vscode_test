<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$login_id = $this->session->userdata('member_id');
$mem 	= $this->m_member->get_member_li_dep_side();
$bala 	= $this->m_coin->get_balance_list();
$bal 	= $this->m_coin->get_balance_id($select_id);

$select_link_img = '/assets/assets/img/ico_binary2_00.png';
if ($bal->level == 1) {
	$select_link_img = '/assets/assets/img/ico_binary2_01.png';
} else if ($bal->level == 2) {
	$select_link_img = '/assets/assets/img/ico_binary2_02.png';
} else if ($bal->level == 3) {
	$select_link_img = '/assets/assets/img/ico_binary2_03.png';
} else if ($bal->level == 4) {
	$select_link_img = '/assets/assets/img/ico_binary2_04.png';
} else if ($bal->level == 5) {
	$select_link_img = '/assets/assets/img/ico_binary2_05.png';
} else if ($bal->level == 6) {
	$select_link_img = '/assets/assets/img/ico_binary2_06.png';
} else if ($bal->level == 7) {
	$select_link_img = '/assets/assets/img/ico_binary2_07.png';
} else if ($bal->level == 8) {
	$select_link_img = '/assets/assets/img/ico_binary2_08.png';
}

function sp_data ($mem, $bal, $member_id, $select_dept, $valName) 
{
    $view_dept 		= 7;
    $rtn 			= "";
    $count 			= 0;
    $left_check 	= false;
    $right_check 	= false;
    $depth 			= $select_dept;
    
    foreach ($mem as $row) 
    {
        if ($select_dept < $view_dept) 
        {
            if ($member_id == $row->sponsor_id) 
            {
                $volume 			= 0;
                $vlm_left_point 	= 0;
                $vlm_right_point 	= 0;
                $level 				= 0;
				//$depth = $row->dep;

                foreach ($bal as $brow) {
                    if ($row->member_id == $brow->member_id) {
                        $vlm_left_point 	= number_format($brow->vlm_left + $brow->vlm_left_point);
                        $vlm_right_point 	= number_format($brow->vlm_right + $brow->vlm_right_point);
                        $volume = number_format($brow->volume);
                        $level = $brow->level;
                    }
                }

                switch ($level) {
                    case 1  : $link_img = "/assets/img/ico_binary2_01.png";
                        break;
                    case 2  : $link_img = "/assets/img/ico_binary2_02.png";
                        break;
                    case 3  : $link_img = "/assets/img/ico_binary2_03.png";
                        break;
                    case 4  : $link_img = "/assets/img/ico_binary2_04.png";
                        break;
                    case 5  : $link_img = "/assets/img/ico_binary2_05.png";
                        break;
                    case 6  : $link_img = "/assets/img/ico_binary2_06.png";
                        break;
                    case 7  : $link_img = "/assets/img/ico_binary2_07.png";
                        break;
                    case 8  : $link_img = "/assets/img/ico_binary2_08.png";
                        break;
                    default : $link_img = "/assets/img/ico_binary2_00.png";
                        break;
                }

				if ($row->biz == 'right' && $left_check == false) {
			        echo 'data.push({ id: "'.$member_id.'-left", pid: "'.$member_id.'", Name: "left", Level: "", Sales : "", Referral: "", "Left Volume": "", "Right Volume": "", tags: ["add_left"] });';
					$left_check = true;
				}

                echo $valName . '.push({ id: "'.$row->member_id.'", pid: "'.$row->sponsor_id.'", Name: "'.$row->member_id.'", Level: "level '.$level.'", img: "'.$link_img.'", Referral: "'.$row->recommend_id.'", Sales : "'.$volume.'", "Left Volume" : "'.$vlm_left_point.'", "Right Volume" : "'.$vlm_right_point.'"';

				if ($select_dept == ($view_dept - 1)) {
	                echo ', tags: ["addview"]';
				}

                echo '});';

                sp_data($mem, $bal, $row->member_id, $select_dept + 1, $valName);
            }
            if ($right_check == true && $left_check == true) {
                break;
            }
        }

        if ($member_id == $row->sponsor_id && $row->biz == 'right') {
            $right_check = true;
        }
        if ($member_id == $row->sponsor_id && $row->biz == 'left') {
            $left_check = true;
        }
    }

    if ($select_dept < $view_dept && $left_check == false) {
        echo 'data.push({ id: "'.$member_id.'-left", pid: "'.$member_id.'", Name: "left", Level: "", Sales : "", Referral: "", "Left Volume": "", "Right Volume": "", tags: ["add_left"] });';
    }
    if ($select_dept < $view_dept && $right_check == false) {
        echo 'data.push({ id: "'.$member_id.'-right", pid: "'.$member_id.'", Name: "right", Level: "", Sales : "", Referral: "", "Left Volume": "", "Right Volume": "", tags: ["add_right"] });';
    }
}
?>
<script src="/assets/js/orgchart.js"></script>
<div class="row wrapper border-bottom white-bg page-heading">
     <div class="col-lg-12">
        <h2><?=get_msg($select_lang, '팀 Binary')?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="/"><?=get_msg($select_lang, '홈')?></a>
            </li>
            <li>
                <a><?=get_msg($select_lang, '계정')?></a>
            </li>
            <li class="active">
                <a><?=get_msg($select_lang, '팀 Binary')?></a>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-9">
            <div class="ibox">
                <div id="chartArea" class="ibox-content" style="height:600px;">
                    <h2>
					<?=get_msg($select_lang, '바이너리 계정')?>
					<? if ($login_id != $select_id) { ?>
					<button class="btn btn-primary pull-right" type="button" onclick="history.go(-1);">Back</button>
					<? } ?>
					</h2>
					<div class="col-lg-12">
						<div style="width:100%; height:520px;background-color:#fff;" id="orgchart"/>
						<script>
						$("#chartArea").css("height", $(window).height() - 250);
                $("#orgchart").css("height", $(window).height() - 330);

                var data = [];
                data.push({ id: "<?=$select_id?>", Name: "<?=$select_id?>", Level: "level <?=$bal->level?>", img: "<?=$select_link_img?>" });
                <?=sp_data($mem, $bala, $select_id, 1, 'data')?>

                try
                {
                    var chart = new OrgChart(document.getElementById("orgchart"), {
                        template: "ula",
                        nodeMouseClick: OrgChart.action.details,
                        //mouseScrool: OrgChart.action.yScroll,
						mouseScrool: OrgChart.action.zoom,
                        //collapse: {level: 5},
                        nodeBinding: {
                            field_0: "Name",
                            field_1: "Sales",
                            img_0: "img"
                        },
                        nodes: data
                    });

                    chart.on('click', function (sender, node) {
                        /*
                        for (idx in data2) {
                            if (data2[idx].pid == node.id) {
                                chart.addNode(data2[idx]);
                                chart.center(node.id);

                            }
                        }
                        */
                        if (node.tags && node.tags[0] == "addview") {
                            location.href = "/office/account/binary/" + node.id;
                        }

                        if (node.tags && node.tags[0] == "add_left") {
                            location.href = "/office/account/binary/left/" + node.pid;
                        }

                        if (node.tags && node.tags[0] == "add_right") {
                            location.href = "/office/account/binary/right/" + node.pid;
                        }

                        /*
                        if (node.Name == "left") {

                        } else if (node.Name == "right") {

                        }
                        */
                    });
                }
                catch (e)
                {
                    alert(e.message);
                }

            </script>
        </div>
    </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, '판매 색상 표시')?></h5>
                        </div>
                        <div id="helpArea" class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12 col-xs-6 m-h-xs m-b-md">
                                    <img class="img-rounded img-sm m-r-md pull-left" style="width:40px !important; height:auto; margin-top:4px; margin-left:15px;" src="/assets/img/ico_binary_01.png" alt="" />
                                    <div class="">
                                        <label class="m-b-xs">PACKAGE1</label><br />
                                        <span class="label label-muted">$150 <?=get_msg($select_lang, '구매')?></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xs-6 m-h-xs m-b-md">
                                    <img class="img-rounded img-sm m-r-md pull-left" style="width:40px !important; height:auto; margin-top:4px; margin-left:15px;" src="/assets/img/ico_binary_02.png" alt="" />
                                    <div class="">
                                        <label class="m-b-xs">PACKAGE2</label><br />
                                        <span class="label label-muted">$450 <?=get_msg($select_lang, '구매')?></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xs-6 m-h-xs m-b-md">
                                    <img class="img-rounded img-sm m-r-md pull-left" style="width:40px !important; height:auto; margin-top:4px; margin-left:15px;" src="/assets/img/ico_binary_03.png" alt="" />
                                    <div class="">
                                        <label class="m-b-xs">PACKAGE3</label><br />
                                        <span class="label label-muted">$750 <?=get_msg($select_lang, '구매')?></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xs-6 m-h-xs m-b-md">
                                    <img class="img-rounded img-sm m-r-md pull-left" style="width:40px !important; height:auto; margin-top:4px; margin-left:15px;" src="/assets/img/ico_binary_04.png" alt="" />
                                    <div class="">
                                        <label class="m-b-xs">PACKAGE4</label><br />
                                        <span class="label label-muted">$1,500 <?=get_msg($select_lang, '구매')?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<style>
/*
  [link-id] path {
        stroke: #750000;
    }
*/
/*
    [node-id] rect {
        stroke: green;
    }
*/
</style>
<script>
    $("#helpArea").css("height", $("#chartArea").height() - 10);
</script>