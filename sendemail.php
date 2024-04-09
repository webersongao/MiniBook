<?php
/**
 * 联系页面, 邮件发送.
*/

//只可以用post方法
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Allow: POST');
	header("HTTP/1.1 405 Method Not Allowed");
	header("Content-type: text/plain");
    exit;
}

// Sets up the WordPress Environment
require_once(preg_replace( '/wp-content.*/', '', __FILE__ ).'wp-load.php');

session_start();

$adminEmail = get_option('admin_email');

if(!$adminEmail){
	fail(__('Admin\'s E_mail address is empty!'));
}

// get post data
$name = isset($_POST['name']) ? trim($_POST['name']) : null;
$from = isset($_POST['from']) ? trim($_POST['from']) : null;
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : null;
$vcode = isset($_POST['vcode']) ? trim($_POST['vcode']) : null;
$content = isset($_POST['mailcontent']) ? stripslashes(trim($_POST['mailcontent'])) : null;

// check post data
if(!$name || !$from || !$subject || !vcode){
	fail(__('请填上所有项目(昵称/地址/主题/验证码)'));
}

if(!is_email($from)){
	fail(__('请输入一个有效的邮箱地址'));
}

if($_SESSION['VCODE']  !== $vcode) {
	fail(__('验证码错误'));
}

if(!$content){
	fail(__('请输入邮件内容'));
}

// format $content to HTML by the 'the_content' filter
$content = apply_filters('the_content', $content);

// data are ok? format the data and send
if(!class_exists('PHPMailer')){
	include_once ABSPATH . WPINC . '/class-phpmailer.php';
}

$mail = new PHPMailer();

// Empty out the values that may be set
$mail->ClearAddresses();
$mail->ClearAllRecipients();
$mail->ClearAttachments();
$mail->ClearBCCs();
$mail->ClearCCs();
$mail->ClearCustomHeaders();
$mail->ClearReplyTos();

/*if you can't send email, please try 'smtp' method. Here is gmail for example.
$mail->Mailer = 'smtp';
$mail->Host = 'smtp.qq.com';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = '349509546@qq.com'; // SMTP 用户名 (SMTP username)
$mail->Password = 'password'; // 密码 (SMTP password)
*/

$mail->CharSet = get_option('blog_charset');
$mail->IsHTML(true);
$mail->From = $from;
$mail->FromName = $name;
$mail->Subject = $subject;
$mail->AddAddress($adminEmail);
// send a copy to ..
$mail->AddCC($from, $name);
$mail->Body = apply_filters('the_content', $content);

// do send
$result = @$mail->Send();

unset($_POST['vcode']);

if($result){
	$response =  sprintf(__('恭喜, %1$s. 邮件已发送成功!'),$name);
	//fail($response);
	}
else{
	$response = sprintf(__('抱歉! 系统出错~您可以直接给我邮件： %1$s'),$adminEmail);
	fail($response);
}
