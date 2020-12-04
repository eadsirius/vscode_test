<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
$lang = get_cookie('lang'); 
?>
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-12">
				<h2><?=get_msg($select_lang, '출금')?></h2>
				<ol class="breadcrumb">
					<li>
						<a href="/"><?=get_msg($select_lang, '홈')?></a>
					</li>
					<li>
						<a><?=get_msg($select_lang, '출금')?></a>
					</li>
					<li class="active">
						<strong><?=get_msg($select_lang, '출금')?></strong>
					</li>
				</ol>
			</div>
		</div>
		<div class="wrapper wrapper-content animated fadeInRight">
			
			<div class="row m-b-lg m-t-md">
				<div class="col-md-12">

					<div class="profile-image text-center">
						<i class="fa fa-exchange fa-5x"></i>
					</div>
					<div class="profile-info">
						<div class="">
							<div>
								<h2 class="no-margins">
									<?=get_msg($select_lang, '출금 내역')?>
								</h2>
								<table class="table m-t-md m-b-xs">
									<tbody>
										<tr>
											<td><strong><?=get_msg($select_lang, '수당 총액')?> :</strong> <span class="font-bold text-primary"><?=number_format($bal->total_point,0)?> P</span></td>
											<td><strong><?=get_msg($select_lang, '총 출금 P')?> :</strong> <?=number_format($bal->Withdrawn_point,0)?> P</td>
											<td><strong><?=get_msg($select_lang, '총 출금 신청 P')?> :</strong> <?=number_format($bal->withdraw_point,0)?> P</td>
											<td><strong><?=get_msg($select_lang, '출금가능 P')?> :</strong> <?=number_format($bal->total_point-$bal->withdraw_point,0)?> P
									</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5><?=get_msg($select_lang, '출금 신청')?></h5>
						</div>
						<div class="ibox-content">

							<div class="row">
								<div class="col-lg-12">
									<div class="alert alert-success alert-dismissable">
										<?$msg = ' Point를 출금하면 WPC로 자동전환되어 출금됩니다. 인출 수수료는' .$site->cfg_send_persent*100 .'% 입니다.';?>
										<?$msg1 = '최소 출금금액은' .number_format($site->cfg_send_point) .'P 입니다.';?>
										<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
										<i class="fa fa-check-circle-o"></i> <?=get_msg($select_lang, $msg)?><br>
										<i class="fa fa-check-circle-o"></i> <?=get_msg($select_lang, $msg1)?>
									</div>
									<form name="reg_form" action="/office/withdraw/send" method="post" onsubmit="return formCheck();" class="form-horizontal">
										<input type="hidden" name="confing" id="confing" value="<?=$conf?>">
										<input type="hidden" name="USNS_USD" id="USNS_USD" value="<?=$USNS_USD?>">
										<input type="hidden" name="USNS_WON" id="USNS_WON" value="<?=$USNS_WON?>">
										<input type="hidden" name="POINT_WON" id="POINT_WON" value="<?=$site->cfg_point_won?>">
										
										<div class="form-group">
											<label class="col-sm-2 control-label"><?=get_msg($select_lang, '출금 가능 P')?></label>
											<div class="col-sm-10">
												<select class="form-control m-b" name="price" id="price">
													<option value="<?=$bal->total_point-$bal->withdraw_point?>"><?=number_format($bal->total_point-$bal->withdraw_point,0)?></option>
												</select>
											</div>
										</div>
										<hr class="hr-line-dashed" />
										<div class="form-group has-error">
											<label class="col-sm-2 control-label"><?=get_msg($select_lang, '최소 출금액')?></label>
											<div class="col-sm-10">
												<input type="text" disabled class="form-control" name="limit" id="limit" value="<?=number_format($site->cfg_send_point)?>" readonly >
											</div>
										</div>
										<hr class="hr-line-dashed" />
										<div class="form-group has-success">
											<label class="col-sm-2 control-label"><?=get_msg($select_lang, '출금신청 P')?></label>
											<div class="col-sm-10">
												<input type="number" class="form-control" name="count" id="count" required onkeypress="givenfees()" onkeyup="givenfees()">
											</div>
										</div>
										<hr class="hr-line-dashed" />
										<div class="form-group has-error">
											<label class="col-sm-2 control-label"><?=get_msg($select_lang, '출금 수수료 비용')?></label>
											<div class="col-sm-10">
												<input type="hidden" name="point" id="point" value="<?=$bal->total_point-$bal->withdraw_point?>" >
												<input type="hidden" name="fee" id="fee" value="<?=$fee?>" >
												<input type="text" class="form-control" name="fee_view" id="fee_view" value="<?=$fee_view?>%" readonly>
											</div>
										</div>
										
										<hr class="hr-line-dashed" />
										<div class="form-group">
											<label class="col-sm-2 control-label"><?=get_msg($select_lang, '실 출금 원화')?></label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="amount" id="amount" required readonly >
											</div>
										</div>
										
										<hr class="hr-line-dashed" />
										<div class="form-group has-success">
											<label class="col-sm-2 control-label"><?=get_msg($select_lang, '출금 지갑주소')?></label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="address" id="address" value="<?=@$wallet?>" required >
											</div>
										</div>

										<hr class="hr-line-dashed" />
										<?if($conf == 'p'){?>
										<div class="form-group has-success">
											<label class="col-sm-2 control-label"><?=get_msg($select_lang, '출금비밀번호')?></label>
											<div class="col-sm-10">
												<input type="password" class="form-control" name="password" id="password" required >
											</div>
										</div>
										<!--
										<?if($mb->mobile == ''){header('Location: /member/profile');}?>
											<input type="hidden" name="type" id="type" value="<?=$mb->country?>">	
											<input type="hidden" name="country" id="country" value="<?=$mb->country?>">	
											<input type="hidden" name="mobile" id="mobile" value="<?=$mb->mobile?>" required>		

											<div class="form-group">
												<div class="col-sm-10 col-sm-offset-2">
													<div class="input-group m-b-sm">
														<input type="text" class="form-control" name="mobile1" id="mobile1" placeholder="mobile number" value="<?=$mb->mobile?>" readonly required /> <span class="input-group-btn"> <button type="button" class="btn btn-primary" onclick="send_sms()"><i class="fa fa-check"></i> <?=get_msg($select_lang, '문자발송')?></button> </span>
													</div>
													<input type="text" class="form-control" name="authcode" id="authcode" maxlength="6" required placeholder="<?=get_msg($select_lang, '문자 인증번호')?>" />
												</div>
											</div>
										-->
										<?} else if($conf == 'g'){?>		
											<!--<script  src="https://code.jquery.com/jquery-1.6.4.min.js"  integrity="sha256-lR1rrjnrFy9XqIvWhvepIc8GD9IfWWSPDSC2qPmPxaU="  crossorigin="anonymous"></script>-->
											<script src="https://caligatio.github.io/jsSHA/sha.js"></script>				

											<div class="form-group">
												<label class="col-sm-2 control-label">Google Code</label>
												<div class="col-sm-10">
													<input type="text" name="codeValue" id="codeValue" value="" autocomplete="off" maxlength="6" placeholder="OTP Code" class="form-control"/>
													<input type="hidden" size="30" maxlength="20" name="userID" id="userID" value="<?=$mb->member_id?>"/>
													<input type="hidden" size="30" name="secret" id="secret" />
													<input type="hidden" name="Gotp" id="Gotp" value="" required >
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-10 col-sm-offset-2">
													<div class="input-group m-b-sm">
														OTP Updating in - <span id='updatingIn'></span> sec
													</div>
												</div>
											</div>
										<?}?>
										<br>
										<button type="submit" id="btn_submit" class="btn btn-lg btn-block btn-primary m-t-md"><?=get_msg($select_lang, '출금신청')?></button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>

<script type="text/javascript">
function formCheck(frm) 
{	
	var frm = document.reg_form;
	
	var count = Number(frm.count.value);
	var limit = Number(frm.limit.value);
	
	if (frm.count.value == "") {
		alert('Please enter a withdrawal amount!');
		frm.count.focus();
		return false;
	}
	
	if (count < limit) {
		alert('Please check the minimum withdrawal amount');
		frm.count.focus();
		return false;
	}
	
	if (frm.point.value > frm.count) {
		alert('Check your balance.');
		frm.count.focus();
		return false;
	}
	
	if (frm.address.value == "") {
		alert('Enter your Bitcoin address!');
		frm.count.focus();
		return false;
	}
	
	$("#form").hide();
	//$(".wait").show();      
	document.getElementById("btn_submit").disabled = "disabled";
	return true;
}
function feeChange() 
{    
	document.getElementById('count').value = "";
	document.getElementById('fee').value = "";
	document.getElementById('amount').value = "";
}

function givenfees()
{    	
	var USNS_USD = document.getElementById('USNS_USD').value;
	var USNS_WON = document.getElementById('USNS_WON').value;
	var POINT_WON = document.getElementById('POINT_WON').value;
	
	var price 	= document.getElementById('price').value;
	var fee 	= document.getElementById('fee').value;
	var count 	= document.getElementById('count').value;
	
	var persent = fee * count;
	console.log(POINT_WON);
	var amount = (count - persent) * 10 / POINT_WON;
	console.log(amount);
	
	//document.getElementById('fee').value = fee;
	document.getElementById('amount').value = amount.toFixed(0);	
	
}

<?if($conf == 'p'){?>
function mobileChange() 
{
	var frm = document.reg_form;
	
	var e = $("#country option:selected").val();
	
	
	frm.type.value = e;
}

function send_sms() {
	var f = document.reg_form;

	if (f.mobile.value == "") {
		alert("Please enter your cell phone number.");
		f.mobile.focus();
		return false;
	}

	if (f.country.value == "") {
		alert("Please select a country");
		f.country.focus();
		return false;
	}
		
	$.ajax({	    
		url:'/member/sms?mobile=' + $('#type').val() + $('#mobile').val(),
		type: "get",
		dataType:"html",
		success: function(data){
			console.log(data);
		}
	});
	
	alert(Common.Lang['Verfiy SMS!']);

}
<?}?>
</script>

<?if($conf == 'g'){?>	
<script>
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

	$('#qrImg').attr('src', 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=200x200&chld=M|0&cht=qr&chl=otpauth://totp/http://questxmining.com/%3Fsecret%3D' + $('#secret').val());
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
<?}?>