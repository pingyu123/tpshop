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
        <h1 class="page-title">分派权限</h1>
    </div>

    <div class="well">
    正在给【<?php echo ($role["role_name"]); ?>】分派权限
    <form action="/index.php/Admin/Role/setauth" method="post">
        <!-- table -->
        <table class="table table-bordered table-hover table-condensed">
        <input type="hidden" name="role_id" value="<?php echo ($role["role_id"]); ?>">
            <thead>
                <tr>
                    <th>权限分类</th>
                    <th>权限</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($top_all)): $i = 0; $__LIST__ = $top_all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$top_v): $mod = ($i % 2 );++$i;?><tr class="success">
                    <td><input type="checkbox" name="id[]" value="<?php echo ($top_v["id"]); ?>" <?php if(in_array(($top_v["id"]), is_array($role["role_auth_ids"])?$role["role_auth_ids"]:explode(',',$role["role_auth_ids"]))): ?>checked="checked"<?php endif; ?> ><?php echo ($top_v["auth_name"]); ?></td>
                    <td>
                        <?php if(is_array($second_all)): $i = 0; $__LIST__ = $second_all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$second_v): $mod = ($i % 2 );++$i; if( $second_v["pid"] == $top_v["id"] ): ?><input type="checkbox" name="id[]" value="<?php echo ($second_v["id"]); ?>" <?php if(in_array(($second_v["id"]), is_array($role["role_auth_ids"])?$role["role_auth_ids"]:explode(',',$role["role_auth_ids"]))): ?>checked="checked"<?php endif; ?> ><?php echo ($second_v["auth_name"]); endif; endforeach; endif; else: echo "" ;endif; ?>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
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