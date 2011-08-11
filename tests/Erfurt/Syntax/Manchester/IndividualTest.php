<?php
require_once 'Erfurt/TestCase.php';
require_once 'test_base.php';
set_include_path(get_include_path() . PATH_SEPARATOR . '../../ontowiki/src/libraries/');

class Erfurt_Syntax_Manchester_IndividualTest extends PHPUnit_Framework_TestCase {

    private function initParser($inputQuery) {
        require_once 'antlr/Php/antlr.php';
        $input = new ANTLRStringStream($inputQuery);
        $lexer = new Erfurt_Syntax_ManchesterLexer($input);
        $tokens = new CommonTokenStream($lexer);
        return new Erfurt_Syntax_ManchesterParser($tokens);
    }

    /**
     * @dataProvider providerParser
     */
    public function TestParser($method, $inputQuery) {
        $q = $this->initParser($inputQuery)->$method();
        $this->assertEquals($inputQuery, $q->__toString());
    }

    public function providerParser() {
        return array(
            array("description", "class1 and class2"),
            array("description", "class1 or class2"),
            array("description", "class1 or class2 or class3"),
            array("description", "class1 or class2 and class3"),
            array("description", "class1 or class2 and class3 or class4"),

            array("literal", '"aaa"'),
            array("literal", '"aaa"@sw'),
            array("literal", '12.22'),
            array("literal", '122'),
            array("literal", '-12.22e33f'),
            array("literal", '"aaa"^^some:type'),
            array("literal", '"aaa"^^nonamespacetype'),

            array("dataTypeRestriction", "integer [>= 150]"),
            array("dataTypeRestriction", "integer [<= 0, >= 150]"),

            array("conjunction", 'ab'),
            array("conjunction", 'a and b'),
            array("conjunction", 'a1 and b1 and c1 and d1'),
            array("conjunction", 'a1 and b1 and c1'),

            array("restriction", 'hasParent some John'),
//        array("restriction",'hasParent some John'),
            array("restriction", 'hasParent only John'),
            array("restriction", 'hasParent value John'),
            array("restriction", 'hasParent Self'),
            array("restriction", 'hasParent min 5 John'),
            array("restriction", 'hasParent max 5 not John'),
            array("restriction", 'hasParent exactly 5 John'),


            array("dataRange", 'aaa'),
            array("dataRange", 'integer [> 5]'),
            array("dataRange", '{"aaa", "bbb"}'),

            array("restriction", 'hasParent some float [< 4]'),
            array("restriction", 'hasParent only integer [> 333]'),
            array("restriction", 'hasParent value "John"@dd'),
            array("restriction", 'hasParent min 5 (integer [<= 222])'),
            array("restriction", 'hasParent max 5 (integer [> 22])'),
            array("restriction", 'hasParent max 5 ({"s", "w", 12})'),
            array("restriction", 'hasParent exactly 5'),

            array("restriction", 'hasAge some integer [< 12, >= 19]'),

            array("dataConjunction", 'not float [< 4]'),
            array("dataConjunction", 'not float [< 4] and integer [>= 5]'),
            array("dataConjunction", 'not float [< 4]'),
        );
    }

    public function testIndividualFrame() {
        //TODO fix string template
        //     $inputQuery = 'Individual: Mary Types: Person';
        //     $q = $this->initParser($inputQuery)->individualFrame();
        //     $this->assertEquals($inputQuery, $q->__toString());
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testClassFrame() {
             $inputQuery = 'Class: Woman SubClassOf: Person';
             $q = $this->initParser($inputQuery)->classFrame();
             $this->assertEquals($inputQuery, $q->__toString());

//        $this->markTestIncomplete('This test has not been implemented yet.');
    }

}
