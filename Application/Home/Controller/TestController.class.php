<?php
//声明命名空间 namespace 分组目录名\Controller目录名
namespace Home\Controller;
//引入控制器父类 Think命名空间Controller是父类控制器的类名
use Think\Controller;
//定义当前控制器类
class TestController extends Controller{
    //定义方法
    public function index(){
        //echo "Hello, This is Test index";
        $this -> display('index');
    }

    //接入参数
// Account Sid
// 479be5194bf8dc3d50597b226e8438a8
// Auth Token
// d9ef58c38fa5f4d9a1e7528963655d47
// 重置
// Rest URL
    //测试 接口调用 发送请求
    public function test_curl(){
        //请求参数
        $url = "http://www.tpshop.com/Home/Test/test_api";
        $post = true;
        $params = ['id' => 100, 'page' => 10];
        //调用curl_request函数
        $res = curl_request($url, $post, $params);
        //dump($res);
    }

    //编写的接口,用于测试请求
    public function test_api(){
        //接收数据
        $data = I('post.');
        //接收数据..直接返回
        //返回数据
        $this -> ajaxReturn($data);
    }

    //快递查询
    public function kuaidi(){
    //准备参数及url    
    //https://www.kuaidi100.com/query?type=yunda&postid=3101314976598
        $url = "https://www.kuaidi100.com/query";
        $type = 'yunda';
        $postid = '3101314976598';
        $url = $url . '?type=' . $type . '&postid=' . $postid;
        //发送请求
        $res = curl_request($url, false, array(), true);
        //dump($res);die;
        if(!$res){
            die('请求失败');
        }
        $data = json_decode($res, true);
        if($data['status'] != 200){
            die($data['message']);
        }
        //dump($data);// 最终需要的数据是$data['data']
        //直接输出展示
        foreach($data['data'] as $k => $v){
            echo $v['time'],'----',$v['context'],'<br>';
        }
    }

    //测试邮件发送
    public function sendmail(){
        $email = "384676057@qq.com";
        $subject = "乌尔宁";
        $body = "呀三亚死";
        $res = sendmail($email, $subject, $body);
        //dump($res);
        if($res === true){
            //发送成功
            echo "success";
        }else{
            //发送失败
            echo $res;
        }
    }
}