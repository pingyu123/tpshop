<?php
namespace Admin\Controller;
//use Think\Controller;
class IndexController extends CommonController{
    //后台首页
    public function index(){
        //图表需要的数据
        $data = [6,10,15,-5];
        $data = json_encode($data);

        $this-> assign('data',$data);
        
        //调用后台首页模板
        $this->display();
    }

}