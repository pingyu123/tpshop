<?php
namespace Admin\Controller;
use Think\Controller;
class ManagerController extends Controller{
        //管理员列表页
        public function index(){
            //实例化模型
            $model = D('manager');
            $data = $model -> select();
            $this->assign('data',$data);

            $this->display();
        }
        //管理员新增页
        public function add(){
            $this->display();
        }
        //管理员修改页
        public function edit(){
            $this->display();
        }
}