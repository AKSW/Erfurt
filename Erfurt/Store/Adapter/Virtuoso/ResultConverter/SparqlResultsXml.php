<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Creates an application/sparql-results+xml-compliant string out of
 * an Erfurt extended format array.
 *
 * @category Erfurt
 * @package Store_Adapter_Virtuoso_ResultConverter
 * @author Norman Heino <norman.heino@gmail.com>
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Store_Adapter_Virtuoso_ResultConverter_SparqlResultsXml
{
    /**
     * @var the xml render template
     */
    const TEMPLATE_NAME = 'XmlTemplate.pxml';
    
    /**
     * @var the result 'head' key
     */
    protected $head = null;
    
    /**
     * @var the result 'results' key
     */
    protected $results = null;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    }
    
    /**
     * Converts the array supplied into an application/sparql-results+xml format string.
     *
     * @param $extendedArray An array in Erfurt extended format.
     * @return string
     */
    public function convert(Array $extendedArray)
    {
        if (!isset($extendedArray['head']) or !isset($extendedArray['results'])) {
            require_once 'Erfurt/Store/Adapter/Virtuoso/ResultConverter/Exception.php';
            throw new Erfurt_Store_Adapter_Virtuoso_ResultConverter_Exception(
                'Supplied array is not a valid Erfurt extended format array.');
        }
        
        // convert to object for easier template handling and inject
        $this->head    = (object) $extendedArray['head'];
        $this->results = (object) $extendedArray['results'];
        
        // render template
        ob_start();
        include self::TEMPLATE_NAME;
        $xml = ob_get_clean();
        
        return $xml;
    }
}