<div id="foot">
<div id="footbar">


</div>
</div>
<?php wp_footer(); ?>
<?php if (get_option('Abook_analytics')!="") {?>
<?php echo stripslashes(get_option('Abook_analytics')); ?>
<?php }?>
 
</body>
</html>