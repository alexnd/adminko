<?php defined('SYSPATH') or die('No direct script access.');?>
<div id="adminko-modal-container" class="modal hide fade in" style="display: none">
    <div id="adminko-modal-header" class="modal-header" style="display:none;">
        <a class="close" data-dismiss="modal">×</a>
        <h3 id="adminko-modal-header-content" data-create-msg="<?=__('Create record')?>" data-edit-msg="<?=__('Edit record')?>" data-delete-msg="<?=__('Delete record')?>"></h3>
    </div>
    <div id="adminko-modal-content" class="modal-body"></div>
    <div id="adminko-modal-buttons" class="modal-footer">
        <a href="#" id="adminko-modal-button-delete" class="btn btn-success" data-id="" data-module="" style="display:none;"><?=__('Delete')?></a>
        <a href="#" id="adminko-modal-button-save" class="btn btn-success" data-id="" data-module=""><?=__('Save')?></a>
        <a href="#" id="adminko-modal-button-cancel" class="btn" data-dismiss="modal" data-delete-trigger=""><?=__('Cancel')?></a>
    </div>
</div>