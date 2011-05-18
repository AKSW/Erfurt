<?php
/**
 * @package erfurt
 * @subpackage   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id: Interface.php 2929 2009-04-22 14:56:30Z pfrischmuth $
 */
interface Erfurt_Syntax_RdfParser_Adapter_Interface
{
    public function parseFromDataString($dataString);
    public function parseFromFilename($filename);
    public function parseFromUrl($url);
    
    public function parseFromDataStringToStore($dataString, $graphUri, $useAc = true);
    public function parseFromFilenameToStore($filename, $graphUri, $useAc = true);
    public function parseFromUrlToStore($filename, $graphUri, $useAc = true);
    
    public function parseNamespacesFromDataString($dataString);
    public function parseNamespacesFromFilename($filename);
    public function parseNamespacesFromUrl($url);
}
