<?php
namespace Admin\Model;
use Think\Model;
class AdviceModel extends Model{
    //指定实际要关联的真实数据表名称.不会自动加载
    //实际数据表明(包含表前缀)
    protected $trueTableName  =  'advice';
}