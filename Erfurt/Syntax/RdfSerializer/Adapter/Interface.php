<?php

/**
 * 
 * 
 * @package   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id$
 */
interface Erfurt_Syntax_RdfSerializer_Adapter_Interface
{    
    public function serializeResourceToString($resourceUri, $graphUri);
    public function serializeGraphToString($graphUri);
}
