<?php

/**
 * This file is part of the {@link http://aksw.org/Projects/Erfurt Erfurt} project.
 *
 * @copyright Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Converts Virtuoso-specific SPARQL results XML format into an 
 * array representation of the Erfurt 'extended' format.
 *
 * The array structure conforms to what would be yielded by 
 * applying json_decode to a JSON-encoded SPARQL result set
 * ({@link http://www.w3.org/TR/rdf-sparql-json-res/}).
 *
 * @category Erfurt
 * @package Store_Adapter_Virtuoso_ResultConverter
 * @author Norman Heino <norman.heino@gmail.com>
 * @copyright Copyright (c) 2008, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */
class Erfurt_Store_Adapter_Virtuoso_ResultConverter_Extended
{
    // ------------------------------------------------------------------------
    // --- Protected Properties -----------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Array of variable bindings
     * @var array
     */
    protected $_bindings = array();
    
    /**
     * The current literal data
     * @var string
     */
    protected $_currentCharacterData = '';
    
    /**
     * The current literal datatype
     * @var string
     */
    protected $_currentDatatype = null;
    
    /**
     * The current literal language
     * @var string
     */
    protected $_currentLanguage = null;
    
    /**
     * The last encountered variable
     * @var string
     */
    protected $_currentVariable = null;
    
    /**
     * The current row
     * @var resource
     */
    protected $_currentRow = null;
    
    /**
     * Whether the parser is currently inside a value element
     * @var boolean
     */
    protected $_inValue = false;
    
    /**
     * Output encoding
     * @var string
     */
    protected $_outputEncoding = 'UTF-8';
    
    /**
     * XML parser instance
     * @var resource
     */
    protected $_parser = null;
    
    /**
     * Denotes whether an rs:results element has been found.
     * @var boolean
     */
    protected $_saneResults = false;
    
    /**
     * All variables encountered during parsing
     * @var array
     */
    protected $_variables = array();
    
    // ------------------------------------------------------------------------
    // --- Magic Methods ------------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // Instead of a namespace-aware parser we use a simple parser with 
        // hard-coded namespace prefixes since the Virtuoso result format 
        // is not expected to change.
        $parser = xml_parser_create($this->_outputEncoding);
        
        // parser options
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        
        // set handlers
        xml_set_object($parser, $this);
        xml_set_element_handler($parser, '_startTag', '_endTag');
        xml_set_character_data_handler($parser, '_startContent');
        
        $this->_parser = $parser;
    }
    
    /**
     * Destructor
     */
    public function __destruct()
    {
        xml_parser_free($this->_parser);
    }
    
    // ------------------------------------------------------------------------
    // --- Public Methods -----------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Converts an XML result string to an RDF/PHP array.
     *
     * @param string $xmlSparqlResults The Virtuoso RDF/XML SPARQL result
     * @return array
     */
    public function convert($xmlSparqlResults)
    {
        // parse the data
        if (xml_parse($this->_parser, (string)$xmlSparqlResults) !== 1) {
            require_once 'Erfurt/Store/Adapter/Virtuoso/ResultConverter/Exception.php';
            throw new Erfurt_Store_Adapter_Virtuoso_ResultConverter_Exception('XML parsing error.');
        }
        
        // this should never happen
        if (!$this->_saneResults) {
            require_once 'Erfurt/Store/Adapter/Virtuoso/ResultConverter/Exception.php';
            throw new Erfurt_Store_Adapter_Virtuoso_ResultConverter_Exception(
                'Could not parse result set. The XML result format might have changed. Please check the parser.');
        }
        
        // prepare sparql-results+json-like array
        $result = array(
            'head' => array(
                'vars' => $this->_variables
            ), 
            'results' => array(
                'bindings' => $this->_bindings
            ), 
            /**
             * Ensures compatibility with erroneous pre-0.9.5 behaviour
             * @deprecated 0.9.5
             */
            'bindings' => $this->_bindings
        );
        
        return $result;
    }
    
    // ------------------------------------------------------------------------
    // --- Protected Methods --------------------------------------------------
    // ------------------------------------------------------------------------
    
    /**
     * Adds a variable binding to the current row.
     *
     * @param string $type Type of the variable
     * @param string $variable The name of the variable
     * @param string $value The value
     */
    protected function _addBinding($type, $variable, $value)
    {
        $this->_currentRow[$variable] = compact('type', 'value');
    }
    
    /**
     * Adds a variable binding for a literal to the current row.
     *
     * @param string $variable The name of the variable
     * @param string $value The value
     */
    protected function _addLiteralBinding($variable, $value)
    {
        // this is going to be a literal
        $binding = array(
            'type'  => 'literal', 
            'value' => $value
        );
        
        // datatype or language set?
        if (null !== $this->_currentDatatype) {
            $binding['datatype'] = $this->_currentDatatype;
            $binding['type'] = 'typed-literal';
            $this->_currentDatatype = null;
        } else if (null !== $this->_currentLanguage) {
            $binding['xml:lang'] = $this->_currentLanguage;
            $this->_currentLanguage = null;
        }
        
        $this->_currentRow[$variable] = $binding;
    }
    
    /**
     * Handles the occurence of a closing tag.
     *
     * @param resource $parser The parser
     * @param string $tagName The tag's name
     */
    protected function _endTag($parser, $tagName)
    {
        switch ($tagName) {
            case 'rs:value':
                if ($this->_inValue) {
                    $variable = $this->_getCurrentVariable();
                    $this->_addLiteralBinding($variable, $this->_currentCharacterData);

                    $this->_inValue = false;
                    $this->_currentCharacterData = '';
                }
            break;
            case 'rs:result':
                // result row closed
                // save current row (if any)
                if (null !== $this->_currentRow) {
                    array_push($this->_bindings, $this->_currentRow);
                }
            break;
        }
    }
    
    /**
     * Returns the last encountered variable.
     *
     * @return string
     */
    protected function _getCurrentVariable()
    {
        return $this->_currentVariable;
    }
    
    /**
     * Handles character data.
     *
     * @param resource $parser The parser
     * @param string $data Character data
     */
    protected function _startContent($parser, $data)
    {
        // literal
        if ($this->_inValue) {
            $this->_currentCharacterData .= $data;
        }
    }
    
    /**
     * Handles the encounter of a new tag
     *
     * @param resource $parser The parser
     * @param string $tagName The tag's name
     * @param array $attributes The tag's attributes
     */
    protected function _startTag($parser, $tagName, $attributes)
    {
        switch ($tagName) {
            case 'rs:results':
                // we have results
                $this->_saneResults = true;
            break;
            case 'rs:result':
                // new row
                $this->_currentRow = array();
            break;
            case 'rs:binding':
                // new variable binding for current row
                // change current variable
                $variableName = $attributes['rs:name'];
                if (!in_array($variableName, $this->_variables)) {
                    $this->_variables[] = $variableName;
                }
                $this->_currentVariable = (string)$variableName;
            break;
            case 'rs:value':
                // new value for current variable binding
                $variable = $this->_getCurrentVariable();
                if (array_key_exists('rdf:resource', $attributes)) {
                    // URI value
                    $this->_addBinding('uri', $variable, $attributes['rdf:resource']);
                } else if (array_key_exists('rdf:nodeID', $attributes)) {
                    // blanknode value
                    $this->_addBinding('bnode', $variable, $attributes['rdf:nodeID']);
                } else {
                    // literal value
                    if (array_key_exists('xml:lang', $attributes)) {
                        $this->_currentLanguage = $attributes['xml:lang'];
                    } else if (array_key_exists('rdf:datatype', $attributes)) {
                        $this->_currentDatatype = $attributes['rdf:datatype'];
                    }
                    
                    $this->_currentCharacterData = '';
                    $this->_inValue = true;
                }
            break;
            default: /* nothing */
            break;
        }
    }
}

