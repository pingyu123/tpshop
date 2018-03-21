<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{
    //前台登陆页面
    public function login(){
        if(IS_POST){
            //表单提交
            $data = I('post.');
            //dump($data);
            if(!$data['username'] || !$data['password']){
                $this -> error('用户名或密码不能为空');
            }
            //实例化模型 根据用户名查询用户表
            $user = D('User') -> where("phone = '{$data['username']}' or email = '{$data['username']}'") -> find();
            if($user && $user['password'] == encrypt_password($data['password'])){
                if($user['is_check'] != 1){
                    //账号未激活
                    $this -> error("请先激活账号");
                }
                //登陆成功
                //设置登陆标识
                session('user_info', $user);
                //dump(session);die;
                //调用Cart模型的cookieTodb方法,迁移购物车数据
                D('Cart') -> cookieTodb();
                //获取登录成功后的跳转地址
                //扩展，通常登录后，如果要返回之前页面，可以利用响应头中的referer字段，记录的是当前请求是从哪个页面跳转过来的。
                $back_url = session('?back_url') ? session('back_url') : U('Home/Index/index');
                $this -> success("登陆成功", $back_url);
            }else{
                $this -> error('用户名或密码错误');
            }
        }else{
                layout(false);
                //调用模板
                $this->display();
        }
    }

    //退出
    public function logout(){
        //销毁session
        session(null);
        //跳转到登陆页
        $this -> redirect('Home/User/login');
    }

    //注册页面
    public function register(){
        if(IS_POST){
            //接收数据
            $data = I('post.');
            //参数检测
            if($data['phone']){
                //手机号注册
                //验证码检测
                $code = session('register_code_'. $data['phone']);
                if($data['code'] != $code){
                    $this -> error('验证码错误');
                }
                //验证码有效期
                $send_time = session('register_time_'. $data['phone']);//发送时间
                if(time() . $send_time > 3000){
                    //验证码已失效
                    $this -> error("验证码已失效");
                }
                //验证码校验成功之后,销毁验证码
                session('register_code_'. $data['phone'], null);
                //设置为已激活
                $data['is_check'] = 1;
            }
            if($data['email']){
                //邮箱注册, 生成验证码
                $data['email_code'] = mt_rand(1000,9999);
            }
            $model = D('User');
            $create = $model -> create($data);
            if(!$create){
                $error = $model -> getError() ?: '参数错误';
                $this -> error($error);
            }
            //将数据添加到用户表
            $res = $model -> add();
            if($res){
                if($data['email']){
                    //发送激活邮件
                    //拼接激活地址
                    $url = "http://www.tpshop.com/Home/User/jihuo/id/{$res}/code/" . $data['email_code'];
                    $subject = "TP商城注册激活邮件";
                    $body = "欢迎注册,请点击以下连接进行激活: <br><a href='$url'>$url</a><br>,
                    如果没有自动跳转,请复制链接到浏览器直接打开.";
                    sendmail($data['email'], $subject, $body);
                    //提示用户收取邮件进行激活
                    $this -> success('注册成功,请进行激活', U('Home/User/login'));
                }else{
                    $this -> success('注册成功', U('Home/User/login'));
                }
            }else{
                $this -> error('注册失败');
            }
        }else{
                    //临时关闭模板布局
        layout(false);
        $this->display();
        }
    }

    //邮件激活
    public function jihuo(){
        //接收桉树
        $data = I('get.');
        //验证用户是否存在
        $user = M('User') -> where(['id' => $data['id']]) -> find();
        //比对验证码
        if($user && $data['code'] == $user['email_code']){
            //激活成功,将is_check字段设置为1
            $user['is_check'] = 1;
            M('User') -> save($user);
            $this -> success('激活成功,请登陆',U('Home/User/login'));
        }else{
            //用户名或验证码不存在
            $this -> error('请不要修改参数');
        }
    }
}