<?php 
 
/**
 * 创建一个有密码提示的 form
 * @return string
 */
function WinyskyPasswordHint( $c ){
	global $post, $user_ID, $user_identity;

	$actionLink = get_option('siteurl') . '/wp-pass.php';
	$inputid =  'pwbox-'.(empty($post->ID) ? rand() : $post->ID);
	$btnValue = __('提交');

	// get and format hint
	$hint = get_post_meta($post->ID, 'password_hint', true);
	$hint = $hint ? $hint : __('本文章已被密码保护，在下面输入密码查看文章:');
	if($user_ID){
		$hint = sprintf(__('欢迎 <strong>%1$s</strong> ! 密码是 : %2$s '), $user_identity, $post->post_password);
	}

	$output = <<<EOF
<form action="{$actionLink}" method="post">
	<div class="row">
	<p><label for="{$inputid}">密码提示：{$hint}</label></p>
	<input id="{$inputid}" class="textfield" name="post_password" type="password" />
	<input class="button hintbtn" name="Submit" type="submit" value="{$btnValue}" />
	</div>
</form>\n
EOF;
	return $output;
}
add_filter('the_password_form', 'WinyskyPasswordHint');

/**
 * 在后台添加有关 密码提示 的相关信息
 *
 * @see do_action('submitpost_box')
 * @see do_action('submitpage_box')
 * @return null
 */
function WinyskyPasswordHintForAdmin(){
	$h3 = __('如何设置密码提示');
	$words = __('如果你在一篇文章中设置了密码，请在<a href="#postcustom">自定义域中</a>新建名为 \'password_hint\'，其值为提示内容');
	$html=<<<END
<div >
	<h3>$h3</h3>
	<div>
		<p>$words</p>
	</div>
</div>
END;
	echo $html;
}
add_action('submitpost_box', 'WinyskyPasswordHintForAdmin');
add_action('submitpage_box', 'WinyskyPasswordHintForAdmin');

//自定义头像
add_filter( 'avatar_defaults', 'fb_addgravatar' );
function fb_addgravatar( $avatar_defaults ) {
$myavatar = get_bloginfo('template_directory') . '/images/gravatar.png';
  $avatar_defaults[$myavatar] = '自定义头像';
  return $avatar_defaults;
}

//彩色标签云
function colorCloud($text) {
$text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
return $text;
}
function colorCloudCallback($matches) {
$text = $matches[1];
$color = dechex(rand(0,16777215));
$pattern = '/style=(\'|\")(.*)(\'|\")/i';
$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
return "<a $text>";
}
add_filter('wp_tag_cloud', 'colorCloud', 1);
/*注册边栏*/
function Abook_widgets_init() {
	register_sidebar( array(
		'name' => __( '顶部左' ),
		'id' => 'primary-widget-area',
		'description' => __( '底部左'),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( '顶部右' ),
		'id' => 'secondary-widget-area',
		'description' => __( '底部中' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( '底部'),
		'id' => 'thirdary-widget-area',
		'description' => __( '底部右' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	
}

add_action( 'widgets_init', 'Abook_widgets_init' );

add_filter('stylesheet_uri','cache_buster_code',9999,1); 

function cache_buster_code($stylesheet_uri){
    $pieces = explode('wp-content', $stylesheet_uri);
    $stylesheet_uri = $stylesheet_uri . '?v=' . filemtime(ABSPATH . '/wp-content' . $pieces[1]);
    return $stylesheet_uri;
}

function LoadJS(){
	global $post;
	$blogurl = get_bloginfo('url').'/';
	$theme = get_bloginfo('template_directory') . '/';
		// javascript loader
	if ( is_singular()||is_404()||is_search() ){
	$jsFileURI = $theme .'js/single.js?v='. date('YmdHis',filemtime(TEMPLATEPATH. '/js/single.js'));
		}
	else{
	$jsFileURI = $theme.'js/home.js?v='. date('YmdHis',filemtime(TEMPLATEPATH. '/js/home.js'));
		}
	$text = <<<EOF
<script type="text/javascript">
<!--
	var base="$blogurl"; var themeurl="$theme";
	var core = document.createElement('script');
	core.type = 'text/javascript'; core.async = true; 
	core.src = '{$jsFileURI}';
	var s = document.getElementsByTagName('head')[0];
	s.appendChild(core);
//-->
</script>
EOF;


	echo $text;
}
add_action('wp_head', 'LoadJS', 100);