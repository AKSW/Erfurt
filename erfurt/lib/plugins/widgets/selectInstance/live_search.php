id=document.getElementById('<?=$_REQUEST['id']?>');
for(i in id.options)
	id.options[i]=null;
<?
include('../../../include.php');
$is=new InstanceSearch($_ET['rdfsmodel'],$_REQUEST['q'].'*');
#$is->allModels=true;
$rs=$is->search(0,50,&$erg);
#print_r($erg);
foreach($rs->getArray() as $row) {
	if(!$max_rel)
		$max_rel=$row['7'];
	$stm=$_ET['rdfsmodel']->_convertRowToStatement($row);
#print_r($stm);
	$label=$stm->subj->getPropertyValue('rdfs:label');
	$label=$label?$label:$stm->subj->getPropertyValue('swrc:name');
	$label=$label?$label:$stm->subj->getPropertyValue('title');
	if(!$is->allModels)
		$type=$stm->subj->getType();
	echo("n=new Option('".($type?$type->getLocalName().': ':'').($label?$label->getLabel():$stm->subj->getLocalName())."','".$stm->subj->getLocalName()."'); id.options[id.options.length]=n;");
}
if($erg>10)
	echo("n=new Option('...'); id.options[id.options.length]=n;");
else if($erg==0)
	echo("n=new Option('No matches!'); id.options[id.options.length]=n;");
?>
