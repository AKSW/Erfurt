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
            'http://User:pass@example.com/test/cat?foo=ba%7C',
            'http://bio2rdf.org/bio2rdf_dataset:bio2rdf-sgd-20121015'
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

    public function testGetFromQnameOrUri()
    {
        $testValues = array(
            'foaf:Person' => 'http://xmlns.com/foaf/0.1/Person',
            'owl:sameAs' => 'http://www.w3.org/2002/07/owl#sameAs',
            'http://www.w3.org/1999/02/22-rdf-syntax-ns#type' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type',
            'ex:hallo' => 'http://example.org/hallo',
            'exs:secure' => 'https://example.org/secure',
            'http://aksw.org/About' => 'http://aksw.org/About',
            'http:you' => 'http://example.http.server.eu/hello/you',
            'b2rds:bio2rdf-sgd-20121015' => 'http://bio2rdf.org/bio2rdf_dataset:bio2rdf-sgd-20121015',
            'http://example.com/Test'                                              => 'http://example.com/Test',
            'urn:isbn:978-3-86680-192-9'                                           => 'urn:isbn:978-3-86680-192-9',
            'ftp://ftp.is.co.za/rfc/rfc1808.txt'                                   => 'ftp://ftp.is.co.za/rfc/rfc1808.txt',
            'gopher://spinaltap.micro.umn.edu/00/Weather/California/Los%20Angeles' => 'gopher://spinaltap.micro.umn.edu/00/Weather/California/Los%20Angeles',
            'http://www.math.uio.no/faq/compression-faq/part1.html'                => 'http://www.math.uio.no/faq/compression-faq/part1.html',
            'mailto:mduerst@ifi.unizh.ch'                                          => 'mailto:mduerst@ifi.unizh.ch',
            'telnet://melvyl.ucop.edu/'                                            => 'telnet://melvyl.ucop.edu/',
            'http://User:pass@example.com/test/cat?foo=ba%7C'                      => 'http://User:pass@example.com/test/cat?foo=ba%7C',
            'http://bio2rdf.org/bio2rdf_dataset:bio2rdf-sgd-20121015'              => 'http://bio2rdf.org/bio2rdf_dataset:bio2rdf-sgd-20121015',
        );
        /**
         * TODO find out, what to do with 'news:comp.infosystems.www.servers.unix', it could be a
         * qname and a URI. Should we first check if it is a URI and just not follow the Qname
         * theory in this case?
         */

        $model = $this->_getMockedModel();

        foreach ($testValues as $input => $output) {
            $this->assertEquals($output, Erfurt_Uri::getFromQnameOrUri($input, $model));
        }
    }

    protected function _getMockedModel()
    {
        $model = $this->getMock('Erfurt_Rdf_Model', // original class name
            array('getNamespaceByPrefix'),          // method to mock
            array('http://base.de/')                // constructor params
        );

        $namespaces = array(
            array('ex', 'http://example.org/'),
            array('exs', 'https://example.org/'),
            array('foaf', 'http://xmlns.com/foaf/0.1/'),
            array('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#'),
            array('rdfs', 'http://www.w3.org/2000/01/rdf-schema#'),
            array('owl', 'http://www.w3.org/2002/07/owl#'),
            array('b2rds', 'http://bio2rdf.org/bio2rdf_dataset:'),
            array('http', 'http://example.http.server.eu/hello/'),
        );

        $model->expects($this->any())
              ->method('getNamespaceByPrefix')
              ->will($this->returnValueMap($namespaces));

        return $model;
    }
}

