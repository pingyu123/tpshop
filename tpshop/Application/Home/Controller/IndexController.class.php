<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //判断静态文件是否存在
        $file = './Static/index.html';
        if(file_exists($file) && (time() - filemtime($file) < 60) ){
            //跳转静态文件
            redirect('/Static/index.html');
        }
        //查询商品分类
        $cate = M('Category') -> select();
        //展示数据
        $this -> assign('cate',$cate);

        //展示指定分类的商品,比如分类id 11的
        $category = M('Category') -> where(['id' => 11]) -> find();
        $this -> assign('category',$category);
        $goods = M('Goods') -> where(['cate_id' => 11]) -> limit(12) -> select();
        $this -> assign('goods',$goods);
        // layout('layout');
        // $this->display();
        //真静态,获取模板内容生成静态文件
        //调用模板
        //从ob缓存输出的数据
        //使用框架写法
        $content = $this -> fetch();
        //保存到静态文件页面中
        file_put_contents('./Static/index.html', $content);
        //跳转到访问页面
        redirect('/Static/index.html');
    }

    //单个商品页面
    public function detail(){
        //商品基本信息
        $id = I('get.id');
        $goods = M('Goods') -> where(['id' => $id]) -> find();
        //dump($goods);die;
        $this -> assign('goods',$goods);
        //商品相册图片
        $goodspics = M('Goodspics') -> where(['goods_id' => $id]) -> select();
        $this -> assign('goodspics',$goodspics);

        //属性值信息
        $attr = M('Attribute') -> where(['type_id' => $goods['type_id']]) -> select();
        $this -> assign('attr',$attr);

        //属性值信息
        $goodsattr = M('GoodsAttr') -> where(['goods_id' => $id]) -> select();
        $this -> assign('goodsattr',$goodsattr);
        $this -> display();
        
    }
}