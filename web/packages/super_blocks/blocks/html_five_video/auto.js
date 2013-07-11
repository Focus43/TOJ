$(function(){
	$('#videoOpts').chosen();
	
	/**
	 * Popovers and tooltips
	 */
	$(document).popover({
		animation: false,
		selector: '.poptip',
		trigger: 'hover',
		placement: function(){
			return this.$element.attr('data-placement') || 'top';
		}
	}).tooltip({
		animation: false,
		selector: '.thetooltip',
		trigger: 'hover focus',
		placement: 'top'
	});
	
});
