
	var aceBlockEditor = function( _jsDirPath ){

		function runAce(){
			var editor = ace.edit('aceBlockEditor'),
				$input = $('textarea[name="content"]', '#editorWrap');
			editor.setTheme('ace/theme/twilight');
			editor.getSession().setMode('ace/mode/html');
			editor.getSession().setTabSize(2);
			editor.getSession().setUseSoftTabs(true);
			editor.getSession().on('change', function(){
				$input.val( editor.getValue() );
			});
			// attach ace editor to editorWrap .data
			$('#editorWrap').data('aceEditor', editor);
			// fullscreen key binding
			editor.commands.addCommand({
				name: 'fullScreen',
				bindKey: {win: 'Alt-F', mac: 'Alt-F'},
				exec: function(editor){
					$('#editorWrap').toggleClass('full-screen');
					editor.resize();
				}
			})
		}
		
		typeof(ace) === 'object' ? runAce() : (function(){
			$.getScript( _jsDirPath + 'ace.js', function(){
				console.log('ace editor loaded');
				ace.config.set('modePath', _jsDirPath);
				ace.config.set('workerPath', _jsDirPath);
				ace.config.set('themePath', _jsDirPath);
				runAce();
			});
		})();
		
	}
