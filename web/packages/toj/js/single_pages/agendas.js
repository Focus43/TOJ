/*! Town Of Jackson; Build: v18.1.0; Author: Focus43 */
!function(a){function b(){a(".panel-footer","#agendasList").toggleClass("complete","true"==e.filter(".active").attr("data-complete"))}var c=a("#agendaSelector"),d=a(".extra-content","#agendasList"),e=a(".results","#agendasList"),f=a("#btnGetMore");c.on("change",function(){d.add(e).removeClass("active").filter('[data-key="'+this.value+'"]').addClass("active");var a=e.filter(".active");a.hasClass("do-first-load")&&(a.removeClass("do-first-load"),f.trigger("click.loader")),b()}),f.on("click.loader",function(){var d=e.filter(".active"),g=+d.attr("data-page");f.attr("disabled","disabled"),d.attr("data-page",g+1),a.get(f.attr("data-src")+g,{agendaType:c.val()},function(a){return f.removeAttr("disabled"),a.length?void d.append(a):(d.attr("data-complete","true"),void b())},"html")})}(jQuery);