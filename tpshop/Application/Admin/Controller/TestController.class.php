<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\GoodsModel;
class TestController extends Controller{
    public function index(){
        //模型实例化
        //$model = new \Admin\Model\GoodsModel();
        //$model = new GoodsModel();
    //}    
    // public function chaxun(){
    //     // $model = D('Goods');
    //     $advice_model = M('Advice',null);
    //     //$data = $model -> where(['goods_number' => ['GT','300']]) -> select();
    //     $data = $advice_model -> alias('a') -> field('a.*,u.username') -> join("left join tpshop_user as u on a.user_id=u.id") ->select();
    //     //dump($data);
    }
        //密码加密
    public function jiami(){
        $password = '123456';
        $new_password = encrypt_password($password);
        echo $new_password;
    }
    
    //测试xss攻击的防范
    public function test_xss(){
        $name = 'test<script>alert("abc");</script>test';
        $name = remove_xss($name);

        dump($name);
    }
}