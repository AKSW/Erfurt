<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Interface for Serializer implementations.
 * 
 * @copyright  Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @package    Erfurt_Syntax_RdfSerializer_Adapter
 * @author     Philipp Frischmuth <pfrischmuth@googlemail.com>
 */
interface Erfurt_Syntax_RdfSerializer_Adapter_Interface
{   
    /**
     * Serializes a given graph.
     *  
     * @param string $graphUri
     * @param bool $pretty
     * @param bool $useAc
     * 
     * @return string
     */ 
    public function serializeGraphToString($graphUri, $pretty = false, $useAc = true);
    
    /**
     * Serializes a given resource in a given graph.
     *  
     * @param string $resourceUri
     * @param string $graphUri
     * @param bool $pretty
     * @param bool $useAc
     * 
     * @return string
     */
    public function serializeResourceToString($resourceUri, $graphUri, $pretty = false, $useAc = true);
}
