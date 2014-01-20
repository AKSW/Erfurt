<?php

/**
 * Tests the util methods for result set handling.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 31.12.13
 */
class Erfurt_Store_Adapter_Oracle_ResultConverter_UtilTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Ensures that getVariables() returns an empty array if the provided
     * result set is empty.
     */
    public function testGetVariablesReturnsEmptyArrayIfResultSetIsEmpty()
    {
        $variables = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::getVariables(array());

        $this->assertEquals(array(), $variables);
    }

    /**
     * Checks if getVariables() returns the variable names from a raw result set.
     */
    public function testGetVariablesReturnsVariablesNames()
    {
        $variables = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::getVariables($this->getRawResultSet());

        $this->assertInternalType('array', $variables);
        $this->assertContains('SUBJECT', $variables);
        $this->assertContains('PREDICATE', $variables);
        $this->assertContains('OBJECT', $variables);
        $this->assertCount(3, $variables);
    }

    /**
     * Ensures that convertToType() does not change string values.
     */
    public function testConvertToTypeDoesNotChangeStrings()
    {
        $value    = 'Hello!';
        $dataType = 'http://www.w3.org/2001/XMLSchema#string';

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertToType($value, $dataType);

        $this->assertInternalType('string', $converted);
        $this->assertEquals($value, $converted);
    }

    /**
     * Checks if convertToType() converts integer values correctly.
     */
    public function testConvertToTypeConvertsIntegerCorrectly()
    {
        $value    = '42';
        $dataType = 'http://www.w3.org/2001/XMLSchema#integer';

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertToType($value, $dataType);

        $this->assertInternalType('integer', $converted);
        $this->assertEquals(42, $converted);
    }

    /**
     * Checks if convertToType() converts double values correctly.
     */
    public function testConvertToTypeConvertsDoubleCorrectly()
    {
        $value    = '42.42';
        $dataType = 'http://www.w3.org/2001/XMLSchema#float';

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertToType($value, $dataType);

        $this->assertInternalType('float', $converted);
        $this->assertEquals(42.42, $converted);
    }

    /**
     * Checks if convertToType() converts boolean values correctly.
     */
    public function testConvertToTypeConvertsBooleanCorrectly()
    {
        $value    = 'true';
        $dataType = 'http://www.w3.org/2001/XMLSchema#boolean';

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertToType($value, $dataType);

        $this->assertTrue($converted);
    }

    /**
     * Ensures that convertToType() can handle a missing data type (null).
     */
    public function testConvertToTypeCanHandleUntypedValue()
    {
        $value    = 'Hello!';
        $dataType = null;

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertToType($value, $dataType);

        $this->assertInternalType('string', $converted);
        $this->assertEquals($value, $converted);
    }

    /**
     * Ensures that convertToType() ignores custom types without raising an error.
     */
    public function testConvertToTypeIgnoresCustomType()
    {
        $value    = serialize(new stdClass());
        $dataType = 'http://example.org/object';

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertToType($value, $dataType);

        $this->assertInternalType('string', $converted);
        $this->assertEquals($value, $converted);
    }

    /**
     * Checks if encodeVariableName() encodes upper case characters in the
     * variable name via underscore.
     */
    public function testEncodeVariableNameEncodesUpperCaseCharactersViaUnderscore()
    {
        $variable = 'upperCase';

        $encoded = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::encodeVariableName($variable);

        $this->assertEquals('upper_case', $encoded);
    }

    /**
     * Ensures that encodeVariableName() escapes underscores in the original
     * variable name via underscore.
     */
    public function testEncodeVariableNameEscapesUnderscores()
    {
        $variable = 'under_score';

        $encoded = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::encodeVariableName($variable);

        $this->assertEquals('under__score', $encoded);
    }

    /**
     * Ensures that encodeVariableName() does not change variables that contain
     * only lower case characters.
     */
    public function testEncodeVariableNameDoesNotChangeLowerCaseVariables()
    {
        $variable = 'lowercase';

        $encoded = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::encodeVariableName($variable);

        $this->assertEquals('lowercase', $encoded);
    }

    /**
     * Checks if decodeVariableName() converts characters after underscores to uppercase.
     */
    public function testDecodeVariableNameChangesCharacterAfterUnderscoreToUppercase()
    {
        $name = 'upper_case';

        $decoded = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::decodeVariableName($name);

        $this->assertEquals('upperCase', $decoded);

    }

    /**
     * Ensures that decodeVariableName() does not change variable names without underscores.
     */
    public function testConverterDoesNotChangeVariableWithoutUnderscores()
    {
        $name = 'case';

        $decoded = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::decodeVariableName($name);

        $this->assertEquals('case', $decoded);
    }

    /**
     * Checks if decodeVariableName() restores escaped underscores ("__").
     */
    public function testConverterRestoresUnderscoresThatAreEscapedViaUnderscore()
    {
        $name = 'real__underscore';

        $decoded = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::decodeVariableName($name);

        $this->assertEquals('real_underscore', $decoded);
    }

    /**
     * Ensures that decodeVariableName() converts characters that are not prefixed by an underscore
     * to lower case.
     */
    public function testConverterChangesCharactersThatAreNotPrefixedByUnderscoreToLowercase()
    {
        $name = 'UPPER_CASE';

        $decoded = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::decodeVariableName($name);

        $this->assertEquals('upperCase', $decoded);
    }

    /**
     * Ensures that convertSingleToDoubleQuotes() does not modify a literal that is enclosed
     * by double quotes.
     */
    public function testConvertSingleToDoubleQuotesDoesNotModifyLiteralWithDoubleQuotes()
    {
        $literalValue = '"Hello \'world\'!"';

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertSingleToDoubleQuotes($literalValue);

        $this->assertEquals($literalValue, $converted);
    }

    /**
     * Ensures that convertSingleToDoubleQuotes() does not modify a long literal that is enclosed
     * by 3 double quotes.
     */
    public function testConvertSingleToDoubleQuotesDoesNotModifyLongLiteralWithDoubleQuotes()
    {
        $literalValue = '"""This is a long \'literal\'."""';

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertSingleToDoubleQuotes($literalValue);

        $this->assertEquals($literalValue, $converted);
    }

    /**
     * Checks if convertSingleToDoubleQuotes() rewrites a literal that is enclosed by single
     * quotes correctly.
     */
    public function testConvertSingleToDoubleQuotesRewritesSingleQuoteLiteral()
    {
        $literalValue = "'Hello \"world\"!'";

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertSingleToDoubleQuotes($literalValue);

        $expected = '"Hello \\"world\\"!"';
        $this->assertEquals($expected, $converted);
    }

    /**
     * Checks if convertSingleToDoubleQuotes() rewrites a long literal that is enclosed by 3 single
     * quotes correctly.
     */
    public function testConvertSingleToDoubleQuotesRewritesLongSingleQuoteLiteral()
    {
        $literalValue = "'''This is a long \"literal\".'''";

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertSingleToDoubleQuotes($literalValue);

        $expected = '"""This is a long \\"literal\\". """';
        $this->assertEquals($expected, $converted);
    }

    /**
     * Ensures that convertSingleToDoubleQuotes() even works if the provided literal
     * has a data type.
     */
    public function testConvertSingleToDoubleQuotesWorksIfLiteralHasDataType()
    {
        $literalValue = "'Hello \"world\"!'^^<http://www.w3.org/2001/XMLSchema#string>";

        $converted = Erfurt_Store_Adapter_Oracle_ResultConverter_Util::convertSingleToDoubleQuotes($literalValue);

        $expected = '"Hello \\"world\\"!"^^<http://www.w3.org/2001/XMLSchema#string>';
        $this->assertEquals($expected, $converted);
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
