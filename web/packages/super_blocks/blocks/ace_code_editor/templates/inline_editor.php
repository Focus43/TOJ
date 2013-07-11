<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="aceEditorWrap"<?php echo ($this->controller->height >= 0) ? ' style="height:'.$this->controller->height.'px;"' : ''; ?>>
<pre id="aceEditor-<?php echo $this->controller->bID; ?>" class="aceInstance">
<?php echo $this->controller->content; ?>
</pre>
</div>
