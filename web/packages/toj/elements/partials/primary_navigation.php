<div id="primaryNav" class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo $this->url('/'); ?>">Town Of Jackson</a>
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span><span class="hidden-phone">Navigation</span> <i class="icon-reorder"></i></span>
            </a>
            <div class="nav-collapse collapse">
                <ul id="primaryNavList" class="nav pull-right">
                    <li><a>Government</a>
                        <div class="subMenu">
                            <div class="container-fluid">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <?php $a = new GlobalArea('Nav Menu 1 Left'); $a->display($c); ?>
                                    </div>
                                    <div class="span6">
                                        <?php $a = new GlobalArea('Nav Menu 1 Right'); $a->display($c); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a>About Jackson</a>
                        <div class="subMenu">
                            <div class="container-fluid">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <?php $a = new GlobalArea('Nav Menu 2 Left'); $a->display($c); ?>
                                    </div>
                                    <div class="span6">
                                        <?php $a = new GlobalArea('Nav Menu 2 Right'); $a->display($c); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a>Services</a><!-- fold "Emergency Services" into this -->
                        <div class="subMenu">
                            <div class="container-fluid">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <?php $a = new GlobalArea('Nav Menu 3 Left'); $a->display($c); ?>
                                    </div>
                                    <div class="span6">
                                        <?php $a = new GlobalArea('Nav Menu 3 Right'); $a->display($c); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a>Contact</a>
                        <div class="subMenu">
                            <div class="container-fluid">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <?php $a = new GlobalArea('Nav Menu 4 Left'); $a->display($c); ?>
                                    </div>
                                    <div class="span6">
                                        <?php $a = new GlobalArea('Nav Menu 4 Right'); $a->display($c); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--<li><a><i class="icon-facebook-sign"></i><i class="icon-twitter-sign"></i><i class="icon-google-plus-sign"></i></a></li>-->
                    <li><a><i class="icon-warning-sign" style="color:#66CC00;"></i> Timely Info.</a>
                        <div class="subMenu">
                            <?php $a = new GlobalArea('Nav Menu 5'); $a->display($c); ?>
                        </div>
                    </li>
                    <li><a><i class="icon-cogs" style="color:#999;"></i><!--<i class="icon-facebook-sign"></i><i class="icon-twitter-sign"></i><i class="icon-google-plus-sign"></i>--></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php if( $c->isEditMode() ): ?>
    <script type="text/javascript">
        // to make hover menus easily editable...
        $(function(){
            $('li > a', '#primaryNavList').on('click', function(_clickEvent){
                _clickEvent.preventDefault(); // prevent from following
                $(this).parent('li').toggleClass('persist');
            });
        });
    </script>
<?php endif; ?>
