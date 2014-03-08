<?php
/**
 * This file is part of the {@link http://erfurt-framework.org Erfurt} project.
 *
 * @copyright Copyright (c) 2014, {@link http://aksw.org AKSW}
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class Erfurt_UriTest extends Erfurt_TestCase
{
    public function testCheck()
    {
        $validUris = array(
            'http://example.com/Test',
            'urn:isbn:978-3-86680-192-9',
            'ftp://ftp.is.co.za/rfc/rfc1808.txt',
            'gopher://spinaltap.micro.umn.edu/00/Weather/California/Los%20Angeles',
            'http://www.math.uio.no/faq/compression-faq/part1.html',
            'mailto:mduerst@ifi.unizh.ch',
            'news:comp.infosystems.www.servers.unix',
            'telnet://melvyl.ucop.edu/',
            'http://User:pass@example.com/test/cat?foo=ba%7C'
        );

        foreach ($validUris as $uri) {
            $this->assertEquals(true, Erfurt_Uri::check($uri));
        }

        $invalidUris = array(
            'Literal value',
            'http://example.com /Test',
            "http://example.com/T\nest",
            'http://example.[com]/{test}/cat?foo=ba%7C'
        );

        foreach ($invalidUris as $uri) {
            $this->assertEquals(false, Erfurt_Uri::check($uri));
        }
    }

    public function testNormalize()
    {
        $uri        = 'HTtP://User:pA:897@ExaMPLe.COM/test/cat?foo=ba%7C';
        $normalized = 'http://User:pA:897@example.com/test/cat?foo=ba%7C';

        $this->assertEquals($normalized, Erfurt_Uri::normalize($uri));
    }

    public function testNormalizeWithNonUri()
    {
        $this->setExpectedException('Erfurt_Uri_Exception');

        $nonUri = "HTtP://User:pA:89\t7@ExaMPLe.COM/test/cat?foo=ba%7C";
        Erfurt_Uri::normalize($nonUri);
    }

    public function testGetPathTo()
    {
        $uris = array(
            // stepping in 1 step
            array(
                'http://d.tld/a.html',
                'http://d.tld/x/b.html',
                './x/b.html'
            ),
            // stepping in 2 steps
            array(
                'http://d.tld/a.html',
                'http://d.tld/x/y/b.html',
                './x/y/b.html'
            ),
            // stepping in 3 steps
            array(
                'http://d.tld/a.html',
                'http://d.tld/x/y/z/b.html',
                './x/y/z/b.html'
            ),
            // in same folder, stepping in 2 steps
            array(
                'http://d.tld/x/a.html',
                'http://d.tld/x/y/z/b.html',
                './y/z/b.html'
            ),
            // in same folder, stepping in 1 step
            array(
                'http://d.tld/x/y/a.html',
                'http://d.tld/x/y/z/b.html',
                './z/b.html'
            ),
            // in same folder => return only target file name
            array(
                'http://d.tld/x/y/z/a.html',
                'http://d.tld/x/y/z/b.html',
                './b.html'
            ),
            // stepping out 3 steps
            array(
                'http://d.tld/x/y/z/a.html',
                'http://d.tld/b.html',
                './../../../b.html'
            ),
            // stepping out 2 steps
            array(
                'http://d.tld/x/y/a.html',
                'http://d.tld/b.html',
                './../../b.html'
            ),
            // stepping out 1 step
            array(
                'http://d.tld/x/a.html',
                'http://d.tld/b.html',
                './../b.html'
            ),
            // different folders, 1 out, 3 in
            array(
                'http://d.tld/x/a.html',
                'http://d.tld/m/n/o/b.html',
                './../m/n/o/b.html'
            ),
            // different folders, 2 out, 3 in
            array(
                'http://d.tld/x/y/a.html',
                'http://d.tld/m/n/o/b.html',
                './../../m/n/o/b.html'
            ),
            // different folders, 3 out, 3 in
            array(
                'http://d.tld/x/y/z/a.html',
                'http://d.tld/m/n/o/b.html',
                './../../../m/n/o/b.html'
            ),
            // different folders, 3 out, 3 in
            array(
                'http://d.tld/x/y/z/a.html',
                'http://d.tld/m/n/o/b.html',
                './../../../m/n/o/b.html'
            ),
            // different folders, 3 out, 2 in
            array(
                'http://d.tld/x/y/z/a.html',
                'http://d.tld/m/n/b.html',
                './../../../m/n/b.html'
            ),
            // different folders, 3 out, 1 in
            array(
                'http://d.tld/x/y/z/a.html',
                'http://d.tld/m/b.html',
                './../../../m/b.html'
            ),
            // domains are not matching => return unmodified target
            array(
                'http://d1.tld/a.html',
                'http://d2.tld/b.html',
                'http://d2.tld/b.html'
            ),
            // top level domains are not matching => return unmodified target
            array(
                'http://d.tld1/a.html',
                'http://d.tld2/b.html',
                'http://d.tld2/b.html'
            ),
            // protocols are not matching => return unmodified target
            array(
                'http://d.tld/a.html',
                'https://d.tld/b.html',
                'https://d.tld/b.html'
            ),
        );
        foreach ($uris as $set) {
            $path = Erfurt_Uri::getPathTo($set[0], $set[1]);
            $this->assertEquals($set[2], $path);
        }
    }
}

