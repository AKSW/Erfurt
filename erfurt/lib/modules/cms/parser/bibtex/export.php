<?php

// includes
$_POWL['deactivateLogin']=1;
include('../../../../include.php');
include('bibtex.php');

if(!empty($_GET['node']))
{
	$node = $_GET['node'];
	if(!is_a($node,'RDFSInstance')) 
	{
		$aisSite=$powl->getModel('http://powl.sf.net/WCMS/AisSite/0.1#');
		$node=$aisSite->instanceF($node);	
	}	

	$ret = '';	
	// bibtex-type
	$class 		 = $node->getClass();
	$bibtex_type=$class->getLocalName();	
	if(strstr($bibtex_type,'#'))
	{
		$_tmp=explode('#',$bibtex_type);
		$bibtex_type = $_tmp[1];
		$ret.=strtolower($bibtex_type).'{';
	}
	if(strstr($bibtex_type,':'))
	{
		$_tmp=explode(':',$bibtex_type);
		$bibtex_type = $_tmp[1];
		$ret.=strtolower($bibtex_type).'{';
	}	
	// bibtex-name
	$bibtex_name	 =$node->getLocalName();
	if(strstr($bibtex_name,'#'))
	{
		$_tmp=explode('#',$bibtex_name);
		$bibtex_name = $_tmp[1];
	}
	elseif(strstr($bibtex_name,':'))
	{
		$_tmp=explode(':',$bibtex_name);
		$bibtex_name = $_tmp[1];
	}	
	if(strlen($bibtex_name))
		$ret.=$bibtex_name.',';
	
	$ret.="\n";	
	// bibtex-values
	$node_properties = $node->listAllPropertyValuesPlain();
	
	
	foreach($node_properties as $key=>$val)
	{		
		if(!empty($val[0])) 
		{
			if(strstr($key,'#has'))
			{
				$_tmp=explode('#has',$key);
				$key = strtolower($_tmp[1]);
				$ret.=$key.'={'.$val[0].'}'.",\n";
			}
			elseif(strstr($key,'has'))
			{
				$_tmp=explode('has',$key);
				$key = strtolower($_tmp[1]);
				$ret.=$key.'={'.$val[0].'}'.",\n";
			}    			
		}
	}
	$ret = substr($ret,0,strlen($ret)-2);
	$ret.="\n}\n";
	
	// send header and generated tex-file
	header("Content-Type: application/x-tex");
	header("Content-Disposition: attachment; filename=".$bibtex_name.".tex;" );
	echo $ret;	
	exit();
}

?>