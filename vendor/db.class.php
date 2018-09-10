<?php


class db{
	private static $link,$result;
    public function __construct($config){


         // 'dns'=>'127.0.0.1',
         // 'username'=>'root',
         // 'password'=>'root',
         // 'port'=>3306,
         // 'charset'=>'utf8',
         // 'dataBase'=>'test',
       // var_dump($config); die;

        self::$link= mysqli_connect($config['dns'],
        	                  $config['username'],
        	                  $config['password'],
        	                  $config['dataBase']);

    }	

    public function query($sql){
       self::$result=mysqli_query(self::$link,$sql);
       return $this;
      
    }
    /*返回所有结果集*/
    public function fetchAll(){

      return mysqli_fetch_all(self::$result,MYSQLI_ASSOC);
    }
    /*返回结果集中第一条*/
    public function fetchOne(){
      return mysqli_fetch_array(self::$result,MYSQLI_ASSOC);
    }
    /*插入*/
    public function insert($tableName,$array=array()){
              $v='(';
              foreach($array as $key=>$value){
                 
                 is_string($value)?$value="'".$value."'":'';

                 $v.=$value.',';
              }
              $v=rtrim($v,',');
              $v.=')';

              $sql=' insert into '.$tableName.
                    ' values '.$v;
              
              mysqli_query(self::$link,$sql);
              return mysqli_insert_id(self::$link);
    }
    /*
       update student set name='a' where id=1;

     */

    public function update($tableName,$array=array(),$condition=''){
        
       foreach($array as $key=>$value){
           if(is_string($value)) $value="'".$value."'";
           $v.=$key.'='.$value.',';
       } 
       $v=rtrim($v,',');
       $sql='update '.$tableName. 
           ' set '.$v.
           ' where '.$condition;
         
       $this->query($sql);
    }
    /*
       
       delete from student where id=1;
     */

    public function delete($tableName,$condition){

       $sql='delete from '.$tableName.' where '.$condition;
       $this->query($sql);

    }

    // public function lastInsertId(){
    //     return 
    // }
}