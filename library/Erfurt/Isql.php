<?php
/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license   http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * OntoWiki utility class.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @packaget
 * @author Christian Würker <christian.wuerker@ceusmedia.de>
 */
class Erfurt_Isql
{
    static public $pathToBinary = 'isql-vt';

    /**
     * Indicates whether ISQL is executable as shell command.
     * @static
     * @access public
     * @return boolean
     */
    static public function checkSupport()
    {
        $a  = array();
        $b  = 0;
        @exec (self::$pathToBinary.' -? 1>/dev/null', $a, $b);
        return $b === 0;
    }

    /**
     * Tries to detect ISQL shell command and stores found path.
     * @static
     * @access public
     * @return boolean
     */
    static public function detectBinary()
    {
        $a  = array();
        exec ('which isql-vt || which isql', $a);
        if (count($a) > 0) {
            self::$pathToBinary = $a[0];
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Imports file using ISQL shell command.
     * @static
     * @access public
     * @return boolean
     * @throws RuntimeException if ISQL reports an error
     */
    static public function importFile($graphUri, $filepath, $server = "localhost", $port = 1111)
    {
        if (!file_exists($filepath)) {
            throw new RuntimeException('Invalid file: '.$filepath);
        }
        $filepath   = realpath( $filepath );
        $isql       = self::$pathToBinary.' '.$server.':'.$port;
        $template   = "ttlp_mt (file_to_string_output('%s'), '', '%s');";
        $command    = sprintf($template, $filepath, $graphUri);
        $a          = array();
        $b          = 0;
        @exec ('echo "'.$command.'" | '.$isql.' 2>&1', $a, $b);
        if ($b === 0) {
            $a  = array_slice($a, 5, -1);
            if (preg_match("/^Done./", $a[0])) {
                return TRUE;
            }
            if (preg_match("/ Error /", $a[0])) {
                $parts  = explode(": ", $a[0]);
                if (count($parts) > 1) {
                    $message    = join(": ", array_slice($parts, 1));
                    if (count($parts) > 2) {
                        $message    = join(": ", array_slice($parts, 2));
                    }
                }
                throw new RuntimeException($message);
            }
        }
        return FALSE;
    }
}