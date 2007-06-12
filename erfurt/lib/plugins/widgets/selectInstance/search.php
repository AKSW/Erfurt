<?
include('../../../include.php');
pwlHTMLHeaderTree();
echo('<b>'.pwl_('Search:').'</b>');
?>
<form target="classes" action="classes.php">
<input type="hidden" name="element" value="<?=$_REQUEST[element]?>" />
<input type="hidden" name="resource" value="<?=$_REQUEST[resource]?>" />
<input type="text" name="search" style="width:135px;" /><input type="submit" value="Go"/> 
</form>
<? pwlHTMLFooter(); ?>