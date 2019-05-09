/* Vancl tracking system : add mousedown event to body*/

var PAGELAB_PATTERN = /^(PageLab_PLE[0-9]{4})=([^;]*)$/;

$(document).ready(function() { 
	$(document.body).mousedown(function(e) {
		e = e ? e.target : window.event.srcElement;
		if (e.className.toUpperCase().indexOf("TRACK") > -1) {
			trackurl(e.name);
		} else {
			var eParent = e.parentNode;
			if (eParent.className.toUpperCase().indexOf("TRACK") > -1)
			    trackurl(eParent.name);
		}
	});
});

/* trace areaid */
function trackurl(areaid) {
    if (areaid == null || areaid == "") return;
    var sb = [];
    var gatherCookies = getGatherCookie();
    
    sb.push(document.location.protocol);
    sb.push("//vamr.vancl.com/track.aspx?ref=");
    sb.push(escape(window.document.referrer));
    sb.push("&areaid=");
    sb.push(areaid);

    if (gatherCookies != "") {
        sb.push("&gather_cookies=" + gatherCookies);
    }
    
    var url = sb.join("");

    $('#weblog_track').remove();
    $('body').append('<img id="weblog_track" src=' + url + ' style="display:none;"/>');

}

function getGatherCookie() {
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