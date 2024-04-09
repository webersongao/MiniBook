<?php
/*
Template Name: gallery
*/?>

 <?php get_header(); echo '	<div id="main">';?>

			
			<div id="mybook">
			
				<div class="pagecontent single-left">
				<?php if(have_posts()) : while(have_posts()): the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="查看文章: <?php the_title_attribute(); ?>"><?php if (is_sticky()) {echo "[置顶]";} ?><?php the_title(); ?></a></h1>
					

<div class="entry" >
<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
<p><iframe src="https://pic.winysky.com" width="380" height="380" frameborder="0" scrolling="no"></iframe></p>
</div>
</div>
</div>
<div class="clear"></div>
	 </div>
				<?php endwhile;endif; // End the loop. Whew. ?>
			</div>

<div class="pagecontent single-right">
				<?php comments_template(); ?>	
		</div>


 <?php echo '</div></div>';get_footer(); ?>
