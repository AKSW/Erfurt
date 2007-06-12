<?php
include('../../include.php');
pwlHTMLHeaderFrameset();

	if(!$_ET['rdfsmodel']) 
	{
		echo '<body>';
		pwl_('No model selected. Please select a model first!');
		echo '</body>';
 	} 
 	else 
 	{ 

?><script language="javascript">
<!--
	parent.frames['docu'].location.href='doc/en/';
//-->
</script>
<FRAMESET cols="200,*" framespacing="0" frameborder="1" border="1">
	<FRAME src="tree.php" name="tree"/>
	<FRAME src="../../empty.php" name="details"/>
</FRAMESET><?php 

	}
pwlHTMLFooter();
?>