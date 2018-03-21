<?php
namespace Admin\Controller;
class TypeController extends CommonController{
    //商品类型新增页
    public function add(){
        //一个方法处理两个逻辑
        if(IS_POST){
            //表单提交
            $data = I('post.');
            //数据检测
            if(!$data['type_name']){
                $this -> error('类型名称不能为空');
            }
            //添加数据到数据表
            $res = M('Type') -> add($data);
            if($res){
                $this -> success('添加成功',U('Admin/Type/index'));
            }else{
                $this -> error('添加失败');
            }
        }else{
            $this->display();
        }

    }
    //商品类型列表
    public function index(){
        //查询商品类型数据
        $type = M('Type') -> select();
        $this -> assign('type',$type);
        $this->display();
    }
}