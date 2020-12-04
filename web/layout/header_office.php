<?
$select_lang = 'kr';
$menu01 = array("office/start");
$menu02 = array("office/account", "office/account/matrixRe", "member/register_add", "member/register_reg", "office/matrixRecommend");
$menu03 = array("office/purchase", "office/purchase/lists", "office/purchase_update", "office/purchase_recyle", "/office/purchase_ok", "office/purchase_send");
$menu04 = array("office/allowance");
$menu05 = array("office/withdraw", "office/withdraw_list", "office/withdraw_send", "/office/pointOut_exOk", "office/bitcoin", "/office/bitcoin_exOk1", "/office/bitcoin_exOk2", "/office/bitcoin_exOk3", "office/bitcoinlists");
$menu06 = array("token/address", "token/exchange");
$menu07 = array("/member/profile", "/member/setting", "token/addressReg", "/member/auth", "token/addressEdit", "/member/auth_reg");
$menu08 = array("/bbs/lists/notice");
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>WINNERS</title>

  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <link href="/assets/img/logo.png" rel="shortcut icon" type="image/x-icon" />

  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="/assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

  <link href="/assets/css/animate.css" rel="stylesheet">
  <link href="/assets/css/style.css?<?= nowdate() ?>" rel="stylesheet">
  <link href="/assets/css/custom.css?<?= nowdate() ?>" rel="stylesheet">
  <script src="/assets/js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="/assets/js/common.js?<?= today() ?>"></script>
  <script type="text/javascript" src="/assets/js/lang_<?= $select_lang ?>.js?<?= today() ?>"></script>
</head>
<style>
  p , span {font-size: 16px;}
</style>
<body>
  <script>
    var fnSelectLang = function(sel_lang) {
      Common.FnCookies("lang", sel_lang, 365);
      history.go(0);
    }
    //alert('<?= $common_page_url ?>');
  </script>
  <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
          <li class="nav-header">
            <div class="dropdown profile-element">
              <span><img alt="XMINING" class="logo-main" src="/assets/img/logo.png" /></span>
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= @$mb->name ?></strong>
                  </span> <span class="text-muted text-xs block"><?= @$this->session->userdata('member_id') ?>
                  <!--<?= $mb->mobile ?>--> <b class="caret"></b></span> </span>
                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">가입일: <?=date("Y-m-d H:i:s",strtotime(@$mb->regdate." +9 hours"))?></strong>
              </a>
              <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><a href="/member/profile"><?= get_msg($select_lang, '설정') ?></a></li>
                <li><a href="/office/account/lists"><?= get_msg($select_lang, '계정') ?></a></li>
                <li class="divider"></li>
                <li><a href="/member/login/out"><?= get_msg($select_lang, '로그아웃') ?></a></li>
              </ul>
            </div>
            <div class="logo-element">
              <img alt="" class="logo-main" src="/assets/img/logo.png" />
            </div>
          </li>
          <li class="<? if (in_array($layout_name, $menu01)) { echo('active'); } ?>">
            <a href="/"><i class="fa fa-tachometer"></i> <span class="nav-label"><?= get_msg($select_lang, '대시보드') ?></span></a>
          </li>

          <li class="<? if (in_array($layout_name, $menu02)) { echo('active'); } ?>">
            <a href="#"><i class="fa fa-user-circle"></i> <span class="nav-label"><?= get_msg($select_lang, '계정관리') ?></span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
              <li class="<? if ($common_page_url == 'office/account/lists') { echo('active'); } ?>">
                <a href="/office/account/lists"><?= get_msg($select_lang, '계정 정보') ?></a>
              </li>
              <!--
              <li class="<? if ($layout_name == 'office/matrixSp' || $layout_name == 'member/register_reg') { echo('active'); } ?>">
              <a href="#" onclick="window.open('/views/solo/matrix_member_sp.php?id=<?= $this->session->userdata('member_id') ?>&auth=<?= md5($this->session->userdata('member_id')) ?>', '_blank', 'width=1200,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0');"class="slide-item"><?= get_msg($select_lang, '팀 Binary') ?></a></li>
              
              <li class="<? if ($layout_name == 'office/matrixSp' || $layout_name == 'member/register_reg') { echo('active'); } ?>">
              <a href="/office/account/binary"><?= get_msg($select_lang, '팀 Binary') ?></a></li>
              -->
              <li class="<? if ($layout_name == 'office/account/matrixRe') { echo('active'); } ?>"><a href="/office/account/matrixRe"><?= get_msg($select_lang, '추천 계보도') ?></a></li>
              <!-- <li class="<? if ($common_page_url == 'member/invite') { echo('active'); } ?>"><a href="/member/invite"><?= get_msg($select_lang, '직추천 가입') ?></a></li> -->
            </ul>
          </li>

          <li class="<? if (in_array($layout_name, $menu03)) { echo('active'); } ?>">
            <a href="#"><i class="fa fa-usd"></i> <span class="nav-label"><?= get_msg($select_lang, '매출관리') ?></span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">

              <li class="<? if ($common_page_url == 'office/purchase' ) { echo('active'); } ?>">
                <a href="/office/purchase"><?= get_msg($select_lang, '매출하기') ?></a>
              </li>
              <li class="<? if ($common_page_url == 'office/purchase/lists') { echo('active'); } ?>">
                <a href="/office/purchase/lists"><?= get_msg($select_lang, '매출내역') ?></a>
              </li>
            </ul>
          </li>

          <li class="<? if (in_array($layout_name, $menu04) || $layout_name == 'office/total_day') { echo('active'); } ?>">
            <a href="#"><i class="fa fa-line-chart"></i> <span class="nav-label"><?= get_msg($select_lang, '수당관리') ?></span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
              <li class="<? if ($common_page_url == 'office/allowance/day') { echo('active'); } ?>">
                <a href="/office/allowance/day"><?= get_msg($select_lang, 'Daily 수당') ?></a></li>

              <li class="<? if ($common_page_url == 'office/allowance/mc' ) { echo('active'); } ?>">
                <a href="/office/allowance/mc"><?= get_msg($select_lang, '추천 매칭 수당 ') ?></a></li>
              <li class="<? if ($common_page_url == 'office/allowance/re') { echo('active'); } ?>">
              <a href="/office/allowance/re"><?= get_msg($select_lang, '공유 수당') ?></a></li>
							<li class="<? if ($common_page_url == 'office/allowance/totaldaysu') { echo('active'); } ?>">
								<a href="/office/allowance/totaldaysu"><?=get_msg($select_lang, '일일 수당 합계')?></a>
							</li>
            </ul>
          </li>

          <li class="<? if (in_array($layout_name, $menu05)) { echo('active'); } ?>">
            <a href="#"><i class="fa fa-refresh"></i> <span class="nav-label"><?= get_msg($select_lang, '출금관리') ?></span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
              <li class="<? if ($common_page_url == 'office/withdraw') { echo('active'); } ?>"><a href="/office/withdraw"><?= get_msg($select_lang, '출금신청') ?></a></li>
              <li class="<? if ($common_page_url == 'office/withdraw/lists') { echo('active'); } ?>"><a href="/office/withdraw/lists"><?= get_msg($select_lang, '출금내역') ?></a></li>
            </ul>
          </li>

          <li class="<? if (in_array($layout_name, $menu06) || ($common_page_url == 'token/address' && $this->input->post('kindout') <> 'A') || ($common_page_url == 'token/exchange' && $this->input->post('kindout') <> 'A')) { echo('active'); } ?>">
            <a href="#"><i class="fa fa-address-book-o"></i> <span class="nav-label"><?= get_msg($select_lang, '지갑관리') ?></span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">

<!--
              <li class="<? if ($common_page_url == 'token/address') { echo('active'); } ?>">
                <a href="/token/address"><?= get_msg($select_lang, '내지갑 주소') ?></a></li>
-->
              <li class="<? if ($common_page_url == 'token/exchange') { echo('active'); } ?>">
                <a href="/token/exchange"><?= get_msg($select_lang, '출금 지갑주소') ?></a></li>
            </ul>
          </li>

          <li class="<? if (in_array($layout_name, $menu07)) { echo('active'); } ?>">
            <a href="#"><i class="fa fa-id-card"></i> <span class="nav-label"><?= get_msg($select_lang, '프로필관리') ?></span> <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
              <li class="<? if ($common_page_url == 'member/profile' || $common_page_url == 'member/profile/auth' || $common_page_url == 'member/profile/authReg') { echo('active'); } ?>">
                <a href="/member/profile"><?= get_msg($select_lang, '사용자 정보') ?></a></li>

<!--
              <li class="<? if ($common_page_url == 'member/profile/setting') { echo('active'); } ?>">
                <a href="/member/profile/setting"><?= get_msg($select_lang, '보안 설정') ?></a></li>
-->
            </ul>
          </li>

          <li class="<? if (in_array($layout_name, $menu08)) { echo('active'); } ?>">
            <a href="/bbs/lists/notice"><i class="fa fa-volume-up"></i> <span class="nav-label"><?= get_msg($select_lang, '공지사항') ?></span> </a>
          </li>

          <? if($mb->level > 9 ) { ?>
          <li>
            <a href="/admin"><i class="fa fa-unlock-alt"></i> <span class="nav-label"><?= get_msg($select_lang, '관리자페이지') ?></span></a>
          </li>
          <? } ?>
        </ul>
      </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
      <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom:0">
          <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>
          </div>
          <ul class="nav navbar-top-links navbar-right">
            <li>
              <a href="#">
                <i class="fa fa-user-circle"></i> <strong><?= @$this->session->userdata('member_id') ?></strong>
              </a>
            </li>
            <li class="dropdown">
              <!-- <?
                            if ($select_lang == "us") {
                        ?>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img alt="Korea" src="/assets/img/lang/ico_lang_en.png"> English <b class="caret"></b>
                            </a>
                        <?
                            } else if ($select_lang == "kr") {
                        ?>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img alt="Korea" src="/assets/img/lang/ico_lang_ko.png"> Korea <b class="caret"></b>
                            </a>
                        <?
                            } else if ($select_lang == "cn") {
                        ?>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img alt="Korea" src="/assets/img/lang/ico_lang_cn.png"> China <b class="caret"></b>
                            </a>
                        <?
                            } else if ($select_lang == "jp") {
                        ?>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img alt="Korea" src="/assets/img/lang/ico_lang_jp.png"> Japan <b class="caret"></b>
                            </a>
                        <?
                            }
                        ?> -->
              <!-- <ul class="dropdown-menu animated fadeInRight m-t-xs pull-right">
                                <li><a href="#" onclick="fnSelectLang('us');return false;"><img alt="English" class="" src="/assets/img/lang/ico_lang_en.png"> <strong>English</strong></a></li>
                                <li><a href="#" onclick="fnSelectLang('kr');return false;"><img alt="Korea" class="" src="/assets/img/lang/ico_lang_ko.png"> <strong>Korea</strong></a></li>
                                <li><a href="#" onclick="fnSelectLang('cn');return false;"><img alt="China" class="" src="/assets/img/lang/ico_lang_cn.png"> <strong>China</strong></a></li>
                                <li><a href="#" onclick="fnSelectLang('jp');return false;"><img alt="China" class="" src="/assets/img/lang/ico_lang_jp.png"> <strong>Japan</strong></a></li>
                            </ul> -->
            </li>
            <li>
              <a href="/member/login/out"><i class="fa fa-sign-out"></i> <?= get_msg($select_lang, '로그아웃') ?></a>
            </li>
          </ul>

        </nav>
      </div>