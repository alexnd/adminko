<?php /*
шаблон "модальное окно на весь экран"
*/
defined('SYSPATH') or die('No direct script access.');?>
<??>
<!DOCTYPE html>
<html xml:lang="<?=substr(I18n::$lang, 0, 2)?>" lang="<?=substr(I18n::$lang, 0, 2)?>">
<head>
<meta charset="utf-8"/>
<title><?=isset($title)?$title:''?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<?if(isset($styles) && count($styles))foreach($styles as $s){?>
<link rel="stylesheet" href="<?=$s?>">
<?}?>
<?if(isset($content_css)){?>
<style type="text/css">
<?=$content_css?>
</style>
<?}?>
<?if(isset($scripts) && count($scripts))foreach($scripts as $s){?>
<script type="text/javascript" src="<?=$s?>"></script>
<?}?>
</head>
<body class="adminko-body">
<?=isset($content)?$content:''?>
<?if(isset($content_js)){?>
<script type="text/javascript" language="javascript">
<?=$content_js?>
</script>
<?}?>
</body>
</html>