<?php
namespace Home\Controller;
use Think\Controller;
class MongoController extends Controller{
	public function doDataToMongo(){
		$data = M('zhilian')->limit(1000)->select();
		$mongo = linkMongo();
		//遍历写入
		foreach ($data as $key => $vlaue){
			$mongo->php->zhilian->insert($value);
		}
	}
	//显示
	public function show(){
		$data = linkMongo()->php->zhilian->find()->limit(10);
		// dump($data);
		foreach ($data as $key => $value){
			foreach ($value as $k => $v){
				echo '<p>'.$v.'</p>';
			}
		}
	}
}	