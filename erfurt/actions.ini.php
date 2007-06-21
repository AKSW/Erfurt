<?php
/**
* default configuration for actions
*/
$nsUri = 'http://ns.ontowiki.net/SysOnt/';

# login
$actionConf[$nsUri.'RegisterNewUser']['defaultGroup'] = 'http://localhost/OntoWiki/Config/DefaultUserGroup';
$actionConf[$nsUri.'RegisterNewUser']['mailvalidation'] = 'yes';
$actionConf[$nsUri.'RegisterNewUser']['uidregexp'] = '/^[[:alnum:]]+$/';
$actionConf[$nsUri.'RegisterNewUser']['passregexp'] = '/^.({6,100})$/';

# register 
$actionConf[$nsUri.'Login']['type'] = 'RDF';

return $actionConf;
?>