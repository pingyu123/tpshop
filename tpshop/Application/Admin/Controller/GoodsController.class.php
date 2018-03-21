<?php
namespace Admin\Controller;
// use Think\Controller;
class GoodsController extends CommonController{
	//商品列表页
	public function index(){
		//实例化Goods模型
		$model = D('Goods');
		$total = $model -> count();
		//实例化分页类
		$pagesize = 3;
		$page = new \Think\Page($total, $pagesize);
		//分页栏内容定制
		$page -> setConfig("prev", "上一页");
		$page -> setConfig("next", "下一页");
		$page -> setConfig("first", "首页");
		$page -> setConfig("last", "末页");
		$page -> setConfig("theme", "%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$page -> rollPage = 3;
		$page -> lastSuffix = false;
		//调用show方法 获取分页栏html代码
		$page_html = $page -> show();
		$this -> assign('page_html', $page_html);
		//当前页数据查询
		$data = $model -> limit($page->firstRow, $page->listRows) -> select();
		// dump($data);die;
		//变量赋值
		$this -> assign('data', $data);
		//调用模板
		$this -> display();
	}

	//商品新增页
	public function add(){
		//一个方法 处理两个业务逻辑： 展示页面  表单提交
		if(IS_POST){
			// post请求 表单提交
			// $data = $_POST;
			// $data['name'] = htmlspecialchars($data['name']);
			$data = I("post.");
			
			// dump($_FILES);die;
			//dump($data);die;
			// $data['goods_create_time'] = time();
			// $data['goods_introduce'] = $_POST['introduce'];
			//富文本编辑器字段，不需要使用htmlspecialchars转化
			$data['goods_introduce'] = I('post.introduce', '', 'remove_xss');
			// $data['goods_introduce'] = remove_xss(I('post.introduce', '', 'trim') );

			// dump($data);die;
			//将数据添加到数据表
			//实例化模型
			$model = D('Goods');
			//文件上传
			$upload_res = $model -> upload_logo($data);
			if(!$upload_res){
				//文件上传失败
				$error = $model -> getError();
				$this -> error($error);
			}
			// dump($data);die;
			//使用create方法自动创建数据集（包含数据验证、字段映射、自动验证等功能）
			$create = $model -> create($data);
			// dump($data);
			// dump($create);
			if(!$create){
				//创建数据失败 报错
				$error = $model -> getError() ?: "数据错误";
				// dump($error);die;
				$this -> error($error);
			}
			// dump($res);die;
			//调用模型的add方法进行添加，传递一维数组参数
			$res = $model -> add();
			// dump($res);
			if($res){
				//添加成功 $res 是商品表的主键id值
				//商品相册图片的上传
				$model -> upload_pics($res);
				//添加商品属性值到商品属性值关联表tpshop_goods_attr表
				$goodsattr = [];
				foreach($data['attr_name'] as $k => $v){
					//$k 属性id  ; $v 是一个数组 ，数组中有一个或多个属性值
					$row['goods_id'] = $res;
					$row['attr_id'] = $k;
					foreach($v as $key => $value){
						//$value 就是一个属性值
						$row['attr_value'] = $value;
						// M('GoodsAttr') -> add($row);
						$goodsattr[] = $row;
					}

				}
				//得到一个二维数组$goodsattr, 可以批量添加到tpshop_goods_attr表
				M('GoodsAttr') -> addAll($goodsattr);
				//提示并跳转
				$this -> success('添加成功', U('Admin/Goods/index'));
			}else{
				//添加失败
				$this -> error("添加失败");
			}
		}else{
			//get请求 展示页面
			//查询商品类型
			$type = M('Type') -> select();
			$this -> assign('type', $type);

			//查询商品分类
			$category = M('Category') -> select();
			//展示数据
			$this -> assign('category',$category);
			//调用模板
			$this -> display();
		}
	}

	//商品修改页
	public function edit(){
		//一个方法两个逻辑
		if(IS_POST){
			//表单提交
			$data = I('post.');
			// dump($data);
			//对商品描述字段单独处理，防范xss攻击
			$data['goods_introduce'] = I('post.introduce', '', 'remove_xss');
			//将数据保存到数据表
			//实例化模型
			$model = D('Goods');
			//文件上传
			// dump($_FILES);die;
			if($_FILES['logo']['error'] == 0){
				//如果上传了新图片则进行处理
				$upload_res = $model -> upload_logo($data);
				if(!$upload_res){
					//上传过程中出错
					$error = $model -> getError();
					$this -> error($error);
				}
				//获取旧图片路径 用于后续从磁盘删除旧图片
				$goods = $model -> where(['id' => $data['id']]) -> find();
			}
			// dump($data);die;
			//使用create方法自动创建数据集（包含数据验证、字段映射、自动验证等功能）
			$create = $model -> create($data);
			if(!$create){
				//创建数据失败 报错
				$error = $model -> getError() ?: "数据错误";
				// dump($error);die;
				$this -> error($error);
			}
			$res = $model -> save();
			// dump($res);
			if($res !== false){
				//修改成功
				//如果上传了新图片，从磁盘删除旧logo图片
				if($_FILES['logo']['error'] == 0){
				// if(isset($goods)){
					unlink(ROOT_PATH . $goods['goods_big_img']);
					unlink(ROOT_PATH . $goods['goods_small_img']);
				}

				//继续上传相册图片
				$model -> upload_pics($data['id']);

				$this -> success('修改成功', U('Admin/Goods/index'));
			}else{
				//修改失败
				$this -> error('修改失败');
			}
		}else{
			//接收id参数 查询原始数据
			$id = I('get.id');
			//查询数据
			$goods = D('Goods') -> where(['id' => $id]) -> find();
			//变量赋值
			$this -> assign('goods', $goods);

			//查询商品相册数据
			$goodspics = M('Goodspics') -> where(['goods_id' => $id]) -> select();
			$this -> assign('goodspics', $goodspics);

			//调用模板
			$this -> display();
		}
		
	}

	//商品删除
	public function del(){
		//接收id参数
		$id = I('get.id');
		//从商品表删除记录
		$model = D('Goods');
		$res = $model -> where(['id' => $id]) -> delete();
		// dump($res);
		if($res !== false){
			//删除成功
			$this -> success('删除成功', U('Admin/Goods/index'));
		}else{
			// 删除失败
			$this -> error('删除失败');
		}
	}

	//商品详情页
	public function detail(){
		//调用模板
		$this -> display();
	}

	//ajax删除相册图片
	public function delpics(){
		//接收参数
		$id = I('post.pics_id');
		//用于后续删除文件
		$goodspics = M('Goodspics') -> where(['id' => $id]) -> find();
		//从相册表删除记录
		$res = M('Goodspics') -> where(['id' => $id]) -> delete();
		if($res !== false){
			//删除成功
			//将图片从磁盘删除
			unlink(ROOT_PATH . $goodspics['pics_origin']);
			unlink(ROOT_PATH . $goodspics['pics_big']);
			unlink(ROOT_PATH . $goodspics['pics_mid']);
			unlink(ROOT_PATH . $goodspics['pics_sma']);
			$return = array(
				'code' => 10000,
				'msg' => '成功'
			);
			//返回json格式数据
			$this -> ajaxReturn($return);
		}else{
			//删除失败
			$return = array(
				'code' => 10001,
				'msg' => '删除失败'
			);
			//返回json格式数据
			$this -> ajaxReturn($return);
		}
	}

	//根据type_id获取属性名称
	public function getattr(){
		//接收参数
		$type_id = I('post.type_id');
		//参数检测
		if(!is_numeric($type_id)){
			$return = array(
				'code' => 10001,
				'msg' => '参数错误'
			);
			$this -> ajaxReturn($return);
		}
		//查询属性表
		$attrs = M('Attribute') -> where(['type_id' => $type_id]) -> select();
		//将可选值转化为数组，方便遍历
		foreach($attrs as $k => &$v){
			$v['attr_values'] = explode(',', $v['attr_values']);
		}
		//返回数据
		$return = array(
			'code' => 10000,
			'msg' => 'success',
			'data' => $attrs
		);
		$this -> ajaxReturn($return);
	}
}