<?php
include_once __DIR__ . '/__include.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

if (!is_login()) {
	go_login();
}

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
	user_logout();
	go_login();
}

$config = get_config();

$accessKey = $config['qiniu']['accessKey'];
$secretKey = $config['qiniu']['secretKey'];
$bucket = $config['qiniu']['bucket'];// 要列取的空间名称
$domain = $config['qiniu']['domain'];// 要列取的空间名称

$auth = new Auth($accessKey, $secretKey);
$bucketMgr = new BucketManager($auth);


// 要列取文件的公共前缀
$prefix = '';
// 上次列举返回的位置标记，作为本次列举的起点信息。

if (isset($_GET['marker'])) {
	$marker = $_GET['marker'];
} else {
	$marker = "";
}

// 本次列举的条目数
$limit = 20;
// 列举文件
list($iterms, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit);

echo "<meta charset='utf-8'/>";
echo '<link rel="stylesheet" href="/static/css/public.css">';


echo "<a href='/index.php?logout=1'>Logout</a>";

if ($err !== null) {
	echo "<h1>Error</h1>";
	echo htmlentities($err->message(), ENT_QUOTES);
} else {
	echo "<pre>";
	echo "<ul>";
	foreach ($iterms as $item) {
		echo "<li>";
		echo "<a href=\"http://$domain/".$item['key']."\">" . $item["key"] . "</a>&lt;" . sprintf("%1\$.2f",($item['fsize']/1024/1024) ). "MB&gt;";
		//print_r($item);
		echo "</li>";
	}

	if ($marker) {
		echo "<a href='/index.php?marker=$marker'>下一页</a>";
	}

}

