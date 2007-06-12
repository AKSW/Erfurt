<?php
/**
 * treeviewJSPage widget
 *  
 * @author Norman Beck <nbeck@panthas.de>
 * @copyright Copyright (c) 2004 
 * @access public
 **/
 

 
class treeviewJSPage extends treeviewJS 
{	
	
	var $config=array(

		'autoLoadLevels'=>0,
		'getNodesScript'=>'',
		'startNode'=>'/',
		'enableNodeAttributes'=>true,
		'baseURL' => 'cms.php?uri='
	);	
	function getNode($node='') 
	{			
					
		$site = new site($_SESSION['PWL']['cms']['language']); 
		$node_inst=$site->siteModel->instanceF($node);
		$node_name=$node_inst->getLabelForLanguage($_SESSION['PWL']['cms']['language']);
		$node_name=$node_name;
		if(!$node_name)
			$node_name=$node_inst->getLocalName();
		
		if($node) 
			$subclasses=$site->listSubPages($node);
		else 
			$subclasses=$site->listTopPages();	
		$childs=array();
				
		if(!$subclasses) 
		{
			$pp_pc = $site->getPositionForNewNode($node).','.$site->getParentForNewNode($node);
			return array($node?$node:'/',array(),$pp_pc,$node_name);
		}
		foreach($subclasses as $subclass)
		{
			$childs[]=$subclass;						
		}
		if($this->config['enableNodeAttributes'])	
		{
			$pp_pc = $site->getPositionForNewNode($node).','.$site->getParentForNewNode($node);
			return array($node?$node:'/',$childs,$pp_pc,$node_name);
		}
		else		
			return $childs;
	}
	


	
}



/**
 * site - gets the website's pages
 *  
 * @author Norman Beck <nbeck@panthas.de>
 * @copyright Copyright (c) 2004 
 * @access public
 **/
class site extends powlModule {
	
	var $language;
	var $contentUri 	= "http://powl.sf.net/WCMS/Content/0.1#";
	var $sysUri 		= "http://powl.sf.net/WCMS/SysOnt/0.1#";
	var $layoutUri 		= "http://powl.sf.net/WCMS/Layout/0.1#";
	var $structureUri 	= "http://powl.sf.net/WCMS/Structure/0.1#";
	var $siteUri		= "http://powl.sf.net/WCMS/AisSite/0.1#";	
	var $contentUris	= array("http://powl.sf.net/WCMS/Content/0.1#",
					"http://purl.org/net/nknouf/ns/bibtex#");
	var $siteModel		= "";	

	var $contentShortUri	= "content:";	
	var $layoutShortUri	= "layout:";
	var $structureShortUri	= "structure:";
	var $contentShortUris	= array("http://powl.sf.net/WCMS/Content/0.1#",
					"bibtex:");
	
	function site($lang)
	{		
		global $powl;
		$this->siteModel = $powl->getModel($this->siteUri);
		$this->contentModel = $powl->getModel($this->contentUri);
		$this->layoutModel = $powl->getModel($this->layoutUri);
		$this->structureModel = $powl->getModel($this->structureUri);
		$this->language=$lang;	
	}
	
	function loadOnModel($model) 
	{		
		return strstr($model,"/Structure/")?true:false;
	}
	/**
	 * Returns array of topnavi-elements with local names
	 * 
	 * @param
	 * @return array
	 **/	
	function listTopPages() 
	{
		global $powl;
			
		$topPages=array();
		$c = $this->siteModel->getClass($this->structureUri.'Page');				
		foreach($c->listInstances() as $pageInstance) 
		{						
			if(!$pageInstance->getPropertyValuePlain($this->structureUri.'pageChildOf')) 
				$topPages[$pageInstance->getLocalName()]=$pageInstance->getLocalName();
		}				
		foreach($c->listSubClasses() as $page) 
			foreach($page->listInstances() as $pageInstance) 
				if(!$pageInstance->getPropertyValuePlain($this->structureUri.'pageChildOf')) 
					$topPages[$pageInstance->getLocalName()]=$pageInstance->getLocalName();	
		return $topPages;	
	}
	/**
	 * Returns array of subnavi-elements with local names
	 * 
	 * @param $pageParent - name of parent element
	 * @return array
	 **/	
	function listSubPages($pageParent) 
	{
		global $powl;
		
		$c = $this->siteModel->getClass($this->structureUri.'Page');					
		foreach($c->listInstances() as $pageInstance)
		{
			if($pageInstance->getPropertyValuePlain($this->structureUri.'pageChildOf')==$this->siteModel->getBaseURI().$pageParent) 
			{
				$subPages[]=$pageInstance;
			}			
		}
		
		foreach($c->listSubClasses() as $page) 
			foreach($page->listInstances() as $pageInstance)			
				if($pageInstance->getPropertyValuePlain($this->structureUri.'pageChildOf')==$this->siteModel->getBaseURI().$pageParent) {					
					$subPages[]=$pageInstance;
			}		
		// sort by position
		$ret = array();
		if(!empty($subPages) && is_array($subPages)) 
		{
			foreach($subPages as $subPage) 
			{			
				$pagePosition = $subPage->getPropertyValuePlain($this->structureUri.'pagePosition');
				$sortedSubPages[$subPage->getLocalName()]=$pagePosition;
			
			}	
			
			natsort($sortedSubPages);
			foreach($sortedSubPages as $key=>$val) 
			{
				$ret[]=$key;
			}
		}
		return $ret;
	}
	/**
	 * Returns the parent element for a new node in the tree.	 
	 * 
	 * return value will look like this: parent1|parent2
	 * parent1= if new node will be a sibling, than the parent of $node will be parent
	 * parent2= if new node will be a child, than $node is parent
	 *
	 * @param String $node
	 * @return String possible parent elements for the node
	 **/		
	function getParentForNewNode($node)
	{
		global $powl;
		
		if(!is_a($node,'RDFSInstance'))
			$node=$this->siteModel->instanceF($node);
		
		// if new node is child of $node
		$childParent = $node->getLocalName();
		// if new node is sibling of $node
		$siblingParent = $this->getNodeParent($node);
		return $siblingParent.'|'.$childParent;
	}
	/**
	 * Returns the position for a new node in the tree.	 
	 * 
	 * return value will look like this: pos1|pos2
	 * pos1= position for new node as sibling of $node
	 * pos2= position for new node as child of $node
	 *
	 * @param String $node
	 * @return String possible positions for the node
	 **/		
	function getPositionForNewNode($node)
	{
		global $powl;
		
		if(!is_a($node,'RDFSInstance'))
			$node=$this->siteModel->instanceF($node);
		// get position for new node as sibling of this node
		$pagePosition = $node->getPropertyValuePlain($this->structureUri.'pagePosition');			
		$siblingPosition = ($pagePosition+1)/2;				
		$pageParent = $this->getNodeParent($node);
		$pageParentChildren=$this->listNaviElements($pageParent);		
		for($i=0;$i<count($pageParentChildren);$i++)
		{
			if($node->getLocalName()==$pageParentChildren[$i]->getLocalName())
			{
				if(!empty($pageParentChildren[$i+1]))
				{
					$_tmp = $pageParentChildren[$i+1]->getPropertyValuePlain($this->structureUri.'pagePosition');
					$siblingPosition = ($pagePosition+$_tmp)/2;
				}
			}
		}

		// get position for new node as child				
		$childPosition = 1;
		$nodeChildren=$this->listNaviElements($node->getLocalName());		
		if(!empty($nodeChildren[0]))
		{			
			$_tmp = $nodeChildren[0]->getPropertyValuePlain($this->structureUri.'pagePosition');
			$childPosition = $_tmp/2;
		}
		
		
		return $siblingPosition.'|'.$childPosition;
	}
	/**
	 * Returns name of the parent element for a node.
	 * 
	 * @param String $node
	 * @return String the parent node.
	 **/		
	function getNodeParent($node)
	{
		global $powl;
			
		if(!is_a($node,'RDFSInstance'))
			$node=$this->siteModel->instanceF($node);
		$pageChild = $node->getPropertyValuePlain($this->structureUri.'pageChildOf');	
		
		
		$c = $this->siteModel->getClass($this->structureUri.'Page');					
		foreach($c->listInstances() as $pageInstance)			
			if($this->siteModel->getBaseURI().$pageInstance->getLocalName()==$pageChild) {
				return $pageInstance->getLocalName();
		}		
		
		foreach($c->listSubClasses() as $page) 
			foreach($page->listInstances() as $pageInstance)			
				if($this->siteModel->getBaseURI().$pageInstance->getLocalName()==$pageChild) {
					return $pageInstance->getLocalName();
			}		
		
	}
	/**
	 * Returns the information for a node in the tree structure.
	 * This funcion is necessary to check, if a node is an instance overview. 	 
	 *
	 * @param String $node.
	 * @return String, pagetype
	 **/	
	function getPageType($node)
	{	
		global $powl;
			
		$instanceName=$node;
		if($node=='root') {
			$instanceName='Startseite';
		}
	
		$_node=$this->siteModel->instanceF($instanceName);
		$class = $_node->getClass();
				
		switch($class->getLocalName()) 
		{
			case $this->structureUri.'pageInstanceOverview':
				return 'instanceOverview';
				break;
			case 'structure:pageInstanceOverview':
				return 'instanceOverview';
				break;				
			default:
				return 'instanceDetail';
				break;			
		}
	
	}	
	/**
	 * Returns an array of navigation elements for the website recursively.
	 * 
	 * @param String $node, if no node is given, then root will be used by default.
	 * @return String the parent node.
	 **/		
	function listNaviElements($node='') 
	{
		global $powl;
			
		if(!$node) 
		{
			$node = 'Startseite';
			$nodes = $this->listSubPages($node);
		}
		else 
		{
			if($nodes = $this->listSubPages($node)) 
			{			
				foreach($nodes as $_node) 
				{
					if($childs = $this->listNaviElements($_node))
						$nodes[]=$childs;
				}
			}					
		}
		for($i=0;$i<count($nodes);$i++) 
		{
			$nodes[$i]=$this->siteModel->instanceF($nodes[$i]);
		}
		return $nodes;
	}
	
	/**
	 * Returns the generated html-code for a specified node.
	 * 
	 * @param String $node
	 * @return String the html output for the page.
	 **/	
	function getContent($node) 
	{
		global $powl;
			
		$ret = array();
		$instanceName=$node;
		if($node=='root') {
			$instanceName='Startseite';
		}
		
		// content references instances from WCMS/Content
		// get these instances
		$_instance=$this->siteModel->instanceF($instanceName);
		$prop=$this->structureModel->propertyF('pageContent');
		$content=$_instance->listPropertyValuesPlain($prop);
		
		// get content from referenced WCMS/content instances
		$tpl='';
		foreach($content as $contentInstance) 
		{
			$instanceName=$contentInstance;
			if(strstr($contentInstance,'#')) 
			{
				$instanceName=explode('#',$contentInstance);
				$instanceName=$instanceName[1];
			}
			elseif(strstr($contentInstance,':'))
			{
				$instanceName=explode(':',$contentInstance);
				$instanceName=$instanceName[1];			
			}
			$inst = $this->siteModel->instanceF($instanceName);

			if($v = $inst->listAllPropertyValuesPlain())
			{
				/* check, if content is online and approved
				if(!empty($v[$this->contentUri.'ContentStatus'][0]) && 
				   $v[$this->contentUri.'ContentStatus'][0]=='Online' && 
				   !empty($v[$this->contentUri.'ContentWorkflowStatus'][0]) && 
				   $v[$this->contentUri.'ContentWorkflowStatus'][0]=='Approved') {
					// content is online, parse template
					$tpl.= $this->renderPage($inst);
				}*/				
				$tpl.= $this->renderPage($inst,$node);
			}
 
		}
		if($node=='suche')
		{
			$tpl.= $this->renderSearchResults();
		}
		return $tpl;	
	}
	/**
	 * Returns the generated html-code for an instance.
	 * 
	 * @param RDFSInstance $inst
	 * @return String the html output for the instance.
	 **/	
	function renderPage($inst,$node='')
	{
		$tpl='';
		if(!empty($node))
		{
			$node=$this->siteModel->instanceF($node);
		}
		
		$properties=$inst->listAllPropertyValuesPlain();		
		if($class = $inst->getClass())
		{
			$tplPiece= $this->getClassTemplate($class);
		
			foreach($properties as $key=>$val) 
			{				
				// check all properties except the standards for workflow an status
				if(
				   $key!=$this->contentUri.'ContentStatus' && 
				   $key!=$this->contentUri.'ContentWorkflowStatus' &&
				   $key!=$this->structureUri.'pagePosition' &&
				   $key!=$this->structureUri.'pageChildOf' &&
				   $key!=$this->structureUri.'pagePosition' &&
				   $key!='structure:ContentStatus' && 
				   $key!='structure:ContentWorkflowStatus' &&
				   $key!='structure:pagePosition' &&
				   $key!='structure:pageChildOf' &&
				   $key!='structure:pagePosition') 
				{
				
					/*
					 workflow for muli-language support
					*/
				
					if($key==$this->contentUri.'ContentDetail' || $key=='content:ContentDetail')
					{																
						$prop = $this->siteModel->propertyF('http://powl.sf.net/WCMS/Content/0.1#ContentDetail');				
						$_val=$inst->listLiteralPropertyValuesPlain($prop,$this->language);						
						if(!empty($_val))
							$val=$_val;
					}
					if($key==$this->contentUri.'ContentTitle' || $key=='content:ContentTitle')
					{					
						$val=array();
						// name of detail instance							
						$tmp=$inst->getLabelForLanguage($this->language);						
						/* name of content class
						if(empty($tmp))
						{
							$tmp=$class->getLabelForLanguage($this->language);
						}
						*/
						// name of node (menu)
						if(empty($tmp) && !empty($node))
						{
							$tmp=$node->getLabelForLanguage($this->language);
						}
						$val[]=$tmp;	
					}
				
					if(strstr($key,'#')) $propShortName=explode('#',$key);
					elseif(strstr($key,':')) $propShortName=explode(':',$key);
					
					//$propertyValues=$inst->listPropertyValuesPlain($prop);							
					// one property-value is needed to check for instance
					if(!empty($val[0]))
						$propertyValue=$val[0];
					else
						$propertyValue='';

					if($tplPiece)
					{
						// if is an instance, than take property definition which specifies some property values from the destination instance
						if($this->isInstance($propertyValue) && strstr($tplPiece,'{{'.$propShortName[1].'}}'))
						{
							$tplPiece= str_replace('{{'.$propShortName[1].'}}', $this->renderInstanceProperty($key, $val), $tplPiece);
						}							
						// render value with property template
						$tplPiece=str_replace('{{'.$propShortName[1].'}}', $this->renderProperty($key,$val),$tplPiece);
						// render value without property template
						$tplPiece=str_replace('{'.$propShortName[1].'}',$this->renderValueSelf($val),$tplPiece);
					}
					else
					{
						// class has no template, render property value								
						$tpl.= $this->renderProperty($key,$val);
					}
				}
			}
						
			$tpl.=$tplPiece;
		}		
		$tpl = $this->renderResourceStandardProperties($inst,$tpl);
		$tpl = $this->cleanLabels($tpl);		
		return $tpl;
	}		
	/**
	 * Returns the generated html-code for an instance detail page.
	 * the instance is given by its uri.
	 * 
	 * @param String $uri
	 * @return String the html output for the instance detail.
	 **/
	function renderInstanceDetail($uri) 
	{	
		global $powl;

		$ret = array();
		$tpl='';
		// get content instances
		$inst=$this->siteModel->instanceF($uri);
		$tpl.= $this->renderPage($inst);

		return $tpl;		
	}
	/**
	 * Returns the generated html-code for an instance overview page.
	 * 
	 * @param String $node
	 * @return String the html output for the instance overview.
	 **/	
	function renderInstanceOverview($node) 
	{	
		global $powl;

		$ret = '';
		$instanceName=$node;
		if($node=='root') 
		{
			$instanceNames[]='Startseite';
		}
	
		// get content instances
		$_instance=$this->siteModel->instanceF($instanceName);
		$prop=$this->structureModel->propertyF('pageInstanceList');
		$content=$_instance->listPropertyValuesPlain($prop);
		
		foreach($content as $cont)
		{
			$_class=$this->siteModel->classF($cont);
			
			// overview main template for headline	
			if($tplName=$this->getTemplateName('TplInstanceOverviewMain',1))		
			{					
				if($className=$_class->getLabelForLanguage($this->language))
				{
					$className=$className;
					$_inst=$this->siteModel->instanceF($tplName);
					$x=$_inst->listAllPropertyValuesPlain();
					$_tpl=$x[$this->layoutUri.'templateDefinition'][0];
					if(!$_tpl) $_tpl=$x['layout:templateDefinition'][0];
					$ret.= $this->renderResourceStandardProperties($className,$_tpl);
				}
			}
			
			$instances=$_class->listInstances();
			$ret.= $this->renderClassInstancesList($instances);	
		}
		
		return $ret;
	}	
	/**
	 * Returns the default html-code for an instance overview.
	 * 
	 * @param array of RDFSInstances.
	 * @return String the html output for the instances overview.
	 **/		
	function renderClassInstancesList($instances)
	{
		global $powl;
		$ret='';
		
		// prepare main url (url of the website with current modules in query)
		$url = $_SERVER['PHP_SELF'].'?';		
		foreach($_GET as $key=>$val)
		{
			if($key!='uri') $url.=$key.'='.$val.'&';
		}
		
		if(is_array($instances))
		{
			foreach($instances as $val)
			{
				$val=$val->getLocalName();
				$val = $this->siteModel->instanceF($val);
				// get standard instance overview template
				if($tplName=$this->getTemplateName('TplInstanceOverviewElement',1))
				{
					$_inst=$this->siteModel->instanceF($tplName);
					$x=$_inst->listAllPropertyValuesPlain();
					$_tpl=$x[$this->layoutUri.'templateDefinition'][0];
					if(!$_tpl) $_tpl=$x['layout:templateDefinition'][0];					
					$_ret = $this->renderResourceStandardProperties($val,$_tpl,$url.'&uri=');
					
					$ret.=$_ret;
				}
			}
		}
		
		return $ret;
	}
	/**
	 * Returns the generated html output for a property template with its values.
	 * 
	 * @param String $propertyName.
	 * @param Array $propertyValues.
	 * @return String html-code.
	 **/	
	function renderProperty($propertyName,$propertyValues)
	{
		global $powl;

		$tplName='';
		$ret='';
		if(strstr($propertyName,'#')) $propShortName=explode('#',$propertyName);
		elseif(strstr($propertyName,':')) $propShortName=explode(':',$propertyName);
		
		
		if($tplName=$this->getTemplateName($propertyName))
		{
			$_inst=$this->siteModel->instanceF($tplName);
			$x=$_inst->listAllPropertyValuesPlain();
			$_tpl=$x[$this->layoutUri.'templateDefinition'][0];
			if(!$_tpl) $_tpl=$x['layout:templateDefinition'][0];
			$ret.=str_replace('{'.$propShortName[1].'}',$this->renderValueSelf($propertyValues),$_tpl);
		
		}
		else
		{
			$ret.='<!--- No template definition found for '.$propertyName.'//-->';
			$ret.=$this->renderValueSelf($propertyValues);
		}				
		return $ret;
	}
	
	/**
	 * Returns the generated html output for a property template with its values.
	 * The property has to be a reference on another content instance.
	 * 
	 * @param String $propertyName.
	 * @param Array $instanceProperties.
	 * @return String html-code.
	 **/		
	function renderInstanceProperty($propertyName,$instanceProperties)
	{
		global $powl;

		$tplName='';
		$ret='';		
		foreach($instanceProperties as $inst)
		{
			$instanceProperty = $this->siteModel->instanceF($inst);	
			if($tplName=$this->getTemplateName($propertyName))
			{					
				$_inst=$this->siteModel->instanceF($tplName);
				$x=$_inst->listAllPropertyValuesPlain();
				$_tpl=$x[$this->layoutUri.'templateDefinition'][0];
				if(!$_tpl) $_tpl=$x['layout:templateDefinition'][0];				
				$tplCode=$_tpl;
				
				// get property values from destination instance and replace the labels in tpl
				$v=$instanceProperty->listAllPropertyValuesPlain();
				
				foreach($v as $key=>$val)
				{										
					if(strstr($key,'#')) $keyName=explode('#',$key);
					elseif(strstr($key,':')) $keyName=explode(':',$key);
					$tplCode=str_replace('{'.$keyName[1].'}',$this->renderValueSelf($val),$tplCode);
				}
				if(strstr($tplCode,'{_ResourceUri_}'))
				{
					$url = $_SERVER['PHP_SELF'].'?';		
					foreach($_GET as $key=>$val)
					{
						if($key!='uri') $url.=$key.'='.$val.'&';
					}
										
					$_insturi=$this->siteModel->instanceF($inst);
					$instUri=$_insturi->getUri();
					$tplCode=str_replace('{_ResourceUri_}','"'.$url.'&uri='.urlencode($instUri).'"',$tplCode);
				
				}				
				$ret.=$tplCode;
			}
			else
			{
				$ret.='<!--- No template definition found for '.$propertyName.'//-->';						
			}
		}
		return $ret;
	}
	/**
	 * Parses the standard resource properties into a template if needed.
	 * Standard properties are the following (Property: {Special-Marker})
	 * 
	 * Resource URI: {_ResourceUri_} - the uri of the resource
	 * Resource local name:  {_ResourceLocalName_} - the local name of the resource
	 * Resource label name for a specified language: {_ResourceLabelName} - the label of the resource for the given language	 
	 *
	 * @param String $instance.
	 * @param String $template.
	 * @param String $link. If resource should be linked in the page than giv url in $link.
	 * @return String html-code.
	 **/	
	function renderResourceStandardProperties($instance,$template,$link='')
	{
		$ret = $template;			
		if(!is_a($instance,'Resource')) $instance=$this->siteModel->resourceF($instance);
		// link uri in page
		if(strlen($link))
		{		
			$ret=str_replace('{_ResourceUri_}',$link.urlencode($instance->getUri()),$ret);
		}
		else
		{			
			$ret=str_replace('{_ResourceUri_}',urlencode($instance->getUri()),$ret);
		}
		$ret=str_replace('{_ResourceLocalName_}',$instance->getLocalName(),$ret);
		if($v=$instance->getLabelForLanguage($this->language))
		{
			$v=$v;
			$ret=str_replace('{_ResourceLabelName_}',$v,$ret);
		}
		else
		{
			$ret=str_replace('{_ResourceLabelName_}',$instance->getLocalName(),$ret);
		}
		return $ret;
	}	
	/**
	 * Returns the values as string.
	 * Modify this function to control properties with more than 1 value.
	 * 	 
	 * @param Array $values.
	 * @return String
	 **/		
	function renderValueSelf($values)
	{	
		$ret='';
		foreach($values as $val)
			$ret.=$val.', ';
		$ret = substr($ret,0,strlen($ret)-2);
		return $ret;
	}
	/**
	 * Returns the template name for a resource (class or property).
	 * 	 
	 * @param String $resourceName.
	 * @return String name of the template
	 **/	
	function getTemplateName($resourceName,$instanceOverview=0)
	{
		global $powl;

		$tplName='';
		if(strstr($resourceName,'#'))
		{
			$_resourceName=explode('#',$resourceName);
			$resourceName=$_resourceName[1];			
		}
		elseif(strstr($resourceName,':'))
		{
			$_resourceName=explode(':',$resourceName);
			$resourceName=$_resourceName[1];			
		}		
		// find template definition
		$label = new RDFSLiteral($resourceName,$this->contentModel);
		$label->dtype='http://www.w3.org/2001/XMLSchema#string';		
		$tpl=$this->siteModel->find(NULL,$this->layoutModel->propertyF('templateResource'),NULL);

		foreach($tpl->triples as $t)
		{
			if($instanceOverview)
			{
				if($t->subj->uri==$this->siteUri.$resourceName)
				{
					$tplName=$t->subj->getLocalName();
				}			
			}
			else
			{
				foreach($this->contentUris as $_contentUri)
				{
					if($t->obj->label==$_contentUri.$resourceName)
					{
						$tplName=$t->subj->getLocalName();					
					}
				}
			}
			
		}
		return $tplName;
	}
	/**
	 * Returns the template for a class template.
	 * 
	 * @param RDFSClass $class.
	 * @return String template code for a class template.
	 **/	
	function getClassTemplate($class)
	{
		global $powl;
		
		// get template for class
		if($tplName=$this->getTemplateName($class->getLocalName()))
		{
			$_inst=$this->siteModel->instanceF($tplName);
			$x=$_inst->listAllPropertyValuesPlain();
			$_tpl=$x[$this->layoutUri.'templateDefinition'][0];
			if(!$_tpl) $_tpl=$x['layout:templateDefinition'][0];
			
			return $_tpl;	
		}
		// if class doesn't has any template, get first template from superclasses
		else
		{
			$v=$class->listSuperClasses();				
			foreach($v as $class)
			{	
				if($tplName=$this->getTemplateName($class->getLocalName()))
				{
					$_inst=$this->siteModel->instanceF($tplName);
					$x=$_inst->listAllPropertyValuesPlain();			;			
					$_tpl=$x[$this->layoutUri.'templateDefinition'][0];
					if(!$_tpl) $_tpl=$x['layout:templateDefinition'][0];					
					return $_tpl;	
				}
			}
		}
	}
	/**
	 * Strip all labels from template. This function is needed
	 * for labels witohut values.
	 * 
	 * @param String $tpl.
	 * @return String the html output.
	 **/		
	function cleanLabels($tpl)
	{
		// content labels
		$tpl=preg_replace('/\{[a-zA-Z]{1,}\}/','',$tpl);
		// labels for standard properties like uri, localname or label names
		$tpl=preg_replace('/_\{[a-zA-Z]{1,}\}_/','',$tpl);
		return $tpl;
	}	
	/**
	 * This function checks if $instanceName is an instance in the content storage.
	 *	 
	 * @param String $instanceName.
	 * @return Boolean
	 **/	
	function isInstance($instanceName)
	{
		global $powl;
		$x=0;
		$inst = $this->siteModel->instanceF($instanceName);
		$ret=$this->siteModel->find($inst,NULL,NULL);	
		foreach($ret->triples as $t) $x=1;
		return $x;
	}
	/**
	 * This function returns the generated html code for the search results.
	 *	 	 
	 * @return String
	 **/	
	function renderSearchResults()
	{
		global $powl;
		$search_query=urldecode($_REQUEST['q']);		
		$type='';
		if(!empty($_REQUEST['type']))
		{	
			$type=$_REQUEST['type'];
		}
		$ret=('<table border="0" width="100%">');
		$res = $this->search($type,$search_query);
		$class_box=array();
		
		// get classes from results
		foreach($res as $row) 
		{
			$_inst = $this->siteModel->instanceF($row['ln']);
			$_class = $_inst->getClass();
			$class_local=$_class->getLocalName();
			$class_local=str_replace($this->contentShortUri,$this->contentUri,$class_local);
			$class_local=str_replace($this->structureShortUri,$this->structureUri,$class_local);
			$class_local=str_replace($this->contentShortUris[1],$this->contentUris[1],$class_local);
			
			if(!$this->isModule($row['ln']) && !in_array($class_local,$class_box))
			{
				if($supers=$_class->listSuperClassesRecursive())
				{		
					foreach($supers as $s)
					{
						$s_name=$s->getLocalName();
						$s_name=str_replace($this->contentShortUri,$this->contentUri,$s_name);
						$s_name=str_replace($this->structureShortUri,$this->structureUri,$s_name);
						$s_name=str_replace($this->contentShortUris[1],$this->contentUris[1],$s_name);
						
						if(!in_array($s_name,$class_box))
						{
							array_push($class_box,$s_name);
						}
							
					}
				}
				$class_box[]=$class_local;
			}
		}
		
				
		// show class-chooser
		if(!empty($class_box))
		{
			$ret.='<tr><form name="search2" action="index.php?language='.$this->language.'&module=suche&q='.$search_query.'&type=class">';
			$ret.='<input type="hidden" name="language" value="'.$this->language.'">';
			$ret.='<input type="hidden" name="module" value="suche">';
			$ret.='<input type="hidden" name="q" value="'.$search_query.'">';
			$ret.='<input type="hidden" name="type" value="class">';			
			
			$ret.='<td align="right">Refine search: <select name="class" style="width: 200px;" onChange="document.search2.submit();"><option value="">All categories:</option>';
			foreach($class_box as $c)
			{	
				$c=$this->siteModel->classF($c);
				$class_local = $c->getLocalName();
				
				$class_local=str_replace($this->contentShortUri,$this->contentUri,$class_local);
				$class_local=str_replace($this->structureShortUri,$this->structureUri,$class_local);
				$class_local=str_replace($this->contentShortUris[1],$this->contentUris[1],$class_local);
				
				$class_name=$c->getLabelForLanguage($this->language);				
				if(!$class_name) $class_name=$class_local;				
								
				$sel='';								
				if($_REQUEST['class']==$class_local) $sel=' SELECTED';
				$ret.='<option value="'.$class_local.'"'.$sel.'>'.$class_name.'</option>';
			}
			$ret.='</select><br /><br /></td>';
			$ret.='</form></tr>';
		}
		
		// show search results
		foreach($res as $row) 
		{		
			$_inst = $this->siteModel->instanceF($row['ln']);
			$link = $_inst->getLabelForLanguage($this->language);
			$link = $link;
			if(!$link) $link = $_inst->getLocalName();
								
			// instance from instance-overview
			if(!$this->isModule($row['ln']))
			{
				$url = $_SERVER['PHP_SELF'].'?language='.$this->language.'&module='.$modstring[1];										
				$url='<a href="'.$url.'&uri='.urlencode($row['ln']).'" style="text-decoration: underline;">'.$link.'</a>';
				$_class=$_inst->getClass();
				$class_name=urlencode($_class->getLocalName());		
				$class_label_name=$_class->getLabelForLanguage($this->language);
				if(!$class_label_name) $class_label_name = $class_name;
				$more='&nbsp;<a href="index.php?language='.$_GET['language'].'&module=suche&type=class&class='.$class_name.'&q='.$search_query.'" style="text-decoration: underline; font-size: 8.0pt; color: #666666;">[Search in: '.$class_label_name.']</a>';
			}
			// content-module = navi-element
			else
			{
				$modstring=explode('#',$row['ln']);
				$url = $_SERVER['PHP_SELF'].'?language='.$this->language.'&module='.$modstring[1];
				$url='<a href="'.$url.'" style="text-decoration: underline;">'.$link.'</a>';				
				$more='';

			}
			$ret.= '<tr valign="top">';
			$ret.= '  <td>'.$url.' ('.$row['rel'].'%)<div style="font-size: 8.0pt;">'.$this->format_result_txt($row['txt'],$search_query);
			$ret.= $more;
			$ret.= '    </div><br /></td>'."\n";
			$ret.= '</tr>';			
		}
		$ret.=('</table>');		
		
		return $ret;
	}
	
	
	function search($type,$search_query)
	{
		global $powl;
		$ret = array();
		$model=$this->siteModel;
		if($type=='class')
		{
			$c=$this->siteModel->classF(urldecode($_REQUEST['class']));
			$related=array();
			$related[]=urldecode($_REQUEST['class']);			
						
			// fetch subclasses
			if($sub=$c->listSubClassesRecursive())
			{
				foreach($sub as $s)
				{
					$s_name=$s->getLocalName();										
					$s_name=str_replace($this->contentShortUri,$this->contentUri,$s_name);
					$s_name=str_replace($this->structureShortUri,$this->structureUri,$s_name);
					$s_name=str_replace($this->contentShortUris[1],$this->contentUris[1],$s_name);
					array_push($related,$s_name);
				}
			}
			
			$class_string='';
			foreach($related as $r)
			{
				$class_string.='s2.object=\''.$r.'\' OR ';
			}
			$class_string.='s2.object=\'\'';
			
			$sql='SELECT *,MATCH(s1.object) AGAINST (\''.$search_query.'\' /*!40001 IN BOOLEAN MODE */) AS score FROM statements s1 JOIN statements s2
			      WHERE MATCH(s1.object) AGAINST (\''.$search_query.'\' /*!40001 IN BOOLEAN MODE */) AND s1.subject=s2.subject AND s2.predicate LIKE \'%type%\'  AND ('.$class_string.') AND s1.modelID IN('.$model->getModelIds().') AND s1.object_is=\'l\'';		
		}
		else
		{			
			$sql='SELECT *,MATCH(object) AGAINST (\''.$search_query.'\' /*!40001 IN BOOLEAN MODE */) AS score FROM statements
			      WHERE MATCH(object) AGAINST (\''.$search_query.'\' /*!40001 IN BOOLEAN MODE */) AND modelID IN('.$model->getModelIds().') AND object_is=\'l\'';						
			
		}		
			
		$rs=$model->dbConn->PageExecute($sql,'','');

		
		// filter results
		$j=0;
		foreach($rs->getArray() as $row)
		{
			if(!$max_rel)
				$max_rel=$row['8'];

			if( !strstr($row[2],$this->layoutUri) &&
			    !strstr($row[2],$this->sysUri) &&
			    !strstr($row[2],$this->structureUri) && $this->isLinkableInstance($row[1]))
			{				

				if($page=$this->isContentInstance($row[1]))
				{
					$uri = $page;
				}
				else
				{
					$uri = $row[1];
				}

				$found=0;
				for($i=0;$i<count($ret);$i++)
				{
					if($ret[$i]['ln']==$uri)
					{	
						$found=1;
					}				
				}
				if(!$found)
				{
					$ret[$j]['ln']  = $uri;
					$ret[$j]['rel'] = round(100*$row['8']/$max_rel);
					$ret[$j]['txt']	= $row[3];
					$j++;			
				}
			}
		}
		
		
		return $ret;
		
	}
	// umbenennen isContentModule
	function isModule($uri)
	{
		global $powl;
		$model=$this->siteModel;
		$sql = 'SELECT * FROM statements WHERE subject LIKE \''.$uri.'\' AND predicate=\''.$this->structureUri.'pagePosition\'';				
		$rs = $model->dbConn->PageExecute($sql,'','');
		foreach($rs->getArray() as $row)
		{
			return 1;					
		}				
		return 0;	
	}
	function isContentInstance($uri)
	{
		global $powl;
		$model=$this->siteModel;
		$uri=explode('#',$uri);
		$uri='%#'.$uri[1];
		$sql = 'SELECT subject FROM statements WHERE object LIKE \''.$uri.'\' AND (predicate=\''.$this->structureUri.'pageContent\' OR predicate=\''.$this->contentUri.'pageContent\')';		
		$rs = $model->dbConn->PageExecute($sql,'','');
		foreach($rs->getArray() as $row)
		{
			return $row[0];					
		}						
	}
	function isLinkableInstance($uri)
	{
		global $powl;
		$model=$this->siteModel;
		$uri=explode('#',$uri);
		$uri='%#'.$uri[1];
		$sql = 'SELECT * FROM statements WHERE subject LIKE \''.$uri.'\' AND predicate=\''.$model->_dbId('RDF_type').'\' AND object NOT IN (\''.join('\',\'',array_keys(array_merge($model->vocabulary['Class'],$model->vocabulary['Property']))).'\')';		
		$rs = $model->dbConn->PageExecute($sql,'','');
		foreach($rs->getArray() as $row)
		{
			return $row[0];					
		}						
	}	
	function format_result_txt($txt,$search_query)
	{			
		$search_strings=array();
		$search_strings[0] = $search_query;
		if(strstr($search_query,' '))
		{
			$search_strings=explode(' ',$search_query);
		}
				
	
		$txt=strip_tags($txt);				
		$ret_txt=$txt;
		if(strlen($txt)>200)
		{
			$query_pos=strpos($txt,$search_strings[0]);		
			$ret_txt = '...'.substr($txt,($search_strings[0]-100),100);		
			$ret_txt.= ' '.substr($txt,$query_pos,100).'...';
		
		}
		
		foreach($search_strings as $st)
		{
			$st=urlencode($st);
			$ret_txt = preg_replace("/$st/ims",'<b>'.$st.'</b>',$ret_txt);
		}
		return $ret_txt;
	}
	/**
	 * This function parses a given string for special chars.
	 *	 
	 * @param String $ustring.
	 * @return $String
	 **/		
	function stripChars($ustring) 
	{
		/*
		$ustring = str_replace('\"','&quot;',$ustring);
		$ustring = str_replace('\'','&apos;',$ustring);
		*/
		return $ustring;
	}
}
?>