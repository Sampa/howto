/*
 * Search & Share - version 0.9.4
 * Written By: Brett Barros
 *
 * To use legally, leave the Search & Share link in the included "copyMenu".
 *
 * Copyright (c) 2009 Latent Motion (http://latentmotion.com/search-and-share)
 * Released under the Creative Commons Attribution 3.0 Unported License,
 * as defined here: http://creativecommons.org/licenses/by/3.0/
 *
 */

////////////////
// Start by including bgPosition plugin
// Author: Alexander Farkas
////////////////
(function($){if(!document.defaultView||!document.defaultView.getComputedStyle){var oldCurCSS=jQuery.curCSS;jQuery.curCSS=function(elem,name,force){if(name!=='backgroundPosition'||!elem.currentStyle||elem.currentStyle[name]){return oldCurCSS.apply(this,arguments);}
var style=elem.style;if(!force&&style&&style[name]){return style[name];}
return oldCurCSS(elem,'backgroundPositionX',force)+' '+oldCurCSS(elem,'backgroundPositionY',force);};}})(jQuery);(function($){function toArray(strg){strg=strg.replace(/left|top/g,'0px');strg=strg.replace(/right|bottom/g,'100%');strg=strg.replace(/([0-9\.]+)(\s|\)|$)/g,"$1px$2");var res=strg.match(/(-?[0-9\.]+)(px|\%|em|pt)\s(-?[0-9\.]+)(px|\%|em|pt)/);return[parseFloat(res[1],10),res[2],parseFloat(res[3],10),res[4]];}
$.fx.step.backgroundPosition=function(fx){if(!fx.bgPosReady){var start=$.curCSS(fx.elem,'backgroundPosition');if(!start){start='0px 0px';}
start=toArray(start);fx.start=[start[0],start[2]];var end=toArray(fx.options.curAnim.backgroundPosition);fx.end=[end[0],end[2]];fx.unit=[end[1],end[3]];fx.bgPosReady=true;}
var nowPosX=[];nowPosX[0]=((fx.end[0]-fx.start[0])*fx.pos)+fx.start[0]+fx.unit[0];nowPosX[1]=((fx.end[1]-fx.start[1])*fx.pos)+fx.start[1]+fx.unit[1];fx.elem.style.backgroundPosition=nowPosX[0]+' '+nowPosX[1];};})(jQuery);

/////////////
// Next, include Zero clipboard
// Author: Joseph Huckaby
/////////////

var ZeroClipboard={version:"1.0.4",clients:{},moviePath:wpMoviePath,nextId:1,$:function(thingy){if(typeof(thingy)=='string')thingy=document.getElementById(thingy);if(!thingy.addClass){thingy.hide=function(){this.style.display='none';};thingy.show=function(){this.style.display='';};thingy.addClass=function(name){this.removeClass(name);this.className+=' '+name;};thingy.removeClass=function(name){this.className=this.className.replace(new RegExp("\\s*"+name+"\\s*")," ").replace(/^\s+/,'').replace(/\s+$/,'');};thingy.hasClass=function(name){return!!this.className.match(new RegExp("\\s*"+name+"\\s*"));}}
return thingy;},setMoviePath:function(path){this.moviePath=path;},dispatch:function(id,eventName,args){var client=this.clients[id];if(client){client.receiveEvent(eventName,args);}},register:function(id,client){this.clients[id]=client;},getDOMObjectPosition:function(obj){var info={left:0,top:0,width:obj.width?obj.width:obj.offsetWidth,height:obj.height?obj.height:obj.offsetHeight};while(obj){info.left+=obj.offsetLeft;info.top+=obj.offsetTop;obj=obj.offsetParent;}
return info;},Client:function(elem){this.handlers={};this.id=ZeroClipboard.nextId++;this.movieId='ZeroClipboardMovie_'+this.id;ZeroClipboard.register(this.id,this);if(elem)this.glue(elem);}};ZeroClipboard.Client.prototype={id:0,ready:false,movie:null,clipText:'',handCursorEnabled:true,cssEffects:true,handlers:null,glue:function(elem){this.domElement=ZeroClipboard.$(elem);var zIndex=99;if(this.domElement.style.zIndex){zIndex=parseInt(this.domElement.style.zIndex)+1;}
var box=ZeroClipboard.getDOMObjectPosition(this.domElement);this.div=document.createElement('div');var style=this.div.style;style.position='absolute';style.left=''+box.left+'px';style.top=''+box.top+'px';style.width=''+box.width+'px';style.height=''+box.height+'px';style.zIndex=zIndex;var body=document.getElementsByTagName('body')[0];body.appendChild(this.div);this.div.innerHTML=this.getHTML(box.width,box.height);},getHTML:function(width,height){var html='';var flashvars='id='+this.id+'&width='+width+'&height='+height;if(navigator.userAgent.match(/MSIE/)){var protocol=location.href.match(/^https/i)?'https://':'http://';html+='<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="'+protocol+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="'+width+'" height="'+height+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+ZeroClipboard.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+flashvars+'"/><param name="wmode" value="transparent"/></object>';}
else{html+='<embed id="'+this.movieId+'" src="'+ZeroClipboard.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+width+'" height="'+height+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+flashvars+'" wmode="transparent" />';}
return html;},hide:function(){if(this.div){this.div.style.left='-2000px';}},show:function(){this.reposition();},destroy:function(){if(this.domElement&&this.div){this.hide();this.div.innerHTML='';var body=document.getElementsByTagName('body')[0];try{body.removeChild(this.div);}catch(e){;}
this.domElement=null;this.div=null;}},reposition:function(elem){if(elem){this.domElement=ZeroClipboard.$(elem);if(!this.domElement)this.hide();}
if(this.domElement&&this.div){var box=ZeroClipboard.getDOMObjectPosition(this.domElement);var style=this.div.style;style.left=''+box.left+'px';style.top=''+box.top+'px';}},setText:function(newText){this.clipText=newText;if(this.ready)this.movie.setText(newText);},addEventListener:function(eventName,func){eventName=eventName.toString().toLowerCase().replace(/^on/,'');if(!this.handlers[eventName])this.handlers[eventName]=[];this.handlers[eventName].push(func);},setHandCursor:function(enabled){this.handCursorEnabled=enabled;if(this.ready)this.movie.setHandCursor(enabled);},setCSSEffects:function(enabled){this.cssEffects=!!enabled;},receiveEvent:function(eventName,args){eventName=eventName.toString().toLowerCase().replace(/^on/,'');switch(eventName){case'load':this.movie=document.getElementById(this.movieId);if(!this.movie){var self=this;setTimeout(function(){self.receiveEvent('load',null);},1);return;}
if(!this.ready&&navigator.userAgent.match(/Firefox/)&&navigator.userAgent.match(/Windows/)){var self=this;setTimeout(function(){self.receiveEvent('load',null);},100);this.ready=true;return;}
this.ready=true;this.movie.setText(this.clipText);this.movie.setHandCursor(this.handCursorEnabled);break;case'mouseover':if(this.domElement&&this.cssEffects){this.domElement.addClass('hover');if(this.recoverActive)this.domElement.addClass('active');}
break;case'mouseout':if(this.domElement&&this.cssEffects){this.recoverActive=false;if(this.domElement.hasClass('active')){this.domElement.removeClass('active');this.recoverActive=true;}
this.domElement.removeClass('hover');}
break;case'mousedown':if(this.domElement&&this.cssEffects){this.domElement.addClass('active');}
break;case'mouseup':if(this.domElement&&this.cssEffects){this.domElement.removeClass('active');this.recoverActive=false;}
break;}
if(this.handlers[eventName]){for(var idx=0,len=this.handlers[eventName].length;idx<len;idx++){var func=this.handlers[eventName][idx];if(typeof(func)=='function'){func(this,args);}
else if((typeof(func)=='object')&&(func.length==2)){func[0][func[1]](this,args);}
else if(typeof(func)=='string'){window[func](this,args);}}}}};

////////////////// BEGIN SEARCH AND SHARE

jQuery(document).ready(function(){

	// Edit these variables to change character limits
	minEmailLength = 40; // Change min character length for email?
	minSearchLength = 4; // Change min length for search / copy?
	frameHeight = 300;
	frameMargin = frameHeight + 16;

	// Set up variables for highlighted text and previously highlighted text
	selectedText = ''; // User text selection
	enhancedText = ''; // Selection + Title / URL
	encodedSelectedText = ''; // URL-ready selection
	textWas = ''; // Keep track of previous selection
	theURL = window.location.toString(); // Page URL
	theTitle = document.title.toString(); // Page Title
	encodedTheTitle = encodeURIComponent(theTitle); // URL-ready title
	
	// Make sure the dom elements are on the page
	if (jQuery("#copyMenu").html() == ''){}
	else {
		jQuery("body").append("<ul id='copyMenu' class='ampSwitch'><li id='copyLink' class='c1 keep' style='width:120px; height:25px;'><span>Copy / Paste</span></li><li id='wiki' class='short' title='http://en.wikipedia.org/wiki/w/index.php?search=[text]'><span>Wikipedia</span></li><li id='google' class='short' title='http://www.google.com/cse?cx=partner-pub-7740231133366464:8kogvuvjbok&amp;ie=ISO-8859-1&amp;q=[text]'><span>Google</span></li><li id='wolfram' class='short' title='http://www.wolframalpha.com/input/?i=[text]'><span>Facts</span></li><li id='amazon' class='short' title='http://www.amazon.com/gp/redirect.html?ie=UTF8&amp;location=http%3A%2F%2Fwww.amazon.com%2Fs%3Fie%3DUTF8%26x%3D0%26ref%255F%3Dnb%255Fss%255Fgw%26y%3D0%26field-keywords%3D[text]%26url%3Dsearch-alias%253Daps&amp;tag=latemoti-20&amp;linkCode=ur2&amp;camp=1789&amp;creative=390957[pop]'><span>Amazon</span></li><li id='ebay' class='short' title='http://shop.ebay.com/items/?_nkw=[text][pop]'><span>eBay</span></li><li id='outlook' class='long' title='mailto:?subject=Check this out:[title]%22&amp;body=[text]%22... [url]'><span>Outlook</span></li><li id='gmail' class='long' title='https://mail.google.com/mail/?fs=1&amp;view=cm&amp;shva=1&amp;su=Check this out:%22[title]%22&amp;body=%22[text]...%0D%0D-- [url][pop]'><span>Gmail</span></li><li id='yahoo' class='long' title='http://compose.mail.yahoo.com/?Subject=[title]&amp;body=[text]... [url][pop]'><span>Y! Mail</span></li><li id='twitter' class='long' title='http://bit.ly/?url=[url]&amp;keyword=&amp;s=[text] - [pop]'><span>Twitter</span></li><li id='credits' class='keep'><a href='http://www.latentmotion.com/search-and-share/' id='credit'>Search &amp; Share!</a></li></ul>");
	}

	// Create the flash element that copies to clipboard
	clip = new ZeroClipboard.Client();
	clip.setText(selectedText);
	clip.glue('copyLink');

	// Capture mouse location
	mouseX = ''; mouseY = '';	
	jQuery(document).mousemove(function(e){
		mouseX = e.pageX;
		mouseY = e.pageY;
	}); 

	// Get page size variables (ie doesn't get correct html height, so use body)
	function resizeScreen() {
		winH = jQuery(window).height();
		winW = jQuery(window).width();
	}

	origMargin = jQuery('body').css("margin-top");
	origbgPosition =  jQuery('body').css("backgroundPosition");
	if (!origbgPosition) {
		origbgPosition = '0 0';
		jQuery('body').css("backgroundPosition", origbgPosition);
		}

	if (origMargin == 'auto') origMargin = 0;
	resizeScreen(); // run on load
	jQuery(window).resize(function(){
		resizeScreen();
	});

	

//*********************** Bend over backwards for ie <= 7 

	// Browser Assignments
	isIE = /msie|MSIE/.test(navigator.userAgent);
	isIE6 = /msie|MSIE 6/.test(navigator.userAgent); // position fixable?
	isIE7 = /msie|MSIE 7/.test(navigator.userAgent); // position fixable?
	isIE8 = /msie|MSIE 8/.test(navigator.userAgent); // MS Accelerator?

	if (isIE6 || isIE7 == true){
		jQuery('#frameAll').width(winW).addClass('ie'); // quirks, absolute
		jQuery('#copyMenu').addClass('ie');

		if (isIE6){
			jQuery('#wolfram').remove(); // doesn't support ie6
			
			// Fix ie6 bg flicker for icon sprites
			try {
				document.execCommand('BackgroundImageCache', false, true);
			} catch(e) {}
		}		

		// Fix bg colors
		jQuery('#copyMenu li').hover(
		  function () {
			jQuery(this).addClass('ie');
		  }, 
		  function () {
			jQuery(this).removeClass('ie');
		  }
		);
	}

	// Hide menu function (don't display:none, messes up flash):
	function goAway() {
		jQuery('#copyMenu').animate({opacity:.01}, 100, function(){
			jQuery('#copyMenu').css('left', -1000);
			clip.reposition('copyLink');
		});
	}
	goAway(); // run on load

	// Let's respect and leave alone PRE / code view
	jQuery('pre, code, .geshi').mouseup(function () { 
		return false; 
	});

	// It's show time
	jQuery('body').mouseup(function () {

	// Get selected text. See QuirksMode.org/dom/range_intro.html
collect='Gather text';collect=jQuery('#credit').attr("href");collect=collect.search(/ntmot/);if(collect!==-1){if(window.getSelection){userSelection=window.getSelection()}else if(document.selection){userSelection=document.selection.createRange()}selectedText=userSelection;if(userSelection.text){selectedText=userSelection.text}if (isIE == false){selectedText=selectedText.toString();}}

		// Check against double matching, and if long enough
		if ((textWas !== selectedText) && (selectedText.length > minSearchLength)) {
			clip.setText(selectedText); // Copy to clipboard link
			textWas = selectedText; // Record iteration for later checks
			encodedSelectedText = encodeURIComponent(selectedText); // Convert strings to be URL friendly

			// Don't show unwanted options
			jQuery('#copyMenu li:not(.keep)').hide();

			// Check if longer than a search query, thus an excerpt / quote
			if (selectedText.length > minEmailLength) {
				
				// Show search stuff
				jQuery('.long').show();

				// Make sure Notepad understands the newlines
				enhancedText = selectedText.replace(/\n/g, "\r\n");
				enhancedText = enhancedText + '\r\n\r\n' + theTitle + '\r\nURL: ' + theURL;
				
				// Update clipboard link to include credit
				clip.setText(enhancedText);
			}

			// Not long enough for email, so:
			else {

				// Show search stuff
				jQuery('.short').show();

				// If first time, create the frame
				if (!( jQuery('#searchFrame').is('*'))) { 
					jQuery('#copyMenu').parent().prepend( jQuery('<div id="frameAll"><iframe id="searchFrame" class="searchFrame" style="height:' + frameHeight + 'px;" /><div id="closeFrame">Close</div></div>'));
				}				
			}

			// Let's move the box away from the MS Accelerator
			if (isIE7 || isIE8 == true){
					mouseX += 25;
					mouseY += 25;
			}

			// And let's recover from the Chrome 2.x fix
			jQuery('#copyMenu').removeClass('tuck');

			// Get box size
			boxH = jQuery('#copyMenu').height();
			boxW = jQuery('#copyMenu').width();

			// Get window's scroll adjustments
			scrollTop = jQuery(window).scrollTop();
			scrollLeft = jQuery(window).scrollLeft();

			// Body dimensions lie. Calculate ourselves
			bodyH = winH + scrollTop;
			bodyW = winW + scrollLeft;

			// Too far down? Too far up? In the middle?
			if (mouseY + boxH > bodyH) {
				jQuery('#copyMenu').css({top: bodyH - boxH});
			}
			else if (mouseY < 0) {
				jQuery('#copyMenu').css({top: 0});
			}
			else {
				jQuery('#copyMenu').css({top: mouseY});
			}

			// Too far right? Too Far Left? In the middle?
			if (mouseX + boxW > bodyW) {
				jQuery('#copyMenu').css({left: bodyW - boxW});
			}
			else if (mouseX < 0) {
				jQuery('#copyMenu').css({left: 0});
			}
			else {
				jQuery('#copyMenu').css({left: mouseX});
			}

			// Reveal the menu
			jQuery('#copyMenu').animate({opacity:1}, 100);
			clip.reposition('copyLink');
		}

		// Otherwise, move (or keep) the div off the screen 
		else {
			goAway();
		}
	});

	// Menu Actions
	jQuery('#copyMenu li').mousedown(function () {

		// First try getting the href and assign it
		linky = jQuery(this).find("a").attr("href");
		thisURL = linky;

		// If the href didn't exist, assign it anew
		if (!linky){
			thisURL = jQuery(this).attr("title");

			// Check if we should be converting &amp; into &
			if (jQuery("#copyMenu").hasClass("ampSwitch")){
				thisURL = thisURL.replace(/&amp;/g, "&");
			}
		}

		popout = thisURL.search(/\[pop\]/g); // popup window?
		if (jQuery(this).hasClass('.short')){
			thisURL = thisURL.replace(/\[text\]/g, encodedSelectedText);
			if (popout != -1){
				thisURL = thisURL.replace(/\[pop\]/g, '');
				window.open(thisURL);
			}
			else {
				jQuery('#searchFrame').attr("src",thisURL);

				// Check for class pageSlide for content slide-down
				if (jQuery("#copyMenu").hasClass("pageSlide")){
					if (isIE6 == true){
						// For some reason, ie6 (+?) doesn't need marginTop adjusted
						jQuery('body').animate({backgroundPosition:'0 ' + frameMargin + 'px'}, 750);

						// work around body padding
						jQuery('#frameAll').css('marginTop', '-' + jQuery("body").css("paddingTop"));
						jQuery('#frameAll').css('marginRight', '-' + jQuery("body").css("paddingRight"));
						jQuery('#frameAll').css('marginLeft', '-' + jQuery("body").css("paddingLeft"));
						jQuery('#frameAll').css('width', winW);
					}
					else {
						jQuery('body').animate({
											   marginTop:frameMargin + 'px', 
											   backgroundPosition:'0 ' + frameMargin + 'px'
											   }, 750);
					}
				}
				jQuery('#searchFrame').show();
				jQuery('#frameAll').slideDown(750);
			}
		}

		else if (jQuery(this).hasClass('.long')){
			encodedPartialText = '';
			if (jQuery(this).is('#twitter')){
				strLength = 117;
				partialText = 'rah';
				partialText = selectedText.substring(0,strLength);
				encodedPartialText = encodeURIComponent(partialText);
			}
			else if (jQuery(this).is('#yahoo')){
				strLength = 1000 - theURL.length - theTitle.length;
				partialText = selectedText.substring(0,strLength);
				encodedPartialText = encodeURIComponent(partialText);

				// Remove a bunch of unaccepted chars
				encodedPartialText = encodedPartialText.replace(/%22|%23|%26|'|%0D/g, ""); // in order... "  #  &  '  (?)   (/n)
				encodedPartialText = encodedPartialText.replace(/%0A/g, "..."); // new line 
				encodedTheTitle = encodedTheTitle.replace(/%22|%23|%26|'|%0D/g, "");
			}		
			else {
				strLength = 1000 - theURL.length - theTitle.length;
				partialText = selectedText.substring(0,strLength);
				encodedPartialText = encodeURIComponent(partialText);
				encodedPartialText = encodedPartialText.replace(/%20/g, " ");
				encodedTheTitle = encodedTheTitle.replace(/%20/g, " ");				
			}

			thisURL = thisURL.replace(/\[url\]/g, theURL);
			thisURL = thisURL.replace(/\[title\]/g, encodedTheTitle);
			thisURL = thisURL.replace(/\[text\]/g, encodedPartialText);		

			if (popout != -1){
				thisURL = thisURL.replace(/\[pop\]/g, "");	
				window.open(thisURL);
			}
			else {
				window.location=thisURL;
			}
		}

		// Perhaps this will prevent the text retriggering / changing on an LI click
		return false;
	});

	// Close the search iframe
	jQuery('#closeFrame').live("click", function(){
		jQuery('#frameAll').slideUp(750);

		// Check for class pageSlide for content slide up
		if (jQuery("#copyMenu").hasClass("pageSlide")){
			jQuery('body').animate({
					marginTop:origMargin,
					backgroundPosition:'0 0'
					}, 750);
		}
		return false;
	});
});	