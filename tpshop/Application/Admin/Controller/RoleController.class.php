<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends CommonController{
    //角色列表
    public function index(){
        //查询数据
        $role = M('Role') ->select();
        $this -> assign('role',$role);
        $this -> display();
    }

    
    public function setauth(){
        //一个方法处理两个逻辑
        if(IS_POST){
            //表单提交
            $data = I('post.');
            // dump(data);die;
            //将数据修改到角色表
            $row['role_id'] = $data['role_id'];
            $row['role_auth_ids'] = implode(',', $data['id']);
            //查询具体的权限信息 用于拼接role_auth_ac字段
            $auth = M('Auth') -> where("id in ({$row['role_auth_ids']})") -> select();
            $role_auth_ac = '';
            foreach($auth as $k => $v){
                if($v['pid'] != 0){
                    $role_auth_ac .= $v['auth_c'] . '-' . $v['auth_a'] . ',';
                }
            }
            //去掉最后的多余的逗号
            $role_auth_ac = trim($role_auth_ac, ',');

            $row['role_auth_ac'] = $role_auth_ac;

            $res = M('Role') -> save($row);
            if($res !== false){
                //分配成功
                $this->success('分配成功', U('Admin/Role/index'));
            }else{
                $this->error('分配失败');
            }
        }else{
            //接收role_id
            $role_id = I('get.role_id');
            //查询角色表数据
            $role = M('Role') -> where(['role_id' => $role_id]) -> find();
            $this -> assign('role',$role);

            //查询所有的权限,分别查询顶级和二级权限
            $top_all = M('Auth') -> where("pid = 0") -> select();
            $second_all = M('Auth') -> where("pid > 0") -> select();
            $this->assign('top_all',$top_all);
            $this->assign('second_all',$second_all);
            $this->display();
        }    
    }

}