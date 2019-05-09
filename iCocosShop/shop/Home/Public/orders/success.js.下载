(function ($) {
    //提交表单数据
    $(".PostOrderData").click(function () {
        $("#myOrderList").submit();
    });
    //弹出层在中央
    $.fn.center = function () {
        var top = ($(window).height() - this.height()) / 2;
        var left = ($(window).width() - this.width()) / 2;
        var scrollTop = $(document).scrollTop();
        var scrollLeft = $(document).scrollLeft();
        return this.css({ position: 'absolute', 'top': top + scrollTop, left: left + scrollLeft }).show();
    };

    function SubStrName(name, indexEnd) {
        return name.substring(0, indexEnd);
    }

    var payUrl = "https://pay.vancl.com";

    $(function () {
        //select框IE6下 z-indexbug.
        if ($.fn.bgiframe) {
            $("#daifu_tipsinfo").bgiframe();
        }

        var orderConfirm = window.orderConfirm;
        //推荐商品展示
        var productIDs = $(".order").attr("data-product-codes");
        var recommendList = $(".otherBuyprod");

        $.ajax({
            async: false,
            url: "http://recom-s.vancl.com/Product/GetCurrentRecommendProducts",
            type: "GET",
            dataType: 'jsonp',
            jsonp: 'callback',
            data: null,
            timeout: 5000,
            cache:false,
            contentType: "application/json;utf-8",
            success: function (data) {
                if (data != null && data != undefined && data.length > 0) {
                    var productListHtml = "";
                    var ModelRows = data.length > 5 ? 5 : data.length;
                    for (var i = 0; i < ModelRows; i++) {
                        var productName = data[i].ProductName;
                        var poductInfoUrl = data[i].ItemUrl;
                        var productPotoUrl = "http://p1.vanclimg.com/150/product/" + data[i].ProductCode.substring(0, 1) + "/" + data[i].ProductCode.substring(1, 2) + "/" + data[i].ProductCode.substring(2, 3) + "/" + data[i].ProductCode + "/" + "mid/" + data[i].Photos[0].FileName;
                        var productMarketPrice = data[i].SPrice;
                        var productSellPrice = data[i].SPrice;
                        productListHtml += '<li>'
                                          + '  <a target="_blank" href="' + poductInfoUrl + '" title="' + productName + '">'
                                          + '      <img src="' + productPotoUrl + '" alt="' + productName + '" width="150"/>'
                                          + '  </a>'
                                          + '  <a class="name" href="' + poductInfoUrl + '"  title="' + productName + '">' + SubStrName(productName, 24) + '</a>'
                                          + '  <p>'
                                          + '  <span class="Rsallprice Infoblock">售价：￥' + productSellPrice + '</span></p>'
                                        + '</li>';
                    }
                    recommendList.html(productListHtml).show();
                } else {
                    recommendList.hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            }
        });


//        var paramJson = "[{ProductCodes:\"" + productIDs + "\",Position:\"" + "rp_order_p1" + "\",Rows:\"" + "5" + "\",ExtraField:\"" + "ListImage" + "\",Remark:\"" + "NeedExclude" + "\"}]";
//        $.getJSON("https://app-recm.vancl.com/RecmService/GetProductByPosition?jsoncallback=?",
//        { strJson: paramJson },
//        function (data) {
//            if (data.Success) {
//                var productListHtml = "";
//                $.each(data.Items, function (i, item) {
//                    var productName = item.ProductName;
//                    var poductInfoUrl = item.ProductUrl + "?ref=" + item.Ref;
//                    var productPotoUrl = item.ImageUrl.replace("http:", "").replace("/small/", "/mid/").replace("/product/", "/150/product/");
//                    var productMarketPrice = item.MarketPrice;
//                    var productSellPrice = item.Price;

//                    productListHtml += '<li>'
//                                          + '  <a target="_blank" href="' + poductInfoUrl + '" title="' + productName + '">'
//                                          + '      <img src="' + productPotoUrl + '" alt="' + productName + '" width="150"/>'
//                                          + '  </a>'
//                                          + '  <a class="name" href="' + poductInfoUrl + '"  title="' + productName + '">' + SubStrName(productName, 24) + '</a>'
//                                          + '  <p><span class="gray999">市场价：<s>￥' + productMarketPrice + '</s></span>'
//                                          + '  <span class="Rsallprice Infoblock">售价：￥' + productSellPrice + '</span></p>'
//                                        + '</li>';
//                });
//                recommendList.html(productListHtml).show();
//            }
//            else {
//                recommendList.hide();
//            }
//        });
        // Vjia广告 去除vjia底部广告 comment by fuweibo 20140623
        /*var myDate = new Date();
        var currentUrlHost = window.location.host;
        var vPluseJSUrl = "https://js.vanclimg.com/vjiaAd/shopping.js";
        if (currentUrlHost.indexOf("demo") > -1) {
        vPluseJSUrl = "http://demojs.vanclimg.com/vjiaAd/shopping.js";
        }

        $.getScript(vPluseJSUrl + "?i=" + myDate.getTime(),
        function () {
        if (vjiaAd.imageUrl != null && vjiaAd.imageUrl != "") {
        var imageUrl = vjiaAd.imageUrl;
        var httpIndex = imageUrl.indexOf("//");
        if (httpIndex == -1) {
        imageUrl = "https:" + imageUrl;
        }
        else {
        imageUrl = imageUrl.substring(httpIndex, imageUrl.length);
        }
                
        //var vplus = "<a href='" + vjiaAd.imageLink + "?source=" + vjiaAd.source + "' class=\"track\" target=\"_blank\"name='" + vjiaAd.track + "'><img style=\"width:980px;height:60px;\" alt=\"V+\" src='" + imageUrl + "' /></a>";
        //$("#VPluse").append(vplus);
        }
        });*/

        var rootDom = $("body");


        //点击现在付款按钮
        rootDom.delegate("a[name='sp_cart_complete_pay_now']", "click", function () {
            var the = $(this);

            if (orderConfirm.required($("#paySelect-list ul").find("input"))) {
                $("#span-success-online-payment-tip").hide();
                $("#payment_reason").show();
                $("div.Online_payment").center(); //显示弹出层
                $("div.PayPopup_bar").hide(); //隐藏找人代付层
                $("a[name='sp_cart_complete_pay_now']").hide();
                $("#paynow").hide();
                //下单后回写支付方式
                orderConfirm.updateOrder($("#payment-writeback-form"));
                var orderId = $("#orderId").val();
                var identifier = $("#paySelect-list").find("input[type='radio'][name='identifier']:checked").val().split('$');
                var paymentTypeId = identifier[0];
                var paymentBank = identifier[2];

                //下单后支付方式变更记录
                if ($("#orderPaymentTypeId").val() != "-1") {
                    if ($("#orderPaymentTypeId").val() != paymentTypeId || $("#orderBankValue").val() != paymentBank) {
                        orderConfirm.setPaymentChangeLog($("#payment-writeback-form").serialize());
                    }
                }
                else {
                    $("#orderPaymentTypeId").val(paymentTypeId);
                    $("#orderBankValue").val(paymentBank);
                }
                var url = "";
                if ($("#orderUrlSource").val() == "Om")//om
                {
                    url = (paymentTypeId == "16") ? payUrl + "/shopping_pay.aspx?orderid=" + orderId + "&paymenttypeid=" + paymentTypeId + "&paymentbank=" + paymentBank + "&paymoney=" + $("#omPrice").val() + "&t=modify" : payUrl + "/shopping_pay.aspx?orderid=" + orderId + "&paymenttypeid=" + paymentTypeId + "&paymoney=" + $("#omPrice").val() + "&paymentbank=&t=modify";
                }
                else {
                    url = (paymentTypeId == "16") ? payUrl + "/shopping_pay.aspx?orderid=" + orderId + "&paymenttypeid=" + paymentTypeId + "&paymentbank=" + paymentBank + "&t=shop" : payUrl + "/shopping_pay.aspx?orderid=" + orderId + "&paymenttypeid=" + paymentTypeId + "&paymentbank=&t=shop";
                }
                $("#repay").attr("href", url);
                window.open(url);
            }
            else {
                $("#span-success-online-payment-tip").show();
                return false;
            }
        });
        //点击银行图片图片
        rootDom.delegate("#paySelect-list ul li img", "click", function () {
            var the = $(this);
            var radiobutton = the.prev();
            if (radiobutton.attr("disabled") == "disabled") {
                return;
            }
            the.prev().click();
            if ($(".Payingbank").is(":visible")) {
                $(".Bftred14").html(the.prev().val().split('$')[1]);
                $("#payment-writeback-form-now #identifier").val(the.prev().val());
            }
        });

        //点击单选按钮
        rootDom.delegate("#paySelect-list ul li input", "click", function () {
            var the = $(this);
            if ($(".Payingbank").is(":visible")) {
                $(".Bftred14").html(the.val().split('$')[1]);
                $("#payment-writeback-form-now #identifier").val(the.val());
            }
        });

        //点击现在支付按钮
        rootDom.delegate("#paynow", "click", function () {
            var the = $(this);
            $("#span-success-online-payment-tip").hide();
            $("#payment_reason").show();
            $("div.Online_payment").center(); //显示弹出层
            $("div.PayPopup_bar").hide(); //隐藏找人代付层
            $("a[name='sp_cart_complete_pay_now']").hide();
            $("#paynow").hide();

            //下单后回写支付方式
            orderConfirm.updateOrder($("#payment-writeback-form-now"));
            var orderId = $("#orderId").val();
            var identifier = $("#payment-writeback-form-now #identifier").val().split('$');
            var paymentTypeId = identifier[0];
            var paymentBank = identifier[2];
            //下单后支付方式变更记录
            if ($("#orderPaymentTypeId").val() != "-1") {
                if ($("#orderPaymentTypeId").val() != paymentTypeId || $("#orderBankValue").val() != paymentBank) {
                    orderConfirm.setPaymentChangeLog($("#payment-writeback-form").serialize());
                }
            }
            else {
                $("#orderPaymentTypeId").val(paymentTypeId);
                $("#orderBankValue").val(paymentBank);
            }

            var url = (paymentTypeId == "16") ? payUrl + "/shopping_pay.aspx?orderid=" + orderId + "&paymenttypeid=" + paymentTypeId + "&paymentbank=" + paymentBank + "&t=shop" : payUrl + "/shopping_pay.aspx?orderid=" + orderId + "&paymenttypeid=" + paymentTypeId + "&paymentbank=&t=shop";
            $("#repay").attr("href", url);
            window.open(url);
        });

        //点击单选按钮后隐藏错误提示
        rootDom.delegate("#paySelect-list ul li input", "click", function () {
            $("#span-success-online-payment-tip").hide();
        });

        //点击图片选中相应单选按钮
        rootDom.delegate("#paySelect-list ul li img", "click", function () {
            var the = $(this);
            var radiobutton = the.prev();
            if (radiobutton.attr("disabled") == "disabled") {
                return;
            }
            the.prev().attr("checked", "checked");
        });

        //重新支付
        rootDom.delegate("#repay", "click", function () {
            orderConfirm.updateOrder($("#payment-writeback-form"));
        });

        //关闭支付之后弹出框
        rootDom.delegate("a.whiteff ,#setPageUrl", "click", function () {
            var the = $(this);
            $("div.Online_payment").hide();
            $("a[name='sp_cart_complete_pay_now']").show();
            if ($(".Payingbank").is(":visible")) {
                $("#paynow").show();
            }
            if (the.is("#setPageUrl")) {
                var reason = $("#maktype option:selected").val();
                $("#3330").val(reason);
                $("#makfrom").submit();
            }
        });

        //提交支付失败原因
        rootDom.delegate("#paymentReasonSubmit", "click", function () {
            var reason = $("#maktype option:selected").val();
            $("#3330").val(reason);
            $("#makfrom").submit();
            $("div.Online_payment").hide();
            $("a[name='sp_cart_complete_pay_now']").show();
            if ($(".Payingbank").is(":visible")) {
                $("#paynow").show();
            }
        });

        //弹出找人代付框
        rootDom.delegate("#daifuLink,#someonepaid", "click", function () {
            $("div.Online_payment").hide();
            $("div.PayPopup_bar").center();
            $("a[name='sp_cart_complete_pay_now']").show();
            if ($(".Payingbank").is(":visible")) {
                $("#paynow").show();
            }
        });

        //关闭找人代付框
        rootDom.delegate("a.whitef", "click", function () {
            $("div.PayPopup_bar").hide();
            $("a[name='sp_cart_complete_pay_now']").show();
            if ($(".Payingbank").is(":visible")) {
                $("#paynow").show();
            }
        });

        //支付失败原因切换
        rootDom.delegate("#maktype", "change", function () {
            var val = $("#maktype option:selected").val();
            var button = "";
            var p = "";
            var html = "";
            var blank10 = "<span class=\"blank10\"/>";

            switch (val) {
                case "21657":
                    html = blank10;
                    $("#showTips").show();
                    $("#paymentReasonSubmit").show();
                    break;
                case "21660":
                    p = "<p class=\"payment_reatips\">请刷新银行支付页面，或尝试重新支付。如问题依然存在建议使用IE浏览器。</p>";
                    html = p + button;
                    $("#showTips").show();
                    $("#paymentReasonSubmit").show();
                    break;
                case "21663":
                    p = "<p class=\"payment_reatips\">建议使用IE浏览器，登陆“我的凡客”，在“我的订单”，完成您的订单支付。</p>";
                    html = p + button;
                    $("#ulfailed").show();
                    $("#showTips").show();
                    $("#paymentReasonSubmit").show();
                    break;
                case "21666":
                    //   p = "<p class=\"payment_reatips\">您可以在修改订单中<a id=\"setPageUrl\" class=\"reda10\" href=\"javascript:;\"  >修改支付方式</a>或者<a class=\"reda10\" id=\"payByOther\" href=\"javascript:;\">找人代付</a>。</p>";
                    p = "<p class=\"payment_reatips\">您可以<a id=\"setPageUrl\" class=\"reda10\" href=\"javascript:;\"  >修改支付方式</a>、尝试小额<a class=\"reda10\" target=\"_blank\"  href=\"http://pay.vancl.com/Pay_Check.aspx?orderid=" + $("#orderId").val() + "\">多次支付</a>、或<a class=\"reda10\" id=\"payByOther\"  href=\"javascript:;\">找人代付</a>。</p>";


                    html = p;
                    $("#ulfailed").show();
                    $("#showTips").show();
                    $("#paymentReasonSubmit").hide();
                    break;
                case "21669":
                    p = "<p class=\"payment_reatips\">您可以在修改订单中<a id=\"setPageUrl\" class=\"reda10\" >修改支付方式</a>或者<a class=\"reda10\" id=\"payByOther\" href=\"javascript:;\">找人代付</a>。也可以到银行开通支付功能，按浏览器提示安装插件。</p>";
                    html = p;
                    $("#showTips").show();
                    $("#paymentReasonSubmit").hide();
                    break;
                case "21672":
                    var text = "<textarea name=\"textarea\" class=\"payment_inputtext\" id=\"textareaError\" rows=\"5\" cols=\"45\"  >请您输入具体原因</textarea>";
                    html = blank10 + text + blank10 + button;
                    $("#ulfailed").show();
                    $("#showTips").show();
                    $("#paymentReasonSubmit").show();
                    break;
                default:
                    html = blank10;
                    $("#showTips").hide();
                    $("#paymentReasonSubmit").hide();
                    $("#ulfailed").show();
            }
            $("#showTips").html(html);
        });

        //复制找人代付链接
        rootDom.delegate("#copyurl", "click", function () {
            var txt = $("#textfield").val();

            if (window.clipboardData) {
                window.clipboardData.clearData();
                window.clipboardData.setData("Text", txt);
            } else if (navigator.userAgent.indexOf("Opera") != -1) {
                window.location = txt;
            } else if (window.netscape) {
                try {
                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                } catch (e) {
                    alert("复制可能被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");
                }
                var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
                if (!clip) {
                    return;
                }
                var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
                if (!trans) {
                    return;
                }
                trans.addDataFlavor('text/unicode');
                var str = new Object();
                var len = new Object();
                var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
                var copytext = txt;
                str.data = copytext;
                trans.setTransferData("text/unicode", str, copytext.length * 2);
                var clipid = Components.interfaces.nsIClipboard;
                if (!clip) {
                    return false;
                }
                clip.setData(trans, null, clipid.kGlobalClipboard);
            }
        });

        //弹窗中支付失败理由切换时找人代付链接
        rootDom.delegate("#payByOther", "click", function () {
            var reason = $("#maktype option:selected").val();
            $("#3330").val(reason);
            $("#makfrom").submit();
            $("div.Online_payment").hide();
            $("div.PayPopup_bar").center();
        });

        //弹窗中支付失败选其他时,填写内容框文字清空
        rootDom.delegate("#textareaError", "click", function () {
            if ($("#textareaError").val() == "请您输入具体原因") {
                $("#textareaError").val("");
                $("#textareaError").focus();
            }
        });

        //弹窗中支付失败选其他时,填写内容框
        rootDom.delegate("#textareaError", "blur keyup", function () {
            var length = $("#textareaError").val().length;
            var word = $("#textareaError").val();
            if (length > 50) {
                word = word.substring(0, 50);
                $("#textareaError").val(word);
                $("#textareaError").focus();
            }
            $("#textbox21672").val(word);
        });
        //找人代付提示
        $("#someonepaid").hover(
            function () {
                $(".daifu_tipsinfo").show();
            },
            function () {
                $(".daifu_tipsinfo").hide();
            }
        );
        //常用支付方式和全部支付方式切换
        rootDom.delegate("#menu_one1", "click", function () {
            $("#menu_one2").removeClass("hover");
            $("#menu_one1").attr("class", "hover");
            $("#content_one1").show();
            $("#content_one2").hide();
            showMPAlipay();
        });
        rootDom.delegate("#menu_one2", "click", function () {
            $("#menu_one1").removeClass("hover");
            $("#menu_one2").attr("class", "hover");
            $("#content_one2").show();
            $("#content_one1").hide();
            showMPAlipay();
        });
        var arr = $("#formCodesList").val().split("|");
        for (var i = 0; i < arr.length; i++) {
            //VA_GLOBAL.va.track(null, "va_oc", arr[i]);
            var clickid = VA_GLOBAL.Lang.timeSeq32();
            VA_GLOBAL.vanew.recordtrackclick(clickid, "va_oc", null, arr[i]);

        }

        //OM留言相关 
        rootDom.delegate("#btn-message", "click", function () {
            if ($("#div-message").is(":visible")) {
            }
            else {
                $("#div-message").show();
            }
        });
        rootDom.delegate("#a-message-close,#a-message-closeimg", "click", function () {
            $("#div-message").hide();
        });
        rootDom.delegate("#txt-message-content", "click", function () {
            var val = $("#txt-message-content").val();
            if (val == "请留下您的宝贵的意见和建议") {
                $("#txt-message-content").val("");
            }
        });
        rootDom.delegate("#txt-message-content", "keyup", function () {
            var len = $("#txt-message-content").val().length;
            var result = 1000 - len;
            $("#span-message-length").html(result);
            if (len > 0) {
                $("#span-message-tip").html("");
            }
            else {
                $("#span-message-tip").html("请填写意见内容");
            }
        });

        rootDom.delegate("#btn-message-submit", "click", function () {
            var type = $("input[name='manyi']:checked").val();
            var text = "";
            if ($("#txt-message-content").val() == "请留下您的宝贵的意见和建议" || $("#txt-message-content").val() == "") {
                text = "";
                $("#span-message-tip").html("请填写意见内容");
                return;
            }
            else if ($("#txt-message-content").val().length > 1000) {
                $("#span-message-tip").html("留言内容不能超过1000个字");
            }
            else {
                text = $("#txt-message-content").val();
            }
            var title = "修改订单建议" + $("#message-orderid").val() + type;
            text = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

            $.ajax({
                url: "/order/SendEmail",
                cache: false,
                type: "POST",
                data: { "mailSubject": title, "mailBody": text },
                success: function (result) {

                },
                error: function (result, status) {

                }
            });
            $("#div-message").hide();
        });

        rootDom.delegate("input[name='identifier']", "change", showMPAlipay);
        showMPAlipay();
    });

    function showMPAlipay() {
        var checkedPaytype = $("input[name='identifier']:checked");
        $("input[name='wx_identifier']").attr("checked", false);
        if (checkedPaytype.val().indexOf("MPALIPAY") > -1 && checkedPaytype.is(":visible")) {
            $("a[name='sp_cart_complete_pay_now']").hide();
            var orderId = $("#orderId").val();
            var identifier = checkedPaytype.val().split('$');
            var paymentTypeId = identifier[0];
            var paymentBank = identifier[2];
            var url = "";
            if ($("#orderUrlSource").val() == "Om")//om
            {
                url = payUrl + "/shopping_pay.aspx?orderid=" + orderId + "&paymenttypeid=" + paymentTypeId + "&paymentbank=" + paymentBank + "&paymoney=" + $("#omPrice").val() + "&t=modify";
            }
            else {
                url = payUrl + "/shopping_pay.aspx?orderid=" + orderId + "&paymenttypeid=" + paymentTypeId + "&paymentbank=" + paymentBank + "&t=shop";
            }
            $("#barcode_iframe").attr("src", url + "&nested=1");
            $('#barcode_pay').show();
        } else {
            $("a[name='sp_cart_complete_pay_now']").show();
            $('#barcode_pay').hide();
            $("#barcode_iframe").attr("src", "");
        }
    }
})(jQuery);

