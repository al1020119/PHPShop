﻿var PAGELAB_PATTERN=/^(PageLab_PLE[0-9]{4})=([^;]*)$/;$(document).ready(function(){$(document.body).mousedown(function(a){a=a?a.target:window.event.srcElement;if(a.className.toUpperCase().indexOf("TRACK")>-1){trackurl(a.name)}else{var b=a.parentNode;if(b.className.toUpperCase().indexOf("TRACK")>-1){trackurl(b.name)}}})});function trackurl(a){if(a==null||a==""){return}var c=[];var b=getGatherCookie();c.push(document.location.protocol);c.push("//vamr.vancl.com/track.aspx?ref=");c.push(escape(window.document.referrer));c.push("&areaid=");c.push(a);if(b!=""){c.push("&gather_cookies="+b)}var d=c.join("");$("#weblog_track").remove();$("body").append('<img id="weblog_track" src='+d+' style="display:none;"/>')}function getGatherCookie(){var b="";var c=document.cookie.split(";");for(var a=0;a<c.length;a++){if(PAGELAB_PATTERN.test(trim(c[a]))){b+=trim(c[a].split("=")[1])+","}}b=(b.length>0)?b.substr(0,b.length-1):"";return b}function trim(c){for(var a=0;a<c.length&&c.charAt(a)==" ";a++){}for(var b=c.length;b>0&&c.charAt(b-1)==" ";b--){}if(a>b){return""}return c.substring(a,b)};function getCookie(b){var a="";var c=b+"=";if(document.cookie.length>0){offset=document.cookie.indexOf(c);if(offset!=-1){offset+=c.length;end=document.cookie.indexOf(";",offset);if(end==-1){end=document.cookie.length}a=unescape(document.cookie.substring(offset,end))}}return a}function setCookie(a,b,d){var e="";var c=1;if(d!=null){c=d}e=new Date((new Date()).getTime()+c*86400000);e="; expires="+e.toGMTString();document.cookie=a+"="+escape(b)+";path=/"+e}function delCookie(a){var b="";b=new Date((new Date()).getTime()-1);b="; expires="+b.toGMTString();document.cookie=a+"="+escape("")+";path=/"+b};