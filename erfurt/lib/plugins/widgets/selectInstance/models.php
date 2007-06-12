<?
include('../../../include.php');
pwlHTMLHeaderTree();
?>
<form target="classes" action="classes.php">
<input type="hidden" name="element" value="<?=$_REQUEST[element]?>" />
<input type="hidden" name="resource" value="<?=$_REQUEST[resource]?>" />
<select name="model" onchange="this.form.submit()" style="width:235px; background-color:#DAE0D2; font-weight:bold;">
<option><?=pwl_('Select a model')?></option>
<?
foreach($_ET[store]->listModels() as $model=>$m)
	echo('<option value="'.$model.'"'.($_SESSION['_ETS']['model']==$model?' selected':'').'>'.$model.'</option>')
?>
</select>
<input type="submit" value="Go"/> 
</form>
<? pwlHTMLFooter(); ?>