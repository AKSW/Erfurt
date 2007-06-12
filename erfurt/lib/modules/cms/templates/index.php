<?php
// ------------------------------------------
// includes and initialize session vars
// ------------------------------------------

ini_set('include_path','.:'.ini_get('include_path'));
$_POWL['deactivateLogin']=1;
include_once('../../../include.php');
include_once('../api/include.php');

if(!$_SESSION['_ETS']['model'])
	$_m=$powl->getModel('http://powl.sf.net/WCMS/AisSite/0.1#');
else
	$_m=$powl->getModel($_SESSION['_ETS']['model']);

// ------------------------------------------
// initialize params
// ------------------------------------------
$language='de';
$module=array();
$modstring= '';
$uri='';
$q='';

// ------------------------------------------
// fetch request
// ------------------------------------------
if (!empty($_GET['language'])) {
	$language=$_GET['language'];
}
if (!empty($_GET['module'])) {	
	$modstring = $_GET['module'];
	$module = explode("/",$_GET['module']);
	if(strstr($_GET['module'],'Startseite'.'/')) {		
		$module = explode("/",substr($_GET['module'],strlen('Startseite')+1));		
	}	
}
if (!empty($_GET['uri'])) {
	$uri=urldecode($_GET['uri']);
}
if (!empty($_GET['q'])) {
	$q=$_GET['q'];
}

$_site = new site($language);


?><html>
<head>
  <title><?php 
// ------------------------------------------
if(!empty($module[count($module)-1]))
	$contentMod = $module[count($module)-1];
else
	$contentMod = 'Startseite';

// get page title	
$site_instance = $_m->instanceF($contentMod);
$title = $site_instance->getLabelForLanguage($language);
if(!$title) $title=$site_instance->getLocalName();

echo $title;
// ------------------------------------------
  ?></title>
  <link rel="stylesheet" type="text/css" href="css/default.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script language="javascript" src="<?php echo $_POWL['uriBase']; ?>scripts.js"></script>
  <script language="javascript">
  <!--
  		powl.uribase='<?php echo $_POWL['uriBase']; ?>';
  //-->
  </script>
</head>


<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">

<table border="0" cellpadding="0" cellspacing="0" align="center" width="780">


<tr valign="top">
  <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?language=<?php echo $language; ?>"><img src="img/logo.png" width="160" height="100" border="0"></a></td>
  <td class="spacerBlue"><img src="img/spacer.gif"></td>
  <td class="spacerBlue"><table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td background="img/ais_gradient_oben.png" width="620" height="35" align="right"><img src="img/spacer.gif" width="1" height="35"><img src="img/uni_logo.png"></td>
    </tr>
    <tr>
      <td background="img/ais_gradient_unten.png"><img src="img/spacer.gif" width="620" height="25"></td>
    </tr>
    <form name="l_chooser" action="">
    <input type="hidden" name="module" value="<?php echo $modstring; ?>">
    <input type="hidden" name="uri" value="<?php echo urlencode($uri); ?>">
    <input type="hidden" name="q" value="<?php echo $q; ?>">
    <tr>
      <td class="headerNavi" height="40" align="right"><?php
// ------------------------------------------
	$language_string = '';	
	foreach($_m->listLanguages() as $l) 
	{
		if($l) $language_string.= '<a href="'.$_SERVER['PHP_SELF'].'?module='.$modstring.'&uri='.urlencode($uri).'&q='.$q.'&language='.$l.'">'.$l.'</a>&nbsp;|&nbsp;';
	}
	
	echo substr($language_string,0,strlen($language_string)-14);
// ------------------------------------------
        ?></td>
    </tr>
    </form>
    </table></td>
</tr>


<tr valign="top">
  <td class="spacerLightblue"><table border="0" cellpadding="0" cellspacing="0" width="160">
    <tr>
      <td align="center" class="subNavi"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?language=<?php echo $language; ?>">Anwendungsspezifische Informationssysteme</a></td>
    </tr>
    <form name="search" action="">
    <input type="hidden" name="language" value="<?php echo $language; ?>">
    <input type="hidden" name="module" value="suche">
    <tr>
      <td align="center" class="headerNavi"><input type="text" name="q" value="<?php echo $q; ?>" class="qSearch" size="7">&nbsp;&nbsp;<input type="submit" class="qSearchSubmit" value="Suchen"></td>
    </tr>
    </form>
    <tr>
      <td align="center" class="subNavi" height="15px"><img src="img/spacer.gif"></td>
    </tr><?php
// ------------------------------------------

$topNaviElements=$_site->listNaviElements();  
foreach($topNaviElements as $elem) 
{    

	// page is linkable?
	if($elem->getPropertyValuePlain($_site->structureUri.'pageIsLinkable'))
	{
		$linkHref=$elem->getLocalName();
		$linkName=$elem->getLocalName();
		if($elem->getLabelForLanguage($language)) {
			$linkName=$elem->getLabelForLanguage($language);
			//$linkName=$linkName->label;
		}
		$class='headerNavi';
		if(in_array($elem->getLocalName(),$module))
		{
			$class='headerNaviActive';			
		}    	
		echo '<tr>';	
		echo '  <td class="'.$class.'"><a href="'.$_SERVER['PHP_SELF'].'?language='.$language.'&module='.$linkHref.'">'.$linkName.'</a></td>';
		echo '</tr>';
		echo '<tr>';
		echo '  <td class="spacerBlue"><img src="img/spacer.gif"></td>';
		echo '</tr>';	

		$subNaviElements=$_site->listNaviElements($elem->getLocalName()); 

		foreach($subNaviElements as $subElem)
		{
			// page is linkable?
			if($subElem->getPropertyValuePlain($_site->structureUri.'pageIsLinkable'))
			{
				$subLinkHref=$subElem->getLocalName();
				$subLinkName=$subElem->getLocalName();
				if($subElem->getLabelForLanguage($language)) {
					$subLinkName=$subElem->getLabelForLanguage($language);
					//$subLinkName=$subLinkName->label;
				}
				$_subMod=$linkHref.'/'.$subLinkHref;
				$class='subNavi';			
				if(in_array($subElem->getLocalName(),$module))
				{
					$class='subNaviActive';			
				}		
				echo '<tr>';
				echo '  <td class="'.$class.'"><a href="'.$_SERVER['PHP_SELF'].'?language='.$language.'&module='.$_subMod.'">'.$subLinkName.'</a></td>';
				echo '</tr>';
				echo '<tr>';
				echo '  <td class="spacerBlue"><img src="img/spacer.gif"></td>';
				echo '</tr>';    		
			}
		}
	}
}
// ------------------------------------------
?>    
    
    <tr>
      <td class="headerNavi"><img src="img/spacer.gif"></td>
    </tr>
    </table></td>
  <td class="spacerBlue"><img src="img/spacer.gif"></td>
  <td class="content"><?php
// ------------------------------------------  

		
$pageInfo=$_site->getPageType($contentMod);

// If no uri is given, then get content from site by properties
if(!$uri)
{
	// get standard content
	$content=$_site->getContent($contentMod);

	// if overview page then get instance-list from class
	if($pageInfo=='instanceOverview')
	{
		$content.=$_site->renderInstanceOverview($contentMod);
	}	

}
// else get content from the uri-instance by its properties
else
{
	$content=$_site->renderInstanceDetail($uri);
}

echo $content;
	


// ------------------------------------------    
    ?><br /><br /></td>
</tr>



</table>


</body>

</html>