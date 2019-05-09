/*!
* Vancl JavaScript Library v1.0
*
* Copyright 2011, http://www.vancl.com
*
* Referrer: jquery library 1.4
* Author: chenqiliang
* Date: 2011.10.17
*/

// window作为局部变量传入，压缩可修改变量名; 防止undefined被重写
(function (window, undefined) {
    // 重写vancl对象
    var vancl = {
        codec: function (str, isEncode) {
            /// <summary>
            /// 字符串编码，解码;
            /// </summary>
            /// <param name="str" type="String">需要编码的字符串</param>
            /// <param name="isEncode" type="Boolean">编码传入true，解码传入false</param>
            /// <returns type="String">返回[编|解]码后字符串</returns>
            return isEncode ? encodeURIComponent(str) : decodeURIComponent(str);
        },

        addQueryString: function (url, name, value) {
            /// <summary>
            /// 添加url参数，返回编码后的url
            /// </summary>
            /// <param name="url" type="String">url字符串</param>
            /// <param name="name" type="String">参数名</param>
            /// <param name="value" type="String">参数值</param>
            /// <returns type="String">返回编码后的url</returns>
            url += url.indexOf("?") === -1 ? "?" : "&";
            url += this.codec(name, true) + "=" + this.codec(value, true);
            return url;
        },

        getQueryString: function (name) {
            /// <summary>
            /// 获取querystring，如果传入name则获取其值，否则获取所有参数值，并以key/value的json对象返回,不区分大小写。
            /// </summary>
            /// <param name="name" type="String">url参数名</param>
            /// <returns type="String|json">如果传入name则获取其值，否则获取所有参数值，并以key/value的json对象返回</returns>
            var qs = (location.href.length > 0 ? location.search.substring(1) : "");
            return this.getUrlValByName(qs, name);
        },

        getUrlValByName: function (url, name, IgnoreCase) {
            /// <summary>
            /// 获取querystring，如果传入name则获取其值，否则获取所有参数值，并以key/value的json对象返回,不区分大小写。
            /// </summary>
            /// <param name="url" type="String">url字符串</param>
            /// <param name="name" type="String">url参数名</param>
            /// <param name="IgnoreCase" type="Boolean">区分大小写,默认不区分大小写</param>
            /// <returns type="String|json">如果传入name则获取其值，否则获取所有参数值，并以key/value的json对象返回</returns>
            if (!IgnoreCase) {
                url = url.toLowerCase();
            }
            var tmp = url.substr(url.indexOf("?") + 1).split("&");
            var obj = {}, item = [];
            for (var i = 0, len = tmp.length; i < len; i++) {
                item = tmp[i].split("=");
                if (item instanceof Array) {
                    obj[vancl.codec(item[0], false)] = vancl.codec(item[1], false);
                }
            }
            return (typeof name === "string") ? obj[name] : obj;
        },

        isInRange: function () {
            /// <summary>
            /// 如果传入的三个数都是数字则判断第一个参数是否在后两个数（min，max）范围内包括min和max本身, 如果在范围内返回true,否则返回false；
            /// 如果传入的第三个参数是true则比较第一个参数是否大于等于第二个参数, 如果大于等于返回true，否则返回false；
            /// 如果传入的第三个参数是false则比较第一个参数是否小于等于第二个参数, 如果小于等于返回true，否则返回false；
            /// 其他一切情况返回false包括异常情况
            /// </summary>
            if (arguments.length === 3) {
                try {
                    var arg1 = parseInt(arguments[0])
                            , arg2 = parseInt(arguments[1]);
                    if (typeof arguments[2] === "boolean") {
                        if (arguments[2]) {
                            return arg1 > arg2;
                        }
                        else {
                            return arg1 < arg2;
                        }
                    }
                    else {
                        var arg3 = parseInt(arguments[2]);
                        return arg1 > arg2 && arg1 < arg3;
                    }
                }
                catch (e) {
                    return false;
                }
            }
            return false;
        },

        formatMoney: function (money, len) {
            /// <summary>
            /// 格式化价格
            /// </summary>
            /// <param name="money" type="Number">货币</param>
            /// <param name="len" type="Number">保留小数位数</param>
            len = len || 2;
            var val = parseFloat(money).toFixed(len);
            val = isNaN(val) ? "0.00" : val;
            return val;
        },

        rndInRange: function (lowerValue, upperValue, isNumber) {
            /// <summary>
            /// 产生指定范围内的随机数,如果isNumber为true则返回整数，否则返回小数.
            /// </summary>
            /// <param name="lowerValue" type="Number">下限值</param>
            /// <param name="upperValue" type="Number">上限值</param>
            /// <param name="isNumber" type="Boolean">如果isNumber为true则返回整数，否则返回小数.</param>
            /// <returns type="number">如果isNumber为true则返回整数，否则返回小数.</returns>
            if (typeof lowerValue === "number" && typeof upperValue === "number") {
                var choices = (isNumber ? (upperValue - lowerValue + 1) :
                    (upperValue - lowerValue)),
                    rnd = Math.random() * choices + lowerValue;
                return isNumber ? Math.floor(rnd) : rnd;
            }
            else {
                jQuery.error("rndInRange方法异常：传入的参数必须为number类型。");
            }
        },

        operateClipboard: function (event, value) {
            /// <summary>
            /// 得到或获取剪切板, 如果传入value则设置剪切板，否则设置; 操作成功返回true，否则返回false。
            /// </summary>
            /// <param name="event" type="event object">事件对象</param>
            /// <param name="value" type="String">设置的文本</param>
            /// <returns type="integer">操作成功返回true，否则返回false。</returns>
            if (arguments.length === 2) {
                if (event.clipboardData) {
                    return event.clipboardData.setData("text/plain", value);
                }
                else {
                    return window.clipboardData.setData("text", value);
                }
            }
            else {
                return (event.clipboardData || window.clipboardData).getData("text");
            }
        },

        throttle: function (fn, context, interval) {
            /// <summary>
            /// 函数节流，让函数至少间隔interval ms才执行一次, 默认200ms。
            /// </summary>
            /// <param name="fn" type="Function">需要执行的函数</param>
            /// <param name="context" type="context object">上下文对象</param>
            /// <param name="interval" type="Integer">时间间隔，单位为ms,默认200ms</param>
            clearTimeout(fn.timeId);
            // 大部分浏览器只能精确到10ms，chrome能到2ms
            interval = (typeof interval !== "number" && interval < 10) || 200;
            fn.timeId = setTimeout(function () {
                fn.call(context);
            }, interval);
        },

        reg: {
            // contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
            email: "/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i",
            // contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
            url: "/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i",
            // http://docs.jquery.com/Plugins/Validation/Methods/number
            number: "/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/",
            // http://docs.jquery.com/Plugins/Validation/Methods/digits
            digits: "/^\d+$/",
            // 验证中国邮政编码
            postalCode: "/^\d{6}$/",
            // 验证中国电话
            phone: "/^((\d{3,4})\-{0,1}){0,1}(\d{7,8})$/",
            // 验证中国手机号
            mobilePhone: "/^((13|15|18|14)\d{9})$/"
        }
    };

    vancl.simpleDialog = function (event, optional) {
        /// <summary>
        /// 显示对话框到固定位置，使用此对话框需要在body中添加如下html:
        /// <div class="simple-dialog">
        ///     <div class="cancel-icon">
        ///     </div>
        ///     <p class="msg">
        ///     </p>
        ///     <p class="buttons">
        ///         <a class="sure"></a><a class="cancel"></a>
        ///     </p>
        ///     <span class="arrow"></span>
        /// </div>
        /// </summary>
        /// <param name="event" type="Event Object">事件对象</param>
        /// <param name="optional" type="Json Object">
        /// 参数格式如下：
        /// { sure: function(){ doSomething }
        ///    cancel: function(){ doSomething }
        ///    msg: 传入的字符串, sureTxt: 传入的字符串, cancelTxt: 传入的字符串 }
        /// </param>
        /// <returns type="jQuery">返回jQuery对话框</returns>        
        if ($(".simple-dialog").length < 1) {
            $("body").append("<div class='simple-dialog'>"
                                + "<div class='deltishi_topico'>"
                                + "</div>"
                                + "<p class='msg'>"
                                + "</p>"
                                + "<p class='buttons'>"
                                + "    <a class='sure'></a><a class='cancel'></a>"
                                + "</p>"
                                + "<span class='simple-dialog-arrow'></span>"
                            + "</div>"
            );
        }
        var dialog = $(".simple-dialog");
        // 如果传递两个参数则说明要重写对话框，如果是一个参数则看对话框是否初始化过，
        // 如果没有初始化则进行初始化，否则不初始化。
        if (arguments.length === 2 || !dialog.data("isInit")) {
            dialog.data("isInit", true);

            var defaultOpt = { sure: null, cancel: null,
                msg: "确定要执行此操作吗？", sureTxt: "确定", cancelTxt: "取消"
            };
            optional = jQuery.extend({}, defaultOpt, optional);

            dialog.find(".msg").text(optional.msg);
            dialog.find(".sure").text(optional.sureTxt).unbind().click(function () {
                if (optional.sure instanceof Function) {
                    //optional.sure.apply(optional.sureContext || null, (optional.sureArg instanceof Array) ? optional.sureArg : null);
                    //optional.sure((optional.sureArg instanceof Array) ? optional.sureArg : null);
                    optional.sure();
                }
                dialog.hide();
                return false;
            });
            dialog.find(".cancel,.cancel-icon").unbind().click(function () {
                if (optional.cancel instanceof Function) {
                    //optional.cancel.apply(optional.cancelContext || null, (optional.cancelArg instanceof Array) ? optional.cancelArg : null);
                    //optional.cancel((optional.cancelArg instanceof Array) ? optional.cancelArg : null);
                    optional.cancel();
                }
                dialog.hide();
                return false;
            }).filter(".cancel").text(optional.cancelTxt);

            // 只有dialog尺寸发生改变时，才需要重新计算高度，否则缓存在自定义属性中
            dialog.css("position", "static").show()
                        .data("height", dialog.outerHeight() + dialog.find(".arrow").height())
                        .hide().css("position", "absolute");
        }

        event = event || window.event;
        dialog.show();
        var eventObjOffset = $(event.currentTarget).offset(),
                    topPos = eventObjOffset.top - dialog.data("height");
        var rDialog = dialog.css({ left: event.pageX + "px", top: topPos + "px" });
        if ($.fn.bgiframe) {
            rDialog.bgiframe();
        }
        return rDialog;
    };

    vancl.dialog = {
        /// <summary>
        /// reference: jquery-1.3.2+, ui.dialog 1.8.3, dialog.css;
        /// author: chen qiliang(chenky)
        /// data: 2011-6-20
        /// update: 2011-11-2
        /// description: vancl dialog library
        /// test in ie6,7,8,9 firefox4.0.1
        /// </summary>
        alert: function (options) {
            /// <summary>
            /// 弹出对话框; 
            /// </summary> 
            /// <param name="options" type="Json">
            /// 可选参数，包括如下属性：
            /// title: "alert对话框", msg: "带绑定函数的alert对话框", modal: true,
            /// sureTxt: "确定"
            /// fn: function() { alert("绑定函数被成功触发！") }, close: function() { alert("close");    
            ///</param>
            /// <returns type="jQuery">返回jQuery对话框</returns>
            options.buttons = [
                {
                    text: options.sureTxt || "确定",
                    click: options.fn
                }
            ];

            return vancl.dialog.custDialog(options);
        },

        confirm: function (options) {
            /// <summary>
            /// 弹出对话框; 
            /// </summary> 
            /// <param name="options" type="Json">
            /// 可选参数，包括如下属性：
            /// title: "confirm对话框", msg: "带绑定函数的confirm对话框", modal: true,
            /// sureTxt: "确定", cancelTxt: "取消"
            /// fn: function() { alert("confirm 确定按钮绑定函数被成功触发！") }
            /// , close: function() { alert("close");    
            ///</param>
            /// <returns type="jQuery">返回jQuery对话框</returns>
            options.buttons = [
                {
                    text: options.sureTxt || "确定",
                    click: function () { options.fn(); $(this).dialog('close'); }
                },
                {
                    text: options.cancelTxt || "取消",
                    click: function () {
                        $(this).dialog('close');
                    },
                    className: "close-button"
                }
            ];

            return vancl.dialog.custDialog(options);
        },

        custDialog: function (options) {
            options.msg = options.msg || "";
            options.minHeight = "auto";
            var custDialog = $("#v-dialog");
            if (custDialog.length > 0) {
                custDialog = custDialog.empty().append(options.msg);
            }
            else {
                custDialog = $("<div id='v-dialog' style='width: auto; height: auto; min-height: auto;'></div>")
                .append(options.msg);
            }
            return custDialog.dialog(options);
        }
    };

    // 日期操作函数
    jQuery.extend(
        Date.prototype,
        {
            isLeapYear: function () {
                /// <summary>判断闰年</summary> 
                /// <returns type="Boolean">是闰年返回true，否则返回false。</returns>
                return (0 == this.getYear() % 4 && ((this.getYear() % 100 != 0) || (this.getYear() % 400 == 0)));
            },
            format: function (format) {
                /// <summary>
                /// 返回指定格式的日期; 
                /// 格式 YYYY/yyyy/YY/yy 表示年份
                /// MM/M 月份
                /// W/w 星期
                /// dd/DD/d/D 日期
                /// hh/HH/h/H 时间
                /// mm/m 分钟
                /// ss/SS/s/S 秒
                /// </summary>
                /// <param name="format" type="String">日期格式字符串</param>
                /// <returns type="String">返回指定格式的日期;</returns>
                var week = ['日', '一', '二', '三', '四', '五', '六'];
                var o = {
                    "M+": this.getMonth() + 1, //month
                    "d+|D+": this.getDate(), //day
                    "h+|H+": this.getHours(), //hour
                    "w|W": week[this.getDay()], // week
                    "m+": this.getMinutes(), //minute
                    "s+": this.getSeconds() //seconds
                }

                // format year
                if (/(y+|Y+)/.test(format)) {
                    format = format.replace(RegExp.$1, this.getFullYear().toString().substr(4 - RegExp.$1.length));
                }

                for (var k in o) {
                    if (new RegExp("(" + k + ")").test(format)) {
                        format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
                    }
                }
                return format;
            }
        }
    );

    // 字符串操作扩展
    jQuery.extend(
        String.prototype,
        {
            sub: function (n) {
                /// <summary>控制字符串个数，多出的使用省略号</summary> 
                var r = /[^\x00-\xff]/g;
                if (this.replace(r, "mm").length <= n) return this; // n = n - 3;
                var m = Math.floor(n / 2);
                for (var i = m; i < this.length; i++) {
                    if (this.substr(0, i).replace(r, "mm").length >= n) {
                        return this.substr(0, i) + "...";
                    }
                }
                return this;
            }
        }
    );

    // v, vancl, vc 映射到全局作用域中
    window.vancl = window.vc = window.v = vancl;
})(window);

Number.prototype.format = function (decimalPoints, thousandsSep, decimalSep) {
    /// <summary>返回格式化后的数值</summary>
    /// <param name="decimalPoints" type="Number">Rounds a number to a specified number of decimals (optional)</param>
    /// <param name="thousandsSep" type="String">Inserts the character of your choice as the thousands separator (optional)</param>
    /// <param name="decimalSep" type="String">Uses the character of your choice for the decimals separator (optional)</param>
    /// <returns type="String">返回格式化后的数值</returns>
    var val = this + '', re = /^(-?)(\d+)/, x, y;
    if (decimalPoints != null) val = this.toFixed(decimalPoints);
    if (thousandsSep && (x = re.exec(val))) {
        for (var a = x[2].split(''), i = a.length - 3; i > 0; i -= 3) a.splice(i, 0, thousandsSep);
        val = val.replace(re, x[1] + a.join(''));
    }
    if (decimalSep) val = val.replace(/\./, decimalSep);
    return val;
}
if (typeof Number.prototype.toFixed != 'function' || (.9).toFixed() == '0' || (.007).toFixed(2) == '0.00') Number.prototype.toFixed = function (f) {
    if (isNaN(f *= 1) || f < 0 || f > 20) f = 0;
    var s = '', x = this.valueOf(), m = '';
    if (this < 0) { s = '-'; x *= -1; }
    if (x >= Math.pow(10, 21)) m = x.toString();
    else {
        m = Math.round(Math.pow(10, f) * x).toString();
        if (f != 0) {
            var k = m.length;
            if (k <= f) {
                var z = '00000000000000000000'.substring(0, f + 1 - k);
                m = z + m;
                k = f + 1;
            }
            var a = m.substring(0, k - f);
            var b = m.substring(k - f);
            m = a + '.' + b;
        }
    }
    if (m == '0') s = '';
    return s + m;
}

function stringBuilder() {
    /// <summary>
    /// 新建一个stringBuilder类型
    /// 参数格式： arg1,arg2,...argn
    /// </summary>
    this._strings = new Array();
    for (var i = 0, len = arguments.length; i < len; i++) {
        this._strings.push(arguments[i]);
    }
}

stringBuilder.prototype = {
    constructor: stringBuilder,
    append: function (str) {
        /// <summary>新建一个stringBuilder类型</summary>
        /// <param name="str" type="String">把字符串追加到数组中去</param>
        /// <returns type="Array">返回字符串数组</returns>
        return this._strings.push(str);
    },

    toString: function () {
        /// <summary>返回字符串</summary>
        /// <returns type="String">返回字符串</returns>
        return this._strings.join("");
    }
};