/*!
* mqGenie v0.5.0
*
* Adjusts CSS media queries in browsers that include the scrollbar's width in the viewport width so they fire at the intended size
*
* Returns the mqGenie object containing .adjusted, .width & fontSize for use in re-calculating media queries in JavaScript with mqAdjust(string)
*
* Copyright (c) 2014 Matt Stow
*
* http://mattstow.com
*
* Licensed under the MIT license
*/
(function(d,b){if(!b.addEventListener){d.mqGenie={adjustMediaQuery:function(i){return i}};return}function e(k,l){var o=k.cssRules?k.cssRules:k.media,n,p=[],j=0,m=o.length;for(j;j<m;j++){n=o[j];if(l(n)){p.push(n)}}return p}function a(i){return e(i,function(j){return j.constructor===CSSMediaRule})}function g(j){var k=d.location,i=b.createElement("a");i.href=j;return i.hostname===k.hostname&&i.protocol===k.protocol}function c(i){return i.ownerNode.constructor===HTMLStyleElement}function f(i){return i.href&&g(i.href)}function h(){var n=b.styleSheets,k,m=n.length,j=0,l=[];for(j;j<m;j++){k=n[j];if(f(k)||c(k)){l.push(k)}}return l}b.addEventListener("DOMContentLoaded",function(){d.mqGenie=(function(){var r=b.documentElement;r.style.overflowY="scroll";var l=d.innerWidth-r.clientWidth,s={adjusted:l>0,fontSize:parseFloat(d.getComputedStyle(r).getPropertyValue("font-size")),width:l,adjustMediaQuery:function(j){if(!mqGenie.adjusted){return j}var i=j.replace(/\d+px/gi,function(w){return parseInt(w,10)+mqGenie.width+"px"});i=i.replace(/\d.+?em/gi,function(w){return((parseFloat(w)*mqGenie.fontSize)+mqGenie.width)/mqGenie.fontSize+"em"});return i}};if(s.adjusted){if("WebkitAppearance" in r.style){var k=/Chrome\/(\d*?\.\d*?\.\d*?\.\d*?)\s/g,q=navigator.userAgent.match(k),u;if(q){q=q[0].replace(k,"$1");u=q.split(".");u[0]=parseInt(u[0]);u[2]=parseInt(u[2]);u[3]=parseInt(u[3]);if(u[0]<=29){if(u[0]===29&&u[2]<1548&&u[3]<57){s.adjusted=false}else{if(u[0]<29){s.adjusted=false}}}}else{s.adjusted=false}if(!s.adjusted){return s}}var t=h(),m=t.length,p=0,n,v;for(p;p<m;p++){n=a(t[p]);v=n.length;for(var o=0;o<v;o++){n[o].media.mediaText=n[o].media.mediaText.replace(/m(in|ax)-width:\s*(\d|\.)+(px|em)/gi,function(i){if(i.match("px")){return i.replace(/\d+px/gi,function(j){return parseInt(j,10)+s.width+"px"})}else{return i.replace(/\d.+?em/gi,function(j){return((parseFloat(j)*s.fontSize)+s.width)/s.fontSize+"em"})}})}}}return s})()})})(window,document);
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