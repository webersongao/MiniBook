(function ($) {
	$.tiny = $.tiny || {}; $.tiny.scrollbar = { options: { axis: 'y', wheel: 40, scroll: true, size: 'auto', sizethumb: 'auto' } }; $.fn.tinyscrollbar = function (options) { var options = $.extend({}, $.tiny.scrollbar.options, options); this.each(function () { $(this).data('tsb', new Scrollbar($(this), options)); }); return this; }; $.fn.tinyscrollbar_update = function (sScroll) { return $(this).data('tsb').update(sScroll); }; function Scrollbar(root, options) {
		var oSelf = this; var oWrapper = root; var oViewport = { obj: $('.viewport', root) }; var oContent = { obj: $('.overview', root) }; var oScrollbar = { obj: $('.scrollbar', root) }; var oTrack = { obj: $('.track', oScrollbar.obj) }; var oThumb = { obj: $('.thumb', oScrollbar.obj) }; var sAxis = options.axis == 'x', sDirection = sAxis ? 'left' : 'top', sSize = sAxis ? 'Width' : 'Height'; var iScroll, iPosition = { start: 0, now: 0 }, iMouse = {}; function initialize() { oSelf.update(); setEvents(); return oSelf; }
		this.update = function (sScroll) { oViewport[options.axis] = oViewport.obj[0]['offset' + sSize]; oContent[options.axis] = oContent.obj[0]['scroll' + sSize]; oContent.ratio = oViewport[options.axis] / oContent[options.axis]; oScrollbar.obj.toggleClass('disable', oContent.ratio >= 1); oTrack[options.axis] = options.size == 'auto' ? oViewport[options.axis] : options.size; oThumb[options.axis] = Math.min(oTrack[options.axis], Math.max(0, (options.sizethumb == 'auto' ? (oTrack[options.axis] * oContent.ratio) : options.sizethumb))); oScrollbar.ratio = options.sizethumb == 'auto' ? (oContent[options.axis] / oTrack[options.axis]) : (oContent[options.axis] - oViewport[options.axis]) / (oTrack[options.axis] - oThumb[options.axis]); iScroll = (sScroll == 'relative' && oContent.ratio <= 1) ? Math.min((oContent[options.axis] - oViewport[options.axis]), Math.max(0, iScroll)) : 0; iScroll = (sScroll == 'bottom' && oContent.ratio <= 1) ? (oContent[options.axis] - oViewport[options.axis]) : isNaN(parseInt(sScroll)) ? iScroll : parseInt(sScroll); setSize(); }; function setSize() { oThumb.obj.css(sDirection, iScroll / oScrollbar.ratio); oContent.obj.css(sDirection, -iScroll); iMouse['start'] = oThumb.obj.offset()[sDirection]; var sCssSize = sSize.toLowerCase(); oScrollbar.obj.css(sCssSize, oTrack[options.axis]); oTrack.obj.css(sCssSize, oTrack[options.axis]); oThumb.obj.css(sCssSize, oThumb[options.axis]); }; function setEvents() {
			oThumb.obj.bind('mousedown', start); oThumb.obj[0].ontouchstart = function (oEvent) { oEvent.preventDefault(); oThumb.obj.unbind('mousedown'); start(oEvent.touches[0]); return false; }; oTrack.obj.bind('mouseup', drag); if (options.scroll && this.addEventListener) { oWrapper[0].addEventListener('DOMMouseScroll', wheel, false); oWrapper[0].addEventListener('mousewheel', wheel, false); }
			else if (options.scroll) { oWrapper[0].onmousewheel = wheel; }
		}; function start(oEvent) { iMouse.start = sAxis ? oEvent.pageX : oEvent.pageY; var oThumbDir = parseInt(oThumb.obj.css(sDirection)); iPosition.start = oThumbDir == 'auto' ? 0 : oThumbDir; $(document).bind('mousemove', drag); document.ontouchmove = function (oEvent) { $(document).unbind('mousemove'); drag(oEvent.touches[0]); }; $(document).bind('mouseup', end); oThumb.obj.bind('mouseup', end); oThumb.obj[0].ontouchend = document.ontouchend = function (oEvent) { $(document).unbind('mouseup'); oThumb.obj.unbind('mouseup'); end(oEvent.touches[0]); }; return false; }; function wheel(oEvent) { if (!(oContent.ratio >= 1)) { oEvent = $.event.fix(oEvent || window.event); var iDelta = oEvent.wheelDelta ? oEvent.wheelDelta / 120 : -oEvent.detail / 3; iScroll -= iDelta * options.wheel; iScroll = Math.min((oContent[options.axis] - oViewport[options.axis]), Math.max(0, iScroll)); oThumb.obj.css(sDirection, iScroll / oScrollbar.ratio); oContent.obj.css(sDirection, -iScroll); oEvent.preventDefault(); }; }; function end(oEvent) { $(document).unbind('mousemove', drag); $(document).unbind('mouseup', end); oThumb.obj.unbind('mouseup', end); document.ontouchmove = oThumb.obj[0].ontouchend = document.ontouchend = null; return false; }; function drag(oEvent) {
			if (!(oContent.ratio >= 1)) { iPosition.now = Math.min((oTrack[options.axis] - oThumb[options.axis]), Math.max(0, (iPosition.start + ((sAxis ? oEvent.pageX : oEvent.pageY) - iMouse.start)))); iScroll = iPosition.now * oScrollbar.ratio; oContent.obj.css(sDirection, -iScroll); oThumb.obj.css(sDirection, iPosition.now); }
			return false;
		}; return initialize();
	};
})(jQuery);

function abookscroll() {
	$(".entry,#thecomments").tinyscrollbar();



}
var commentjs = function () {
	$('#toolBar').animate({ opacity: 'show' }, 400);
	$.getScript(themeurl + "js/comment.js");
	$('#comment').unbind('focus', commentjs);//取消绑定focus的动作
}

var gravatarjs = function () {
	$.getScript(themeurl + "js/realgravatar.js");
	$('#email').unbind('focus', gravatarjs);//取消绑定focus的动作
}

function getParamsOfShareWindow(width, height) {
	return ['toolbar=0,status=0,resizable=1,width=' + width + ',height=' + height + ',left=', (screen.width - width) / 2, ',top=', (screen.height - height) / 2].join('');
}
function bindShareList() {
	var link = encodeURIComponent(document.location);
	var title = encodeURIComponent(document.title.substring(0, 76));
	var source = encodeURIComponent('网站名称');
	var windowName = 'share';
	var site = base;
	jQuery('#twitter-share').click(function () {
		var url = 'https://twitter.com/share?url=' + link + '&text=' + title;
		var params = getParamsOfShareWindow(500, 375);
		window.open(url, windowName, params)
	});
	jQuery('#fanfou-share').click(function () {
		var url = 'https://fanfou.com/sharer?u=' + link + '?t=' + title;
		var params = getParamsOfShareWindow(600, 400); window.open(url, windowName, params);
	});
	jQuery('#kaixin001-share').click(function () {
		var url = 'https://www.kaixin001.com/repaste/share.php?rurl=' + link + '&rcontent=' + link + '&rtitle=' + title;
		var params = getParamsOfShareWindow(540, 342);
		window.open(url, windowName, params)
	});
	jQuery('#renren-share').click(function () {
		var url = 'https://share.renren.com/share/buttonshare?link=' + link + '&title=' + title;
		var params = getParamsOfShareWindow(626, 436);
		window.open(url, windowName, params)
	});
	jQuery('#douban-share').click(function () {
		var url = 'https://www.douban.com/recommend/?url=' + link + '&title=' + title;
		var params = getParamsOfShareWindow(450, 350);
		window.open(url, windowName, params)
	});
	jQuery('#sina-share').click(function () {
		var url = 'https://v.t.sina.com.cn/share/share.php?url=' + link + '&title=' + title;
		var params = getParamsOfShareWindow(607, 523);
		window.open(url, windowName, params)
	});
	jQuery('#netease-share').click(function () {
		var url = 'https://t.163.com/article/user/checkLogin.do?link=' + link + 'source=' + source + '&info=' + title + ' ' + link;
		var params = getParamsOfShareWindow(642, 468);
		window.open(url, windowName, params)
	});
	jQuery('#tencent-share').click(function () {
		var url = 'https://v.t.qq.com/share/share.php?title=' + title + '&url=' + link + '&site=' + site;
		var params = getParamsOfShareWindow(634, 668);
		window.open(url, windowName, params)
	})
}
function abooksingleinit() {
	$(".post h1 a,#nav a,.cate a").click(function () {
		$('#loading').fadeIn('slow');
	});
	$('.pagecontent,#next_page_button,#prev_page_button').show();
	if ($('#next_page_button').html() == '') { $('#next_page_button').hide(); }
	if ($('#prev_page_button').html() == '') { $('#prev_page_button').hide(); }

	// 消除鏈接虛線
	$('a,input[type="submit"],button[type="button"],object').bind('focus', function () { if (this.blur) { this.blur(); } });
	$('.tg_t').click(function () { $(this).next('.tg_c').slideToggle(400); $(".entry").tinyscrollbar_update('relative'); });

	//限制图片大小
	$('.entry img,.comment-body img').each(function () {
		var maxWidth, maxHeight;    // 图片最大高宽
		if (($(window).width() >= 1280) && ($(window).height() >= 799)) {
			maxWidth = 450; maxHeight = 560;
		} else {
			maxWidth = 350; maxHeight = 360;
		}
		var ratio = 0;  // 缩放比例
		var width = $(this).width();    // 图片实际宽度
		var height = $(this).height();  // 图片实际高度

		// 检查图片是否超宽
		if (width > maxWidth) {
			ratio = maxWidth / width;   // 计算缩放比例
			$(this).css("width", maxWidth); // 设定实际显示宽度
			height = height * ratio;    // 计算等比例缩放后的高度 
			$(this).css("height", height);  // 设定等比例缩放后的高度
		}

		// 检查图片是否超高
		if (height > maxHeight) {
			ratio = maxHeight / height; // 计算缩放比例
			$(this).css("height", maxHeight);   // 设定实际显示高度
			width = width * ratio;    // 计算等比例缩放后的高度
			$(this).css("width", width);    // 设定等比例缩放后的高度
		}
	});
	abookscroll();

	bindShareList();
	$('#comment_header li').click(function () {
		$(this).addClass("comment_switch_active").siblings().removeClass();
		$("#comment_content > div").hide(400).eq($('#comment_header li').index(this)).show(500);
		return false;
	});
	$('.com_num').click(function () {
		$('#add_comment').addClass("comment_switch_active").siblings().removeClass();
		$("#comment_content > div").hide(400).eq(0).show(500);
		$("#comment_parent").attr("value", '0');
		$("#comment").attr("value", '').focus();
		return false;
	});


	$('#comment').bind('focus', commentjs);
	$('#email').bind('focus', gravatarjs);

	//	profile change
	$("#edit_profile").toggle(function () {
		$("#welcome_msg").slideUp(200);
		$("#guest_info").slideDown(200);
		$("#edit_profile").html(' (改好了吧~)')
		return false;
	},
		function () {
			$("#welcome_msg").slideDown(200);
			$("#guest_info").slideUp(200);
			$("#edit_profile").html(' (再改一次？)')
			return false;
		})

	var $s = $('.entry'), lb = $s.find('a:has(img)');
	if (lb.length) {
		$.getScript(themeurl + "js/slimbox.js", function () {
			$(".entry a[href]").filter(function () {
				return /\.(jpg|png|gif)$/i.test(this.href);
			}).slimbox({}, null, function (el) {
				return (this == el) || (this.parentNode && (this.parentNode == el.parentNode));
			});
		});
	}
	$(".entry a:has(img)").each(function () {
		var newclass;
		if ($(this).attr('href').match(/(jpg|gif|jpeg|png|tif)/)) { newclass = 'zoom_image'; } else { newclass = ''; }
		var $image = $(this).contents("img");
		if ($image.length > 0) {
			$image.wrap("<span class=" + newclass + "></span>");//把图片用span包起来
			$image.parent().css({ //给这个span加css属性，当然也可以在css里直接写……
				display: 'inline-block'
			})

		}
	});
	$('.entry a img').hover(function () {
		$(this).stop().animate({
			opacity: 0.5
		},
			400)
	},
		function () {
			$(this).stop().animate({
				opacity: 1
			},
				400)
		});



	$('#related_area img').hover(
		function () { $(this).fadeTo("fast", 0.7); },
		function () {
			$(this).fadeTo("fast", 1);
		});


	commentajax();
	comment_pager();
	singleajax();
	$('#loading').fadeOut('slow');
}//abooksingleinit结束
function commentajax() {
	$('.fn a').attr({ target: "_blank" });  //对class=“fn”标签内的a中添加target: "_blank"
	$(".comment .avatar").load(function () {
		$(this).wrap(function () {
			return '<span class="' + $(this).attr('class') + '" style="background:url(' + $(this).attr('src') + ') no-repeat center center; width: ' + $(this).width() + 'px; height: ' + $(this).height() + 'px;" />';
		});
		$(this).css("opacity", "0");
	});
	$('.reply').hide(0);
	$(".commnetdiv").hover(function () {
		$(this).find('.reply').stop(true, true).fadeIn(300);
	},
		function () {
			$(this).find('.reply').stop(true, true).fadeOut(300)
		});
	$('.comment-reply-link').click(function () {
		var t = $(this).parent().parent().attr("id");
		var postid = $(this).attr("id").split("reply-")[1].split("-")[0];
		var parent = $(this).attr("id").split("reply-")[1].split("-")[1];
		//alert (parent);
		var a = '"#' + t + '"';
		var b = $(this).parent().parent().find('cite:first').text();
		var c = '<a href=' + a + '>@' + b + '</a>,';
		$('#commento').html(c);
		$('#add_comment').addClass("comment_switch_active").siblings().removeClass();
		$("#comment_content > div").hide(400).eq(0).show(500);
		$("#comment").focus();
		$("#comment_post_ID").attr("value", postid);
		$("#comment_parent").attr("value", parent);

		var temp = $("#" + t).html();
		$('#ajaxpre').html('').html('<li id="ajaxtempview" class="commentlist comment" style="background:#ddd"><div>' + temp + '</div></li>').show();
		$("#cancel-comment-reply-link").show();
		$("#cancel-comment-reply-link").unbind('click').bind('click', function () {

			$('#comment_switch').addClass("comment_switch_active").siblings().removeClass();
			$('#respond_area').hide(400);
			$("#comment_area").show(500);

			$("#comment").attr("value", '');
			$('#commento').html('');
			$("#comment_parent").attr("value", '0');
			$("#cancel-comment-reply-link,#ajaxpre").hide();
			$("#" + t).focus();
			return false;
		});

		return false;
	});

}


function comment_pager() {
	$('#comment_pager a').click(function () {
		var wpurl = $(this).attr("href").split(/(\?|&)action=AjaxCommentsPage.*$/)[0];
		var commentPage = 1;
		if (/comment-page-/i.test(wpurl)) {
			commentPage = wpurl.split(/comment-page-/i)[1].split(/(\/|#|&).*$/)[0];
		} else if (/cpage=/i.test(wpurl)) {
			commentPage = wpurl.split(/cpage=/)[1].split(/(\/|#|&).*$/)[0];
		};
		//alert(commentPage);
		var postId = $("#comment_post_ID").attr("value");
		//alert(postId);
		var url = wpurl.split(/#.*$/)[0];
		url += /\?/i.test(wpurl) ? '&' : '?';
		url += 'action=AjaxCommentsPage&post=' + postId + '&page=' + commentPage;
		//alert(url);
		$.ajax({
			url: url,
			type: 'GET',

			beforeSend: function () {
				$('#comment_pager').hide();
				var loading = '<div id="com_loading">正在努力读取中......</div>';
				$('#thecomments .overview').html(loading);
				$("#thecomments").tinyscrollbar_update();
			},
			error: function (request) {
				alert(request.responseText);
			},
			success: function (data) {
				var responses = data.split('<!--Abook-AJAX-COMMENT-PAGE-->');
				$('#thecomments .overview').html(responses[0]);
				$('#comment_pager').html(responses[1]);
				$("#thecomments").tinyscrollbar_update();
				commentajax();
				comment_pager();
				$('#thecomments .overview,#comment_pager').show();



			}
		});
		return false;
	});
}
function singleajax() {
	$("#next_page_button,#prev_page_button").click(function () {
		var href = $(this).children().attr("href");
		href += /\?/i.test(href) ? '&' : '?';
		href += 'act=singlePage';
		$.ajax({
			url: href,
			dataType: 'html',
			contentType: 'application/json; charset=utf-8',
			cache: true,
			beforeSend: function () {
				//$('#main').empty();
				$('#prev_page_button,#next_page_button').fadeOut(0);
				$("#loading").show();

			},
			success: function (resource) {
				$("#main").empty().html(resource);

				abooksingleinit();

			}

		});
		return false;
	});
}

jQuery(document).ready(function ($) {



	abooksingleinit();

	$("#nav li").hover(function () {
		$(this).stop().animate({ marginTop: '-10px' }, 250, 'swing', function () { $(this).css("overflow", "auto"); });
	}, function () {
		$(this).stop().animate({ marginTop: '0' }, 250, 'swing', function () { $(this).css("overflow", "Hidden"); });

	});




});//js end













