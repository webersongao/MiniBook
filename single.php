<?php if(isset($_GET['act'])&& $_GET['act']== 'singlePage' ):?>
<?php echo '<!--ajaxpagebegin-->';?>
 <?php else:?>
 <?php get_header(); echo '	<div id="main">';?>
 <?php endif;?>	
<span id="next_page_button"><?php previous_post_link('%link'); ?></span>
			<span id="prev_page_button"><?php next_post_link('%link'); ?></span>
			
			<div id="mybook">
			
				<div class="pagecontent single-left">
				<?php if(have_posts()) : while(have_posts()): the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="查看文章: <?php the_title_attribute(); ?>"><?php if (is_sticky()) {echo "[置顶]";} ?><?php the_title(); ?></a></h1>
						<div class="postmeta">
		<span class="data"><?php time_diff( $time_type = 'post' ); ?></span><span class="cate"><?php the_category(',') ?></span><span class="view"><?php if(function_exists('the_views')) { the_views(); }elseif(function_exists('post_views')){post_views('点击：', '');} ?></span><span class="com_num"><a href="#respond">写评论</a></span>
	</div>

<div class="entry" >
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
<?php the_content(); ?>
</div>
	</div>
</div>


	 </div>
				<?php endwhile;endif; // End the loop. Whew. ?>
			</div>

<div class="pagecontent single-right">
				<?php comments_template(); ?>	
		</div>
 </div>

<?php if(isset($_GET['act'])&& $_GET['act']== 'singlePage' ):?>
<?php echo '<!--ajaxpageend-->';?>
 <?php else:?>
 <?php echo '</div></div>';get_footer(); ?>
 <?php endif;?>		