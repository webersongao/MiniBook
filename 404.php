<?php get_header(); echo '<div id="main">';?>

			
			<div id="mybook">
			
				<div class="pagecontent single-left">
<div class="page" >
						<h1>404</h1>


<div class="entry" >
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
<p><?php _e('Sorry, no such page'); ?>... 哦也，这儿啥也没有,去看看其它的吧</p>
<p><img src="<?php bloginfo('stylesheet_directory'); ?>/images/404.jpg"  alt="" style="display:block; margin:0 auto;border-radius:15px;-webkit-border-radius: 15px;-moz-border-radius:15px;"/></p>
</div>
	 </div>

			</div>	

	 </div>

			</div>	
<div class="pagecontent single-right">
<h3 style="margin:20px 0 0 0;">推荐阅读</h3>
<ul id="related_area">
<?php
$post_num = 6; // 數量設定.
$args = array(
	'post_status' => 'publish',
	'caller_get_posts' => 1,
	'orderby' => 'comment_count', // 依評論日期排序.
	'posts_per_page' => $post_num
);
query_posts($args);
 while( have_posts() ) { the_post(); 
 $related_thumb = post_thumbnail($width = "100px",$height = "100px"); ?>
    <li><?php echo $related_thumb;?><?php the_title(); ?></li>
	<?php }
 wp_reset_query();
 
?>
</ul>
 		</div>
</div>

 <?php echo '</div></div>';get_footer(); ?>
	