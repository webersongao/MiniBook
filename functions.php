<?php

// debug - if true the errors will display below footer when admin login
//define('winysky_DEBUG', true);
error_reporting(0);

// functions for other functions
include_once TEMPLATEPATH.'/includes/options/theme_options.php';

// app dir
define('Abook_Include', TEMPLATEPATH.'/includes');

/**
 * include all PHP script
 * @param string $dir
 * @return unknown_type
 */
function IncludeAll($dir){
	$dir = realpath($dir);
	if($dir){
		$files = scandir($dir);
		sort($files);
		foreach($files as $file){
			if($file == '.' || $file == '..'){
				continue;
			}elseif(preg_match('/\.php$/i', $file)){
				include_once $dir.'/'.$file;
			}
		}
	}
}
// include functions from yinheli
IncludeAll( Abook_Include );

?>
<?php

//add_filter('the_content','post_copyright_content');
function post_copyright_content($text){
	ob_start();
	post_copyright();
	$post_copyright_content = ob_get_contents();
	ob_end_clean();
	return $text.$post_copyright_content;
}
//......................版权函数结束.................
/* Mini Gavatar Cache by Willin Kan. */
function my_avatar($avatar) {
  $tmp = strpos($avatar, 'http');
  $g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
  $tmp = strpos($g, 'avatar/') + 7;
  $f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
  $w = get_bloginfo('wpurl');
  $e = ABSPATH .'avatar/'. $f .'.jpg';
  $t = 1209600; //設定14天, 單位:秒
  if ( !is_file($e) || (time() - filemtime($e)) > $t ) { //當頭像不存在或文件超過14天才更新
    
  } else  $avatar = strtr($avatar, array($g => $w.'/avatar/'.$f.'.jpg'));
  
  return $avatar;
}
add_filter('get_avatar', 'my_avatar');
// -- END ----------------------------------------
/* <<小牆>> Anti-Spam v1.84 by Willin Kan. */
class anti_spam {
  function anti_spam() {
    if ( !current_user_can('read') ) {
      add_action('template_redirect', array($this, 'w_tb'), 1);
      add_action('init', array($this, 'gate'), 1);
      add_action('preprocess_comment', array($this, 'sink'), 1);
    }
  }
    //設欄位
  function w_tb() {
    if ( is_singular() ) {
      ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
      "textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
    }
  }
  // 檢查
  function gate() {
    $w = 'w';
    if ( !empty($_POST[$w]) && empty($_POST['comment']) ) {
      $_POST['comment'] = $_POST[$w];
    } else {
      $request = $_SERVER['REQUEST_URI'];
      $way     = isset($_POST[$w]) ? '手動操作' : '未經評論表格';
      $spamcom = isset($_POST['comment']) ? $_POST['comment'] : '';
      $_POST['spam_confirmed'] = "請求: ". $request. "\n方式: ". $way. "\n內容: ". $spamcom. "\n -- 記錄成功 --";
    }
  }
  // 處理
  function sink( $comment ) {
      // 不管 Trackbacks/Pingbacks
      if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment;

      // 已确定为 spam
      if ( !empty($_POST['spam_confirmed']) ) {
          // 标记为 spam, 留在数据库检查是否误判.
          add_filter('pre_comment_approved', function() {
              return "spam";
          });
          $comment['comment_content'] = "[ 小牆判斷這是Spam! ]\n". $_POST['spam_confirmed'];
          $this->add_black( $comment );
      } else {
          // 检查头像
          $avatar_data = get_avatar_data( $comment['comment_author_email'] );
          if ( empty( $avatar_data['found'] ) ) {
              // 没头像的标记为待审
              add_filter('pre_comment_approved', function() {
                  return "0";
              });
              //$this->add_black( $comment );
          }
      }
      return $comment;
  }
  // 列入黑名單
  function add_black( $comment ) {
    if (!($comment_author_url = $comment['comment_author_url'])) return;
    if (strpos($comment_author_url, '//')) $comment_author_url = substr($comment_author_url, strpos($comment_author_url, '//') + 2);
    if (strpos($comment_author_url, '/'))  $comment_author_url = substr($comment_author_url, 0, strpos($comment_author_url, '/'));
    update_option('blacklist_keys', $comment_author_url . "\n" . get_option('blacklist_keys'));
  }
}
$anti_spam = new anti_spam();
// -- END ----------------------------------------

function my_scripts_method() {
    wp_enqueue_script( 'jquery' );
}    
add_action('wp_enqueue_scripts', 'my_scripts_method');
?>