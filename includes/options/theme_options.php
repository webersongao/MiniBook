<?php

$themename = "Abook";
$shortname = "Abook";

//$categories = get_categories('hide_empty=0&orderby=name');
//$wp_cats = array();
//foreach ($categories as $category_list ) {
  //     $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
//}

$options = array (
 
array( "name" => $themename." Options",
       "type" => "title"),
//SEO设置
    array( "name" => "主题SEO设置",
           "type" => "section"),
	array( "type" => "open"),

	array(	"name" => "网站关键词",
			"desc" => "例如：折腾WordPress,生活记录,独立博客,winy（多个关键词用英文的逗号隔开）",
			"id" => $shortname."_keywords",
			"type" => "text",
            "std" => ""),
	array(	"name" => "网站描述",
			"desc" => "针对搜索引擎设置的网页描述。（最好200字以内）",
			"id" => $shortname."_description",
			"type" => "textarea",
            "std" => ""),
	array("name" => "自定义订阅地址",
            "desc" => "",
            "id" => $shortname."_feed",
            "type" => "text",
            "std" => ""),	
//功能模块设置
    array( "type" => "close"),
	array( "name" => "功能模块设置",
			"type" => "section"),
	array( "type" => "open"),	
	
	array(  "name" => "站点标题LOGO设置",
			"desc" => "是否启用图片logo（如果选择TRUE，请自行修改主题/images下的logo.png）",
            "id" => $shortname."_logo",
            "type" => "select",
            "std" => "FALSE",
            "options" => array("FALSE", "TRUE")),
	array("name" => "文章链接和分享",
            "desc" => "是否在单篇文章底部显示文章地址和分享链接",
            "id" => $shortname."_postbottom",
            "type" => "select",
            "std" => "FALSE",
			"options" => array("FALSE", "TRUE")),	
	 array("name" => "文章底部插入内容",
            "desc" => "输入文章底部插入内容，例如版权或作者介绍（上面的选项“TRUE”才有效）",
            "id" => $shortname."_postadditional",
            "type" => "textarea",
            "std" => "<strong>声明:</strong> 本文采用 <a href=\"https://creativecommons.org/licenses/by-nc-sa/3.0/\" rel=\"nofollow external\"><abbr title=\"署名-非商业性使用-相同方式共享\">BY-NC-SA</abbr></a> 协议进行授权. 转载请注明 "),
	array(  "name" => "特殊英文字体支持",
			"desc" => "主题部分英文字体将采用自定义字体，该字体保存在主题目录里，开启该选项可获得更加优美的英文字体渲染，但是可能会拖慢主题载入速度",
            "id" => $shortname."_font",
            "type" => "select",
            "std" => "TRUE",
            "options" => array("TRUE", "FALSE")),
	
	array(  "name" => "无觅插件支持",
			"desc" => "默认的无觅插件会显示在文章页底部，开启这个选项会指定无觅插件显示位置，请在无觅插件中选用自定义设置。（将替换文章页右侧默认的相关文章和RSS中主题附带的相关文章）如果未启用无觅插件，请选择“False”。",
            "id" => $shortname."_wumi",
            "type" => "select",
            "std" => "FALSE",
            "options" => array("FALSE", "TRUE")),
//广告和统计
    array( "type" => "close"),
	array( "name" => "广告和统计",
			"type" => "section"),
	array( "type" => "open"),

	
    array("name" => "顶部广告代码",
            "desc" => "文章页和订阅顶部显示，推荐大小200*200",
            "id" => $shortname."_ad1",
            "type" => "textarea",
            "std" => ""),
	
	array("name" => "统计代码",
            "desc" => "通常用来放置Google Analytics等分析统计代码或其他验证信息",
            "id" => $shortname."_analytics",
            "type" => "textarea",
            "std" => ""),      
//通告和订阅
    array( "type" => "close"),
	array( "name" => "通告信息和SNS站点",
			"type" => "section"),
	array( "type" => "open"),
	
	array("name" => "通告栏",
            "desc" => "显示站点通告",
            "id" => $shortname."_notice",
            "type" => "textarea",
            "std" => ""),
	
	array("name" => "输入twitter地址",
            "desc" => "",
            "id" => $shortname."_twitter",
            "type" => "text",
            "std" => ""),      
	array("name" => "输入新浪微博地址",
            "desc" => "",
            "id" => $shortname."_sina",
            "type" => "text",
            "std" => ""),    
	array("name" => "输入腾讯微博地址",
            "desc" => "",
            "id" => $shortname."_qq",
            "type" => "text",
            "std" => ""),    			
	  
	array(	"type" => "close") 
);

function mytheme_add_admin() {

    if ( isset($_GET['page']) && $_GET['page'] == basename(__FILE__) ) {

        // 检查用户权限
        if ( ! current_user_can('manage_options') ) {
            return;
        }

        if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) {
            global $options;
            foreach ($options as $value) {
                update_option( $value['id'], $_REQUEST[ $value['id'] ] );
            }
            wp_redirect(admin_url('admin.php?page=theme_options.php&saved=true'));
            exit;
        }
        elseif ( isset($_REQUEST['action']) && 'reset' == $_REQUEST['action'] ) {
            global $options;
            foreach ($options as $value) {
                delete_option( $value['id'] );
            }
            wp_redirect(admin_url('admin.php?page=theme_options.php&reset=true'));
            exit;
        }
    }
}
add_action('admin_init', 'mytheme_add_admin');


function mytheme_add_init() {

$file_dir=get_bloginfo('template_directory');
wp_enqueue_style("functions", $file_dir."/includes/options/options.css", false, "1.0", "all");
wp_enqueue_script("rm_script", $file_dir."/includes/options/rm_script.js", false, "1.0");
}
function mytheme_admin() {
 
global $themename, $shortname, $options;
$i=0;
 
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' 主题设置已保存</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' 主题已重新设置</strong></p></div>';
 
?>
<div class="wrap rm_wrap">
<div id="icon-themes" class="icon32"><br /></div>
<h2><?php echo $themename; ?> 设置</h2>
<p>友情提示：本主题由<a href="https://winysky.com" target="_blank">Winy</a>设计,售后支持:admin@winysky.com</p>
<p>为了保证作者和用户之间的利益，禁止以任何形式未经授权的使用、复制或转卖。</p>
<div class="rm_opts">
<form method="post">
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?>
 
<?php break;
 
case "close":
?>
 
</div>
</div>
<br />

 
<?php break;
 
case "title":
?>

 
<?php break;
 
case 'text':
?>

<div class="rm_input rm_text">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
 	<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 
 </div>
<?php
break;
 
case 'textarea':
?>

<div class="rm_input rm_textarea">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
 	<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
 <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 
 </div>
  
<?php
break;
 
case 'select':
?>

<div class="rm_input rm_select">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	
<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
<?php foreach ($value['options'] as $option) { ?>
		<option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; }?>><?php echo $option; ?></option><?php } ?>
</select>

	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
</div>
<?php
break;
 
case "checkbox":
?>

<div class="rm_input rm_checkbox">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	
<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />


	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
 </div>
<?php break; 
case "section":

$i++;

?>

<div class="rm_section">
<div class="rm_title"><h3><img src="<?php bloginfo('template_directory')?>/includes/options/clear.png" class="inactive" alt="""><?php echo $value['name']; ?></h3><span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="保存设置" />
</span><div class="clearfix"></div></div>
<div class="rm_options">

 
<?php break;
 
}
}
?>
 
<input type="hidden" name="action" value="save" />
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="恢复默认" />
<input type="hidden" name="action" value="reset" /><span style="padding-left:5px;color:red;">注意：将删除自定义设置</span>
</p>
</form>
 </div> 


<div class="shortcut">

<div class="rm_section" style="padding:5px">
    <div style="padding-left:20px;">
	<h2>短代码格式</h2>
	<h3>Abook支持以下短代码样式</h3>
	<P>写文章时可以加入下列短代码（可视化与HTML两种模式均可直接加入）</p>
		<h4>点击隐藏/展开区域</h4>
		<p>默认隐藏(点击展开)：　<code>[toggle]隐藏区域内容[/toggle]</code></p>
		<p>自定义隐藏提示文字：<code>[toggle title="<span style="color:red;">提示文字</span>"]隐藏区域内容[/toggle]</code></p>
		
		<h4>音乐播放器</h4>
		<p>默认不自动播放：　<code>[music]https://www.xxx.com/xxx.mp3[/music]</code></p>
		<p>自动播放：　<code>[music auto=1]https://www.xxx.com/xxx.mp3[/music]</code></p>
	
		<h4>灰色项目面板短代码</h4>
      <p><code>[task]文字内容[/task]</code></p>
	
	  <h4>红色禁止面板短代码</h4>
      <p><code>[noway]文字内容[/noway]</code></p>

	  <h4>黄色警告面板短代码</h4>
      <p><code>[warning]文字内容[/warning]</code></p>

	   <h4>绿色购买面板短代码</h4>
      <p><code>[buy]文字内容[/buy]</code></p>

	  <h4>下载样式</h4>
      <p><code>[Downlink href="https://www.xxx.com/xxx.zip"]download xxx.zip[/Downlink]</code></p>


      <h4>Flv播放器</h4>
      <p>注意：如果要使用这个播放器，一定要添加flv格式的视频文件</p>
      <p>默认不自动播放：　<code>[flv]https://www.xxx.com/xxx.flv[/flv]</code></p>
      <p>自动播放：　<code>[flv auto="1"]https://www.xxx.com/xxx.flv[/flv]</code></p>

	  <p>说明:短代码样式部分移植自付费主题iStudio和loper并向下兼容</p>
    </div>
  </div>
</div>
<?php
}
?>
<?php
add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');


