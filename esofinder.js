jQuery(document).ready(function($) {
	$('.esof').tooltip({ animation: true, container: 'body', delay: 0, html: true, placement: 'top',
    template: '<div class="esof-tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>', trigger: 'hover' });
	$('[data-toggle="tooltip"]').tooltip('.esof');
});
