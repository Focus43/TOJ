<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="iframeWrap">
    <iframe name="iFrameable-<?php echo $this->controller->bID; ?>"></iframe>
</div>

<form class="execIframe" action="<?php echo SUPER_BLOCKS_TOOLS_URL; ?>ace_code_editor/run-iframe" method="post" target="iFrameable-<?php echo $this->controller->bID; ?>">
    <div class="aceEditorWrap"<?php echo ($this->controller->height >= 0) ? ' style="height:'.$this->controller->height.'px;"' : ''; ?>>
<pre id="aceEditor-<?php echo $this->controller->bID; ?>" class="aceInstance">
<?php echo $this->controller->content; ?>
</pre>
    </div>

    <button type="button" class="btn btn-success">Run</button>
    <textarea name="code" style="display:none;"></textarea>
    <?php echo Loader::helper('form')->hidden('iframeBlockID', $this->controller->bID); ?>
</form>
