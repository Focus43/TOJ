/*! Town Of Jackson; Build: v18.1.0; Author: Focus43 */
+function(a){"use strict";function b(){var a=document.createElement("bootstrap"),b={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var c in b)if(void 0!==a.style[c])return{end:b[c]};return!1}a.fn.emulateTransitionEnd=function(b){var c=!1,d=this;a(this).one(a.support.transition.end,function(){c=!0});var e=function(){c||a(d).trigger(a.support.transition.end)};return setTimeout(e,b),this},a(function(){a.support.transition=b()})}(jQuery),+function(a){"use strict";var b=function(c,d){this.$element=a(c),this.options=a.extend({},b.DEFAULTS,d),this.transitioning=null,this.options.parent&&(this.$parent=a(this.options.parent)),this.options.toggle&&this.toggle()};b.DEFAULTS={toggle:!0},b.prototype.dimension=function(){var a=this.$element.hasClass("width");return a?"width":"height"},b.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var b=a.Event("show.bs.collapse");if(this.$element.trigger(b),!b.isDefaultPrevented()){var c=this.$parent&&this.$parent.find("> .panel > .in");if(c&&c.length){var d=c.data("bs.collapse");if(d&&d.transitioning)return;c.collapse("hide"),d||c.data("bs.collapse",null)}var e=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[e](0),this.transitioning=1;var f=function(){this.$element.removeClass("collapsing").addClass("collapse in")[e]("auto"),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!a.support.transition)return f.call(this);var g=a.camelCase(["scroll",e].join("-"));this.$element.one(a.support.transition.end,a.proxy(f,this)).emulateTransitionEnd(350)[e](this.$element[0][g])}}},b.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var b=a.Event("hide.bs.collapse");if(this.$element.trigger(b),!b.isDefaultPrevented()){var c=this.dimension();this.$element[c](this.$element[c]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse").removeClass("in"),this.transitioning=1;var d=function(){this.transitioning=0,this.$element.trigger("hidden.bs.collapse").removeClass("collapsing").addClass("collapse")};return a.support.transition?void this.$element[c](0).one(a.support.transition.end,a.proxy(d,this)).emulateTransitionEnd(350):d.call(this)}}},b.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()};var c=a.fn.collapse;a.fn.collapse=function(c){return this.each(function(){var d=a(this),e=d.data("bs.collapse"),f=a.extend({},b.DEFAULTS,d.data(),"object"==typeof c&&c);!e&&f.toggle&&"show"==c&&(c=!c),e||d.data("bs.collapse",e=new b(this,f)),"string"==typeof c&&e[c]()})},a.fn.collapse.Constructor=b,a.fn.collapse.noConflict=function(){return a.fn.collapse=c,this},a(document).on("click.bs.collapse.data-api","[data-toggle=collapse]",function(b){var c,d=a(this),e=d.attr("data-target")||b.preventDefault()||(c=d.attr("href"))&&c.replace(/.*(?=#[^\s]+$)/,""),f=a(e),g=f.data("bs.collapse"),h=g?"toggle":d.data(),i=d.attr("data-parent"),j=i&&a(i);g&&g.transitioning||(j&&j.find('[data-toggle=collapse][data-parent="'+i+'"]').not(d).addClass("collapsed"),d[f.hasClass("in")?"addClass":"removeClass"]("collapsed")),f.collapse(h)})}(jQuery),+function(a){"use strict";function b(b){a(d).remove(),a(e).each(function(){var d=c(a(this)),e={relatedTarget:this};d.hasClass("open")&&(d.trigger(b=a.Event("hide.bs.dropdown",e)),b.isDefaultPrevented()||d.removeClass("open").trigger("hidden.bs.dropdown",e))})}function c(b){var c=b.attr("data-target");c||(c=b.attr("href"),c=c&&/#[A-Za-z]/.test(c)&&c.replace(/.*(?=#[^\s]*$)/,""));var d=c&&a(c);return d&&d.length?d:b.parent()}var d=".dropdown-backdrop",e="[data-toggle=dropdown]",f=function(b){a(b).on("click.bs.dropdown",this.toggle)};f.prototype.toggle=function(d){var e=a(this);if(!e.is(".disabled, :disabled")){var f=c(e),g=f.hasClass("open");if(b(),!g){"ontouchstart"in document.documentElement&&!f.closest(".navbar-nav").length&&a('<div class="dropdown-backdrop"/>').insertAfter(a(this)).on("click",b);var h={relatedTarget:this};if(f.trigger(d=a.Event("show.bs.dropdown",h)),d.isDefaultPrevented())return;f.toggleClass("open").trigger("shown.bs.dropdown",h),e.focus()}return!1}},f.prototype.keydown=function(b){if(/(38|40|27)/.test(b.keyCode)){var d=a(this);if(b.preventDefault(),b.stopPropagation(),!d.is(".disabled, :disabled")){var f=c(d),g=f.hasClass("open");if(!g||g&&27==b.keyCode)return 27==b.which&&f.find(e).focus(),d.click();var h=" li:not(.divider):visible a",i=f.find("[role=menu]"+h+", [role=listbox]"+h);if(i.length){var j=i.index(i.filter(":focus"));38==b.keyCode&&j>0&&j--,40==b.keyCode&&j<i.length-1&&j++,~j||(j=0),i.eq(j).focus()}}}};var g=a.fn.dropdown;a.fn.dropdown=function(b){return this.each(function(){var c=a(this),d=c.data("bs.dropdown");d||c.data("bs.dropdown",d=new f(this)),"string"==typeof b&&d[b].call(c)})},a.fn.dropdown.Constructor=f,a.fn.dropdown.noConflict=function(){return a.fn.dropdown=g,this},a(document).on("click.bs.dropdown.data-api",b).on("click.bs.dropdown.data-api",".dropdown form",function(a){a.stopPropagation()}).on("click.bs.dropdown.data-api",e,f.prototype.toggle).on("keydown.bs.dropdown.data-api",e+", [role=menu], [role=listbox]",f.prototype.keydown)}(jQuery),+function(a){"use strict";var b=function(b,c){this.options=c,this.$element=a(b),this.$backdrop=this.isShown=null,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,a.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};b.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},b.prototype.toggle=function(a){return this[this.isShown?"hide":"show"](a)},b.prototype.show=function(b){var c=this,d=a.Event("show.bs.modal",{relatedTarget:b});this.$element.trigger(d),this.isShown||d.isDefaultPrevented()||(this.isShown=!0,this.escape(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',a.proxy(this.hide,this)),this.backdrop(function(){var d=a.support.transition&&c.$element.hasClass("fade");c.$element.parent().length||c.$element.appendTo(document.body),c.$element.show().scrollTop(0),d&&c.$element[0].offsetWidth,c.$element.addClass("in").attr("aria-hidden",!1),c.enforceFocus();var e=a.Event("shown.bs.modal",{relatedTarget:b});d?c.$element.find(".modal-dialog").one(a.support.transition.end,function(){c.$element.focus().trigger(e)}).emulateTransitionEnd(300):c.$element.focus().trigger(e)}))},b.prototype.hide=function(b){b&&b.preventDefault(),b=a.Event("hide.bs.modal"),this.$element.trigger(b),this.isShown&&!b.isDefaultPrevented()&&(this.isShown=!1,this.escape(),a(document).off("focusin.bs.modal"),this.$element.removeClass("in").attr("aria-hidden",!0).off("click.dismiss.bs.modal"),a.support.transition&&this.$element.hasClass("fade")?this.$element.one(a.support.transition.end,a.proxy(this.hideModal,this)).emulateTransitionEnd(300):this.hideModal())},b.prototype.enforceFocus=function(){a(document).off("focusin.bs.modal").on("focusin.bs.modal",a.proxy(function(a){this.$element[0]===a.target||this.$element.has(a.target).length||this.$element.focus()},this))},b.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keyup.dismiss.bs.modal",a.proxy(function(a){27==a.which&&this.hide()},this)):this.isShown||this.$element.off("keyup.dismiss.bs.modal")},b.prototype.hideModal=function(){var a=this;this.$element.hide(),this.backdrop(function(){a.removeBackdrop(),a.$element.trigger("hidden.bs.modal")})},b.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},b.prototype.backdrop=function(b){var c=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var d=a.support.transition&&c;if(this.$backdrop=a('<div class="modal-backdrop '+c+'" />').appendTo(document.body),this.$element.on("click.dismiss.bs.modal",a.proxy(function(a){a.target===a.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus.call(this.$element[0]):this.hide.call(this))},this)),d&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!b)return;d?this.$backdrop.one(a.support.transition.end,b).emulateTransitionEnd(150):b()}else!this.isShown&&this.$backdrop?(this.$backdrop.removeClass("in"),a.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one(a.support.transition.end,b).emulateTransitionEnd(150):b()):b&&b()};var c=a.fn.modal;a.fn.modal=function(c,d){return this.each(function(){var e=a(this),f=e.data("bs.modal"),g=a.extend({},b.DEFAULTS,e.data(),"object"==typeof c&&c);f||e.data("bs.modal",f=new b(this,g)),"string"==typeof c?f[c](d):g.show&&f.show(d)})},a.fn.modal.Constructor=b,a.fn.modal.noConflict=function(){return a.fn.modal=c,this},a(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(b){var c=a(this),d=c.attr("href"),e=a(c.attr("data-target")||d&&d.replace(/.*(?=#[^\s]+$)/,"")),f=e.data("bs.modal")?"toggle":a.extend({remote:!/#/.test(d)&&d},e.data(),c.data());c.is("a")&&b.preventDefault(),e.modal(f,this).one("hide",function(){c.is(":visible")&&c.focus()})}),a(document).on("show.bs.modal",".modal",function(){a(document.body).addClass("modal-open")}).on("hidden.bs.modal",".modal",function(){a(document.body).removeClass("modal-open")})}(jQuery),+function(a){"use strict";var b=function(a,b){this.type=this.options=this.enabled=this.timeout=this.hoverState=this.$element=null,this.init("tooltip",a,b)};b.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1},b.prototype.init=function(b,c,d){this.enabled=!0,this.type=b,this.$element=a(c),this.options=this.getOptions(d);for(var e=this.options.trigger.split(" "),f=e.length;f--;){var g=e[f];if("click"==g)this.$element.on("click."+this.type,this.options.selector,a.proxy(this.toggle,this));else if("manual"!=g){var h="hover"==g?"mouseenter":"focusin",i="hover"==g?"mouseleave":"focusout";this.$element.on(h+"."+this.type,this.options.selector,a.proxy(this.enter,this)),this.$element.on(i+"."+this.type,this.options.selector,a.proxy(this.leave,this))}}this.options.selector?this._options=a.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},b.prototype.getDefaults=function(){return b.DEFAULTS},b.prototype.getOptions=function(b){return b=a.extend({},this.getDefaults(),this.$element.data(),b),b.delay&&"number"==typeof b.delay&&(b.delay={show:b.delay,hide:b.delay}),b},b.prototype.getDelegateOptions=function(){var b={},c=this.getDefaults();return this._options&&a.each(this._options,function(a,d){c[a]!=d&&(b[a]=d)}),b},b.prototype.enter=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type);return clearTimeout(c.timeout),c.hoverState="in",c.options.delay&&c.options.delay.show?void(c.timeout=setTimeout(function(){"in"==c.hoverState&&c.show()},c.options.delay.show)):c.show()},b.prototype.leave=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type);return clearTimeout(c.timeout),c.hoverState="out",c.options.delay&&c.options.delay.hide?void(c.timeout=setTimeout(function(){"out"==c.hoverState&&c.hide()},c.options.delay.hide)):c.hide()},b.prototype.show=function(){var b=a.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){if(this.$element.trigger(b),b.isDefaultPrevented())return;var c=this,d=this.tip();this.setContent(),this.options.animation&&d.addClass("fade");var e="function"==typeof this.options.placement?this.options.placement.call(this,d[0],this.$element[0]):this.options.placement,f=/\s?auto?\s?/i,g=f.test(e);g&&(e=e.replace(f,"")||"top"),d.detach().css({top:0,left:0,display:"block"}).addClass(e),this.options.container?d.appendTo(this.options.container):d.insertAfter(this.$element);var h=this.getPosition(),i=d[0].offsetWidth,j=d[0].offsetHeight;if(g){var k=this.$element.parent(),l=e,m=document.documentElement.scrollTop||document.body.scrollTop,n="body"==this.options.container?window.innerWidth:k.outerWidth(),o="body"==this.options.container?window.innerHeight:k.outerHeight(),p="body"==this.options.container?0:k.offset().left;e="bottom"==e&&h.top+h.height+j-m>o?"top":"top"==e&&h.top-m-j<0?"bottom":"right"==e&&h.right+i>n?"left":"left"==e&&h.left-i<p?"right":e,d.removeClass(l).addClass(e)}var q=this.getCalculatedOffset(e,h,i,j);this.applyPlacement(q,e),this.hoverState=null;var r=function(){c.$element.trigger("shown.bs."+c.type)};a.support.transition&&this.$tip.hasClass("fade")?d.one(a.support.transition.end,r).emulateTransitionEnd(150):r()}},b.prototype.applyPlacement=function(b,c){var d,e=this.tip(),f=e[0].offsetWidth,g=e[0].offsetHeight,h=parseInt(e.css("margin-top"),10),i=parseInt(e.css("margin-left"),10);isNaN(h)&&(h=0),isNaN(i)&&(i=0),b.top=b.top+h,b.left=b.left+i,a.offset.setOffset(e[0],a.extend({using:function(a){e.css({top:Math.round(a.top),left:Math.round(a.left)})}},b),0),e.addClass("in");var j=e[0].offsetWidth,k=e[0].offsetHeight;if("top"==c&&k!=g&&(d=!0,b.top=b.top+g-k),/bottom|top/.test(c)){var l=0;b.left<0&&(l=-2*b.left,b.left=0,e.offset(b),j=e[0].offsetWidth,k=e[0].offsetHeight),this.replaceArrow(l-f+j,j,"left")}else this.replaceArrow(k-g,k,"top");d&&e.offset(b)},b.prototype.replaceArrow=function(a,b,c){this.arrow().css(c,a?50*(1-a/b)+"%":"")},b.prototype.setContent=function(){var a=this.tip(),b=this.getTitle();a.find(".tooltip-inner")[this.options.html?"html":"text"](b),a.removeClass("fade in top bottom left right")},b.prototype.hide=function(){function b(){"in"!=c.hoverState&&d.detach(),c.$element.trigger("hidden.bs."+c.type)}var c=this,d=this.tip(),e=a.Event("hide.bs."+this.type);return this.$element.trigger(e),e.isDefaultPrevented()?void 0:(d.removeClass("in"),a.support.transition&&this.$tip.hasClass("fade")?d.one(a.support.transition.end,b).emulateTransitionEnd(150):b(),this.hoverState=null,this)},b.prototype.fixTitle=function(){var a=this.$element;(a.attr("title")||"string"!=typeof a.attr("data-original-title"))&&a.attr("data-original-title",a.attr("title")||"").attr("title","")},b.prototype.hasContent=function(){return this.getTitle()},b.prototype.getPosition=function(){var b=this.$element[0];return a.extend({},"function"==typeof b.getBoundingClientRect?b.getBoundingClientRect():{width:b.offsetWidth,height:b.offsetHeight},this.$element.offset())},b.prototype.getCalculatedOffset=function(a,b,c,d){return"bottom"==a?{top:b.top+b.height,left:b.left+b.width/2-c/2}:"top"==a?{top:b.top-d,left:b.left+b.width/2-c/2}:"left"==a?{top:b.top+b.height/2-d/2,left:b.left-c}:{top:b.top+b.height/2-d/2,left:b.left+b.width}},b.prototype.getTitle=function(){var a,b=this.$element,c=this.options;return a=b.attr("data-original-title")||("function"==typeof c.title?c.title.call(b[0]):c.title)},b.prototype.tip=function(){return this.$tip=this.$tip||a(this.options.template)},b.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},b.prototype.validate=function(){this.$element[0].parentNode||(this.hide(),this.$element=null,this.options=null)},b.prototype.enable=function(){this.enabled=!0},b.prototype.disable=function(){this.enabled=!1},b.prototype.toggleEnabled=function(){this.enabled=!this.enabled},b.prototype.toggle=function(b){var c=b?a(b.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type):this;c.tip().hasClass("in")?c.leave(c):c.enter(c)},b.prototype.destroy=function(){clearTimeout(this.timeout),this.hide().$element.off("."+this.type).removeData("bs."+this.type)};var c=a.fn.tooltip;a.fn.tooltip=function(c){return this.each(function(){var d=a(this),e=d.data("bs.tooltip"),f="object"==typeof c&&c;(e||"destroy"!=c)&&(e||d.data("bs.tooltip",e=new b(this,f)),"string"==typeof c&&e[c]())})},a.fn.tooltip.Constructor=b,a.fn.tooltip.noConflict=function(){return a.fn.tooltip=c,this}}(jQuery),+function(a){"use strict";var b=function(a,b){this.init("popover",a,b)};if(!a.fn.tooltip)throw new Error("Popover requires tooltip.js");b.DEFAULTS=a.extend({},a.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),b.prototype=a.extend({},a.fn.tooltip.Constructor.prototype),b.prototype.constructor=b,b.prototype.getDefaults=function(){return b.DEFAULTS},b.prototype.setContent=function(){var a=this.tip(),b=this.getTitle(),c=this.getContent();a.find(".popover-title")[this.options.html?"html":"text"](b),a.find(".popover-content")[this.options.html?"string"==typeof c?"html":"append":"text"](c),a.removeClass("fade top bottom left right in"),a.find(".popover-title").html()||a.find(".popover-title").hide()},b.prototype.hasContent=function(){return this.getTitle()||this.getContent()},b.prototype.getContent=function(){var a=this.$element,b=this.options;return a.attr("data-content")||("function"==typeof b.content?b.content.call(a[0]):b.content)},b.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")},b.prototype.tip=function(){return this.$tip||(this.$tip=a(this.options.template)),this.$tip};var c=a.fn.popover;a.fn.popover=function(c){return this.each(function(){var d=a(this),e=d.data("bs.popover"),f="object"==typeof c&&c;(e||"destroy"!=c)&&(e||d.data("bs.popover",e=new b(this,f)),"string"==typeof c&&e[c]())})},a.fn.popover.Constructor=b,a.fn.popover.noConflict=function(){return a.fn.popover=c,this}}(jQuery),+function(a){"use strict";var b='[data-dismiss="alert"]',c=function(c){a(c).on("click",b,this.close)};c.prototype.close=function(b){function c(){f.trigger("closed.bs.alert").remove()}var d=a(this),e=d.attr("data-target");e||(e=d.attr("href"),e=e&&e.replace(/.*(?=#[^\s]*$)/,""));var f=a(e);b&&b.preventDefault(),f.length||(f=d.hasClass("alert")?d:d.parent()),f.trigger(b=a.Event("close.bs.alert")),b.isDefaultPrevented()||(f.removeClass("in"),a.support.transition&&f.hasClass("fade")?f.one(a.support.transition.end,c).emulateTransitionEnd(150):c())};var d=a.fn.alert;a.fn.alert=function(b){return this.each(function(){var d=a(this),e=d.data("bs.alert");e||d.data("bs.alert",e=new c(this)),"string"==typeof b&&e[b].call(d)})},a.fn.alert.Constructor=c,a.fn.alert.noConflict=function(){return a.fn.alert=d,this},a(document).on("click.bs.alert.data-api",b,c.prototype.close)}(jQuery),function(a){"use strict";a.extend({simpleWeather:function(b){b=a.extend({location:"",woeid:"2357536",unit:"f",success:function(){},error:function(){}},b);var c=new Date,d="//query.yahooapis.com/v1/public/yql?format=json&rnd="+c.getFullYear()+c.getMonth()+c.getDay()+c.getHours()+"&diagnostics=true&callback=?&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&q=";if(""!==b.location)d+='select * from weather.forecast where woeid in (select woeid from geo.placefinder where text="'+b.location+'" and gflags="R") and u="'+b.unit+'"';else{if(""===b.woeid)return b.error("Could not retrieve weather due to an invalid location."),!1;d+="select * from weather.forecast where woeid="+b.woeid+' and u="'+b.unit+'"'}return a.getJSON(encodeURI(d),function(c){null!==c&&null!==c.query.results&&"Yahoo! Weather Error"!==c.query.results.channel.description?a.each(c.query.results,function(a,c){-1!==c.constructor.toString().indexOf("Array")&&(c=c[0]);var d=["N","NNE","NE","ENE","E","ESE","SE","SSE","S","SSW","SW","WSW","W","WNW","NW","NNW","N"],e=d[Math.round(c.wind.direction/22.5)];if(c.item.condition.temp<80&&c.atmosphere.humidity<40)var f=-42.379+2.04901523*c.item.condition.temp+10.14333127*c.atmosphere.humidity-.22475541*c.item.condition.temp*c.atmosphere.humidity-6.83783*Math.pow(10,-3)*Math.pow(c.item.condition.temp,2)-5.481717*Math.pow(10,-2)*Math.pow(c.atmosphere.humidity,2)+1.22874*Math.pow(10,-3)*Math.pow(c.item.condition.temp,2)*c.atmosphere.humidity+8.5282*Math.pow(10,-4)*c.item.condition.temp*Math.pow(c.atmosphere.humidity,2)-1.99*Math.pow(10,-6)*Math.pow(c.item.condition.temp,2)*Math.pow(c.atmosphere.humidity,2);else var f=c.item.condition.temp;if("f"===b.unit)var g="c",h=Math.round(5/9*(c.item.condition.temp-32)),i=Math.round(5/9*(c.item.forecast[0].high-32)),j=Math.round(5/9*(c.item.forecast[0].low-32)),k=Math.round(5/9*(c.item.forecast[1].high-32)),l=Math.round(5/9*(c.item.forecast[1].low-32)),m=Math.round(5/9*(c.item.forecast[1].high-32)),n=Math.round(5/9*(c.item.forecast[1].low-32)),o=Math.round(5/9*(c.item.forecast[2].high-32)),p=Math.round(5/9*(c.item.forecast[2].low-32)),q=Math.round(5/9*(c.item.forecast[3].high-32)),r=Math.round(5/9*(c.item.forecast[3].low-32)),s=Math.round(5/9*(c.item.forecast[4].high-32)),t=Math.round(5/9*(c.item.forecast[4].low-32));else var g="f",h=Math.round(1.8*c.item.condition.temp+32),i=Math.round(1.8*c.item.forecast[0].high+32),j=Math.round(1.8*c.item.forecast[0].low+32),k=Math.round(1.8*(c.item.forecast[1].high+32)),l=Math.round(1.8*(c.item.forecast[1].low+32)),m=Math.round(1.8*(c.item.forecast[1].high+32)),n=Math.round(1.8*(c.item.forecast[1].low+32)),o=Math.round(1.8*(c.item.forecast[2].high+32)),p=Math.round(1.8*(c.item.forecast[2].low+32)),q=Math.round(1.8*(c.item.forecast[3].high+32)),r=Math.round(1.8*(c.item.forecast[3].low+32)),s=Math.round(1.8*(c.item.forecast[4].high+32)),t=Math.round(1.8*(c.item.forecast[4].low+32));var u={title:c.item.title,temp:c.item.condition.temp,tempAlt:h,code:c.item.condition.code,todayCode:c.item.forecast[0].code,units:{temp:c.units.temperature,distance:c.units.distance,pressure:c.units.pressure,speed:c.units.speed,tempAlt:g},currently:c.item.condition.text,high:c.item.forecast[0].high,highAlt:i,low:c.item.forecast[0].low,lowAlt:j,forecast:c.item.forecast[0].text,wind:{chill:c.wind.chill,direction:e,speed:c.wind.speed},humidity:c.atmosphere.humidity,heatindex:f,pressure:c.atmosphere.pressure,rising:c.atmosphere.rising,visibility:c.atmosphere.visibility,sunrise:c.astronomy.sunrise,sunset:c.astronomy.sunset,description:c.item.description,thumbnail:"//l.yimg.com/a/i/us/nws/weather/gr/"+c.item.condition.code+"ds.png",image:"//l.yimg.com/a/i/us/nws/weather/gr/"+c.item.condition.code+"d.png",tomorrow:{high:c.item.forecast[1].high,highAlt:k,low:c.item.forecast[1].low,lowAlt:l,forecast:c.item.forecast[1].text,code:c.item.forecast[1].code,date:c.item.forecast[1].date,day:c.item.forecast[1].day,image:"//l.yimg.com/a/i/us/nws/weather/gr/"+c.item.forecast[1].code+"d.png"},forecasts:{one:{high:c.item.forecast[1].high,highAlt:m,low:c.item.forecast[1].low,lowAlt:n,forecast:c.item.forecast[1].text,code:c.item.forecast[1].code,date:c.item.forecast[1].date,day:c.item.forecast[1].day,image:"//l.yimg.com/a/i/us/nws/weather/gr/"+c.item.forecast[1].code+"d.png"},two:{high:c.item.forecast[2].high,highAlt:o,low:c.item.forecast[2].low,lowAlt:p,forecast:c.item.forecast[2].text,code:c.item.forecast[2].code,date:c.item.forecast[2].date,day:c.item.forecast[2].day,image:"//l.yimg.com/a/i/us/nws/weather/gr/"+c.item.forecast[2].code+"d.png"},three:{high:c.item.forecast[3].high,highAlt:q,low:c.item.forecast[3].low,lowAlt:r,forecast:c.item.forecast[3].text,code:c.item.forecast[3].code,date:c.item.forecast[3].date,day:c.item.forecast[3].day,image:"//l.yimg.com/a/i/us/nws/weather/gr/"+c.item.forecast[3].code+"d.png"},four:{high:c.item.forecast[4].high,highAlt:s,low:c.item.forecast[4].low,lowAlt:t,forecast:c.item.forecast[4].text,code:c.item.forecast[4].code,date:c.item.forecast[4].date,day:c.item.forecast[4].day,image:"//l.yimg.com/a/i/us/nws/weather/gr/"+c.item.forecast[4].code+"d.png"}},city:c.location.city,country:c.location.country,region:c.location.region,updated:c.item.pubDate,link:c.item.link};b.success(u)}):b.error(null===c.query.results?"An invalid WOEID or location was provided.":"There was an error retrieving the latest weather information. Please try again.")}),this}})}(jQuery),function(a){function b(a){return Modernizr.sessionstorage?sessionStorage.getItem(a):null}function c(a,b){return Modernizr.sessionstorage?(sessionStorage.setItem(a,b),!0):!1}String.prototype.hashCode=function(){var a,b,c,d=0;if(0===this.length)return d;for(a=0,b=this.length;b>a;a++)c=this.charCodeAt(a),d=(d<<5)-d+c,d|=0;return d};var d={};a.clientCache=function(e,f,g){var h="undefined"!=typeof g?g:"html",i=e+"_"+("c@che"+e).hashCode()+h;return d[i]||(d[i]=a.Deferred(function(a){var d=b(i);if(d){var e="json"===h?JSON.parse(d):d;return void a.resolve(e)}a.done(function(a){var b="json"===h?JSON.stringify(a):a;c(i,b)}),f(a)}).promise()),d[i]},a.clientCacheBust=function(a,b){var c="undefined"!=typeof b?b:"html",d=a+"_"+("c@che"+a).hashCode()+c;sessionStorage.removeItem(d)}}(jQuery),function(a,b){var c=this,d=a(document),e=a("body"),f=a("#siteSettings"),g=a("#sidebarLeft"),h=a("#sidebarRight");"undefined"!=typeof b&&b.backgroundsize&&a("[data-background]").each(function(b,c){a(c).css("backgroundImage","url("+c.getAttribute("data-background")+")")}),this.transitionEnd="transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",e.hasClass("edit-mode")?a(".sidebars").removeAttr("data-load"):(e.hasClass("cms-admin")&&sessionStorage.clear(),d.on(c.transitionEnd,"#cL1",function(b){if(b.target===this){var f=e.outerWidth();f>=1200&&g.attr("data-load")&&a.clientCache("leftSidebar",function(b){a.get(g.attr("data-load"),function(a){b.resolve(a)},"html")}).done(function(a){g.append(a).removeAttr("data-load"),g.trigger("sidebar_left_open")}),f>=1334&&a.clientCache("rightSidebar",function(b){a.get(h.attr("data-load"),function(a){b.resolve(a)},"html")}).done(function(a){h.append(a).removeAttr("data-load"),d.off(c.transitionEnd,"#cL1")})}})),d.on("sidebar_left_open",function(){a.clientCache("weatherData",function(b){a.simpleWeather({zipcode:"83002",unit:"f",success:function(a){b.resolve(a)}})},"json").done(function(b){a(".panel-body","#sidebarLeft .weatherWidget").empty().append(function(){return'<img src="'+b.thumbnail+'" />'+b.temp+"&deg;"+b.units.temp+' &nbsp;<span class="badge">'+b.currently+"</span>"})})}),a("#cL1").trigger("transitionend"),d.on("click","#openSettings, #closeSettings",{el:f},function(a){a.data.el.toggleClass("opend")}),f.on("click",".setFontSize",function(){var b=a(this).attr("data-zoom");return"default"===b?void e.removeAttr("data-zoom"):void e.attr("data-zoom",b)}),d.on("click",".modalize",function(b){b.preventDefault();var c=a(this),d=c.attr("href");return d.length?void a.get(d,{modal:!0},function(b){var c=a(b);c.appendTo(e).modal()},"html"):void alert("Unable to load requested page.")}),d.popover({animation:!1,selector:".showPopover",trigger:"hover",placement:function(){return this.$element.attr("data-placement")||"top"},container:"body"}).tooltip({animation:!1,selector:".showTooltip",trigger:"hover focus",placement:function(){return this.$element.attr("data-placement")||"top"},container:"body"}),a.ajax({url:a("#tojAppPaths").attr("data-tools")+"_data/current",dataType:"json",cache:!1,success:function(b){var c=b.criticals?"text-danger":b.warnings?"text-warning":"text-success",d=b.criticals?"fa-exclamation-triangle":b.warnings?"fa-exclamation-circle":"fa-check-circle";a(".status-alert-icon","#primaryNav").find("i.fa").replaceWith('<i class="fa '+c+" "+d+'" />');var e=a('<div class="alertGroup" />');b.criticals&&(a.each(b.criticals,function(a,b){e.append('<a class="alert alert-danger" href="'+b.path+'"><i class="fa fa-exclamation-triangle"></i><span> '+b.name+"</span></a>")}),a.clientCacheBust("leftSidebar")),b.warnings&&(a.each(b.warnings,function(a,b){e.append('<a class="alert alert-warning" href="'+b.path+'"><i class="fa fa-exclamation-circle"></i><span>'+b.name+"</span></a>")}),a.clientCacheBust("leftSidebar")),a(".alert",e).length||e.append('<a class="alert alert-success no-icon"><span>No warnings or critical alerts are currently issued.</span></a>'),a("h5.updating","#primaryNav").replaceWith(e),a(".status-alert-icon","#primaryNav .navbar-header").popover({animation:!1,html:!0,placement:"bottom",title:"Current Alerts",content:e.clone(),trigger:"click",container:"#primaryNav"})}}),a(".toggle-posts").on("click.deptpagination",function(){var b=a(this),c=a(".body-content","#cPageContent"),d=a("#deptPostsContainer");if(b.hasClass("minimize"))return void c.removeClass("posts-view");if(b.hasClass("expand")&&c.addClass("posts-view"),d.data("all_posts_loaded")!==!0){var e=d.attr("data-deptid"),f=d.attr("data-deptpath"),g=+(d.data("pagination")||2);d.data("pagination",g+1),a.get(f+"_load_posts/"+e+"/"+g,function(b){return b.length?void a(".list-group","#deptPostsContainer").append(b):(a(".toggle-posts.view-more").empty().append('<strong class="text-success"><i class="fa fa-check-circle-o"></i> All Posts Loaded!</strong>'),void d.data("all_posts_loaded",!0))},"html")}}),d.on("eventclick.schedulizer",function(b,c){a.get(a("#tojAppPaths").attr("data-tools")+"schedulizer_event_view",{eventID:c.id},function(b){var c=a(b);c.appendTo(e).modal()},"html")}),a(".sociable","#cPageContent").is(":visible")&&(e.append('<div id="fb-root"></div>'),function(a,b,c){var d,e=a.getElementsByTagName(b)[0];a.getElementById(c)||(d=a.createElement(b),d.id=c,d.src="//connect.facebook.net/en_US/all.js#xfbml=1&status=0",e.parentNode.insertBefore(d,e))}(document,"script","facebook-jssdk"),function(a,b,c){var d,e=a.getElementsByTagName(b)[0];a.getElementById(c)||(d=a.createElement(b),d.id=c,d.src="https://platform.twitter.com/widgets.js",e.parentNode.insertBefore(d,e))}(document,"script","twitter-wjs")),jQuery.extend(jQuery.easing,{easeInSine:function(a,b,c,d,e){return-d*Math.cos(b/e*(Math.PI/2))+d+c},easeInExpo:function(a,b,c,d,e){return 0===b?c:d*Math.pow(2,10*(b/e-1))+c},easeOutExpo:function(a,b,c,d,e){return b===e?c+d:d*(-Math.pow(2,-10*b/e)+1)+c}})}(jQuery,Modernizr||{});