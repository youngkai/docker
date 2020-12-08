<?php
/*================================================================
*  File Name：MessageService.php
*  Author：carlziess, chengmo9292@126.com
*  Create Date：2018-06-15 10:43:25
*  Description：
===============================================================*/
class MessageService
{
    public function postMessageByEmail($params = [])
    {
        if (empty($params)) return false;
        if ($params['serial_number'] && $params['erp_password']) {
            $isERPOpen = true;
        }
        $subject = '供应商开户及ERP接口资料';
        $body = "<strong>尊敬的{$params['agent_name']}:</strong><br>" .
                "以下信息为贵公司在订货宝系统的开户信息". ($isERPOpen ? "及ERP接口信息" : "")."，特此告知！<br><br>" .
                "<strong>开户信息：</strong><br>".
                "客户名称：{$params['company_name']}<br>".
                "联系电话：{$params['legal_mobile']}<br>".
                "开通时间：{$params['date']}<br><br>";
        if ($isERPOpen) {
            $body .= "<strong>API接口信息：</strong><br>".
                     "序列号：{$params['serial_number']}<br>".
                     "密码: {$params['erp_password']}<br><br><br>";
        }
        $body .= '<hr>' .
                '1、本邮件由系统自动发送，请勿回复<br>'.
                '2、紧急联系：dhb@rsung.com   support@rsung.com<br>'.
                '3、为了能够正常显示和及时接收邮件内容,请把no-reply@rsung.com添加为您的邮件联系人<br>'.
                '4、请妥善保管好邮件中的客户开户信息及ERP接口信息，未经同意不得泄露给任何第三方个人或单位<br>';
        $from = 'no-reply@rsung.com';
        //设置smtp参数
        $mail = new PHPMailer();
        $mail->IsSMTP();
        // $mail->SMTPDebug = true;
        $mail->SMTPAuth = true;
        $mail->SMTPKeepAlive = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.qq.com';
        $mail->Port = 465; 
        //填写你的email账号和密码
        $mail->Username = $from;
        $mail->Password = 'dcoktookkjuxddai';
        //注意这里也要填写授权码就是我在上面QQ邮箱开启SMTP中提到的，不能填邮箱登录的密码哦。
        //设置发送方，最好不要伪造地址
        $mail->From = $from;
        $mail->FromName = 'no-reply@rsung.com';
        $mail->Subject = $subject;
        $mail->AltBody = $body;
        $mail->WordWrap = 50;
        // set word wrap
        $mail->MsgHTML($body); 
        $mail->AddAddress($email);
        // 使用HTML格式发送邮件
        $mail->IsHTML(true);
        //通过Send方法发送邮件
        if(!$mail->Send()){ 
            //备注一大堆又有什么卵用~没有超时也没有异常捕获，也没有重试。累！！
        }else{ 
        }
    }

}
