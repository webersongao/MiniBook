<?php get_header(); ?>
		<div id="main">

			<span id="next_page_button"></span>
			<span id="prev_page_button"></span>
			<div id="mybook">
				<?php query_posts('posts_per_page=8');?>
				<?php  $i=0;$j=0;if(have_posts()) : ?>
				<?php while(have_posts()): the_post(); ?>

				<?php 
				if($i%2==0){
					if($j%2!=0){
						echo '<div class="pagecontent page-right">';
					}else{
						echo '<div class="pagecontent page-left">';
					}
					$j++;
					}
					?>
				<!-- #post-## -->

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h2 ><a href="<?php the_permalink() ?>" rel="bookmark" title="查看文章: <?php the_title_attribute(); ?>"><?php if (is_sticky()) {echo "[置顶]";} ?><?php winyexcerpt(30, '...', 'title');?></a><span class="com_num"><?php comments_popup_link('抢沙发！', '1+', '%+'); ?></span></h2>
						<div class="postmeta">
		<span class="data"><?php time_diff( $time_type = 'post' ); ?></span><span class="cate"><?php the_category(',') ?></span><span class="view"><?php if(function_exists('the_views')) { the_views(); }elseif(function_exists('post_views')){post_views('点击：', '');} ?></span>
	</div>

<div class="postentry" <?php if($i%3!=0){echo 'style="float:left;"';}else{echo 'style="float:right;"';}?>>
<?php winyexcerpt(180); ?>
</div>
<div class="postimg" <?php if($i%3==0){echo 'style="float:left;"';}else{echo 'style="float:right;"';}?>>
<?php echo post_thumbnail( $width = "100px",$height = "100px");?>
</div>
<div class="clear"></div>
			</div><!-- #post-## -->
				<?php if($i%2!=0){
						echo '<div class="pagenum"></div></div>';
					}
					?>
				
				<?php $i++;?>
				<?php endwhile;
				 if(($i<8)&&($i%2!=0)){
						echo '<div class="pagenum"></div></div>';
					}
					?>
				<?php endif; // End the loop. Whew. ?>
			</div>

		
	</div><!-- #main-## -->
</div>
		<?php	get_footer(); ?>