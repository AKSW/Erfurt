<?php
/**
 * @package   syntax
 * @author    Philipp Frischmuth <pfrischmuth@googlemail.com>
 * @copyright Copyright (c) 2008 {@link http://aksw.org aksw}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version   $Id:$
 */
interface Erfurt_Syntax_RdfParser_Adapter_Interface
{
    //public function parseFromDataString($dataString);
    //public function parseFromFileHandle($fileHandle);
    //public function parseFromDataStringToStore($dataString, $modelUri);
    public function parseFromFileHandleToStore($fileHandle, $modelUri);
}
