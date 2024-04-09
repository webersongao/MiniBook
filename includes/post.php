<?php 
/**************************其它模板函数**************************
 */



/* Auto-excerpt by winy */
function winyexcerpt($max_char = 200, $more_text = '...', $limit_type = 'content',$more=true) {
	
    if ($limit_type == 'title') { $text = get_the_title(); }
    else { $text = get_the_content(); }
    $text = apply_filters('the_content', $text);
    $text = strip_tags(str_replace(']]>', ']]>', $text));
	$text = trim($text);
     if (strlen($text) > $max_char) {
		 $text = substr($text, 0, $max_char+1);
         $text = utf8_conver($text);
		 $text = str_replace(array("\r", "\n"), ' ', $text);
		 $text .= $more_text;
		 if ($limit_type == 'content'){
		 $text = "<p>".$text."</p>";
			if($more){$text .= "<div class='readmore'><a href='".get_permalink()."' title='查看全文点击此处' rel='nofollow'>继续阅读</a></div>";}
		 }
        echo $text;
    } else {
		 if ($limit_type == 'content'){$text = "<p>".$text."</p>";}
        echo $text;
    }
}

function utf8_conver($str) {
    $len = strlen($str);
    $hex = ''; // 初始化 $hex 变量
    for ($i = $len - 1; $i >= 0; $i -= 1) {
        $hex .= ' ' . ord($str[$i]);
        $ch = ord($str[$i]);
        if (($ch & 128) == 0) {
            return substr($str, 0, $i); // 如果字符为单字节，则返回前面的部分
        }
        if (($ch & 192) == 192) {
            // 如果字符以 110xxxxx 或 1110xxxx 开头，则需要检查下一个字节
            return substr($str, 0, $i);
        }
    }
    return $str; // 如果字符串本身就是多字节 UTF-8 字符，则返回原始字符串
}

//显示广告

function WinyskyFeedAdditional($content){
	if(is_single() or is_feed()){//文章开头广告
		if (get_option('Abook_ad1')!="") {
			$html= '<div class="postbefore">'.stripslashes(get_option('Abook_ad1')).'</div>';
		}
		//处理文章附加
		$this_post_info= '<div class="clear"></div>';
		if(get_option('Abook_postbottom') == 'TRUE'){
			$this_post_info.='<div class="sharebar"> <span>分享到：</span><a rel="nofollow" id="twitter-share" title="Twitter">Twitter</a><a rel="nofollow" id="kaixin001-share" title="开心网">开心网</a><a rel="nofollow" id="renren-share" title="人人网">人人网</a><a rel="nofollow" id="douban-share" title="豆瓣">豆瓣</a><a rel="nofollow" id="fanfou-share" title="饭否">饭否</a><a rel="nofollow" id="sina-share" title="新浪微博">新浪微博</a><a rel="nofollow" id="tencent-share" title="腾讯微博">腾讯微博</a><a rel="nofollow" id="netease-share" title="163微博">163微博</a></div>';
			$this_post_info.='<div class="copyright_info">本文地址:<a href="'.get_permalink().'">'.get_permalink().'</a><br />';
			$this_post_info.= stripslashes(get_option('Abook_postadditional'));
			$this_post_info.='</div>';
		}

		if(is_single()){
		$content .= $this_post_info;
		}else{
			global $id;
			$comment_num = get_comments_number($id);
			
			if($comment_num==0){
				$rss_comment_tip="<BR />&raquo;当你从RSS阅览器里看到这篇文章时，还没有评论，还不赶紧过来抢沙发？ ";
			}elseif($comment_num>=1 && $comment_num<30){
				$rss_comment_tip="<BR />&raquo;当你从RSS阅览器里看到这篇文章时，已有 <strong> ".$comment_num." </strong>条评论 ,欢迎过来看看 !";
			}else{
				$rss_comment_tip="<BR />&raquo;当你从RSS阅览器里看到这篇文章时，已有超过<strong> ".$comment_num." </strong>条评论,火热盖楼进行中...";
			}
			$content .= $this_post_info.$rss_comment_tip;
			if(get_option('Abook_wumi') == 'FALSE'){
				$content .='<div class="clear"></div><BR /><ul>'.winyrelated_post('false').'</ul>';
			}
		}
	
	}
	return $content;
}
add_filter('the_content', 'WinyskyFeedAdditional', 1000);
function time_diff( $time_type ){

    switch( $time_type ){
        case 'comment':    //如果是评论的时间
            $time_diff = current_time('timestamp') - get_comment_time('U');
            if( $time_diff <= 86400 )    //24 小时之内
                echo human_time_diff(get_comment_time('U'), current_time('timestamp')).' 前';    //显示格式 OOXX 之前
            else
                printf(__('(%1$s at %2$s)'), get_comment_date('Y.m.d'),  get_comment_time());    //显示格式 X年X月X日 OOXX 时
            break;
        case 'post';    //如果是日志的时间
            $time_diff = current_time('timestamp') - get_the_time('U');
            if( $time_diff <= 86400 )
                echo human_time_diff(get_the_time('U'), current_time('timestamp')).' 前';
            else
                the_time('Y.m.d');
            break;
    }
}


/* 首页图片 by winy*/

function post_thumbnail($width = "220px", $height = "100px") {
    global $post;

    $thumbnail = ''; // 初始化缩略图内容
    
    // 获取文章的特色图片
    if (has_post_thumbnail($post->ID)) {
        $thumbnail_url = get_the_post_thumbnail_url($post->ID, array($width, $height));
        $thumbnail = '<a title="' . $post->post_title . '" href="' . get_permalink() . '"><img src="' . $thumbnail_url . '" alt="" class="thumb" /></a>';
    } else {
        // 如果文章没有特色图片，则随机选择默认图片
        $random_thumb_url = get_template_directory_uri() . '/images/default_thumb/' . rand(1, 22) . '.jpg';
        $thumbnail = '<a title="' . $post->post_title . '" href="' . get_permalink() . '"><img src="' . $random_thumb_url . '" alt="" class="thumb" /></a>';
    }

    return $thumbnail;
}

/*带缩略图的相关文章 by winy 
	origin by william
*/
function winyrelated_post($post_thumb){
$post_num = 6; // 文章数量
$exclude_id = $post->ID; 
$posttags = get_the_tags(); $i = 0;
$related_thumb='';
if ( $posttags ) { $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';
$args = array(
	'post_status' => 'publish',
	'tag_slug__in' => explode(',', $tags), // 只选 tags 的文章.
	'post__not_in' => explode(',', $exclude_id), // 排除已出现的文章
	'caller_get_posts' => 1,
	'orderby' => 'comment_date', 
	'posts_per_page' => $post_num
);
query_posts($args);
 while( have_posts() ) { the_post(); 
 if($post_thumb){
 $related_thumb = post_thumbnail($width = "100px",$height = "100px"); }?>
    <li><?php echo $related_thumb;?><?php the_title(); ?>(<?php comments_popup_link('0', '1', '%'); ?>)</li>
<?php
    $exclude_id .= ',' . $post->ID; $i ++;
 } wp_reset_query();
}
if ( $i < $post_num ) { // 當 tags 文章數量不足, 再取 category 補足.
$cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
$args = array(
	'category__in' => explode(',', $cats), // 只選 category 的文章.
	'post__not_in' => explode(',', $exclude_id),
	'caller_get_posts' => 1,
	'orderby' => 'comment_date',
	'posts_per_page' => $post_num - $i
);
query_posts($args);
 while( have_posts() ) { the_post();
 if($post_thumb){
	$related_thumb = post_thumbnail($width = "100px",$height = "100px");} ?>
    <li><?php echo $related_thumb;?><?php the_title(); ?>(<?php comments_popup_link('0', '1', '%'); ?>)</li>
	
<?php
    $i ++;
 } wp_reset_query();
}
if ( $i  == 0 )  echo '<li>尚无相关文章</li>';
}

/*短代码
* 短代码样式部分移植自付费主题iStudio和loper并向下兼容
*/

/////////////点击隐藏/展开 /////////////
function single_toggle($atts, $content=null){
	extract(shortcode_atts(array("title"=>'(点击展开)'),$atts));	
	return '<p class="tg_t">'.$title.'</p><p class="tg_c" style="display:none;">'.$content.'</p>';
}
add_shortcode('toggle','single_toggle');
//////////////警示/////////////
function warningbox($atts, $content=null, $code="") {
					$return = '<div class="warning shortcodestyle">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
add_shortcode('warning' , 'warningbox' );
//////////////禁止/////////////
function nowaybox($atts, $content=null, $code="") {
					$return = '<div class="noway shortcodestyle">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
add_shortcode('noway' , 'nowaybox' );
//////////////购买/////////////
function buybox($atts, $content=null, $code="") {
					$return = '<div class="buy shortcodestyle">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
add_shortcode('buy' , 'buybox' );
//////////////项目版/////////////
function taskbox($atts, $content=null, $code="") {
					$return = '<div class="task shortcodestyle">';
					$return .= $content;
					$return .= '</div>';
					return $return;
				}
add_shortcode('task' , 'taskbox' );
//////////////豆瓣播放器/////////////
function doubanplayer($atts, $content=null){
				extract(shortcode_atts(array("auto"=>'0'),$atts));
				return '<p><embed src="'.get_bloginfo("template_url").'/images/shortcode/doubanplayer.swf?url='.$content.'&amp;autoplay='.$auto.'" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="400" height="30"></p>';
				}
add_shortcode('music','doubanplayer');	
//////////////下载/////////////				
function downlink($atts,$content=null){
					extract(shortcode_atts(array("href"=>'https://'),$atts));
				return '<div class="but_down"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a><div class="clear"></div></div>';
				}
add_shortcode('Downlink','downlink');
//////////////flv播放器/////////////	
function flvlink($atts,$content=null){
				extract(shortcode_atts(array("auto"=>'0'),$atts));
				return'<p><embed src="'.get_bloginfo("template_url").'/images/shortcode/flvideo.swf?auto='.$auto.'&flv='.$content.'" menu="false" quality="high" wmode="transparent" bgcolor="#ffffff" width="378" height="212" name="flvideo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="https://www.adobe.com/go/getflashplayer_cn" /></p>';
				}
				add_shortcode('flv','flvlink');
				
				///////////////////////



