<?php
include_once __DIR__ . '/__include.php';

if (is_login()) {
	go_index();
}



if (isset($_POST['token']) && isset($_POST['user']) && isset($_POST['pass'])) {
	$access_token_verify = access_token_verify($_POST['token']);
	$user_verify = user_verify($_POST['user'], $_POST['pass']);
	if (!$access_token_verify) {
		die("token error");
	}
	if (!$user_verify) {
		die('user error');
	}

	user_login($_POST['user']);
	go_index();

} else {
	$token = access_token_generate();
}

?>
<form action="login.php" method="post">
	<input type="hidden" name="token" value="<?php echo $token;?>" />
<table style="margin:0 auto;">
	<tr>
		<td>user:</td>
		<td><input name="user" /></td>
	</tr
	<tr>
		<td>pass:</td>
		<td><input name="pass" /></td>
	</tr>
	<tr><td></td><td><input type="submit" value="login"/></td></tr>
</table>


</form>
