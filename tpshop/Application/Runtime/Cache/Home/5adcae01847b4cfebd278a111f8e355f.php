<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<title>首页</title>

		<!-- <link href="/Public/Home/css/amazeui.css" rel="stylesheet" type="text/css" /> -->
		<link rel="stylesheet" type="text/css" href="/Public/Home/css/amazeui.css" />
		<link href="/Public/Home/css/admin.css" rel="stylesheet" type="text/css" />
		<link href="/Public/Home/css/demo.css" rel="stylesheet" type="text/css" />
		<link href="/Public/Home/css/hmstyle.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			.nav-cont .nav-extra{background: url(/Public/Home/images/extra.png);}
		</style>
		<!-- <script src="/Public/Home/js/jquery.min.js"></script> -->
		<script type="text/javascript" src="/Public/Home/js/jquery.min.js"></script>
		<script src="/Public/Home/js/amazeui.min.js"></script>
		<script src="/Public/Home/js/quick_links.js"></script>

	</head>

	<body>
		
		<!--顶部导航条 -->
		<div class="am-container header">
			<ul class="message-l">
				<div class="topMessage">
					<div class="menu-hd">
						<?php if( $_SESSION['user_info']== null ): ?><a href="/index.php/Home/User/login.html" target="_top" class="h">亲，请登录</a>
						<a href="/index.php/Home/User/register.html" target="_top">免费注册</a>

						<?php elseif( $_SESSION['user_info']['phone']!= null ): ?>
						<a href="javascript:;" target="_top" class="h"><?php echo (encrypt_phone($_SESSION['user_info']['phone'])); ?></a>
						<a href="/index.php/Home/User/logout.html" target="_top">退出</a>
						
						<?php elseif( $_SESSION['user_info']['email']!= null ): ?>
						<a href="javascript:;" target="_top" class="h"><?php echo ($_SESSION['user_info']['email']); ?></a>
						<a href="/index.php/Home/User/logout.html" target="_top">退出</a>
						
						<?php else: ?>

						<a href="javascript:;" target="_top" class="h"><?php echo ($_SESSION['user_info']['username']); ?></a>
						<a href="/index.php/Home/User/logout.html" target="_top">退出</a><?php endif; ?>
					</div>
				</div>
			</ul>
			<ul class="message-r">
				<div class="topMessage home">
					<div class="menu-hd"><a href="#" target="_top" class="h">商城首页</a></div>
				</div>
				<div class="topMessage my-shangcheng">
					<div class="menu-hd MyShangcheng"><a href="#" target="_top"><i class="am-icon-user am-icon-fw"></i>个人中心</a></div>
				</div>
				<div class="topMessage mini-cart">
					<div class="menu-hd"><a id="mc-menu-hd" href="#" target="_top"><i class="am-icon-shopping-cart  am-icon-fw"></i><span>购物车</span><strong id="J_MiniCartNum" class="h">0</strong></a></div>
				</div>
				<div class="topMessage favorite">
					<div class="menu-hd"><a href="#" target="_top"><i class="am-icon-heart am-icon-fw"></i><span>收藏夹</span></a></div>
				</div>
			</ul>
		</div>
		<!--悬浮搜索框-->
		<div class="nav white">
			<div class="logo"><img src="/Public/Home/images/logo.png" /></div>
			<div class="logoBig">
				<li><img src="/Public/Home/images/logobig.png" /></li>
			</div>

			<div class="search-bar pr">
				<a name="index_none_header_sysc" href="#"></a>
				<form>
					<input id="searchInput" name="index_none_header_sysc" type="text" placeholder="搜索" autocomplete="off">
					<input id="ai-topsearch" class="submit am-btn" value="搜索" index="1" type="submit">
				</form>
			</div>
		</div>
		<div class="clear"></div>

    	
		<link href="/Public/Home/css/cartstyle.css" rel="stylesheet" type="text/css" />
		<link href="/Public/Home/css/optstyle.css" rel="stylesheet" type="text/css" />

		<!--购物车 -->
		<div class="concent">
			<div id="cartTable">
				<div class="cart-table-th">
					<div class="wp">
						<div class="th th-chk">
							<div id="J_SelectAll1" class="select-all J_SelectAll">

							</div>
						</div>
						<div class="th th-item">
							<div class="td-inner">商品信息</div>
						</div>
						<div class="th th-price">
							<div class="td-inner">单价</div>
						</div>
						<div class="th th-amount">
							<div class="td-inner">数量</div>
						</div>
						<div class="th th-sum">
							<div class="td-inner">金额</div>
						</div>
						<div class="th th-op">
							<div class="td-inner">操作</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<tr class="item-list">
					<div class="bundle  bundle-last ">
						<div class="bundle-hd">
							<div class="bd-promos">
								<div class="bd-has-promo">已享优惠:<span class="bd-has-promo-content">省￥19.50</span>&nbsp;&nbsp;</div>
								<div class="act-promo">
									<a href="#" target="_blank">第二支半价，第三支免费<span class="gt">&gt;&gt;</span></a>
								</div>
								<span class="list-change theme-login">编辑</span>
							</div>
						</div>
						<div class="clear"></div>
						<div class="bundle-main">
							<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><ul class="item-content clearfix" goods_id="<?php echo ($vol["goods_id"]); ?>" goods_attr_ids="<?php echo ($vol["goods_attr_ids"]); ?>" cart_id="<?php echo ((isset($vol["id"]) && ($vol["id"] !== ""))?($vol["id"]):0); ?>">
								<li class="td td-chk">
									<div class="cart-checkbox ">
										<input class="check row_check" name="items[]" value="170037950254" type="checkbox">
										<label for="J_CheckBox_170037950254"></label>
									</div>
								</li>
								<li class="td td-item">
									<div class="item-pic">
										<a href="/index.php/Home/Index/detail/id/<?php echo ($vol["goods_id"]); ?>" target="_blank" data-title="<?php echo ($vol["goods"]["goods_name"]); ?>" class="J_MakePoint" data-point="tbcart.8.12">
											<img src="<?php echo ($vol["goods"]["goods_small_img"]); ?>" class="itempic J_ItemImg"></a>
									</div>
									<div class="item-info">
										<div class="item-basic-info">
											<a href="/index.php/Home/Index/detail/id/<?php echo ($vol["goods_id"]); ?>" target="_blank" title="<?php echo ($vol["goods"]["goods_name"]); ?>" class="item-title J_MakePoint" data-point="tbcart.8.11"><?php echo ($vol["goods"]["goods_name"]); ?></a>
										</div>
									</div>
								</li>
								<li class="td td-info">
									<div class="item-props item-props-can">
										<?php if(is_array($vol["goodsattr"])): $i = 0; $__LIST__ = $vol["goodsattr"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol_attr): $mod = ($i % 2 );++$i;?><span class="sku-line"><?php echo ($vol_attr["attr_name"]); ?>：<?php echo ($vol_attr["attr_value"]); ?> </span><?php endforeach; endif; else: echo "" ;endif; ?>
										<span tabindex="0" class="btn-edit-sku theme-login">修改</span>
										<i class="theme-login am-icon-sort-desc"></i>
									</div>
								</li>
								<li class="td td-price">
									<div class="item-price price-promo-promo">
										<div class="price-content">
											<div class="price-line">
												<em class="price-original"><?php echo ($vol["goods"]["goods_price"]); ?></em>
											</div>
											<div class="price-line">
												<em class="J_Price price-now" tabindex="0"><?php echo ($vol["goods"]["goods_price"]); ?></em>
											</div>
										</div>
									</div>
								</li>
								<li class="td td-amount">
									<div class="amount-wrapper ">
										<div class="item-amount ">
											<div class="sl">
												<input class="min am-btn sub_number" name="" type="button" value="-" />
												<input class="text_box current_number" name="" type="text" number="<?php echo ($vol["number"]); ?>" value="<?php echo ($vol["number"]); ?>" style="width:30px;" />
												<input class="add am-btn add_number" name="" type="button" value="+" />
											</div>
										</div>
									</div>
								</li>
								<li class="td td-sum">
									<div class="td-inner">
										<em tabindex="0" class="J_ItemSum number row_price"><?php echo ($vol['number'] * $vol['goods']['goods_price']); ?></em>
									</div>
								</li>
								<li class="td td-op">
									<div class="td-inner">
										<a title="移入收藏夹" class="btn-fav" href="#"> 移入收藏夹</a>
										<a href="javascript:;" data-point-url="#" class="delete"> 删除</a>
									</div>
								</li>
							</ul><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</tr>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>

			<div class="float-bar-wrapper">
				<div id="J_SelectAll2" class="select-all J_SelectAll">
					<div class="cart-checkbox">
						<input class="check-all check" name="select-all" value="true" type="checkbox">
						<label for="J_SelectAllCbx2"></label>
					</div>
					<span>全选</span>
				</div>
				<div class="operations">
					<a href="#" hidefocus="true" class="deleteAll">删除</a>
					<a href="#" hidefocus="true" class="J_BatchFav">移入收藏夹</a>
				</div>
				<div class="float-bar-right">
					<div class="amount-sum">
						<span class="txt">已选商品</span>
						<em id="J_SelectedItemsCount">0</em><span class="txt">件</span>
						<div class="arrow-box">
							<span class="selected-items-arrow"></span>
							<span class="arrow"></span>
						</div>
					</div>
					<div class="price-sum">
						<span class="txt">合计:</span>
						<strong class="price">¥<em id="J_Total">0.00</em></strong>
					</div>
					<div class="btn-area">
						<a href="javascript:void(0);" id="J_Go" class="submit-btn submit-btn-disabled" aria-label="请注意如果没有选择宝贝，将无法结算">
							<span>结&nbsp;算</span></a>
					</div>
				</div>

			</div>
		</div>
<script type="text/javascript">
	$(function(){
		//修改商品数量发送ajax
		var changenum = function(new_number, element){
			//发送ajax请求
			var data = {
				'goods_id': $(element).closest('ul').attr('goods_id'),
				'goods_attr_ids': $(element).closest('ul').attr('goods_attr_ids'),
				'new_number': new_number,
			};
			// console.log(data);return;
			$.ajax({
				'url': '/index.php/Home/Cart/changenum',
				'type':'post',
				'data':data,
				'dataType':'json',
				'success':function(response){
					if(response.code != 10000){
						alert(response.msg);
					}else{
						//将新的数量显示在页面input
						$(element).closest('ul').find('.current_number').val(new_number);
						//修改input输入框的number属性
						$(element).closest('ul').find('.current_number').attr('number', new_number);
						//获取当前行单价
						var price_now = parseFloat( $(element).closest('ul').find('.J_Price').text() );
						var price_row = price_now * new_number;
						//将新的总金额显示在页面上 row_price
						$(element).closest('ul').find('.row_price').text(price_row);

						//重新计算已选商品数量和价格
						changetotal();

					}
				}
			})
		}
		//重新计算已选商品数量和价格
		var changetotal = function(){
			//获取所有的选中的checkbox
			var checked_checkbox = $('.row_check:checked');
			// if(checked_checkbox.length == 0){
			// 	$('#J_SelectedItemsCount').text('0');
			// 	$('#J_Total').text('0.00');
			// 	return;
			// }
			// console.log(checked_checkbox);
			//已选商品数量
			var total_number = 0;
			//总金额
			var total_price = 0.00;
			$.each(checked_checkbox, function(i,v){
				//v 是一个input checkbox标签
				//获取选中的每一行的数量，进行累加
				var current_number = parseInt( $(v).closest('ul').find('.current_number').val() );
				total_number += current_number;
				//获取选中的每一行的金额，进行累加
				var row_price = parseFloat( $(v).closest('ul').find('.J_ItemSum').text() );
				total_price += row_price;
			});
			// console.log(total_number);
			//将已选商品数量和总金额显示到页面
			$('#J_SelectedItemsCount').text(total_number);
			$('#J_Total').text(total_price);
		}
		//给+号绑定点击事件
		$('.add_number').click(function(){
			//新的number数量
			var number = parseInt( $(this).closest('ul').find('.current_number').val() );
			if(number == 100){
				return;
			}
			var new_number = number + 1;
			//发送ajax请求
			changenum(new_number, this);
		});

		//给-号绑定点击事件
		$('.sub_number').click(function(){
			//新的number数量
			var number = parseInt( $(this).closest('ul').find('.current_number').val() );
			if(number == 1){
				return;
			}
			var new_number = number - 1;
			//发送ajax请求
			changenum(new_number, this);
		});

		//给商品数量input输入框绑定change事件
		$('.current_number').change(function(){
			var number = parseInt( $(this).val() );
			// console.log(number);return;
			//数量格式检测
			if(isNaN(number)){
				//需要将修改之前的数量保存在input输入框的number属性上
				var old_number = $(this).attr('number');
				$(this).val(old_number);
				alert('请输入数字');return;
			}
			//边界条件 1~100
			if(number > 100){
				number = 100;
			}
			if(number < 1){
				number = 1;
			}
			//发送ajax
			changenum(number, this);
		});

		//给删除绑定点击事件
		$('.delete').click(function(){
			//准备参数
			var data = {
				'goods_id': $(this).closest('ul').attr('goods_id'),
				'goods_attr_ids': $(this).closest('ul').attr('goods_attr_ids')
			};
			var _this = this;
			//发送ajax
			$.ajax({
				'url':'/index.php/Home/Cart/ajaxdel',
				'type':'post',
				'data':data,
				'dataType':'json',
				'success':function(response){
					if(response.code != 10000){
						alert(response.msg);
					}else{
						//从页面移除当前行（ul标签）
						$(_this).closest('ul').remove();

						//重新计算已选商品数量和价格
						changetotal();
					}
				}
			})
		});

		//给每一行的checkbox绑定change事件
		$('.row_check').change(function(){
			//重新计算已选商品数量和价格
			changetotal();
			//获取所有选中的行  checkbox
			var checked = $('.row_check:checked');
			//获取所有的行数
			var all = $('.row_check');
			//判读数量是否一致
			if(checked.length == all.length){
				//将全选 选中
				$('.check-all').prop('checked', true);
			}else{
				//将全选 取消
				$('.check-all').prop('checked', false);
			}
		});

		//给全选绑定change事件
		$('.check-all').change(function(){
			//每一行的checkbox的选中状态  和  全选 一致
			var status = $(this).prop('checked');
			// console.log(status);
			$('.row_check').prop('checked', status);
			//重新计算已选商品数量和价格
			changetotal();
		});

		//给结算绑定点击事件
		$('#J_Go').click(function(){
			//获取选中行对应的cart表的主键id
			var checked_checkbox = $('.row_check:checked');
			if(checked_checkbox.length == 0){
				return;
			}
			var cart_ids = '';
			//遍历取出每一个cart_id ，拼接起来
			$.each(checked_checkbox, function(i,v){
				var cart_id = $(v).closest('ul').attr('cart_id');
				cart_ids += cart_id + ',';
			});
			//console.log($cart_id);
			//去除最后的逗号
			cart_ids = cart_ids.slice(0, -1);
			//console.log(cart_ids);
			//跳转页面，拼接url中的参数
			location.href = "/index.php/Home/Cart/flow2/cart_ids/" + cart_ids;

		})
	})
</script>
	
		<div class="clear "></div>
		<!-- 底部内容 -->
		<div class="footer ">
			<div class="footer-hd ">
				<p>
					<a href="# ">恒望科技</a>
					<b>|</b>
					<a href="# ">商城首页</a>
					<b>|</b>
					<a href="# ">支付宝</a>
					<b>|</b>
					<a href="# ">物流</a>
				</p>
			</div>
			<div class="footer-bd ">
				<p>
					<a href="# ">关于恒望</a>
					<a href="# ">合作伙伴</a>
					<a href="# ">联系我们</a>
					<a href="# ">网站地图</a>
				</p>
			</div>
		</div>
		<!--右侧菜单 -->
		<div class=tip>
			<div id="sidebar">
				<div id="wrap">
					<div id="prof" class="item ">
						<a href="# ">
							<span class="setting "></span>
						</a>
						<div class="ibar_login_box status_login ">
							<div class="avatar_box ">
								<p class="avatar_imgbox "><img src="/Public/Home/images/no-img_mid_.jpg " /></p>
								<ul class="user_info ">
									<li>用户名：sl1903</li>
									<li>级&nbsp;别：普通会员</li>
								</ul>
							</div>
							<div class="login_btnbox ">
								<a href="# " class="login_order ">我的订单</a>
								<a href="# " class="login_favorite ">我的收藏</a>
							</div>
							<i class="icon_arrow_white "></i>
						</div>

					</div>
					<div id="shopCart " class="item ">
						<a href="# ">
							<span class="message "></span>
						</a>
						<p>
							购物车
						</p>
						<p class="cart_num ">0</p>
					</div>
					<div id="asset " class="item ">
						<a href="# ">
							<span class="view "></span>
						</a>
						<div class="mp_tooltip ">
							我的资产
							<i class="icon_arrow_right_black "></i>
						</div>
					</div>

					<div id="foot " class="item ">
						<a href="# ">
							<span class="zuji "></span>
						</a>
						<div class="mp_tooltip ">
							我的足迹
							<i class="icon_arrow_right_black "></i>
						</div>
					</div>

					<div id="brand " class="item ">
						<a href="#">
							<span class="wdsc "><img src="/Public/Home/images/wdsc.png " /></span>
						</a>
						<div class="mp_tooltip ">
							我的收藏
							<i class="icon_arrow_right_black "></i>
						</div>
					</div>

					<div id="broadcast " class="item ">
						<a href="# ">
							<span class="chongzhi "><img src="/Public/Home/images/chongzhi.png " /></span>
						</a>
						<div class="mp_tooltip ">
							我要充值
							<i class="icon_arrow_right_black "></i>
						</div>
					</div>

					<div class="quick_toggle ">
						<li class="qtitem ">
							<a href="# "><span class="kfzx "></span></a>
							<div class="mp_tooltip ">客服中心<i class="icon_arrow_right_black "></i></div>
						</li>
						<!--二维码 -->
						<li class="qtitem ">
							<a href="#none "><span class="mpbtn_qrcode "></span></a>
							<div class="mp_qrcode " style="display:none; "><img src="/Public/Home/images/weixin_code_145.png " /><i class="icon_arrow_white "></i></div>
						</li>
						<li class="qtitem ">
							<a href="#top " class="return_top "><span class="top "></span></a>
						</li>
					</div>

					<!--回到顶部 -->
					<div id="quick_links_pop " class="quick_links_pop hide "></div>

				</div>

			</div>
			<div id="prof-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					我
				</div>
			</div>
			<div id="shopCart-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					购物车
				</div>
			</div>
			<div id="asset-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					资产
				</div>

				<div class="ia-head-list ">
					<a href="# " target="_blank " class="pl ">
						<div class="num ">0</div>
						<div class="text ">优惠券</div>
					</a>
					<a href="# " target="_blank " class="pl ">
						<div class="num ">0</div>
						<div class="text ">红包</div>
					</a>
					<a href="# " target="_blank " class="pl money ">
						<div class="num ">￥0</div>
						<div class="text ">余额</div>
					</a>
				</div>

			</div>
			<div id="foot-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					足迹
				</div>
			</div>
			<div id="brand-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					收藏
				</div>
			</div>
			<div id="broadcast-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					充值
				</div>
			</div>
		</div>
	</body>

</html>