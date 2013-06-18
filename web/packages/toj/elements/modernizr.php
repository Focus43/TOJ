<script type="text/javascript">
	Modernizr.load([
		{
			test: Modernizr.mq('only all'),
			nope: '<?php echo Loader::helper('html')->javascript('libs/shims/respond.min.js', 'toj')->file; ?>',
			complete: function(){
			    if( typeof(respond) !== 'undefined' ){
			        respond.update();
			    }
			}
		},
		{
			test: Modernizr.placeholder,
			nope: '<?php echo Loader::helper('html')->javascript('libs/shims/placeholder.min.js', 'toj')->file; ?>',
			complete: function(){
				if( typeof(Placeholders) != 'undefined' ){
					Placeholders.init();
				}
			}
		},
		{
		    test: Modernizr.backgroundsize,
		    nope: '<?php echo Loader::helper('html')->javascript('libs/shims/backstretch.js', 'toj')->file; ?>',
		    complete: function(){
		        if( typeof($) !== 'undefined' && $.isFunction($.backstretch) ){
		            $('[data-background]').each(function(idx, element){
                        $(element).backstretch( element.getAttribute('data-background') );
                    });
		        }
		    }
		}
	]);
</script>
