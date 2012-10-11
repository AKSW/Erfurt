<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

require_once 'Erfurt/Rdf/Model.php';

/**
 * Represents a RDFS Model.
 *
 * @category   Erfurt
 * @package    Erfurt_Rdfs
 * @copyright  Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Rdfs_Model extends Erfurt_Rdf_Model
{
    /**
     * Resource factory method
     *
     * @return Erfurt_Rdfs_Resource
     */
    public function getResource($resourceIri)
    {
        require_once 'Erfurt/Rdfs/Resource.php';
        return new Erfurt_Rdfs_Resource($resourceIri, $this);
    }
}

