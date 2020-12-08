function getBrowserInfo()
{
    var agent = navigator.userAgent.toLowerCase() ;

    var regStr_ie = /msie [\d.]+;/gi ;
    var regStr_ff = /firefox\/[\d.]+/gi
    var regStr_chrome = /chrome\/[\d.]+/gi ;
    var regStr_saf = /safari\/[\d.]+/gi ;
//IE
    if(agent.indexOf("msie") > 0)
    {
        return agent.match(regStr_ie) ;
    }

//firefox
    if(agent.indexOf("firefox") > 0)
    {
        return agent.match(regStr_ff) ;
    }

//Chrome
    if(agent.indexOf("chrome") > 0)
    {
        return agent.match(regStr_chrome) ;
    }

//Safari
    if(agent.indexOf("safari") > 0 && agent.indexOf("chrome") < 0)
    {
        return agent.match(regStr_saf) ;
    }

}

var browser = getBrowserInfo();
var verinfo = (browser+"").replace(/[^0-9.]/ig,"");
var browserName = (browser+"").replace(/[^a-z.]/ig,"");
if(browserName == "msie.") {

    if(verinfo < 10) {
        alert("系统检测，当前浏览器版本过低，为了更好的产品体验，请升级到IE10版本以上，使用火狐浏览器或chrome浏览器!");
    }
}