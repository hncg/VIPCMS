<?php
 namespace Home\Model;
 use Think\Model\MongoModel;
 Class UserModel extends MongoModel 
 {       
 //可以是空的。
 	 Protected $_idType = self::TYPE_INT;
     protected $_autoinc =  true;
 	 public  function cg(){
	 	echo "cg";
 	 }
 	
 }