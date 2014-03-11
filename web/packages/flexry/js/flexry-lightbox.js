/*! FLEXRY - Build v0.0.6 (2014-03-11) */
!function(a){function b(b,c){function d(){return z.gallery&&m()["1"]?(a(".gallery-arrows",A).on("click",function(b){return b.stopPropagation(),b.preventDefault(),a(this).hasClass("next")?(e(),void 0):(f(),void 0)}),z.galleryMarkers&&(h(),A.$_markersInner.on("click",function(b){b.stopPropagation(),b.preventDefault(),a(b.target).hasClass("m")&&g(b.target.getAttribute("data-cache"))})),void 0):(A.removeClass("arrows markers"),void 0)}function e(){k(m()[u+1]||m()[0])}function f(){k(m()[u-1]||m()[v])}function g(a){k(m()[a])}function h(){z.galleryMarkers&&A.$_markersInner.empty().append(function(){var a="";for(var b in m())a+='<div class="m" data-cache="'+m()[b].index+'"><div class="t"><img src="'+m()[b].src_thumb+'" /></div></div>';return a})}function i(b){return t[b]||(t[b]=a.Deferred(function(a){a.notify();var c=new Image;c.onload=function(){a.resolve(c)},c.src=b}).promise()),t[b]}function j(b){return a.Deferred(function(a){setTimeout(function(){a.resolve()},+(b||z.transitionDuration))}).promise()}function k(b){B||(B=!0,u=b.index,A.setStatus(r),x===!0&&(A.$_transition[0].className=y[Math.floor(Math.random()*y.length)]),a.when(i(b.src_full),j()).done(function(){var c=new Image;c.src=b.src_full,c.className="primary-img",a("img.primary-img",A.$_content).replaceWith(c),z.captions&&(A.$_captionContainer.css({maxWidth:c.clientWidth,height:c.clientHeight}),A.$_caption1.text(b.title),A.$_caption2.text(b.descr),l(c)),B=!1,A.setStatus(q)}))}function l(a){0===a.clientHeight&&!function b(){setTimeout(function(){return a.clientHeight>=1?(A.$_captionContainer.css({maxWidth:a.clientWidth,height:a.clientHeight}),void 0):(b(),void 0)},100)}()}function m(c){return w&&c!==!0||(w={},a(z.itemTargets,b).each(function(a,b){b.setAttribute("data-flexrylb",a),w[a]=z.dataSourceMap(b),w[a].index=a,console.log(w),v=a})),w}function n(b){return{title:a(".title",b).text()||"",descr:a(".descr",b).text()||"",src_thumb:a("img",b).eq(0).attr("src"),src_full:b.getAttribute("data-src-full")}}var o=this,p=a("html").hasClass("flexry-csstransforms"),q=!0,r=!1,s=200,t={},u=null,v=0,w=!1,x=!1,y=["","fx-spin","fx-fall","fx-zoom","fx-flip-vertical","fx-flip-horizontal","fx-slide-in-right","fx-slide-in-left","fx-side-fall","fx-slit"],z=a.extend(!0,{},{maskColor:"#2a2a2a",maskOpacity:.85,maskFadeSpeed:250,closeOnClick:!0,itemTargets:".lightbox-item",delegateTarget:!1,transitionEffect:"",transitionDuration:s,captions:!0,gallery:!0,galleryMarkers:!0,dataSourceMap:n},c),A=function(){function c(){if(+z.transitionDuration!==s){var b=["-webkit-","-moz-","-o-","-ms-",""],c=z.transitionDuration/1e3,d=c/2;a(".modal-container, .content",g).attr("style",b.join("transition-duration: "+c+"s;")),a(".loader-container",g).attr("style",b.join("transition-duration: "+d+"s;"))}}function e(){return f||(f=a.Deferred(function(b){g.attr("id","flexryLightbox-"+(new Date).getTime()),g.appendTo("body"),a(".masker",g).css({background:z.maskColor,opacity:z.maskOpacity});var e=z.closeOnClick?g:a(".closer",g);e.on("click",function(b){var c=a(b.target);c.hasClass("primary-img")||c.hasClass("caption-container")||g.close()}),c(),d(),b.resolve()}).promise()),f}var f,g=a("<div />",{"class":["flexry-lightbox",z.captions?"captions":"",z.gallery?"arrows":"",z.galleryMarkers?"markers":""].join(" "),html:'<div data-transition class="'+z.transitionEffect+'"><div class="masker"></div><div class="modal-container"><div class="content"><a class="gallery-arrows prev"></a><a class="gallery-arrows next"></a><div class="caption-container"><div class="caption title"><span></span></div><div class="caption descr"><span></span></div></div><img class="primary-img" /></div></div><div class="loader-container"><div class="inner"></div></div><a class="closer"><span>Close</span></a><div class="gallery-markers"><div class="m-inner"></div></div></div>'});return x="randomize"===z.transitionEffect,g.open=function(){return a.Deferred(function(c){e().done(function(){a("html").addClass("flexry-lb-active"),g.setStatus(r).fadeIn(z.maskFadeSpeed,function(){c.resolve(),b.trigger("flexrylb.open")})})}).promise()},g.close=function(){return a("html").removeClass("flexry-lb-active"),g.setStatus(r).fadeOut(z.maskFadeSpeed,function(){b.trigger("flexrylb.close")})},g.setStatus=function(a){return g.toggleClass("loaded",a===q),g},g.$_transition=a("[data-transition]",g),g.$_content=a(".content",g),g.$_captionContainer=a(".caption-container",g),g.$_caption1=a(".title span",g),g.$_caption2=a(".descr span",g),g.$_markersInner=a(".m-inner",g),g}(),B=!1;return b.on("click.lb",z.itemTargets,function(b){if(!z.delegateTarget||a(b.target).is(z.delegateTarget)){if(p){var c=m(),d=this.getAttribute("data-flexrylb");return A.open().then(function(){k(c[d])}),void 0}alert("Sorry, your browser does not support viewing this image in large format. Please consider upgrading!")}}),{listCache:m,instance:o,$container:function(){return A},settings:function(){return z},currentIndex:function(){return u},listDataLength:function(){return v},config:function(a,b){return b?(z[a]=b,this):z[a]},rescanItems:function(){var a=m(!0);return h(),a}}}a.fn.flexryLightbox=function(c){return this.each(function(d,e){var f=a(e),g=new b(f,c);f.data("flexryLightbox",g)})}}(jQuery);