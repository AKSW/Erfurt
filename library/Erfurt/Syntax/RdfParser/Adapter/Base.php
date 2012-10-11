<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * serves as the abstract base class for rdf parser adapters. and handles the base URI of parsed files. 
 * great pun...
 * @package   Erfurt_Syntax_RdfParser_Adapter
 * @copyright Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

abstract class Erfurt_Syntax_RdfParser_Adapter_Base implements Erfurt_Syntax_RdfParser_Adapter_Interface
{
    protected $_baseUri = null;
    
    const TYPE_FILE = 'file';
    const TYPE_URL = 'url';
    const TYPE_STRING = 'string';

    protected function _setLocalFileBaseUri($filename)
    {
        if ($filename === null) {
            $filename = '';
        }
        $this->_setBaseUri('file://' . str_replace(' ', '%20', dirname($filename)) . DIRECTORY_SEPARATOR);
    }
    
    protected function _setURLBaseUri($uri)
    {
        if (strrpos($uri, '#') !== false) {
            $baseUri = substr($uri, 0, strrpos($uri, '#') + 1);
        } else {
            $baseUri = substr($uri, 0, strrpos($uri, '/') + 1);
        }
        $this->_setBaseUri($baseUri);
    }

    public function getBaseUri()
    {
        if (null !== $this->_baseUri) {
            return $this->_baseUri;
        } else {
            return false;
        }
    }
    
    protected function _setBaseUri($baseUri)
    {
        $this->_baseUri = $baseUri;
    }
}

