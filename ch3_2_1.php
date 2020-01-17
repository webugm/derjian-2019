<?php
$var = "abc";

fun();

function fun(){
  // 這裡是區域範圍
  //global $var;
  $var2 = "123";
  echo $var;
}