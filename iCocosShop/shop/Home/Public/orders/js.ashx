﻿function getCookie(b){var a="";var c=b+"=";if(document.cookie.length>0){offset=document.cookie.indexOf(c);if(offset!=-1){offset+=c.length;end=document.cookie.indexOf(";",offset);if(end==-1){end=document.cookie.length}a=unescape(document.cookie.substring(offset,end))}}return a}function setCookie(a,b,d){var e="";var c=1;if(d!=null){c=d}e=new Date((new Date()).getTime()+c*86400000);e="; expires="+e.toGMTString();document.cookie=a+"="+escape(b)+";path=/"+e}function delCookie(a){var b="";b=new Date((new Date()).getTime()-1);b="; expires="+b.toGMTString();document.cookie=a+"="+escape("")+";path=/"+b};$(function(){var b,c,d,a;b=(function(){window.VANCL=window.VANCL||{};window.VANCL.Global=window.VANCL.Global||{};return window.VANCL.Global}());c=document.location.hash;d=c.indexOf("@");a=c.length;if(document.all&&c.length>-1&&document.title.split("#").length>1){document.title=document.title.split("#")[0]}if(d>-1){document.location.hash=c.substr(d+1)}if(c.substr(0,5)==="#ref="){if(d>-1){a=d}b.ref=c.substring(5,a)}$("body").mousedown(function(e){function k(p){var o=b.hasOwnProperty("ref")?b.ref:null;return p.attr("location")===undefined?o:p.attr("location")}function h(o){return o===undefined||o===""||o===null}function n(p,r){var s=k(r),q,o;if(h(s)===true){return h(p)?null:p}if(p===""){return s}q=p+"|"+s;o=q.split("|");if(o.length>1&&o[0]===o[1]){return s}if(o.length>=10){o.splice(8,o.length-9)}return o.join("|")}function i(p){var o=p.attr("href");if(h(o)===true){return null}o=o.replace(" ","");if(o.indexOf("javascript")>-1){return null}if(o.indexOf("#")>-1&&p.attr("target")===undefined){return null}return o}function f(o){if(o===undefined){return false}if(o===""){return true}if(o.indexOf("_")===-1&&o.indexOf("-")===-1){return false}return true}function j(r,u){var o="",t=r,p,q,s;p=r.lastIndexOf("#");q=r.indexOf("@");if(p>-1){t=r.substr(0,p);if(q===-1){q=p}o="@"+r.substr(q+1)}if(r.indexOf("vjia.com")===-1){return t+"#ref="+u+o}if(r.indexOf(u)>-1){return r}s=r.indexOf("?")===-1?"?":"&";return t+s+"ref="+u}var m,l,g;m=$(e.target).closest("a");if(m.length===0){return}l=m.attr("rel");g=i(m);if(g===null){return}if(h(l)&&m.hasClass("track")){l=m.attr("name")}if(f(l)===false){return}l=n(l,m);if(l){m.attr("href",j(g,l))}})});(function(a){a.fn.hoverIntent=function(i,j){var b={sensitivity:7,interval:100,timeout:0};b=a.extend(b,j?{over:i,out:j}:i);var d,e,l,m;var n=function(f){d=f.pageX;e=f.pageY};var c=function(f,g){g.hoverIntent_t=clearTimeout(g.hoverIntent_t);if((Math.abs(l-d)+Math.abs(m-e))<b.sensitivity){a(g).unbind("mousemove",n);g.hoverIntent_s=1;return b.over.apply(g,[f])}else{l=d;m=e;g.hoverIntent_t=setTimeout(function(){c(f,g)},b.interval)}};var h=function(f,g){g.hoverIntent_t=clearTimeout(g.hoverIntent_t);g.hoverIntent_s=0;return b.out.apply(g,[f])};var k=function(f){var q=(f.type=="mouseover"?f.fromElement:f.toElement)||f.relatedTarget;while(q&&q!=this){try{q=q.parentNode}catch(f){q=this}}if(q==this){return false}var g=jQuery.extend({},f);var o=this;if(o.hoverIntent_t){o.hoverIntent_t=clearTimeout(o.hoverIntent_t)}if(f.type=="mouseover"){l=g.pageX;m=g.pageY;a(o).bind("mousemove",n);if(o.hoverIntent_s!=1){o.hoverIntent_t=setTimeout(function(){c(g,o)},b.interval)}}else{a(o).unbind("mousemove",n);if(o.hoverIntent_s==1){o.hoverIntent_t=setTimeout(function(){h(g,o)},b.timeout)}}};return this.mouseover(k).mouseout(k)}})(jQuery);function setLoginInfo(){if(hasLogin()){$(window).load(setWelcome)}}function hasLogin(){return getCookie("UserLogin")!=""}function setWelcome(){var a=getCookie("UserLogin");if(a!=""){jQuery.getScript("http://my.vancl.com/user/getusernamebycookie",function(){getUserName=getUserName.sub(10);jQuery("#welcome").html("您好, <a href='http://my.vancl.com' class='top track' name='head-denglu' style='color: rgb(51, 51, 51);'>"+getUserName+"</a> <span style='color: #a10000'><a class='top track' style='color: #a10000'  href='https://login.vancl.com/Login/UserLoginOut.aspx' target='_parent' name='head-tcdl' >退出登录</a>&nbsp;|&nbsp;<a class='track' name='head-ghyh' href=\"javascript:location.href='https://login.vancl.com/login/login.aspx?'+location.href\" style='color: #a10000'>更换用户</a></span>")})}}String.prototype.sub=function(c){var d=/[^\x00-\xff]/g;if(this.replace(d,"mm").length<=c){return this}var b=Math.floor(c/2);for(var a=b;a<this.length;a++){if(this.substr(0,a).replace(d,"mm").length>=c){return this.substr(0,a)+"..."}}return this};function setShoppingCar(){return}function GetPrizeCout(){var k=0;var d=getCookie("noLargessSelected");var h=getCookie("MustHasSKU");if(d!="undefined"&&d!=""){var e=d.split("@");for(var a=0;a<e.length;a++){var c=e[a].split("$");if(c.length>1){var g=c[1].split(",");for(var b=0;b<g.length;b++){var f=g[b].split("|");k+=parseInt(f[1])}}}}if(h!="undefined"&&h!=""){var e=h.split("@");for(var a=0;a<e.length;a++){var c=e[a].split("$");if(c.length>1){var g=c[1].split(",");for(var b=0;b<g.length;b++){k+=1}}}}return k}function getShoppingCookie(a,b){if(document.cookie.length>0){c_start=document.cookie.indexOf(a+"=");if(c_start!=-1){c_start=c_start+a.length+1;c_end=document.cookie.indexOf(";",c_start);if(c_end==-1){c_end=document.cookie.length}value=document.cookie.substring(c_start,c_end);return b?unescape(value):value}}return""}function setShoppingCookie(a,d,c,b){document.cookie=a+"="+(b?escape(d):d)+((c==null)?";":";expires="+c+";")+"path=/;domain=.vancl.com;"};function ClickSourceVancl(){}ClickSourceVancl.prototype.url=location.href;ClickSourceVancl.prototype.refUrl=document.referrer;ClickSourceVancl.prototype.clickwwwname="http://click.vancl.com/";ClickSourceVancl.prototype.redirect=function(b){var a=document.createElement("script");a.src=b;var c=document.getElementsByTagName("script")[0];c.parentNode.insertBefore(a,c)};ClickSourceVancl.prototype.get_param=function(d){var f=location.search.substring(1)||location.hash.substring(1);var c=f.split("&");for(var b=0;b<c.length;b++){var e=c[b].indexOf("=");if(e==-1){continue}var a=c[b].substring(0,e);if(a.toLowerCase()==d.toLowerCase()){var g=c[b].substring(e+1);g=decodeURIComponent(g);return g}}return null};ClickSourceVancl.prototype.getHost=function(d){var a="";if(typeof d=="undefined"||d==null){return a}var c=/.*\:\/\/([^\/]*).*/;var b=d.match(c);if(typeof b!="undefined"&&b!=null){a=b[1]}return a};ClickSourceVancl.prototype.getCookie=function(b){var a="";var c=b+"=";if(document.cookie.length>0){offset=document.cookie.indexOf(c);if(offset!=-1){offset+=c.length;end=document.cookie.indexOf(";",offset);if(end==-1){end=document.cookie.length}a=unescape(document.cookie.substring(offset,end))}}return a};ClickSourceVancl.prototype.setCookie=function(a,b,d){var e="";var c=1;if(d!=null){c=d}e=new Date((new Date()).getTime()+c*86400000);e="; expires="+e.toGMTString();document.cookie=a+"="+escape(b)+";domain=vancl.com;path=/"+e};ClickSourceVancl.prototype.excuteFunction=function(a){try{if(window.location.host.indexOf("vancl.com")<0){return}try{if(window.top==window){a.setCookie("union_frame","0",1)}else{a.setCookie("union_frame","1",1)}}catch(b){a.setCookie("union_frame","1",1)}if(window.document.referrer&&window.document.referrer.indexOf("soso.com")>=0){VanclUnionClick();return}var j=a.get_param("source");if(j!=null&&j!=""){var k=a.get_param("sourcesuninfo");if(k==null){k=""}if(k==""){var g=a.get_param("psId");if(g!=null&&g!=""){k="ad-0-1-"+g+"-0"}var l=a.get_param("srcId");if(l!=null&&l!=""){k="ad-0-3-0"+l+"-1"}}var n=a.getCookie("union_visited");var d;if(n=="1"){d=0}else{a.setCookie("union_visited","1",1);d=1}var c=a.clickwwwname+"websource/websource.aspx?source="+j+"&sourceInfo="+k+"&referer="+encodeURIComponent(a.refUrl)+"&hrefurl="+encodeURIComponent(a.url)+"&isnew="+d;a.redirect(c)}else{var h=a.refUrl;if(h!=null&&h!=""){if(a.getHost(h).indexOf("vancl.com")<0&&a.getHost(h).indexOf("vanclimg.com")<0){var n=a.getCookie("union_visited");var d;if(n=="1"){d=0}else{a.setCookie("union_visited","1",1);d=1}var f=a.clickwwwname+"websource/websourceurl.aspx?SourceUrl="+encodeURIComponent(h)+"&hrefurl="+encodeURIComponent(a.url)+"&isnew="+d;a.redirect(f)}else{var m=a.getCookie("WebSourceTemp");if(m!=""){var i=a.clickwwwname+"websource/websource.aspx";a.redirect(i)}}}}}catch(b){}};var clickSourceVanclObj=new ClickSourceVancl();clickSourceVanclObj.excuteFunction(clickSourceVanclObj);function VanclUnionClick(){var b=location.href;var c=document.referrer;var d=document.createElement("script");d.src="http://click.vancl.com/Default.aspx?landingPage="+encodeURIComponent(b)+"&referrer="+encodeURIComponent(c);d.language="javascript";d.type="text/javascript";var a=document.getElementsByTagName("head")[0];a.appendChild(d)};