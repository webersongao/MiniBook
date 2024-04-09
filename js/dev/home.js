/*
 * jQuery Easing v1.3 - https://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright ?? 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

jQuery.easing['jswing'] = jQuery.easing['swing']; jQuery.extend(jQuery.easing, { def: 'easeOutQuad', swing: function (x, t, b, c, d) { return jQuery.easing[jQuery.easing.def](x, t, b, c, d) }, easeInQuad: function (x, t, b, c, d) { return c * (t /= d) * t + b }, easeOutQuad: function (x, t, b, c, d) { return -c * (t /= d) * (t - 2) + b }, easeInOutQuad: function (x, t, b, c, d) { if ((t /= d / 2) < 1) return c / 2 * t * t + b; return -c / 2 * ((--t) * (t - 2) - 1) + b }, easeInCubic: function (x, t, b, c, d) { return c * (t /= d) * t * t + b }, easeOutCubic: function (x, t, b, c, d) { return c * ((t = t / d - 1) * t * t + 1) + b }, easeInOutCubic: function (x, t, b, c, d) { if ((t /= d / 2) < 1) return c / 2 * t * t * t + b; return c / 2 * ((t -= 2) * t * t + 2) + b }, easeInQuart: function (x, t, b, c, d) { return c * (t /= d) * t * t * t + b }, easeOutQuart: function (x, t, b, c, d) { return -c * ((t = t / d - 1) * t * t * t - 1) + b }, easeInOutQuart: function (x, t, b, c, d) { if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b; return -c / 2 * ((t -= 2) * t * t * t - 2) + b }, easeInQuint: function (x, t, b, c, d) { return c * (t /= d) * t * t * t * t + b }, easeOutQuint: function (x, t, b, c, d) { return c * ((t = t / d - 1) * t * t * t * t + 1) + b }, easeInOutQuint: function (x, t, b, c, d) { if ((t /= d / 2) < 1) return c / 2 * t * t * t * t * t + b; return c / 2 * ((t -= 2) * t * t * t * t + 2) + b }, easeInSine: function (x, t, b, c, d) { return -c * Math.cos(t / d * (Math.PI / 2)) + c + b }, easeOutSine: function (x, t, b, c, d) { return c * Math.sin(t / d * (Math.PI / 2)) + b }, easeInOutSine: function (x, t, b, c, d) { return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b }, easeInExpo: function (x, t, b, c, d) { return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b }, easeOutExpo: function (x, t, b, c, d) { return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b }, easeInOutExpo: function (x, t, b, c, d) { if (t == 0) return b; if (t == d) return b + c; if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b; return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b }, easeInCirc: function (x, t, b, c, d) { return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b }, easeOutCirc: function (x, t, b, c, d) { return c * Math.sqrt(1 - (t = t / d - 1) * t) + b }, easeInOutCirc: function (x, t, b, c, d) { if ((t /= d / 2) < 1) return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b; return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b }, easeInElastic: function (x, t, b, c, d) { var s = 1.70158; var p = 0; var a = c; if (t == 0) return b; if ((t /= d) == 1) return b + c; if (!p) p = d * .3; if (a < Math.abs(c)) { a = c; var s = p / 4 } else var s = p / (2 * Math.PI) * Math.asin(c / a); return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b }, easeOutElastic: function (x, t, b, c, d) { var s = 1.70158; var p = 0; var a = c; if (t == 0) return b; if ((t /= d) == 1) return b + c; if (!p) p = d * .3; if (a < Math.abs(c)) { a = c; var s = p / 4 } else var s = p / (2 * Math.PI) * Math.asin(c / a); return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b }, easeInOutElastic: function (x, t, b, c, d) { var s = 1.70158; var p = 0; var a = c; if (t == 0) return b; if ((t /= d / 2) == 2) return b + c; if (!p) p = d * (.3 * 1.5); if (a < Math.abs(c)) { a = c; var s = p / 4 } else var s = p / (2 * Math.PI) * Math.asin(c / a); if (t < 1) return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b; return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b }, easeInBack: function (x, t, b, c, d, s) { if (s == undefined) s = 1.70158; return c * (t /= d) * t * ((s + 1) * t - s) + b }, easeOutBack: function (x, t, b, c, d, s) { if (s == undefined) s = 1.70158; return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b }, easeInOutBack: function (x, t, b, c, d, s) { if (s == undefined) s = 1.70158; if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b; return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b }, easeInBounce: function (x, t, b, c, d) { return c - jQuery.easing.easeOutBounce(x, d - t, 0, c, d) + b }, easeOutBounce: function (x, t, b, c, d) { if ((t /= d) < (1 / 2.75)) { return c * (7.5625 * t * t) + b } else if (t < (2 / 2.75)) { return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b } else if (t < (2.5 / 2.75)) { return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b } else { return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b } }, easeInOutBounce: function (x, t, b, c, d) { if (t < d / 2) return jQuery.easing.easeInBounce(x, t * 2, 0, c, d) * .5 + b; return jQuery.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * .5 + c * .5 + b } });
/*
 * main function
 *
 *
 */


var page1, page2, page3, page4, page0, pageN1;//标记页面
var num = 1, noclick = 0, ajaxed = false, nopage = false;  //num来记录预加载次数，并设置默认不响应点击
var pageIndex = 0; pageMax = 4;// 起始页面
var pageWidth = 400;
var pageHeight = 500;
var flipTime = 500;
function pageLayout() {
	console.log("page index " + pageIndex);//调试页面
	//console.log( "page Max " + pageMax);//调试页面
	// 初始化
	page1 = $(".pagecontent:eq(" + pageIndex + ")");
	page1.addClass("page1").css("zIndex", 1);

	page2 = $(".pagecontent:eq(" + parseInt(pageIndex + 1) + ")");
	page2.addClass("page2").css(
		{
			"left": pageWidth,
			"zIndex": 3,
			"paddingRight": 0,
			"width": pageWidth
		});
	$('.page1 .pagenum').text(pageIndex + 1);
	$('.page2 .pagenum').text(pageIndex + 2);
	//预加载下一页
	if ((nopage != true) && ($(".pagecontent").length < parseInt(pageIndex + 6)) && (ajaxed != true)) {  //执行Ajax预加载
		num = Math.floor(pageIndex / 4) + 2;
		var type = $("#catname").text();
		$.ajax({
			url: "?action=Ajax_post&" + type + "&page=" + num,  //php段配合，获取当前页后2页的文章列表
			dataType: 'html', contentType: 'application/json; charset=utf-8',
			cache: false,
			beforeSend: function () {
				ajaxed = true;
			},
			success: function (a) {
				if (a.length > 1) {  //如果有返回数据时
					$('#mybook').append(a);
					pageMax = pageMax + 2;
					reload();//页面函数的重载
				} else {  //如果无返回数据时
					//$('#next_page_button').hide(0);  //“下一页”隐藏
					nopage = true;
					pageMax = pageIndex + 2;

				}
				ajaxed = false;
			},
			error: function (a) {
				alert("获取页面出粗 " + a);
				console.log(a);//调试页面
				ajaxed = false;
			}
		});
	}

	if ($(".pagecontent").length > parseInt(pageIndex + 2)) { // 如果存在下一页
		page3 = $(".pagecontent:eq(" + parseInt(pageIndex + 2) + ")");
		page3.addClass("page3").css(
			{
				"left": pageWidth * 2,
				"zIndex": 4,
				"width": 0,
				"marginLeft": 0,
				"paddingLeft": 0
			});

		page4 = $(".pagecontent:eq(" + parseInt(pageIndex + 3) + ")");
		page4.addClass("page4").css({
			"left": pageWidth,
			"zIndex": 2
		});




	} else {
		$('#next_page_button').hide(0);
	}

	//前一页

	if (pageIndex > 1) { // there should be a previous page

		page0 = $(".pagecontent:eq(" + parseInt(pageIndex - 1) + ")");
		page0.addClass("page0").css(
			{
				"left": 0,
				"zIndex": 0

			});

		pageN1 = $(".pagecontent:eq(" + parseInt(pageIndex - 2) + ")");
		pageN1.addClass("pageN1").css(
			{
				"left": 0,
				"zIndex": 0

			});

	}


}
function previousPage() {

	page0.css("zIndex", 6).css("paddingRight", 0);
	page0.children("div:first").css("marginLeft", -1 * pageWidth)
	pageN1.css("zIndex", 5).css("width", 0);


	page0.children("div:first").animate(
		{ marginLeft: 0 }, flipTime - 100
	);

	page0.animate(
		{
			left: pageWidth,
			width: pageWidth,
			paddingRight: 30

		}, {
		duration: flipTime,
		specialEasing: {
			left: "easeInOutQuad",
			width: "easeInOutQuad",
			paddingRight: "linear"
		}
	}
	);

	pageN1.animate(
		{
			width: pageWidth

		}, flipTime, "easeInOutQuad", function () {
			//console.log("Animation complete.");

			page1.removeClass("page1");
			page2.removeClass("page2");
			page3.removeClass("page3");
			page4.removeClass("page4");
			page0.removeClass("page0");
			pageN1.removeClass("pageN1");
			pageIndex -= 2;
			pageLayout();
			$(this).dequeue();
		}
	);


}

function nextPage() {

	// flip to next spread

	page3.animate(
		{
			left: 0,
			width: pageWidth//,
			//	paddingLeft: 40,
			//	marginLeft: -40

			// adjusting the padding/margin to show shadow effects. broken in IE.

		}, {
		duration: flipTime
	}, {
		easing: "easeInOutQuad"
	});

	page2.animate(
		{
			width: 0

		}, flipTime / 2, "easeInOutQuad", function () {
			//console.log("Animation complete.");

			page1.removeClass("page1");
			page2.removeClass("page2");
			page3.removeClass("page3");
			page4.removeClass("page4");
			if (pageIndex > 1) {
				page0.removeClass("page0");
				pageN1.removeClass("pageN1");
			}
			pageIndex += 2;

			pageLayout();
			$(this).dequeue();
		}
	);



}
function next_page_button_click() {
	nextPage();
	$('#prev_page_button:hidden').fadeIn(300);  //如果“上一页”不可见则渐
	//“下一页”隐藏
}

function prev_page_button_click() {

	previousPage();
	if (pageIndex == 2) {  //页码为0时
		//console.log( "上一页 " + pageIndex);//调试页面
		$('#prev_page_button').fadeOut(0); //“上一页”渐隐

	}
	$('#next_page_button:hidden').fadeIn(300);  //如果“下一页”不可见则渐显
}




function reload() {

	//载入中效果
	$('#post-title,.readmore a').click(function (e) {
		e.preventDefault();
		var Url = $(this).attr('href'), Html = '页面载入中', t = $(this).html(Html).unbind('click'), i = 5; ct();
		window.location = Url;
		function ct() {
			(i < 0) ? (i = 5, t.html(Html), ct()) : (t[0].innerHTML += '·', i--, setTimeout(ct, 200));
		};
	});
	// 消除鏈接虛線
	$('a,input[type="submit"],button[type="button"],object').bind('focus', function () { if (this.blur) { this.blur(); } });
}

function book() {
	$('#loading').hide();
	$('#next_page_button').show();
	pageLayout();
	$('#prev_page_button').click(function () {
		if (checkajax()) {
			noclick = 1;
			prev_page_button_click();
			noclick = 0;
		}
		return false;
	});
	$('#next_page_button').click(function () {
		if (checkajax()) {
			noclick = 1;
			next_page_button_click();
			noclick = 0;
		}
		return false;
	});
	$(document).keyup(function (event) {
		if (event.keyCode == 37) {
			if (checkajax()) {
				noclick = 1; prev_page_button_click(); noclick = 0;
			}
		}
		else if (event.keyCode == 39) {
			if (checkajax()) {
				noclick = 1; next_page_button_click(); noclick = 0;
			}
		}
	});
	reload();
	$("#nav li").hover(function () {
		$(this).stop().animate({ marginTop: '-15px' }, 250, 'swing', function () { $(this).css("overflow", "auto"); });
	}, function () {
		$(this).stop().animate({ marginTop: '0' }, 250, 'swing', function () { $(this).css("overflow", "Hidden"); });

	});

}

//ajax状态提醒，防止连续提交
function checkajax() {
	if (noclick > 0) {
		alert('请求已经发出，请等待片刻！\n\n' + '不要重复提交，谢谢！');
		return false;
	}
	return true;
}
jQuery(document).ready(function ($) {
	book();




});//js end