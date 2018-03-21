<?php

//密码加密函数
function encrypt_password($password){
    //加盐(值)
    $salt = 'asdsadasdoowkeo3o124k';
    //加密
    return md5( md5( $password ) .$salt );
}


function remove_xss($string){
	//相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
    require_once './Public/Admin/htmlpurifier/HTMLPurifier.auto.php';
    // 生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 以下就是配置：
    $cfg -> set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg -> set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj -> purify($string);
}

#递归方法实现无限极分类
function getTree($list,$pid=0,$level=0) {
    static $tree = array();
    foreach($list as $row) {
        if($row['pid']==$pid) {
            $row['level'] = $level;
            $tree[] = $row;
            getTree($list, $row['id'], $level + 1);
        }
    }
    return $tree;
}

//手机号加密函数
function encrypt_phone($phone){
    return substr($phone, 0, 2) . '****' . substr($phone, 7, 4);
}

//封装发送curl请求的函数
function curl_request($url, $post=false, $params=array(), $https=false){
    //①curl_init函数初始化请求会话,可以传递一个请求地址参数
    $ch = curl_init($url);
    //②curl_setopt函数设置请求参数(选项)
    //如果是post请求,设置请求方法
    if($post){
        curl_setopt($ch, CURLOPT_POST, true);//设置请求方式为post,默认为get
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);//设置post请求参数, get请求参数直接放在url中
    }
    //https请求
    if($https){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//禁止从服务端验证https整数
    }
    //返回具体的数据
    curl_setopt($th, CURLOPT_RETURNTRANSFER, true);
    // ①curl_exec函数发送请求,有返回值
    $res = curl_exec($ch);
    // ②curl_close关闭请求会话
    curl_close($ch);
    return $res;//ae443dcc2cf03e6e6db0c04f49bf7ff7
}

//使用PHPMailer发送邮件
function sendmail($email, $subject, $body){
    require 'Application/Tools/PHPMailer/PHPMailerAutoload.php';
    
    $mail = new PHPMailer;                              

        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output

        $mail->isSMTP();                                      // 设置使用SMTP服务
        $mail->Host = 'smtp.qq.com';                          // 设置SMTP地址
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '384676057@qq.com';                   // 邮箱用户名
        $mail->Password = 'enmecegkrzrfcbcd';                 // 邮箱授权码
        $mail->SMTPSecure = 'tls';                            // 设置加密方式
        $mail->Port = 25;                                     // 邮件发送端口
        $mail->CharSet = "utf-8";                             // 设置邮件内容字符编码
        $mail->setFrom('384676057@qq.com');                    // 设置发件人
        $mail->addAddress($email);                            // 添加收件人
    
        // //Recipients
        // $mail->setFrom('from@example.com', 'Mailer');
        // $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');    //添加回复人
        // $mail->addCC('cc@example.com');                          //添加抄送人
        // $mail->addBCC('bcc@example.com');                        //添加密送人
    
        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //  添加附件
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optionnal name
    
        // //Content
        $mail->isHTML(true);                                  // 设置邮件内容格式 html
        $mail->Subject = $subject;                          //主题
        $mail->Body    = $body;                             //内容
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        if(!$mail->send()){
           return  $mail->ErrorInfo;
        }else{
            return true;
        }
}

