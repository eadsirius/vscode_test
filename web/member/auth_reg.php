<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
<!--<script  src="https://code.jquery.com/jquery-1.6.4.min.js"  integrity="sha256-lR1rrjnrFy9XqIvWhvepIc8GD9IfWWSPDSC2qPmPxaU="  crossorigin="anonymous"></script>-->
<script src="https://caligatio.github.io/jsSHA/sha.js"></script>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2><?=get_msg($select_lang, '보안 설정')?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="/"><?=get_msg($select_lang, '홈')?></a>
                    </li>
                    <li>
                        <a><?=get_msg($select_lang, '프로필')?></a>
                    </li>
                    <li class="active">
                        <strong><?=get_msg($select_lang, '보안 설정')?></strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            
            <div class="row animated fadeInRight">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2><?=get_msg($select_lang, '회원 기본 정보')?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal xm">
                                        <dt><?=get_msg($select_lang, '회원 ID')?> :</dt> <dd class="text-primary"><?=$this->session->userdata('member_id')?></dd>
                                        <dt><?=get_msg($select_lang, '이름')?> :</dt> <dd><?=$mb->name?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, 'OTP 인증')?> <small>Step.2</small></h5>
                        </div>
                        <div class="ibox-content">
                            <div class="well">
                                <h2><?=get_msg($select_lang, 'OTP 신청')?></h2>
                                <?=get_msg($select_lang, 'Google Authenticator 앱에서 계정설정 -> 바코드스캔 을 이용하여 바코드를 스캔 하십시오.')?>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <img id="qrImg"  src="" style="display:block; margin:0 auto;" alt="" />
                                    <p class="m-t-md"><?=get_msg($select_lang, '바코드 스캔을 이용할수 없으면 아래키를 입력할 수 있습니다.')?></p>

                                    <form method="get" class="form-horizontal">
                                        <div class="form-group has-success">
                                            <label class="col-sm-2 control-label"><?=get_msg($select_lang, '키')?></label>
											<input type="hidden" size="30" maxlength="20" name="userID" id="userID" value="<?=$mb->member_id?>" class="form-control is-valid state-valid" />	
                                            <div class="col-sm-10"><input type="text" readonly class="form-control" name="secret" id="secret" value="" /></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?=get_msg($select_lang, 'OTP인증번호Step3설명')?></h5>
                        </div>
                        <div class="ibox-content">
                            <div class="text-center p-sm">
                                <h5><?=get_msg($select_lang, 'OTP 업데이트 남은시간')?></h5>
                                <h2 class="m-b-md" style="letter-spacing:0.05em;"><span id='updatingIn'></span> <?=get_msg($select_lang, '초')?></h2>
                                <div class="progress progress-striped active m-b-xs hide">
                                    <div style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="panel panel-success m-b-sm">
                                    <div class="panel-heading">
                                        <?=get_msg($select_lang, '인증번호 입력')?>
                                    </div>
                                    <div class="panel-body">
                                        <p style="font-size:14px; line-height:1.7em; margin-bottom:0;">
                                            <?=get_msg($select_lang, 'OTP 인증앱에 표시된 인증번호 6자리를 입력해 주십시오.')?><br />
                                            <br />
											<form name="reg_form" action="<?=current_url()?>" method="post" onsubmit="return formCheck();" class="form-horizontal">
												<input type="hidden" name="Gotp" id="Gotp" value="" required >		
												<input type="hidden" name="dataType" value="json" />				
                                                <div class="input-group m-b-xxs">
                                                    <input type="text" class="form-control" name="codeValue" id="codeValue" value="" autocomplete="off" maxlength="6" placeholder="<?=get_msg($select_lang, 'OTP 인증번호를 입력하세요')?>"  /> <span class="input-group-btn"> <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <?=get_msg($select_lang, 'OTP 등록')?></button> </span>
                                                 </div>
                                            </form>
                                        </p>
                                    </div>
                                </div>

                                <div class="alert alert-warning alert-dismissable" style="font-size:14px; line-height:1.7em;">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <i class="fa fa-exclamation-triangle"></i> <?=get_msg($select_lang, '한번 실패한 인증번호는 다시 사용할 수 없습니다. 인증번호를 틀렸을 경우, [새로고침] 후 다시 시도하세요.')?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<script>
function formCheck() 
{	
	var f = document.reg_form;

    if (f.codeValue.value == "") {
        alert("Input Code! ");
        f.codeValue.focus();
        return false;
    }
}


function dec2hex(s) { return (s < 15.5 ? '0' : '') + Math.round(s).toString(16); }
function hex2dec(s) { return parseInt(s, 16); }

$(function () {
	
     $('#secret').val(Conversions.base32.encode(leftpad($('#userID').val(),'1','!')));
    updateOtp();

    $('#update').click(function (event) {
      updateOtp();
      event.preventDefault();
    });

    $('#secret').keyup(function () {
      updateOtp();
    });

    $('#userID').keyup(function () {
      console.log(leftpad($('#userID').val(),'1','!'));
      $('#secret').val(Conversions.base32.encode(leftpad($('#userID').val(),'1','!')));
      
      updateOtp();
    });

    setInterval(timer, 1000);
  });

  function leftpad(str, len, pad) {
    if (len + 1 >= str.length) {
      str = Array(len + 1 - str.length).join(pad) + str;
    }
    return str;
  }
  
  function base32tohex(base32) {
    var base32chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
    var bits = "";
    var hex = "";

    for (var i = 0; i < base32.length; i++) {
      var val = base32chars.indexOf(base32.charAt(i).toUpperCase());
      bits += leftpad(val.toString(2), 5, '0');
    }

    for (var i = 0; i + 4 <= bits.length; i += 4) {
      var chunk = bits.substr(i, 4);
      hex = hex + parseInt(chunk, 2).toString(16);
    }
    return hex;

  }

  function updateOtp() {

    var key = base32tohex($('#secret').val());
    var epoch = Math.round(new Date().getTime() / 1000.0);
    var time = leftpad(dec2hex(Math.floor(epoch / 30)), 16, '0');

    // updated for jsSHA v2.0.0 - http://caligatio.github.io/jsSHA/
    var shaObj = new jsSHA("SHA-1", "HEX");
    shaObj.setHMACKey(key, "HEX");
    shaObj.update(time);
    var hmac = shaObj.getHMAC("HEX");

    $('#qrImg').attr('src', 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=200x200&chld=M|0&cht=qr&chl=otpauth://totp/http://wallet.wns.ai//%3Fsecret%3D' + $('#secret').val());
    $('#secretHex').text(key);
    $('#secretHexLength').text((key.length * 4) + ' bits');
    $('#epoch').text(time);
    $('#hmac').empty();

    if (hmac == 'KEY MUST BE IN BYTE INCREMENTS') {
      $('#hmac').append($('<span/>').addClass('label important').append(hmac));
    } else {
      var offset = hex2dec(hmac.substring(hmac.length - 1));
      var part1 = hmac.substr(0, offset * 2);
      var part2 = hmac.substr(offset * 2, 8);
      var part3 = hmac.substr(offset * 2 + 8, hmac.length - offset);
      if (part1.length > 0) $('#hmac').append($('<span/>').addClass('label label-default').append(part1));
      $('#hmac').append($('<span/>').addClass('label label-primary').append(part2));
      if (part3.length > 0) $('#hmac').append($('<span/>').addClass('label label-default').append(part3));
    }

    var otp = (hex2dec(hmac.substr(offset * 2, 8)) & hex2dec('7fffffff')) + '';
    otp = (otp).substr(otp.length - 6, 6);

    //$('#otp').text(otp);
    document.getElementById('Gotp').value = otp;
  }

  function timer() {
    var epoch = Math.round(new Date().getTime() / 1000.0);
    var countDown = 30 - (epoch % 30);
    if (epoch % 30 == 0) updateOtp();
    $('#updatingIn').text(countDown);

  }

  // Note that we assume ascii strings, not unicode.
  // A better implementation should use array buffers
  // of bytes, and force a conversion before executing,
  // and convert outputs back into strings.
  (function(exports) {
      var base32 = {
          a: "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567",
          pad: "",
          encode: function (s) {
              var a = this.a;
              var pad = this.pad;
              var len = s.length;
              var o = "";
              var w, c, r=0, sh=0;
              for(i=0; i<len; i+=5) {
                  // mask top 5 bits
                  c = s.charCodeAt(i);
                  w = 0xf8 & c;
                  o += a.charAt(w>>3);
                  r = 0x07 & c;
                  sh = 2;

                  if ((i+1)<len) {
                      c = s.charCodeAt(i+1);
                      // mask top 2 bits
                      w = 0xc0 & c;
                      o += a.charAt((r<<2) + (w>>6));
                      o += a.charAt( (0x3e & c) >> 1 );
                      r = c & 0x01;
                      sh = 4;
                  }
                  
                  if ((i+2)<len) {
                      c = s.charCodeAt(i+2);
                      // mask top 4 bits
                      w = 0xf0 & c;
                      o += a.charAt((r<<4) + (w>>4));
                      r = 0x0f & c;
                      sh = 1;
                  }

                  if ((i+3)<len) {
                      c = s.charCodeAt(i+3);
                      // mask top 1 bit
                      w = 0x80 & c;
                      o += a.charAt((r<<1) + (w>>7));
                      o += a.charAt((0x7c & c) >> 2);
                      r = 0x03 & c;
                      sh = 3;
                  }

                  if ((i+4)<len) {
                      c = s.charCodeAt(i+4);
                      // mask top 3 bits
                      w = 0xe0 & c;
                      o += a.charAt((r<<3) + (w>>5));
                      o += a.charAt(0x1f & c);
                      r = 0;
                      sh = 0;
                  } 
              }
              // Calculate length of pad by getting the 
              // number of words to reach an 8th octet.
              if (r!=0) { o += a.charAt(r<<sh); }
              var padlen = 8 - (o.length % 8);
              // modulus 
              if (padlen==8) { return o; }
              if (padlen==1) { return o + pad; }
              if (padlen==3) { return o + pad + pad + pad; }
              if (padlen==4) { return o + pad + pad + pad + pad; }
              if (padlen==6) { return o + pad + pad + pad + pad + pad + pad; }
              console.log('there was some kind of error');
              console.log('padlen:'+padlen+' ,r:'+r+' ,sh:'+sh+', w:'+w);
          },
          decode: function(s) {
              var len = s.length;
              var apad = this.a + this.pad;
              var v,x,r=0,bits=0,c,o='';

              s = s.toUpperCase();

              for(i=0;i<len;i+=1) {
                  v = apad.indexOf(s.charAt(i));
                  if (v>=0 && v<32) {
                      x = (x << 5) | v;
                      bits += 5;
                      if (bits >= 8) {
                          c = (x >> (bits - 8)) & 0xff;
                          o = o + String.fromCharCode(c);
                          bits -= 8;
                      }
                  }
              }
              // remaining bits are < 8
              if (bits>0) {
                  c = ((x << (8 - bits)) & 0xff) >> (8 - bits);
                  // Don't append a null terminator.
                  // See the comment at the top about why this sucks.
                  if (c!==0) {
                      o = o + String.fromCharCode(c);
                  }
              }
              return o;
          }
      };

      var base32hex = {
          a: '0123456789ABCDEFGHIJKLMNOPQRSTUV',
          pad: '=',
          encode: base32.encode,
          decode: base32.decode
      };
      exports.base32 = base32;
      exports.base32hex = base32hex;
  })(this.Conversions = {});
  
</script>