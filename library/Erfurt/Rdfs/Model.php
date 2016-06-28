<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012-2016, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */


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
        return new Erfurt_Rdfs_Resource($resourceIri, $this);
    }
}

