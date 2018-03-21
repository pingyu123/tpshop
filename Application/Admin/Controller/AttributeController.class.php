<?php
namespace Admin\Controller;
class AttributeController extends CommonController{
	//属性添加
	public function add(){
		//一个方法两个逻辑
		if(IS_POST){
			$data = I('post.');
			// dump($data);
			//数据检测 Todo

			//将数据添加到数据表
			$res = M('Attribute') -> add($data);
			if($res){
				$this -> success('添加成功', U('Admin/Attribute/index'));
			}else{
				$this -> error('添加失败');
			}
		}else{
			//查询所有的商品类型数据，用于下拉列表展示
			$type = M('Type') -> select();
			$this -> assign('type', $type);
			$this -> display();
		}
		
	}

	//商品属性列表
	public function index(){
		//查询属性信息 连表查询 tpshop_type表，获取类型名称
		$attr = M('Attribute') -> alias('t1') -> field('t1.*, t2.type_name') -> join("left join tpshop_type as t2 on t1.type_id = t2.type_id") -> select();
		// dump($attr);die;
		$this -> assign('attr', $attr);
		$this -> display();
	}
}