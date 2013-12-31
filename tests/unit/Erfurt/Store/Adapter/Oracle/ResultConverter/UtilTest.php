<?php

/**
 * Tests the util methods for result set handling.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 31.12.13
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_UtilTest extends \PHPUnit_Framework_TestCase
{

    public function testGetVariablesReturnsEmptyArrayIfResultSetIsEmpty()
    {

    }

    public function testGetVariablesReturnsVariablesNames()
    {

    }

    public function testConvertToTypeDoesNotChangeStrings()
    {

    }

    public function testConvertToTypeConvertsIntegerCorrectly()
    {

    }

    public function testConvertToTypeConvertsDoubleCorrectly()
    {

    }

    public function testConvertToTypeCanHandleUntypedValue()
    {

    }

    public function testConvertToTypeIgnoresCustomType()
    {
        
    }

    /**
     * Returns an example result set.
     *
     * @return array(array(string=>string|null))
     */
    protected function getRawResultSet()
    {
        return array(
            array(
                'SUBJECT'           => 'http://www.example.org/subject',
                'SUBJECT$RDFVID'    => 7614293122126211127,
                'SUBJECT$_PREFIX'   => 'http://www.example.org/',
                'SUBJECT$_SUFFIX'   => 'subject',
                'SUBJECT$RDFVTYP'   => 'URI',
                'SUBJECT$RDFCLOB'   => null,
                'SUBJECT$RDFLTYP'   => null,
                'SUBJECT$RDFLANG'   => null,
                'PREDICATE'         => 'http://www.example.org/predicate',
                'PREDICATE$RDFVID'  => 8663359142594985318,
                'PREDICATE$_PREFIX' => 'http://www.example.org/',
                'PREDICATE$_SUFFIX' => 'predicate',
                'PREDICATE$RDFVTYP' => 'URI',
                'PREDICATE$RDFCLOB' => null,
                'PREDICATE$RDFLTYP' => null,
                'PREDICATE$RDFLANG' => null,
                'OBJECT'            => 'http://www.example.org/object',
                'OBJECT$RDFVID'     => 6944352155936009563,
                'OBJECT$_PREFIX'    => 'http://www.example.org/',
                'OBJECT$_SUFFIX'    => 'object',
                'OBJECT$RDFVTYP'    => 'URI',
                'OBJECT$RDFCLOB'    => null,
                'OBJECT$RDFLTYP'    => null,
                'OBJECT$RDFLANG'    => null,
                'SEM$ROWNUM'        => 1
            )
        );
    }

}
