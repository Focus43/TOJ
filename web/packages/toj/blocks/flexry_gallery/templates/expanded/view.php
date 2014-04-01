<?php defined('C5_EXECUTE') or die("Access Denied.");
/** @var BlockTemplateHelper $templateHelper */
/** @var FlexryFileList $fileListObj */

$selectorID = sprintf('flexryExpanded-%s', $this->controller->bID);
$imageList  = $fileListObj->get();

$height = (is_numeric($templateHelper->value('height'))) ? (int)$templateHelper->value('height') : 250;
?>

    <style type="text/css">
        #<?php echo $selectorID; ?> {height:<?php echo (int)$height; ?>px;}
    </style>

    <div id="<?php echo $selectorID; ?>" class="flexry-expanded">
    <?php foreach($imageList AS $flexryFile): /** @var FlexryFile $flexryFile */ ?>
        <div class="flexry-expanded-item" style="background-image:url('<?php echo $flexryFile->fullImgSrc(); ?>');">
            <div class="flexry-expanded-inner">
                <div class="tabular">
                    <div class="cellular">
                        <div class="meta">
                            <span class="title <?php echo $titleDisplay; ?>"><?php echo $flexryFile->getTitle(); ?></span>
                            <span class="descr <?php echo $descriptionDisplay; ?>"><?php echo $flexryFile->getDescription(); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>