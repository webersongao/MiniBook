	
<?php if ( post_password_required() ) : ?>
				<div id="comments">	<p class="nopassword"><?php _e( '私人文章，输入密码查看留言'  ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>


<!--comment satae-->

<div id="comments" >
<div id="comment_header">
<ul>
<li id="add_comment" ><a href="#respond">写评论</a></li>
<li id="comment_switch" class="comment_switch_active"><a href="javascript:void(0);"> <span id="number"><?php
$str = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID 
AND comment_approved = '1' AND comment_type != ''";
$count_t = $post->comment_count;
$count_p = $wpdb->get_var($str);
echo  '评论('.$count_t.')';
?> </span></a></li>
<li id="trackback_switch"><a href="javascript:void(0);">引用( <?php echo $count_p ?> )</a></li>
<?php if(is_single()):?>
<li id="related_posts"><a href="javascript:void(0);">相关文章</a></li>
<?php endif;?>
</ul>
<div class="clear"></div>
</div>
<div id="comment_content">
<div id="respond_area" style="display: none;" >
<div id="respond">
	<?php if(comments_open()):?>
	<h3 style="display:none;"><?php comment_form_title(__('Leave a Reply'), __('Leave a Reply to %s')); ?></h3>

		<div id="ajaxpre"><div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div><div class="viewport"><div class="overview"></div></div></div>
		<form id="commentform" action="<?php bloginfo('url'); ?>/wp-comments-post.php" method="post">
				<?php if($user_ID) : ?>
					<p><?php _e('欢迎回来 !');?></p><p><?php _e('以管理员ID：'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><strong><?php echo $user_identity; ?></strong></a><?php _e(' 登录'); ?> .
					<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('退出 &raquo;'); ?></a></p>
				
				<?php else: ?>
					<?php if(isset($_COOKIE['comment_author_email_'.COOKIEHASH]) && isset($_COOKIE['comment_author_'.COOKIEHASH]))  : ?>
					<div id="commentwelcome">
						<?php printf(__('嘿! <strong>%1s</strong>, 欢迎回来! 评论指导否？'), $comment_author); ?><a id="edit_profile" title="重新填写资料" href="javascript:void(0);"><?php _e(' (编辑信息?)'); ?></a>
					</div>
					<div id="welcome_msg">
						<code><?php echo AbookWelcomeCommentAuthorBack($comment_author_email); ?></code>
					</div>	
					<?php endif; ?>


		<div id="guest_info" class="<?php echo $comment_author_email ? 'hidden' : 'profile'; ?>">
		<div id="guest_name">
			
			<input type="text" name="author" id="author" class="textfield" value="<?php echo $comment_author; ?>" size="22" tabindex="1"/><label for="author"><span>昵称</span><?php if ($req) _e('(required)'); ?></label>
		</div>
		<div id="guest_email">
			
			<input type="text" name="email" id="email" class="textfield" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2"/><label for="email"><span>邮箱</span><?php if ($req) _e('(required)'); ?></label>
		</div>
		<div id="guest_url">
			
			<input type="text" name="url"  id="url" class="textfield" value="<?php echo $comment_author_url;  ?>" size="22" tabindex="3"/><label for="url"><span>网站或博客</span></label>
			</div>
	</div>
	<?php endif; ?>
	
<div id="toolBar" class="hidden">
<div id="toolBarloading">评论工具栏加载中...</div>
<div id="tools" class="hidden">
<a class="smelis" title="表情" href="javascript:setStyleDisplay('smelislist','block');"></a>
<div id="smelislist" style="display: none;"><?php include(TEMPLATEPATH . '/smiley.php');?></div>
<a class="fontcolor" title="字体颜色" href="javascript:Editor.fontColor();">fontcolor</a>
<a class="fontsize" title="字体大小" href="javascript:Editor.fontSize();">fontsize</a>
<a class="strong" title="粗体" href="javascript:Editor.strong();">STRONG</a>
<a class="ahref" title="超链接" href="javascript:Editor.ahref();">ahrefa</a>
<a class="imgadd" title="插入图片" href="javascript:Editor.img();">img</a>
<a class="code" title="插入代码" href="javascript:Editor.code();">code</a>
<a class="bquote" title="插入引用" href="javascript:Editor.blockquote();">blockquote</a>
<a class="clearFormat" title="去除格式" href="javascript:Editor.clear();">CLEAR</a>
<a class="resetarea" title="清空输入" href="javascript:Editor.empty();">Empty Input</a>
</div>

</div>
<div id="cancel-comment-reply">
	<?php cancel_comment_reply_link('取消评论'); ?>
</div>
		<div id="comment_textarea" >
					<div id="real-avatar">
		<?php if(isset($_COOKIE['comment_author_email_'.COOKIEHASH])) : ?>
		
			<?php echo get_avatar($comment_author_email, 25);?>
			<?php else :?>
			<?php global $user_email;?><?php echo get_avatar($user_email, 25); ?>
			<?php endif;?>
		
</div>	
			<textarea id="comment" class="textfield" rows="10" cols="50" name="comment"  tabindex="4" title="支持Ctrl+Enter提交" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit_comment').click();return false};"></textarea>
		
			<div id="ajaxcommentmsg">评论提交中...</div>
			<div id="commento" style="display:none;"></div>
	</div>	
	<div id="comment_textarea_bottom">
	<span class="mail_notify"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked" style="width:auto;" /><label for="comment_mail_notify"> 有人回复时邮件通知我</label></span>
	<span class="textcount">您输入了&nbsp;<i id="num" > 0/800 </i>&nbsp;字</span>
	</div>
<div id="submit_comment_wrapper">
<input name="submit" type="submit" id="submit_comment"  tabindex="5" value="写好了 " />
<?php comment_id_fields(); ?>

</div>
<div><?php do_action('comment_form', $post->ID); ?></div>
</form>





<?php else: ?>

	<h3><?php _e('评论关闭了.'); ?></h3>

<?php endif; ?>
</div>
</div>
<div id="comment_area" >
<!--list comment-->

<?php if( have_comments() ):?>

<div id="thecomments" class="commentlist">
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
		<ol>
<?php wp_list_comments('callback=AbookComments&max_depth=2');?>
</ol>
</div>
	</div>
</div>

<?php else:?>

<div id="thecomments" class="commentlist">
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
		<ol>
	<li class="comment">
		<div class="comment-content"><h3>目前还没有评论,沙发等着您~</h3></div>
	</li>
	</ol>
	</div>
	</div>
</div>

<?php endif; ?>


<!--comments pages-->
<?php
if (get_option('page_comments')){
		// 获取评论分页的 HTML
		$comment_pages = paginate_comments_links('echo=0');
		// 如果评论分页的 HTML 不为空, 显示上一页和下一页的链接
		if ($comment_pages) {
?>
<div id="comment_pager" ><span class="pages">分页：</span>
		<?php echo $comment_pages; ?>
</div>
<?php
	
		}
	}

?>

</div>
<div id="trackback_area" style="display: none;">
<!--list trackbacks-->
<ol id="pinglist" class="commentlist">
<?php
foreach($comments as $comment){
   if(get_comment_type() != 'comment' && $comment->comment_approved != '0'){ $havepings = 1; break; }
}
if($havepings == 1) : 
 wp_list_comments('type=pings&per_page=0&callback=AbookPings'); 
else:?>

	<li class="comment">
		<div class="comment-content"><h3><?php _e('目前还没有trackbacks.'); ?></h3></div>
	</li>
<?php
endif;
if(!pings_open()):
?>
	<li class=" comment">
		<div class="comment-content"><h3><?php _e('Trackbacks被禁用了'); ?></h3></div>
	</li>
<?php endif; ?>
</ol>
</div>
<?php if(is_single()):?>
<div id="related_area"  style="display: none;">
<?php if(get_option('Abook_wumi') == 'TRUE'): ?>
<div id="wumiiDisplayDiv"></div>
<?php else : ?>	
<ul>
<?php winyrelated_post('true');?></ul>
<?php endif;?>
</div>
<?php endif;?>
</div>
</div>