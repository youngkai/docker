可以按照以下步骤来部署和运行程序:
业务流程
                                 +--------------------+
 Client Request <----------------+   Controller       |
        +                        |    +               |
        |                        |    |               |
        |                        |    |               |
        |                        |    |               |
        |                        |    |               |
        |                        |    v               |
        |                        |   Service          |
        |                        |    +               |
        |                        |    |               |
        |                        |    |               |
        |                        |    |               |
        |                        |    |               |
        |                        |    |               |
        v                        |    v               |
AlphaFramework Applications+---> |   Model            |
                                 +--------------------+

1.请确保机器carlziess@alphas-MacBook-Pro.local已经安装了Yaf框架, 并且已经加载入PHP;
2.把demo-v1目录Copy到Nginx服务器的webroot目录中,并将root指向应用的public目录
3.nginx配置示例
server {
    listen 80;
    server_name demo-v1.com;
    access_log  /logpath/demo-v1.access.log  main;
    error_log  /logpath/demo-v1.error.log;
    root /data/codes/apps/demo-v1/www;
    index  inside.php index.htm;
    try_files $uri $uri/ /index.php$is_args$args;
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

}

4.需要在php.ini里面启用如下配置，生产的代码才能正确运行：
/*框架保存的路径*/
yaf.library=/data/codes/alpha_framework
yaf.use_namespace=1
/*Yaf的自动加载行为会影响spl_autoload,需要允许spl_autoload,避免包含spl_autoload的项目报错*/
yaf.use_spl_autoload=1
yaf.environ="product"
5.重启Webserver;
6.访问http://demo-v1.com,出现{"code":0,"data":"Hellow Word!"}, 表示运行成功,否则请查看php错误日志;
