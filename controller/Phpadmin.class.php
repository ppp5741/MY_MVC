<?php
class Phpadmin{
  public static function login(){
  	  //var_dump($GLOBALS['db']);sd
  	//查询
    //$aa= $GLOBALS['db']->query('show tables;')->fetchAll();
    //插入
   // $aa=$GLOBALS['db']->insert('student',array('id'=>'','name'=>'dage','subject'=>'test','score'=>23));
    //修改
    //$GLOBALS['db']->update('student',array('name'=>'ssssss'),'name="dage" and id=11');
    //
   // $GLOBALS['db']->delete('student','name="dage"');
    //调用模板
    //
     //情况1： 已经登录后，访问登录页面; 则直接可以操作数据库
    //
    

     if(isset($_SESSION['pma_username']) or !empty($_SESSION['pma_username'])){
        echo ''; die; 
     }
     include 'view/Phpmyadmin4/login.html';
  }

  public static  function loginCheck(){
      //查询用户是否存于，mysql库中的user表里
       $user=$_POST['pma_username'];
       $pssw=$_POST['pma_password'];
       $result= $GLOBALS['db']->query('select User,Password from mysql.user where User="'.$user.'" limit 1' )->fetchOne();
       //如果返回的值不为空，则说明用户存在
       if(empty($result)) die('此用户不存在！');
  

       //数据库密码验证 使用的技术是，select 密码=password(密码);
       $is_pass=$GLOBALS['db']->query('select "'.$result['Password'].'"=password("'.$pssw.'") as res;')->fetchOne();

       //登录成功后，SESSION设置,并用跳转到操作页面
       if($is_pass['res']==1){
           $_SESSION['pma_username']=$user;
      }
       else
       {
         die('mima bu zheng que');
       }
  }
  //MYSQL操作页面,得到数据库列表
   public static function home(){
       $result= $GLOBALS['db']->query("show databases" )->fetchAll();
      // var_dump($result); die;
       include 'view/phpmyadmin4/home.html';
  }
  //得到数据库内数据表列表
    public static function getTable(){

        $database=$_GET['database'];
        $GLOBALS['db']->query("use $database;");
        $result= $GLOBALS['db']->query("show tables;" )->fetchAll();
        $jsonString=json_encode($result);
        $jsonString=str_replace($database,'name',$jsonString);
        $result=json_decode($jsonString,true);//如果 没TRUE则默认转换成OBJECT对象
        include 'view/phpmyadmin4/tableList.html';
        die;

    }
    //得到三级菜单下的，两个设置（字段，索引）
    public static function getFieldIndex(){
        $database=$_GET['database'];
        $table=$_GET['table'];
        include 'view/phpmyadmin4/fieldIndex.html';
        die;
    }
    //得到数据表下的字段列表与索引列表 ，，
    public static function getFildIndexList(){
        $database=$_GET['database'];
        $table   =$_GET['table'];
        $choose  =$_GET['choose'];
        if($choose=='field'){
            $result= $GLOBALS['db']->query("desc ".$database.'.'.$table )->fetchAll();
        }
        if($choose=='index'){
            $result= $GLOBALS['db']->query("show index from ".$database.'.'.$table )->fetchAll();
        }
       //var_dump($result); die;
        include 'view/phpmyadmin4/'.$choose.'List.html';
        die;
    }
    /*新建数据表*/
    public static function createTable(){
       $database=$_GET['database'];
       include 'view/phpmyadmin4/createTable.html';
       die;
    }
}