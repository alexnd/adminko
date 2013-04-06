<?php defined('SYSPATH') or die('No direct script access.');?>

<form class="form-horizontal" id="adminko-form-editor">
    <fieldset>
        <div class="control-group">
            <label class="control-label"><?=__('Content')?></label>
            <div class="controls" id="c_editor_content">
                <textarea id="editor_content" name="editor_content" style="width:90%;height:80%;"><?=(isset($editor_content))?htmlspecialchars($editor_content):''?></textarea>
            </div>
        </div>
    </fieldset>
</form>
