<?php slot('badge') ?> 
(function() {
	var global = this;
	
	// helpers
	var J$ = function(e){
		return document.getElementById(e);
	};

	// build badge container
	var container = J$("jotag_badge_container");
    var container1= J$("inner_content_with_menu");
    //alert(container1);
    if(!container1)
    {
	if(!container) {
		document.write('<div id="jotag_badge_container""></div>');
		container = J$("jotag_badge_container");
	};
    }
    else
    {
    if(!container) {
		document.write('<div id="jotag_badge_container"></div>');
		container = J$("jotag_badge_container");
	};
    }
	
	// append contents to the container
	container.innerHTML = "<?php echo addslashes(preg_replace("/[ \t][ \t]*/"," ",preg_replace("/[\r\n]/"," ",$badge->getHTML($jotag,$contacts,$authorized,$reload)))) ?>";
	
	// Lighbox object
	var jotag_lighbox_controller = (function () {
		// get elements
		var background = J$("jotag_badge_background");
		var wrapper = J$("jotag_badge_lightbox_wrapper");
		var lightbox = J$("jotag_badge_lightbox");
		var closebtn = J$("jotag_badge_lightbox_close");
		var border = J$("jotag_badge_lightbox_border");
		var iframe = J$("jotag_badge_lightbox_iframe");
		var comm = J$("jotag_badge_comm");
		
		// adjust background width
		if(typeof(window.innerWidth) == 'number'); // background.style.width = window.innerWidth;
		else if(document.documentElement && (document.documentElement.clientWidth)) background.style.width = document.documentElement.clientWidth;
		else background.style.width = document.body.clientWidth;
		
		// get current domain
		var domain = window.location.protocol+"//"+window.location.hostname;
		
		// initialize communication channel
		comm.src = "<?php echo url_for("@badge_comm",true) ?>?domain="+domain;
		
		// setup event handlers
		if(closebtn) closebtn.onclick = function () { return _close(); };
		background.onclick = function () { return _close(); };
		comm.onload = comm.onreadystatechange = function () {
			
			if(this.readyState && this.readyState != "complete") { return true; }
			
			try {
				if (comm.contentWindow.location.hash == "#jotag_reload") {
					// reload
					window.setTimeout(function(){
						var script = document.createElement('script');
						script.type = "text/javascript";
						script.src = "<?php echo url_for("@badge_get?jotag=".$jotag->getJotag(),true); ?>?reload=1";
						
						document.body.appendChild(script);
					}, 0);
				}
			} catch(e) {}
		};

		// private methods
		var _open = function (url,borderClass) {
			// load iframe
			iframe.src = url;
			comm.src = "<?php echo url_for("@badge_comm",true) ?>?domain="+domain;

			var boxheight = 0;			
			if(borderClass) {
				border.className = borderClass;
				boxheight = 290;
			}
			else {
				border.className = "";
				boxheight = 506;
			}
			
			// adjust lightbox margin top
			if(typeof(window.innerHeight) == 'number') border.style.marginTop = ((window.innerHeight-boxheight) / 2)+"px";
			else if(document.documentElement && (document.documentElement.clientHeight)) border.style.marginTop = ((document.documentElement.clientHeight-boxheight) / 2)+"px";
			else border.style.marginTop = ((document.body.clientHeight-boxheight) / 2)+"px";
			
			background.style.display = "block";
			wrapper.style.display = "block";
			
			return false;
		};
		
		var _close = function () {
			background.style.display = "none";
			wrapper.style.display = "none";
			
			// clear iframe
			iframe.src = "about:blank";
			comm.src = "<?php echo url_for("@badge_comm",true) ?>?domain="+domain;
			
			return false;
		};
		
		// public methods
		return {
			open: function (url,borderClass) {
				_open(url,borderClass);
			}
		};
	})();
	
	// to keep track of close timer
	var close_timer = null;
	
	// global function
	global.JoTAG_unlock = function () {
		jotag_lighbox_controller.open("<?php echo url_for("@view_jotag_badge?jotag=".$jotag->getJotag(),true); ?>","unlock");
		
		// setup a timer to abort close_timer, if available
		window.setTimeout(function () {
			if(close_timer) {
				window.clearTimeout(close_timer);
				close_timer = null;
			}
		},100);
		
		return false;
	};
	
	global.JoTAG_more = function () {
		jotag_lighbox_controller.open("<?php echo url_for("@view_jotag_badge?jotag=".$jotag->getJotag(),true); ?>?show=1");
		
		return false;
	};
	
	global.JoTAG_show = function (id) {
		// cancel previous close request
		if (close_timer) {
			window.clearTimeout(close_timer);
			close_timer = null;
		}
		
		J$(id).style.display = "block";
	};
	
	global.JoTAG_hide = function (id) {
		close_timer = window.setTimeout(function () {
			J$(id).style.display = "none";
		},800);
	};
})();


		
var tipwidth='150px'; //default tooltip width
var tipbgcolor='lightyellow';  //tooltip bgcolor
var disappeardelay=250;  //tooltip disappear speed onMouseout (in miliseconds)
var vertical_offset="0px"; //horizontal offset of tooltip from anchor link
var horizontal_offset="-3px"; //horizontal offset of tooltip from anchor link

/////No further editting needed

var ie4=document.all;
var ns6=document.getElementById&&!document.all;

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}


function showhide(obj, e, display, none, tipwidth){
if (ie4||ns6)
dropmenuobj.style.left=dropmenuobj.style.top=-500;
if (tipwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style;
dropmenuobj.widthobj.width=tipwidth;
}
if (e.type=="click" && obj.display==none || e.type=="mouseover")
obj.display='block';
else if (e.type=="click")
obj.display=none;
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1;
if (whichedge=="rightedge"){
var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15;
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth;
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth;
}
else{
var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18;
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight;
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight;
}
return edgeoffset;
}

function fixedtooltip(menucontents, obj, e, tipwidth){

if (window.event) event.cancelBubble=true;
else if (e.stopPropagation) e.stopPropagation();
clearhidetip();
dropmenuobj=document.getElementById? document.getElementById("jotag_badge_box") : jotag_badge_box;
//dropmenuobj.innerHTML=menucontents;

if (ie4||ns6){
showhide(dropmenuobj.style, e, "display", "none", tipwidth);
dropmenuobj.x=getposOffset(obj, "left");
dropmenuobj.y=getposOffset(obj, "top");
//dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px";

//dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px";

if(document.getElementById('inner_content_with_menu')!=null)
{
	if(document.getElementById('changeDiv')!=null)
    dropmenuobj.style.top='240px';
    else
    dropmenuobj.style.top='160px';
    
    dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px";
    document.getElementById('pkimagediv').style.display='inline';
    //alert('here');
}
else
{
	//dropmenuobj.style.top='30px';
    //dropmenuobj.style.right='0px';
    //if(ie4)
    //{
    //dropmenuobj.style.left="10px";   
    //}
    dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px";

	dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px";
}
//alert(dropmenuobj.x+" "+clearbrowseredge(obj, "rightedge")+" "+dropmenuobj.style.left);
//alert(dropmenuobj.style.top);
}
}

function hidetip(e){
if (typeof dropmenuobj!="undefined"){
if (ie4||ns6)
dropmenuobj.style.display="none";
}
}

function delayhidetip(){
if (ie4||ns6)
delayhide=setTimeout("hidetip()",disappeardelay);
}

function clearhidetip(){
if (typeof delayhide!="undefined")
clearTimeout(delayhide);
}


if(document.getElementById('inner_content_with_menu')!=null)
{
	document.getElementById('pkimagediv').style.display='inline';
    //alert('here');
}

<?php end_slot(); ?>
<?php
	// pack output
	$packer = new JavaScriptPacker(get_slot('badge'));
	echo $packer->pack();