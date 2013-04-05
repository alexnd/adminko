/*
Adminko client-side part
*/
if('undefined'==typeof(console)) var console={'log':function(s){alert(s);}};
if('undefined'==typeof($g)) var $g={};
if('object'==typeof($g) && 'undefined'==typeof($g['adminko_uri'])) $g['adminko_uri']='/adminko';
if('object'==typeof($g) && 'undefined'!=typeof($)) $(document).ready(function() {

//jquery serialization method
if('undefined'==typeof($.fn.serializeObject)) $.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

// supply events for controls in modal containers
$g.adminko_apply_modal_controls = function() {

    $('#adminko-modal-button-save').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id'),
            module = $(this).attr('data-module'),
            clb = 'adminko_onsave_' + module;
        if('function'!==typeof($g[clb])) {
            //TODO: base code for form validation, aggreating, and ajax post
        } else {
            $g[clb].call(this, id, function(){
                $('#adminko-modal-button-save').attr({'data-id':'', 'data-module':''});
                $('#adminko-modal-container').modal('hide');
                $g.adminko_apply_controls();
            });
        }
        return false;
    });

    $('#adminko-modal-button-delete').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id'),
            module = $(this).attr('data-module'),
            ts = new Date().getTime(),
            url = $g.adminko_uri + '/module/' + module + '/' + id;
        $.ajax(url, {'type':'DELETE', 'data':{'ts':ts}, 'dataType':'json', 'success':function() {
            $('#adminko-modal-button-delete').attr({'data-module':'', 'data-id':''});
            $('#adminko-modal-container').modal('hide');
            clb = 'adminko_render_' + module;
            if('function'===typeof($g[clb])) $g[clb].call(this);
        }});
        return false;
    });

    $('#adminko-modal-button-cancel').click(function(e) {
        e.preventDefault();
        $('#adminko-modal-button-delete').attr({'data-id':'', 'data-module':''});
        $('#adminko-modal-button-save').attr({'data-id':'', 'data-module':''});
        $('#adminko-modal-container').modal('hide');
        return false;
    });
}

// supply events for controls on a page
$g.adminko_apply_controls = function() {

    //TODO: fixme!
    $('.adminko-editor-button').click(function() {
        var id = $(this).attr('data-id'),
            ts = new Date().getTime(),
            url = $g.adminko_uri + '/editor/' + id;
        $.get(url, {'ts':ts}, function(s) {
            $('#modal-content').html(s);
            setTimeout(function() {
                $('#adminko-modal-container').modal();
            }, 1200);
        }, 'html');
        return false;
    });

    $('.adminko-module-button').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id'),
            module = $(this).attr('data-module'),
            ts = new Date().getTime(),
            url = $g.adminko_uri + '/module/' + module + '/' + id;
        $('#adminko-modal-header-content').text(
            ((id) ? $('#adminko-modal-header-content').attr('data-edit-msg') :
            $('#adminko-modal-header-content').attr('data-create-msg'))
        );
        $('#adminko-modal-button-save').attr({'data-id' : $(this).attr('data-id'), 'data-module' : $(this).attr('data-module')});
        $('#adminko-modal-button-delete').hide();
        $('#adminko-modal-button-save').show();
        $.get(url, {'ts':ts}, function(s) {
            $('#adminko-modal-content').html(s);
            // there is no way to work with dom mutation events since April 2013
            // still looking: http://stackoverflow.com/questions/5416822/dom-mutation-events-replacement/13835369
            // so timer solution will be used
            setTimeout(function() {
                $('#adminko-modal-header').show();
                $('#adminko-modal-content').show();
                $('#adminko-modal-container').modal();
            }, 1200);
        }, 'html');
        return false;
    });

    $('.adminko-module-delete-button').click(function(e) {
        e.preventDefault();
        $('#adminko-modal-content').hide();
        $('#adminko-modal-button-save').hide();
        $('#adminko-modal-header-content').text( $('#adminko-modal-header-content').attr('data-delete-msg') );
        $('#adminko-modal-button-delete').attr({'data-id' : $(this).attr('data-id'), 'data-module' : $(this).attr('data-module')});
        $('#adminko-modal-button-cancel').attr('data-delete-trigger', 1);
        $('#adminko-modal-header').show();
        $('#adminko-modal-button-delete').show();
        $('#adminko-modal-container').modal();
        return false;
    });
}

// example for supply your module
/*
$g.adminko_render_<module> = function() {
    $('#<module>_content').load('/<module>/partial', function(){
        $g.adminko_apply_controls();
    });
    $g.adminko_apply_blog();
}

$g.adminko_onsave_<module> = function(id, clb) {
    var data = $('#adminko-form-<module>').serializeObject();
    data.is_ajax = 1;
    data.ts = new Date().getTime();
    $.post($g.adminko_uri + '/module/<module>/' + id, data, function(r){
        if('function'!==typeof(clb)) clb.call(this);
        $g.adminko_render_<module>();
    }, 'json');
}
*/

$g.adminko_apply_modal_controls();
$g.adminko_apply_controls();

});