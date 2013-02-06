(function(a){function c(b){if(a.fn.cycle.debug)d(b)}function d(){if(window.console&&window.console.log)window.console.log("[cycle] "+Array.prototype.join.call(arguments," "))}function e(b,c,e){function i(b,c,e){if(!b&&c===true){var g=a(e).data("cycle.opts");if(!g){d("options not found, can not resume");return false}if(e.cycleTimeout){clearTimeout(e.cycleTimeout);e.cycleTimeout=0}l(g.elements,g,1,!f.rev&&!f.backwards)}}if(b.cycleStop==undefined)b.cycleStop=0;if(c===undefined||c===null)c={};if(c.constructor==String){switch(c){case"destroy":case"stop":var f=a(b).data("cycle.opts");if(!f)return false;b.cycleStop++;if(b.cycleTimeout)clearTimeout(b.cycleTimeout);b.cycleTimeout=0;a(b).removeData("cycle.opts");if(c=="destroy")g(f);return false;case"toggle":b.cyclePause=b.cyclePause===1?0:1;i(b.cyclePause,e,b);return false;case"pause":b.cyclePause=1;return false;case"resume":b.cyclePause=0;i(false,e,b);return false;case"prev":case"next":var f=a(b).data("cycle.opts");if(!f){d('options not found, "prev/next" ignored');return false}a.fn.cycle[c](f);return false;default:c={fx:c}}return c}else if(c.constructor==Number){var h=c;c=a(b).data("cycle.opts");if(!c){d("options not found, can not advance slide");return false}if(h<0||h>=c.elements.length){d("invalid slide index: "+h);return false}c.nextSlide=h;if(b.cycleTimeout){clearTimeout(b.cycleTimeout);b.cycleTimeout=0}if(typeof e=="string")c.oneTimeFx=e;l(c.elements,c,1,h>=c.currSlide);return false}return c}function f(b,c){if(!a.support.opacity&&c.cleartype&&b.style.filter){try{b.style.removeAttribute("filter")}catch(d){}}}function g(b){if(b.next)a(b.next).unbind(b.prevNextEvent);if(b.prev)a(b.prev).unbind(b.prevNextEvent);if(b.pager||b.pagerAnchorBuilder)a.each(b.pagerAnchors||[],function(){this.unbind().remove()});b.pagerAnchors=null;if(b.destroy)b.destroy(b)}function h(b,c,e,g,h){var m=a.extend({},a.fn.cycle.defaults,g||{},a.metadata?b.metadata():a.meta?b.data():{});if(m.autostop)m.countdown=m.autostopCount||e.length;var p=b[0];b.data("cycle.opts",m);m.$cont=b;m.stopCount=p.cycleStop;m.elements=e;m.before=m.before?[m.before]:[];m.after=m.after?[m.after]:[];m.after.unshift(function(){m.busy=0});if(!a.support.opacity&&m.cleartype)m.after.push(function(){f(this,m)});if(m.continuous)m.after.push(function(){l(e,m,0,!m.rev&&!m.backwards)});i(m);if(!a.support.opacity&&m.cleartype&&!m.cleartypeNoBg)q(c);if(b.css("position")=="static")b.css("position","relative");if(m.width)b.width(m.width);if(m.height&&m.height!="auto")b.height(m.height);if(m.startingSlide)m.startingSlide=parseInt(m.startingSlide);else if(m.backwards)m.startingSlide=e.length-1;if(m.random){m.randomMap=[];for(var r=0;r<e.length;r++)m.randomMap.push(r);m.randomMap.sort(function(a,b){return Math.random()-.5});m.randomIndex=1;m.startingSlide=m.randomMap[1]}else if(m.startingSlide>=e.length)m.startingSlide=0;m.currSlide=m.startingSlide||0;var s=m.startingSlide;c.css({position:"absolute",top:0,left:0}).hide().each(function(b){var c;if(m.backwards)c=s?b<=s?e.length+(b-s):s-b:e.length-b;else c=s?b>=s?e.length-(b-s):s-b:e.length-b;a(this).css("z-index",c)});a(e[s]).css("opacity",1).show();f(e[s],m);if(m.fit&&m.width)c.width(m.width);if(m.fit&&m.height&&m.height!="auto")c.height(m.height);var t=m.containerResize&&!b.innerHeight();if(t){var u=0,v=0;for(var w=0;w<e.length;w++){var x=a(e[w]),y=x[0],z=x.outerWidth(),A=x.outerHeight();if(!z)z=y.offsetWidth||y.width||x.attr("width");if(!A)A=y.offsetHeight||y.height||x.attr("height");u=z>u?z:u;v=A>v?A:v}if(u>0&&v>0)b.css({width:u+"px",height:v+"px"})}if(m.pause)b.hover(function(){this.cyclePause++},function(){this.cyclePause--});if(j(m)===false)return false;var B=false;g.requeueAttempts=g.requeueAttempts||0;c.each(function(){var b=a(this);this.cycleH=m.fit&&m.height?m.height:b.height()||this.offsetHeight||this.height||b.attr("height")||0;this.cycleW=m.fit&&m.width?m.width:b.width()||this.offsetWidth||this.width||b.attr("width")||0;if(b.is("img")){var c=a.browser.msie&&this.cycleW==28&&this.cycleH==30&&!this.complete;var e=a.browser.mozilla&&this.cycleW==34&&this.cycleH==19&&!this.complete;var f=a.browser.opera&&(this.cycleW==42&&this.cycleH==19||this.cycleW==37&&this.cycleH==17)&&!this.complete;var i=this.cycleH==0&&this.cycleW==0&&!this.complete;if(c||e||f||i){if(h.s&&m.requeueOnImageNotLoaded&&++g.requeueAttempts<100){d(g.requeueAttempts," - img slide not loaded, requeuing slideshow: ",this.src,this.cycleW,this.cycleH);setTimeout(function(){a(h.s,h.c).cycle(g)},m.requeueTimeout);B=true;return false}else{d("could not determine size of image: "+this.src,this.cycleW,this.cycleH)}}}return true});if(B)return false;m.cssBefore=m.cssBefore||{};m.animIn=m.animIn||{};m.animOut=m.animOut||{};c.not(":eq("+s+")").css(m.cssBefore);if(m.cssFirst)a(c[s]).css(m.cssFirst);if(m.timeout){m.timeout=parseInt(m.timeout);if(m.speed.constructor==String)m.speed=a.fx.speeds[m.speed]||parseInt(m.speed);if(!m.sync)m.speed=m.speed/2;var C=m.fx=="shuffle"?500:250;while(m.timeout-m.speed<C)m.timeout+=m.speed}if(m.easing)m.easeIn=m.easeOut=m.easing;if(!m.speedIn)m.speedIn=m.speed;if(!m.speedOut)m.speedOut=m.speed;m.slideCount=e.length;m.currSlide=m.lastSlide=s;if(m.random){if(++m.randomIndex==e.length)m.randomIndex=0;m.nextSlide=m.randomMap[m.randomIndex]}else if(m.backwards)m.nextSlide=m.startingSlide==0?e.length-1:m.startingSlide-1;else m.nextSlide=m.startingSlide>=e.length-1?0:m.startingSlide+1;if(!m.multiFx){var D=a.fn.cycle.transitions[m.fx];if(a.isFunction(D))D(b,c,m);else if(m.fx!="custom"&&!m.multiFx){d("unknown transition: "+m.fx,"; slideshow terminating");return false}}var E=c[s];if(m.before.length)m.before[0].apply(E,[E,E,m,true]);if(m.after.length>1)m.after[1].apply(E,[E,E,m,true]);if(m.next)a(m.next).bind(m.prevNextEvent,function(){return n(m,m.rev?-1:1)});if(m.prev)a(m.prev).bind(m.prevNextEvent,function(){return n(m,m.rev?1:-1)});if(m.pager||m.pagerAnchorBuilder)o(e,m);k(m,e);return m}function i(b){b.original={before:[],after:[]};b.original.cssBefore=a.extend({},b.cssBefore);b.original.cssAfter=a.extend({},b.cssAfter);b.original.animIn=a.extend({},b.animIn);b.original.animOut=a.extend({},b.animOut);a.each(b.before,function(){b.original.before.push(this)});a.each(b.after,function(){b.original.after.push(this)})}function j(b){var e,f,g=a.fn.cycle.transitions;if(b.fx.indexOf(",")>0){b.multiFx=true;b.fxs=b.fx.replace(/\s*/g,"").split(",");for(e=0;e<b.fxs.length;e++){var h=b.fxs[e];f=g[h];if(!f||!g.hasOwnProperty(h)||!a.isFunction(f)){d("discarding unknown transition: ",h);b.fxs.splice(e,1);e--}}if(!b.fxs.length){d("No valid transitions named; slideshow terminating.");return false}}else if(b.fx=="all"){b.multiFx=true;b.fxs=[];for(p in g){f=g[p];if(g.hasOwnProperty(p)&&a.isFunction(f))b.fxs.push(p)}}if(b.multiFx&&b.randomizeEffects){var i=Math.floor(Math.random()*20)+30;for(e=0;e<i;e++){var j=Math.floor(Math.random()*b.fxs.length);b.fxs.push(b.fxs.splice(j,1)[0])}c("randomized fx sequence: ",b.fxs)}return true}function k(b,c){b.addSlide=function(d,e){var f=a(d),g=f[0];if(!b.autostopCount)b.countdown++;c[e?"unshift":"push"](g);if(b.els)b.els[e?"unshift":"push"](g);b.slideCount=c.length;f.css("position","absolute");f[e?"prependTo":"appendTo"](b.$cont);if(e){b.currSlide++;b.nextSlide++}if(!a.support.opacity&&b.cleartype&&!b.cleartypeNoBg)q(f);if(b.fit&&b.width)f.width(b.width);if(b.fit&&b.height&&b.height!="auto")$slides.height(b.height);g.cycleH=b.fit&&b.height?b.height:f.height();g.cycleW=b.fit&&b.width?b.width:f.width();f.css(b.cssBefore);if(b.pager||b.pagerAnchorBuilder)a.fn.cycle.createPagerAnchor(c.length-1,g,a(b.pager),c,b);if(a.isFunction(b.onAddSlide))b.onAddSlide(f);else f.hide()}}function l(b,d,e,f){if(e&&d.busy&&d.manualTrump){c("manualTrump in go(), stopping active transition");a(b).stop(true,true);d.busy=false}if(d.busy){c("transition active, ignoring new tx request");return}var g=d.$cont[0],h=b[d.currSlide],i=b[d.nextSlide];if(g.cycleStop!=d.stopCount||g.cycleTimeout===0&&!e)return;if(!e&&!g.cyclePause&&!d.bounce&&(d.autostop&&--d.countdown<=0||d.nowrap&&!d.random&&d.nextSlide<d.currSlide)){if(d.end)d.end(d);return}var j=false;if((e||!g.cyclePause)&&d.nextSlide!=d.currSlide){j=true;var k=d.fx;h.cycleH=h.cycleH||a(h).height();h.cycleW=h.cycleW||a(h).width();i.cycleH=i.cycleH||a(i).height();i.cycleW=i.cycleW||a(i).width();if(d.multiFx){if(d.lastFx==undefined||++d.lastFx>=d.fxs.length)d.lastFx=0;k=d.fxs[d.lastFx];d.currFx=k}if(d.oneTimeFx){k=d.oneTimeFx;d.oneTimeFx=null}a.fn.cycle.resetState(d,k);if(d.before.length)a.each(d.before,function(a,b){if(g.cycleStop!=d.stopCount)return;b.apply(i,[h,i,d,f])});var n=function(){a.each(d.after,function(a,b){if(g.cycleStop!=d.stopCount)return;b.apply(i,[h,i,d,f])})};c("tx firing; currSlide: "+d.currSlide+"; nextSlide: "+d.nextSlide);d.busy=1;if(d.fxFn)d.fxFn(h,i,d,n,f,e&&d.fastOnEvent);else if(a.isFunction(a.fn.cycle[d.fx]))a.fn.cycle[d.fx](h,i,d,n,f,e&&d.fastOnEvent);else a.fn.cycle.custom(h,i,d,n,f,e&&d.fastOnEvent)}if(j||d.nextSlide==d.currSlide){d.lastSlide=d.currSlide;if(d.random){d.currSlide=d.nextSlide;if(++d.randomIndex==b.length)d.randomIndex=0;d.nextSlide=d.randomMap[d.randomIndex];if(d.nextSlide==d.currSlide)d.nextSlide=d.currSlide==d.slideCount-1?0:d.currSlide+1}else if(d.backwards){var o=d.nextSlide-1<0;if(o&&d.bounce){d.backwards=!d.backwards;d.nextSlide=1;d.currSlide=0}else{d.nextSlide=o?b.length-1:d.nextSlide-1;d.currSlide=o?0:d.nextSlide+1}}else{var o=d.nextSlide+1==b.length;if(o&&d.bounce){d.backwards=!d.backwards;d.nextSlide=b.length-2;d.currSlide=b.length-1}else{d.nextSlide=o?0:d.nextSlide+1;d.currSlide=o?b.length-1:d.nextSlide-1}}}if(j&&d.pager)d.updateActivePagerLink(d.pager,d.currSlide,d.activePagerClass);var p=0;if(d.timeout&&!d.continuous)p=m(b[d.currSlide],b[d.nextSlide],d,f);else if(d.continuous&&g.cyclePause)p=10;if(p>0)g.cycleTimeout=setTimeout(function(){l(b,d,0,!d.rev&&!d.backwards)},p)}function m(a,b,d,e){if(d.timeoutFn){var f=d.timeoutFn.call(a,a,b,d,e);while(f-d.speed<250)f+=d.speed;c("calculated timeout: "+f+"; speed: "+d.speed);if(f!==false)return f}return d.timeout}function n(b,c){var d=b.elements;var e=b.$cont[0],f=e.cycleTimeout;if(f){clearTimeout(f);e.cycleTimeout=0}if(b.random&&c<0){b.randomIndex--;if(--b.randomIndex==-2)b.randomIndex=d.length-2;else if(b.randomIndex==-1)b.randomIndex=d.length-1;b.nextSlide=b.randomMap[b.randomIndex]}else if(b.random){b.nextSlide=b.randomMap[b.randomIndex]}else{b.nextSlide=b.currSlide+c;if(b.nextSlide<0){if(b.nowrap)return false;b.nextSlide=d.length-1}else if(b.nextSlide>=d.length){if(b.nowrap)return false;b.nextSlide=0}}var g=b.onPrevNextEvent||b.prevNextClick;if(a.isFunction(g))g(c>0,b.nextSlide,d[b.nextSlide]);l(d,b,1,c>=0);return false}function o(b,c){var d=a(c.pager);a.each(b,function(e,f){a.fn.cycle.createPagerAnchor(e,f,d,b,c)});c.updateActivePagerLink(c.pager,c.startingSlide,c.activePagerClass)}function q(b){function d(a){a=parseInt(a).toString(16);return a.length<2?"0"+a:a}function e(b){for(;b&&b.nodeName.toLowerCase()!="html";b=b.parentNode){var c=a.css(b,"background-color");if(c.indexOf("rgb")>=0){var e=c.match(/\d+/g);return"#"+d(e[0])+d(e[1])+d(e[2])}if(c&&c!="transparent")return c}return"#ffffff"}c("applying clearType background-color hack");b.each(function(){a(this).css("background-color",e(this))})}var b="2.88";if(a.support==undefined){a.support={opacity:!a.browser.msie}}a.fn.cycle=function(b,f){var g={s:this.selector,c:this.context};if(this.length===0&&b!="stop"){if(!a.isReady&&g.s){d("DOM not ready, queuing slideshow");a(function(){a(g.s,g.c).cycle(b,f)});return this}d("terminating; zero elements found by selector"+(a.isReady?"":" (DOM not ready)"));return this}return this.each(function(){var i=e(this,b,f);if(i===false)return;i.updateActivePagerLink=i.updateActivePagerLink||a.fn.cycle.updateActivePagerLink;if(this.cycleTimeout)clearTimeout(this.cycleTimeout);this.cycleTimeout=this.cyclePause=0;var j=a(this);var k=i.slideExpr?a(i.slideExpr,this):j.children();var n=k.get();if(n.length<2){d("terminating; too few slides: "+n.length);return}var o=h(j,k,n,i,g);if(o===false)return;var p=o.continuous?10:m(n[o.currSlide],n[o.nextSlide],o,!o.rev);if(p){p+=o.delay||0;if(p<10)p=10;c("first timeout: "+p);this.cycleTimeout=setTimeout(function(){l(n,o,0,!o.rev&&!i.backwards)},p)}})};a.fn.cycle.resetState=function(b,c){c=c||b.fx;b.before=[];b.after=[];b.cssBefore=a.extend({},b.original.cssBefore);b.cssAfter=a.extend({},b.original.cssAfter);b.animIn=a.extend({},b.original.animIn);b.animOut=a.extend({},b.original.animOut);b.fxFn=null;a.each(b.original.before,function(){b.before.push(this)});a.each(b.original.after,function(){b.after.push(this)});var d=a.fn.cycle.transitions[c];if(a.isFunction(d))d(b.$cont,a(b.elements),b)};a.fn.cycle.updateActivePagerLink=function(b,c,d){a(b).each(function(){a(this).children().removeClass(d).eq(c).addClass(d)})};a.fn.cycle.next=function(a){n(a,a.rev?-1:1)};a.fn.cycle.prev=function(a){n(a,a.rev?1:-1)};a.fn.cycle.createPagerAnchor=function(b,d,e,f,g){var h;if(a.isFunction(g.pagerAnchorBuilder)){h=g.pagerAnchorBuilder(b,d);c("pagerAnchorBuilder("+b+", el) returned: "+h)}else h='<a href="#">'+(b+1)+"</a>";if(!h)return;var i=a(h);if(i.parents("body").length===0){var j=[];if(e.length>1){e.each(function(){var b=i.clone(true);a(this).append(b);j.push(b[0])});i=a(j)}else{i.appendTo(e)}}g.pagerAnchors=g.pagerAnchors||[];g.pagerAnchors.push(i);i.bind(g.pagerEvent,function(c){c.preventDefault();g.nextSlide=b;var d=g.$cont[0],e=d.cycleTimeout;if(e){clearTimeout(e);d.cycleTimeout=0}var h=g.onPagerEvent||g.pagerClick;if(a.isFunction(h))h(g.nextSlide,f[g.nextSlide]);l(f,g,1,g.currSlide<b)});if(!/^click/.test(g.pagerEvent)&&!g.allowPagerClickBubble)i.bind("click.cycle",function(){return false});if(g.pauseOnPagerHover)i.hover(function(){g.$cont[0].cyclePause++},function(){g.$cont[0].cyclePause--})};a.fn.cycle.hopsFromLast=function(a,b){var c,d=a.lastSlide,e=a.currSlide;if(b)c=e>d?e-d:a.slideCount-d;else c=e<d?d-e:d+a.slideCount-e;return c};a.fn.cycle.commonReset=function(b,c,d,e,f,g){a(d.elements).not(b).hide();d.cssBefore.opacity=1;d.cssBefore.display="block";if(e!==false&&c.cycleW>0)d.cssBefore.width=c.cycleW;if(f!==false&&c.cycleH>0)d.cssBefore.height=c.cycleH;d.cssAfter=d.cssAfter||{};d.cssAfter.display="none";a(b).css("zIndex",d.slideCount+(g===true?1:0));a(c).css("zIndex",d.slideCount+(g===true?0:1))};a.fn.cycle.custom=function(b,c,d,e,f,g){var h=a(b),i=a(c);var j=d.speedIn,k=d.speedOut,l=d.easeIn,m=d.easeOut;i.css(d.cssBefore);if(g){if(typeof g=="number")j=k=g;else j=k=1;l=m=null}var n=function(){i.animate(d.animIn,j,l,e)};h.animate(d.animOut,k,m,function(){if(d.cssAfter)h.css(d.cssAfter);if(!d.sync)n()});if(d.sync)n()};a.fn.cycle.transitions={fade:function(b,c,d){c.not(":eq("+d.currSlide+")").css("opacity",0);d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d);d.cssBefore.opacity=0});d.animIn={opacity:1};d.animOut={opacity:0};d.cssBefore={top:0,left:0}}};a.fn.cycle.ver=function(){return b};a.fn.cycle.defaults={fx:"fade",timeout:4e3,timeoutFn:null,continuous:0,speed:1e3,speedIn:null,speedOut:null,next:null,prev:null,onPrevNextEvent:null,prevNextEvent:"click.cycle",pager:null,onPagerEvent:null,pagerEvent:"click.cycle",allowPagerClickBubble:false,pagerAnchorBuilder:null,before:null,after:null,end:null,easing:null,easeIn:null,easeOut:null,shuffle:null,animIn:null,animOut:null,cssBefore:null,cssAfter:null,fxFn:null,height:"auto",startingSlide:0,sync:1,random:0,fit:0,containerResize:1,pause:0,pauseOnPagerHover:0,autostop:0,autostopCount:0,delay:0,slideExpr:null,cleartype:!a.support.opacity,cleartypeNoBg:false,nowrap:0,fastOnEvent:0,randomizeEffects:1,rev:0,manualTrump:true,requeueOnImageNotLoaded:true,requeueTimeout:250,activePagerClass:"activeSlide",updateActivePagerLink:null,backwards:false}})(jQuery);(function(a){a.fn.cycle.transitions.none=function(b,c,d){d.fxFn=function(b,c,d,e){a(c).show();a(b).hide();e()}};a.fn.cycle.transitions.scrollUp=function(b,c,d){b.css("overflow","hidden");d.before.push(a.fn.cycle.commonReset);var e=b.height();d.cssBefore={top:e,left:0};d.cssFirst={top:0};d.animIn={top:0};d.animOut={top:-e}};a.fn.cycle.transitions.scrollDown=function(b,c,d){b.css("overflow","hidden");d.before.push(a.fn.cycle.commonReset);var e=b.height();d.cssFirst={top:0};d.cssBefore={top:-e,left:0};d.animIn={top:0};d.animOut={top:e}};a.fn.cycle.transitions.scrollLeft=function(b,c,d){b.css("overflow","hidden");d.before.push(a.fn.cycle.commonReset);var e=b.width();d.cssFirst={left:0};d.cssBefore={left:e,top:0};d.animIn={left:0};d.animOut={left:0-e}};a.fn.cycle.transitions.scrollRight=function(b,c,d){b.css("overflow","hidden");d.before.push(a.fn.cycle.commonReset);var e=b.width();d.cssFirst={left:0};d.cssBefore={left:-e,top:0};d.animIn={left:0};d.animOut={left:e}};a.fn.cycle.transitions.scrollHorz=function(b,c,d){b.css("overflow","hidden").width();d.before.push(function(b,c,d,e){a.fn.cycle.commonReset(b,c,d);d.cssBefore.left=e?c.cycleW-1:1-c.cycleW;d.animOut.left=e?-b.cycleW:b.cycleW});d.cssFirst={left:0};d.cssBefore={top:0};d.animIn={left:0};d.animOut={top:0}};a.fn.cycle.transitions.scrollVert=function(b,c,d){b.css("overflow","hidden");d.before.push(function(b,c,d,e){a.fn.cycle.commonReset(b,c,d);d.cssBefore.top=e?1-c.cycleH:c.cycleH-1;d.animOut.top=e?b.cycleH:-b.cycleH});d.cssFirst={top:0};d.cssBefore={left:0};d.animIn={top:0};d.animOut={left:0}};a.fn.cycle.transitions.slideX=function(b,c,d){d.before.push(function(b,c,d){a(d.elements).not(b).hide();a.fn.cycle.commonReset(b,c,d,false,true);d.animIn.width=c.cycleW});d.cssBefore={left:0,top:0,width:0};d.animIn={width:"show"};d.animOut={width:0}};a.fn.cycle.transitions.slideY=function(b,c,d){d.before.push(function(b,c,d){a(d.elements).not(b).hide();a.fn.cycle.commonReset(b,c,d,true,false);d.animIn.height=c.cycleH});d.cssBefore={left:0,top:0,height:0};d.animIn={height:"show"};d.animOut={height:0}};a.fn.cycle.transitions.shuffle=function(b,c,d){var e,f=b.css("overflow","visible").width();c.css({left:0,top:0});d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,true,true,true)});if(!d.speedAdjusted){d.speed=d.speed/2;d.speedAdjusted=true}d.random=0;d.shuffle=d.shuffle||{left:-f,top:15};d.els=[];for(e=0;e<c.length;e++)d.els.push(c[e]);for(e=0;e<d.currSlide;e++)d.els.push(d.els.shift());d.fxFn=function(b,c,d,e,f){var g=f?a(b):a(c);a(c).css(d.cssBefore);var h=d.slideCount;g.animate(d.shuffle,d.speedIn,d.easeIn,function(){var c=a.fn.cycle.hopsFromLast(d,f);for(var i=0;i<c;i++)f?d.els.push(d.els.shift()):d.els.unshift(d.els.pop());if(f){for(var j=0,k=d.els.length;j<k;j++)a(d.els[j]).css("z-index",k-j+h)}else{var l=a(b).css("z-index");g.css("z-index",parseInt(l)+1+h)}g.animate({left:0,top:0},d.speedOut,d.easeOut,function(){a(f?this:b).hide();if(e)e()})})};d.cssBefore={display:"block",opacity:1,top:0,left:0}};a.fn.cycle.transitions.turnUp=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,true,false);d.cssBefore.top=c.cycleH;d.animIn.height=c.cycleH});d.cssFirst={top:0};d.cssBefore={left:0,height:0};d.animIn={top:0};d.animOut={height:0}};a.fn.cycle.transitions.turnDown=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,true,false);d.animIn.height=c.cycleH;d.animOut.top=b.cycleH});d.cssFirst={top:0};d.cssBefore={left:0,top:0,height:0};d.animOut={height:0}};a.fn.cycle.transitions.turnLeft=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,false,true);d.cssBefore.left=c.cycleW;d.animIn.width=c.cycleW});d.cssBefore={top:0,width:0};d.animIn={left:0};d.animOut={width:0}};a.fn.cycle.transitions.turnRight=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,false,true);d.animIn.width=c.cycleW;d.animOut.left=b.cycleW});d.cssBefore={top:0,left:0,width:0};d.animIn={left:0};d.animOut={width:0}};a.fn.cycle.transitions.zoom=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,false,false,true);d.cssBefore.top=c.cycleH/2;d.cssBefore.left=c.cycleW/2;d.animIn={top:0,left:0,width:c.cycleW,height:c.cycleH};d.animOut={width:0,height:0,top:b.cycleH/2,left:b.cycleW/2}});d.cssFirst={top:0,left:0};d.cssBefore={width:0,height:0}};a.fn.cycle.transitions.fadeZoom=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,false,false);d.cssBefore.left=c.cycleW/2;d.cssBefore.top=c.cycleH/2;d.animIn={top:0,left:0,width:c.cycleW,height:c.cycleH}});d.cssBefore={width:0,height:0};d.animOut={opacity:0}};a.fn.cycle.transitions.blindX=function(b,c,d){var e=b.css("overflow","hidden").width();d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d);d.animIn.width=c.cycleW;d.animOut.left=b.cycleW});d.cssBefore={left:e,top:0};d.animIn={left:0};d.animOut={left:e}};a.fn.cycle.transitions.blindY=function(b,c,d){var e=b.css("overflow","hidden").height();d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d);d.animIn.height=c.cycleH;d.animOut.top=b.cycleH});d.cssBefore={top:e,left:0};d.animIn={top:0};d.animOut={top:e}};a.fn.cycle.transitions.blindZ=function(b,c,d){var e=b.css("overflow","hidden").height();var f=b.width();d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d);d.animIn.height=c.cycleH;d.animOut.top=b.cycleH});d.cssBefore={top:e,left:f};d.animIn={top:0,left:0};d.animOut={top:e,left:f}};a.fn.cycle.transitions.growX=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,false,true);d.cssBefore.left=this.cycleW/2;d.animIn={left:0,width:this.cycleW};d.animOut={left:0}});d.cssBefore={width:0,top:0}};a.fn.cycle.transitions.growY=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,true,false);d.cssBefore.top=this.cycleH/2;d.animIn={top:0,height:this.cycleH};d.animOut={top:0}});d.cssBefore={height:0,left:0}};a.fn.cycle.transitions.curtainX=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,false,true,true);d.cssBefore.left=c.cycleW/2;d.animIn={left:0,width:this.cycleW};d.animOut={left:b.cycleW/2,width:0}});d.cssBefore={top:0,width:0}};a.fn.cycle.transitions.curtainY=function(b,c,d){d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,true,false,true);d.cssBefore.top=c.cycleH/2;d.animIn={top:0,height:c.cycleH};d.animOut={top:b.cycleH/2,height:0}});d.cssBefore={left:0,height:0}};a.fn.cycle.transitions.cover=function(b,c,d){var e=d.direction||"left";var f=b.css("overflow","hidden").width();var g=b.height();d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d);if(e=="right")d.cssBefore.left=-f;else if(e=="up")d.cssBefore.top=g;else if(e=="down")d.cssBefore.top=-g;else d.cssBefore.left=f});d.animIn={left:0,top:0};d.animOut={opacity:1};d.cssBefore={top:0,left:0}};a.fn.cycle.transitions.uncover=function(b,c,d){var e=d.direction||"left";var f=b.css("overflow","hidden").width();var g=b.height();d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,true,true,true);if(e=="right")d.animOut.left=f;else if(e=="up")d.animOut.top=-g;else if(e=="down")d.animOut.top=g;else d.animOut.left=-f});d.animIn={left:0,top:0};d.animOut={opacity:1};d.cssBefore={top:0,left:0}};a.fn.cycle.transitions.toss=function(b,c,d){var e=b.css("overflow","visible").width();var f=b.height();d.before.push(function(b,c,d){a.fn.cycle.commonReset(b,c,d,true,true,true);if(!d.animOut.left&&!d.animOut.top)d.animOut={left:e*2,top:-f/2,opacity:0};else d.animOut.opacity=0});d.cssBefore={left:0,top:0};d.animIn={left:0}};a.fn.cycle.transitions.wipe=function(b,c,d){var e=b.css("overflow","hidden").width();var f=b.height();d.cssBefore=d.cssBefore||{};var g;if(d.clip){if(/l2r/.test(d.clip))g="rect(0px 0px "+f+"px 0px)";else if(/r2l/.test(d.clip))g="rect(0px "+e+"px "+f+"px "+e+"px)";else if(/t2b/.test(d.clip))g="rect(0px "+e+"px 0px 0px)";else if(/b2t/.test(d.clip))g="rect("+f+"px "+e+"px "+f+"px 0px)";else if(/zoom/.test(d.clip)){var h=parseInt(f/2);var i=parseInt(e/2);g="rect("+h+"px "+i+"px "+h+"px "+i+"px)"}}d.cssBefore.clip=d.cssBefore.clip||g||"rect(0px 0px 0px 0px)";var j=d.cssBefore.clip.match(/(\d+)/g);var k=parseInt(j[0]),l=parseInt(j[1]),m=parseInt(j[2]),n=parseInt(j[3]);d.before.push(function(b,c,d){if(b==c)return;var g=a(b),h=a(c);a.fn.cycle.commonReset(b,c,d,true,true,false);d.cssAfter.display="block";var i=1,j=parseInt(d.speedIn/13)-1;(function o(){var a=k?k-parseInt(i*(k/j)):0;var b=n?n-parseInt(i*(n/j)):0;var c=m<f?m+parseInt(i*((f-m)/j||1)):f;var d=l<e?l+parseInt(i*((e-l)/j||1)):e;h.css({clip:"rect("+a+"px "+d+"px "+c+"px "+b+"px)"});i++<=j?setTimeout(o,13):g.css("display","none")})()});d.cssBefore={display:"block",opacity:1,top:0,left:0};d.animIn={left:0};d.animOut={left:0}}})(jQuery)