<?php defined('C5_EXECUTE') or die("Access Denied.");
	$pageSelector = Loader::helper('form/page_selector');
    $formHelper   = Loader::helper('form');
?>

	<style type="text/css">
	   #weatherWidgetBlock.ccm-ui h4,
	   #buttonLink.ccm-ui .form-inline {padding:.5em 0;}
	</style>

	<div id="weatherWidgetBlock" class="ccm-ui">
		<h4>Zip Code</h4>
		<?php echo $formHelper->text('zipCode', $this->controller->zipCode, array('class' => 'input-block-level', 'placeholder' => 'Weather Area Zip Code', 'maxlength' => '5')); ?>
	</div>


