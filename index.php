<?php
   /*如果PATH_INFO为空，则默认为 welcome/index */
   header('content-type:text/html;charset=utf8');
   if(!isset($_SERVER['PATH_INFO']) or empty($_SERVER['PATH_INFO']))                        $_SERVER['PATH_INFO']='welcome/index';

   $pathInfo=$_SERVER['PATH_INFO'];
   /*URL 路由*/
   $pathInfo= ltrim($pathInfo,'/');
   $actionFunction=explode('/',$pathInfo);

   /*Controller要求首字母大写*/
   $actionFunction[0]= ucfirst($actionFunction[0]);
   // $actionFunction[1]= ucfirst($actionFunction[1]);

   /*DB准备中*/
   include 'vendor/db.class.php';
   include 'common/db.config.php';
   $GLOBALS['db']=new db($config['db']);    

   /*定义__PUBLIC__变量*/
   $project=$_SERVER['SCRIPT_NAME'];
   $project=ltrim($project,'/');
   $project=explode('/',$project);
   $host=$_SERVER['HTTP_HOST'];
   define("__PUBLIC__",'http://'.$host.'/'.$project[0].'/public/');

   /*开启SESSION*/
   session_start();

   /*加载路由类*/
   include 'controller/'.$actionFunction[0].'.class.php';
   call_user_func_array($actionFunction,array(''));

