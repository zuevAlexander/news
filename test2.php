<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 22:42
 */
include_once("model/post.php");

$a = new Post();
$b = 2;
$c= $a->getAll();
var_dump($c); 