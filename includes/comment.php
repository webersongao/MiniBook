<?php 
/**
 * 评论部分
 *
 */
function AbookComments( $comment, $args, $depth ) {
	if($comment->comment_type==''){
		$GLOBALS['comment'] = $comment;
		global $commentcount;
	$page = ( !empty($in_comment_loop) ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args );
	if(!$commentcount) { //初始化楼层计数器
	
	$cpp=get_option('comments_per_page');//获取每页评论显示数量
		if ($page > 1) {
		$commentcount = $cpp * ($page - 1);
		} else {
		$commentcount = 0;//如果评论还没有分页，初始值为0
		}
	}
	
	$zw=array(
	'<span style="color:red;">☆沙发</span>',
	'<span style="color:blue;">板凳</span>',
	'<span style="color:green;">地板</span>',
	'墙角',
	'天花板',
	'下水道'
	);
	if($comment->user_id >0){
		$admin_comment = '(<a href="#" style="color:red; font-size: 18px; font-weight: 700;" title="博主认证">√</a>)';
	}else{
	$admin_comment = '';
	}
	?>

<li <?php comment_class('clear'); ?> id="li-comment-<?php comment_ID(); ?>" <?php if($depth>2){echo 'style="margin-left:0px"';} ?>>


		<div id="comment-<?php comment_ID() ?>" class="commnetdiv">
			
		<div class="comment-author vcard">
			
			<?php printf(__('<cite class="fn">%s</cite><span class="says">%s</span>'), get_comment_author_link(), $admin_comment); 
           ?>
		   <span class="comdate"><?php  time_diff( $time_type = 'comment' ); ?><?php edit_comment_link( __( '(Edit)' ), ' ' );?></span>
		   <span class="floor">
					<?php if(!$comment->comment_parent) {
						if(($page==1)&&($commentcount<6)){
							printf('%1$s', $zw[$commentcount]);
							$commentcount++;
							}else{
						printf('%1$s楼', ++$commentcount);
						}
				} ?>
			</span>
		</div><!-- .comment-author .vcard -->		
		<div class="reply">
			
		<a id="reply-<?php echo $comment->comment_post_ID; ?>-<?php echo comment_ID(); ?>" href="#respond" class="comment-reply-link" rel="nofollow">Reply</a>
		</div>
		<?php if($depth>1){echo get_avatar( $comment, 24 );}else{echo get_avatar( $comment, 32 );}?>
		<div class="comment-body">
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<p><?php _e( '评论等待审核' ); ?></p>
		<?php endif; ?>
		<?php comment_text(); ?></div>
				
		</div>

		
<?php	
}
}



/**
 * list pings
 *
 */

function AbookPings($comment, $args, $depth) { // wp_list_comments()->pings
    $GLOBALS['comment'] = $comment;
	static $index = 1;
    if('pingback' == get_comment_type()) $pingtype = 'Pingback';
    else $pingtype = 'Trackback';
?>
    <li id="comment-<?php echo $comment->comment_ID ?>" class="comment">
        <?php echo '#'.$index.'| ';comment_author_link(); ?> - <?php echo $pingtype; ?> on <?php echo mysql2date('Y/m/d/ H:i', $comment->comment_date); ?>
<?php 
	$index++;
}

/* comment_mail_notify v1.0 by willin kan. (有勾選欄, 由訪客決定) */
function comment_mail_notify($comment_id) {
$admin_notify = '0'; // admin 要不要收回覆通知 ( '1'=要 ; '0'=不要 )
$admin_email = get_bloginfo ('admin_email'); // $admin_email 可改為你指定的 e-mail.
$comment = get_comment($comment_id);
$comment_author_email = trim($comment->comment_author_email);
$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
global $wpdb;
if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
$wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
$wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
$notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
$spam_confirmed = $comment->comment_approved;
if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
$wp_email = 'admin@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 發出點, no-reply 可改為可用的 e-mail.
$to = trim(get_comment($parent_id)->comment_author_email);
$subject = '您在 [' . get_option("blogname") . '] 的留言有回复了 去看看吧 ^_^';
$message = '
<div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">
<p>Hi！' . trim(get_comment($parent_id)->comment_author) . ',您曾在《' . get_the_title($comment->comment_post_ID) . '》上的评论有了新回复:<br />
<p><strong>你</strong>说：' . trim(get_comment($parent_id)->comment_content) . '<br /></p>
<p><strong>' . trim($comment->comment_author) . ' </strong>说:' . trim($comment->comment_content) . '<br /></p>
<p>继续围观，请猛击：<a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '"> 查看回复完整內容</a></p><p>(此邮件由系统自动发出, 请勿回复.)</p>
<p style="float:right"> —— By <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>

</div>';
$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
wp_mail( $to, $subject, $message, $headers );
//echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
}
}
add_action('comment_post', 'comment_mail_notify');
// -- END ----------------------------------------


/* 貼圖 by qiqiboy. */
function add_comment_tags($content) {
    //替换图片
    $content = preg_replace('/\[img src=(.*?) alt=(.*?) \/]/e', '"<img src=\"$1\" alt=\"$2\"/>"', $content);
    //替换成颜色标记
    $content = preg_replace('/\[color=(.*?)\](.*?)(\[\/color)?\]/e', '"<span style=\"color:$1;\">$2</span>"', $content);
    //替换成文字大小标记
    $content = preg_replace('/\[size=(.*?)\](.*?)(\[\/size)?\]/e', '"<span style=\"font-size:$1;\">$2</span>"', $content);
    return $content;
}

add_filter('comment_text', 'add_comment_tags');
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src ($img_src, $img, $siteurl){
    return get_bloginfo('template_directory').'/images/smilies/'.$img;
}

/**
 * welcome message
 * @param unknown_type $email
 * @return void|string
 */
function AbookWelcomeCommentAuthorBack($email = ''){
	if(empty($email)){
		return;
	}
	global $wpdb;

	$past_30days = gmdate('Y-m-d H:i:s',((time()-(24*60*60*30))+(get_option('gmt_offset')*3600)));
	$sql = "SELECT count(comment_author_email) AS times FROM $wpdb->comments
					WHERE comment_approved = '1'
					AND comment_author_email = '$email'
					AND comment_date >= '$past_30days'";
	$times = $wpdb->get_results($sql);
	$times = ($times[0]->times) ? $times[0]->times : 0;
	$message = $times ? sprintf(__('过去30天内您评论了<strong><span class="comment-num">%1$s</span></strong>次，感谢关注~' ), $times) : '<p>您很久都没有留言了，这次想说点什么吗？</p>';

	return $message;
}


function nofollow_compopup_link(){
    return' rel="nofollow"';
  }
add_filter('comments_popup_link_attributes','nofollow_compopup_link');

function nofollow_comreply_link($link){
    return str_replace('<a','<a rel="nofollow"',$link);
  }
  get_option('comment_registration')||
  add_filter('comment_reply_link','nofollow_comreply_link');