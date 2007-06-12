<?php


class vCard_Import{
	function setFile($path){
		$this->vcfArray = file($path);
	}

	
### Webseite
	function getWebsiteWork(){
		$row = $this->array_search_bit("URL;WORK:", $this->vcfArray);
		if($row == FALSE)	
		{
			$row = $this->array_search_bit("URL:", $this->vcfArray);
			if($row == FALSE)	{return FALSE;}
			else{return str_replace("URL:", '',$this->vcfArray[$row]);}
		}
		else {return str_replace("URL;WORK:", '',$this->vcfArray[$row]);}
	}

	function getWebsiteHome(){
		$row = $this->array_search_bit("URL;HOME:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else				{return str_replace("URL;HOME:", '',$this->vcfArray[$row]);}
	}


### Telefon
	function getTelWork(){
		$row = $this->array_search_bit("TEL;WORK;VOICE:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else				{return str_replace("TEL;WORK;VOICE:", '',$this->vcfArray[$row]);}
	}

	function getTelHome(){
		$row = $this->array_search_bit("TEL;HOME;VOICE:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else				{return str_replace("TEL;HOME;VOICE:", '',$this->vcfArray[$row]);}
	}

### Mobilphone
	function getCellWork(){
		$row = $this->array_search_bit("TEL;CELL;VOICE:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else				{return str_replace("TEL;CELL;VOICE:", '',$this->vcfArray[$row]);}
	}

### FAX
	function getFaxWork(){
		$row = $this->array_search_bit("TEL;WORK;FAX:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else				{return str_replace("TEL;WORK;FAX:", '',$this->vcfArray[$row]);}
	}

	function getFaxHome(){
		$row = $this->array_search_bit("TEL;HOME;FAX:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else				{return str_replace("TEL;HOME;FAX:", '',$this->vcfArray[$row]);}
	}

### Pager
	function getPager(){
		$row = $this->array_search_bit("TEL;PAGER;VOICE:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else				{return str_replace("TEL;PAGER;VOICE:", '',$this->vcfArray[$row]);}
	}


### Strasse
	function getWorkStreet(){
		$row = $this->array_search_bit("ADR;WORK:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else{
			$street = str_replace("ADR;WORK:", '',$this->vcfArray[$row]);
			$StreetArray = explode(';',$street );
			return  $StreetArray[2];
		}
	}

	function getHomeStreet(){
		$row = $this->array_search_bit("ADR;HOME:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else{
			$street = str_replace("ADR;HOME:", '',$this->vcfArray[$row]);
			$StreetArray = explode(';',$street );
			return  $StreetArray[2];
		}
	}

### Stadt

	function getWorkCity(){
		$row = $this->array_search_bit("ADR;WORK:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else{
			$street = str_replace("ADR;WORK:", '',$this->vcfArray[$row]);
			$StreetArray = explode(';',$street );
			return  $StreetArray[3];
		}
	}

	function getHomeCity(){
		$row = $this->array_search_bit("ADR;HOME:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else{
			$street = str_replace("ADR;HOME:", '',$this->vcfArray[$row]);
			$StreetArray = explode(';',$street );
			return  $StreetArray[3];
		}
	}

### PLZ

	function getWorkZip(){
		$row = $this->array_search_bit("ADR;WORK:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else{
			$street = str_replace("ADR;WORK:", '',$this->vcfArray[$row]);
			$StreetArray = explode(';',$street );
			return  $StreetArray[5];
		}
	}

	function getHomeZip(){
		$row = $this->array_search_bit("ADR;HOME:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else{
			$street = str_replace("ADR;HOME:", '',$this->vcfArray[$row]);
			$StreetArray = explode(';',$street );
			return  $StreetArray[5];
		}
	}


### LAND

	function getWorkCountry(){
		$row = $this->array_search_bit("ADR;WORK:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else{
			$street = str_replace("ADR;WORK:", '',$this->vcfArray[$row]);
			$StreetArray = explode(';',$street );
			return  $StreetArray[6];
		}
	}

	function getHomeCountry(){
		$row = $this->array_search_bit("ADR;HOME:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;
		}else{
			$street = str_replace("ADR;HOME:", '',$this->vcfArray[$row]);
			$StreetArray = explode(';',$street );
			return  $StreetArray[6];
		}
	}

	function getName()
	{
		foreach($this->vcfArray as $key=>$val)
		{
			if(strstr($val,'N:') && !strstr($val,'FN') && !strstr($val,'BEGIN') && !strstr($val,'VERSION'))
			{
				return (str_replace("N:", '',$this->vcfArray[$key]));
			}
		}
	}

	function getFirstName(){
		$fname=$this->getName();
		$tmp=explode(';',$fname);
		$fname='';		
		return trim($tmp[1]);
	}

	function getLastName(){
		$lname=$this->getName();
		$tmp=explode(';',$lname);
		return trim($tmp[0]);
	}

	function getRole(){
		$role=$this->getName();
		$tmp=explode(';',$role);
		return trim($tmp[2]);
	}
	
	function getOpening(){
		$opening=$this->getName();
		$tmp=explode(';',$opening);
		return trim($tmp[3]);
	}
	
	function getBirthday(){
		$row = $this->array_search_bit("BDAY:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else				{return str_replace("BDAY:", '',$this->vcfArray[$row]);}
	}

	function getEmail(){
		$row = $this->array_search_bit("EMAIL;PREF;INTERNET:", $this->vcfArray);
		if($row == FALSE){
			$row = $this->array_search_bit("EMAIL;INTERNET;WORK:", $this->vcfArray);
			if($row == FALSE)	{return FALSE;}
			else				{return str_replace("EMAIL;INTERNET;WORK:", '',$this->vcfArray[$row]);}
			
		}else{return str_replace("EMAIL;PREF;INTERNET:", '',$this->vcfArray[$row]);}
	}
	
	function getEmailPriv(){
		#print_r($this->vcfArray[$row]);
		$row = $this->array_search_bit("EMAIL;INTERNET:", $this->vcfArray);
		if($row == FALSE){return FALSE;}
		else{return str_replace("EMAIL;INTERNET:", '',$this->vcfArray[$row]);}
	}

	function getCompany(){
		$row = $this->array_search_bit("ORG:", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else{
			$company = str_replace("ORG:", '',$this->vcfArray[$row]);
			$position =  strrpos($company,';');

			if($position == FALSE)	{return $company;}
			else					{return substr($company, 0, $position); }
		}
	}

	function getNote(){
		$row = $this->array_search_bit("NOTE;", $this->vcfArray);
		if($row == FALSE)	{return FALSE;}
		else{
			$note =  str_replace("NOTE;", '',$this->vcfArray[$row]);
			$note =  str_replace("ENCODING=QUOTED-PRINTABLE:", '',$note);
			return str_replace("=0D=0A", '',$note);
		}
	}

	function array_search_bit($search, $array_in){
   		foreach ($array_in as $key => $value)
   		{
   			if (strpos($value, $search) !== FALSE)
   			return $key;
   		}
   		return FALSE;
	}


}
?>