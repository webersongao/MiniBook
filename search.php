<?php get_header(); ?>
<div id="main">
			<div id="mybook">
			
				<div class="pagecontent single-left">


<?php if ( have_posts() ) : ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1><?php printf( __( ' %s的搜索结果:'), '<span>' . get_search_query() . '</span>' ); ?></h1>
		
				<div class="entry" ><div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
				<?php while ( have_posts() ) : the_post(); ?>
<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="查看文章: <?php the_title_attribute(); ?>"><?php if (is_sticky()) {echo "[置顶]";} ?><?php winyexcerpt(30, '...', 'title');?></a></h3>
<div class="postmeta">
		<span class="data"><?php time_diff( $time_type = 'post' ); ?></span><span class="cate"><?php the_category(',') ?></span><span class="view"><?php if(function_exists('the_views')) { the_views(); }elseif(function_exists('post_views')){post_views('点击：', '');} ?></span>
	</div>
	<?php winyexcerpt(180,'...','content',false); ?>
	<?php endwhile;?>
</div>
	</div>
</div>
</div>				
<?php else: ?>
				<div id="post-0" class="post no-results not-found">
					<h1><?php _e( 'Nothing Found'); ?></h1>
					<div class="entry" ><div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
						<p><?php _e( '抱歉没有找到相关文章'); ?></p>
						
				</div>
	</div>
</div>
</div>
<?php endif; ?>
</div>
		<div class="pagecontent single-right">
			<div id="comments" >
<div id="comment_header">
<ul>
<li class="comment_switch_active"><a href="javascript:void(0);">最热文章</a></li>
<li ><a href="javascript:void(0);">最新文章</a></li>
<li ><a href="javascript:void(0);">随机文章</a></li>
<li><a href="javascript:void(0);">分类目录</a></li>
<li ><a href="javascript:void(0);">标签云</a></li>


</ul>
<div class="clear"></div>
</div>
<div id="comment_content">
<div id="hot" >
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
<div id="recent" style="display:none;">
<h3>最新文章</h3>
<ul style="padding:5px 15px;">
  <?php $posts = query_posts("orderby=date&showposts=10" ); ?>  
                <?php while(have_posts()) : the_post(); ?> 
                <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php winyexcerpt(30, '...', 'title'); ?></a></li> 
                <?php endwhile; ?> 
		</ul>
</div>	
<div id="random" style="display:none;">
<h3>随机文章</h3>
<ul style="padding:5px 15px;">
   <?php $rand_posts = get_posts("numberposts=10&orderby=rand"); foreach( $rand_posts as $post ) : ?>
				<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php winyexcerpt(30, '...', 'title'); ?></a></li>
				<?php endforeach; ?>
		</ul>
</div>


<div id="categories" style="display:none;">
	<ul><?php wp_list_categories('title_li=<h3>' .('分类目录') . '</h3>'); ?></ul>
</div>

<div class="wp-tag-cloud" style="display:none;">
	<h3>标签云</h3>
		<ul><li><?php wp_tag_cloud('smallest=12&largest=18');?></li></ul>
	</div>

	
		</div>		
		</div>
		</div>

</div></div></div>
 <?php get_footer(); ?>