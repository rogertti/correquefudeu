<?php
	define("DB_TYPE","mysql");
	define("DB_HOST","localhost");
	define("DB_USER","u578932509_blog");
	define("DB_PASS","melancia#123");
	define("DB_DATA","u578932509_blog");
	
	$pdo = new PDO("".DB_TYPE.":host=".DB_HOST.";dbname=".DB_DATA."",DB_USER,DB_PASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec("SET NAMES utf8");
?>