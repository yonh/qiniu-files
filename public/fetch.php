<?php
include_once __DIR__ . '/__include.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

if (!is_login()) {
	go_login();
}

$config = get_config();

$accessKey = $config['qiniu']['accessKey'];
$secretKey = $config['qiniu']['secretKey'];
$bucket = $config['qiniu']['bucket'];// 要列取的空间名称
$domain = $config['qiniu']['domain'];// 要列取的空间名称


$auth = new Auth($accessKey, $secretKey);
$bmgr = new BucketManager($auth);

if (isset($_POST['token']) && isset($_POST['fetch_url'])) {
	$access_token_verify = access_token_verify($_POST['token']);
	if (!$access_token_verify) {
		die('error token');
	}

	$url = $_POST['fetch_url'];
	if (!isset($_POST['key']) || empty(trim($_POST['key']))) {
		$key = null;
	} else {
		$key = $_POST['key'];
	}

} else {
	echo "error fetch url";
	die;
}

session_write_close();

list($ret, $err) = $bmgr->fetch($url, $bucket, $key);
echo "fetch " . htmlentities($url, ENT_QUOTES) ." to bucket: $bucket  key: " . htmlentities($key, ENT_QUOTES) . "<br/>";


if ($err !== null) {
	echo "<h1>Error</h1>";
	echo htmlentities($err->message(), ENT_QUOTES);
} else {
	echo "Success";
}

echo "<br/><a href='/index.php'>go back index</a>";
