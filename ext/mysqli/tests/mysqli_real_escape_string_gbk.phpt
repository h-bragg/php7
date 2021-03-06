--TEST--
mysqli_real_escape_string() - gbk
--SKIPIF--
<?php
if (version_compare(PHP_VERSION, '5.9.9', '>') == 1) {
	die('skip set character set not functional with PHP 6 (fomerly PHP 6 && unicode.semantics=On)');
}

require_once('skipif.inc');
require_once('skipifemb.inc');
require_once('skipifconnectfailure.inc');
require_once('connect.inc');

if (!$link = mysqli_connect($host, $user, $passwd, $db, $port, $socket)) {
	die(sprintf("skip Cannot connect to MySQL, [%d] %s\n",
		mysqli_connect_errno(), mysqli_connect_error()));
}
if (!mysqli_set_charset($link, 'gbk'))
	die(sprintf("skip Cannot set charset 'gbk'"));

mysqli_close($link);
?>
--FILE--
<?php

	require_once("connect.inc");
	require_once('table.inc');

	var_dump(mysqli_set_charset($link, "gbk"));

	if ('�İ汾\\\\�İ汾' !== ($tmp = mysqli_real_escape_string($link, '�İ汾\\�İ汾')))
		printf("[004] Expecting \\\\, got %s\n", $tmp);

	if ('�İ汾\"�İ汾' !== ($tmp = mysqli_real_escape_string($link, '�İ汾"�İ汾')))
		printf("[005] Expecting \", got %s\n", $tmp);

	if ("�İ汾\'�İ汾" !== ($tmp = mysqli_real_escape_string($link, "�İ汾'�İ汾")))
		printf("[006] Expecting ', got %s\n", $tmp);

	if ("�İ汾\\n�İ汾" !== ($tmp = mysqli_real_escape_string($link, "�İ汾\n�İ汾")))
		printf("[007] Expecting \\n, got %s\n", $tmp);

	if ("�İ汾\\r�İ汾" !== ($tmp = mysqli_real_escape_string($link, "�İ汾\r�İ汾")))
		printf("[008] Expecting \\r, got %s\n", $tmp);

	if ("�İ汾\\0�İ汾" !== ($tmp = mysqli_real_escape_string($link, "�İ汾" . chr(0) . "�İ汾")))
		printf("[009] Expecting %s, got %s\n", "�İ汾\\0�İ汾", $tmp);

	var_dump(mysqli_query($link, "INSERT INTO test(id, label) VALUES (100, '��')"));

	mysqli_close($link);
	print "done!";
?>
--EXPECTF--
bool(true)
bool(true)
done!
