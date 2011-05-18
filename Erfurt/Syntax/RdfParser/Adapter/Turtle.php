<?php
require_once 'Erfurt/Syntax/RdfParser/Adapter/Interface.php';

class Erfurt_Syntax_RdfParser_Adapter_Turtle implements Erfurt_Syntax_RdfParser_Adapter_Interface
{
    protected $_data = '';
    protected $_pos  = 0;
    //protected $_lastCharLength = 1;
    
    protected $_baseUri = null;
    protected $_subject = null;
    protected $_predicate = null;
    protected $_object = null;
    
    protected $_namespaces = array();
    
    const BNODE_PREFIX = 'node';
    
    protected $_bnodeCounter = 0;
    
    protected $_usedBnodeIds = array();
    
    protected $_statements = array();
    
    protected $_parseToStore = false;
    protected $_graphUri = null;
    protected $_useAc = true;
    protected $_stmtCounter = 0;
    
    public function parseFromDataString($dataString, $baseUri = null)
    {
        $this->_parse($dataString); 
        return $this->_statements;
    }
    
    public function parseFromFilename($filename)
    {
        $this->_baseUri = $filename;
        
        $fileHandle = fopen($filename, 'r');
        
        if ($fileHandle === false) {
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException("Failed to open file with filename '$filename'");
        }
    
// TODO support for large files 
        $data = '';
        // Let's parse.
        while (!feof($fileHandle)) {
            $data .= fread($fileHandle, 4096);
        }

        $this->_parse($data);
        
        fclose($fileHandle);

        return $this->_statements;
    }
    
    public function parseFromUrl($url)
    {
        $this->_baseUri = $url;
        
        return $this->parseFromFilename($url);
    }
    
    public function parseFromDataStringToStore($data, $graphUri, $useAc = true, $baseUri = null)
    {
        $this->_parseToStore = true;
        $this->_graphUri = $graphUri;
        $this->_useAc = $useAc;
        $this->parseFromDataString($data);
        
        $this->_writeStatementsToStore();
        $this->_addNamespacesToStore();
        
        return true;
    }
    
    public function parseFromFilenameToStore($filename, $graphUri, $useAc = true)
    {
        $this->_parseToStore = true;
        $this->_graphUri = $graphUri;
        $this->_useAc = $useAc;
        $this->parseFromFilename($filename);
        $this->_writeStatementsToStore();
        $this->_addNamespacesToStore();

        return true;
    }
    
    public function parseFromUrlToStore($url, $graphUri, $useAc = true)
    {
        return $this->parseFromFilenameToStore($url, $graphUri, $useAc);
    }
    
    public function parseNamespacesFromDataString($data)
    {
        $this->_parseNamespacesOnly($data);
        return $this->_namespaces;
    }
    
    public function parseNamespacesFromFilename($filename)
    {
        $fileHandle = fopen($filename, 'r');
        
        if ($fileHandle === false) {
            require_once 'Erfurt/Syntax/RdfParserException.php';
            throw new Erfurt_Syntax_RdfParserException("Failed to open file with filename '$filename'");
        }
                
        $data = '';
        // Let's parse.
        while (!feof($fileHandle)) {
            $data .= fread($fileHandle, 4096);
        }
        
        $this->_parseNamespacesOnly($data);
        
        fclose($fileHandle);

        return $this->_namespaces;
    }
    
    public function parseNamespacesFromUrl($url)
    {
        return $this->parseNamespacesFromFilename($url);
    }
    
    public function reset()
    {
        $this->_data = '';
        $this->_pos  = 0;
        
        $this->_baseUri = null;
        $this->_subject = null;
        $this->_predicate = null;
        $this->_object = null;

        $this->_namespaces = array();

        $this->_bnodeCounter = 0;

        $this->_usedBnodeIds = array();

        $this->_statements = array();

        $this->_parseToStore = false;
        $this->_graphUri = null;
        $this->_useAc = true;
        $this->_stmtCounter = 0;
    }
    
    /**
     * Call this method after parsing only. The function parseToStore will add namespaces automatically.
     * This method is just for situations, where the namespaces are needed to after a in-memory parsing.
     * 
     * @return array
     */
    public function getNamespaces()
    {
        return $this->_namespaces;
    }
    
    protected function _addNamespacesToStore()
    {
        $erfurtNamespaces = Erfurt_App::getInstance()->getNamespaces();
        
        foreach ($this->_namespaces as $prefix => $ns) {
            try {
                $erfurtNamespaces->addNamespacePrefix($this->_graphUri,  $ns, $prefix, $this->_useAc);
            } catch (Erfurt_Namespaces_Exception $e) {
                // We need to catch the store exception, for the namespace component throws exceptions in case a prefix
                // already exists.
                
                // Do nothing... just continue with the next one...
            }
        }
    }
    
    protected function _parse($data)
    {
        $this->_data = $data;
        $this->_dataLength = strlen($data);
        $this->_pos  = 0;

        $c = $this->_skipWS();

        while ($c !== -1) {
            $this->_parseStatement();
            $c = $this->_skipWS();
        } 
    }
    
    protected function _parseNamespacesOnly($data)
    {
        $this->_data = $data;
        $this->_pos  = 0;
        
        $c = $this->_skipWS();
        while ($c !== -1) {
            $c = $this->_peek();

            if ($c === '@') {
                $this->_parseDirective();
                $this->_skipWS();

                // Is a dot after prefix definition allowed?
                if ($this->_peek() === '.') {
                    $this->_read();
                }
            }
            $c = $this->_skipWS();
        }
    }
    
    protected function _parseStatement()
    {
        $c = $this->_peek();

        if ($c === '@') {
            $this->_parseDirective();
            $this->_skipWS();
            
            // Is a dot after prefix definition allowed?
            if ($this->_peek() === '.') {
                $this->_read();
            }
        } else {
            $this->_parseTriples();
            $this->_skipWS();
            
            if ($this->_peek() === '.') {
                $this->_read();
            }
        }
    }
    
    protected function _parseDirective()
    {
        $c = $this->_read(5);

        if ($c === '@base') {
            $this->_parseBase();
        } else {
            $c .= $this->_read(2);
            
            if ($c === '@prefix') {
                $this->_parsePrefixId();
            }
        }
    }
    
    protected function _parsePrefixId()
    {
        $this->_skipWS();

        $token = '';
        while (true) {
            $c = $this->_read();
            
            if ($c === ':') {
                $this->_unread();
                break;
            } else if ($this->_isWS($c)) {
                break;
            } 
            
            $token .= $c;
        }
       
        $this->_skipWS();
        $this->_read();
        $this->_skipWS();
        
        $ns = $this->_parseUri();
        $this->_addNamespace($token, $ns);
    }
    
    protected function _addNamespace($prefix, $ns)
    {
        $prefix = (string)$prefix;
        
        if ($ns instanceof Erfurt_Rdf_Resource) {
            $ns = $ns->getUri();
        } else {
            $ns = (string)$ns;
        }
        
        $this->_namespaces[$prefix] = $ns;
    }
    
    protected function _parseUri()
    {
        $this->_read();
        $c = $this->_read();
        
        $token = '';
        while ($c !== -1 && $c !== '>') {
            $token .= $c;
            $c = $this->_read();
        }
        
        #$c = $this->_skipWS();
         
        $uri = $this->_resolveUri( $this->_decodeString($token, true) );
        require_once 'Erfurt/Rdf/Resource.php';
        return Erfurt_Rdf_Resource::initWithIri($uri);
    }
    
    protected function _resolveUri($uri)
    {
        if ((strlen($uri) > 0) && ($uri[0] === '#') || (strpos($uri, ':') === false)) {
            if ($this->_getBaseUri()) {
				return substr($this->_getBaseUri(),0,strrpos($this->_getBaseUri(),'/')+1) . $uri;
            }
        } 
            
        return $uri;
    }
    
    protected function _getBaseUri()
    {
        if (null !== $this->_baseUri) {
            return $this->_baseUri;
        } else {
            return false;
        }
    }
    
    
    protected function _verifyChar($char, $expected)
    {
        if ($char === -1 || strpos((string)$expected, $char) === false) {
            $this->_throwException("'$expected' expected. '$char' found instead (".substr((string)$this->_data, $this->_pos-20, 40).").");
        }
    }
    
    protected function _parseBase()
    {
        $this->_skipWS();
        $baseUri = $this->_parseUri();
        $this->_setBaseUri($baseUri);
    }
    
    protected function _setBaseUri($baseUri)
    {
        $this->_baseUri = $baseUri;
    }
    
    protected function _parseTriples()
    {
        $this->_parseSubject();
        $this->_skipWS();
        $this->_parsePredicateObjectList();

        $this->_subject   = null;
        $this->_predicate = null;
        $this->_object    = null;
    }
    
    protected function _parseSubject()
    {
        $c = $this->_peek();

        switch ($c) {
            case '(':
                $this->_subject = $this->_parseCollection();
                break;
            case '[':
                $this->_subject = $this->_parseImplicitBlank();
                break;
            default:
                $this->_subject = $this->_parseValue();
        }
    }
    
    protected function _parseValue()
    {
        $c = $this->_peek();

        if ($c === '<') {
            return $this->_parseUri();
        } else if ($c === '_') {
            return $this->_parseNodeId();
        } else if ($c === '"') {
            return $this->_parseQuotedLiteral();
        } else if (is_numeric($c) || $c === '.' || $c === '+' || $c === '-') {
            return $this->_parseNumber();
        } else {
            return $this->_parseQNameOrBoolean();
        }
    }
    
    protected function _throwException($msg)
    {
        require_once 'Erfurt/Syntax/RdfParserException.php';
        throw new Erfurt_Syntax_RdfParserException($msg);
    }
    
    protected function _parseNumber()
    {
        $datatype = EF_XSD_INTEGER;
        
        $c = $this->_read();
        
        $token = '';
        if ($c === '+' || $c === '-') {
            $token .= $c;
        }
        
        while ($c !== -1 && is_numeric($c)) {
            $token .= $c;
            $c = $this->_read();
        }
        
        if ($c === '.' || $c === 'e' || $c === 'E') {
            $datatype = EF_XSD_DECIMAL;
            
            if ($c === '.') {
                $token .= $c;
                
                $c = $this->_read();
                
                while ($c !== -1 && is_numeric($c)) {
                    $token .= $c;
                    $c = $this->_read();
                }
               
                if (strlen($token) === 1) {
                    $this->_throwException('Object for statement is missing.');
                }
            } else {
                if (strlen($token) === 0) {
                    $this->_throwException('Object for statement is missing.');
                }
            }
            
            if ($c === 'e' || $c === 'E') {
                $datatype = EF_XSD_DOUBLE;
                $token .= $c;
                
                $c = $this->_read();
                if ($c === '+' || $c === '-') {
                    $token .= $c;
                    $c = $this->_read();
                }
                
                if (!is_numeric($c)) {
                    $this->_throwException('Exponent value missing.');
                }
                
                $token .= $c;
                
                $c = $this->_read();
                while ($c !== -1 && is_numeric($c)) {
                    $token .= $c;
                    $c = $this->_read();
                }
            }
        }
        
        $this->_unread();
        
        require_once 'Erfurt/Rdf/Literal.php';
        return Erfurt_Rdf_Literal::initWithLabelAndDatatype($token, $datatype);   
    }
    
    protected function _parseQuotedLiteral()
    {
        $label = $this->_parseQuotedString();
   
        $c = $this->_peek();
      
        if ($c === '@') {
            $this->_read();
            
            $lang = '';
            $c = $this->_read();
            
            if (!$this->_isLanguageStartChar($c)) {
                require_once 'Erfurt/Syntax/RdfParserException.php';
                throw new Erfurt_Syntax_RdfParserException('Character "' . $c . '" not allowed as starting char in language tags.');
            }
            
            $lang .= $c;
            $c = $this->_read();
            
            while ($c !== -1 && !$this->_isWS($c) && !($c === ',') && !($c === '.')) { 
                if (!$this->_isLanguageChar($c)) {
                    require_once 'Erfurt/Syntax/RdfParserException.php';
                    throw new Erfurt_Syntax_RdfParserException('Character "' . $c . '" not allowed in language tags.');
                }
                
                $lang .= $c;
                $c = $this->_read();
            }

            $this->_unread();
            require_once 'Erfurt/Rdf/Literal.php';
            return Erfurt_Rdf_Literal::initWithLabelAndLanguage($label, $lang);
        } else if ($c === '^') {
            $this->_read();
            
            $this->_verifyChar($this->_read(), '^');
            
            $datatype = $this->_parseValue();
            if ($datatype instanceof Erfurt_Rdf_Resource) {
                require_once 'Erfurt/Rdf/Literal.php';
                return Erfurt_Rdf_Literal::initWithLabelAndDatatype($label, (string) $datatype);
            } else {
                $this->_throwException('Illegal datatype value.');
                return null;
            }
        } else {
            require_once 'Erfurt/Rdf/Literal.php';
            return Erfurt_Rdf_Literal::initWithLabel($label);
        }
    }
    
    /*
    protected function _isLanguageChar($c)
    {
        return ($this->_isLanguageStartChar($c) || is_numeric($c) || $c === '-');
    }*/
    
    /*
    protected function _isLanguageStartChar($c)
    {
        return ($this->_ord($c) >= 0x41 && $this->_ord($c) <= 0x7A);
    }*/
    
    protected function _parseQuotedString()
    {
        $result = null;
        
        $this->_verifyChar($this->_read(), '"');
        
        $c2 = $this->_read();
        $c3 = $this->_read();
        
        if ($c2 === '"' && $c3 === '"') {
            // long string
            $result = $this->_parseLongString();
        } else {
            // normal string
            $this->_unread(); // c3
            $this->_unread(); // c2
            
            $result = $this->_parseString();
        }
       
        return $this->_decodeString($result);
    }
    
    protected function _parseString()
    {
        $result = '';
     
        while (true) {
            $c = $this->_read();
            
            if ($c === '"') {
                break;
            }
            
            $result .= $c;
            
            if ($c == "\\") {
                $c = $this->_read();
                $result .= $c;
            } 
        }

        return $result;
    }
    
    protected function _parseLongString()
    {
        $result = '';
        $doubleQuoteCount = 0;
        
        while ($doubleQuoteCount < 3) {
            $c = $this->_read();
            
            if ($c === '"') {
                ++$doubleQuoteCount;
            } else {
                $doubleQuoteCount = 0;
            }
            
            $result .= $c;
            
            if ($c === "\\") {
                $c = $this->_read();
                $result .= $c;
            }
        }
        
        return substr((string)$result, 0, -3);
    }
    
    protected function _parseNodeId()
    {
        $this->_verifyChar($this->_read(), '_');
        $this->_verifyChar($this->_read(), ':');
        
        $c = $this->_read();
        #if (!$this->_isNameStartChar($c)) {
        #    $this->_throwException('Illegal char.');
        #}
        
        $result = $c;
        
        $c = $this->_read();
        while ($c !== -1 && !$this->_isWS($c)) {
            $result .= $c;
            $c = $this->_read();
        }
        
        $this->_unread();
        
        return $this->_createBNode($result);
    }
    
    /*
    protected function _isNameChar($c)
    {
        return (
            $this->_isNameStartChar($c) ||
            is_numeric($c) ||
            $c === '-' ||
            $this->_ord($c) === 0x00B7 ||
            ($this->_ord($c) >= 0x0300 && $this->_ord($c) < 0x036F) ||
            ($this->_ord($c) >= 0x203F && $this->_ord($c) < 0x2040) 
        );
    }*/
    
    /*protected function _isNameStartChar($c)
    {
        return ($c === '_' || $this->_isPrefixStartChar($c));
    }*/
    
    protected function _parseQNameOrBoolean()
    {
        $c = $this->_read();

        #if ($c !== ':' && !$this->_isPrefixStartChar($c)) {
        #    $this->_throwException('Expected ":" or letter.');
        #}

        $namespace = null;
        if ($c === ':') {
            // QName with default namespace
            if (isset($this->_namespaces[''])) {
                $namespace = $this->_namespaces[''];
            } else {
                $this->_throwException('Default namespace used, but not defined.');
            }
        } else {
            $prefix = $c;
            $c = $this->_read();
            while ($c !== -1 && !$this->_isWS($c) && $c !== ':') {
                $prefix .= $c;
                $c = $this->_read();
            }
            
            if ($c !== ':') {
                // Prefix might be a boolean value.
                $value = $prefix;

                if ($prefix === 'true' || $prefix === 'false') {
                    require_once 'Erfurt/Rdf/Literal.php';
                    return Erfurt_Rdf_Literal::initWithLabelAndDatatype($value, EF_XSD_BOOLEAN);
                }
            }

            $this->_verifyChar($c, ':');

            if (isset($this->_namespaces[$prefix])) {
                $namespace = $this->_namespaces[$prefix];
            } else {
                $this->_throwException("Namespace '$prefix' used, but not defined.");
            }
        }
        
        $c = $this->_read();
        $localName = $c;
        
        $c = $this->_read();
        while ($c !== -1 && !$this->_isWS($c) && $c !== ',' && $c !== ';' && $c !== ')') {
            $localName .= $c;
            $c = $this->_read();
        }

        $this->_unread();

        
        require_once 'Erfurt/Rdf/Resource.php';
        return Erfurt_Rdf_Resource::initWithNamespaceAndLocalName($namespace, $localName);
    }
    
    /*protected function _isPrefixChar($c)
    {
        return $this->_isNameChar($c);
    }*/
    
    /*protected function _isPrefixStartChar($c)
    {
        return (
            ($this->_ord($c) >= 0x41    && $this->_ord($c) <= 0x7A)   ||
            ($this->_ord($c) >= 0x00C0  && $this->_ord($c) <= 0x00D6) ||
            ($this->_ord($c) >= 0x00D8  && $this->_ord($c) <= 0x00F6) ||
            ($this->_ord($c) >= 0x00F8  && $this->_ord($c) <= 0x02FF) ||
            ($this->_ord($c) >= 0x0370  && $this->_ord($c) <= 0x037D) ||
            ($this->_ord($c) >= 0x037F  && $this->_ord($c) <= 0x1FFF) ||
            ($this->_ord($c) >= 0x200C  && $this->_ord($c) <= 0x200D) ||
            ($this->_ord($c) >= 0x2070  && $this->_ord($c) <= 0x218F) ||
            ($this->_ord($c) >= 0x2C00  && $this->_ord($c) <= 0x2FEF) ||
            ($this->_ord($c) >= 0x3001  && $this->_ord($c) <= 0xD7FF) ||
            ($this->_ord($c) >= 0xF900  && $this->_ord($c) <= 0xFDCF) ||
            ($this->_ord($c) >= 0xFDF0  && $this->_ord($c) <= 0xFFFD) ||
            ($this->_ord($c) >= 0x10000 && $this->_ord($c) <= 0xEFFFF) 
        );
    }*/
    
    protected function _parseImplicitBlank()
    {
        $this->_verifyChar($this->_read(), '[');
        
        $bNode = $this->_createBNode();
        
        $c = $this->_read();
        if ($c !== ']') {
            $this->_unread();
            
            $oldSubject   = $this->_subject;
            $oldPredicate = $this->_predicate;
            
            $this->_subject = $bNode;
            
            $this->_skipWS();
            
            $this->_parsePredicateObjectList();
            
            $this->_skipWS();
            
            $this->_verifyChar($this->_read(), ']');
            
            $this->_subject   = $oldSubject;
            $this->_predicate = $oldPredicate;
        }
        
        return $bNode;
    }
    
    protected function _createBNode($id = null)
    {
        if (null === $id) {
            while (true) {
                $id = self::BNODE_PREFIX . ++$this->_bnodeCounter;

                if (!isset($this->_usedBnodeIds[$id])) {
                    break;
                }
            }    
        }
        
        $this->_usedBnodeIds[$id] = true;
        require_once 'Erfurt/Rdf/Resource.php';
        return Erfurt_Rdf_Resource::initWithBlankNode($id);
    }
    
    protected function _parseCollection()
    {
        $this->_verifyChar($this->_read(), '(');
        
        $c = $this->_skipWS();
        if ($c === ')') {
            // Empty list
            $this->_read();
            return EF_RDF_NIL;
        } else {
            $listRoot = $this->_createBNode();
            
            $oldSubject   = $this->_subject;
            $oldPredicate = $this->_predicate;
            
            $this->_subject   = $listRoot;
            $this->_predicate = EF_RDF_FIRST;
            
            $this->_parseObject();
            
            $bNode = $listRoot;
            while (!$this->_isEndReached() && $this->_skipWS() !== ')') {
                $newBNode = $this->_createBNode();
                $this->_addStatement($bNode, EF_RDF_REST, $newBNode);
                
                $this->_subject = $bNode = $newBNode;
                
                $this->_parseObject();
            }
            
            $this->_read();
            
            // Finish the list.
            $this->_addStatement($bNode, EF_RDF_REST, EF_RDF_NIL);
            
            $this->_subject   = $oldSubject;
            $this->_predicate = $oldPredicate;
            
            return $listRoot;
        }
    }
    
    protected function _isEndReached()
    {
        if ($this->_pos >= $this->_dataLength) {
            return true;
        } else {
            return false;
        }
    }
    
    protected function _parsePredicateObjectList()
    {
        $this->_predicate = $this->_parsePredicate();
        $this->_skipWS();

        $this->_parseObjectList();

        while ($this->_peek() === ';') {
            $this->_read(); // Skip the ;
            $c = $this->_skipWS();
            
            if ($c === '.' || $c === ']') {
                break;
            }
            
            $this->_predicate = $this->_parsePredicate();
            $this->_skipWS();
            $this->_parseObjectList();
        }
    }
    
    protected function _parsePredicate()
    {
        $c1 = $this->_read();

        if ($c1 === 'a') {
            $c2 = $this->_read();
            
            if ($this->_isWS($c2)) {
                $this->_unread();
                return EF_RDF_TYPE;
            }
            
            $this->_unread();
        }
        $this->_unread();
        
        $predicate = $this->_parseValue();
        if ($predicate instanceof Erfurt_Rdf_Resource && !$predicate->isBlankNode()) {
            return $predicate;
        } else {
            $this->_throwException("Illegal predicate value ($predicate).");
            return null;
        }
    }
    
    protected function _parseObjectList()
    {
        $this->_parseObject();

        while ($this->_skipWS() === ',') {
            $this->_read(); // Skip the ,
            $this->_skipWS(); // Skip additional whitespace
            $this->_parseObject();
            
        }
    }
    
    protected function _parseObject()
    {
        $c = $this->_peek();

        if ($c === '(') {
            $this->_object = $this->_parseCollection();
        } else if ($c === '[') {
            $this->_object = $this->_parseImplicitBlank();
        } else {
            $this->_object = $this->_parseValue();
        }

        $this->_addStatement($this->_subject, $this->_predicate, $this->_object);
    }
    
    protected function _addStatement($s, $p, $o)
    {
        if ($s instanceof Erfurt_Rdf_Resource) {
            if ($s->isBlankNode()) {
                $s = '_:' . $s->getId();
            } else {
                $s = $s->getUri();
            }
        }
        
        if ($p instanceof Erfurt_Rdf_Resource) {
            $p = $p->getUri();
        }
        
        if ($o instanceof Erfurt_Rdf_Resource) {
            if ($o->isBlankNode()) {
                $o = '_:' . $o->getId();
                $oType = 'bnode';
            } else {
                $o = $o->getUri();
                $oType = 'uri';
            }
        } else if ($o instanceof Erfurt_Rdf_Literal) {
            $dType = $o->getDatatype();
            $lang = $o->getLanguage();
            $o = $o->getLabel();
            $oType = 'literal';
        }
        
        if (!isset($this->_statements["$s"])) {
            $this->_statements["$s"] = array();
        }
        if (!isset($this->_statements["$s"]["$p"])) {
            $this->_statements["$s"]["$p"] = array();
        }
        
        if (!isset($oType)) {
            if (substr((string)$o, 0, 2) === '_:') {
                $oType = 'bnode';
            } else {
                $oType = 'uri';
            }
        }
        
        $objectArray = array(
            'type'  => $oType,
            'value' => $o
        );
        
        if ($oType === 'literal' && null !== $dType) {
            $objectArray['datatype'] = $dType;
        }
        if ($oType === 'literal' && null !== $lang) {
            $objectArray['lang'] = $lang;
        }
        
        $this->_statements["$s"]["$p"][] = $objectArray;
        ++$this->_stmtCounter;
        
        if ($this->_parseToStore && $this->_stmtCounter >= 1000) {
            // Write the statements
            $this->_writeStatementsToStore();
        }
    }
    
    protected function _writeStatementsToStore()
    {
        // Check whether model exists.
        $store = Erfurt_App::getInstance()->getStore();
        if (!$store->isModelAvailable($this->_graphUri, $this->_useAc)) {
            throw new Exception('Model with uri ' . $this->_graphUri . ' not available.');
        }
        
        if ($this->_stmtCounter > 0) {
            $store->addMultipleStatements($this->_graphUri, $this->_statements, $this->_useAc);
            $this->_statements = array();
            $this->_stmtCounter = 0;
        }
    }
    
    protected function _peek()
    {
        return $this->_data[$this->_pos];
    }
    
    protected function _skipWS()
    {
        $c = $this->_read();

        while ($this->_isWS($c))
        {
            if ($c === '#') {
                $this->_skipLine();
            }
            
            $c = $this->_read();
        }
        
        $this->_unread();
        return $c;
    }
    
    protected function _skipLine()
    {
        $c = $this->_read();
        while (ord($c) !== 0xD && ord($c) !== 0xA) {
            $c = $this->_read();
        }
        
        if (ord($c) === 0xD) {
            $c = $this->_read();
            
            if (ord($c) !== 0xA) {
                $this->_unread();
            }
        }
    }
    
    protected function _isLanguageStartChar($c) 
    {
        return (boolean)preg_match('/^[a-z]$/', $c);
    }
    
    protected function _isLanguageChar($c)
    {
        return (boolean)preg_match('/^[a-z0-9\-]$/', $c);
    }
    
    protected function _isWS($c)
    {
        // ws ::= #x9 | #xA | #xD | #x20 | comment ('#' ( [^#xA#xD] )*)
        return (
            ord($c) === 0x9  ||
            ord($c) === 0xA  ||
            ord($c) === 0xD  ||
            ord($c) === 0x20 ||
            $c === '#'
        );   
    }
    
    protected function _read($count = 1)
    {
        if ($this->_pos < $this->_dataLength) {
            if ($count > 1) {
                $val = substr((string)$this->_data, $this->_pos, $count);
                $this->_pos += $count;
                return $val;
            } else {
                return $this->_data[$this->_pos++];
            }
            
        } else {
            return -1;
        }
    }
    
    /*protected function _readUntil($char)
    {
        $rest = substr($this->_data, $this->_pos);
        $idx = strpos($rest, $char);
        
        return substr($rest, 0, $idx);
    }*/
    
    protected function _unread()
    {
        --$this->_pos;
    }
    
    protected function _ord($c)
    {
        $strLen = strlen($c);
        
        if ( $strLen === 1) {
            return ord($c);
        } else {
            $result = '';
            for ($i=0; $i<$strLen; ++$i) {
                $result .= dechex(ord($c[$i]));
            }
            return hexdec($result);
        }
    }
    
    /**
     * Decodes escape sequences on a string
     * (Including Unicode escape via \u and \U)
     * @param String $value the string to decode escape sequences from
     * @pram boolean $isUrl whether the input escapes should be encoded url compatible
     * @return String with decoded escape sequences
     */
    protected function _decodeString($value, $isUrl = false)
    {
        $backSlashIdx = strpos((string)$value, "\\");
        
        if ($backSlashIdx === false) {
            return $value;
        }
        
        $startIdx = 0;
        $length = strlen($value);
        $result = '';
        
        while ($backSlashIdx !== false) {
            $result .= substr((string)$value, $startIdx, $backSlashIdx-$startIdx);
            
            $c = $value[($backSlashIdx+1)];
            switch ($c) {
                case 't':
                    $result .= "\t";
                    $startIdx = $backSlashIdx + 2;
                    break;
                case 'r':
                    $result .= "\r";
                    $startIdx = $backSlashIdx + 2;
                    break;
                case 'n':
                    $result .= "\n";
                    $startIdx = $backSlashIdx + 2;
                    break;
                case '"':
                    $result .= $isUrl ? urlencode('"') : '"';
                    $startIdx = $backSlashIdx + 2;
                    break;
                case '>':
                    $result .= $isUrl ? urlencode('>') : '>';
                    $startIdx = $backSlashIdx + 2;
                    break;
                case "\\":
                    $result .= $isUrl ? urlencode("\\") : "\\";
                    $startIdx = $backSlashIdx + 2;
                    break;
                case 'u':
                    $xx = substr((string)$value, $backSlashIdx+2, 4);
                    $c = $this->_uchr(hexdec($xx));
                    $startIdx = $backSlashIdx + 6;
                    $result .= $isUrl ? urlencode($c) : $c;
                    break;
                case 'U':
                    $xx = substr((string)$value, $backSlashIdx+2, 8);
                    $c = $this->_uchr(hexdec($xx));
                    $startIdx = $backSlashIdx + 10;
                    $result .= $isUrl ? urlencode($c) : $c;
                    break;
            }
            
            $backSlashIdx = strpos((string)$value, "\\", $startIdx);
        }
        
        $result .= substr((string)$value, $startIdx);
        return $result;
    }
    
    protected function _uchr($dec)
    {
        if ($dec < 128) {
            $utf = chr($dec);
          } else if ($dec < 2048) {
            $utf = chr(192 + (($dec - ($dec % 64)) / 64));
            $utf .= chr(128 + ($dec % 64));
          } else {
            $utf = chr(224 + (($dec - ($dec % 4096)) / 4096));
            $utf .= chr(128 + ((($dec % 4096) - ($dec % 64)) / 64));
            $utf .= chr(128 + ($dec % 64));
          }
          return $utf;
    }
}
