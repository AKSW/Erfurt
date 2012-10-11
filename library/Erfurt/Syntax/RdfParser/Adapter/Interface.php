<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2012, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * @package   Erfurt_Syntax_RdfParser_Adapter
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2012 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
interface Erfurt_Syntax_RdfParser_Adapter_Interface
{
    public function parseFromDataString($dataString);
    public function parseFromFilename($filename);

    public function parseFromDataStringToStore($dataString, $graphUri, $useAc = true);
    public function parseFromFilenameToStore($filename, $graphUri, $useAc = true);
    
    public function parseNamespacesFromDataString($dataString);
    public function parseNamespacesFromFilename($filename);

    public function getBaseUri();
}
