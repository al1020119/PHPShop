
////////////////////////////////////////////////////////////////////////////////
//新的采集程序
////////////////////////////////////////////////////////////////////////////////

var VA_GLOBAL = {};
VA_GLOBAL.shopid="";
VA_GLOBAL.pagetype="";
//
VA_GLOBAL.namespace = function(str){
  var arr = str.split("."),o = VA_GLOBAL;
  for (i=(arr[0] == "VA_GLOBAL") ? 1 : 0; i<arr.length; i++) {
    o[arr[i]]=o[arr[i]] || {};
    o=o[arr[i]];
  }
}
//Lang
VA_GLOBAL.namespace("Lang");
//
VA_GLOBAL.Lang.trim = function(s){
  return s.replace(/^\s+|\s+$/g,"");
}
//
VA_GLOBAL.Lang.isEmpty = function(s){
  return /^\s*$/.test(s);
}
//
VA_GLOBAL.Lang.isNone = function(s){
  return ((typeof s == "undefined") || s == null || ((typeof s == "string") && VA_GLOBAL.Lang.trim(s) == "") || s == "undefined");
}
//
VA_GLOBAL.Lang.isNumber = function(s){
  return !isNaN(s);
}
//include lowerValue and upperValue.
VA_GLOBAL.Lang.random = function(lowerValue, upperValue) {
  var choices = upperValue - lowerValue + 1;
  return Math.floor(Math.random() * choices + lowerValue);
}
//return yyyyMMddhhmmssms
VA_GLOBAL.Lang.dateTimeStrWms0 = function(dt){
  try {
    var t = dt.getFullYear();
  }
  catch(ex) {
    dt = new Date();
  }
  var mon = dt.getMonth()+1;
  mon = mon < 10 ? "0"+mon : ""+mon;
  var dd = dt.getDate();
  dd = dd < 10 ? "0"+dd : ""+dd;
  var hh = dt.getHours();
  hh = hh < 10 ? "0"+hh : ""+hh;
  var mm = dt.getMinutes();
  mm = mm < 10 ? "0"+mm : ""+mm;
  var ss = dt.getSeconds();
  ss = ss < 10 ? "0"+ss : ""+ss;
  var ms = dt.getMilliseconds();
  if (ms < 10) ms = "00"+ms;
  else if (ms < 100) ms = "0"+ms;

  return dt.getFullYear()+mon+dd+hh+mm+ss+ms;
}
//length is 32(17+15).
VA_GLOBAL.Lang.timeSeq32 = function(){
  return VA_GLOBAL.Lang.dateTimeStrWms0() + VA_GLOBAL.Lang.random(100000000000000, 999999999999999); //1000000, 9999999
}
//http
VA_GLOBAL.namespace("Http");
VA_GLOBAL.Http={

  isIp: function (host){
    var pattern=/^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/;
    return (pattern.test(host));
  },

  getQueryStringArgs: function (){

    //get query string without the initial ?
    var qs = (location.search.length > 0 ? location.search.substring(1) : "");

    //object to hold data
    var args = {};

    //get individual items
    var items = qs.split("&");
    var item = null,
    name = null,
    value = null;

    //assign each item onto the args object
    for (var i=0; i < items.length; i++){
      item = items[i].split("=");
      if (item.length > 1) {
        try {
          name = decodeURIComponent(item[0]);
          value = decodeURIComponent(item[1]);
          args[name] = value;
        }
        catch (uriex) {}
      }
    }
    
    //get hash string without the initial #
    var hash = (window.location.hash.length > 0 ? window.location.hash.substring(1) : "");
    
    //get individual items
    items = hash.split("&");
    
    //assign each item onto the args object
    for (var i=0; i < items.length; i++){
      item = items[i].split("=");
      if (item.length > 1) {
        try {
          name = decodeURIComponent(item[0]);
          value = decodeURIComponent(item[1]);
          args[name] = value;
        }
        catch (uriex) {}
      }
    }
    
    return args;
  }


};
//Dom
VA_GLOBAL.namespace("Dom");
//
VA_GLOBAL.Dom.loadScriptURL = function(src){
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = src;
  document.body.appendChild(script);
}
//
VA_GLOBAL.Dom.loadImageBeacon = function(src){
  var img = document.createElement("img");
  img.type = "image/png";
  img.src = src;
  img.border = 0;
  img.height = 1;
  img.width = 1;
  document.body.appendChild(img);
}
//Event 相关
VA_GLOBAL.namespace("Event");
VA_GLOBAL.Event={

  getEvent: function(event){
    return event ? event : window.event;
  },

  getTarget: function(event){
    event = event ? event : window.event;
    return event.target || event.srcElement;
  },

  stopPropagation: function(event){
    event = event ? event : window.event;
    if (event.stopPropagation){
      event.stopPropagation();
    } else {
      event.cancelBubble = true;
    }
  },

  preventDefault: function(event){
    event = event ? event : window.event;
    if (event.preventDefault){
      event.preventDefault();
    } else {
      event.returnValue = false;
    }
  },

  addHandler: function(element, type, handler){
    element = typeof element == "string" ? document.getElementById(element) : element;

    if (element.addEventListener){
      element.addEventListener(type, handler, false);
    } else if (element.attachEvent){
      element.attachEvent("on" + type, handler);
    } else {
      element["on" + type] = handler;
    }
  }


};


VA_GLOBAL.namespace("Cookie");
VA_GLOBAL.Cookie = {
    get: function(name) {
        var cookieValue = null;
        var cookies = document.cookie.split('; ');
        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            if (parts != null && parts != "undefined") {
                if (parts[0] === name) {
                    if (parts[1] != null && parts[1] != "undefined") {
                        cookieValue = parts[1];
                    }
                }
            }
        }
        return cookieValue;
    },

    set: function(name, value, expires, path, domain, secure) {
        var cookieText = encodeURIComponent(name) + "=" + encodeURIComponent(value);
        if (expires instanceof Date) {
            cookieText += "; expires=" + expires.toGMTString();
        }

        if (path) {
            cookieText += "; path=" + path;
        }

        if (domain) {
            cookieText += "; domain=" + domain;
        }

        if (secure) {
            cookieText += "; secure";
        }

        document.cookie = cookieText;
    },

    unset: function(name, path, domain, secure) {
        this.set(name, "", new Date(0), path, domain, secure);
    }

};
//
VA_GLOBAL.namespace("SubCookie");
VA_GLOBAL.SubCookie={
  
  get: function (name, subName){
    var subCookies = this.getAll(name);
    if (subCookies){
      return subCookies[subName]; //undefined
    } else {
      return null;
    }
  },
  
  getAll: function(name){
    var cookieName = encodeURIComponent(name) + "=",
    cookieStart = document.cookie.indexOf(cookieName),
    cookieValue = null,
    result = {};
    
    if (cookieStart > -1){
      var cookieEnd = document.cookie.indexOf(";", cookieStart);
      if (cookieEnd == -1){
        cookieEnd = document.cookie.length;
      }
      cookieValue = document.cookie.substring(cookieStart + cookieName.length, cookieEnd);
      
      if (cookieValue.length > 0){
        var subCookies = cookieValue.split("&");
        
        for (var i=0, len=subCookies.length; i < len; i++){
          var parts = subCookies[i].split("=");
          result[decodeURIComponent(parts[0])] = decodeURIComponent(parts[1]);
        }
        
        return result;
      }  
    } 
    
    return result; //null
  },
  
  set: function (name, subName, value, expires, path, domain, secure) {
    
    var subcookies = this.getAll(name) || {};
    subcookies[subName] = value;
    this.setAll(name, subcookies, expires, path, domain, secure);
    
  },
  
  setAll: function(name, subcookies, expires, path, domain, secure){
    
    var cookieText = encodeURIComponent(name) + "=";
    var subcookieParts = new Array();
    
    for (var subName in subcookies){
      if (subName.length > 0 && subcookies.hasOwnProperty(subName)){
        subcookieParts.push(encodeURIComponent(subName) + "=" + encodeURIComponent(subcookies[subName]));
      }
    }
    
    if (subcookieParts.length > 0){
      cookieText += subcookieParts.join("&");
      if (expires instanceof Date) {
        cookieText += "; expires=" + expires.toGMTString();
      }
      
      if (path) {
        cookieText += "; path=" + path;
      }
      
      if (domain) {
        cookieText += "; domain=" + domain;
      }
      
      if (secure) {
        cookieText += "; secure";
      }
    } else {
      cookieText += "; expires=" + (new Date(0)).toGMTString();
    }
    
    document.cookie = cookieText;        
    
  },
  
  unset: function (name, subName, path, domain, secure){
    var subcookies = this.getAll(name);
    if (subcookies){
      delete subcookies[subName];
      this.setAll(name, subcookies, null, path, domain, secure);
    }
  },
  
  unsetAll: function(name, path, domain, secure){
    this.setAll(name, null, new Date(0), path, domain, secure);
  }
  
};





// 4s版本
VA_GLOBAL.namespace("vanew");
VA_GLOBAL.vanew = {

    prepare: function() {
        var begintime = new Date().getTime();
        VA_GLOBAL.new_begintime = begintime;
        VA_GLOBAL.new_requestid = VA_GLOBAL.Lang.timeSeq32();
        var protocol = window.location.protocol.toLowerCase();
        VA_GLOBAL.new_protocol = protocol;
        VA_GLOBAL.new_resolution = window.screen.width + '*' + window.screen.height;
        var desthost = "//vamr.vancl.com:";
        var destport = protocol == "https:" ? 443 : 80;
        VA_GLOBAL.new_server = protocol + desthost + destport;
        var domain = window.location.hostname.toLowerCase();
        VA_GLOBAL.new_domain = domain;
        var isip = VA_GLOBAL.Http.isIp(domain);
        var idx = domain.lastIndexOf(".");
        if (idx > 0)
            idx = domain.lastIndexOf(".", idx - 1);
        var domain1 = isip ? domain : (idx == -1 ? ("." + domain) : domain
				.substring(idx)); // .vancl.com
        VA_GLOBAL.new_domain1 = domain1;
        var uri = window.location.pathname;
        if (VA_GLOBAL.Lang.isEmpty(uri))
            uri = "/";
        VA_GLOBAL.uri = uri;
        var query = window.location.search;
        if (query.length > 0)
            query = query.substring(1);
        VA_GLOBAL.new_query = query;
        var params = VA_GLOBAL.Http.getQueryStringArgs();
        var source = params["source"];
        if (VA_GLOBAL.Lang.isNone(source)) {
            source = null;
        }
        //锚点
        var hash = (window.location.hash.length > 0 ? window.location.hash.substring(1) : "");
        if (VA_GLOBAL.Lang.isNone(hash)) {
            hash = "-";
        }
        VA_GLOBAL.new_source = source;
        VA_GLOBAL.new_hash = hash;
        var referer = document.referrer;
        if (referer == null || (typeof referer == "undefined")
				|| referer == "") {
            VA_GLOBAL.Cookie.unset("va_click", "/", VA_GLOBAL.new_domain1, null);
        } else if (referer.indexOf(".vancl.com") == -1) {
            VA_GLOBAL.Cookie.unset("va_click", "/", VA_GLOBAL.new_domain1, null);
        }
        VA_GLOBAL.new_referer = referer;
        VA_GLOBAL.new_useragent = navigator.userAgent;
        // session
        var sid = VA_GLOBAL.Cookie.get("sid");
        if ((typeof sid == "undefined") || sid == null
				|| sid == "") {
            sid = "-";
        }

        var va_sid = VA_GLOBAL.Cookie.get("va_sid");
        var visitsequence = null;

        if (va_sid != null && va_sid == sid) {
            visitsequence = "g";
        } else {
            if (referer == null || (typeof referer == "undefined")
				|| referer == "") {
                visitsequence = "l";
                VA_GLOBAL.Cookie.unset("va_click", "/", VA_GLOBAL.new_domain1, null);
            } else if (referer.indexOf(".vancl.com") == -1) {
                visitsequence = "l";
                VA_GLOBAL.Cookie.unset("va_click", "/", VA_GLOBAL.new_domain1, null);
            }
            else {
                visitsequence = "g";
            }
            va_sid = sid;
        }


        VA_GLOBAL.new_sid = va_sid;

        VA_GLOBAL.new_visitsequence = visitsequence;
        var a24h = new Date();
        a24h.setTime(begintime + 24 * 60 * 60 * 1000);
        VA_GLOBAL.Cookie.set("va_sid", va_sid, a24h, "/", VA_GLOBAL.new_domain1, null);
        // click
        var clickinfo = VA_GLOBAL.SubCookie.getAll("va_click");
        VA_GLOBAL.new_parentrequestid = (typeof clickinfo["rid"] == "undefined") ? "-"
				: clickinfo["rid"];
        VA_GLOBAL.new_clickid = (typeof clickinfo["cid"] == "undefined") ? "-"
				: clickinfo["cid"];
        VA_GLOBAL.new_trackurl = (typeof clickinfo["turl"] == "undefined") ? "-"
				: decodeURIComponent(clickinfo["turl"]);
        VA_GLOBAL.new_trackname = (typeof clickinfo["tname"] == "undefined") ? "-"
				: clickinfo["tname"];
        VA_GLOBAL.new_tracklabel = VA_GLOBAL.Lang.trim((typeof clickinfo["tlabel"] == "undefined") ? "-"
				: clickinfo["tlabel"]);
        // user
        var userinfo = VA_GLOBAL.SubCookie.getAll("va_visit"); // uid,uvc,ft,lt,tt
        var uid = userinfo["uid"];
        var uservisitcount = userinfo["uvc"];
        if (VA_GLOBAL.Lang.isNone(uid)) { // new user
            uid = VA_GLOBAL.Lang.timeSeq32();
            uservisitcount = 1;
            userinfo["uid"] = uid;
            userinfo["uvc"] = uservisitcount;
            userinfo["ft"] = begintime; // first time
            userinfo["lt"] = begintime; // last time
            userinfo["tt"] = begintime; // this time
        } else if (visitsequence == "l") {
            try {
                uservisitcount = Number(uservisitcount) + 1;
                if (Number(uservisitcount) > 999)
                    uservisitcount = 999;
            } catch (uvcex) {
                uservisitcount = 1;
            }
            userinfo["uvc"] = uservisitcount;
            userinfo["lt"] = userinfo["tt"]; // last time
            userinfo["tt"] = begintime; // this time
        } else {
            try {
                uservisitcount = Number(uservisitcount);
                if (Number(uservisitcount) > 999)
                    uservisitcount = 999;
            } catch (uvcex) {
                uservisitcount = 1;
            }
            userinfo["uvc"] = uservisitcount;
        }
        VA_GLOBAL.new_uid = userinfo["uid"];
        VA_GLOBAL.new_uservisitcount = userinfo["uvc"];
        VA_GLOBAL.new_firsttime = userinfo["ft"];
        VA_GLOBAL.new_lasttime = userinfo["lt"];
        VA_GLOBAL.new_thistime = userinfo["tt"];
        var a1year = new Date();
        a1year.setTime(begintime + 365 * 24 * 60 * 60 * 1000); // one years
        VA_GLOBAL.SubCookie.setAll("va_visit", userinfo, a1year, "/", VA_GLOBAL.new_domain1,
				null);
        // track_sinput
        var insitesearchway = "-";
        if ((typeof track_sinput != "undefined") && track_sinput != null
				&& track_sinput != "") {
            insitesearchway = track_sinput;
        }
        VA_GLOBAL.new_insitesearchway = insitesearchway;

        var pageLab = getPageLab();
        if (pageLab != "") {
            //item页面实验室
            VA_GLOBAL.new_pagelab = pageLab;
        }
        else {
            VA_GLOBAL.new_pagelab = "-";
        }

    },

    request: function() {
        try {
            if (typeof VA_GLOBAL.new_server != "undefined") {
                var referer = VA_GLOBAL.new_referer;
                //引荐需要
                var hash = VA_GLOBAL.new_hash;
                var trackname = VA_GLOBAL.new_trackname;
                var tracklabel = VA_GLOBAL.new_tracklabel;
                var str = VA_GLOBAL.new_server + "/visit.ashx?";
                str += "version=1.2";
                str += "&requestid=" + VA_GLOBAL.new_requestid;
                str += "&parentrequestid=" + VA_GLOBAL.new_parentrequestid;
                str += "&sid=" + VA_GLOBAL.new_sid;
                str += "&uid=" + VA_GLOBAL.new_uid;
                str += "&referer="
						+ (referer == "" ? "-" : encodeURIComponent(referer
								.replace(/[\r\n\t]/g, " ").substring(0, 400)));
                str += "&visitsequence=" + VA_GLOBAL.new_visitsequence;
                str += "&uservisitcount=" + VA_GLOBAL.new_uservisitcount;
                str += "&firsttime=" + VA_GLOBAL.new_firsttime;
                str += "&lasttime=" + VA_GLOBAL.new_lasttime;
                str += "&thistime=" + VA_GLOBAL.new_thistime;
                str += "&insitesearchway=" + VA_GLOBAL.new_insitesearchway;
                str += "&pagelab=" + encodeURIComponent(VA_GLOBAL.new_pagelab);
                str += "&resolution=" + encodeURIComponent(VA_GLOBAL.new_resolution);
                str += "&title=" + encodeURIComponent(document.title);
                str += "&hash=" + (hash == "" ? "-" : encodeURIComponent(hash));
                //str += "&anchor_ref=" + encodeURIComponent(anchor_ref);
                str += "&clickid=" + VA_GLOBAL.new_clickid;
                str += "&trackname="
						+ (trackname == "" ? "-" : encodeURIComponent(trackname
								.replace(/[\r\n\t\'\"]/g, " ")));
                str += "&tracklabel="
						+ (tracklabel == "" ? "-"
								: encodeURIComponent(tracklabel.replace(/[\r\n\t\'\"]/g, " ")));
				str += "&shopid=" + (VA_GLOBAL.shopid == "" ? "-": VA_GLOBAL.shopid);
				str += "&pagetype=" +  (VA_GLOBAL.pagetype == "" ? "-": VA_GLOBAL.pagetype);
                $.getScript(str);
            }
        } catch (ex) {
        }
    },

    loadtime: function() {
        try {
            // send load time
            if (typeof VA_GLOBAL.new_server != "undefined") {
                var rendertime = new Date().getTime() - VA_GLOBAL.new_begintime;
                var referer = VA_GLOBAL.new_referer;
                // send
                var str = VA_GLOBAL.new_server + "/render.ashx?";
                str += "version=1.2";
                str += "&requestid=" + VA_GLOBAL.new_requestid;
                str += "&parentrequestid=" + VA_GLOBAL.new_parentrequestid;
                str += "&sid=" + VA_GLOBAL.new_sid;
                str += "&uid=" + VA_GLOBAL.new_uid;
                str += "&rendertime=" + rendertime;
                str += "&referer="
						+ (referer == "" ? "-" : encodeURIComponent(referer
								.replace(/[\r\n\t]/g, " ").substring(0, 400)));
                $.getScript(str);
            }
        } catch (ex) {
        }
    },

    listenclick: function() {
        try {
            // click info gather
            VA_GLOBAL.Event.addHandler(document, "mousedown", function(event) { // click
                var node = VA_GLOBAL.Event.getTarget(event);
                if (node.nodeType == 1) {// element
                    var found = VA_GLOBAL.vanew.elementclicked(node);
                    if (found == false) {
                        VA_GLOBAL.vanew.elementclicked(node.parentNode);
                    }
                } // end if (node.nodeType == 1)
            });
        } catch (ex) {
        }
    },

    elementclicked: function(node) {
        if (node.nodeType != 1) {
            return false;
        }
        var istrack = false;
        var clsName = node.className;
        if (clsName == null || (typeof clsName == "undefined")) {
            clsName = "";
        }
        clsName = clsName.toLowerCase();
        var cls = clsName.split(" ");
        for (var i = 0; i < cls.length; i++) {
            if (cls[i] == "track") {
                istrack = true;
                break;
            }
        }
        var trackname = null;
        // is track
        if (istrack) {
            try {
                trackname = node.name;
            }
            catch (ex) { }
        }
        if (istrack == false || (typeof trackname == "undefined")
				|| trackname == null || trackname == "") {
            trackname = "-";
        }
        var nodeName = node.nodeName.toLowerCase();
        var tracklabel = null;
        var trackurl = null;
        // is a
        if (nodeName == "a") {
            try {
                tracklabel = node.innerHTML;
                var hr = node.href;
                if ((typeof hr != "undefined") && hr != null) {
                    if (/^https?:\/\/./i.test(hr)) {
                        trackurl = hr;
                    } else if (/^\/\/./i.test(hr)) {
                        trackurl = hr;
                    } else if (/^\/./i.test(hr)) {
                        trackurl = hr;
                    }
                }
                trackurl = encodeURIComponent(trackurl);
            } catch (ex) {
            }
        } // end if (nodeName == "a")
        else {
            try {
                tracklabel = node.value;
                if ((typeof tracklabel == "undefined") || tracklabel == null) {
                    tracklabel = node.title;
                    if ((typeof tracklabel == "undefined") || tracklabel == null) {
                        tracklabel = node.data;
                    }
                }
            } catch (ex) {
            }
        }
        if ((typeof tracklabel == "undefined") || tracklabel == null) {
            tracklabel = "-";
        }
        try {
            if (typeof tracklabel != "string")
                tracklabel = "";
            else
                tracklabel = tracklabel.replace(/[\r\n\t\'\"]/g, " ");
        } catch (ex) {
        }
        tracklabel = VA_GLOBAL.Lang.trim(tracklabel);
        if (tracklabel.length > 100) {
            tracklabel = encodeURIComponent(tracklabel.substring(0, 100));
        }
        else {
            tracklabel = encodeURIComponent(tracklabel);
        }

        var clickid = VA_GLOBAL.Lang.timeSeq32();
        if (istrack) {
            VA_GLOBAL.vanew.recordtrackclick(clickid, trackname, trackurl, tracklabel);
        }
        if (nodeName == "a") {
            VA_GLOBAL.vanew.recordaclick(clickid, trackname, trackurl, tracklabel);
        }
        //either track or a will stop finding
        return istrack || nodeName == "a";
    },

    recordaclick: function(clickid, trackname, trackurl, tracklabel) {
        if (trackname == null || (typeof trackname == "undefined")
				|| trackname == "") {
            trackname = "-";
        }
        if (tracklabel == null || (typeof tracklabel == "undefined")
				|| tracklabel == "") {
            tracklabel = "-";
        }
        if (trackurl == null || (typeof trackurl == "undefined")
				|| trackurl == "") {
            trackurl = "-";
        }
        // pass track info to next page
        var trackinfo = {};
        trackinfo["rid"] = VA_GLOBAL.new_requestid;
        trackinfo["cid"] = clickid;
        trackinfo["turl"] = trackurl;
        trackinfo["tname"] = trackname;
        trackinfo["tlabel"] = tracklabel;
        var a1min = new Date();
        a1min.setTime(new Date().getTime() + 60 * 1000);
        VA_GLOBAL.SubCookie.setAll("va_click", trackinfo, a1min, "/",
				VA_GLOBAL.new_domain1, null);
    },

    recordtrackclick: function(clickid, trackname, trackurl, tracklabel) {
        if (trackname == null || (typeof trackname == "undefined")
				|| trackname == "") {
            trackname = "-";
        }
        if (tracklabel == null || (typeof tracklabel == "undefined")
				|| tracklabel == "") {
            tracklabel = "-";
        }
        if (trackurl == null || (typeof trackurl == "undefined")
				|| trackurl == "") {
            trackurl = "-";
        }
        // send
        if (typeof VA_GLOBAL.new_server != "undefined") {
            var referer = VA_GLOBAL.new_referer;
            var str = VA_GLOBAL.new_server + "/click.ashx?";
            str += "version=1.2";
            str += "&clickid=" + clickid;
            str += "&trackurl=" + (trackurl == "" ? "-" : encodeURIComponent(trackurl
					.replace(/[\r\n\t]/g, " ").substring(0, 400)));
            str += "&trackname=" + (trackname == "" ? "-" : encodeURIComponent(trackname
					.replace(/[\r\n\t]/g, " ").substring(0, 400)));
            str += "&tracklabel=" + (tracklabel == "" ? "-" : encodeURIComponent(tracklabel
					.replace(/[\r\n\t]/g, " ").substring(0, 400)));
            str += "&requestid=" + VA_GLOBAL.new_requestid;
            str += "&sid=" + VA_GLOBAL.new_sid;
            str += "&uid=" + VA_GLOBAL.new_uid;
            str += "&referer="
					+ (referer == "" ? "-" : encodeURIComponent(referer
							.replace(/[\r\n\t]/g, " ").substring(0, 400)));
			str += "&shopid=" + (VA_GLOBAL.shopid == "" ? "-": VA_GLOBAL.shopid);
			str += "&pagetype=" +  (VA_GLOBAL.pagetype == "" ? "-": VA_GLOBAL.pagetype);
            $.getScript(str);
        }
    },


    ////////////////////////////////////////////////////////////////////////////////
    //send visit info
    ////////////////////////////////////////////////////////////////////////////////
    send: function() {
        try {
            //4s版本
            if (typeof VA_GLOBAL.v4sreadyed != "undefined")
                return;
            VA_GLOBAL.v4sreadyed = "1";
            VA_GLOBAL.vanew.prepare();
            VA_GLOBAL.vanew.request();
        }
        catch (ex) { }
    },


    ////////////////////////////////////////////////////////////////////////////////
    //loaded
    ////////////////////////////////////////////////////////////////////////////////
    loaded: function() {
        try {

            //4s版本
            if (typeof VA_GLOBAL.v4sloaded != "undefined")
                return;
            VA_GLOBAL.v4sloaded = "1";
            VA_GLOBAL.vanew.loadtime();
            VA_GLOBAL.vanew.listenclick();

        }
        catch (ex) { }
    }

};




////////////////////////////////////////////////////////////////////////////////
//原有的采集程序，目前暂时保留，以后会撤销，用后面新的采集程序替换
////////////////////////////////////////////////////////////////////////////////
/* Vancl tracking system*/

var PAGELAB_PATTERN = /^(PageLab_PLE[0-9]{4})=([^;]*)$/;
var weblog_loadtime = new Date();

try {
  $(document).ready(
    function() {
      //4s版本
      VA_GLOBAL.vanew.send();
    
    });
} catch (err) { }

function getPageLab() {
  var returnValue = "";
  var str = document.cookie.split(";");
  for (var i = 0; i < str.length; i++) {
    if (PAGELAB_PATTERN.test(trim(str[i]))) {
      returnValue += trim(str[i].split('=')[1]) + ",";
    }
  }
  returnValue = (returnValue.length > 0) ? returnValue.substr(0, returnValue.length - 1) : "";
  return returnValue;
}

function trim(str) {
  for (var i = 0; i < str.length && str.charAt(i) == " "; i++);
  for (var j = str.length; j > 0 && str.charAt(j - 1) == " "; j--);
  if (i > j) return "";
  return str.substring(i, j);
}

try {
  $(window).load(
    function() {
      //4s版本
      VA_GLOBAL.vanew.loaded();    
    });
} catch (err) { }


