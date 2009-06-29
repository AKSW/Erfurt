<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @version    $Id: Placeholder.php 7078 2007-12-11 14:29:33Z matthew $
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/** Zend_View_Helper_Placeholder_Container_Standalone */
require_once 'Zend/View/Helper/Placeholder/Container/Standalone.php';

/**
 * Zend_Layout_View_Helper_HeadLink
 *
 * @see        http://www.w3.org/TR/xhtml1/dtds.html
 * @uses       Zend_View_Helper_Placeholder_Container_Standalone
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_View_Helper_HeadLink extends Zend_View_Helper_Placeholder_Container_Standalone
{
    /**
     * $_validAttributes
     *
     * @var array
     */
    protected $_itemKeys = array('charset', 'href', 'hreflang', 'media', 'rel', 'rev', 'type', 'title');

    /**
     * @var string registry key
     */
    protected $_regKey = 'Zend_View_Helper_HeadLink';

    /**
     * Constructor
     *
     * Use PHP_EOL as separator
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setSeparator(PHP_EOL);
    }

    /**
     * headLink() - View Helper Method
     *
     * Returns current object instance. Optionally, allows passing array of
     * values to build link.
     *
     * @return Zend_View_Helper_HeadLink
     */
    public function headLink(array $attributes = null, $placement = Zend_View_Helper_Placeholder_Container_Abstract::APPEND)
    {
        if (null !== $attributes) {
            $item = $this->createData($attributes);
            switch ($placement) {
                case Zend_View_Helper_Placeholder_Container_Abstract::SET:
                    $this->set($item);
                    break;
                case Zend_View_Helper_Placeholder_Container_Abstract::PREPEND:
                    $this->prepend($item);
                    break;
                case Zend_View_Helper_Placeholder_Container_Abstract::APPEND:
                default:
                    $this->append($item);
                    break;
            }
        }
        return $this;
    }

    /**
     * Overload method access
     *
     * Creates the following virtual methods:
     * - appendStylesheet($href, $media, $conditionalStylesheet)
     * - offsetSetStylesheet($index, $href, $media, $conditionalStylesheet)
     * - prependStylesheet($href, $media, $conditionalStylesheet)
     * - setStylesheet($href, $media, $conditionalStylesheet)
     * - appendAlternate($href, $type, $title)
     * - offsetSetAlternate($index, $href, $type, $title)
     * - prependAlternate($href, $type, $title)
     * - setAlternate($href, $type, $title)
     *
     * Items that may be added in the future:
     * - Navigation?  need to find docs on this
     *   - public function appendStart()
     *   - public function appendContents()
     *   - public function appendPrev()
     *   - public function appendNext()
     *   - public function appendIndex()
     *   - public function appendEnd()
     *   - public function appendGlossary()
     *   - public function appendAppendix()
     *   - public function appendHelp()
     *   - public function appendBookmark()
     * - Other?
     *   - public function appendCopyright()
     *   - public function appendChapter()
     *   - public function appendSection()
     *   - public function appendSubsection()
     *
     * @param mixed $method
     * @param mixed $args
     * @return void
     */
    public function __call($method, $args)
    {
        if (preg_match('/^(?P<action>set|(ap|pre)pend|offsetSet)(?P<type>Stylesheet|Alternate)$/', $method, $matches)) {
            $argc   = count($args);
            $action = $matches['action'];
            $type   = $matches['type'];
            $index  = null;

            if ('offsetSet' == $action) {
                if (0 < $argc) {
                    $index = array_shift($args);
                    --$argc;
                }
            }

            if (1 > $argc) {
                require_once 'Zend/View/Exception.php';
                throw new Zend_View_Exception(sprintf('%s requires at least one argument', $method));
            }

            if (is_array($args[0])) {
                $item = $this->createData($args[0]);
            } else {
                $dataMethod = 'createData' . $type;
                $item       = $this->$dataMethod($args);
            }

            if ($item) {
                if ('offsetSet' == $action) {
                    $this->offsetSet($index, $item);
                } else {
                    $this->$action($item);
                }
            }

            return $this;
        }

        return parent::__call($method, $args);
    }

    /**
     * Check if value is valid
     *
     * @param  mixed $value
     * @return boolean
     */
    protected function _isValid($value)
    {
        if (!$value instanceof stdClass) {
            return false;
        }

        $vars         = get_object_vars($value);
        $keys         = array_keys($vars);
        $intersection = array_intersect($this->_itemKeys, $keys);
        if (empty($intersection)) {
            return false;
        }

        return true;
    }

    /**
     * append()
     *
     * @param  array $value
     * @return void
     */
    public function append($value)
    {
        if (!$this->_isValid($value)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('append() expects a data token; please use one of the custom append*() methods');
        }

        return $this->getContainer()->append($value);
    }

    /**
     * offsetSet()
     *
     * @param  string|int $index
     * @param  array $value
     * @return void
     */
    public function offsetSet($index, $value)
    {
        if (!$this->_isValid($value)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('offsetSet() expects a data token; please use one of the custom offsetSet*() methods');
        }

        return $this->getContainer()->offsetSet($index, $value);
    }

    /**
     * prepend()
     *
     * @param  array $value
     * @return Zend_Layout_ViewHelper_HeadLink
     */
    public function prepend($value)
    {
        if (!$this->_isValid($value)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('prepend() expects a data token; please use one of the custom prepend*() methods');
        }

        return $this->getContainer()->prepend($value);
    }

    /**
     * set()
     *
     * @param  array $value
     * @return Zend_Layout_ViewHelper_HeadLink
     */
    public function set($value)
    {
        if (!$this->_isValid($value)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception('set() expects a data token; please use one of the custom set*() methods');
        }

        return $this->getContainer()->set($value);
    }


    /**
     * Create HTML link element from data item
     *
     * @param  stdClass $item
     * @return string
     */
    public function itemToString(stdClass $item)
    {
        $attributes = (array) $item;
        $link       = '<link ';

        foreach ($this->_itemKeys as $itemKey) {
            if (isset($attributes[$itemKey])) {
                $link .= sprintf('%s="%s" ', $itemKey, ($this->_autoEscape) ? $this->_escape($attributes[$itemKey]) : $attributes[$itemKey]);
            }
        }

        if ($this->view instanceof Zend_View_Abstract) {
            $link .= ($this->view->doctype()->isXhtml()) ? '/>' : '>';
        } else {
            $link .= '/>';
        }

        if (($link == '<link />') || ($link == '<link >')) {
            return '';
        }

        if (isset($attributes['conditionalStylesheet'])
            && (false !== $attributes['conditionalStylesheet']))
        {
            $link = '<!--[if ' . $attributes['conditionalStylesheet'] . ']> ' . $link . '<![endif]-->';
        }

        return $link;
    }

    /**
     * Render link elements as string
     *
     * @param  string|int $indent
     * @return string
     */
    public function toString($indent = null)
    {
        $indent = (null !== $indent)
                ? $this->getWhitespace($indent)
                : $this->getIndent();

        $items = array();
        foreach ($this as $item) {
            $items[] = $this->itemToString($item);
        }

        return $indent . implode($this->_escape($this->getSeparator()) . $indent, $items);
    }

    /**
     * Create data item for stack
     *
     * @param  array $attributes
     * @return stdClass
     */
    public function createData(array $attributes)
    {
        $data = (object) $attributes;
        return $data;
    }

    /**
     * Create item for stylesheet link item
     *
     * @param  array $args
     * @return stdClass|false Returns fals if stylesheet is a duplicate
     */
    public function createDataStylesheet(array $args)
    {
        $rel                   = 'stylesheet';
        $type                  = 'text/css';
        $media                 = 'screen';
        $conditionalStylesheet = false;
        $href                  = array_shift($args);

        if ($this->_isDuplicateStylesheet($href)) {
            return false;
        }

        if (0 < count($args)) {
            $media = array_shift($args);
            $media = (string) $media;
        }
        if (0 < count($args)) {
            $conditionalStylesheet = array_shift($args);
            if (false !== $conditionalStylesheet) {
                $conditionalStylesheet = (string) $conditionalStylesheet;
            }
        }

        $attributes = compact('rel', 'type', 'href', 'media', 'conditionalStylesheet');
        return $this->createData($attributes);
    }

    /**
     * Is the linked stylesheet a duplicate?
     *
     * @param  string $uri
     * @return bool
     */
    protected function _isDuplicateStylesheet($uri)
    {
        foreach ($this->getContainer() as $item) {
            if (($item->rel == 'stylesheet') && ($item->href == $uri)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Create item for alternate link item
     *
     * @param  array $args
     * @return stdClass
     */
    public function createDataAlternate(array $args)
    {
        if (3 > count($args)) {
            require_once 'Zend/View/Exception.php';
            throw new Zend_View_Exception(sprintf('Alternate tags require 3 arguments; %s provided', count($args)));
        }

        $rel   = 'alternate';
        $href  = array_shift($args);
        $type  = array_shift($args);
        $title = array_shift($args);

        $href  = (string) $href;
        $type  = (string) $type;
        $title = (string) $title;

        $attributes = compact('rel', 'href', 'type', 'title');
        return $this->createData($attributes);
    }
}
