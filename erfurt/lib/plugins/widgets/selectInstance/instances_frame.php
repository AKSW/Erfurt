<?
include('../../../include.php');
pwlHTMLHeaderFrameset(pwl_('pOWL: Select resource'));
?>
<frameset rows="*,35" framespacing="0" frameborder="0" border="0">
	<frame name="instanceslist" src="instances.php?<?=$_SERVER['QUERY_STRING']?>" scrolling="no" />
	<frame name="instancesearch" src="instances_search.php?<?=$_SERVER['QUERY_STRING']?>" scrolling="no" />
</frameset>
<? pwlHTMLFooter(); ?>