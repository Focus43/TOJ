<div class="row">
    <div class="col-sm-12">

        <div id="agendasList" class="panel panel-default">
            <div class="panel-heading" style="background:#3b3b3b;color:#e1e1e1;">
                <?php echo Loader::helper('form')->select('agendaSelector', $optionList, '', array('class' => 'form-control')); ?>
                <?php foreach($optionList AS $key => $value): ?>
                    <div class="extra-content <?php if($key == '_all_'){ echo 'active'; } ?>" data-key="<?php echo $key; ?>">
                        <?php $a = new Area("Agenda Content: {$value}"); $a->display($c); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="list-group">
                <?php foreach($optionList AS $key => $value): ?>
                    <div class="results <?php echo ($key == '_all_') ? 'active' : 'do-first-load';  ?>" data-page="<?php echo ($key == '_all_') ? 2 : 1; ?>" data-key="<?php echo $key; ?>">
                        <?php if($key == '_all_'){ foreach($agendaList AS $pageObj):
                            Loader::packageElement('partials/agenda_list_item', 'toj', array('pageObj' => $pageObj));
                        endforeach; } ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="panel-footer">
                <button id="btnGetMore" data-src="<?php echo $this->action('load_more'); ?>" class="btn btn-info btn-block">
                    <i class="fa fa-retweet"></i> Load More
                </button>
                <strong class="text-success"><i class="fa fa-check-circle-o"></i> No more meetings to load...</strong>
            </div>
        </div>
    </div>
</div>