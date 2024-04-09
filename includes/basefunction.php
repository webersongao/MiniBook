<?php
/**************************以下函数修改wp默认设置**************************

/* 取消原有的 jquery 因为我自己定义，防止插件冲突 */
if ( !is_admin() ) { // 後台不用
function my_init_method() {
    wp_deregister_script( 'jquery' ); //   
}    
add_action('init', 'my_init_method'); // 
}
wp_deregister_script( 'l10n' );
remove_action('init','wp_admin_bar_init');
//禁用修改历史记录
remove_action('pre_post_update','wp_save_post_revision');
//禁止在head泄露wordpress版本号
remove_action('wp_head','wp_generator');
//移除head中的rel="EditURI"
remove_action('wp_head','rsd_link');
//强化WP后台可视化编辑器 
function editor_styles($url) {
if (!empty($url)) $url .= ',';
$url .= trailingslashit(get_stylesheet_directory_uri()).'editor.css';
return $url;
}
if(current_user_can('edit_posts')):
add_filter('mce_css', 'editor_styles');
endif;
/**
 * 去掉输出wordpress版本，安全
 */
remove_action('wp_head', 'wp_generator');
/**
 * 去掉输出短链接
 */
remove_action('wp_head', 'wp_shortlink_wp_head');
/**
 *去掉默认的最新评论css
 */
function remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'remove_recent_comments_style' );

/*移除li中空行*/
function remove_white_space( $content ) {return str_replace(array("\n", "\r", "\t"), "", $content); }
add_filter( 'wp_list_pages', 'remove_white_space' );
add_filter( 'wp_list_categories', 'remove_white_space' );

// No Self Pings，禁止自己ping
function no_self_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link )
		if ( 0 === strpos( $link, $home ) )
			unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );
/*
 *去掉标题字样
 *
 */
function blah($title) {
       return '%s';
}
add_filter('protected_title_format', 'blah');
add_filter('private_title_format', 'blah');
/*
 *自动将半角的单引号、双引号和省略号转换为全角标点的问题。 Author: Sparanoid
 */
 $qmr_work_tags = array('bloginfo','comment_author','comment_text','list_cats','link_name','link_description','link_notes','single_post_title','term_name','term_description','the_title','the_content','the_excerpt','wp_title','widget_title');
 foreach ( $qmr_work_tags as $qmr_work_tag ) {
     remove_filter ($qmr_work_tag, 'wptexturize');
 }
 // 移除wordpress登陆漏洞
// 替换 create_function() 函数
add_filter('login_errors', function($a) { return null; });

// 修改搜索过滤器函数
add_filter('pre_get_posts', function($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
});

// -- END ----------------------------------------


add_action( 'after_setup_theme', 'Abook_setup' );
if ( ! function_exists( 'Abook_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function Abook_setup() {
	// wp_nav_menu() wp3.0自定义导航
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'Abook' ),
	) );
	// 自定义背景
	add_custom_background();

}
endif;


/**
 * wp_nav_menu() fallback, wp_page_menu(), 显示主页链接
 */
function Abook_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'Abook_page_menu_args' );

/**
 * 错误泡泡
 *
 * 用于抛出错误
 * 实现$s的多变
 * 摘自著名主题 k2
 * 修改了参数类型,更方便使用!
 *
 * @since 1.0
 */
function fail($s) {
	header('HTTP/1.0 403 Forbidden');
	header('Content-Type: text/plain');
	if(is_string($s)){
		die($s);
	}else{
		$s;
		die;
	}
}