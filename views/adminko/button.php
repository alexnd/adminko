<?php defined('SYSPATH') or die('No direct script access.');?>
<?/*
 * шаблон "кнопка цмс"
 * */?>
<?if(isset($type) && ($type=='js' || $type=='css')){?>
<a href="#" class="adminko-editor-button" data-id="<?=isset($id)?$id:""?>" data-type="<?=$type?>"><?=__('Edit')?> <?=isset($id)?$id:""?> (<?=$type?>)</a>
<?}else{?>
<div id="c_content_<?=isset($id)?$id:""?>"><?=isset($content)?$content:""?></div>
 <a href="#" class="adminko-editor-button" data-id="<?=isset($id)?$id:""?>"><?=__('Edit')?> <?=isset($id)?$id:""?></a>
<?}?>