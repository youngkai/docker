/*================================================================
 *  File Name：bootstrap.js
 *  Author：carlziess, chengmo9292@126.com
 *  Create Date：2018-04-05 21:55:51
 *  Description：
===============================================================*/
RESOURCEURL = 'http://static.app.com';
SSOURL = 'http://sso.store.com';
PASSPORTURL = 'http://passport.app.com';
if (!window.location.origin) {
    window.location.origin = window.location.protocol +  '//' + window.location.host;
}

var initJs = [
    '/js/ips.public.js',
    '/js/libs/jquery-2.0.2.min.js',
    '/js/libs/jquery-ui-1.10.3.min.js',
    '/js/bootstrap/bootstrap.min.js',
    '/js/notification/SmartNotification.min.js',
    '/js/smartwidgets/jarvis.widget.min.js',
    '/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js',
    '/js/plugin/sparkline/jquery.sparkline.min.js',
    '/js/plugin/jquery-validate/jquery.validate.min.js',
    '/js/plugin/masked-input/jquery.maskedinput.min.js',
    '/js/plugin/select2/select2.js',
    '/js/plugin/bootstrap-slider/bootstrap-slider.min.js',
    '/js/plugin/msie-fix/jquery.mb.browser.min.js',
    '/js/plugin/smartclick/smartclick.js',
    '/js/plugin/jquerycookie/jquery.cookie.js',
    '/js/plugin/jquery-validate/jquery.validate.ext.js',
    '/js/plugin/jquery-validate/messages_bs_zh.js',
    '/js/plugin/blockui/jquery.blockUI.js',
    '/js/plugin/iframeresizer/js/iframeResizer.contentWindow.min.js',
    '/js/plugin/date/moment.js',
    '/js/plugin/date/daterangepicker.js'
];

var initCss = [
    '/css/bootstrap.min.css',
    '/css/smartadmin-production.css',
    '/css/smartadmin-skins.css',
    '/css/demo-increase.css',
    '/css/jquery.multiselect2side.css',
    '/css/daterangepicker-bs3.css',
    '/css/demo.css',
    '/css/font-awesome.min.css'
];

function DHB() {
    //ajax
    this.request = function(options) {
        var opt = {
            type: 'POST',
            dataType: 'json',
            data: {}
        } 
        opt = $.extend(opt, options);
        $.ajax({
            type: opt.type,
            url: opt.url,
            dataType: opt.dataType,
            data: opt.data,
            success: function(res){
                if (200 == res.code) {
                    opt.success && opt.success(res.data);
                } else {
                    console.log(res.message);
                    opt.error && opt.error();
                }
            },
            error: function(xhr, errMsg) {
                console.log(xhr.status);
                opt.error && opt.error(xhr);
            },
            complete: function(xhr) {
                opt.complete && opt.complete(xhr);
            },
            timeout: 3000
        });
    }

    /**
     * @param type string [css|js]
     * @param file array file path
     * @return void
     */
    this.loadFile = function(type, file) {
        if ('css' == type) {
            document.write('<link' + ' rel ="stylesheet" type="text/css"' + ' media="screen" href="' + file + '">');
        } else {
            document.write('<scr' + 'ipt type="text/javascript" src="' + file + '" async></scr' + 'ipt>');
        }
    }

    //locate
    this.locate = function(url) {
        window.location.href = url;
    }

    /**
     * checkLogin 
     */
    this.checkLogin = function() {
        var self = this;
        //checking the login state in SSO center
        this.request({
            type: 'GET',
            dataType: 'jsonp',
            url: SSOURL + '/state',
            success: function(data) {
                if (false == data.success) {
                    //checking the login state in passport service
                    self.request({
                        type: 'GET',
                        dataType: 'jsonp',
                        url: PASSPORTURL + '/state',
                        success: function(data) {
                            var referer = window.location.href;
                            if (false == data.success) {
                                var callBackUrl = PASSPORTURL + '/index.html?redirectURL=' + escape(referer);
                                self.locate(callBackUrl);
                            } 
                            if (true == data.success) {
                                var callBackUrl = PASSPORTURL + '/jump?target=' + escape(referer); 
                                self.locate(callBackUrl);
                            }
                        }
                    })
                }
            }
        });
    }

    //domain
    this.domain = function() {
        return window.location.protocol +  '//' + window.location.host;
    }

    //loginout
    this.loginOut = function() {
        var self = this;
        this.request({
            type: 'GET',
            dataType: 'jsonp',
            url: PASSPORTURL + '/clear'
        })
    }
}

DHB.prototype = {
    getUserInfo: function() {
        var domain = this.domain();
        this.request({
            type: "GET",
            dataType: 'json',
            url: domain + '/index/goods/get',
            success: function(data) {
                console.log(data); 
            }
        })
    }

}

var $D = new DHB();
//Running
$D.loadFile('js', RESOURCEURL + '??' + initJs.join(','));
$D.loadFile('css', RESOURCEURL + '??' + initCss.join(','));
$D.checkLogin();
$D.getUserInfo();
//LoginOut
//$D.loginOut();
