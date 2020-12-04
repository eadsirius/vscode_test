<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
$login_id = $this->session->userdata('member_id');
$login_name =  @$mb->name;
$mem = $this->M_member->get_member_li_dep_side();
//echo $depth;

function re_data ($mem, $member_id, $depth) {
    foreach ($mem as $row) {
        if ($member_id == $row->recommend_id) {
            if($row->sales > 0){
              $percent = ($row->total_point/($row->sales*2))*100;
            }else{
              $percent = 0;
            }
            
            echo 'data.push({ id: "'.$row->member_id.'", parent: "'.$member_id.'", text: "'.$row->member_id.':'.$row->name.' [매출:'.number_format($row->sales).'P] (지급률 '.$percent.'%)", icon : "fa fa-user-circle"';

            if ($depth <= 10) {
                echo ',state: {opened : true}';
            }

            echo '});';

            re_data($mem, $row->member_id, $depth + 1);
        }
    }
}
?>

<link href="/assets/js/plugins/jsTree/style.min.css" rel="stylesheet">
<script src="/assets/js/plugins/jsTree/jstree.min.js"></script>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-12">
    <h2><?=get_msg($select_lang, '추천 계보도')?></h2>
    <ol class="breadcrumb">
      <li>
        <a href="/"><?=get_msg($select_lang, '홈')?></a>
      </li>
      <li>
        <a><?=get_msg($select_lang, '계정')?></a>
      </li>
      <li class="active">
        <a><?=get_msg($select_lang, '추천 계보도')?></a>
      </li>
    </ol>
  </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="ibox" style="background-color:#fff;padding-bottom:20px;">
      <div class="ibox-tools">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="fa fa-cog" style="font-size:18px; color:grey; margin-top:10px;margin-right:15px"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
          <li>
            <a href="#" onclick="$('#OrganizationChartArea').jstree(true).open_all('#'); return false;">전체열기</a>
          </li>
          <li>
            <a href="#" onclick="$('#OrganizationChartArea').jstree(true).close_all('#'); return false;">전체닫기</a>
          </li>
        </ul>
      </div>
      <div id="treeArea" class="ibox-content" style="border: none; padding-top: 0px; padding-left: 10px;padding-bottom: 10px; overflow-y: auto; height: 500px;">
        <div id="OrganizationChartArea"></div>
      </div>
    </div>
  </div>
</div>

<script>
  var data = [];
  data.push({
    "id": "<?=$login_id?>",
    "parent": "#",
    "text": "<?=$login_id.':'.$login_name?> [매출:<?=number_format($user_sales)?>P](지급률 <?=$user_percent?>%)",
    state: {
      opened: true
    },
    icon: "fa fa-user-circle"
  });

  <?=re_data($mem, $login_id, 1)?>

  $('#OrganizationChartArea').jstree({
    'core': {
      'check_callback': function(operation, node, node_parent) {
        if (operation == "move_node" && node.parent == node_parent.id) {
          return true;
        }
        return false;
      },
      'data': data
    }
  });

  $("#treeArea").css("height", $(window).height() - 300);

</script>
