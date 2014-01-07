<style type="text/css">
    .agenda-view {display:none;}
    .agenda-view.active {display:block;}
    a.agenda-view {color:#FFFF99;text-align:center;padding-top:10px;}
    a.agenda-view:hover {color:#FFFF99;}
</style>

<div class="row">
    <div class="col-sm-3 innerSidebar">
        <?php
        $bt = BlockType::getByHandle('autonav');
        $bt->controller->orderBy                = 'display_asc';
        $bt->controller->displayPages 			= 'custom';
        $bt->controller->displayPagesCID        = Page::getByPath('/government')->getCollectionID();
        $bt->controller->displaySubPages 		= 'none';
        $bt->controller->displaySubPageLevels 	= 'enough';
        $bt->render('templates/sidebar');

        $a = new Area('Sidebar Content'); $a->display($c);
        ?>
    </div>
    <div class="col-sm-9">
        <div id="postList" class="panel panel-default">
            <div class="panel-heading" style="background:#3b3b3b;">
                <select id="agendaSelector" class="form-control">
                    <option value="tc">Town Council Meeting Agendas</option>
                    <option value="pz">Planning &amp; Zoning Commission / Board of Adjustment Meeting Agendas</option>
                </select>
                <a class="agenda-view active" data-show-on="tc" href="http://archive.townofjackson.com/agendas/index.cfm?fuseaction=displayTownCouncil&contentID=76&navID=76" target="_blank">Browse Archived Town Council Agendas (2007-2013)</a>
                <a class="agenda-view" data-show-on="pz" href="http://archive.townofjackson.com/agendas/index.cfm?fuseaction=displayPlanningCommissions&contentID=77&navID=78" target="_blank">Browse Archived PZCBA Agendas (2007-2013)</a>
            </div>

            <!-- town council -->
            <div class="list-group agenda-view active" data-show-on="tc" >
                <?php foreach($townCouncilAgendas AS $pageObj):
                    Loader::packageElement('partials/agenda_list_item', 'toj', array('pageObj' => $pageObj));
                endforeach; ?>
            </div>
            <div class="panel-footer agenda-view active" data-show-on="tc" >
                <button data-list="tc" data-src="<?php echo $this->action('load_more'); ?>" class="btn btn-info btn-block btnLoadMoreAgendas">
                    <i class="fa fa-retweet"></i> Load More
                </button>
            </div>

            <!-- planning zoning -->
            <div class="list-group agenda-view" data-show-on="pz">
                <?php foreach($planningZoningAgendas AS $pageObj):
                    Loader::packageElement('partials/agenda_list_item', 'toj', array('pageObj' => $pageObj));
                endforeach; ?>
            </div>
            <div class="panel-footer agenda-view" data-show-on="pz">
                <button data-list="pz" data-src="<?php echo $this->action('load_more'); ?>" class="btn btn-info btn-block btnLoadMoreAgendas">
                    <i class="fa fa-retweet"></i> Load More
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Push function onto stack that gets executed by the TOJ library *after* everything is loaded.
    (function( _stack ){
        _stack.push(function(){
            $('#agendaSelector').on('change', function(){
                var $this = $(this),
                    _val  = $this.val();
                $('.agenda-view', '#postList').removeClass('active').filter('[data-show-on="'+_val+'"]').addClass('active');
            });

            $('.btnLoadMoreAgendas').on('click.paging', function(){
                var $this = $(this),
                    _page = +($this.data('paging') || 2);
                // auto-incr the paging data attr even before querying
                $this.data('paging', _page + 1);
                // fetch via ajax
                $.get( $this.attr('data-src') + _page, {list: $this.attr('data-list')}, function( _html ){
                    if( !_html.length ){
                        $this.replaceWith('<strong class="text-success"><i class="fa fa-check-circle-o"></i> All Agendas Loaded</strong>');
                        $this.off('click.paging');
                        return;
                    }

                    $this.parents('.agenda-list').find('.list-group').append(_html);
                }, 'html');
            });
        });
        window.tojOnLoad = _stack;
    }( window.tojOnLoad || [] ));
</script>