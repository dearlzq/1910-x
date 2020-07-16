<?php
$redis = new Redis();       //实例化Redis

//连接redis
$redis->connect('127.0.0.1',6379);
$redis->auth('asdfghjkl0113');

var_dump($redis);
//
//$redis->auth('123456abc');
//
//$k1 = 'xxx';
//echo $redis->get($k1);
