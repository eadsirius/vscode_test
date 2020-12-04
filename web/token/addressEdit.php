<?php
$select_lang = 'kr';

defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?=get_msg($select_lang, '거래소WNS주소')?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="/"><?=get_msg($select_lang, '홈')?></a>
			</li>
			<li>
				<a><?=get_msg($select_lang, '프로필')?></a>
			</li>
			<li class="active">
				<strong><?=get_msg($select_lang, '거래소WNS주소')?></strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?=get_msg($select_lang, '거래소 WNS지갑 주소 등록 정보')?></h5>
				</div>
				<div class="ibox-content">

					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-success alert-dismissable">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								<i class="fa fa-check-circle-o"></i> <?=get_msg($select_lang, '당신의 거래소 WNS지갑 주소를 등록하세요')?>
							</div>

							<form id="reg_form" name="reg_form" action="<?=current_url()?>" class="form-horizontal" method="post">
								<input type="hidden" name="wallet_no" id="wallet_no" value="<?=$wallet_no?>">
								<div class="form-group">
									<label class="col-sm-2 control-label"><?=get_msg($select_lang, '거래소 WNS지갑 주소')?></label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="address" id="address" maxlength="42" value="<?=$wallet?>" required />
									</div>
								</div>
								<p style="color: red; font-weight:bold; padding:15px 0 0 30px;">0x로 시작하는 42자리 지갑주소를 입력해 주세요.</p>

								<button id='btn_submit' type="button" class="btn btn-lg btn-block btn-primary m-t-md"><?=get_msg($select_lang, '수정하기')?></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>
<script language="javascript">
  
  $('#btn_submit').click(function(){
    var address = $('#address').val();
    
    if(address == ''){
      alert('지갑주소를 입력하세요.');
      return;
    }
    
    if(address.substr(0,2) != '0x'){
      alert('지갑주소 형식이 잘못됐습니다.');
      return;
    }
    
    if(address.length != 42){
      alert('지갑주소를 전부 입력해주세요.');
      return;
    }
    
    if(address.replace(/ /g,"").length != 42){
      alert('지갑주소에 공백이 들어가 있습니다.');
      return;
    }
    
    $('#reg_form').submit();
  })

//	function formCheck(frm) {
//		if (frm.address.value.indexOf("0x") == -1) {
//			alert("잘못된 주소입니다.");
//			return false;
//			}
//
//		if (frm.address.value == "") {
//			alert("Input Bitcoin Address");
//			frm.rev_id.focus();
//			return false;
//		}
//		return true;
//	}

	function mobileChange() {
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
			url: '/member/sms?mobile=' + $('#type').val() + $('#mobile').val(),
			type: "get",
			dataType: "html",
			success: function (data) {
				console.log(data);
			}
		});

	}

	function send_email() {
		var f = document.reg_form;

		if (f.email.value == "") {
			alert("Please enter your email.");
			f.email.focus();
			return false;
		}

		check(f.email.value);

		var bf = f.email.value.split('@');

		$.ajax({

			url: '/member/qmail/qsend/' + bf[0] + '/' + bf[1],
			type: "get",
			dataType: "html",
			success: function (data) {
				console.log(data);
			}
		});

		alert("Verfiy Email Checked!");

	}

	function check(email) {

		var exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;

		//이메일 형식이 알파벳+숫자@알파벳+숫자.알파벳+숫자 형식이 아닐경우	
		if (exptext.test(email) == false) {

			alert("이 메일형식이 올바르지 않습니다.");

			return false;

		}

	}
</script>

<?if($site->cfg_google_bit == 1){?>
<script>
	function dec2hex(s) {
		return (s < 15.5 ? '0' : '') + Math.round(s).toString(16);
	}

	function hex2dec(s) {
		return parseInt(s, 16);
	}
	$(function () {

		$('#secret').val(Conversions.base32.encode(leftpad($('#userID').val(), '1', '!')));
		updateOtp();

		$('#update').click(function (event) {
			updateOtp();
			event.preventDefault();
		});

		$('#secret').keyup(function () {
			updateOtp();
		});

		$('#userID').keyup(function () {
			console.log(leftpad($('#userID').val(), '1', '!'));
			$('#secret').val(Conversions.base32.encode(leftpad($('#userID').val(), '1', '!')));

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

		$('#qrImg').attr('src',
			'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=200x200&chld=M|0&cht=qr&chl=otpauth://totp/http://questxmining.com/%3Fsecret%3D' +
			$('#secret').val());
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
	(function (exports) {
		var base32 = {
			a: "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567",
			pad: "",
			encode: function (s) {
				var a = this.a;
				var pad = this.pad;
				var len = s.length;
				var o = "";
				var w, c, r = 0,
					sh = 0;
				for (i = 0; i < len; i += 5) {
					// mask top 5 bits
					c = s.charCodeAt(i);
					w = 0xf8 & c;
					o += a.charAt(w >> 3);
					r = 0x07 & c;
					sh = 2;

					if ((i + 1) < len) {
						c = s.charCodeAt(i + 1);
						// mask top 2 bits
						w = 0xc0 & c;
						o += a.charAt((r << 2) + (w >> 6));
						o += a.charAt((0x3e & c) >> 1);
						r = c & 0x01;
						sh = 4;
					}

					if ((i + 2) < len) {
						c = s.charCodeAt(i + 2);
						// mask top 4 bits
						w = 0xf0 & c;
						o += a.charAt((r << 4) + (w >> 4));
						r = 0x0f & c;
						sh = 1;
					}

					if ((i + 3) < len) {
						c = s.charCodeAt(i + 3);
						// mask top 1 bit
						w = 0x80 & c;
						o += a.charAt((r << 1) + (w >> 7));
						o += a.charAt((0x7c & c) >> 2);
						r = 0x03 & c;
						sh = 3;
					}

					if ((i + 4) < len) {
						c = s.charCodeAt(i + 4);
						// mask top 3 bits
						w = 0xe0 & c;
						o += a.charAt((r << 3) + (w >> 5));
						o += a.charAt(0x1f & c);
						r = 0;
						sh = 0;
					}
				}
				// Calculate length of pad by getting the 
				// number of words to reach an 8th octet.
				if (r != 0) {
					o += a.charAt(r << sh);
				}
				var padlen = 8 - (o.length % 8);
				// modulus 
				if (padlen == 8) {
					return o;
				}
				if (padlen == 1) {
					return o + pad;
				}
				if (padlen == 3) {
					return o + pad + pad + pad;
				}
				if (padlen == 4) {
					return o + pad + pad + pad + pad;
				}
				if (padlen == 6) {
					return o + pad + pad + pad + pad + pad + pad;
				}
				console.log('there was some kind of error');
				console.log('padlen:' + padlen + ' ,r:' + r + ' ,sh:' + sh + ', w:' + w);
			},
			decode: function (s) {
				var len = s.length;
				var apad = this.a + this.pad;
				var v, x, r = 0,
					bits = 0,
					c, o = '';

				s = s.toUpperCase();

				for (i = 0; i < len; i += 1) {
					v = apad.indexOf(s.charAt(i));
					if (v >= 0 && v < 32) {
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
				if (bits > 0) {
					c = ((x << (8 - bits)) & 0xff) >> (8 - bits);
					// Don't append a null terminator.
					// See the comment at the top about why this sucks.
					if (c !== 0) {
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