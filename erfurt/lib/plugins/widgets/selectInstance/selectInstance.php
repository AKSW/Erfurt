<?
include('../../../include.php');
pwlHTMLHeaderFrameset(pwl_('pOWL: Select resource'));
?>
<? if(strtolower($_REQUEST['resource'])=='selectinstance' || strtolower($_REQUEST['resource'])=='selectresource') { ?>
<frameset cols="300,*" framespacing="0" frameborder="0" border="0">
<? } ?>
	<frameset rows="<?=!empty($_REQUEST['uri'])?'':'45,'?>*,45" framespacing="0" frameborder="0" border="0">
<? if(empty($_REQUEST['uri'])) { ?>
		<frame name="models" src="models.php?resource=<?=$_REQUEST['resource']?>&element=<?=urlencode($_REQUEST['element'])?>" />
<? } ?>
		<frame name="classes" src="classes.php?resource=<?=$_REQUEST['resource']?>&uri=<?=empty($_REQUEST['uri'])?'':urlencode($_REQUEST['uri'])?>&element=<?=urlencode($_REQUEST['element'])?>" />
		<frame name="search" src="search.php?resource=<?=$_REQUEST['resource']?>&element=<?=urlencode($_REQUEST['element'])?>" scrolling="no" />
	</frameset>
<? if(strtolower($_REQUEST['resource'])=='selectinstance' || strtolower($_REQUEST['resource'])=='selectresource') { ?>
	<frame name="instances" src="../../../empty.php" />
</frameset>
<? } ?>
<?
pwlHTMLFooter();
?>