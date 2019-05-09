/// <reference path="jquery/jquery-1.7.2-vsdoc.js" />
/// <reference path="vancl/vancl-1.1.js" />
/// <reference path="../vancl/cookie.js" />
/// <reference path="delivery.js" />
/// <reference path="present.js" />
/*
* author: chen qiliang
* desc: 订单确认页逻辑处理
* date: 2012.2.24
* todo 表示未完成。
* not best 表示不够好还可以优化
* maybe wrong 表示可能又错误 
* 包含删除的注释表示发布时候可以删除
* 变量前面加tmp表示临时变量
* 变量以Html结尾表示html字符串
* 变量以Url结尾表示url字符串
* del表示删除
*/
(function ($, window, undefined) {
    $(function () {
        var alert = vancl.dialog.alert
        , wrapper = $("#wrapper")
        , addr = $("#addr")
        , orderSummaryPanel = $("#order-summary-panel")
        , orderInfoPanel = $("#order-info-panel");
        // document.documentElement和document.body哪个有scrollTop用哪个
        //, rootDom = (document.documentElement.scrollTop === 0 ? document.body : document.documentElement);

        var setting = {
            tipStr: "提示",
            sureTxt: "确定删除",
            cancelTxt: "取消",
            delTips: "您要删除该地址吗？",
            defaultMsg: "好像出现了点小意外，请您稍后再试一次，或者请您与客服坐席400-650-7099联系。",
            addrMsg: "请您选择一个地址。",
            defaultPostalCodeTxt: "参考邮编：",
            defaultAreaCodeTxt: "参考区号：",
            tmpWarn: "请先确认",
            addrWarn: "“收货地址”",
            deliveryWarn: "“配送方式”",
            payWarn: "“支付方式”",
            submitOrderLoadingTxt: "正在提交订单...",
            GATarr: ["香港", "澳门", "台湾"],
            TaiWanArr: ["台湾"],
            noPresentMsg: "您还没有选择特惠品，确定要提交订单吗？",


            constTen: 10,
            constEleven: 11,
            constTwenty: 20,
            constThirty: 30,
            constFifty: 50,
            constOneHundred: 100,
            constTwoHundred: 200,
            constFiveHundred: 500,
            // 以f开头表示国外地址各项内容长度过长的错误提示，否则是国内
            addresseeLengthError: "收货人姓名过长，请您最多输入20个字符。",
            addrDetailLengthError: "详细地址过长，请您最多输入100个字符。",
            invoiceTitleLengthError: "发票抬头过长，请您最多输入50个字符",
            fFirstNameLengthError: "最多输入200个英语字符。",
            fLastNameLengthError: "最多输入200个英语字符。",
            fFirstAddrLengthError: "收货地址1填写过长，请您最多输入500个英语字符。",
            fSecondAddrLengthError: "收货地址2填写过长，请您最多输入500个英语字符。",
            fCityLengthError: "城市填写过长，请您最多输入200个英语字符。",
            fStateLengthError: "州/省/地区填写过长，请您最多输入200个英语字符。",
            fPostalCodeLengthError: "邮政编码填写过长，请您最多输入30个英语字符。",
            mobilePhoneLengthError: "手机号码必须11位",
            fPhoneLengthError: "电话号码填写过长，请您最多输入20个英语字符。",
            illegalStrError: "包含非法字符，请重新输入。",
            invoiceStrError: "您选择了需要发票，请填写发票抬头。",


            optHtml: "<option value='#val#'>#txt#</option>",
            tipHtml: '<div class="order-tip">'
                 + '   <div class="buyCheck_Rtips05ico">'
                 + '       <p>'
                 + '           #txt#</p>'
                 + '   </div>'
                 + '   <span class="order-tip-close"></span>'
                 + '</div>',
            giftCardHtml: '<input type="checkbox" name="UseGiftCard" id="use-gift-card" />'
                       + '<label for="use-gift-card">礼品卡支付</label>',
            modalLoadHtml: "<span class='modal-loading'></span>",
            addrRadioHtml: '<input type="radio" id="hidden-addr" checked="checked" name="AddressId" value="#val#" />',
            loadingTip: "请稍候...",
            areaInfoUrl: "/address/areainfo",
            getOrderInfoUrl: "/buy/orderinfo",
            getOrderSummaryUrl: "/order/ordersummary",
            setSplitTypeUrl: "/buy/setsplittype",
            paymentChangeLogUrl: "/order/paymentchangelog"
        };

        var orderConfirm = {
            isSupportPlaceHolder: function () {
                /// <summary>测试是否支持placeholder属性</summary>
                return 'placeholder' in document.createElement("input");
            },

            placeholder: function () {
                /// <summary>如果不支持placeholder属性，则需要做兼容性处理</summary>
                $("#wrapper :input[placeholder]").each(function () {
                    var the = $(this), val = the.val();
                    if (!orderConfirm.isSupportPlaceHolder() && the.val() == "") {
                        // 为空时才需要placeholder中的信息
                        the.val(the.attr("placeholder"));
                    }
                    if (val != "" && val != the.attr("placeholder")) {
                        // 因为html中默认有placeholder样式所以如果有信息就不要提示的placeholder样式
                        the.removeClass("place-holder");
                    }
                });
            },

            go2TopWithAnimate: function () {
                /// <summary>缓慢的回到顶端</summary>                
                this.go2WithAnimate(0);
            },

            go2WithAnimate: function (topPos) {
                /// <summary>缓慢滚动到指定y坐标</summary>
                /// <param name="topPos" type="Int">滚动到的y坐标</param>                
                try {
                    $('html,body').animate({ scrollTop: topPos }, 1000);
                }
                catch (e) {
                    $(window).scrollTop(topPos);
                }
            },

            setmodalLoadTip: function (panel, loadHtml) {
                /// <summary>异步请求时友好提示</summary>
                /// <param name="panel" type="jQuery">容器</param>
                /// <param name="loadHtml" type="html">容器中的html</param>
                if (panel.length > 0) {
                    if (typeof loadHtml === "undefined") {
                        panel.empty().append(setting.modalLoadHtml);
                    }
                    else if (typeof loadHtml === "string") {
                        panel.empty().append(loadHtml);
                    }
                }
            },

            showOrderTips: function () {
                /// <summary>设置订单提示信息</summary>
                $("#all-tips").hide();
                $("#all-tips-details").hide();
                $("#all-tips-dajian").hide();
                var tips = $("#all-tips").data("tips");
                var orderCount = $("#orderCount").val();
                if (tips instanceof Array) {
                    var tmpTipsHtml = new stringBuilder();
                    $.each(tips, function (index, val) {
                        tmpTipsHtml.append(
                        setting.tipHtml.replace(/#txt#/gi, val)
                    );
                    });
                    //$("order-tip").remove();
                    //$("#order-info-panel").prepend(tmpTipsHtml.toString());
                    if (tmpTipsHtml.toString().indexOf("您有商品暂时不能订购") > 0) {
                        $("#all-tips-details").html("非常抱歉，您有商品暂时不能订购。");
                        $("#all-tips-details").show();
                        $("#all-tips").show();
                    }
                    else {
                        $("#all-tips-details").hide();
                        $("#all-tips").hide();
                    }

                    if (tmpTipsHtml.toString().indexOf("您的订单将会被拆分发出") > 0) {
                        $("#all-tips-dajian").show();
                        //                        $("#all-tips-details").hide();
                        //                        $("#all-tips").hide();
                    }
                    else {
                        $("#all-tips-dajian").hide();
                    }

                    if ($("#all-tips-details").is(":visible") || $("#all-tips-dajian").is(":visible")) {
                        var tipsTop = $("#all-tips-details").offset().top;
                        //this.go2WithAnimate(tipsTop);
                    }
                    //                    if (tmpTipsHtml.toString() != "") {
                    //                        $("#all-tips-details").html("非常抱歉，您有商品暂时不能订购。");
                    //                        $("#all-tips-details").show();
                    //                        $("#all-tips").show();
                    //                    }
                }
                if ($("#all-tips-details").is(":visible") && $("#all-tips-details").html().toString().indexOf("您有商品暂时不能订购") < 0) {
                    $("#all-tips").hide();
                    $("#all-tips-details").hide();
                }
                if (orderCount == "0" && $("#all-tips-details").is(":hidden") && $("#all-tips").is(":hidden")) {
                    $("#all-tips-details").html("您没有选购商品，请您先<a href=\"http://www.vancl.com\" class=\"ared11\">选购商品>></a>");
                    $("#all-tips-details").show();
                    $("#all-tips").show();
                    $("#all-tips-dajian").hide();
                }
            },
            valid: function (data, callback) {
                /// <summary>后台返回数据验证,后台返回html返回值为true, 否则返回false。</summary>
                /// <param name="data" type="Json or html">请求返回的数据</param>
                /// <param name="callback" type="function">请求返回的数据</param>
                if (typeof data === "string") {
                    return true;
                }

                var title, msg, url, type;
                if (data !== null && typeof data === "object") {
                    title = data.Title;
                    msg = data.Content;
                    url = data.LinkUrl;
                    type = data.Type;
                }
                if (type == "Authorize") {
                    if (url && (document.location.protocol + "//" + document.location.host + url) !== location.href) {
                        location.href = url;
                    }
                }
                else if (type == "Redirect") {
                    location.href = url;
                    return true;
                }
                else {
                    alert({
                        title: title || setting.tipStr,
                        msg: msg || setting.defaultMsg,
                        //modal: true,
                        fn: function () {
                            $(this).dialog("close");
                            if (typeof callback === "function") {
                                callback();
                                return;
                            }
                            if (url && (document.location.protocol + "//" + document.location.host + url) !== location.href) {
                                location.href = url;
                            }
                        }
                    });
                }

                return false;
            },

            // validate the required field
            required: function (elem, defaultVal) {
                /// <summary>验证用户是否已经填写了表单</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <param name="defaultVal" type="String">默认值</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                var nodeName = elem[0].nodeName.toLowerCase();
                switch (nodeName) {
                    case "select":
                        var val = elem.val();
                        if (!defaultVal) {
                            return val && val.length > 0;
                        }
                        else {
                            return defaultVal != val;
                        }
                    case "input":
                        var type = elem.attr("type");
                        if (type === "radio" || type === "checkbox") {
                            var name = elem.attr("name");
                            var inputs = $("[name=" + name + "]");
                            var isCheck = false;
                            inputs.each(function (i) {
                                if ($(this).is(":checked")) {
                                    isCheck = true;
                                    return false;
                                }
                            });
                            return isCheck;
                        }
                        else {
                            return defaultVal ? $.trim(elem.val()) != defaultVal : $.trim(elem.val()).length > 0;
                        }
                    default:
                        return defaultVal ? $.trim(elem.val()) != defaultVal : $.trim(elem.val()).length > 0;
                }
            },

            scriptInjection: function (elem) {
                /// <summary>验证用户是否已经填写了表单</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <param name="defaultVal" type="String">默认值</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                var nodeName = elem[0].nodeName.toLowerCase();
                switch (nodeName) {
                    case "input":
                    case "textarea":
                        var type = elem.attr("type");
                        if (type !== "radio" || type !== "checkbox") {
                            return /^([^<>]+)?$/.test(elem.val());
                        }
                    default:
                        return true;
                }
            },

            setIllegalStrError: function (elem) {
                /// <summary>如果包含非法字符串则显示错误提示，否则隐藏</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                if (this.scriptInjection(elem)) {
                    this.hideError(elem);
                    return true;
                }
                else {
                    this.showError(elem, setting.illegalStrError);
                    return false;
                }
            },

            // validate the telephone number
            telePhone: function (elem) {
                /// <summary>验证电话号码</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                //                return /^((\d{3,4})\-{0,1}){0,1}(\d{7,8})(\-{0,1}\d{1,6}){0,1}$/.test(elem.val());
                return /^\d{3,4}-\d{7,8}(-\d{1,4})?$/.test(elem.val());
            },

            // validate the mobile phone number
            mobilePhone: function (elem) {
                /// <summary>验证手机号码</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                return /^(1\d{10})$/.test(elem.val());
            },

            /*telePhone4GAT: function (elem) {
            /// <summary>验证港澳台电话号码</summary>
            /// <param name="elem" type="jQuery">元素</param>
            /// <returns type="Boolean">验证通过返回true，否则false</returns>
            return /^(0\d{2,3}-)?[2,3]{1}\d{7}(-\d{1,6})?$/.test(elem.val());
            },

            mobilePhone4GAT: function (elem) {
            /// <summary>验证港澳台手机号码</summary>
            /// <param name="elem" type="jQuery">元素</param>
            /// <returns type="Boolean">验证通过返回true，否则false</returns>
            return /^\d{1,11}$/.test(elem.val());
            },*/

            isContain: function (val, arr) {
                /// <summary>arr中是否包含val，是返回true，否返回false</summary>
                /// <param name="val" type="String">字符串</param>
                /// <param name="arr" type="Array">比较的数组</param>
                /// <returns type="Boolean">是返回true，否返回false</returns>
                if (typeof val === "string" && arr instanceof Array) {
                    for (index in arr) {
                        if (val.indexOf(arr[index]) > -1) {
                            return true;
                        }
                    }
                    return false;
                }
                else {
                    $.error("参数错误，函数名isContain,参数个数或类型错误。");
                }
            },

            isContainGAT: function (val) {
                /// <summary>是否包含港澳台，是返回true，否返回false</summary>
                /// <param name="val" type="String">字符串</param>
                /// <returns type="Boolean">是返回true，否返回false</returns>
                return this.isContain(val, setting.GATarr);
            },

            isContainTaiWan: function (val) {
                /// <summary>是否包含台湾，是返回true，否返回false</summary>
                /// <param name="val" type="String">字符串</param>
                /// <returns type="Boolean">是返回true，否返回false</returns>
                return this.isContain(val, setting.TaiWanArr);
            },

            maxLength: function (elem, maxlength) {
                /// <summary>验证输入字符个数小于等于maxlength</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <param name="maxlength" type="Number">最大长度</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                return $.trim(elem.val()).length <= maxlength;
            },

            equalTo: function (elem, length) {
                /// <summary>验证输入字符个数是否等于length</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <param name="length" type="Number">长度</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                return $.trim(elem.val()).length === length;
            },

            setLengthError: function (elem, maxlength, errorMsg) {
                /// <summary>验证不通过显示错误信息，否则清空错误信息并隐藏</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <param name="maxlength" type="Number">最大长度</param>
                /// <param name="errorMsg" type="String">错误信息</param>
                if (this.maxLength(elem, maxlength)) {
                    this.hideError1(elem);
                }
                else {
                    this.showError1(elem, errorMsg);
                }
            },

            setInlandMobileLengthError: function (elem, length, errorMsg) {
                /// <summary>验证不通过显示错误信息，否则清空错误信息并隐藏</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <param name="length" type="Number">最大长度</param>
                /// <param name="errorMsg" type="String">错误信息</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                if (this.equalTo(elem, length)) {
                    this.hideError(elem);
                    return true;
                }
                else {
                    this.showError(elem, errorMsg);
                    return false;
                }
            },

            digits: function (elem) {
                /// <summary>验证港澳台整数数字</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                return /^\d+$/.test(elem.val());
            },

            // validate the postal code number
            postalCode: function (elem) {
                /// <summary>验证邮政编码</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                return /^\d{6}$/.test(elem.val());
            },

            // validate the postal code number
            postalCodeTaiWan: function (elem) {
                /// <summary>验证邮政编码</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <returns type="Boolean">验证通过返回true，否则false</returns>
                return /^\d{5,}$/.test(elem.val());
            },

            showError: function (elem, msg) {
                /// <summary>显示错误信息</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <param name="msg" type="String">字符串信息</param>
                if (typeof msg === "string") {
                    elem.nextAll(".buy_addAinfo02Tips:eq(0)").text(msg);
                }
                elem.nextAll(".buy_addAinfo02Tips:eq(0)").show();
            },

            hideError: function (elem) {
                /// <summary>显示错误信息</summary>
                /// <param name="elem" type="jQuery">元素</param>
                elem.nextAll(".buy_addAinfo02Tips:eq(0)").hide();
            },
            showError1: function (elem, msg) {
                /// <summary>显示错误信息</summary>
                /// <param name="elem" type="jQuery">元素</param>
                /// <param name="msg" type="String">字符串信息</param>

                elem.text(msg);
                elem.show();
            },

            hideError1: function (elem) {
                /// <summary>显示错误信息</summary>
                /// <param name="elem" type="jQuery">元素</param>
                elem.hide();
            },

            addrChange: function () {
                /// <summary>收货地址变化刷新配送方式</summary>
                delivery.initDelivery();
            },
            getCityByProvince: function (province) {
                /// <summary>根据省获取市</summary>
                /// <param name="province" type="String">省名</param> 
                var provinceInDetail = $("#province-in-detail");
                $("#city-in-detail").text("");
                $("#area-in-detail").text("");
                if (province !== "") {
                    var url = setting.areaInfoUrl + "?province=" + province;
                    provinceInDetail.text($("#province-id").children(":selected").text() + ",");
                }
                else {
                    $("#city-id").children(":gt(0)").remove();
                    $("#area-id").children(":gt(0)").remove();
                    provinceInDetail.text("");
                    return;
                }
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { },
                    success: function (data) {
                        var tmpHtml = new stringBuilder();
                        $.each(data, function (idx, val) {
                            var city = val.split(",")
                                , cityVal = city[0]
                                , cityTxt = city[1];
                            tmpHtml.append(
                                setting.optHtml.replace(/#val#/gi, cityVal)
                                                .replace(/#txt#/gi, cityTxt)
                            );
                        });
                        $("#city-id").children(":gt(0)").remove();
                        $("#city-id").append(tmpHtml.toString());
                        // 清空地区列表项
                        $("#area-id").children(":gt(0)").remove();
                    }
                });
            },

            getAreaByPC: function (province, city) {
                /// <summary>根据省市获取地区</summary>
                /// <param name="province" type="String">省编号</param> 
                /// <param name="city" type="String">市编号</param> 
                var cityInDetail = $("#city-in-detail");
                $("#area-in-detail").text("");
                if (province !== "" && city !== "") {
                    var url = setting.areaInfoUrl + "?province=" + province + "&city=" + city;
                    cityInDetail.text($("#city-id").children(":selected").text() + ",");
                }
                else {
                    $("#area-id").children(":gt(0)").remove();
                    cityInDetail.text("");
                    return;
                }
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { },
                    success: function (data) {
                        var tmpHtml = new stringBuilder();
                        $.each(data, function (idx, val) {
                            var area = val.split(",")
                                , areaVal = area[0]
                                , areaTxt = area[1];
                            tmpHtml.append(
                                setting.optHtml.replace(/#val#/gi, areaVal)
                                                .replace(/#txt#/gi, areaTxt)
                            );
                        });
                        $("#area-id").children(":gt(0)").remove();
                        $("#area-id").append(tmpHtml.toString());
                    }
                });
            },

            getPostalCodeAndAreaCodeByPCA: function (province, city, area) {
                /// <summary>根据省市区获取邮政编码和区号</summary>
                /// <param name="province" type="String">省编号</param> 
                /// <param name="city" type="String">市编号</param> 
                /// <param name="area" type="String">地区编号</param> 
                var areaInDetail = $("#area-in-detail")
                    , defPostalCode = $("#default-postal-code")
                    , usePostalCode = $("#use-postal-code")
                    , defAreaCode = $("#default-area-code")
                    , useAreaCode = $("#use-area-code");
                if (province !== "" && city !== "" && area !== "") {
                    var url = setting.areaInfoUrl + "?province=" + province
                        + "&city=" + city + "&area=" + area;
                    areaInDetail.text($("#area-id").children(":selected").text() + ",");
                }
                else {
                    defPostalCode.data("postal-code", "").text("").hide();
                    usePostalCode.hide();
                    defAreaCode.data("area-code", "").text("").hide();
                    useAreaCode.hide();
                    areaInDetail.text("");
                    return;
                }
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { },
                    success: function (data) {
                        var postalCode = data["PostalCode"]
                                , areaCode = data["AreaCode"];
                        defPostalCode.data("postal-code", postalCode).text(setting.defaultPostalCodeTxt + postalCode).show();
                        usePostalCode.show();
                        defAreaCode.data("area-code", areaCode).text(setting.defaultAreaCodeTxt + areaCode).show();
                        useAreaCode.show();
                    }
                });
            },

            setUserChooseAddr: function () {
                /// <summary>确保提交的地址是用户最后选择的地址</summary>
                var addrList = $("#modify-addr-form table");
                // 如果地址列表没有选中项默认选中第一个
                var addrRadios = addrList.find("input[name='AddressId']")
                    , selectedAddrVal = addr.data("selected-addr-val")
                    , selectedAddr = addrRadios.filter("[value=" + selectedAddrVal + "]");
                if (selectedAddr.length === 1) {
                    // 当前地址列表中存在用户已经选择的地址，则选中它
                    selectedAddr.attr("checked", true);
                }
                else if (typeof selectedAddrVal === "string") {
                    // 清空之前的选择项
                    addrRadios.attr("checked", false);
                    // 当前地址列表中不存在用户已经选择的地址，则复制这个地址（隐藏的radio）到当前列表
                    //addrRadios.eq(0).parent().append(setting.addrRadioHtml.replace(/#val#/, selectedAddrVal));
                }
            },

            expandAddrList: function (url, callback) {
                /// <summary>展开收货地址列表（国内和国外）</summary>
                /// <param name="url" type="String">展开地址的url</param> 
                /// <param name="callback" type="Function">回调函数</param> 
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { orderConfirm.setmodalLoadTip(addr.find("ul")); },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            addr.html(data);
                            if (typeof callback === "function") {
                                var addAddr = $("#add-addr"); // radio按钮，单击它可获取填写地址信息的表单                                    
                                callback(addAddr);
                            }
                        }
                    }
                });
            },

            getAddrListByPage: function (obj) {
                /// <summary>展开收货地址列表（国内和国外）</summary>
                /// <param name="obj" type="jQuery">单击对象</param> 
                var url = obj.attr("href"), addrList = addr.find(".buyCheck_addAddress");
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { orderConfirm.setmodalLoadTip(addrList); },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            addrList.html(data);
                            addr.find(".save-addr").show();
                            orderConfirm.setUserChooseAddr();
                        }
                    }
                });
            },

            getDefaultAddr: function (obj) {
                /// <summary>获取默认地址（国内和国外）</summary>
                /// <param name="obj" type="jQuery">单击对象</param> 
                var url = obj.attr("href");
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { orderConfirm.setmodalLoadTip(addr.find("section")); },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            addr.html(data);
                        }
                    }
                });
            },

            getAddrForm: function (url) {
                /// <summary>获取地址表单(包括国内，国外的添加和编辑)</summary>
                /// <param name="url" type="String">地址表单的url</param> 
                var addrForm = addr.find(".addr-form");
                // 如果是新用户没有地址列表的话(.addr-form在地址列表中)
                //if (addrForm.length === 0) {
                //addrForm = addr;
                //}
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { orderConfirm.setmodalLoadTip(addrForm); },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            addr.find(".save-addr").hide();
                            addrForm.html(data);
                            // html5 placeholder属性做兼容性处理
                            orderConfirm.placeholder();
                        }
                    }
                });
            },

            delAddr: function (obj) {
                /// <summary>删除一个地址（国内和国外）</summary>
                /// <param name="obj" type="jQuery">要删除的对象</param> 
                var url = obj.attr("href");
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            addr.html(data);
                            orderConfirm.setUserChooseAddr();
                        }
                    }
                });
            },

            preventSubmitPlaceholderVal: function (form) {
                /// <summary>阻止表单提交placeholder中的值</summary>
                /// <param name="form" type="jQuery">需要提交表单</param>                 
                form.find(":input[placeholder]").each(function () {
                    var inputField = $(this);
                    if (inputField.val() === inputField.attr("placeholder")) {
                        inputField.val("");
                    }
                });
            },

            modifyDefaultAddr: function (form) {
                /// <summary>修改默认地址</summary>
                /// <param name="form" type="jQuery">需要提交表单</param>
                // 禁止表单提交placeholder中的值 
                this.preventSubmitPlaceholderVal(form);
                var param = form.serialize()
                , url = form.attr("action") + "?" + param;
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            addr.html(data);
                            // 收货地址变更
                            orderConfirm.addrChange();
                            orderConfirm.go2TopWithAnimate();
                        }
                    }
                });
            },

            saveNewAddr: function (form) {
                /// <summary>保存新地址</summary>
                /// <param name="form" type="jQuery">需要提交表单</param>
                // 禁止表单提交placeholder中的值 
                this.preventSubmitPlaceholderVal(form);
                var param = form.serialize()
                , url = form.attr("action");
                var addrForm = $("#set-addr-form");

                $.ajax({
                    type: "POST",
                    url: url,
                    data: param,
                    beforeSend: function () { orderConfirm.setmodalLoadTip(addrForm); },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            addr.html(data);
                            // 收货地址变更
                            orderConfirm.addrChange();
                            orderConfirm.go2TopWithAnimate();
                        }
                    }
                });
            },

            getOrderInfo: function () {
                /// <summary>更新订单信息</summary>
                $.ajax({
                    type: "GET",
                    //url: vancl.addQueryString(setting.getOrderInfoUrl, "_", new Date()),
                    cache: false,
                    url: vancl.addQueryString(setting.getOrderInfoUrl, "async", "true"),
                    beforeSend: function () { orderConfirm.setmodalLoadTip(orderInfoPanel); },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            orderInfoPanel.html(data);
                            orderConfirm.excuteOrderInfo();
                        }
                    }
                });
            },

            excuteOrderInfo: function () {
                /// <summary>更新订单信息后的后续操作</summary>
                orderConfirm.showOrderTips();
                //是否强制展开发票
                var temp = $("#must-invoice").attr("data-invoice-tip");
                if ($("#must-invoice").attr("data-invoice-tip") == "True") {
                    window.invoice.invoiceNeedOpen(true);
                }
                window.payment.paymentReopenByOrderInfo();
            },

            getOrderSummary: function () {
                /// <summary>更新订单总计信息</summary>
                $.ajax({
                    type: "GET",
                    cache: false,
                    url: vancl.addQueryString(setting.getOrderSummaryUrl, "async", "true"),
                 //   url: vancl.addQueryString(setting.getOrderSummaryUrl, "_", new Date()),
                    beforeSend: function () { },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            orderSummaryPanel.html(data);


                            //cart.loadGiftProduct();
                            cart.loadGift($("#gift"));
                            
                            // 延迟加载所有图片
                            var isHttp = (location.protocol === "http:");
                            $("img.lazy:visible").each(function () {
                                var self = $(this);
                                if (self.filter(":above-the-fold").length > 0) {
                                    var originUrl = self.data("origin");
                                    originUrl = (isHttp ? originUrl.replace(staticResourcePath.sslimg, staticResourcePath.img) : originUrl);
                                    self.attr("src", originUrl);
                                }
                            });
                        }
                    }
                });
            },

            getOrderInfoAndSummary: function () {
                /// <summary>同时更新订单列表和订单总计信息</summary>
                orderConfirm.getOrderInfo();
                orderConfirm.getOrderSummary();
            },

            setSplitType: function (splittype) {
                /// <summary>设置分单方式</summary>
                /// <param name="splittype" type="String">分单方式</param>
                var url = setting.setSplitTypeUrl + "?splittype=" + splittype;
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function () { orderConfirm.setmodalLoadTip(orderInfoPanel); },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            orderInfoPanel.html(data);
                            delivery.initDelivery();//更改分单方式时，避免配送方式不支持，重新刷新一下配送方式
                            orderConfirm.excuteOrderInfo();
                            //3. 重新加载清单总计
                            orderConfirm.getOrderSummary();
                        }
                    }
                });
            },

            saveOrder: function (a) {
                /// <summary>提交订单</summary>
                /// <param name="form" type="jQuery">需要提交表单</param>
                var requireInvoice = $("#invoice-check").is(":checked")
                , requireComment = $("#remark-check").is(":checked")
                , invoiceCustomerType = $("#invoice-custom").val()
                , invoiceTitle = $("#invoice-title").val()
                , invoiceContent = $("#invoice-content").val()
                , invoicetaxNo = $("#invoice-taxNo").val() == undefined ? "" : $("#invoice-taxNo").val();
                var comments = $("#remark-content").val();
                if (!requireComment || comments == "留言请在50字以内") {
                    comments = "";
                }
                var param = "requireInvoice=" + requireInvoice
                                + "&invoiceCustom=" + invoiceCustomerType
                                + "&invoiceTitle=" + invoiceTitle
                                + "&invoiceContent=" + invoiceContent
                                + "&invoiceTaxNo=" + invoicetaxNo
                                + "&comments=" + comments
                , url = a.attr("href");
                if (a.is(".submit-order-loading")) { return; }
                // 添加加载提示, 其中blur事件是为了解决ie按钮的黑边框问题
                a.blur().removeClass("buyCheck_RtipsBtn")
                          .addClass("submit-order-loading").html(setting.submitOrderLoadingTxt);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: param,
                    beforeSend: function () { },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                        }
                        else {
                            a.removeClass("submit-order-loading")
                            .addClass("buyCheck_RtipsBtn").html("");
                        }
                    },
                    error: function () {
                        a.removeClass("submit-order-loading")
                           .addClass("buyCheck_RtipsBtn").html("");
                    }
                });
            },

            updateOrder: function (form) {
                /// <summary>下单后选择在线支付方式</summary>
                /// <param name="form" type="jQuery">需要提交表单</param>
                var param = form.serialize()
                //, url = form.attr("action") + "?" + param
                , url = form.attr("action")
                $.ajax({
                    type: "POST",
                    url: url,
                    data: param,
                    beforeSend: function () { },
                    success: function (data) {
                    }
                });
            },

            setPaymentChangeLog: function (param) {
                /// <summary>下单后支付方式变更记录</summary>
                /// <param name="form" type="jQuery">需要提交表单</param>
                var param = param
                , url = setting.paymentChangeLogUrl
                $.ajax({
                    type: "POST",
                    url: url,
                    data: param,
                    beforeSend: function () { },
                    success: function (data) {
                    }
                });
            },

            setGlobalLoadTip: function (isHide) {
                /// <summary>异步请求时友好提示</summary>
                /// <param name="isHide" type="Boolean">是否隐藏</param>  
                if (isHide) {
                    $(".loading").hide();
                    $(":checkbox").each(function () {
                        var the = $(this);
                        the.attr("disable", true);
                    });
                }
                else {
                    $(":checkbox").each(function () {
                        var the = $(this);
                        the.attr("disable", false);
                    });
                    if ($(".loading").length < 1) {
                        $("body").append("<div class='loading'><span></span><b></b></div>");
                    }
                    var loading = $(".loading");
                    loading.children("b").text(setting.loadingTip);
                    loading.show();
                    if ($.browser.msie && $.browser.version < 7) {
                        var topPos = $(window).height() / 2 + $(document).scrollTop()
                        , leftPos = $(window).width() / 2 + $(document).scrollLeft();
                        loading.css({ top: topPos, left: leftPos });
                    }
                }
            },
            delProduct: function (obj) {
                var url = obj.attr("href");
                //, isPromotee = obj.closest("tbody").is("#present-product")
                //, isPoint = vancl.getUrlValByName(url, "ispoint") === "true" ? true : false;
                $.ajax({
                    type: "GET",
                    cache: false,
                    url: vancl.addQueryString(url, "async", "true"),
                    beforeSend: function () { orderConfirm.setGlobalLoadTip(false); },
                    success: function (data) {
                        if (orderConfirm.valid(data)) {
                            //1. 重新加载特惠区
                            // cart.loadGift($("#gift"));
                            //                            //2. 重新加载清单列表
                            //                            orderInfoPanel.html(data);
                            //                            orderConfirm.excuteOrderInfo();
                            //                            //3. 重新加载清单总计
                            //                            orderConfirm.getOrderSummary();
                            orderConfirm.getOrderInfoAndSummary();
                        }
                    },
                    complete: function () { orderConfirm.setGlobalLoadTip(true); }
                });
            }
        };

        window.setting = setting;
        window.orderConfirm = orderConfirm;
    });
})(jQuery, window);


