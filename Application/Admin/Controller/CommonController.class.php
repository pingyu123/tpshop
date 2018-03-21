<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{
    public function __construct(){
        //先调用父类构造方法
        parent::__construct();
        //登陆判断
        if(!session('?manager_info')){
            //没有登陆,跳转到登陆页
            $this -> redirect('Admin/Login/login');
        }
        //调用getnav方法
		$this -> getnav();
		
		//调用checkauth进行权限检测
		$this-> checkauth();
    }
    

    //获取左侧菜单权限
    public function getnav(){
		//优化，先判断session中有没有菜单权限信息
		if(session('?top') && session('?second')){
			//不需要查询数据表
			//return ;
		}
		//从session获取登录的管理员信息  role_id
		$role_id = session('manager_info.role_id');
		//根据role_id 进行判断 超级管理员和普通管理员
		if($role_id == 1){
			//超级管理员 直接查询权限表 分别查询顶级 和二级权限
			$top = M('Auth') -> where("pid = 0 and is_nav = 1") -> select();
			$second = M('Auth') -> where("pid > 0 and is_nav = 1") -> select();
		}else{
			//普通管理员 根据role_id查询角色表
			$role = M('Role') -> where("role_id = $role_id") -> find();
			// 根据角色表role_auth_ids字段值查询权限表 分别查询顶级和二级权限
			$role_auth_ids = $role['role_auth_ids']; // "1,2,5"

			$top = M('Auth') -> where("pid = 0 and id in ($role_auth_ids) and is_nav = 1") -> select();
			$second = M('Auth') -> where("pid > 0 and id in ($role_auth_ids) and is_nav = 1") -> select();
		}
		//将查询的权限放到session中，页面上直接读取session即可
		session('top', $top);
		session('second', $second);
	}
	
	//权限检测
	public function checkauth(){
		//获取角色id
		$role_id = session('manager_info.role_id');
		if($role_id ==1){
			//超级管理员不需要检测
			return;
		}
		//获取当前访问页面.控制器名和方法名
		$c = CONTROLLER_NAME;
		$a = ACTION_NAME;

		$ac = $c . '-' . $a;
		//首页 不需要检测权限,所有人都可以访问
		if($ac =='Index-index'){
			return;
		}
		//根据role_id查询角色信息判断$ac 是否在role_auth_id字段中
		$role = M('Role') ->where(['role_id' => $role_id]) -> find();
		$role_auth_ac = explode(',', $role_['role_auth_ac']);

		if(!in_array($ac,$role_auth_ac)){
			//没有权限
			$this -> error('没有权限',U('Admin/Index/index'));
		}

		
        
    }
}