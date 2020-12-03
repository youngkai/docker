<?php

//phpinfo();

$mysql = new mysqli('mysql', 'root', 'root', 'test');
$res = $mysql->query('show tables');
var_dump($res);