<?php
 namespace Home\Model;
 use Think\Model\MongoModel;
 Class VipsModel extends MongoModel 
 {       
 //可以是空的。
 	 Protected $_idType = self::TYPE_INT;
     protected $_autoinc =  true;
 }