/*!
* mqGenie v0.4.1
*
* Adjusts CSS media queries in browsers that include the scrollbar's width in the viewport width so they fire at the intended size
*
* Returns the mqGenie object containing .adjusted, .width & fontSize for use in re-calculating media queries in JavaScript with mqAdjust(string)
*
* Copyright (c) 2013 Matt Stow
*
* http://mattstow.com
*
* Licensed under the MIT license
*/
;(function(e,t){function n(e,t){var n=e.cssRules?e.cssRules:e.media,r,i=[],s=0,o=n.length;for(s;s<o;s++){r=n[s];if(t(r))i.push(r)}return i}function r(e){return n(e,function(e){return e.constructor===CSSMediaRule})}function i(n){var r=e.location,i=t.createElement("a");i.href=n;return i.hostname===r.hostname&&i.protocol===r.protocol}function s(e){return e.ownerNode.constructor===HTMLStyleElement}function o(e){return e.href&&i(e.href)}function u(){var e=t.styleSheets,n,r=e.length,i=0,u=[];for(i;i<r;i++){n=e[i];if(o(n)||s(n))u.push(n)}return u}if(!t.addEventListener)return;t.addEventListener("DOMContentLoaded",function(){e.mqGenie=function(){var n=t.documentElement;n.style.overflowY="scroll";var i=e.innerWidth-n.clientWidth,s={adjusted:i>0,fontSize:parseFloat(e.getComputedStyle(n).getPropertyValue("font-size")),width:i};if(s.adjusted){if("WebkitAppearance"in n.style){var o=/Chrome\/(\d*?\.\d*?\.\d*?\.\d*?)\s/g,a=navigator.userAgent.match(o),f;if(a){a=a[0].replace(o,"$1");f=a.split(".");f[0]=parseInt(f[0]);f[2]=parseInt(f[2]);f[3]=parseInt(f[3]);if(f[0]<=29){if(f[0]===29&&f[2]<1548&&f[3]<57){s.adjusted=false}else if(f[0]<29){s.adjusted=false}}}else{s.adjusted=false}if(!s.adjusted)return s}var l=u(),c=l.length,h=0,p,d;for(h;h<c;h++){p=r(l[h]);d=p.length;for(var v=0;v<d;v++){p[v].media.mediaText=p[v].media.mediaText.replace(/m(in|ax)-width:\s*(\d|\.)+(px|em)/gi,function(e){if(e.match("px")){return e.replace(/\d+px/gi,function(e){return parseInt(e,10)+s.width+"px"})}else{return e.replace(/\d.+?em/gi,function(e){return(parseFloat(e)*s.fontSize+s.width)/s.fontSize+"em"})}})}}}return s}();e.mqAdjust=function(e){if(!mqGenie.adjusted)return e;var t=e.replace(/\d+px/gi,function(e){return parseInt(e,10)+mqGenie.width+"px"});t=t.replace(/\d.+?em/gi,function(e){return(parseFloat(e)*mqGenie.fontSize+mqGenie.width)/mqGenie.fontSize+"em"});return t}})})(window,document);
/*
 * Viewport Genie v0.3
 * Adds the "real" viewport width and height (in px and em) as an element on the body to help with obtaining values for responsive breakpoints when ?genie=true
 *
 * Use it in conjunction with mqGenie (https://github.com/stowball/mqGenie) to trigger the correct breakpoints in non-WebKit browsers
 * 
 * Copyright (c) 2013 Matt Stow
 *
 * http://mattstow.com
 *
 * Licensed under the MIT license
 */
;(function(e){if(e){var d=/(&|\?)(\w+)=true/gi,k=window.location.href,f,p="",l={};while(f=d.exec(k)){p+=" "+f[2];l[f[2]]=true}if(!l.genie){return}}var g=document.documentElement,i=document.head,h=document.body,c="vp-genie",j=document.getElementById(c),a=document.getElementById(c+"-style"),o,n=g.clientWidth?true:false;var b={init:function(){if(j){h.removeChild(j);i.removeChild(a);return}var m="#"+c+"{background: rgba(255,0,0,.75);border: 1px solid #900;-webkit-box-shadow: 2px 2px 2px rgba(0,0,0,.3);box-shadow: 2px 2px 2px rgba(0,0,0,.3);color: #fff;font-family: monospace;font-size: 13px;left: 0;line-height: 17px;padding: 3px 6px 5px;position: fixed;top: 0;z-index: 9999;}#"+c+" span {white-space: nowrap;}",q=document.createTextNode(m);a=document.createElement("style");a.setAttribute("id",c+"-style");a.type="text/css";if(a.styleSheet){a.styleSheet.cssText=q.nodeValue}else{a.appendChild(q)}i.appendChild(a);j=document.createElement("div");j.setAttribute("id",c);h.appendChild(j);b.calculate();if(window.addEventListener){window.addEventListener("resize",b.calculate,false)}},calculate:function(){if(window.getComputedStyle){o=parseInt(window.getComputedStyle(g).getPropertyValue("font-size"))}else{o=16}var q,m;if(n){q=g.clientWidth;m=g.clientHeight}else{q=window.innerWidth;m=window.innerHeight}j.innerHTML="<span>"+q+"px &times; "+m+"px</span> &bull; <span>"+q/o+"em &times; "+m/o+"em</span>"}};b.init()})(true);