<?php
/*
Template Name: archives
*/
?>

 <?php get_header();?>
<div id="main">
			
		<div id="mybook">
			
				<div class="pagecontent single-left">
				<?php if(have_posts()) : while(have_posts()): the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="查看文章: <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
						

<div class="entry" >
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
<?php the_content(); ?>
<p>以下是全部文章归档：<a id="expand_collapse" href="#">全部展开/收缩</a></p>
<div id="archives"><?php archives_list_SHe(); ?></div>
</div>
</div>
	</div>
<div class="clear"></div>
	 </div>
				<?php endwhile;endif; // End the loop. Whew. ?>
			</div>

<div class="pagecontent single-right">
<div id="comments" >
<div id="comment_header">
<ul>
<li class="comment_switch_active"><a href="javascript:void(0);">标签云</a></li>
<li><a href="javascript:void(0);">读者墙</a></li>
<li><a href="javascript:void(0);">分类目录</a></li>
<li><a href="javascript:void(0);">最热文章</a></li>
<li><a href="javascript:void(0);">友情链接</a></li>
</ul>
<div class="clear"></div>
</div>
<div id="comment_content">
	<div class="wp-tag-cloud">
	<h3>标签云</h3>
		<ul><li><?php wp_tag_cloud('smallest=12&largest=18');?></li></ul>
	</div>
<div class="friend" style="display:none;">
	<h3>读者墙</h3>
		<?php
$exclude_emails = get_bloginfo ('admin_email');//希望被排除的email请添加到此数组中
$imgsize = 40;//头像大小，单位px
global $imgsize ;
global $exclude_emails;
//$cur_time_span = date('Y-m-d H:i:s', strtotime('-1 week'));
//$cur_time_span = date('Y-m-d H:i:s', strtotime('-1 Month')) ;
$cur_time_span = date('Y-m-d H:i:s', strtotime('-3 Month'));
//$cur_time_span = date('Y-m-d H:i:s', strtotime('-1 Year'));
	
	global $wpdb;
	$request = "SELECT count(comment_ID) comment_nums,comment_author, comment_author_email,comment_author_url   FROM  {$wpdb->prefix}comments where comment_date>'".$cur_time_span."' AND comment_type='' AND comment_approved=1 AND comment_author_url != '' group by comment_author_email order by count(comment_ID) DESC ";
	
	$comments = $wpdb->get_results($request);
  $output='';
    foreach ($comments as $comment) {
		if (($comment->comment_author_email==$exclude_emails)||$comment->comment_nums <=3 || $comment->comment_author_url==''  )  continue;
		$url = $comment->comment_author_url;
		$output .= "<a href='".$url."' title='".$comment->comment_author." (".$comment->comment_nums.")'>".get_avatar($comment->comment_author_email,$imgsize)."</a>";
		
       }
	   
	
	$output = "<div class='wall' style='padding:2px 25px;'>".$output."</div>";
echo $output;
?>
</div>
<div id="categories" style="display:none;">
	<ul><?php wp_list_categories('title_li=<h3>' .('分类目录') . '</h3>'); ?></ul>
</div>

<div id="hot" style="display:none;">
<h3>最热文章</h3>
<ul style="padding:5px 15px;">
   <?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 10");
     foreach ($result as $post) {
      setup_postdata($post);
      $postid = $post->ID;
      $title = $post->post_title;
      $commentcount = $post->comment_count;
      if ($commentcount != 0) { ?>
       <li><a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>">
        <?php echo $title ?></a> (<?php echo $commentcount ?>)</li>
        <?php } } ?>
		</ul>
</div>
<div id="link" style="display:none;">
	<ul><?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>'); ?></ul>
</div>
		</div>
		</div>		
		</div>
<script type="text/javascript">
/* <![CDATA[ */		
/* 存档页面 jQ伸缩 */
jQuery(document).ready(function($){
 $('#expand_collapse,.archives-yearmonth').css({cursor:"s-resize"});
 $('#archives ul li ul.archives-monthlisting').hide();
 $('#archives ul li ul.archives-monthlisting:first').show();
 $('#archives ul li span.archives-yearmonth').click(function(){$(this).next().slideToggle('fast');$(".entry").tinyscrollbar_update('relative');return false;});
 //以下下是全局的操作
 $('#expand_collapse').toggle(
 function(){
 $('#archives ul li ul.archives-monthlisting').slideDown('fast');
 $(".entry").tinyscrollbar_update('relative');
 },
 function(){
 $('#archives ul li ul.archives-monthlisting').slideUp('fast');
 $(".entry").tinyscrollbar_update('relative');
 });
///友情链接图标favicon
$(".blogroll a").each(function(e){
 $(this).prepend("<img src=https://www.google.com/s2/favicons?domain="+this.href.replace(/^(http:\/\/[^\/]+).*$/, '$1').replace( 'https://', '' )+" style=padding-right:5px;>");
});
});
/* ]]> */
</script>		
</div>
</div>
</div>
<?php get_footer(); ?>
