
/*
$(function(){
	$('#bbb').jrumble({
		speed: 50,
		opacity: true,
		opacityMin: .75
	});
	$('#bbb').trigger('startRumble');
});
 */

$(function(){

	var siteurl = window.location.origin;

	var OriginTitile = document.title;
	var titleTime;
	document.addEventListener('visibilitychange', function() {
		if (document.hidden) {
			document.title = 'QuQ憋走啊 ! ! ! ' + OriginTitile;
			clearTimeout(titleTime);
		}else {
			document.title = '卧槽，大污逼回来了~ ' + OriginTitile;
			titleTime = setTimeout(function() {
				document.title = OriginTitile;
			}, 3500);
		}
	});

	$('#is-an').click(function(){
		var is = $('input[name="is"]');
		var a = $('input[name="from"]');
		var b = $('#from');
		var c = $('#is-an span[name="is-icon"]');
		var d = $('#is-an span[name="is-info"]');
		if(parseInt(is.attr('value'))) {
			$(this).attr('class','button margin-bottom bg-dot');
			a.attr('value','');
			c.attr('class','icon-question-circle');
			d.text('你想匿名发给Ta吗?');
			is.attr('value','0');
			b.show();
		}else {
			b.hide();
			$(this).attr('class','button margin-bottom bg-main');
			a.attr('value','匿名');
			c.attr('class','icon-check');
			d.text('匿名发给Ta吧');
			is.attr('value','1');
		}
	});

	$('#is-hide').click(function(){
		var is = $('input[name="hide"]');
		var c = $('#is-hide span[name="is-icon"]');
		var d = $('#is-hide span[name="is-info"]');
		if(parseInt(is.attr('value'))) {
			$(this).attr('class','button bg-dot');
			c.attr('class','icon-question-circle');
			d.text('你想隐藏内容和Ta的名字吗?');
			is.attr('value','0');
		}else {
			$(this).attr('class','button bg-main');
			c.attr('class','icon-check');
			d.text('隐藏内容让Ta猜猜看~');
			is.attr('value','1');
		}
	});

	if(!sessionStorage.hide) sessionStorage.hide='';
	$('#u a.vindication').each(function(a, b) {
		var e = $(b);
		var m = e.children('.v-main');
		var h = m.data('hide');
		var i = e.find('.input');
		var s = sessionStorage.hide.split(',');
		var len = s.length;
		for (var x=0; x<len; x++) {
			if(s[x] === h.m) {
				e.attr('href','p.php?bid='+decodeStr(h.m));
				e.find('.v-header .form-inline').hide();
				e.find('strong.to').text(decodeStr(h.k));
				m.find('strong.from').text(decodeStr(h.j));
				return;
			}
		}
		var bool;
		$(this).find('.button').click(function() {
			if( (i.val() !== '') ) {
				//console.log(encodeStr(i.val()) + ' --- ' +h.j );
				if(encodeStr(i.val()) === h.j) {
					alert('猜对了，确定后 1 秒跳转详情...');
					sessionStorage.hide += h.m+',';
					setTimeout(function(){window.location.href="p.php?bid="+decodeStr(h.m)},3000)
				}else {
					alert('猜错了呀，再来一次？');
					i.val('').focus()
				}
			}else {
				alert('不输入Ta的名字怎么猜？');
			}
		});
		$(this).click(function() {
			//if(!$('#u > a:nth-child(9) > div.bg-3.text-dot.v-main').data('hide').a) {console.log(1)}else {console.log(0)}
            console.log(decodeStr(h.a));
			if(Number(decodeStr(h.a))) {
				console.log('隐藏');
			}else {
				console.log('没隐藏');
				sessionStorage.hide += h.m+',';
			}
		})
	});

	$.each($('#vindication div.vindication'), function(a ,b) {
		var e = $(b);
		var m = e.children('.v-main');
		var h = m.data('hide');
		var i = e.find('.input');
		var s = sessionStorage.hide.split(',');
		var len = s.length;

		for (var x=0; x<len; x++) {
			console.log();
			console.log(s[x]);

			if(s[x] === h.m) {
				e.find('.v-header .form-inline').hide();
				e.find('strong.to').text(decodeStr(h.k));
				m.find('strong.from').text(decodeStr(h.j));
				m.find('strong.tel').text(decodeStr(h.t));
				$('title').text(decodeStr(h.j)+'想对'+decodeStr(h.k)+'说...    - 表白墙 - 想大声说爱你');
				return;
			}else {
				if(Number(decodeStr(h.a))) {
					e.find('.v-header .form-inline').show();
					e.find('strong.to').text(decodeStr(h.k).substr(0,1)+'*');
					m.find('strong.from').text(decodeStr(h.j).substr(0,1)+'**('+decodeStr(h.j).length+'个字哟');
					m.find('strong.tel').text(decodeStr(h.t));
					$('title').text('***想对***说...    - 表白墙 - 想大声说爱你');
				}else {
					e.find('.v-header .form-inline').hide();
					e.find('strong.to').text(decodeStr(h.k));
					m.find('strong.from').text(decodeStr(h.j));
					m.find('strong.tel').text(decodeStr(h.t));
					$('title').text(decodeStr(h.j)+'想对'+decodeStr(h.k)+'说...    - 表白墙 - 想大声说爱你');
				}
			}
		}

		$(this).find('.button').click(function() {
			if( (i.val() !== '') ) {
				//console.log(encodeStr(i.val()) + ' --- ' +h.j );
				if(encodeStr(i.val()) === h.j) {
					//var a = sessionStorage.hide.split(',');
					var bool;
					$.each(sessionStorage.hide.split(','), function(a ,b) {
						if(b === getQueryString('bid')) {
							bool = true;
							return;
						}else {
							bool = false
						}
					})

					if(!bool) sessionStorage.hide += h.m+',';
					alert('真腻害呀，猜对了');
					e.find('.v-header .form-inline').hide();
					e.find('strong.to').text(decodeStr(h.k));
					m.find('strong.from').text(decodeStr(h.j));
					m.find('strong.tel').text(decodeStr(h.t));
				}else {
					alert('猜错了呀，再来一次？');
					i.val('').focus()
				}
			}else {
				alert('不输入Ta的名字怎么猜？')
			}

		})
	});

	if(Number(sessionStorage.success)) {success(sessionStorage.Uri)};

	$('#alert-success  a[class="view"]').click(function(){alertSuccess()});

	$('#share').click(function(){
			$('#mcover').css('display','block');
			alertSuccess()
		})
	});

	function alertSuccess() {
		$('#alert-success').hide();
		sessionStorage.success = 0
	}
	function success(url) {
		var html = '<div id="alert-success" class="alert alert-green"><span class="close rotate-hover"></span><strong>发表成功，<a class="view" href="p.php?bid=' + url + '">点击查看你的表白</a> </strong></div>';
		$("#success").prepend(html);
	}
	function getQueryString(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
		var r = window.location.search.substr(1).match(reg);
		if (r != null) return unescape(r[2]); return null;
	}

	function encodeStr(str) {
		var b = new Base64();
		var base64Str = b.encode(str);
		return base64Str;
	}
	function decodeStr(base64Str) {
		var b = new Base64();
		var str = b.decode(base64Str);
		return str;
	}
function Base64() {
	_keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	this.encode = function(input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;
		input = _utf8_encode(input);
		while (i < input.length) {
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);
			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;
			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}
			output = output + _keyStr.charAt(enc1) + _keyStr.charAt(enc2) + _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
		}
		return output;
	}

	this.decode = function(input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
		while (i < input.length) {
			enc1 = _keyStr.indexOf(input.charAt(i++));
			enc2 = _keyStr.indexOf(input.charAt(i++));
			enc3 = _keyStr.indexOf(input.charAt(i++));
			enc4 = _keyStr.indexOf(input.charAt(i++));
			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;
			output = output + String.fromCharCode(chr1);
			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}
		}
		output = _utf8_decode(output);
		return output;
	}

	_utf8_encode = function(string) {
		string = string.replace(/\r\n/g, "\n");
		var utftext = "";
		for ( var n = 0; n < string.length; n++) {
			var c = string.charCodeAt(n);
			if (c < 128) {
				utftext += String.fromCharCode(c);
			} else if ((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			} else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}

		}
		return utftext;
	}

	_utf8_decode = function(utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
		while (i < utftext.length) {
			c = utftext.charCodeAt(i);
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			} else if ((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i + 1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			} else {
				c2 = utftext.charCodeAt(i + 1);
				c3 = utftext.charCodeAt(i + 2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
		}
		return string;
	}
}
