<?php defined('SYSPATH') or die('No direct script access.');?>
<?/*шаблон "форма редактирования"*/?>
<textarea style="width:99%;height:90%;border:1px solid #000;background:#fff;padding:2px" id="editor_code"><?=isset($content)?$content:""?></textarea>

<div style="height:9%">
    <div style="padding:5px">
        <a href="#" id="a_editor_save" data-id="<?=isset($id)?$id:''?>"><?=__('Save')?> <?=isset($id)?$id:''?></a>
        &nbsp;
        <a href="#" id="a_editor_close"><?=__('Cancel')?></a>
    </div>
</div>

<script>
$(document).ready(function(){

    $('#a_editor_save').click(function(){
        var nd = $(this).attr('data-id'),
                nt = $(this).attr('data-type'),
                s = $('#editor_code').val(),
                u = $g.adminko_uri + '/editor/' + nd,
                ts = Math.random();
        if(nd) {
            $.post(u, {
                'content':s,
                'ts':ts
            }, function(resp) {
                $('#basic-modal-content').modal('hide');
                //console.log('editor responce', resp);
                //if(nt != 'js' && nt != 'css') $('#c_content_'+nd).html(resp);
                //console.log(typeof nt);
                if('string' == typeof nt && 'js' == nt) {
                    $.getScript(u + '?content=1&ts=' + ts);
                }
                else if('string' == typeof nt && 'css' == nt && $.browser.msie) {
                    $('<link>')
                            .appendTo($('head'))
                            .attr({type : 'text/css', rel : 'stylesheet'})
                            .attr('href', u + '?content=1&ts=' + ts);
                }
                else {
                    $('#c_content_'+nd).html(resp);
                }
            }, 'html');
        }
        return false;
    });

    $('#a_editor_close').click(function(){
        $('#basic-modal-content').modal('hide');
        return false;
    });

});
</script>