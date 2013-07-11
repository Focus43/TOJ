<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="codeBlock">
<div class="with-example">
<div class="actual-output">
<div class="clearfix">
<?php if( Page::getCurrentPage()->isEditMode() ){ ?>
    <div style="padding:10px;background:#e1e1e1;">Output is disabled while in edit mode.</div>
<?php }else{ ?>
    <?php echo htmlspecialchars_decode( $this->controller->content ); ?>
<?php } ?>
</div>
</div>
<pre class="linenums prettyprint">
<?php echo $this->controller->content; ?>
</pre>
</div>
</div>