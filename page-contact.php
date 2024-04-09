<?php
/*
Template Name: cantact
*/?>
<?php
$adminEmail = get_option('admin_email');
$comment_author=stripslashes($_COOKIE['comment_author_'.COOKIEHASH]);
$comment_author_email=stripslashes($_COOKIE['comment_author_email_'.COOKIEHASH]);
$comment_author_url=stripslashes($_COOKIE['comment_author_url_'.COOKIEHASH]);
$username = ($user_ID) ? get_the_author_meta('user_nicename', $user_ID) : $comment_author;
$useremail = ($user_ID) ? get_the_author_meta('user_email', $user_ID) : $comment_author_email;
$userurl = ($user_ID) ? get_the_author_meta('user_url', $user_ID) : $comment_author_url;
?>  

 <?php get_header(); ?>

<div id="main">

			
			<div id="mybook">
			
				<div class="pagecontent single-left">
<?php if(have_posts()) : while(have_posts()): the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="查看文章: <?php the_title_attribute(); ?>"><?php if (is_sticky()) {echo "[置顶]";} ?><?php the_title(); ?></a></h1>
						<div class="postmeta">
		<span class="data"><?php time_diff( $time_type = 'post' ); ?></span><span class="view"><?php if(function_exists('the_views')) { the_views(); }elseif(function_exists('post_views')){post_views('点击：', '');} ?></span>
	</div>
	<div class="entry" >
	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
<?php the_content(); ?>
</div>
</div>
	</div>
<div class="clear"></div>
	 </div>
				<?php endwhile;endif; // End the loop. Whew. ?>
			</div>
			
			<div class="pagecontent single-right"><!-- contactbox form -->
				<div id="contactbox" >
	<h3 style="margin:30px 5px;">请填写如下部分：邮件联系</h3>
	<?php if($adminEmail): ?>
		<form id="mailform" method="post" action="<?php echo get_bloginfo('template_url')?>/sendemail.php">
			<?php if($user_ID) : ?>
					<p><?php _e('欢迎回来 !');?></p><p><?php _e('以管理员ID：'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><strong><?php echo $user_identity; ?></strong></a><?php _e(' 登录'); ?> .
					<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('退出 &raquo;'); ?></a></p>
			<?php else: ?>
		<?php if(isset($_COOKIE['comment_author_email_'.COOKIEHASH]) && isset($_COOKIE['comment_author_'.COOKIEHASH]))  : ?>
		<div id="commentwelcome">
		<?php printf(__('嗨~ <strong>%1s</strong>, 您的昵称和邮件地址已填上'), $comment_author); ?>
					</div>
			
	
			<?php endif; ?><?php endif; ?>
			<div id="guest_info" >
			
		<div id="guest_name">
		
		<input class="textfield" id="name" type="text" name="name" tabindex="1" value="<?php if(isset($_POST['author'])) echo $_POST['author'];else echo $username; ?>"/><label for="name" class="small"><?php _e('您的名称')?></label>
		</div>
		<div id="guest_email">
			<input class="textfield" id="from" type="text" name="from" tabindex="2" value="<?php if(isset($_POST['email'])) echo $_POST['email'];else echo esc_attr($useremail); ?>"/><label for="from" class="small"><?php _e('您的邮箱')?></label>
			
		</div>
		
			
		<div id="guest_subject" class="row">
			<input class="textfield" id="subject" type="text" name="subject" tabindex="3"/><label for="subject" class="small"><?php _e('邮件主题')?></label>
			
		</div>
		
		<div id="guest_vcode" class="row">
			<input class="textfield" id="vcode" type="text" name="vcode" tabindex="4"/><label for="vcode" class="small"><?php _e('验证码')?>(*):<img class="yzimg" src="<?php bloginfo('template_url'); ?>/yz_img.php" title="<?php _e('点击此处刷新')?>" alt="" onclick="this.src=this.src+'?'" style="cursor:pointer;" /></label>
		
		</div>
		</div>
					

		<div id="comment_textarea" >
			<textarea id="mailcontent" class="textfield" rows="10" cols="50" name="mailcontent"  tabindex="5" title="支持Ctrl+Enter提交" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit_mail').click();return false};"><?php echo '你好, winy!';echo "\n\n\t\n";echo '祝好~',"\n";?></textarea>
			<div id="ajaxcommentmsg"></div>
	</div>	
	
<div id="submit_comment_wrapper">
<input name="submit" type="submit" id="submit_mail"  tabindex="6" value="发邮件 " />
</div>
		

		</form>
		<?php else: ?>
		<p class="error"><?php _e('不能获取管理员邮箱，请检查设置！' )?></p>
		<?php endif;?>
	</div>

			
		</div>
		<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function($) {

/** submit */
$('#mailform').submit(function() {
		
		$('#ajaxcommentmsg').html('<span class="ajaxwait">邮件发送中...<\/span>').fadeIn();
		$submit.attr('disabled', true).fadeTo('slow', 0.5);
/** Ajax */
	$.ajax( {
		url: themeurl + 'sendemail.php',
		data: $(this).serialize(),
		type: $(this).attr('method'),
		error: function(request) {
			$('#ajaxcommentmsg').html('<span class="ajaxerror">'+request.responseText+'<\/span>');
			setTimeout(function() {$submit.attr('disabled', false).fadeTo('slow', 1); $('#ajaxcommentmsg').hide();}, 3000);
			},

		success: function(data) {
			$('#ajaxcommentmsg').html('<span class="ajaxsuccess">邮件发送成功！<\/span>').fadeOut(4000);
			$("#mailcontent").attr("value", '');
			countdown();

	}

		
	}); // end Ajax
  return false;
}); // end submit

  });
var wait = 15, $submit = $('#submit_comment'); 
$submit.attr('disabled', false);
submit_val = $submit.val();
function countdown() {
	if ( wait > 0 ) {
		$submit.val(wait); wait--; setTimeout(countdown, 1000);
	} else {
		$submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
		wait = 15;
  }
}

/* ]]> */
</script>
</div></div></div>
 <?php get_footer(); ?>



	