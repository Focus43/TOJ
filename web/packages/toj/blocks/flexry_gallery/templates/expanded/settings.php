<?php
$templateHelper; /** @var BlockTemplateHelper $templateHelper */
$formHelper = Loader::helper('form'); /** @var FormHelper $formHelper */
?>

<?php Loader::packageElement('alert_crop_fit', 'flexry'); ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="2">Settings</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Height</td>
        </tr>
        <tr>
            <td><?php echo $formHelper->text($templateHelper->field('height'), FlexryBlockTemplateOptions::valueOrDefault($templateHelper->value('height'), 250), array('placeholder' => '250', 'class' => 'input-block')); ?></td>
        </tr>
    </tbody>
</table>