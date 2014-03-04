<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class Erfurt_UtilsTest extends Erfurt_TestCase
{
    public function testBuildLiteralString()
    {
        $literals = array(
            array('"false"^^<http://www.w3.org/2001/XMLSchema#boolean>', 'false', 'http://www.w3.org/2001/XMLSchema#boolean', null, true),
            array('"false"^^<http://www.w3.org/2001/XMLSchema#boolean>', '0', 'http://www.w3.org/2001/XMLSchema#boolean', null, true),
            array('"false"^^<http://www.w3.org/2001/XMLSchema#boolean>', false, 'http://www.w3.org/2001/XMLSchema#boolean', null, true),
            array('"true"^^<http://www.w3.org/2001/XMLSchema#boolean>', 'true', 'http://www.w3.org/2001/XMLSchema#boolean', null, true),
            array('"true"^^<http://www.w3.org/2001/XMLSchema#boolean>', '1', 'http://www.w3.org/2001/XMLSchema#boolean', null, true),
            array('"true"^^<http://www.w3.org/2001/XMLSchema#boolean>', true, 'http://www.w3.org/2001/XMLSchema#boolean', null, true),
            array('"123456789"^^<http://www.w3.org/2001/XMLSchema#int>', '123456789', 'http://www.w3.org/2001/XMLSchema#int', null, true),
            array('"1234.56789"^^<http://www.w3.org/2001/XMLSchema#float>', '1234.56789', 'http://www.w3.org/2001/XMLSchema#float', null, true),
            array('"Hallo"@de', 'Hallo', null, 'de', true),
            array('"Hello"@en-US', 'Hello', null, 'en-US', true),
            array(
                '"Mit Backslash \\\\ im Text"^^<http://www.w3.org/2001/XMLSchema#string>',
                'Mit Backslash \\ im Text', 'http://www.w3.org/2001/XMLSchema#string', null, true
            ),
            array(
                "\"\"\"This\nis\na\nmulti\nline\ntext\"\"\"^^<http://www.w3.org/2001/XMLSchema#string>",
                "This\nis\na\nmulti\nline\ntext", 'http://www.w3.org/2001/XMLSchema#string', null, true
            ),
            array(
                "'''This\nis\na\n\"\"\"multi\nline\"\"\"\ntext'''^^<http://www.w3.org/2001/XMLSchema#string>",
                "This\nis\na\n\"\"\"multi\nline\"\"\"\ntext", 'http://www.w3.org/2001/XMLSchema#string', null, true
            ),
            array(
                '"This\nis\na\nmulti\nline\ntext"^^<http://www.w3.org/2001/XMLSchema#string>',
                "This\nis\na\nmulti\nline\ntext", 'http://www.w3.org/2001/XMLSchema#string', null, false
            ),
            array(
                '"Literal with\tTab"^^<http://www.w3.org/2001/XMLSchema#string>',
                "Literal with\tTab", 'http://www.w3.org/2001/XMLSchema#string', null, true
            ),
        );

        foreach ($literals as $literalDesc) {
            $literal = $literalDesc[0];
            $value = $literalDesc[1];
            $datatype = $literalDesc[2];
            $lang = $literalDesc[3];
            $longString = $literalDesc[4];

            $this->assertEquals(
                $literal,
                Erfurt_Utils::buildLiteralString(
                    $value,
                    $datatype,
                    $lang,
                    $longString
                )
            );
        }
    }
}
