<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller{
    //购物车页面
    public function cart(){
        //获取数据,调用Cart模型中的getAllCart方法查询购物车中所有数据
        $data = D('Cart') -> getAllCart();
        //遍历$data,查询页面需要商品基本信息和属性相关信息
        foreach($data as $k => &$v){
        //查询商品表根据ID选取指定内容,返回一条数据  
        $goods = M('Goods') -> field(['goods_name, goods_price, goods_small_img']) -> where(['id' => $v['goods_id']]) -> find();
        $v['goods'] = $goods; 
        // dump($goods);die; 
        //商品属性值相关信息,连表tpshop_attribute,()
        $goodsattr = M('GoodsAttr') -> alias('t1') -> field('t1.*, t2.attr_name') -> join('left join tpshop_attribute as t2 on t1.attr_id = t2.attr_id') -> where("t1.id in ({$v['goods_attr_ids']})") -> select();
        $v['goodsattr'] = $goodsattr;
        }    
        $this -> assign('data',$data);
        $this -> display();
    }

     //加入购物车方法
     public function addcart(){
         if(IS_POST){
            //处理表单提交
            $data = I('post.');
            //dump ($data);die;
            //参数检测
            if(!$data['goods_id'] || !$data['goods_attr_ids'] || !$data['number']){
                $this -> error('参数错误');
               
            }
            //将数据加入购物车,调用Cart模型的addCart方法
            $res = D('Cart') -> addCart($data['goods_id'],$data['number'],$data['goods_attr_ids']);
            //dump ($res);die;
            if($res){
                //添加成功
                //查询商品信息
                $goods = D('Goods') -> where(['id' => $data['goods_id']]) -> find();
                $this -> assign('goods',$goods);
                $this->display();
            }else{
                //添加失败
                $this-> error('添加失败');
            }
         }else{
             $this -> redirect('Home/Cart/cart');
            
         }

    }

    //ajax请求修改购买数量
    public function changenum(){
        $data = I('post.');
        //dump($data);die;
        //参数判断
        if(!$data['goods_id'] || !$data['new_number'] || !$data['goods_attr_ids']){
            //参数错误
            $return = array('code' => 10002, 'msg' => '参数错误');
            $this -> ajaxReturn($return);
        }
        $res = D('Cart') -> changeNum($data['goods_id'],$data['new_number'],$data['goods_attr_ids']);
        if($res){
            //成功
            $return = array('code' => 10000, 'msg' => 'success');
        }else{
            $return = array('code' => 10001, 'msg' => '修改失败');
        }
        $this -> ajaxReturn($return);
    }

    //ajax删除购物车中的指定记录
    public function ajaxdel(){
        $data = I('post.');
        //参数检测
        if(!$data['goods_id'] || !$data['goods_attr_ids']){
            //参数错误
            $return = array('code' => 10002, 'msg' => '参数错误');
            $this -> ajaxReturn($return);
        }
        $res = D('Cart') -> delCart($data['goods_id'],$data['goods_attr_ids']);
        if($res){
            //成功
            $return = array('code' => 10000, 'msg' => 'success');
        }else{
            $return = array('code' => 10001, 'msg' => '删除失败');
        }
        $this -> ajaxReturn($return);
    
    }
     //前台结算页面
     public function flow2(){
        
        //登录判断
        if(!session('?user_info')){
            //没有登录,跳转到登陆页
            //设置返回的url,登陆成功跳转到购物车页面
            session('back_url',U('Home/Cart/cart'));
            $this -> redirect('Home/User/login');
        }
        //接收参数cart_ids
        $cart_ids = I('get.cart_ids');
        //dump($cart_ids);die;
        // if($cart_ids){
        //     $this -> success;
        // }
        //查询收获地址信息
        $user_id = session('user_info.id');
        //dump($user_id);die;
        $address = M('Address') -> where(['user_id' => $user_id]) -> select();
        
        $this -> assign('address',$address);
        //查询购物记录信息
        //查询购物车记表 和商品表 连表查询
        $cart = D('Cart') -> alias('t1') -> field('t1.*, t2.goods_name, t2.goods_small_img, t2.goods_price') -> join('left join tpshop_goods t2 on t1.goods_id = t2.id') -> where("t1.id in ($cart_ids)") -> select();
        //dump($cart);die;
        //查询商品属性表信息, 连表 tpshop_attrbute
        $total_price = 0;
        foreach($cart as $k => &$v){
            $goodsattr = M('GoodsAttr') -> alias('t1') -> field('t1.*, t2.attr_name') -> join('left join tpshop_attribute as t2 on t1.attr_id = t2.attr_id') -> where("t1.id in ({$v['goods_attr_ids']})") -> select();
            $v['goodsattr'] = $goodsattr;
            //计算总价格,',';]]]
            $total_price += $v['number'] * $v['goods_price'];

        }
        // dump($cart);die;
        $this -> assign('cart',$cart);
        $this -> assign('total_price',$total_price);
        $this -> display();
    }

    //生成订单
    public function createorder(){
        if(IS_POST){
            //接收数据
            $data = I('post.');
            //dump($data);die;
            //参数检测
            //向订单加一条数据
            //订单编号
            $order_sn = time() . uniqid();
            $user_id = session('user_info.id');
            //根据cart_ids查询购物车表
            //查询购物车表 和商品表 和连表查询
            $cart_ids = $data['cart_ids'];
            // dump($cart_ids);die;
            $cart = D('Cart') -> alias('t1') -> field('t1.*, t2.goods_price') -> join('left join tpshop_goods t2 on t1.goods_id = t2.id') -> where("t1.id in ($cart_ids)") -> select();
            //计算金额
            $order_amount = 0;
            foreach($cart as $k => $v){
                $order_amount += $v['number'] * $v['goods_price'];
            }
            //组装订单表的一条数据
            $row = array(
                'order_sn' => $order_sn,
                'order_amount' => $order_amount,
                'user_id' => $user_id,
                'address_id' => $data['address_id'],
                'shipping_type' => $data['shipping_type'],
                'pay_type' => $data['pay_type'],
                'create_time' => time()
            );
            //可以考虑加事务
            $res = D('Order') -> add($row);
            if($res){
                //$res 订单表主键id
                //向订单商品表添加数据
                //遍历查询的购物记录数据,对应添加到订单商品表
                foreach($cart as $k => $v){
                    $row = array(
                        'order_id' => $res,
                        'goods_id' => $v['goods_id'],
                        'goods_attr_ids' => $v.['goods_attr_ids'],
                        'number' => $v['number'],
                        'goods_price' => $v['goods_price']
                    );
                    $ordergoods[] = $row;

                }
                //批量添加
                D('OrderGoods') -> addAll($ordergoods);
                //订单数据处理成功,从购物车表清除指定的购物记录
                D('Cart') -> where("id in ($cart_ids)") -> delete();
                //之后就是支付流程
                if($data['pay_type'] == 0){
                    //银联卡
                }elseif($data['pay_type'] == 1){
                    //微信支付
                }elseif($data['pay_type'] == 2){
                    //支付宝支付,跳转到支付宝网站.支付成功后调回本网站
                    //模拟跳转到支付成功页面
                    $html = "<form action='/Application/Tools/alipay/alipayapi.php' class='alipayform' id='alipayform' method='post'>
                    <input type='text' name='WIDout_trade_no' id='out_trade_no' value='{$order_sn}'>
                    <input type='text' name='WIDsubject' value='TP电商商品'></div>
                    <input type='text' name='WIDtotal_fee' value='{$order_amount}'></div>
                    <input type='text' name='WIDbody' value='发货'></div>
                </form><script>document.getElementById('alipayform').submit();</script>";
                            echo $html;
                }else{

                }        
                }else{
                    $this -> error('订单创建失败');
                }
            }else{
                $this -> redirect('Home/Index/index'); 
            }
        
    }

    
    //付款成功页面
    public function flow3(){
        $total_fee = I('get.totle_fee');
        $this -> assign('total_fee', $total_fee);
        $this->display();
    }

    //异步通知地址
    public function notify(){
        //修改订单状态
        $data = I('post.');
    }
}