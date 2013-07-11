<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<style type="text/css">
	.ui-dialog-content {overflow:hidden;}
	#editorWrap {position:relative;height:435px;}
	#editorWrap #aceBlockEditor { font-size:12px;font-family:monospace;margin:0;padding:0;position: absolute;top: 0;bottom: 0;left: 0;right: 0;}
	#editorWrap.full-screen {position:fixed !important;z-index:9999;width:100%;top:0;left:0;height:100% !important;min-height:100% !important;}
	label.checkbox {padding-right:6px;}
	label.checkbox input[type="checkbox"] {margin:0;}
</style>

<div id="editorWrap">
	<!-- editor -->
	<pre id="aceBlockEditor"><?php echo $this->controller->content; ?></pre>
	<textarea name="content" style="display:none;"><?php echo $this->controller->content; ?></textarea>
</div>
<div class="clearfix form-inline" style="padding-top:15px;">
    Output Height <?php echo Loader::helper('form')->text('height', $this->controller->height, array('style' => 'width:50px;', 'placeholder' => 'Height')); ?> px (Applicable to Inline Editor templates only)
</div>

<script type="text/javascript">
	$(function(){
		new aceBlockEditor('<?php echo $aceJsDirPath; ?>');		
	});
</script>
