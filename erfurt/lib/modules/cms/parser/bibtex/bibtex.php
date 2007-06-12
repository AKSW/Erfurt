<?php



function parsefile($_file)
{
	$f='';
	$fid=file($_file);
	for($i=0;$i<count($fid);$i++) 
		if(strlen(trim($fid[$i])))
			$f.= trim($fid[$i]).' ';
	$f='} '.$f;
	$f=str_replace("'","`",$f);
	$f=str_replace("\"","`",$f);	
	$f=trim($f);		
	// strip illegal @	
	$f=str_replace('}@','#####',$f);
	$f=str_replace('} @','#####',$f);
	$f=str_replace('@','##at##',$f);
	$f=str_replace('#####','@',$f);	
	
	$entries = explode('@',$f);
	if(!count($entries)) die('No valid Bibtex.');
	for($i=1;$i<count($entries);$i++) 
	{
		$uname=explode(',',$entries[$i]);
		$uname=explode('{',$uname[0]);
		
		// Get Type
		if(!empty($uname[0]))
			$item[$i-1]['type']=strtoupper(substr($uname[0],0,1)).strtolower(substr($uname[0],1,strlen($uname[0])-1));
		// Get Name
		if(!empty($uname[1]))
			$item[$i-1]['uname']=$uname[1];
			
		// Get Description...content...etc				
		$contents=explode('=',$entries[$i]);
		
		for($j=0;$j<count($contents)-1;$j++)
		{
			$keys=explode(',',$contents[$j]);			
			$key=trim($keys[count($keys)-1]);			
		
				if($j<count($contents)-2) {
					$vals = explode(',',$contents[$j+1]); 
					$val='';
					if(!empty($vals[0])) {
						for($k=0;$k<count($vals)-1;$k++)
							$val.= $vals[$k].', ';
						$val = str_replace('}}','}',$val);
						$val = str_replace('} }','}',$val);
						$val = trim(substr($val,0,strlen($val)-2));
					}
				} else {							
					$val = substr($contents[$j+1],0,strlen($contents[$j+1])-1);					
					$val = trim(str_replace('}}','}',$val));
					$val = trim(str_replace('} }','}',$val));
				}
			// stroke {} an ``				
			if(strlen($val) && ($val[0]=='{' && $val[strlen($val)-1]=='}') || ($val[0]=='`' && $val[strlen($val)-1]=='`'))
				$val = substr($val,1,strlen($val)-2);
			
			$_key='has'.strtoupper(substr($key,0,1)).strtolower(substr($key,1,strlen($key)-1));
			if(strtolower($_key)=='hasurl')
				$_key='hasURL';

			if(strtolower($_key)=='hasisbn')
				$_key='hasISBN';
			
			if(strtolower($_key)=='hasissn')
				$_key='hasISSN';

			if(strtolower($_key)=='haslccn')
				$_key='hasLCNN';


			$item[$i-1][$_key]=str_replace('##at##','@',$val);
		}
	}
	return $item;
}


// old funcion
function parsefile2($uploadfile)
{

	$fid=fopen ($uploadfile,'r');
	$fsize=@filesize($uploadfile);
        $count=-1;
	$lineindex=0;
        while(!feof($fid))
        {
                if (feof($fid)){break;}
                $line=trim(fgets($fid,$fsize));
                $line=str_replace("'","`",$line);
                $seg=str_replace("\"","`",$line);
                $ps=strpos($seg,'=');
                $segtest=strtolower($seg);
                if (strpos($segtest,'@string')!==false) {continue;}
                if (strpos($seg,'%%')!==false) {continue;}
        
        	if ($seg[0]=='@')
        	{
        	        $count++;
        	        $ps=strpos($seg,'@');
        	        $pe=strpos($seg,'{');
        	        $uname=explode(',',trim(substr($seg, $pe+1)));
        	        
        	        
        	        $type[$count]=trim(substr($seg, 1,$pe-1));
        	        $item[$count]['type']=strtoupper(substr($type[$count],0,1)).strtolower(substr($type[$count],1,strlen($type[$count])-1));
        	        $item[$count]['u_name']=$uname[0];
        	        
        	        $fieldcount=-1; 
        	} 
        
        	elseif ($ps!==false )
        	{
        	        $ps=strpos($seg,'=');
        	        $fieldcount++;
        	        $var[$fieldcount]=strtolower(trim(substr($seg,0,$ps)));
        	        if ($var[$fieldcount]=='pages')
        	        {
        	                $ps=strpos($seg,'=');
        	                $pm=strpos($seg,'--');
        	                $pe=strpos($seg,'},');
        	                $pagefrom[$count]= substr($seg,$ps,$pm-$ps);
        	                $pageto[$count]=substr($seg,$pm,$pe-$pm);
        	        }
        	        $pe=strpos($seg,'},');
        	        if ($pe ===false)
        	        { 
        	        	$value[$fieldcount]=strstr($seg,'='); 
        	        }
        	        else
                	{ 
                		$value[$fieldcount]=substr($seg,$ps,$pe);
                	}
        	}
        	else
        	{
        	        $pe=strpos($seg,'},');
        	        if ($pe ===false)
        	        { 
        	        	$value[$fieldcount].=' '.strstr($seg,' '); 
        	        }
                	else
                	{ 
                		$value[$fieldcount].=' '.substr($seg,$ps,$pe);
                	}
        	}
        	
        	if(!empty($value) && !empty($value[$fieldcount])) 
        	{
        		$v=$value[$fieldcount];
        		$v=str_replace('=','',$v);
        		$v=str_replace('{','',$v);
        		$v=str_replace('}','',$v);
        		$v=str_replace(',',' ',$v);
        		$v=str_replace('\'',' ',$v);
        		$v=str_replace('\"',' ',$v);
        		$v=trim($v);
        		$keyName = 'has'.strtoupper(substr($var[$fieldcount],0,1)).strtolower(substr($var[$fieldcount],1,strlen($var[$fieldcount])-1));
        		$item[$count][$keyName]=$v;
        	}
        	
        	$lineindex++;
        }


	return($item);




}
?>