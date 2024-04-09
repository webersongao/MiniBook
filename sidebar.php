<div id="sidebar" class="post">
	<ul class="alignleft">
	<?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>				
				<?php dynamic_sidebar( 'primary-widget-area' ); ?>
		<?php else: ?>
	<li id="search">
			<h3>搜索</h3>
			<?php get_search_form(); ?>
		</li>
			<?php wp_list_pages('title_li=<h3>' .('页面') . '</h3>'); ?>
		<?php endif; ?>
	</ul>
	<ul class="alignright">
		<?php if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>
			<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
					
		<?php else: ?>	
		<?php wp_list_categories('title_li=<h3>' .('分类') . '</h3>'); ?>
	
		<?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>'); ?>
		
		<?php endif; ?>
	</ul>
</div>
<div id="sidebar" class="post">
		<ul class="alignright">
		<?php if ( is_active_sidebar( 'thirdary-widget-area' ) ) : ?>
				<?php dynamic_sidebar( 'thirdary-widget-area' ); ?>
					
		<?php else: ?>	
		<?php wp_list_categories('title_li=<h3>' .('分类') . '</h3>'); ?>
	
		<?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>'); ?>
		
		<?php endif; ?>
	</ul>
</div>