//处理评论框
var myField = document.getElementById("comment") || 0;
function ids(id) {
	return document.getElementById(id);
}
function setStyleDisplay(id, status) {
	ids(id).style.display = status;
}
function addSmelie(tag) {
	var myField = document.getElementById('comment');
	return addEditor(myField, ' ' + tag + ' ', '', true);
}

function addEditor(myField, ftag, etag, smelie) {
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		index = etag ? myField.value.indexOf(ftag + sel.text + etag) : myField.value.indexOf(ftag.replace(/ :[a-z\?]+?: /gi, 'smelis'));
		if (index == -1) {
			etag ? sel.text = ftag + sel.text + etag : sel.text = ftag;
		} else {
			alert('已经插入过了!');
		}
		myField.focus();
	} else if (myField.selectionStart || myField.selectionStart == '0') {
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		var cursorPos = endPos;
		index = etag ? myField.value.indexOf(ftag + myField.value.substring(startPos, endPos) + etag) : myField.value.indexOf(ftag.replace(/ :[a-z\?]+?: /gi, 'smelis'));
		if (index == -1) {
			etag ? myField.value = myField.value.substring(0, startPos) + ftag + myField.value.substring(startPos, endPos) + etag + myField.value.substring(endPos, myField.value.length) : myField.value = myField.value.substring(0, startPos) + ftag + myField.value.substring(endPos, myField.value.length);
			etag ? cursorPos += ftag.length + etag.length : cursorPos += ftag.length - endPos + startPos;
			if (startPos == endPos && etag) cursorPos -= etag.length;
		} else {
			alert('已经插入过了!');
			cursorPos = index + ftag.length;
		}
		myField.focus();
		myField.selectionStart = cursorPos;
		myField.selectionEnd = cursorPos
	} else {
		myField.value += ftag + etag;
		myField.focus();
	}
	if (smelie) { setStyleDisplay('smelislist', 'none'); }
}


var Editor = {
	strong: function () {
		addEditor(myField, '<strong>', '</strong>');
	},

	ahref: function () {
		var URL = prompt('输入地址', 'https://');
		if (URL) {
			addEditor(myField, '<a target="_blank" href="' + URL + '" rel="external">', '</a>');
		}
	},
	img: function () {
		var myValue = prompt('输入图片地址', 'https://');
		if (myValue) {
			myValue = '[img src='
				+ myValue
				+ ' alt=' + prompt('输入描述（可跳过）', '')
				+ ' /]';
			addEditor(myField, myValue);
		}
	},

	code: function () {
		addEditor(myField, '<code>', '</code>');
	},
	blockquote: function () {
		addEditor(myField, '<blockquote>', '</blockquote>');
	},
	fontColor: function () {
		var myValue = prompt('输入颜色css值', '#000000');
		if (myValue) {
			addEditor(myField, '[color=' + '#' + myValue.match(/[^#]{3,6}/gi)[0] + ']', '[/color]');
		}
	},
	fontSize: function () {
		var myValue = prompt('输入字体大小，例如12px', '12px');
		if (myValue) {
			addEditor(myField, '[size=' + myValue.match(/\d+/gi)[0] + 'px]', '[/size]');
		}
	},
	clear: function () {
		myField = myField;
		if (document.selection) {
			myField.focus();
			sel = document.selection.createRange();
			sel.text = sel.text.replace(/(?:<|\[)[^>]*?(?:>|\])/gi, '');
			myField.focus();
		} else if (myField.selectionStart || myField.selectionStart == '0') {
			var startPos = myField.selectionStart;
			var endPos = myField.selectionEnd;
			var cursorPos = startPos;
			myField.value = myField.value.substring(0, startPos) + myField.value.substring(startPos, endPos).replace(/(?:<|\[)[^>]*?(?:>|\])/gi, '') + myField.value.substring(endPos, myField.value.length);
			myField.focus();
			myField.selectionStart = cursorPos;
			myField.selectionEnd = cursorPos
		} else {
			myField.value = myField.value.replace(/(?:<|\[)[^>]*?(?:>|\])/gi, '');
			myField.focus();
		}
	},
	empty: function () {
		myField.value = '';
		myField.focus();
	}

}

var mycode = document.getElementById("commentform") || 0;
mycode.onsubmit = function () {
	var myField = document.getElementById('comment')
	var str = myField.value;
	var start = str.indexOf('<code>');
	var end = str.indexOf('</code>');
	if (start > -1 && end > -1 && start < end) {
		myField.value = '';
	} else return;
	while (end != -1) {
		myField.value += str.substring(0, start + 6) + str.substring(start + 6, end).replace(/<(?=[^>]*?>)/gi, '&lt;').replace(/>/gi, '&gt;');
		str = str.substring(end + 7, str.length);
		start = str.indexOf('<code>') == -1 ? -6 : str.indexOf('<code>');
		end = str.indexOf('</code>');
		if (end == -1) {
			myField.value += '</code>' + str;
		} else if (start == -6) {
			myField.value += '&lt;/code&gt;';
		} else {
			myField.value += '</code>';
		}
	}
}


myField.onclick = function () {
	setStyleDisplay('smelislist', 'none');
}

jQuery(document).ready(function ($) {


	$('#comment').bind('focus keyup input paste', function () {

		if (this.value.length > 800) {
			this.value = $(this).attr("value").substring(0, 800);
			$('#num').text('上限800');
		} else {
			$('#num').text($(this).attr("value").length);
		}
	});

	/** submit */
	$('#commentform').submit(function () {
		$cancel = $('#cancel-comment-reply-link'); cancel_text = $cancel.text();
		$('#ajaxcommentmsg').html('<span class="ajaxwait">评论提交中...</span>').fadeIn();
		$submit.attr('disabled', true).fadeTo('slow', 0.5);
		/** Ajax */
		$.ajax({
			url: themeurl + 'comments-ajax.php',
			data: $(this).serialize(),
			type: $(this).attr('method'),
			error: function (request) {
				$('#ajaxcommentmsg').html('<span class="ajaxerror">' + request.responseText + '</span>');
				setTimeout(function () { $submit.attr('disabled', false).fadeTo('slow', 1); $('#ajaxcommentmsg').hide(); }, 3000);
			},

			success: function (data) {
				$('#ajaxcommentmsg').html('<span class="ajaxsuccess">提交成功~</span>').fadeOut(4000);
				$("#cancel-comment-reply-link").hide();
				$("#comment").attr("value", '');
				$("#comment_parent").attr("value", '0');
				countdown();
				// comments
				$comments = $('#number'); // 評論數的 ID
				if ($comments.length) {

					n = parseInt($comments.text().match(/\d+/));
					$comments.text($comments.text().replace(n, n + 1));
				}

				// show comment

				new_htm = '<ol id="new_comm">' + data + '</ol>';
				$('#ajaxpre').html('').append(new_htm).fadeIn(2000);
				setTimeout(function () {
					$('.comment-num').after('<span class="comment-add">+1</span>');
					$('.comment-add').animate({//让这个标签执行动画效果
						fontColor: '#F76C00',
						opacity: 'hide'
					},
						4000);
				},
					1200);
				setTimeout(function () {//动画执行完以后的操作
					$('.comment-add').remove();//将渐隐后的span标签移除
					$('.comment-num').text(parseInt($('.comment-num').text()) + 1)//最后再让访客评论次数+1
				},
					3000);




			}
		}); // end Ajax
		return false;
	}); // end submit
	$("#toolBarloading").html('初始化完成').fadeOut('slow');
	$("#tools").fadeIn().show();
});

var wait = 15, $submit = $('#submit_comment');
$submit.attr('disabled', false);
submit_val = $submit.val();
function countdown() {
	if (wait > 0) {
		$submit.val(wait); wait--; setTimeout(countdown, 1000);
	} else {
		$submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
		wait = 15;
	}
}