<?php

include('../../include.php');

if(empty($_SESSION['PWL']['cms']['language']))
{
	$_SESSION['PWL']['cms']['language']='de';
}
if(!empty($_POST['clanguage']))
{
	$_SESSION['PWL']['cms']['language']=$_POST['clanguage'];
}
pwlHTMLHeaderTree();


$languages=$_ET['rdfsmodel']->listLanguages();
if($languages) 
{
	$show=array('Names'=>'Names');
	echo('<form name="cms_language" action="" method="POST">Language: <select name="clanguage" onChange="document.cms_language.submit();">');
	foreach($languages as $l) 
	{
		if($l)
		{
			$show[$l]= $l;
			$sel='';
			if($l==$_SESSION['PWL']['cms']['language']) $sel=' SELECTED';
			echo '<option value="'.$l.'"'.$sel.'>'.$l.'</option>';
		}
	}
	//echo '<option value="de">de</option>';
	//echo '<option value="en">en</option>';
	echo '</select>';
	
	echo('</form>');
}

echo '<hr noshade="noshade" />';

$tv='treeviewJS';
$t=new treeViewJSPage();
echo '<script language="JavaScript" src="scripts.js"></script>';
echo $t->show(); 


?>

<hr noshade="noshade" />


<form name="pageform">

<a href="#" onClick="newPage('<?php echo urlencode($_ET['rdfsmodel']->getBaseURI()) ?>','sibling');"><img src="../../images/item_ltr.png" align="absmiddle">&nbsp;<?= pwl_("Add Page") ?></a><br />
<a href="#" onClick="if(confirm('<?= pwl_('Do you really want to delete this object?') ?>')) parent.frames['details'].location.href=document.getElementById('tree'+<?=$tv?>.selected).href+'&action=remove';"><img src="../../images/item_ltr.png" align="absmiddle">&nbsp;<?= pwl_("Remove") ?></a><br /><br />
<a href="#" onClick="openWebsite('<?php echo $_SESSION['PWL']['cms']['language']; ?>');"><img src="../../images/item_ltr.png" align="absmiddle">&nbsp;<?= pwl_('Preview') ?></a><br />
<a href="templates/index.php" target="blank_"><img src="../../images/item_ltr.png" align="absmiddle">&nbsp;<?= pwl_('Show website') ?></a>
</form>

<hr noshade="noshade" />
<a href="parser/bibtex/import.php" target="details"><img src="../../images/item_ltr.png" align="absmiddle">&nbsp;<?= pwl_('Import Bibtex-File') ?></a><br>
<!--<a href="parser/vcal/example.php" target="details"><img src="../../images/item_ltr.png" align="absmiddle">&nbsp;<?= pwl_('Import vCal-File') ?></a><br>//-->
<a href="parser/vcard/import.php" target="details"><img src="../../images/item_ltr.png" align="absmiddle">&nbsp;<?= pwl_('Import vCard-File') ?></a><br>

<? pwlHTMLFooter(); ?>
