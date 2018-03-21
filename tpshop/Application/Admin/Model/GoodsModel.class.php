<?php
//声明命名空间
namespace Admin\Model;
//引入父类模型
use Think\Model;
//定义当前模型类
class GoodsModel extends Model{
    //根据需要写一些属性和方法

    //字段映射
    protected $_map = array(
        //表单中的字段名 => 数据表字段名
        "name" => "goods_name",
        "price" => "goods_price",
        "number" => "goods_number",
    );

    //自动验证
    protected $_calidate = array(
        //array(验证字段1,验证规则(require[字段必须],email[邮箱],url[URL地址],currency[货币],number[数字]),错误提示,[验证条件,附加规则,验证时间])
        array('goods_name', 'require', '商品名称不能为空'),
        array('goods_price', 'require', '商品价格不能为空'),
        array('goods_price', 'currency', '商品价格格式不正确'),
        array('goods_number', 'require', '商品数量不能为空'),
        array('goods_number', 'number', '商品数量格式不正确')
    );

    //自动完成
    protected $_auto = array(
        //array(完成字段1,完成规则,[完成条件.附加规则])
        array('goods_create_time',1,'function'),
    );

    //封装一个logo图片上传的方法
    public function upload_logo(&$data){
        //进行文件上传 将文件保存到指定位置.将文件路径存到数据表(向$data中加字段)
        if($_FILES['logo']['error'] > 0){
            //文件有错误
            $this -> error = '文件错误';
            return false;
        }
        // dump($_FILES);die;
        //实例化文件上传类
        $config = array(
            'maxSize' =>  10 * 1024 * 1024,         //上传的文件大小限制
            'exts'    =>  array('jpg','png','gif','jpeg','bmp'),//上传文件类型
            'rootPath'=>  ROOT_PATH . UPLOAD_PATH,     //保存文件根目录
        );
        $upload = new \Think\Upload($config);
        //调用uploadOne方法或者upload方法 将文件保存到指定位置
        $res = $upload -> uploadOne($_FILES['logo']);
        //dump($res);die;
        if(!$res){
            //上传失败
            $this -> error = $upload -> getError();
            return false;
        }
        //拼接文件地址
        $data['goods_big_img'] = UPLOAD_PATH . $res['savepath'] . $res['savename'];
        //实例化Image类
        $image = new \Think\Image();
        //调用open方法 打开原图片
        $image -> open( ROOT_PATH . $data['goods_big_img']);
        //调用thumb方法生成缩略图 ,指定最大宽高
        $image -> thumb(188, 188);
        $goods_small_img = UPLOAD_PATH . $res['savepath'] . 'thumb_' . $res['savename'];
        //保存新的缩略图
        $image -> save( ROOT_PATH . $goods_small_img );

        $data['goods_small_img'] = $goods_small_img;
        return true;


    }

    //封装一个上传相册图片的方法
    public function upload_pics($goods_id){
        if(min( $_FILES['goods_pics']['error'] ) != 0){
            //所有文件都有错误  
            return false;
        }
        //实例化Upload类
        //实例化文件上传类
        $config = array(
            'maxSize'       => 10*1024*1024,     //上传文件最大限制
            'exts'          => array('jpg','png','gif','jpeg'),   //上传文件后缀限制
            'rootPath'      => ROOT_PATH . UPLOAD_PATH,    //上传文件保存根路径
        );
        $upload = new \Think\Upload($config);
        //调用upload方法进行多文件上传
        $files = array($_FILES['goods_pics']);

        $res = $upload -> upload($files);
        // dump($res);die;
        if(!$res){
			return false;
		}
		//上传成功，$res是一个二维数组
		foreach($res as $k => $v){
			//每一张图片，拼接原图片的路径，生成三张缩略图
			//然后向相册表添加一条记录
			$origin_pics = UPLOAD_PATH . $v['savepath'] . $v['savename'];  

          //生成三张缩略图
          //实例化Image类
          $image = new \Think\Image();
          $image -> open(ROOT_PATH . $origin_pics);
          //生成800*800 缩略图
          $image -> thumb(800, 800);
          $pics_big = UPLOAD_PATH . $v['savepath'] . 'thumb800_' . $v['savename'];
          $image -> save(ROOT_PATH . $pics_big);
          //生成400*400 缩略图
          $image -> thumb(400, 400);
          $pics_mid = UPLOAD_PATH . $v['savepath'] . 'thumb400_' . $v['savename'];
          $image -> save(ROOT_PATH . $pics_mid);
          //生成50*50缩略图
          $image -> thumb(50, 50);
          $pics_sma = UPLOAD_PATH . $v['savepath'] . 'thumb50_' . $v['savename'];
          $image -> save(ROOT_PATH . $pics_sma);

          //添加一条数据到相册表
          $row = array(
              'goods_id' => $goods_id,
              'pics_origin' => $origin_pics,
              'pics_big' => $pics_big,
              'pics_mid' => $pics_mid,
              'pics_sma' => $pics_sma,
          );
          $goodspics[] = $row;
        }
        D('Goodspics') -> addAll($goodspics);
        return true;
    }
}    