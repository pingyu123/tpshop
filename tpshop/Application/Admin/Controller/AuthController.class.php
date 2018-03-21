<?php
namespace Admin\Controller;
class AuthController extends CommonController{
    //后台权限新增
    public function add(){
        //一个方法两个逻辑
        if(IS_POST){
            //接收表单提交
            $data = I('post.');
            //添加到数据表
            $res = M('Auth') -> add($data);
            if($res){
                $this-> success('添加成功',U('Admin/Auth/index'));
            }else{
                $this-> error('添加失败');
            }
        }else{
            $top = M('Auth') ->where("pid = 0") -> select();
            $this->assign('top',$top);
            $this->display();
        }
        
    }
    //后台权限列表
    public function index(){
        //查询权限表数据
        $auth = M('Auth') -> select();

        $auth = getTree($auth);
        $this->assign('auth',$auth);
        $this->display();
    }
}