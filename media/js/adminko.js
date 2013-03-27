/*
Adminko client-side part
TODO: wrap as JQuery plugin
*/
if('undefined'==typeof(console)) var console={'log':function(s){alert(s);}};
if('undefined'==typeof($g)) var $g={};
if('object'==typeof($g) && 'undefined'==typeof($g['adminko_uri'])) $g['adminko_uri']='/adminko';
if('object'==typeof($g) && 'undefined'!=typeof($)) $(document).ready(function() {

$('.editor-button').click(function() {
    //TODO: put admin controller path to $g in view
    var id = $(this).attr('data-id'),
        type = $(this).attr('data-type'),
        ts = Math.random(),
        url = $g.adminko_uri + '/editor/' + id;
    $.get(url, {'ts':ts}, function(resp) {
        //console.log('editor-button:',resp);
        //explanation: http://www.w3resource.com/twitter-bootstrap/modals-tutorial.php
        var mc = $('#basic-modal-content');
        if(mc.length) {
            mc.html(resp);
            mc.css('height', ($(window).height()-100)+'px');
            //$('#basic-modal-content').show();
            mc.modal({
                containerCss: {
                    width: ($(window).width()-100),
                    height: ($(window).height()-80)
                },
                onShow: function(){
                    $('#editor_code').css('height', ($(window).height()-120)+'px');
                    $('#a_editor_save').attr('data-type', nt);
                }
            });
        }
    }, 'html');
    return false;
});

});