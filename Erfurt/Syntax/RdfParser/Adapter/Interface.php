<?php
/**
 * @package   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id$
 */
interface Erfurt_Syntax_RdfParser_Adapter_Interface
{
    public function parseFromDataString($dataString);
    public function parseFromFilename($filename);
    public function parseFromUrl($url);
    
    public function parseFromDataStringToStore($dataString, $graphUri);
    public function parseFromFilenameToStore($filename, $graphUri);
    public function parseFromUrlToStore($filename, $graphUri);
    
    public function reset();
}
