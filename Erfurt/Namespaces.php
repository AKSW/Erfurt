<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2011, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

/**
 * Erfurt namespace and prefix management.
 *
 * @category Erfurt
 * @package Namespaces
 * @author Nathanael Arndt <arndtn@gmail.com>
 * @author Norman Heino <norman.heino@gmail.com>
 */
class Erfurt_Namespaces
{
    // ------------------------------------------------------------------------
    // --- Class Constants ----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * The predicate URI used to store prefixes.
     * @var string
     */
    const PREFIX_PREDICATE = 'http://ns.ontowiki.net/SysOnt/prefix';

    // ------------------------------------------------------------------------
    // --- Protected Members --------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Whether to allow multiple prefixes for the same namespace URI.
     * @var boolean
     */
    protected $_allowMultiplePrefixes = true;

    /**
     * Hash table for namespace storage per graph.
     * @var array
     */
    protected $_namespaces = array();

    /**
     * Hash table of names not to be used as prefixes.
     * @var array
     */
    protected $_reservedNames = array();

    /**
     * Hash table of prefixes for standard vocabularies that
     * should always be the same.
     * @var array
     */
    protected $_standardPrefixes = array();

    // ------------------------------------------------------------------------
    // --- Magic Methods ------------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Constructs a namespaces object.
     *
     * An optional array of configuration options can be provided. The following
     * keys are recognized:
     * - allow_multiple_prefixes:   Whether to allow multiple prefixes for the same namespace (boolean)
     * - reserved_names:            An array of names not to be used as prefixes
     * - standard_prefixes:         An array of default prefix => namespace mappings
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        if (array_key_exists('allow_multiple_prefixes', $options)) {
            $this->_standardPrefixes = (boolean)$options['allow_multiple_prefixes'];
        }

        if (array_key_exists('reserved_names', $options)) {
            $this->_reservedNames = array_flip((array)$options['reserved_names']);
        }

        if (array_key_exists('standard_prefixes', $options)) {
            $this->_standardPrefixes = array_flip((array)$options['standard_prefixes']);
        }
    }

    // ------------------------------------------------------------------------
    // --- Public Methods -----------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     * Adds a prefix for the namespace URI in a given graph.
     *
     * @param Erfurt_Rdf_Model|string $graph
     * @param string $namespace
     * @param string $prefix
     * @throws Erfurt_Namespaces_Exception
     */
    public function addNamespacePrefix($graph, $namespace, $prefix)
    {
        // safety
        $prefix    = (string)$prefix;
        $namespace = (string)$namespace;

        //lowercase prefix always (for best compatibility)
        $prefix = strtolower($prefix);

        $graphPrefixes = $this->getNamespacesForGraph($graph);

        // check if namespace is a valid URI
        require_once 'Erfurt/Uri.php';
        if (!Erfurt_Uri::check($namespace)) {
            require_once 'Erfurt/Namespaces/Exception.php';
            throw new Erfurt_Namespaces_Exception("Given namespace '$namespace' is not a valid URI.");
        }

        // check if prefix is a valid XML name
        require_once 'Erfurt/Utils.php';
        if (!Erfurt_Utils::isXmlPrefix($prefix)) {
            require_once 'Erfurt/Namespaces/Exception.php';
            throw new Erfurt_Namespaces_Exception("Given prefix '$prefix' is not a valid XML name.");
        }

        // check if prefix matches a URI scheme (http://www.iana.org/assignments/uri-schemes.html)
        if (array_key_exists($prefix, $this->_reservedNames)) {
            require_once 'Erfurt/Namespaces/Exception.php';
            throw new Erfurt_Namespaces_Exception("Reserved name '$prefix' cannot be used as a namespace prefix.");
        }

        // check for existence of prefixes
        if (array_key_exists($prefix, $graphPrefixes)) {
            require_once 'Erfurt/Namespaces/Exception.php';
            throw new Erfurt_Namespaces_Exception("Prefix '$prefix' already exists.");
        }

        // check for multiple prefixes
        if (!$this->_allowMultiplePrefixes and array_key_exists($namespace, array_flip($graphPrefixes))) {
            require_once 'Erfurt/Namespaces/Exception.php';
            throw new Erfurt_Namespaces_Exception("Multiple prefixes for namespace '$namespace' not allowed.");
        }

        // add new prefix
        $graphPrefixes[$prefix] = $namespace;

        // save new set of prefixes
        $this->setNamespacesForGraph($graph, $graphPrefixes);
    }

    /**
     * Removes the prefix for the namespaces URI in a given graph.
     *
     * @param string $graph
     * @param string $prefix
     */
    public function deleteNamespacePrefix($graph, $prefix)
    {
        $graphPrefixes = $this->getNamespacesForGraph($graph);

        if (array_key_exists($prefix, $graphPrefixes)) {
            unset($graphPrefixes[$prefix]);
        }

        $this->setNamespacesForGraph($graph, $graphPrefixes);
    }

    public function getModel($graph)
    {
        if (!is_object($graph)) {
            $store = Erfurt_App::getInstance()->getStore();
            // we need to read from the system config even though the user
            // may have no direct access to it
            $graph = $store->getModel($graph, false);
        }

        return $graph;
    }

    /**
     * Returns the prefix for the namespace URI in a given graph.
     *
     * If more than one prefixes are stored for the given namespace,
     * the first one in alphabetical order is returned.
     *
     * @param string $graph
     * @param string $namespace
     * @return string|null
     */
    public function getNamespacePrefix($graph, $namespace)
    {
        $graphPrefixes = $this->getNamespacesForGraph($graph);

        // sort reverse alphabetical
        krsort($graphPrefixes);

        // invert keys <=> values
        $prefixesByNs = array_flip($graphPrefixes);

        $prefix = null;

        // stored prefix
        if (array_key_exists($namespace, $prefixesByNs)) {
            $prefix = $prefixesByNs[$namespace];
        } else {
            // try standard prefix
            if (array_key_exists($namespace, $this->_standardPrefixes)) {
                $prefix = $this->_standardPrefixes[$namespace];
            } else {
                // synthesize prefix
                do {
                    $k = isset($k) ? $k+1 : 0;
                    $prefix = 'ns' . $k;
                } while (array_key_exists($prefix, $graphPrefixes));
            }

            // store standard or synthetic prefix
            $this->addNamespacePrefix($graph, $namespace, $prefix);
        }

        return $prefix;
    }

    /**
     * Returns all namespace prefixes for a given graph.
     *
     * @param string $graph
     * @return array
     */
    public function getNamespacePrefixes($graph)
    {
        return $this->getNamespacesForGraph($graph);
    }

    /**
     * Returns the stored namespaces indexed by their prefixes for a
     * given graph URI.
     *
     * @param string $graph The graph URI
     * @return array
     */
    public function getNamespacesForGraph($graph)
    {
        $model = $this->getModel($graph);
        $graph = (string)$graph;

        if (!array_key_exists($graph, $this->_namespaces)) {
            $graphNamespaces = array();

            // load graph configuration froms store
            $prefixOptions = (array)$model->getOption(self::PREFIX_PREDICATE);

            foreach ($prefixOptions as $entry) {
                // split raw config string
                $parts     = isset($entry['value']) ? explode('=', $entry['value']) : array();
                $prefix    = isset($parts[0]) ? $parts[0] : '';
                $namespace = isset($parts[1]) ? $parts[1] : null;

                // store only if namespace is valid
                if (null !== $namespace) {
                    $graphNamespaces[$prefix] = $namespace;
                }
            }

            // add to global store
            $this->_namespaces[$graph] = $graphNamespaces;
        }

        return $this->_namespaces[$graph];
    }

    /**
     * Sets the namespace configuration for a given graph.
     *
     * @param string $graph
     * @param array|null $namespaces
     */
    public function setNamespacesForGraph($graph, $namespaces = null)
    {
        $model      = $this->getModel($graph);
        $graph      = (string)$graph;
        $namespaces = (array)$namespaces;

        $newValues = array();
        foreach ($namespaces as $prefix => $namespace) {
            $rawValue = $prefix
                . '='
                . $namespace;

            array_push($newValues, array('value' => $rawValue, 'type' => 'literal'));
        }

        try {
            // will fail if model is not writable
            $model->setOption(self::PREFIX_PREDICATE, $newValues);

            // update locally
            $this->_namespaces[$graph] = $namespaces;
        } catch (Erfurt_Exception $e) {
            require_once 'Erfurt/Namespaces/Exception.php';
            throw new Erfurt_Namespaces_Exception(
                "Insufficient privileges to edit namespace prefixes for graph '$graph'.");
        }
    }

    /**
     * check if a namespace prefix is registered in the given graph
     *
     * @param string $graph
     * @param string $prefix
     */
    public function hasNamespaceByPrefix($graph, $prefix)
    {
        $graphPrefixes = $this->getNamespacesForGraph($graph);

        if (array_key_exists($prefix, $graphPrefixes)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * returns the namespace uri to a given namespace prefix
     *
     * @param string $graph
     * @param string $prefix
     */
    public function getNamespaceByPrefix($graph, $prefix)
    {
        if (!$this->hasNamespaceByPrefix($graph, $prefix)) {
            throw new Erfurt_Namespaces_Exception('The given namespace prefix is not registered.');
        } else {
            $graphPrefixes = $this->getNamespacesForGraph($graph);
            return $graphPrefixes[$prefix];
        }
    }
}
