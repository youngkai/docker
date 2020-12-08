function IpsComet(module, method)
{
    this.data = [];
    this.pollTime = 60000;
    this.errorRetryTime = 0;
    this.pollServer = {
        module: !!module ? module : 'poll',
        method: !!method ? method : 'index'
    };
    this.setTranMode(typeof window.WebSocket);
}

IpsComet.prototype = {
    /**
     * 增加一个请求类型
     *
     * @param {string}   module   module
     * @param {string}   method   method
     * @param {Function} callback callback
     */
    add: function(module, method, callback, params) {
        if (typeof module == 'undefined' || 
            typeof method == 'undefined' || typeof callback == 'undefined'
        ) {
            throw new Error('缺少参数');
        }
        var id = this.generateId();
        this.data.push({
            id: id,
            module: module,
            method: method,
            params: params,
            callback: callback
        });
        this.execute();
    },

    /**
     * 生成ID
     *
     * @return {string} id
     */
    generateId: function() {
        var id = this._randomString(6), self = this;
        $.each(self.data, function() {
            if (id === this.id) {
                id = self.generateId();
                return true;
            }
        });
        return id;
    },

    /**
     * run request
     *
     * @return {void}
     */
    execute: function() {
        if (this.isSocket == true) {
            this.socket();
        } else {
            this.poll();
        }
    },

    /**
     * 设置请求模式
     *
     * @param {string} tranMode Transmission mode
     */
    setTranMode: function(tranMode) {
        var modes = ['socket', 'poll'];
        if (!$.inArray(tranMode, modes)) {
            throw new Error('unknow Transmission mode');
            return;
        }
        if (tranMode == 'socket' && typeof window.WebSocket) {
            this.isSocket = true;
        } else {
            this.isSocket = false;
        }
    },

    /**
     * 轮询
     *
     * @return {void}
     */
    poll: function() {
        var self = this, params = [];
        $.each(this.data, function(index, item) {
            params.push({
                id: item.id,
                module: item.module,
                method: item.method,
                params: item.params
            });
        });
        $ips.load(this.pollServer.module,
            this.pollServer.method, {data: params}, function(res) {
            $.each(res, function(index, item) {
                $.each(self.data, function(i, request) {
                    request.callback(item);
                });
            });
            setTimeout(function() {
                if(pollControl == undefined || pollControl == 0) {
                    self.poll();
                }
            }, self.pollTime);
            self.errorRetryTime = 0;
        }, function (res) {
            console.error(res.XMLHttpRequest, res.textStatus);
            if (res.XMLHttpRequest.status == 0) {
                $ips.error('获取数据失败, 网络异常!');
            } else {
                $ips.error('获取数据失败, 错误码:' + XMLHttpRequest.status);
            }
            if (self.errorRetryTime / self.pollTime < 10) {
                self.errorRetryTime += self.pollTime;
            }
            setTimeout(function() {
                if(pollControl == undefined || pollControl == 0) {
                    self.poll();
                }
            }, self.errorRetryTime);
        });
        return;
    },

    socket: function() {

    },

    _randomString: function(len) {
    　　len = len || 32;
    　　var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
    　　var maxPos = $chars.length;
    　　var str = '';
    　　for (i = 0; i < len; i++) {
            str += $chars.charAt(Math.floor(Math.random() * maxPos));
    　　}
    　　return str;
    }
};

/**
 * [cometService description]
 * 
 * @type {IpsComet}
 */
$ips.cometService = new IpsComet();

