<style type="text/css">
    #tblSelectableOptions thead tr th {white-space:nowrap;}
    #tblSelectableOptions td {text-align:center;vertical-align:middle;}
    #tblSelectableOptions tbody tr td:first-child {padding:0;}
    #tblSelectableOptions tbody tr td:last-child {width:1%;white-space:nowrap;}
    #tblSelectableOptions .mover {cursor:move;}
    #tblSelectableOptions .remove {display:inline-block;padding:4px;cursor:pointer;}
    #tblSelectableOptions .clonable {display:none;}
</style>

<table id="tblSelectableOptions" class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Key Value</th>
            <th>Display Value</th>
            <th><button id="btnClearAll" class="btn btn-mini btn-default" type="button">Clear All</button></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($optionList AS $optionObj): /** @var SelectableAttributeTypeOption $optionObj */ ?>
            <tr>
                <td><i class="mover icon-resize-vertical"></i></td>
                <td><?php echo $formHelper->text('pairs[key][]', $optionObj->getOptionKey(), array('class' => 'input-block-level', 'placeholder' => 'Key Value')); ?></td>
                <td><?php echo $formHelper->text('pairs[value][]', $optionObj->getOptionValue(), array('class' => 'input-block-level', 'placeholder' => 'Display Value')); ?></td>
                <td><a class="remove"><i class="icon-remove"></i></a></td>
            </tr>
        <?php endforeach; ?>
        <tr class="clonable">
            <td><i class="mover icon-resize-vertical"></i></td>
            <td><?php echo $formHelper->text('pairs[key][]', '', array('class' => 'input-block-level', 'placeholder' => 'Key Value')); ?></td>
            <td><?php echo $formHelper->text('pairs[value][]', '', array('class' => 'input-block-level', 'placeholder' => 'Display Value')); ?></td>
            <td><a class="remove"><i class="icon-remove"></i></a></td>
        </tr>
    </tbody>
</table>

<button id="btnAddRow" type="button" class="btn btn-default">Add Row</button>

<script type="text/javascript">
    $(function(){
        var $table    = $('#tblSelectableOptions'),
            $clonable = $('.clonable', $table);

        // create new row
        $('#btnAddRow').on('click', function(){
            $clonable.clone().insertBefore($clonable).removeClass('clonable');
        });

        // delete existing single row
        $table.on('click', '.remove', function(){
            if( confirm('Delete the selected row?') ){
                $(this).parents('tr').remove();
            }
        });

        // clear all
        $('#btnClearAll').on('click', function(){
            if( confirm('This will delete all rows (only updated after clicking Save). Continue?') ){
                $('tbody', $table).find('tr').not('.clonable').remove();
            }
        });

        // make sortable (helper code makes the rows retain their width on drag)
        $('tbody', $table).sortable({items: 'tr', handle: '.mover', containment: 'parent', tolerance: 'pointer', helper: function(_event, _tr){
            var $originals = _tr.children(),
                $helper    = _tr.clone();
            $helper.children().each(function(idx){
                $(this).width($originals.eq(idx).width());
            });
            return $helper;
        }});
    });
</script>