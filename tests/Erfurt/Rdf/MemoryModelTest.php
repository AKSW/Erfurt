<?php
class Erfurt_Rdf_MemoryModelTest extends Erfurt_TestCase
{
    public function setUp()
    {
        $this->fixture = new Erfurt_Rdf_MemoryModel();
    }

    public function testEmpty()
    {
        $this->assertCount(0, $this->fixture->getStatements());
    }


    /**
     * @expectedException Erfurt_Exception
     **/
    public function testHasSbool()
    {
        $this->fixture->hasS(true);
    }

    /**
     * @expectedException Erfurt_Exception
     **/
    public function testHasSint()
    {
        $this->fixture->hasS(1);
    }

    /**
     * @expectedException Erfurt_Exception
     **/
    public function testHasSarray()
    {
        $this->fixture->hasS(array());
    }

    public function testHasSwrong()
    {
        $this->assertFalse($this->fixture->hasS('http://e.org/not-available'));
    }

    public function testAddRelationCorrect()
    {
        $this->fixture->addRelation('http://e.org/r1', 'http://e.org/p1', 'http://e.org/r2');
        $this->fixture->addRelation('http://e.org/r1', 'http://e.org/p1', 'http://e.org/r3');
        $this->assertTrue($this->fixture->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 'http://e.org/r2'));
        $this->assertTrue($this->fixture->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 'http://e.org/r3'));
        $this->assertEquals(2, $this->fixture->countSP('http://e.org/r1', 'http://e.org/p1'));
        return $this->fixture;
    }

    public function testAddAttributeCorrect()
    {
        $this->fixture->addAttribute('http://e.org/r1', 'http://e.org/p1', 'a-literal');
        $this->fixture->addAttribute('http://e.org/r1', 'http://e.org/p1', 10);
        $this->assertTrue($this->fixture->hasSP('http://e.org/r1', 'http://e.org/p1'));
        $this->assertTrue($this->fixture->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 'a-literal'));
        $this->assertTrue($this->fixture->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 10));
        $this->assertTrue($this->fixture->hasSPvalue('http://e.org/r1', 'http://e.org/p1', '10'));
        return $this->fixture;
    }

    /**
     * @depends testAddAttributeCorrect
     */
    public function testGetSP($fixture)
    {
        $fixture2 = clone $fixture;
        $oExist = array('type' => 'literal', 'value' => 'a-literal');
        $oNotExist = array('type' => 'literal', 'value' => 'no-existing');
        $this->assertCount(1, $fixture2->getSP($oExist));
        $this->assertCount(0, $fixture2->getSP($oNotExist));
    }

    /**
     * @depends testAddAttributeCorrect
     */
    public function testGetSubjects($fixture)
    {
        $fixture2 = clone $fixture;
        $this->assertCount(1, $fixture2->getSubjects());
        $fixture2->addAttribute('http://e.org/r2', 'http://e.org/p1', 10);
        $this->assertCount(2, $fixture2->getSubjects());
    }

    /**
     * @depends testAddAttributeCorrect
     */
    public function testRemoveS($fixture)
    {
        $fixture2 = clone $fixture;
        $fixture2->removeS('http://e.org/r1');
        $this->assertFalse($fixture2->hasSP('http://e.org/r1', 'http://e.org/p1'));
        $this->assertFalse($fixture2->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 'a-literal'));
        $this->assertFalse($fixture2->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 10));
    }

    /**
     * @depends testAddAttributeCorrect
     */
    public function testRemoveSP($fixture)
    {
        $fixture2 = clone $fixture;
        $fixture2->removeSP('http://e.org/r1', 'http://e.org/p1');
        $this->assertFalse($fixture2->hasSP('http://e.org/r1', 'http://e.org/p1'));
        $this->assertFalse($fixture2->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 'a-literal'));
        $this->assertFalse($fixture2->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 10));
    }

    /**
     * @depends testAddAttributeCorrect
     */
    public function testHasSCorrect($fixture)
    {
        $this->assertTrue($fixture->hasS('http://e.org/r1'));
        $this->assertFalse($fixture->hasS('http://e.org/r2'));
    }

    /**
     * @depends testAddAttributeCorrect
     */
    public function testHasSPCorrect($fixture)
    {
        $this->assertTrue($fixture->hasSP('http://e.org/r1', 'http://e.org/p1'));
        $this->assertFalse($fixture->hasSP('http://e.org/r2', 'http://e.org/p1'));
        $this->assertFalse($fixture->hasSP('http://e.org/r1', 'http://e.org/p2'));
        $this->assertFalse($fixture->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 'another-literal'));
        $this->assertTrue($fixture->hasSPvalue('http://e.org/r1', 'http://e.org/p1', '/.*literal/', 'preg'));
    }

    /**
     * @depends testAddAttributeCorrect
     */
    public function testHasSPvalueCorrect($fixture)
    {
        $this->assertTrue($fixture->hasSP('http://e.org/r1', 'http://e.org/p1'));
        $this->assertFalse($fixture->hasSP('http://e.org/r2', 'http://e.org/p1'));
        $this->assertFalse($fixture->hasSP('http://e.org/r1', 'http://e.org/p2'));
        $this->assertFalse($fixture->hasSPvalue('http://e.org/r1', 'http://e.org/p1', 'another-literal'));
        $this->assertTrue($fixture->hasSPvalue('http://e.org/r1', 'http://e.org/p1', '/.*literal/', 'preg'));
    }
}
