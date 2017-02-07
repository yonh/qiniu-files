<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Symfony\Component\Yaml\Yaml;

session_start();

function go_index() {
	header("Location: http://" . $_SERVER['HTTP_HOST']);
	exit;
}

function go_login() {
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/login.php");
	exit;
}

function get_config() {
	$config = Yaml::parse(file_get_contents(__DIR__ . "/../config.yaml"));

	return $config;
}
function get_access_token() {
	if (isset($_SESSION['access_token'])) {
		return $_SESSION['access_token'];
	} else {
		return access_token_generate();
	}
}

function access_token_generate() {
	$token = md5(time() . rand(1000, 9999));
	$_SESSION['access_token'] = $token;

	return $token;
}

function access_token_verify($token) {
	$access_token = get_access_token();
	unset($_SESSION['access_token']);
	return $token === $access_token;
}

function is_login() {
	$config = get_config();

	if (empty($_SESSION['username'])) {
		return false;
	}

	if ($config['user']['username'] == $_SESSION['username']) {
		return true;
	} else {
		return false;
	}
}

function user_verify($user, $pass) {
	$config = get_config();
	$user_verify = $user === $config['user']['username'];
	$pass_verify = password_verify($pass, $config['user']['password']);

	return $user_verify && $pass_verify;
}

function user_login($username) {
	$_SESSION['username'] = $username;
}

function user_logout() {
	unset($_SESSION['username']);
}