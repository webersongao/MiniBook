<?php 
/**************************以下函数是为了优化SEO**************************
 *标题，关键词，站点描述等
 *部分参考自philna2 
 *@2011.6.9
 */

function WinyTitle(){
	global $post, $wp_query;
	$page = $wp_query->get('paged');
	$page = !empty($page) ? __(' | Page  ').$page : '';
	if( is_home() ){//首页
		echo bloginfo('name'), ' | ' . get_bloginfo('description'), $page;
	}elseif( is_single() ){ // 单篇文章页
		echo wp_title('',true), ' » ' . get_bloginfo('name'), $page;
	}elseif( is_page()){ //者普通页面
		echo wp_title('',true), ' » ', get_bloginfo('name');
	}elseif( is_search() ){ //搜索页
		printf(__('搜索结果 &quot;%1$s&quot;'),
		attribute_escape(get_search_query()));
		echo ' - ', bloginfo('name'), $page;
	}elseif( is_category() ){ //分类页
		echo  single_cat_title(), ' » ', get_bloginfo('name'), $page;
	}elseif( is_tag() ){ //Tags页 (标签页)
		echo single_tag_title(), ' » ', get_bloginfo('name'), $page;
	}elseif( is_month() ){ //存档页(目前只有月份存档,如果有需要再添加其他的存档可能)
		printf(__('%1$s中的文章'), single_month_title(' ', false));
		echo  ' » ', get_bloginfo('name'), $page;
	}elseif( is_404() ){ //404 错误页面
		echo __('404 Not Found  I\'m sorry'), ' » ', get_bloginfo('name');
	}else{ //其他没有考虑到的情况
		echo wp_title('',true), ' » ', get_bloginfo('name'), $page;
	}
}

/* Auto-description v1.3 by Willin Kan & Modified by winy */
function head_desc_and_keywords() {
  global $s, $post;
  $description = '';
  $keywords = '';
  $blog_name = get_bloginfo('name');
  if ( is_singular() ) {
	if(!empty($post->post_password)){//有密码保护的文章不输出
	  $text = "受保护的文章,输入密码查看！";
	  $keywords = '';
	}else{
      $text = $post->post_content;
	  if ( get_the_tags( $post->ID ) ) {
		foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
		}
		foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
	    }
    $description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
   	if ( !( $description ) ) $description = $blog_name . " - " . trim( wp_title('', false) );
	$keywords = substr_replace( $keywords, "" , -2 );
  } elseif ( is_home () )    {
	$description = get_option('Abook_description');
	$keywords = get_option('Abook_keywords');
  } elseif ( is_tag() )      { 
	$description = $blog_name . "有关 '" . single_tag_title('', false) . "' 的文章";
	$keywords = single_tag_title('', false);
  } elseif ( is_category() ) {
	$description = $blog_name . "有关 '" . single_cat_title('', false) . "' 的文章";
	$keywords = single_cat_title('', false);
  } elseif ( is_archive() )  {
	$description = $blog_name . "在: '" . trim( wp_title('', false) ) . "' 的文章";
	$keywords = trim( wp_title('', false) );
  } elseif ( is_search() )   {
	$description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
	$keywords = esc_html( $s, 1 );
  } else { 
	$description = $blog_name . "有关 '" . trim( wp_title('', false) ) . "' 的文章";
	 $keywords = trim( wp_title('', false) );
  }  
  if ( $keywords ) {
    echo "<meta name=\"keywords\" content=\"$keywords\" />\n";
  }
	$description = mb_substr( $description, 0, 97, 'utf-8' ) . '..';//截取文章的前97个字符作为描述
	echo "<meta name=\"description\" content=\"$description\" />\n";
}

/**
 * cononical link
 * 据说有利于爬虫
 * function copy from philna2
 */
function AbookCanonical(){
	if(function_exists('rel_canonical') && is_singular()){
		return;
	}
	if(is_404() || is_search()){
		return;
	}
	global $post;
	if( is_home() )
		echo '<link rel="canonical" href="'.get_bloginfo('url').'"/>',"\n";
	else
		echo  '<link rel="canonical" href="'.get_permalink($post->ID).'"/>',"\n";
}

/**
 * common head links
 * 优化SEO，
 * function copy from philna2 & modified by winy 10.01.24
 */
function AbookHeadItem(){
	if(get_option('Abook_feed')!=""){
		$feed_url=get_option('Abook_feed');
	}else{
		$feed_url=get_bloginfo('rss_url');
	 }
	echo
	'<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />',"\n",
	'<link rel="alternate" type="application/rss+xml" title="'.__('RSS 2.0 - posts').'" href="'.$feed_url.'" />',"\n",
	'<link rel="alternate" type="application/rss+xml" title="'.__('RSS 2.0 - all comments').'" href="'.get_bloginfo('comments_rss2_url').'" />',"\n";
	if(is_singular()){
	echo '<link rel="pingback" href="'.get_bloginfo('pingback_url').'"/>',"\n";
	}
	if(is_home() || is_front_page() || is_single() || is_page()){
		echo '<meta name="robots" content="index,follow" />', "\n";
	}elseif(is_day() || is_tag() || is_search() || is_author()){
		echo '<meta name="robots" content="noindex,follow,noodp" />', "\n";
	}else{
		echo '<meta name="robots" content="noindex,follow" />', "\n";
	}
	if(is_bot()){ wp_get_archives('type=monthly&format=link'); } // for bots
}

/**
 * 通过USER_Agent判断是否为机器人.
 * Edit by winy 10.01.28
 * @return Boolean
 */
function is_bot(){
	$bots = array('Baiduspider1'=>'Baiduspider','Baiduspider2'=>'Baiduspider+','Google Bot1' => 'googlebot', 'Google Bot2' => 'google', 'Google AdSense' => 'Mediapartners', 'MSN' => 'msnbot', 'Yahoo Bot1' => 'yahoo', 'Yahoo Bot2' => 'Yahoo! Slurp','Yahoo Bot3' => 'Yahoo! Slurp China','YodaoBot' => 'YodaoBot','iaskspider' => 'iaskspider','Sogou web spider' => 'Sogou web spider','Sogou Push Spider' => 'Sogou Push Spider','Sosospider' => 'Sosospider','Alex' => 'ia_archiver', 'Bot'=>'bot','Spider'=>'spider','for_test'=>'sFirefox');
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	foreach ($bots as $name => $lookfor) {
		if (stristr($useragent, $lookfor) !== false) {
			return true;
			break;
		}
	}
}