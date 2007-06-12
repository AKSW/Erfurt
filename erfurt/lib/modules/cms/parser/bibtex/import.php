<?php
// includes
include('../../../../include.php');
include('bibtex.php');

if(!empty($_FILES['source']['tmp_name']) && is_uploaded_file($_FILES['source']['tmp_name']))
{

	// parse bibtex file 
	$bib_elements = parsefile($_FILES['source']['tmp_name']);
//print_R($bib_elements);exit;
	// save bibtex entries
	for($i=0;$i<count($bib_elements);$i++) 
	{	
		foreach($bib_elements[$i] as $key=>$val) 
		{			
			$key=trim($key);
			$val=trim($val);
			if($key=="type") 
			{
				$class=$_ET['rdfsmodel']->getClass('http://purl.org/net/nknouf/ns/bibtex#'.$val);			
			} 
			elseif($key=='uname') 
			{
				$instance=new $_ET['rdfsmodel']->instance($val,$_ET['rdfsmodel']);
				$stms=$_ET['rdfsmodel']->find($instance,$GLOBALS['RDF_type'],NULL);			
				if($stms->triples) {
					echo '<br />The given name is not allowed: '.$val;
					exit;
				}
				echo '<br />Bibtex-Instance added: '.$val;
				flush();
				$instance->setClass($class);
				$class->addInstance($instance);						
			} 

			elseif(strlen($key)) 
			{
				if($p=$class->listProperties()) 
					foreach($p as $cl)
						foreach($cl as $prop){	
						//echo $prop->getLocalName().'<br>';
							if($prop->getLocalName()=='bibtex:'.$key)
								$instance->setPropertyValue($prop,$val);
						}
			}

	
	
		}
	}

}
?>
<p><b><?= pwl_("Bibtex File:") ?></b><br />
<form method="post" enctype="multipart/form-data">
<input type="file" value="" name="source" /><br /><br />
<input type="submit" value="<?=pwl_('Submit')?>" onclick="powl.wait(this)" />
</form>
