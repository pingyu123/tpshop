<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>后台管理系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/main.css">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/bootstrap-responsive.min.css">
</head>
<body>

<!-- 上 -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <ul class="nav pull-right">
                <li id="fat-menu" class="dropdown">
                    <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user icon-white"></i> admin
                        <i class="icon-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="javascript:void(0);">修改密码</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="/index.php/Admin/Login/logout">安全退出</a></li>
                    </ul>
                </li>
            </ul>
            <a class="brand" href="index.html"><span class="first">后台管理系统</span></a>
            <ul class="nav">
                <li class="active"><a href="javascript:void(0);">首页</a></li>
                <li><a href="javascript:void(0);">系统管理</a></li>
                <li><a href="javascript:void(0);">权限管理</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- 左 -->
<div class="sidebar-nav">
    <?php if(is_array($_SESSION['top'])): $k = 0; $__LIST__ = $_SESSION['top'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top_vol): $mod = ($k % 2 );++$k;?><a href="#error-menu<?php echo ($k); ?>" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i><?php echo ($top_vol["auth_name"]); ?></a>
    <ul id="error-menu<?php echo ($k); ?>" class="nav nav-list collapse in">
        <?php if(is_array($_SESSION['second'])): $i = 0; $__LIST__ = $_SESSION['second'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$second_vol): $mod = ($i % 2 );++$i; if( $second_vol["pid"] == $top_vol["id"] ): ?><li><a href="/index.php/Admin/<?php echo ($second_vol["auth_c"]); ?>/<?php echo ($second_vol["auth_a"]); ?>"><?php echo ($second_vol["auth_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </ul><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<!-- 右 -->
<div class="content">
    <div class="header">
        <h1 class="page-title">管理员列表</h1>
    </div>

    <div class="well">
        <!-- search button -->
        <form action="" method="get" class="form-search">
            <div class="row-fluid" style="text-align: left;">
                <div class="pull-left span4 unstyled">
                    <p> 用户名：<input class="input-medium" name="" type="text"></p>
                </div>
                <div class="pull-left span4 unstyled">
                    <p> 开始时间：<input class="input-medium" name="" type="text" onclick="WdatePicker()"></p>
                </div>
            </div>
            <button type="submit" class="btn">查找</button>
            <a class="btn btn-primary" onclick="javascript:window.location.href='#'">新增</a>
        </form>
    </div>
    <div class="well">
        <!-- table -->
        <table class="table table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th>编号</th>
                    <th>用户名</th>
                    <th>昵称</th>
                    <th>邮箱</th>
                    <th>是否可用</th>
                    <th>上次登录时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($data)): foreach($data as $k=>$v): ?><tr class="success">
                    <td><?php echo ($v["id"]); ?></td>
                    <td><?php echo ($v["username"]); ?></td>
                    <td><?php echo ($v["nickname"]); ?></td>
                    <td><?php echo ($v["email"]); ?></td>
                    <td><?php if( $v["status"] == 1 ): ?>可用<?php else: ?>不可用<?php endif; ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $v['last_login_time']);?></td>
                    <td>
                        <a href="javascript:void(0);"> 编辑 </a>
                        <a href="javascript:void(0);" onclick="if(confirm('确认删除？')) location.href='#'"> 删除 </a>
                        <a href="javascript:void(0);"> 重置密码 </a>
                    </td>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
        <!-- pagination -->
        <div class="pagination">
            <ul>
                <li><a href="#">Prev</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">Next</a></li>
            </ul>
        </div>
    </div>
    <!-- footer -->
    <footer>
        <hr>
        <p>© 2017 <a href="javascript:void(0);" target="_blank">ADMIN</a></p>
    </footer>
</div>
</body>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="/Public/Admin/js/jquery-1.8.1.min.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
<!-- 日期控件 -->
<script src="/Public/Admin/js/calendar/WdatePicker.js"></script>
</html>