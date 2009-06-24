<?php
require_once 'Erfurt/TestCase.php';
require_once 'Erfurt/Syntax/RdfParser/Adapter/Turtle.php';

class Erfurt_Syntax_RdfParser_Adapter_TurtleTest extends Erfurt_TestCase
{
    /**
     * @var Erfurt_Syntax_RdfParser_Adapter_Turtle
     * @access protected
     */
    protected $_object;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->_object    = new Erfurt_Syntax_RdfParser_Adapter_Turtle();   
    }
    
    
    public function testParseEmpty()
    {
        $data = '';
        
        $result = $this->_object->parseFromDataString($data);
        
        $this->assertEquals(0, count($result));
    }
    
    public function testParseComplexDataString()
    {
        $data = '@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
        @prefix ns0: <http://www.w3.org/2002/07/owl#> .
        @prefix ns1: <http://www.w3.org/2000/01/rdf-schema#> .

        <http://3ba.se/conferences/> rdf:type ns0:Ontology ;
                                     ns1:label "Conference Model" ;
                                     ns1:comment "Demo Model about Conferences and Semantic Web People" .';
        
        $result = $this->_object->parseFromDataString($data);
        
        $this->assertEquals(1, count($result));
        $this->assertEquals(3, count($result['http://3ba.se/conferences/']));
    }
    
    public function testParseComplex()
    {
        $data = '# Exported with the new Erfurt exporter classes...

        @prefix ns0: <http://www.w3.org/2002/07/owl#> .
        @prefix ns1: <http://www.w3.org/2000/01/rdf-schema#> .
        @prefix ns2: <http://3ba.se/conferences/> .
        @prefix ns3: <http://www.w3.org/2001/XMLSchema#> .
        @prefix ns4: <http://swrc.ontoware.org/ontology#> .
        @prefix ns5: <http://www.w3.org/2003/01/geo/wgs84_pos#> .
        @prefix ns6: <http://usefulinc.com/ns/doap#> .
        @prefix ns7: <http://dbpedia.> .
        @prefix ns8: <http://xmlns.com/foaf/0.1/> .
        @prefix ns9: <http://aksw.org/images/wikipedia-query.> .
        @prefix ns10: <http://aksw.org/Projects/> .
        @prefix ns11: <http://usefulinc.com/doap/licenses/> .
        @prefix ns12: <http://aksw.org/images/ontowiki-map-view.> .
        @prefix ns13: <http://powl.sourceforge.net/images/powl-screenshot.> .
        @prefix ns14: <http://sebastian.dietzold.de/rdf/foaf.> .
        @prefix ns15: <http://sebastian.dietzold.> .
        @prefix ns16: <http://softwiki.> .
        @prefix ns17: <http://purl.org/dc/elements/1.1/> .
        @prefix ns18: <http://www.informatik.uni-leipzig.de/~auer/publication/ontowiki.> .


        <http://3ba.se/conferences/> a ns0:Ontology ;
                                     ns1:comment "Demo Model about Conferences and Semantic Web People" ;
                                     ns1:label "Conference Model" .

        ns2:AIMSA2006 ns2:URL "http://aimsa2006.inrialpes.fr/"^^ns3:anyURI ;
                      ns2:acceptanceNotification "2006-06-10"^^ns3:date ;
                      ns2:camera-readySubmission "2006-06-30"^^ns3:date ;
                      ns2:end "2006-09-15"^^ns3:date ;
                      ns2:place "Varna, Bulgaria"^^ns3:string ;
                      ns2:price "300"^^ns3:integer ;
                      ns2:start "2006-09-13"^^ns3:date ;
                      ns2:submissionsDue "2006-04-15"^^ns3:date ;
                      ns4:title "12th International Conference on Artificial Intelligence: Methodology, Systems, Applications"^^ns3:string ;
                      ns4:year "2006" ;
                      a ns4:Conference ;
                      ns1:label "AIMSA2006" ;
                      ns5:lat "43.206667"^^ns3:float ;
                      ns5:long "27.918889"^^ns3:float .

        ns2:AKSW ns4:carriesOut ns2:OntoWiki, ns2:SoftWiki, ns2:Powl ;
                 ns4:head ns2:SrenAuer ;
                 ns4:member ns2:SrenAuer, ns2:SebastianDietzold, ns2:NormanHeino, ns2:PhilippFrischmuth, ns2:JensLehmann, ns2:ThomasRiechert, ns2:MuhammadAhtishamAslam ;
                 a ns4:ResearchGroup ;
                 ns1:label "Agile Knowledge Engineering and Semantic Web" .

        ns2:AMCIS2006 ns2:URL "http://amcis2006.aisnet.org"^^ns3:anyURI ;
                      ns2:end "2006-08-06"^^ns3:date ;
                      ns2:logo "http://amcis2006.aisnet.org/MEMO%20LOGO%20C%20red.jpg"^^ns3:anyURI ;
                      ns2:place "Acapulco, México"@en ;
                      ns2:start "2006-08-04"^^ns3:date ;
                      ns4:title "12th Americas Conference on Information Systems"^^ns3:string ;
                      ns4:year "2006" ;
                      a ns4:Conference ;
                      ns1:label "AMCIS2006" ;
                      ns5:lat "16.85"^^ns3:float ;
                      ns5:long "-99.92"^^ns3:float .

        ns2:AbrahamBernstein ns2:affiliation "University of Zurich" ;
                             ns2:country "Switzerland" ;
                             a ns4:Person ;
                             ns1:label "Abraham Bernstein" .

        ns2:AchilleVarzi ns2:affiliation "Department of Philosophy, Columbia University" ;
                         ns2:country "United States" ;
                         a ns4:Person ;
                         ns1:label "Achille Varzi" .

        ns2:AlainLeger ns2:affiliation "France  Telecom"^^ns3:string ;
                       ns2:country "France" ;
                       a ns4:Person ;
                       ns1:label "Alain Leger" .

        ns2:AldoGangemi ns2:affiliation "CNR"^^ns3:string ;
                        ns2:country "Italy" ;
                        a ns4:Person ;
                        ns1:label "Aldo Gangemi" .

        ns2:AleksanderPivk ns2:affiliation "J. Stefan Institute" ;
                           ns2:country "Slovenia" ;
                           a ns4:Person ;
                           ns1:label "Aleksander Pivk" .

        ns2:AlessandroLenci ns2:affiliation "University of Pisa" ;
                            ns2:country "Italy" ;
                            a ns4:Person ;
                            ns1:label "Alessandro Lenci" .

        ns2:AlexBorgida ns2:affiliation "Rutgers University" ;
                        ns2:country "United States" ;
                        a ns4:Person ;
                        ns1:label "Alex Borgida" .

        ns2:AlexanderLoeser ns2:affiliation "TU Berlin" ;
                            ns2:country "Germany" ;
                            a ns4:Person ;
                            ns1:label "Alexander Loeser" .

        ns2:AmitSheth ns2:affiliation "University of Georgia and Semagix" ;
                      ns2:country "United States" ;
                      a ns4:Person ;
                      ns1:label "Amit Sheth" .

        ns2:AndreasAbecker ns2:affiliation "FZI Karlsruhe" ;
                           ns2:country "Germany" ;
                           a ns4:Person ;
                           ns1:label "Andreas Abecker" .

        ns2:AndreasEberhart ns2:affiliation "Hewlett Packard" ;
                            ns2:country "Germany" ;
                            a ns4:Person ;
                            ns1:label "Andreas Eberhart" .

        ns2:AndreasHotho ns2:affiliation "University of Kassel" ;
                         ns2:country "Germany" ;
                         a ns4:Person ;
                         ns1:label "Andreas Hotho" .

        ns2:AnnaVZhdanova ns1:label "AnnaVZhdanova" .

        ns2:AntonyGalton ns2:affiliation "School of Engineering and Computer Science, University of Exeter" ;
                         ns2:country "United Kingdom" ;
                         a ns4:Person ;
                         ns1:label "Antony Galton" .

        ns2:AnupriyaAnkolekar ns2:affiliation "University of Karlsruhe" ;
                              ns2:country "Germany" ;
                              a ns4:Person ;
                              ns1:label "Anupriya Ankolekar" .

        ns2:ArantzaIllarramendi ns2:affiliation "Basque Country University" ;
                                ns2:country "Spain" ;
                                a ns4:Person ;
                                ns1:label "Arantza Illarramendi" .

        ns2:ArtificialIntelligence a ns4:Topic ;
                                   ns1:label "ArtificialIntelligence"^^ns3:string .

        ns2:AsunGomezPerez ns2:affiliation "Universidad Politecnica de Madrid" ;
                           ns2:country "Spain" ;
                           a ns4:Person ;
                           ns1:label "Asun Gomez-Perez" .

        ns2:AtanasKiryakov ns2:affiliation "Sirma AI" ;
                           ns2:country "Bulgaria" ;
                           a ns4:Person ;
                           ns1:label "Atanas Kiryakov" .

        ns2:AxelHahn ns2:affiliation "University of Oldenburg" ;
                     ns2:country "Germany" ;
                     a ns4:Person ;
                     ns1:label "Axel Hahn" .

        ns2:BPM2006 ns2:URL "http://bpm2006.tuwien.ac.at/"^^ns3:anyURI ;
                    ns2:acceptanceNotification "2006-05-12"^^ns3:date ;
                    ns2:camera-readySubmission "2006-05-27"^^ns3:date ;
                    ns2:place "Vienna, Austria"^^ns3:string ;
                    ns2:start "2006-09-05"^^ns3:date ;
                    ns2:submissionsDue "2006-03-17"^^ns3:date ;
                    ns4:title "4th International Conference on Business Process Management"^^ns3:string ;
                    ns4:year "2006" ;
                    a ns4:Conference ;
                    ns1:label "BPM2006" ;
                    ns5:lat "48.208333"^^ns3:float ;
                    ns5:long "16.373056"^^ns3:float .

        ns2:BarbaraPartee ns2:affiliation "University of Massachusetts" ;
                          ns2:country "United States" ;
                          a ns4:Person ;
                          ns1:label "Barbara Partee" .

        ns2:BarrySmith ns2:affiliation "National Center for Ontological Research and Department of Philosophy, University at Buffalo, USA; Institute for Formal Ontology and Medical Information Science, Saarbrücken" ;
                       ns2:country "Germany" ;
                       a ns4:Person ;
                       ns1:label "Barry Smith" .

        ns2:BillAndersen ns2:affiliation "OntoWorks" ;
                         ns2:country "United States" ;
                         a ns4:Person ;
                         ns1:label "Bill Andersen" .

        ns2:BoiFaltings ns2:affiliation "EPFL Lausanne" ;
                        ns2:country "Switzerland" ;
                        a ns4:Person ;
                        ns1:label "Boi Faltings" .

        ns2:BorisMotik ns2:affiliation "FZI Karlsruhe" ;
                       ns2:country "Germany" ;
                       a ns4:Person ;
                       ns1:label "Boris Motik" .

        ns2:BrandonBennett ns2:affiliation "School of Computing, University of Leeds" ;
                           ns2:country "United Kingdom" ;
                           a ns4:Person ;
                           ns1:label "Brandon Bennett" .

        ns2:BrianMcBride ns2:affiliation "Hewlett Packard" ;
                         ns2:country "United Kingdom" ;
                         a ns4:Person ;
                         ns1:label "Brian McBride" .

        ns2:CKC2007 ns2:URL "https://km.aifb.uni-karlsruhe.de/ws/ckc2007"^^ns3:anyURI ;
                    ns2:conferenceChair ns2:NatashaNoy, ns2:HarithAlani ;
                    ns2:inConjunctionWith ns2:WWW2007 ;
                    ns2:place "Banff, Canada"^^ns3:string ;
                    ns2:start "2007-05-08"^^ns3:date ;
                    ns4:title "Workshop on Social and Collaborative Construction of Structured Knowledge" ;
                    ns4:year "2007" ;
                    a ns4:Workshop ;
                    ns1:label "CKC2007" ;
                    ns5:lat "50.729502"^^ns3:float ;
                    ns5:long "-110.67627"^^ns3:float .

        ns2:COLINGACL2006 ns2:URL "http://www.acl2006.mq.edu.au/"^^ns3:anyURI ;
                          ns2:end "2006-07-21"^^ns3:date ;
                          ns2:place "Sydney, Australia"^^ns3:string ;
                          ns2:start "2006-07-17"^^ns3:date ;
                          ns4:title "Conference of the International Committee on Computational Linguistics and the Association for Computational Linguistics"^^ns3:string ;
                          ns4:year "2006" ;
                          a ns4:Conference ;
                          ns1:label "COLING-ACL2006" ;
                          ns5:lat "-33.866667"^^ns3:float ;
                          ns5:long "151.2"^^ns3:float .

        ns2:COMPSAC2006 ns2:URL "http://conferences.computer.org/compsac/2006/"^^ns3:anyURI ;
                        ns2:inConjunctionWith ns2:CoSTEP2006 ;
                        ns4:title "IEEE Computer Society Signature Conference on Software Technology and Applications"^^ns3:string ;
                        ns4:year "2006" ;
                        a ns4:Conference ;
                        ns1:label "COMPSAC2006" .

        ns2:CSSW2007 ns2:URL "http://aksw.org/SocialSemanticWebConference"^^ns3:anyURI ;
                     ns2:conferenceChair ns2:SrenAuer, ns2:ChrisBizer, ns2:ClaudiaMueller, ns2:AnnaVZhdanova ;
                     ns2:end "2007-09-28"^^ns3:date ;
                     ns2:place "Leipzig, Germany"^^ns3:string ;
                     ns2:start "2007-09-26"^^ns3:date ;
                     ns2:submissionsDue "2006-06-01"^^ns3:date ;
                     ns4:title "SABRE Conference on Social Semantic Web"^^ns3:string ;
                     ns4:year "2007" ;
                     a ns4:Conference ;
                     ns1:label "CSSW2007" ;
                     ns5:lat "51.340264"^^ns3:float ;
                     ns5:long "12.371292"^^ns3:float .

        ns2:CarolaEschenbach ns2:affiliation "Department for Informatics, University of Hamburg" ;
                             ns2:country "Germany" ;
                             a ns4:Person ;
                             ns1:label "Carola Eschenbach" .

        ns2:CaroleGoble ns2:affiliation "University of Manchester" ;
                        ns2:country "United Kingdom" ;
                        a ns4:Person ;
                        ns1:label "Carole Goble" .

        ns2:ChrisBizer ns1:label "Chris Bizer" .

        ns2:ChrisMenzel ns2:affiliation "Department of Philosophy, Texas A&M University" ;
                        ns2:country "United States" ;
                        a ns4:Person ;
                        ns1:label "Chris Menzel" .

        ns2:ChrisPreist ns2:affiliation "HP Labs" ;
                        ns2:country "United Kingdom" ;
                        a ns4:Person ;
                        ns1:label "Chris Preist" .

        ns2:ChrisWelty ns2:affiliation "IBM" ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Chris Welty" .

        ns2:ChristianeFellbaum ns2:affiliation "Cognitive Science Laboratory, Princeton University, USA and Berlin Brandenburg Academy of Sciences and Humanities, Berlin" ;
                               ns2:country "Germany" ;
                               a ns4:Person ;
                               ns1:label "Christiane Fellbaum" .

        ns2:ChristineGolbreich ns2:affiliation "University of Rennes" ;
                               ns2:country "France" ;
                               a ns4:Person ;
                               ns1:label "Christine Golbreich" .

        ns2:ChristophBussler ns2:affiliation "Cisco Systems, Inc." ;
                             ns2:country "United States" ;
                             a ns4:Person ;
                             ns1:label "Christoph Bussler" .

        ns2:ClaudiaMueller ns1:label "Claudia Müller" .

        ns2:ClaudioMasolo ns2:affiliation "Laboratory for Applied Ontology, ISTC-CNR, Trento" ;
                          ns2:country "Italy" ;
                          a ns4:Person ;
                          ns1:label "Claudio Masolo" .

        ns2:CoSTEP2006 ns2:URL "http://conferences.computer.org/CoSTEP/"^^ns3:anyURI ;
                       ns2:end "2006-09-23"^^ns3:date ;
                       ns2:place "Chicago, USA"^^ns3:string ;
                       ns2:start "2006-09-17"^^ns3:date ;
                       ns4:title "The Congress on Software Technology  and Engineering Practice"^^ns3:string ;
                       ns4:year "2006" ;
                       a ns4:Conference ;
                       ns1:label "CoSTEP2006" ;
                       ns5:lat "41.9"^^ns3:float ;
                       ns5:long "-87.65"^^ns3:float .

        ns2:DBpedia ns4:carriedOutBy ns2:AKSW ;
                    ns6:description "DBpedia.org is a community effort to extract structured information from Wikipedia and to make this information available on the Web. dbpedia allows you to ask sophisticated queries against Wikipedia and to link other datasets on the Web to Wikipedia data." ;
                    ns6:developer ns2:JensLehmann, ns2:SrenAuer ;
                    ns6:homepage ns7:org ;
                    ns6:maintainer ns2:SrenAuer ;
                    ns6:name "DBpedia.org" ;
                    ns6:programming-language "PHP", "JavaScript" ;
                    a ns4:SoftwareProject ;
                    ns1:label "DBpedia.org" ;
                    ns8:depiction ns9:png .

        ns2:DEXA2006 ns2:URL "http://www.dexa.org/"^^ns3:anyURI ;
                     ns2:abstractsDue "2006-02-28"^^ns3:date ;
                     ns2:acceptanceNotification "2006-05-10"^^ns3:date ;
                     ns2:camera-readySubmission "2006-06-10"^^ns3:date ;
                     ns2:end "2006-09-08"^^ns3:date ;
                     ns2:logo "http://www.dexa.org/themes/dexa/images/logo_2006.gif"^^ns3:anyURI ;
                     ns2:place "Krakow, Poland"^^ns3:string ;
                     ns2:start "2006-09-04"^^ns3:date ;
                     ns2:submissionsDue "2006-03-07"^^ns3:date ;
                     ns4:isAbout ns2:DataMining, ns2:Databases, ns2:XML ;
                     ns4:title "17th International Conference on Database and Expert Systems Applications"^^ns3:string ;
                     ns4:year "2006" ;
                     a ns4:Conference ;
                     ns1:comment "The aim of DEXA 2006 is to present both research contributions in the area of data base and intelligent systems and a large spectrum of already implemented or just being developed applications. DEXA will offer the opportunity to extensively discuss requirements, problems, and solutions in the field. The workshop and conference should inspire a fruitful dialogue between developers in practice, users of database and expert systems, and scientists working in the field." ;
                     ns1:label "DEXA 2006" ;
                     ns5:lat "50.061667"^^ns3:float ;
                     ns5:long "19.937222"^^ns3:float .

        ns2:DMIN2006 ns2:URL "http://www.dmin-2006.com/"^^ns3:anyURI ;
                     ns2:acceptanceNotification "2006-04-09"^^ns3:date ;
                     ns2:camera-readySubmission "2006-04-20"^^ns3:date ;
                     ns2:end "2006-05-29"^^ns3:date ;
                     ns2:inConjunctionWith ns2:WORLDCOMP06 ;
                     ns2:place "Monte Carlo Resort, Las Vegas, Nevada, USA"^^ns3:string ;
                     ns2:preRegistration "2006-04-20"^^ns3:date ;
                     ns2:start "2006-05-26"^^ns3:date ;
                     ns2:submissionsDue "2006-03-06"^^ns3:date ;
                     ns4:isAbout ns2:DataMining, ns2:DataVisualization ;
                     ns4:title "2006 International Conference on Data Mining"^^ns3:string ;
                     ns4:year "2006" ;
                     a ns4:Conference ;
                     ns1:label "DMIN2006" ;
                     ns5:lat "36.183333"^^ns3:float ;
                     ns5:long "-115.216667"^^ns3:float .

        ns2:DanielOlmedilla ns2:affiliation "L3S Hannover" ;
                            ns2:country "Germany" ;
                            a ns4:Person ;
                            ns1:label "Daniel Olmedilla" .

        ns2:DanielSchwabe ns2:affiliation "PUC-Rio" ;
                          ns2:country "Brazil" ;
                          a ns4:Person ;
                          ns1:label "Daniel Schwabe" .

        ns2:DataMining a ns4:Topic ;
                       ns1:label "DataMining"^^ns3:string .

        ns2:DataModeling a ns4:Topic ;
                         ns1:label "DataModeling"^^ns3:string .

        ns2:DataVisualization a ns4:Topic ;
                              ns1:label "DataVisualization"^^ns3:string .

        ns2:Databases a ns4:Topic .

        ns2:DavidMark ns2:affiliation "Department of Geography, State University of New York, Buffalo" ;
                      ns2:country "United States" ;
                      a ns4:Person ;
                      ns1:label "David Mark" .

        ns2:DavidRandell ns2:affiliation "Imperial College London" ;
                         ns2:country "United Kingdom" ;
                         a ns4:Person ;
                         ns1:label "David Randell" .

        ns2:DavidToman ns2:affiliation "University of Waterloo" ;
                       ns2:country "Canada" ;
                       a ns4:Person ;
                       ns1:label "David Toman" .

        ns2:DeanAllemang ns2:affiliation "TopQuadrant Inc." ;
                         ns2:country "United States" ;
                         a ns4:Person ;
                         ns1:label "Dean Allemang" .

        ns2:DerekSleeman ns2:affiliation "University of Aberdeen" ;
                         ns2:country "United Kingdom" ;
                         a ns4:Person ;
                         ns1:label "Derek Sleeman" .

        ns2:DianaMaynard ns2:affiliation "University Sheffield" ;
                         ns2:country "United Kingdom" ;
                         a ns4:Person ;
                         ns1:label "Diana Maynard" .

        ns2:DieterFensel ns2:affiliation "University of Innsbruck and DERI" ;
                         ns2:country "Austria" ;
                         a ns4:Person ;
                         ns1:label "Dieter Fensel" .

        ns2:DimitrisPlexousakis ns2:affiliation "University of Crete" ;
                                ns2:country "Greece" ;
                                a ns4:Person ;
                                ns1:label "Dimitris Plexousakis" .

        ns2:DunjaMladenic ns2:affiliation "J. Stefan Institute" ;
                          ns2:country "Slovenia" ;
                          a ns4:Person ;
                          ns1:label "Dunja Mladenic" .

        ns2:E-Collaboration a ns4:Topic ;
                            ns1:label "E-Collaboration"^^ns3:string .

        ns2:E-Commerce a ns4:Topic ;
                       ns1:label "E-Commerce"^^ns3:string .

        ns2:E-Government a ns4:Topic ;
                         ns1:label "E-Government"^^ns3:string .

        ns2:E-Learning a ns4:Topic .

        ns2:EC-TEL2006 ns2:URL "http://www.ectel06.org"^^ns3:anyURI ;
                       ns2:acceptanceNotification "2006-06-01"^^ns3:date ;
                       ns2:camera-readySubmission "2006-06-30"^^ns3:date ;
                       ns2:place "Crete, Greece"^^ns3:string ;
                       ns2:start "2006-10-01"^^ns3:date ;
                       ns2:submissionsDue "2006-03-30"^^ns3:date ;
                       ns4:title "First European Conference on Technology Enhanced Learning" ;
                       ns4:year "2006" ;
                       a ns4:Conference ;
                       ns1:label "EC-TEL2006" ;
                       ns5:lat "35"^^ns3:float ;
                       ns5:long "24"^^ns3:float .

        ns2:EDBT2006 ns2:URL "http://www.edbt2006.de"^^ns3:anyURI ;
                     ns2:end "2006-03-31"^^ns3:date ;
                     ns2:logo "http://www.edbt2006.de/Images/Logo1.jpg"^^ns3:anyURI ;
                     ns2:place "Munich, Germany"^^ns3:string ;
                     ns2:start "2006-03-26"^^ns3:date ;
                     ns4:title "10. International Conference on Extending Database Technology"^^ns3:string ;
                     ns4:year "2006" ;
                     a ns4:Conference ;
                     ns1:label "EDBT2006" ;
                     ns5:lat "48.133333"^^ns3:float ;
                     ns5:long "11.566667"^^ns3:float .

        ns2:EISTA06 ns2:URL "http://www.conf-info.org/eista06/"^^ns3:anyURI ;
                    ns2:acceptanceNotification "2006-04-03"^^ns3:date ;
                    ns2:end "2006-07-23"^^ns3:date ;
                    ns2:place "Orlando, Florida, USA"^^ns3:string ;
                    ns2:start "2006-07-20"^^ns3:date ;
                    ns4:year "2006" ;
                    a ns4:Conference ;
                    ns1:comment "4th International Conference on Education and Information Systems, Technologies and Applications" ;
                    ns1:label "EISTA06" ;
                    ns5:lat "28.533611"^^ns3:float ;
                    ns5:long "-81.368533"^^ns3:float .

        ns2:ER2006 ns2:URL "http://adrg.eller.arizona.edu/ER2006/"^^ns3:anyURI ;
                   ns2:abstractsDue "2006-04-03"^^ns3:date ;
                   ns2:acceptanceNotification "2006-06-14"^^ns3:date ;
                   ns2:camera-readySubmission "2006-07-12"^^ns3:date ;
                   ns2:end "2006-11-09"^^ns3:date ;
                   ns2:place "Tucson, Arizona, USA"^^ns3:string ;
                   ns2:start "2006-11-06"^^ns3:date ;
                   ns2:submissionsDue "2006-04-10"^^ns3:date ;
                   ns4:isAbout ns2:DataModeling, ns2:Databases, ns2:ProcessModeling ;
                   ns4:title "25th International Conference on Conceptual Modeling"^^ns3:string ;
                   ns4:year "2006" ;
                   a ns4:Conference ;
                   ns1:label "ER2006" ;
                   ns5:lat "32.214444"^^ns3:float ;
                   ns5:long "-110.918056"^^ns3:float .

        ns2:ESWC06 ns2:URL "http://www.eswc2006.org/"^^ns3:anyURI ;
                   ns2:camera-readySubmission "2006-03-31"^^ns3:date ;
                   ns2:end "2006-06-14"^^ns3:date ;
                   ns2:pcMember ns2:AbrahamBernstein, ns2:AlainLeger, ns2:AldoGangemi, ns2:AleksanderPivk, ns2:AlexanderLoeser, ns2:AmitSheth, ns2:AndreasAbecker, ns2:AndreasEberhart, ns2:AndreasHotho, ns2:AnupriyaAnkolekar, ns2:AsunGomezPerez, ns2:AtanasKiryakov, ns2:AxelHahn, ns2:BoiFaltings, ns2:BorisMotik, ns2:BrianMcBride, ns2:CaroleGoble, ns2:ChrisPreist, ns2:ChristineGolbreich, ns2:ChristophBussler, ns2:DanielOlmedilla, ns2:DanielSchwabe, ns2:DeanAllemang, ns2:DerekSleeman, ns2:DianaMaynard, ns2:DieterFensel, ns2:DimitrisPlexousakis, ns2:DunjaMladenic, ns2:EeroHyvnen, ns2:ElenaPaslaruBontas, ns2:EnricoFranconi, ns2:EnricoMotta, ns2:FabienGandon, ns2:FaustoGiunchiglia, ns2:FrancoisBry, ns2:FrankvanHarmelen, ns2:GerdStumme, ns2:GritDenker, ns2:GuusSchreiber, ns2:HamishCunningham, ns2:HeinerStuckenschmidt, ns2:HermanterHorst, ns2:HideakiTakeda, ns2:HolgerWache, ns2:IanHorrocks, ns2:IsabelCruz, ns2:JaneHunter, ns2:JeenBroekstra, ns2:JeffHeflin, ns2:JeffZPan, ns2:JeremyJCarroll, ns2:JeromeEuzenat, ns2:JinghaiRao, ns2:JoergDiedrich, ns2:JohnDavies, ns2:JohnMylopoulos, ns2:JosdeBruijn, ns2:JrgenAngele, ns2:KalinaBontcheva, ns2:KatiaSycara, ns2:KavithaSrinivas, ns2:KrzysztofWecel, ns2:LeoObrst, ns2:LilianaCabral, ns2:LjiljanaStojanovic, ns2:ManolisKoubarakis, ns2:MarcoPistore, ns2:MariGeorges, ns2:MarieChristineRousset, ns2:MarkoGrobelnik, ns2:MarkoTadic, ns2:MartinDzbor, ns2:MartinHepp, ns2:MasahiroHori, ns2:MatthiasKlusch, ns2:MaurizioLenzerini, ns2:MichaelSintek, ns2:MichaelStollberg, ns2:MichaelWooldridge, ns2:MihhailMatskin, ns2:NicolaGuarino, ns2:NicolaHenze, ns2:NigelCollier, ns2:OscarCorcho, ns2:PaoloBouquet, ns2:PaoloTraverso, ns2:PascalHitzler, ns2:PaulBuitelaar, ns2:PaulodaPinheiro, ns2:RalfMoeller, ns2:RaphaelTroncy, ns2:RichardBenjamins, ns2:RiichiroMizoguchi, ns2:RobertTolksdorf, ns2:RubenLara, ns2:RudiStuder, ns2:SeanBechhofer, ns2:SergioTessaris, ns2:SiegfriedHandschuh, ns2:SofiaPinto, ns2:StefanSchlobach, ns2:SteffenStaab, ns2:SteveWillmott, ns2:TerryPayne, ns2:UbboVisser, ns2:UlrichReimer, ns2:ValentinaTamma, ns2:VangelisKarkaletsis, ns2:VibhuMittal, ns2:VipulKashyap, ns2:VojtechSvatek, ns2:VolkerHaarslev, ns2:WalterBinder, ns2:WolfgangNejdl, ns2:YingDing ;
                   ns2:place "Budva, Montenegro"^^ns3:string ;
                   ns2:start "2006-06-11"^^ns3:date ;
                   ns4:isAbout ns2:SemanticWeb ;
                   ns4:title "3rd Annual European Semantic Web Conference"^^ns3:string ;
                   ns4:year "2006" ;
                   a ns4:Conference ;
                   ns1:label "ESWC06" ;
                   ns5:lat "42.285278"^^ns3:float ;
                   ns5:long "18.843611"^^ns3:float .

        ns2:EduardHovy ns2:affiliation "University of Southern California" ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Eduard Hovy" .

        ns2:EeroHyvnen ns2:affiliation "University of Helsinki" ;
                       ns2:country "Finland" ;
                       a ns4:Person ;
                       ns1:label "Eero Hyvönen" .

        ns2:ElenaPaslaruBontas ns2:affiliation "FU Berlin" ;
                               ns2:country "Germany" ;
                               a ns4:Person ;
                               ns1:label "Elena Paslaru Bontas" .

        ns2:EnricoFranconi ns2:affiliation "Free University of Bozen-Bolzano" ;
                           ns2:country "Italy" ;
                           a ns4:Person ;
                           ns1:label "Enrico Franconi" .

        ns2:EnricoMotta ns2:affiliation "The Open University" ;
                        ns2:country "United Kingdom" ;
                        a ns4:Person ;
                        ns1:label "Enrico Motta" .

        ns2:ErnestDavis ns2:affiliation "Department of Computer Science, New York University" ;
                        ns2:country "United States" ;
                        a ns4:Person ;
                        ns1:label "Ernest Davis" .

        ns2:FMILeipzig ns4:hasParts ns2:IfILeipzig ;
                       a ns4:Department ;
                       ns1:label "Faculty of Mathematics and Computer Science" ;
                       ns8:homepage <http://www.fmi.uni-leipzig.de/> .

        ns2:FOIS2006 ns2:URL "http://www.formalontology.org/"^^ns3:anyURI ;
                     ns2:abstractsDue "2006-05-01"^^ns3:date ;
                     ns2:acceptanceNotification "2006-05-05"^^ns3:date ;
                     ns2:camera-readySubmission "2006-06-28"^^ns3:date ;
                     ns2:conferenceChair ns2:NicolaGuarino ;
                     ns2:end "2006-11-11"^^ns3:date ;
                     ns2:localChair ns2:BillAndersen ;
                     ns2:pcMember ns2:AchilleVarzi, ns2:AldoGangemi, ns2:AlessandroLenci, ns2:AntonyGalton, ns2:BarbaraPartee, ns2:BarrySmith, ns2:BillAndersen, ns2:BrandonBennett, ns2:CarolaEschenbach, ns2:ChrisMenzel, ns2:ChrisWelty, ns2:ChristianeFellbaum, ns2:ClaudioMasolo, ns2:DavidMark, ns2:DavidRandell, ns2:EduardHovy, ns2:ErnestDavis, ns2:IanPrattHartmann, ns2:IngvarJohansson, ns2:JamesPustejovsky, ns2:JerryHobbs, ns2:JohnBateman, ns2:JohnMylopoulos, ns2:JohnSowa, ns2:JoostBreuker, ns2:LaureVieu, ns2:LeoObrst, ns2:LeonardoLesmo, ns2:MartinDrr, ns2:MassimoPoesio, ns2:MatteoCristani, ns2:MichaelGruninger, ns2:MikeUschold, ns2:NathalieAussenacGilles, ns2:NicholasAsher, ns2:NicolaGuarino, ns2:PhilippeMuller, ns2:PierdanieleGiaretta, ns2:RichmondThomason, ns2:RobertRynasiewicz, ns2:RobertoCasati, ns2:SimonMilton, ns2:StefanoBorgo, ns2:TonyCohn, ns2:UdoHahn, ns2:VedaStorey, ns2:WernerCeusters, ns2:WernerKuhn ;
                     ns2:place "Baltimore, Maryland (USA)"^^ns3:string ;
                     ns2:programChair """Brandon Bennett (University of Leeds, UK) brandon@comp.leeds.ac.uk
        Christiane Fellbaum (Princeton University, USA and Berlin Brandenburg Academy of Sciences and Humanities, Germany) fellbaum@clarity.princeton.edu""" ;
                     ns2:programmeCommittee """*  Bill Andersen (OntologyWorks, USA)
            * Nicholas Asher (Department of Philosophy, University of Texas at Austin, USA)
            * Nathalie Aussenac-Gilles (Research Institute for Computer Science, CNRS, Toulouse, France)
            * John Bateman (Department of Applied English Linguistics, University of Bremen, Germany)
            * Brandon Bennett (School of Computing, University of Leeds, UK)
            * Stefano Borgo (Laboratory for Applied Ontology, ISTC-CNR, Italy)
            * Joost Breuker (Leibniz Center for Law, University of Amsterdam, The Netherlands)
            * Roberto Casati (Jean Nicod Institute, CNRS, Paris, France)
            * Werner Ceusters (European Centre for Ontological Research, Saarbrücken)
            * Tony Cohn (School of Computing, University of Leeds, UK)
            * Matteo Cristani (University of Verona, Italy)
            * Ernest Davis (Department of Computer Science, New York University, USA)
            * Martin Dörr (Institute of Computer Science, FORTH, Heraklion, Greece)
            * Carola Eschenbach (Department for Informatics, University of Hamburg, Germany)
            * Christiane Fellbaum (Cognitive Science Laboratory, Princeton University, USA and Berlin Brandenburg Academy of Sciences and Humanities, Berlin, Germany)
            * Antony Galton (School of Engineering and Computer Science, University of Exeter, UK)
            * Aldo Gangemi (Laboratory for Applied Ontology, ISTC-CNR, Roma, Italy)
            * Pierdaniele Giaretta (Department of Philosophy, University of Verona, Italy)
            * Michael Gruninger (University of Toronto, Canada)
            * Nicola Guarino (Laboratory for Applied Ontology, ISTC-CNR, Trento, Italy)
            * Udo Hahn (Jena University, Germany)
            * Jerry Hobbs (University of Southern California, USA)
            * Eduard Hovy (University of Southern California, USA)
            * Ingvar Johansson (Institute for Formal Ontology and Medical Information Science, University of Saarbrücken, Germany)
            * Werner Kuhn (IFGI, Muenster)
            * Fritz Lehmann (USA)
            * Alessandro Lenci (University of Pisa, Italy)
            * Leonardo Lesmo (Department of Computer Science, University of Torino, Italy)
            * David Mark (Department of Geography, State University of New York, Buffalo, USA)
            * Claudio Masolo (Laboratory for Applied Ontology, ISTC-CNR, Trento, Italy)
            * Chris Menzel (Department of Philosophy, Texas A&M University, USA)
            * Simon Milton (Department of Information Systems, University of Melbourne, Australia)
            * Philippe Muller (Research Institute for Computer Science, University of Toulouse III, France)
            * John Mylopoulos (Department of Computer Science, University of Toronto, Canada)
            * Leo Obrst (The MITRE Corporation, USA)
            * Barbara Partee (University of Massachusetts, USA)
            * Massimo Poesio (Department of Computer Science, University of Essex, UK)
            * Ian Pratt-Hartmann (Department of Computer Science, University of Manchester, UK)
            * James Pustejovsky (Department of Computer Science, Brandeis University, USA)
            * David Randell (Imperial College London, UK)
            * Robert Rynasiewicz (Johns Hopkins University, USA)
            * Barry Smith (National Center for Ontological Research and Department of Philosophy, University at Buffalo, USA; Institute for Formal Ontology and Medical Information Science, Saarbrücken, Germany)
            * John Sowa (Vivomind Intelligence Inc., USA)
            * Veda Storey (Department of Computer Information Systems, Georgia State University, USA)
            * Richmond Thomason (University of Michigan, USA)
            * Mike Uschold (The Boeing Company, USA)
            * Achille Varzi (Department of Philosophy, Columbia University, USA)
            * Laure Vieu (Research Institute for Computer Science, CNRS, Toulouse, France)
            * Chris Welty (IBM Watson Research Center, USA)""" ;
                     ns2:publicityChair "Leo Obrst (MITRE, USA) lobrst@mitre.org" ;
                     ns2:start "2006-11-09"^^ns3:date ;
                     ns2:submissionsDue "2006-05-05"^^ns3:date ;
                     ns4:isAbout ns2:KnowledgeEngineering, ns2:Ontologies, ns2:SemanticWeb ;
                     ns4:title "International Conference on Formal Ontology in Information Systems" ;
                     ns4:year "2006" ;
                     a ns4:Conference ;
                     ns1:comment """Since ancient times, ontology, the analysis and categorisation of what exists, has been fundamental to philosophical enquiry. But, until recently, ontology has been seen as an abstract, purely theoretical discipline, far removed from the practical applications of science. However, with the increasing use of sophisticated computerised information systems, solving problems of an ontological nature is now key to the effective use of technologies supporting a wide range of human activities. The ship of Theseus and the tail of Tibbles the cat are no longer merely amusing puzzles. We employ databases and software applications to deal with everything from ships and ship building to anatomy and amputations. When we design a computer to take stock of a ship yard or check that all goes well at the veterinary hospital, we need to ensure that our system operates in a consistent and reliable way even when manipulating information that involves subtle issues of semantics and identity. So, whereas ontologists may once have shied away from practical problems, now the practicalities of achieving cohesion in an information-based society demand that attention must be paid to ontology.

        Researchers in such areas as artificial intelligence, formal and computational linguistics, biomedical informatics, conceptual modeling, knowledge engineering and information retrieval have come to realise that a solid foundation for their research calls for serious work in ontology, understood as a general theory of the types of entities and relations that make up their respective domains of inquiry. In all these areas, attention is now being focused on the content of information rather than on just the formats and languages used to represent information. The clearest example of this development is provided by the many initiatives growing up around the project of the Semantic Web. And, as the need for integrating research in these different fields arises, so does the realisation that strong principles for building well-founded ontologies might provide significant advantages over ad hoc, case-based solutions. The tools of formal ontology address precisely these needs, but a real effort is required in order to apply such philosophical tools to the domain of information systems. Reciprocally, research in the information sciences raises specific ontological questions which call for further philosophical investigations.

        The purpose of FOIS is to provide a forum for genuine interdisciplinary exchange in the spirit of a unified effort towards solving the problems of ontology, with an eye to both theoretical issues and concrete applications.""" ;
                     ns1:label "FOIS-2006" ;
                     ns5:lat "39.2865"^^ns3:float ;
                     ns5:long "-76.6149"^^ns3:float .

        ns2:FabienGandon ns2:affiliation "INRIA Sophia-Antipolis" ;
                         ns2:country "France" ;
                         a ns4:Person ;
                         ns1:label "Fabien Gandon" .

        ns2:FaustoGiunchiglia ns2:affiliation "University of Trento" ;
                              ns2:country "Italy" ;
                              a ns4:Person ;
                              ns1:label "Fausto Giunchiglia" .

        ns2:FrancoisBry ns2:affiliation "University of Munich" ;
                        ns2:country "Germany" ;
                        a ns4:Person ;
                        ns1:label "Francois Bry" .

        ns2:FrankvanHarmelen ns2:affiliation "Vrije Universiteit Amsterdam" ;
                             ns2:country "Netherlands" ;
                             a ns4:Person ;
                             ns1:label "Frank van Harmelen" .

        ns2:FranzBaader ns2:affiliation "University of Dresden" ;
                        ns2:country "Germany" ;
                        a ns4:Person ;
                        ns1:label "Franz Baader" .

        ns2:GeorgLausen ns2:affiliation "University of Freiburg" ;
                        ns2:country "Germany" ;
                        a ns4:Person ;
                        ns1:label "Georg Lausen" .

        ns2:GerdStumme ns2:affiliation "University of Kassel" ;
                       ns2:country "Germany" ;
                       a ns4:Person ;
                       ns1:label "Gerd Stumme" .

        ns2:GiuseppeDeGiacomo ns2:affiliation "University of Roma Sapienza" ;
                              ns2:country "Italy" ;
                              a ns4:Person ;
                              ns1:label "Giuseppe De Giacomo" .

        ns2:GritDenker ns2:affiliation "SRI" ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Grit Denker" .

        ns2:GuidoVetere ns2:affiliation "IBM" ;
                        ns2:country "Italy" ;
                        a ns4:Person ;
                        ns1:label "Guido Vetere" .

        ns2:GuusSchreiber ns2:affiliation "Vrije Universiteit Amsterdam" ;
                          ns2:country "Netherlands" ;
                          a ns4:Person ;
                          ns1:label "Guus Schreiber" .

        ns2:HamishCunningham ns2:affiliation "University Sheffield" ;
                             ns2:country "United Kingdom" ;
                             a ns4:Person ;
                             ns1:label "Hamish Cunningham" .

        ns2:HarithAlani ns1:label "Harith Alani" .

        ns2:HeikoSchuldt ns2:affiliation "University Basel" ;
                         ns2:country "Switzerland" ;
                         a ns4:Person ;
                         ns1:label "Heiko Schuldt" .

        ns2:HeinerStuckenschmidt ns2:affiliation "University of Mannheim" ;
                                 ns2:country "Germany" ;
                                 a ns4:Person ;
                                 ns1:label "Heiner Stuckenschmidt" .

        ns2:HermanterHorst ns2:affiliation "Philips Research" ;
                           ns2:country "Netherlands" ;
                           a ns4:Person ;
                           ns1:label "Herman ter Horst" .

        ns2:HideakiTakeda ns2:affiliation "National Institute of Informatics" ;
                          ns2:country "Japan" ;
                          a ns4:Person ;
                          ns1:label "Hideaki Takeda" .

        ns2:HolgerWache ns2:affiliation "Vrije Universiteit Amsterdam" ;
                        ns2:country "Netherlands" ;
                        a ns4:Person ;
                        ns1:label "Holger Wache" .

        ns2:ICDM06 ns2:URL "http://www.comp.hkbu.edu.hk/iwi06/icdm"^^ns3:anyURI ;
                   ns2:acceptanceNotification "2006-09-04"^^ns3:date ;
                   ns2:camera-readySubmission "2006-10-04"^^ns3:date ;
                   ns2:end "2006-12-22"^^ns3:date ;
                   ns2:place "Hong Kong Convention and Exhibition Centre, Hong Kong, China"^^ns3:string ;
                   ns2:start "2006-12-18"^^ns3:date ;
                   ns2:submissionsDue "2006-07-05"^^ns3:date ;
                   ns4:isAbout ns2:DataMining ;
                   ns4:title "IEEE International Conference on Data Mining" ;
                   ns4:year "2006" ;
                   a ns4:Conference ;
                   ns1:label "ICDM06" ;
                   ns5:lat "22.285278"^^ns3:float ;
                   ns5:long "114.147778"^^ns3:float .

        ns2:ICEC06 ns2:URL "http://www.icec06.net/"^^ns3:anyURI ;
                   ns2:acceptanceNotification "2006-04-15"^^ns3:date ;
                   ns2:camera-readySubmission "2006-05-31"^^ns3:date ;
                   ns2:end "2006-08-16"^^ns3:date ;
                   ns2:place "Fredericton, New Brunswick, Canada"^^ns3:string ;
                   ns2:start "2006-08-14"^^ns3:date ;
                   ns2:submissionsDue "2006-03-06"^^ns3:date ;
                   ns4:isAbout ns2:E-Commerce, ns2:E-Government, ns2:MultiagentSystems, ns2:SemanticWeb ;
                   ns4:title "The Eighth International Conference on Electronic Commerce" ;
                   ns4:year "2006" ;
                   a ns4:Conference ;
                   ns1:label "ICEC06" ;
                   ns5:lat "45.95"^^ns3:float ;
                   ns5:long "-66.666667"^^ns3:float .

        ns2:ICL2006 ns2:URL "http://www.icl-conference.org/"^^ns3:anyURI ;
                    ns2:abstractsDue "2006-05-19"^^ns3:date ;
                    ns2:acceptanceNotification "2006-06-19"^^ns3:date ;
                    ns2:camera-readySubmission "2006-09-11"^^ns3:date ;
                    ns2:end "2006-09-29"^^ns3:date ;
                    ns2:logo "http://www.icl-conference.org/images/logo_big.gif"^^ns3:anyURI ;
                    ns2:place "Carinthia Tech Institute, Villach, Austria"^^ns3:string ;
                    ns2:start "2006-09-27"^^ns3:date ;
                    ns4:isAbout ns2:E-Learning ;
                    ns4:title "Interactive Computer Aided Learning Conference" ;
                    ns4:year "2006" ;
                    a ns4:Conference ;
                    ns1:label "ICL2006" ;
                    ns5:lat "46.625"^^ns3:float ;
                    ns5:long "13.834167"^^ns3:float .

        ns2:ICWE2006 ns2:URL "http://www-conf.slac.stanford.edu/icwe06/"^^ns3:anyURI ;
                     ns2:acceptanceNotification "2006-04-01"^^ns3:date ;
                     ns2:camera-readySubmission "2006-04-19"^^ns3:date ;
                     ns2:end "2006-04-14"^^ns3:date ;
                     ns2:logo "http://www-conf.slac.stanford.edu/icwe06/images/ICWE_logo1.gif"^^ns3:anyURI ;
                     ns2:start "2006-07-11"^^ns3:date ;
                     ns4:isAbout ns2:E-Learning, ns2:P2P, ns2:WebApplications, ns2:WebServices ;
                     ns4:title "Sixth International Conference on Web Engineering" ;
                     ns4:year "2006" ;
                     a ns4:Conference ;
                     ns1:label "ICWE2006" ;
                     ns5:lat "37.429167"^^ns3:float ;
                     ns5:long "-122.138056"^^ns3:float .

        ns2:ICWS2006 ns2:URL "http://www.icws.org/"^^ns3:anyURI ;
                     ns2:inConjunctionWith ns2:CoSTEP2006 ;
                     ns4:title "IEEE International Conference on Web Services"^^ns3:string ;
                     a ns4:Conference ;
                     ns1:label "ICWS2006" .

        ns2:IMCL06 ns2:URL "http://www.imcl-conference.org"^^ns3:anyURI ;
                   ns2:end "2006-04-21"^^ns3:date ;
                   ns2:logo "http://www.imcl-conference.org/images/imcl_logo_gross.gif"^^ns3:anyURI ;
                   ns2:place "Princess Sumaya University for Technology, Amman, Jordan"^^ns3:string ;
                   ns2:start "2006-04-19"^^ns3:date ;
                   ns4:isAbout ns2:E-Learning, ns2:MobileComputing ;
                   ns4:title "First International Conference on Interactive Mobile and Computer Aided Learning" ;
                   ns4:year "2006" ;
                   a ns4:Conference ;
                   ns1:label "IMCL06" ;
                   ns5:lat "31.95"^^ns3:float ;
                   ns5:long "35.933333"^^ns3:float .

        ns2:ISWC2006 ns2:URL "http://iswc2006.semanticweb.org/"^^ns3:anyURI ;
                     ns2:acceptanceNotification "2006-07-26"^^ns3:date ;
                     ns2:camera-readySubmission "2006-08-25"^^ns3:date ;
                     ns2:end "2006-11-09"^^ns3:date ;
                     ns2:logo "http://www.informatik.uni-leipzig.de/~auer/iswc.png"^^ns3:anyURI ;
                     ns2:place "Athens, Georgia, USA"^^ns3:string ;
                     ns2:start "2006-11-05"^^ns3:date ;
                     ns2:submissionsDue "2006-05-15"^^ns3:date ;
                     ns4:isAbout ns2:SemanticWeb ;
                     ns4:title "Fifth International Semantic Web Conference"^^ns3:string ;
                     ns4:year "2006" ;
                     a ns4:Conference ;
                     ns1:comment """The dream of the Web was to create a human communication and collaboration
        platform for sharing knowledge and enabling a universal space for
        information and services. We all are now much more connected, and in turn
        face new resulting problems: service and information overload caused by
        insufficient support for information selection, organization and
        collaboration. The Semantic Web, by providing standards for formulating and
        distributing metadata and ontologies, enables means for information
        organization and selective access. However, the Semantic Web requires new
        infrastructure on all levels - e.g., human-computer interaction, expressive
        representation and query languages, reasoning engines, data representation
        and integration, interoperability middleware, and distributed computing.

        To foster the exchange of ideas and collaboration, the International
        Semantic Web Conference brings together researchers in relevant disciplines
        such as artificial intelligence, databases, distributed computing, web
        engineering, information systems, and human-computer interaction.

        The Fifth International Semantic Web Conference (ISWC2006) follows on the
        success of previous conferences and workshops in Galway, Ireland (2005),
        Hiroshima, Japan (2004), Sanibel Island, USA (2003), Sardinia, Italy (2002),
        and Stanford, USA (2001).

        The organizing committee is soliciting paper submissions for the Research
        papers track and the Semantic Web In-Use papers track.""" ;
                     ns1:label "ISWC 2006" .

        ns2:IanHorrocks ns2:affiliation "University of Manchester" ;
                        ns2:country "United Kingdom" ;
                        a ns4:Person ;
                        ns1:label "Ian Horrocks" .

        ns2:IanPrattHartmann ns2:affiliation "Department of Computer Science, University of Manchester" ;
                             ns2:country "United Kingdom" ;
                             a ns4:Person ;
                             ns1:label "Ian Pratt-Hartmann" .

        ns2:IfILeipzig ns4:hasParts ns2:AKSW ;
                       a ns4:Institute ;
                       ns1:label "Department of Computer Science" ;
                       ns8:homepage <http://www.informatik.uni-leipzig.de/> .

        ns2:IngvarJohansson ns2:affiliation "Institute for Formal Ontology and Medical Information Science, University of Saarbrücken" ;
                            ns2:country "Germany" ;
                            a ns4:Person ;
                            ns1:label "Ingvar Johansson" .

        ns2:IntelligentSystems a ns4:Topic ;
                               ns1:label "IntelligentSystems"^^ns3:string .

        ns2:IsabelCruz ns2:affiliation "University Illinois at Chicago" ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Isabel Cruz" .

        ns2:JamesPustejovsky ns2:affiliation "Department of Computer Science, Brandeis University" ;
                             ns2:country "United States" ;
                             a ns4:Person ;
                             ns1:label "James Pustejovsky" .

        ns2:JaneHunter ns2:affiliation "University of Queensland" ;
                       ns2:country "Austria" ;
                       a ns4:Person ;
                       ns1:label "Jane Hunter" .

        ns2:JeenBroekstra ns2:affiliation "Technical University Eindhoven and Aduna" ;
                          ns2:country "Netherlands" ;
                          a ns4:Person ;
                          ns1:label "Jeen Broekstra" .

        ns2:JeffHeflin ns2:affiliation "Lehigh University" ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Jeff Heflin" .

        ns2:JeffZPan ns2:affiliation "University of Aberdeen" ;
                     ns2:country "United Kingdom" ;
                     a ns4:Person ;
                     ns1:label "Jeff Z. Pan" .

        ns2:JensLehmann ns2:country "Germany" ;
                        ns4:address "Johannisgasse 26, 04103 Leipzig, Germany" ;
                        ns4:affiliation ns2:UniversityOfLeipzig ;
                        ns4:email "lehmann@informatik.uni-leipzig.de" ;
                        ns4:fax "+49 341 9732329" ;
                        ns4:firstName "Jens" ;
                        ns4:lastName "Lehmann" ;
                        ns4:phone "+49 341 9732260" ;
                        a ns4:AcademicStaff, ns4:Person, ns4:PhDStudent ;
                        ns1:label "Jens Lehmann" ;
                        ns8:depiction "http://aksw.org/images/jpegPhoto.php?name=cn&value=Jens+Lehmann" ;
                        ns8:workInfoHomepage "http://jens-lehmann.org/" .

        ns2:JeremyJCarroll ns2:affiliation "HP Labs" ;
                           ns2:country "United Kingdom" ;
                           a ns4:Person ;
                           ns1:label "Jeremy J. Carroll" .

        ns2:JeromeEuzenat ns2:affiliation "INRIA Rhone-Alpes" ;
                          ns2:country "France" ;
                          a ns4:Person ;
                          ns1:label "Jerome Euzenat" .

        ns2:JerryHobbs ns2:affiliation "University of Southern California" ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Jerry Hobbs" .

        ns2:JimHendler ns2:affiliation "University of Maryland" ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Jim Hendler" .

        ns2:JinghaiRao ns2:affiliation "Carnegie Mellon University" ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Jinghai Rao" .

        ns2:JoergDiedrich ns2:affiliation "L3S Hannover" ;
                          ns2:country "Germany" ;
                          a ns4:Person ;
                          ns1:label "Joerg Diedrich" .

        ns2:JohannEder ns2:affiliation "University of Vienna" ;
                       ns2:country "Austria" ;
                       a ns4:Person ;
                       ns1:label "Johann Eder" .

        ns2:JohnBateman ns2:affiliation "Department of Applied English Linguistics, University of Bremen" ;
                        ns2:country "Germany" ;
                        a ns4:Person ;
                        ns1:label "John Bateman" .

        ns2:JohnDavies ns2:affiliation "BT" ;
                       ns2:country "United Kingdom" ;
                       a ns4:Person ;
                       ns1:label "John Davies" .

        ns2:JohnMylopoulos ns2:affiliation "University of Toronto" ;
                           ns2:country "Canada" ;
                           a ns4:Person ;
                           ns1:label "John Mylopoulos" .

        ns2:JohnSowa ns2:affiliation "Vivomind Intelligence Inc." ;
                     ns2:country "United States" ;
                     a ns4:Person ;
                     ns1:label "John Sowa" .

        ns2:JoostBreuker ns2:affiliation "Leibniz Center for Law, University of Amsterdam" ;
                         ns2:country "Netherlands" ;
                         a ns4:Person ;
                         ns1:label "Joost Breuker" .

        ns2:JosdeBruijn ns2:affiliation "DERI Innsbruck" ;
                        ns2:country "Austria" ;
                        a ns4:Person ;
                        ns1:label "Jos de Bruijn" .

        ns2:JournalofWebSemantics ns2:URL "http://authors.elsevier.com/JournalDetail.html?PubID=671322"^^ns3:anyURI ;
                                  ns2:interval "quarterly" ;
                                  ns2:issn "1570-8268" ;
                                  a ns4:Journal ;
                                  ns1:label "Journal of Web Semantics" .

        ns2:JrgenAngele ns2:affiliation "Ontoprise" ;
                        ns2:country "Germany" ;
                        a ns4:Person ;
                        ns1:label "Jürgen Angele" .

        ns2:JuergenAngele ns2:affiliation "Ontoprise GmbH" ;
                          ns2:country "Germany" ;
                          a ns4:Person ;
                          ns1:label "Juergen Angele" .

        ns2:KES2006 ns2:URL "http://kes2006.kesinternational.org"^^ns3:anyURI ;
                    ns2:place "Bournemouth International Conference Centre"^^ns3:string ;
                    ns2:start "2006-10-09"^^ns3:date ;
                    ns2:submissionsDue "2006-10-11"^^ns3:date ;
                    ns4:isAbout ns2:IntelligentSystems, ns2:KnowledgeEngineering ;
                    ns4:title "10th International Conference on Knowledge-Based & Intelligent Information & Engineering Systems" ;
                    ns4:year "2006" ;
                    a ns4:Conference ;
                    ns1:label "KES2006" ;
                    ns5:lat "50.72"^^ns3:float ;
                    ns5:long "-1.88"^^ns3:float .

        ns2:KalinaBontcheva ns2:affiliation "University Sheffield" ;
                            ns2:country "United Kingdom" ;
                            a ns4:Person ;
                            ns1:label "Kalina Bontcheva" .

        ns2:KatiaSycara ns2:affiliation "Carnegie Mellon University" ;
                        ns2:country "United States" ;
                        a ns4:Person ;
                        ns1:label "Katia Sycara" .

        ns2:KavithaSrinivas ns2:affiliation "IBM T. J. Watson Research Center" ;
                            ns2:country "United States" ;
                            a ns4:Person ;
                            ns1:label "Kavitha Srinivas" .

        ns2:KnowledgeEngineering a ns4:Topic ;
                                 ns1:label "KnowledgeEngineering"^^ns3:string .

        ns2:KrzysztofWecel ns2:affiliation "Poznan University of Economics" ;
                           ns2:country "Poland" ;
                           a ns4:Person ;
                           ns1:label "Krzysztof Wecel" .

        ns2:LarryKerschberg ns2:affiliation "George Mason University" ;
                            ns2:country "United States" ;
                            a ns4:Person ;
                            ns1:label "Larry Kerschberg" .

        ns2:LaureVieu ns2:affiliation "Research Institute for Computer Science, CNRS, Toulouse" ;
                      ns2:country "France" ;
                      a ns4:Person ;
                      ns1:label "Laure Vieu" .

        ns2:LeoObrst ns2:affiliation "MITRE" ;
                     ns2:country "United States" ;
                     a ns4:Person ;
                     ns1:label "Leo Obrst" .

        ns2:LeonardoLesmo ns2:affiliation "Department of Computer Science, University of Torino" ;
                          ns2:country "Italy" ;
                          a ns4:Person ;
                          ns1:label "Leonardo Lesmo" .

        ns2:LilianaCabral ns2:affiliation "Open University" ;
                          ns2:country "United Kingdom" ;
                          a ns4:Person ;
                          ns1:label "Liliana Cabral" .

        ns2:LjiljanaStojanovic ns2:affiliation "FZI Karlsruhe" ;
                               ns2:country "Germany" ;
                               a ns4:Person ;
                               ns1:label "Ljiljana Stojanovic" .

        ns2:ManolisKoubarakis ns2:affiliation "Technical University of Crete" ;
                              ns2:country "Greece" ;
                              a ns4:Person ;
                              ns1:label "Manolis Koubarakis" .

        ns2:MarcoAntonioCasanova ns2:affiliation "PUC-Rio" ;
                                 ns2:country "Brazil" ;
                                 a ns4:Person ;
                                 ns1:label "Marco Antonio Casanova" .

        ns2:MarcoPistore ns2:affiliation "University of Trento" ;
                         ns2:country "Italy" ;
                         a ns4:Person ;
                         ns1:label "Marco Pistore" .

        ns2:MariGeorges ns2:affiliation "ILOG" ;
                        ns2:country "France" ;
                        a ns4:Person ;
                        ns1:label "Mari Georges" .

        ns2:MarieChristineRousset ns2:affiliation "University Orsay" ;
                                  ns2:country "France" ;
                                  a ns4:Person ;
                                  ns1:label "Marie-Christine Rousset" .

        ns2:MaristellaAgosti ns2:affiliation "University of Padova" ;
                             ns2:country "Italy" ;
                             a ns4:Person ;
                             ns1:label "Maristella Agosti" .

        ns2:MarkoGrobelnik ns2:affiliation "J. Stefan Institute" ;
                           ns2:country "Slovenia" ;
                           a ns4:Person ;
                           ns1:label "Marko Grobelnik" .

        ns2:MarkoTadic ns2:affiliation "University of Zagreb" ;
                       ns2:country "Croatia" ;
                       a ns4:Person ;
                       ns1:label "Marko Tadic" .

        ns2:MartinDrr ns2:affiliation "Institute of Computer Science, FORTH, Heraklion" ;
                      ns2:country "Greece" ;
                      a ns4:Person ;
                      ns1:label "Martin Dörr" .

        ns2:MartinDzbor ns2:affiliation "Open University" ;
                        ns2:country "United Kingdom" ;
                        a ns4:Person ;
                        ns1:label "Martin Dzbor" .

        ns2:MartinHepp ns2:affiliation "University of Innsbruck and DERI" ;
                       ns2:country "Austria" ;
                       a ns4:Person ;
                       ns1:label "Martin Hepp" .

        ns2:MasahiroHori ns2:affiliation "Kansai University" ;
                         ns2:country "Japan" ;
                         a ns4:Person ;
                         ns1:label "Masahiro Hori" .

        ns2:MassimoPoesio ns2:affiliation "Department of Computer Science, University of Essex" ;
                          ns2:country "United Kingdom" ;
                          a ns4:Person ;
                          ns1:label "Massimo Poesio" .

        ns2:MatteoCristani ns2:affiliation "University of Verona" ;
                           ns2:country "Italy" ;
                           a ns4:Person ;
                           ns1:label "Matteo Cristani" .

        ns2:MatthiasKlusch ns2:affiliation "DFKI Saarbruecken" ;
                           ns2:country "Germany" ;
                           a ns4:Person ;
                           ns1:label "Matthias Klusch" .

        ns2:MaurizioLenzerini ns2:affiliation "Universita di Roma Sapienza" ;
                              ns2:country "Italy" ;
                              a ns4:Person ;
                              ns1:label "Maurizio Lenzerini" .

        ns2:MichaelGruninger ns2:affiliation "University of Toronto" ;
                             ns2:country "Canada" ;
                             a ns4:Person ;
                             ns1:label "Michael Gruninger" .

        ns2:MichaelSintek ns2:affiliation "DFKI Kaiserslautern" ;
                          ns2:country "Germany" ;
                          a ns4:Person ;
                          ns1:label "Michael Sintek" .

        ns2:MichaelStollberg ns2:affiliation "DERI Innsbruck" ;
                             ns2:country "Austria" ;
                             a ns4:Person ;
                             ns1:label "Michael Stollberg" .

        ns2:MichaelWooldridge ns2:affiliation "University of Liverpool" ;
                              ns2:country "United Kingdom" ;
                              a ns4:Person ;
                              ns1:label "Michael Wooldridge" .

        ns2:MicheleMissikoff ns2:affiliation "CNR" ;
                             ns2:country "Italy" ;
                             a ns4:Person ;
                             ns1:label "Michele Missikoff" .

        ns2:MihhailMatskin ns2:affiliation "KTH Stockholm" ;
                           ns2:country "Sweden" ;
                           a ns4:Person ;
                           ns1:label "Mihhail Matskin" .

        ns2:MikeUschold ns2:affiliation "The Boeing Company" ;
                        ns2:country "United States" ;
                        a ns4:Person ;
                        ns1:label "Mike Uschold" .

        ns2:MobileComputing a ns4:Topic ;
                            ns1:label "MobileComputing"^^ns3:string .

        ns2:MohandSaidHacid ns2:affiliation "Universite Claude Bernard Lyon" ;
                            ns2:country "France" ;
                            a ns4:Person ;
                            ns1:label "Mohand Said Hacid" .

        ns2:MuhammadAhtishamAslam ns2:country "Germany" ;
                                  ns4:address "Johannisgasse 26, 04103 Leipzig, Germany" ;
                                  ns4:affiliation ns2:UniversityOfLeipzig ;
                                  ns4:email "ahtisham_a@hotmail.com" ;
                                  ns4:fax "+49 341 9732329" ;
                                  ns4:firstName "Muhammad Ahtisham" ;
                                  ns4:lastName "Aslam" ;
                                  a ns4:AcademicStaff, ns4:Person, ns4:PhDStudent ;
                                  ns1:label "Muhammad Ahtisham Aslam" ;
                                  ns8:depiction "http://aksw.org/images/jpegPhoto.php?name=sn&value=Aslam" .

        ns2:Multiagent-Systems a ns4:Topic ;
                               ns1:label "Multiagent-Systems"^^ns3:string .

        ns2:MultiagentSystems a ns4:Topic ;
                              ns1:label "MultiagentSystems"^^ns3:string .

        ns2:NETObjectDays2006 ns2:URL "http://www.netobjectdays.org"^^ns3:anyURI ;
                              ns2:end "2006-09-21"^^ns3:date ;
                              ns2:place "Erfurt, Germany"^^ns3:string ;
                              ns2:start "2006-09-18"^^ns3:date ;
                              ns4:title "Net.ObjectDays 2006"^^ns3:string ;
                              ns4:year "2006" ;
                              a ns4:Conference ;
                              ns1:label "NET.ObjectDays2006" ;
                              ns5:lat "50.983333"^^ns3:float ;
                              ns5:long "11.033333"^^ns3:float .

        ns2:NatashaNoy ns1:label "Natasha Noy" .

        ns2:NathalieAussenacGilles ns2:affiliation "Research Institute for Computer Science, CNRS, Toulouse" ;
                                   ns2:country "France" ;
                                   a ns4:Person ;
                                   ns1:label "Nathalie Aussenac-Gilles" .

        ns2:NicholasAsher ns2:affiliation "Department of Philosophy, University of Texas at Austin" ;
                          ns2:country "United States" ;
                          a ns4:Person ;
                          ns1:label "Nicholas Asher" .

        ns2:NicolaGuarino ns2:affiliation "CNR" ;
                          ns2:country "Italy" ;
                          a ns4:Person ;
                          ns1:label "Nicola Guarino" .

        ns2:NicolaHenze ns2:affiliation "University of Hannover" ;
                        ns2:country "Germany" ;
                        a ns4:Person ;
                        ns1:label "Nicola Henze" .

        ns2:NigelCollier ns2:affiliation "National Institute of Informatics" ;
                         ns2:country "Japan" ;
                         a ns4:Person ;
                         ns1:label "Nigel Collier" .

        ns2:NormanHeino ns2:country "Germany" ;
                        ns4:studiesAt ns2:UniversityOfLeipzig ;
                        a ns4:Student, ns4:Person ;
                        ns1:label "Norman Heino" .

        ns2:ODBASE2006 ns2:URL "http://www.cs.rmit.edu.au/fedconf/"^^ns3:anyURI ;
                       ns2:abstractsDue "2006-05-30"^^ns3:date ;
                       ns2:acceptanceNotification "2006-08-05"^^ns3:date ;
                       ns2:camera-readySubmission "2006-08-20"^^ns3:date ;
                       ns2:end "2006-11-03"^^ns3:date ;
                       ns2:logo "http://www.cs.rmit.edu.au/fedconf/img/odbase2006cfp.gif"^^ns3:anyURI ;
                       ns2:pcMember ns2:AlexBorgida, ns2:ArantzaIllarramendi, ns2:BillAndersen, ns2:ChrisWelty, ns2:ChristophBussler, ns2:DavidToman, ns2:FranzBaader, ns2:GeorgLausen, ns2:GiuseppeDeGiacomo, ns2:GuidoVetere, ns2:HeikoSchuldt, ns2:JeffHeflin, ns2:JimHendler, ns2:JohannEder, ns2:JohnMylopoulos, ns2:JuergenAngele, ns2:LarryKerschberg, ns2:MarcoAntonioCasanova, ns2:MaristellaAgosti, ns2:MicheleMissikoff, ns2:MohandSaidHacid, ns2:NicolaGuarino, ns2:PeterSchwarz, ns2:PeterSpyns, ns2:RainerEckstein, ns2:RogerBuzzKing, ns2:RossKing, ns2:SergioTessaris, ns2:SibelAdali, ns2:SilvanaCastano, ns2:SoniaBergamaschi, ns2:StefanDecker, ns2:ThomasRisse, ns2:TizianaCatarci, ns2:VipulKashyap, ns2:WolfgangNeijdl, ns2:YorkSure ;
                       ns2:place "Montpellier, France"^^ns3:string ;
                       ns2:programmeCommittee """* Sibel Adali (Rensselaer Polytechnic Univ., USA)
            * Maristella Agosti (University of Padova, Italy)
            * Bill Andersen (OntoWorks, USA)
            * Juergen Angele (Ontoprise GmbH, Germany)
            * Franz Baader (University of Dresden, Germany)
            * Sonia Bergamaschi (Università di Modena e Reggio Emilia, Italy)
            * Alex Borgida (Rutgers University, USA)
            * Christoph Bussler (Cisco Systems, USA)
            * Marco Antonio Casanova (PUC-Rio, Brazil)
            * Silvana Castano (University of Milan, Italy)
            * Tiziana Catarci (Universita degli Studi di Roma \"La Sapienza\", Italy)
            * Giuseppe De Giacomo (University of Roma \"La Sapienza\", Italy)
            * Stefan Decker (DERI Galway, Ireland)
            * Rainer Eckstein (Humboldt-Universitaet zu Berlin, Germany)
            * Johann Eder (University of Vienna, Austria)
            * Nicola Guarino (CNR, Trento, Italy)
            * Mohand Said Hacid (Universite Claude Bernard Lyon, France)
            * Jeff Heflin (Lehigh University, USA)
            * Jim Hendler (University of Maryland, College Park)
            * Edward Hung (Hong Kong Polytechnic University)
            * Arantza Illarramendi (Basque Country University, Spain)
            * Vipul Kashyap (Partners HealthCare Systems, USA)
            * Larry Kerschberg (George Mason University, USA)
            * Ross King (Research Studios Austria - DME, Austria)
            * Roger (Buzz) King (University of Colorado, USA)
            * Harumi Kuno (HP Labs)
            * Georg Lausen (University of Freiburg, Germany)
            * Michele Missikoff (CNR, Italy)
            * John Mylopoulos (University of Toronto, Canada)
            * Wolfgang Neijdl (L3C, Germany)
            * Christine Parent (Universite de Lausanne Switzerland)
            * Thomas Risse (Fraunhofer IPSI, Germany)
            * Heiko Schuldt (University Basel, Switzerland)
            * Peter Schwarz (IBM, USA)
            * Peter Spyns (Vrije Universiteit Brussels, Belgium)
            * York Sure (University Karlsruhe, Germany)
            * Sergio Tessaris (Free University of Bozen-Bolzano, Italy)
            * David Toman (University of Waterloo, Canada)
            * Guido Vetere (IBM, Italy)
            * Chris Welty (IBM, USA)"""^^ns3:string ;
                       ns2:start "2006-10-29"^^ns3:date ;
                       ns2:submissionsDue "2006-06-10"^^ns3:date ;
                       ns4:isAbout ns2:Databases, ns2:Ontologies ;
                       ns4:title "5th International Conference on Ontologies, DataBases, and Applications of Semantics" ;
                       ns4:year "2006" ;
                       a ns4:Conference ;
                       ns1:comment """As in previous years, the 2006 conference on Ontologies, DataBases, and Applications of
        Semantics (ODBASE06) provides a forum for exchanging the latest research results on ontologies,
        data semantics, and other areas of computing involved in developing the Semantic Web.

        ODBASE06 intends to draw a highly diverse body of researchers and practitioners by being part
        of the Federated Symposium Event \"On the Move to Meaningful Internet Systems 2006\" that co-locates
        four conferences: ODBASE06, DOA06 (International Symposium on Distributed Objects and Applications),
        CoopIS06 (International Conference on Cooperative Information Systems), and GADA06 (International
        Symposium on Grid computing, high-performAnce and Distributed Applications).

        Of particular relevance to ODBASE06 are papers that bridge traditional boundaries
        between disciplines such as databases, artificial intelligence, networking, computational
        linguistics, and mobile computing. ODBASE06 also encourages the submission of research and
        practical experience papers concerning scalability issues in ontology management, information
        integration, and data mining, as well as papers that examine the information needs of various
        applications, including electronic commerce, electronic government, mobile systems,
        and bioinformatics.

        ODBASE06 will consider two categories of papers: research and experience. Research papers must
        contain novel, unpublished results. Experience papers must describe existing, realistically
        large systems. Preference will be given to papers that describe software products or systems
        that are in wide experimental use.""" ;
                       ns1:label "ODBASE 2006" ;
                       ns5:lat "43.611944"^^ns3:float ;
                       ns5:long "3.877222"^^ns3:float .

        ns2:OntoWiki ns4:carriedOutBy ns2:AKSW ;
                     ns6:bug-database <http://sourceforge.net/tracker/?group_id=99425&atid=624170> ;
                     ns6:description "OntoWiki is a tool providing support for agile, distributed knowledge engineering scenarios. OntoWiki facilitates the visual presentation of a knowledge base as an information map, with different views on instance data. It enables intuitive authoring of semantic content, with an inline editing mode for editing RDF content, smiliar to WYSIWIG for text documents. It fosters social collaboration aspects by keeping track of changes, allowing to comment and discuss every single part of a knowledge base, enabling to rate and measure the popularity of content and honoring the activity of users." ;
                     ns6:developer ns2:NormanHeino ;
                     ns6:download-page <http://sourceforge.net/project/showfiles.php?group_id=99425> ;
                     ns6:homepage ns10:OntoWiki ;
                     ns6:license ns11:gpl ;
                     ns6:maintainer ns2:SebastianDietzold ;
                     ns6:name "OntoWiki" ;
                     ns6:programming-language "PHP", "JavaScript" ;
                     ns6:shortdesc "A Tool for Social, Semantic Collaboration" ;
                     a ns4:SoftwareProject ;
                     ns1:label "OntoWiki" ;
                     ns8:depiction ns12:jpg .

        ns2:Ontologies a ns4:Topic .

        ns2:OscarCorcho ns2:affiliation "University of Manchester" ;
                        ns2:country "United Kingdom" ;
                        a ns4:Person ;
                        ns1:label "Oscar Corcho" .

        ns2:P2P a ns4:Topic .

        ns2:PSI2006 ns2:URL "http://www.iis.nsk.su/PSI06/"^^ns3:anyURI ;
                    ns2:end "2006-06-30"^^ns3:date ;
                    ns2:place "Novosibirsk, Akademgorodok, Russia"^^ns3:string ;
                    ns2:start "2006-06-27"^^ns3:date ;
                    ns4:isAbout ns2:ArtificialIntelligence, ns2:Databases, ns2:SoftwareEngineering ;
                    ns4:title "Sixth International Andrei Ershov Memorial Conference" ;
                    ns4:year "2006" ;
                    a ns4:Conference ;
                    ns1:label "PSI2006" ;
                    ns5:lat "54.988889"^^ns3:float ;
                    ns5:long "82.904167"^^ns3:float .

        ns2:PaoloBouquet ns2:affiliation "University of Trento" ;
                         ns2:country "Italy" ;
                         a ns4:Person ;
                         ns1:label "Paolo Bouquet" .

        ns2:PaoloTraverso ns2:affiliation "Automated Reasoning Systems Division at ITC/IRST" ;
                          ns2:country "Italy" ;
                          a ns4:Person ;
                          ns1:label "Paolo Traverso" .

        ns2:PascalHitzler ns2:affiliation "University of Karlsruhe" ;
                          ns2:country "Germany" ;
                          a ns4:Person ;
                          ns1:label "Pascal Hitzler" .

        ns2:PaulBuitelaar ns2:affiliation "DFKI Saarbruecken" ;
                          ns2:country "Germany" ;
                          a ns4:Person ;
                          ns1:label "Paul Buitelaar" .

        ns2:PaulodaPinheiro ns2:affiliation "Stanford University" ;
                            ns2:country "United States" ;
                            a ns4:Person ;
                            ns1:label "Paulo da Pinheiro" .

        ns2:PeterSchwarz ns2:affiliation "IBM" ;
                         ns2:country "United States" ;
                         a ns4:Person ;
                         ns1:label "Peter Schwarz" .

        ns2:PeterSpyns ns2:affiliation "Vrije Universiteit Brussels"^^ns3:string ;
                       ns2:country "Belgium"@en ;
                       a ns4:Person ;
                       ns1:label "Peter Spyns" .

        ns2:PhilippFrischmuth ns2:country "Germany" ;
                              ns4:studiesAt ns2:UniversityOfLeipzig ;
                              a ns4:Student, ns4:Person ;
                              ns1:label "Philipp Frischmuth" .

        ns2:PhilippeMuller ns2:affiliation "Research Institute for Computer Science, University of Toulouse III" ;
                           ns2:country "France" ;
                           a ns4:Person ;
                           ns1:label "Philippe Muller" .

        ns2:PierdanieleGiaretta ns2:affiliation "Department of Philosophy, University of Verona" ;
                                ns2:country "Italy" ;
                                a ns4:Person ;
                                ns1:label "Pierdaniele Giaretta" .

        ns2:Powl ns4:carriedOutBy ns2:AKSW ;
                 ns6:bug-database <http://sourceforge.net/tracker/?group_id=99425&atid=624170> ;
                 ns6:description "Powl is a Semantic Web application development framework featuring a comprehensive API for handling RDF, RDFS and OWL, a library of semantic widgets and a web based user interface. Powl is implemented for the most widely deployed web application environment: PHP and MySQL. Powl was downloaded over 3.000 times and has an active developer and user community." ;
                 ns6:developer ns2:PhilippFrischmuth ;
                 ns6:download-page <http://sourceforge.net/project/showfiles.php?group_id=99425> ;
                 ns6:homepage ns10:Powl ;
                 ns6:license ns11:gpl ;
                 ns6:maintainer ns2:SrenAuer ;
                 ns6:name "Powl" ;
                 ns6:programming-language "PHP", "JavaScript" ;
                 ns6:shortdesc "Semantic Web Development Plattform" ;
                 a ns4:SoftwareProject ;
                 ns1:label "Powl" ;
                 ns8:depiction ns13:png .

        ns2:ProcessModeling a ns4:Topic ;
                            ns1:label "ProcessModeling"^^ns3:string .

        ns2:RainerEckstein ns2:affiliation "Humboldt-Universitaet zu Berlin" ;
                           ns2:country "Germany" ;
                           a ns4:Person ;
                           ns1:label "Rainer Eckstein" .

        ns2:RalfMoeller ns2:affiliation "Hamburg University of Technology" ;
                        ns2:country "Germany" ;
                        a ns4:Person ;
                        ns1:label "Ralf Moeller" .

        ns2:RaphaelTroncy ns2:affiliation "CWI Amsterdam" ;
                          ns2:country "Netherlands" ;
                          a ns4:Person ;
                          ns1:label "Raphael Troncy" .

        ns2:RichardBenjamins ns2:affiliation "iSOCO" ;
                             ns2:country "Spain" ;
                             a ns4:Person ;
                             ns1:label "Richard Benjamins" .

        ns2:RichmondThomason ns2:affiliation "University of Michigan" ;
                             ns2:country "United States" ;
                             a ns4:Person ;
                             ns1:label "Richmond Thomason" .

        ns2:RiichiroMizoguchi ns2:affiliation "Osaka University" ;
                              ns2:country "Japan" ;
                              a ns4:Person ;
                              ns1:label "Riichiro Mizoguchi" .

        ns2:RobertRynasiewicz ns2:affiliation "Johns Hopkins University" ;
                              ns2:country "United States" ;
                              a ns4:Person ;
                              ns1:label "Robert Rynasiewicz" .

        ns2:RobertTolksdorf ns2:affiliation "Free University Berlin" ;
                            ns2:country "Germany" ;
                            a ns4:Person ;
                            ns1:label "Robert Tolksdorf" .

        ns2:RobertoCasati ns2:affiliation "Jean Nicod Institute, CNRS, Paris" ;
                          ns2:country "France" ;
                          a ns4:Person ;
                          ns1:label "Roberto Casati" .

        ns2:RogerBuzzKing ns2:affiliation "University of Colorado" ;
                          ns2:country "United States" ;
                          a ns4:Person ;
                          ns1:label "Roger (Buzz) King" .

        ns2:RossKing ns2:affiliation "Research Studios Austria - DME" ;
                     ns2:country "Austria" ;
                     a ns4:Person ;
                     ns1:label "Ross King" .

        ns2:RubenLara ns2:affiliation "Tecnologia, Informacion y Finanzas" ;
                      ns2:country "Spain" ;
                      a ns4:Person ;
                      ns1:label "Ruben Lara" .

        ns2:RudiStuder ns2:affiliation "University of Karlsruhe" ;
                       ns2:country "Germany" ;
                       a ns4:Person ;
                       ns1:label "Rudi Studer" .

        ns2:SCC2006 ns2:URL "http://conferences.computer.org/scc"^^ns3:anyURI ;
                    ns2:inConjunctionWith ns2:CoSTEP2006 ;
                    ns4:title "IEEE International Conference on Services Computing"^^ns3:string ;
                    ns4:year "2006" ;
                    a ns4:Conference ;
                    ns1:label "SCC2006" .

        ns2:SIGMOD2006 ns2:URL "http://tangra.si.umich.edu/clair/sigmod-pods06"^^ns3:anyURI ;
                       ns2:end "2006-06-29"^^ns3:date ;
                       ns2:place "Chicago, USA"^^ns3:string ;
                       ns2:start "2006-06-26"^^ns3:date ;
                       ns4:isAbout ns2:Databases, ns2:P2P ;
                       ns4:title "ACM SIGMOD International Conference on Management of Data"^^ns3:string ;
                       ns4:year "2006" ;
                       a ns4:Conference ;
                       ns1:label "SIGMOD2006" ;
                       ns5:lat "41.9"^^ns3:float ;
                       ns5:long "-87.65"^^ns3:float .

        ns2:SeanBechhofer ns2:affiliation "University of Manchester" ;
                          ns2:country "United Kingdom" ;
                          a ns4:Person ;
                          ns1:label "Sean Bechhofer" .

        ns2:SebastianDietzold ns2:country "Germany" ;
                              ns4:address "Johannisgasse 26, 04103 Leipzig, Germany" ;
                              ns4:affiliation ns2:UniversityOfLeipzig ;
                              ns4:email "dietzold@informatik.uni-leipzig.de" ;
                              ns4:fax "+49 341 9732329" ;
                              ns4:firstName "Sebastian" ;
                              ns4:lastName "Dietzold" ;
                              ns4:phone "+49 341 9732366" ;
                              a ns4:AcademicStaff, ns4:PhDStudent, ns4:Person ;
                              ns1:label "Sebastian Dietzold" ;
                              ns1:seeAlso ns14:rdf ;
                              ns8:depiction "http://aksw.org/images/jpegPhoto.php?name=sn&value=Dietzold" ;
                              ns8:homepage ns15:de ;
                              ns8:mbox_sha1sum "16ef723e22f2b7c6fc04f151cc7bd400918330b3" ;
                              ns8:workInfoHomepage "http://bis.informatik.uni-leipzig.de/SebastianDietzold" .

        ns2:SemTech2006 ns2:URL "http://www.semantic-conference.com/"^^ns3:anyURI ;
                        ns2:audience "Academia"^^ns3:string, "Business", "Investors" ;
                        ns2:end "2006-03-09"^^ns3:date ;
                        ns2:place "San Jose, California, USA"^^ns3:string ;
                        ns2:start "2006-03-06"^^ns3:date ;
                        ns4:title "2006 Semantic Technology Conference" ;
                        ns4:year "2006" ;
                        a ns4:Conference ;
                        ns1:label "SemTech 2006" ;
                        ns5:lat "37.304167"^^ns3:float ;
                        ns5:long "-121.872778"^^ns3:float .

        ns2:SemanticWeb a ns4:Topic .

        ns2:SergioTessaris ns2:affiliation "Free University Bozen" ;
                           ns2:country "Italy" ;
                           a ns4:Person ;
                           ns1:label "Sergio Tessaris" .

        ns2:SibelAdali ns2:affiliation "Rensselaer Polytechnic Univ." ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Sibel Adali" .

        ns2:SiegfriedHandschuh ns2:affiliation "FZI Karlsruhe" ;
                               ns2:country "Germany" ;
                               a ns4:Person ;
                               ns1:label "Siegfried Handschuh" .

        ns2:SilvanaCastano ns2:affiliation "University of Milan" ;
                           ns2:country "Italy" ;
                           a ns4:Person ;
                           ns1:label "Silvana Castano" .

        ns2:SimonMilton ns2:affiliation "Department of Information Systems, University of Melbourne" ;
                        ns2:country "Australia" ;
                        a ns4:Person ;
                        ns1:label "Simon Milton" .

        ns2:SofiaPinto ns2:affiliation "Technical University of Lisbon" ;
                       ns2:country "Portugal" ;
                       a ns4:Person ;
                       ns1:label "Sofia Pinto" .

        ns2:SoftWiki ns4:carriedOutBy ns2:AKSW ;
                     ns6:description "The aim of the cooperative research project SoftWiki is to support the collaboration of all stakeholders in software development processes in particular with respect to software requirements. Potentially very large and spatially distributed user groups shall be enabled to collect, semantically enrich, classify and aggregate software requirements. The solution will be founded on the Semantic Web standards for terminological knowledge representation. The implementation will base on generic means of semantic collaboration using next generation Web user interfaces (in the spirit of Social Software and the Web 2.0) thus fostering completely new means of Requirements Engineering with very large user groups." ;
                     ns6:homepage ns16:de ;
                     ns6:name "OntoWiki" ;
                     ns6:shortdesc "Distributed, End-user Centered Requirements Engineering for Evolutionary Software Development" ;
                     a ns4:ResearchProject ;
                     ns1:label "SoftWiki" .

        ns2:SoftwareEngineering a ns4:Topic ;
                                ns1:label "SoftwareEngineering"^^ns3:string .

        ns2:SoniaBergamaschi ns2:affiliation "Università di Modena e Reggio Emilia" ;
                             ns2:country "Italy" ;
                             a ns4:Person ;
                             ns1:label "Sonia Bergamaschi" .

        ns2:SrenAuer ns2:country "Germany" ;
                     ns4:address "Johannisgasse 26, 04103 Leipzig, Germany" ;
                     ns4:affiliation ns2:UniversityOfLeipzig ;
                     ns4:email "auer@informatik.uni-leipzig.de" ;
                     ns4:fax "+49 341 9732329" ;
                     ns4:firstName "Sören" ;
                     ns4:lastName "Auer" ;
                     ns4:phone "+49 341 9732367" ;
                     a ns4:AcademicStaff, ns4:Person ;
                     ns1:label "Sören Auer" ;
                     ns8:depiction "http://aksw.org/images/jpegPhoto.php?name=sn&value=Auer" ;
                     ns8:workInfoHomepage "http://www.informatik.uni-leipzig.de/~auer" .

        ns2:StefanDecker ns2:affiliation "DERI Galway" ;
                         ns2:country "Ireland" ;
                         a ns4:Person ;
                         ns1:label "Stefan Decker" .

        ns2:StefanSchlobach ns2:affiliation "Vrije Universiteit Amsterdam" ;
                            ns2:country "Netherlands" ;
                            a ns4:Person ;
                            ns1:label "Stefan Schlobach" .

        ns2:StefanoBorgo ns2:affiliation "Laboratory for Applied Ontology, ISTC-CNR" ;
                         ns2:country "Italy" ;
                         a ns4:Person ;
                         ns1:label "Stefano Borgo" .

        ns2:SteffenStaab ns2:affiliation "University of Koblenz" ;
                         ns2:country "Germany" ;
                         a ns4:Person ;
                         ns1:label "Steffen Staab" .

        ns2:SteveWillmott ns2:affiliation "Universidad Politecnica de Cataluna" ;
                          ns2:country "Spain" ;
                          a ns4:Person ;
                          ns1:label "Steve Willmott" .

        ns2:TMRA2006 ns2:URL "http://www.informatik.uni-leipzig.de/~tmra/"^^ns3:anyURI ;
                     ns2:end "2006-02-12"^^ns3:date ;
                     ns2:place "Leipzig, Germany"^^ns3:string ;
                     ns2:start "2006-10-11"^^ns3:date ;
                     ns2:submissionsDue "2006-06-02"^^ns3:date ;
                     ns4:isAbout ns2:TopicMaps ;
                     ns4:title "Topic Maps Research and Applications" ;
                     ns4:year "2006" ;
                     a ns4:Conference ;
                     ns1:label "TMRA 2006" ;
                     ns5:lat "51.333333"^^ns3:float ;
                     ns5:long "12.383333"^^ns3:float .

        ns2:TerryPayne ns2:affiliation "University of Southampton" ;
                       ns2:country "United Kingdom" ;
                       a ns4:Person ;
                       ns1:label "Terry Payne" .

        ns2:ThomasRiechert ns2:country "Germany" ;
                           ns4:address "Johannisgasse 26, 04103 Leipzig, Germany" ;
                           ns4:affiliation ns2:UniversityOfLeipzig ;
                           ns4:email "riechert@informatik.uni-leipzig.de" ;
                           ns4:fax "+49 341 9732329" ;
                           ns4:firstName "Thomas" ;
                           ns4:lastName "Riechert" ;
                           ns4:phone "+49 341 9732323" ;
                           a ns4:AcademicStaff, ns4:Person, ns4:PhDStudent ;
                           ns1:label "Thomas Riechert" ;
                           ns8:depiction "http://aksw.org/images/jpegPhoto.php?name=sn&value=Riechert" ;
                           ns8:workInfoHomepage "http://bis.informatik.uni-leipzig.de/ThomasRiechert" .

        ns2:ThomasRisse ns2:affiliation "Fraunhofer IPSI" ;
                        ns2:country "Germany" ;
                        a ns4:Person ;
                        ns1:label "Thomas Risse" .

        ns2:TizianaCatarci ns2:affiliation "Universita degli Studi di Roma \"La Sapienza\"" ;
                           ns2:country "Italy" ;
                           a ns4:Person ;
                           ns1:label "Tiziana Catarci" .

        ns2:TonyCohn ns2:affiliation "School of Computing, University of Leeds" ;
                     ns2:country "United Kingdom" ;
                     a ns4:Person ;
                     ns1:label "Tony Cohn" .

        ns2:TopicMaps a ns4:Topic .

        ns2:URL a ns0:DatatypeProperty ;
                ns1:label "URL" .

        ns2:UbboVisser ns2:affiliation "University of Bremen" ;
                       ns2:country "Germany" ;
                       a ns4:Person ;
                       ns1:label "Ubbo Visser" .

        ns2:UdoHahn ns2:affiliation "Jena University" ;
                    ns2:country "Germany" ;
                    a ns4:Person ;
                    ns1:label "Udo Hahn" .

        ns2:UlrichReimer ns2:affiliation "University of Konstanz and University of Applied Sciences St. Gallen" ;
                         ns2:country "Switzerland" ;
                         a ns4:Person ;
                         ns1:label "Ulrich Reimer" .

        ns2:UniversityOfLeipzig ns4:hasParts ns2:FMILeipzig ;
                                a ns4:University ;
                                ns1:label "University of Leipzig" ;
                                ns8:homepage <http://www.uni-leipzig.de/> .

        ns2:VLDB2006 ns2:URL "http://aitrc.kaist.ac.kr/~vldb06/"^^ns3:anyURI ;
                     ns2:abstractsDue "2006-03-09"^^ns3:date ;
                     ns2:acceptanceNotification "2006-05-30"^^ns3:date ;
                     ns2:camera-readySubmission "2006-06-23"^^ns3:date ;
                     ns2:end "2006-09-15"^^ns3:date ;
                     ns2:place "Convention and Exhibition Center (COEX), Seoul, Korea"^^ns3:string ;
                     ns2:start "2006-09-12"^^ns3:date ;
                     ns2:submissionsDue "2006-03-16"^^ns3:date ;
                     ns4:isAbout ns2:Databases ;
                     ns4:title "32nd International Conference on Very Large Data Bases" ;
                     ns4:year "2006" ;
                     a ns4:Conference ;
                     ns1:label "VLDB2006" ;
                     ns5:lat "37.583333"^^ns3:float ;
                     ns5:long "127"^^ns3:float .

        ns2:ValentinaTamma ns2:affiliation "University of Liverpool" ;
                           ns2:country "United Kingdom" ;
                           a ns4:Person ;
                           ns1:label "Valentina Tamma" .

        ns2:VangelisKarkaletsis ns2:affiliation "NCSR Demokritos" ;
                                ns2:country "Greece" ;
                                a ns4:Person ;
                                ns1:label "Vangelis Karkaletsis" .

        ns2:VedaStorey ns2:affiliation "Department of Computer Information Systems, Georgia State University" ;
                       ns2:country "United States" ;
                       a ns4:Person ;
                       ns1:label "Veda Storey" .

        ns2:VibhuMittal ns2:affiliation "Google Research" ;
                        ns2:country "United States" ;
                        a ns4:Person ;
                        ns1:label "Vibhu Mittal" .

        ns2:VipulKashyap ns2:affiliation "Clinical informatics R&D" ;
                         ns2:country "United States" ;
                         a ns4:Person ;
                         ns1:label "Vipul Kashyap" .

        ns2:VojtechSvatek ns2:affiliation "University of Economics" ;
                          ns2:country "Czech Republic" ;
                          a ns4:Person ;
                          ns1:label "Vojtech Svatek" .

        ns2:VolkerHaarslev ns2:affiliation "Concordia University" ;
                           ns2:country "Canada" ;
                           a ns4:Person ;
                           ns1:label "Volker Haarslev" .

        ns2:WETICE2006 ns2:URL "http://wetice.co.umist.ac.uk/"^^ns3:anyURI ;
                       ns2:end "2006-06-28"^^ns3:date ;
                       ns2:logo "http://wetice.co.umist.ac.uk/assets/images/wetice2006.jpg"^^ns3:anyURI ;
                       ns2:place "The University of Manchester, Manchester, U.K."^^ns3:string ;
                       ns2:start "2006-06-26"^^ns3:date ;
                       ns4:isAbout ns2:E-Collaboration, ns2:Multiagent-Systems ;
                       ns4:title "15th International Workshops on Enabling Technologies: Infrastructures for Collaborative Enterprises" ;
                       ns4:year "2006" ;
                       a ns4:Conference ;
                       ns1:label "WETICE 2006" ;
                       ns5:lat "53.483333"^^ns3:float ;
                       ns5:long "-2.25"^^ns3:float .

        ns2:WORLDCOMP06 ns2:URL "http://www.world-academy-of-science.org/worldcomp06/ws"^^ns3:anyURI ;
                        ns2:end "2006-06-29"^^ns3:date ;
                        ns2:place "Las Vegas, USA"^^ns3:string ;
                        ns2:start "2006-06-26"^^ns3:date ;
                        ns4:title "The 2006 World Congress in Computer Science, Computer Engineering, and Applied Computing" ;
                        ns4:year "2006" ;
                        a ns4:Conference ;
                        ns1:label "WORLDCOMP06" ;
                        ns5:lat "36.183333"^^ns3:float ;
                        ns5:long "-115.216667"^^ns3:float .

        ns2:WWW2006 ns2:URL "http://www2006.org"^^ns3:anyURI ;
                    ns2:end "2006-05-26"^^ns3:date ;
                    ns2:logo "http://www2006.org/images/template/titlelogo.gif"^^ns3:anyURI ;
                    ns2:place "Edinburgh International Conference Centre"^^ns3:string ;
                    ns2:start "2006-05-23"^^ns3:date ;
                    ns4:isAbout ns2:WorldWideWeb ;
                    ns4:title "15th International World Wide Web Conference" ;
                    ns4:year "2006" ;
                    a ns4:Conference ;
                    ns1:label "WWW2006" ;
                    ns5:lat "55.949556"^^ns3:float ;
                    ns5:long "-3.160288"^^ns3:float .

        ns2:WWW2007 ns2:URL "http://www2007.org/"^^ns3:anyURI ;
                    ns2:end "2007-05-12"^^ns3:date ;
                    ns2:logo "http://www2007.org/images/menuWWW2007logo.jpg"^^ns3:anyURI ;
                    ns2:place "Banff, Canada"^^ns3:string ;
                    ns2:start "2007-05-08"^^ns3:date ;
                    ns2:submissionsDue "2006-11-20"^^ns3:date ;
                    ns4:title "16th International World Wide Web Conference"^^ns3:string ;
                    ns4:year "2007" ;
                    a ns4:Conference ;
                    ns1:label "WWW2007" ;
                    ns5:lat "50.729502"^^ns3:float ;
                    ns5:long "-110.67627"^^ns3:float .

        ns2:WalterBinder ns2:affiliation "EPFL" ;
                         ns2:country "Switzerland" ;
                         a ns4:Person ;
                         ns1:label "Walter Binder" .

        ns2:WebApplications a ns4:Topic ;
                            ns1:label "WebApplications"^^ns3:string .

        ns2:WebServices a ns4:Topic ;
                        ns1:label "WebServices"^^ns3:string .

        ns2:WernerCeusters ns2:affiliation "European Centre for Ontological Research" ;
                           ns2:country "Germany" ;
                           a ns4:Person ;
                           ns1:label "Werner Ceusters" .

        ns2:WernerKuhn ns2:affiliation "IFGI" ;
                       ns2:country "Germany" ;
                       a ns4:Person ;
                       ns1:label "Werner Kuhn" .

        ns2:WolfgangNeijdl ns2:affiliation "L3C" ;
                           ns2:country "Germany" ;
                           a ns4:Person ;
                           ns1:label "Wolfgang Neijdl" .

        ns2:WolfgangNejdl ns2:affiliation "University of Hannover and L3S" ;
                          ns2:country "Germany" ;
                          a ns4:Person ;
                          ns1:label "Wolfgang Nejdl" .

        ns2:WorldWideWeb a ns4:Topic .

        ns2:XML a ns4:Topic ;
                ns1:label "XML"^^ns3:string .

        ns2:XTECH2006 ns2:URL "http://xtech06.usefulinc.com/"^^ns3:anyURI ;
                      ns2:end "2006-05-19"^^ns3:date ;
                      ns2:place "Amsterdam, Netherlands"^^ns3:string ;
                      ns2:start "2006-05-16"^^ns3:date ;
                      ns4:isAbout ns2:XML ;
                      ns4:title "XTECH 2006 \"Building Web 2.0\""^^ns3:string ;
                      ns4:year "2006" ;
                      a ns4:Conference ;
                      ns1:label "XTECH2006" ;
                      ns5:lat "52.370197"^^ns3:float ;
                      ns5:long "4.890444"^^ns3:float .

        ns2:YingDing ns2:affiliation "University of Innsbruck" ;
                     ns2:country "Austria" ;
                     a ns4:Person ;
                     ns1:label "Ying Ding" .

        ns2:YorkSure ns2:affiliation "University Karlsruhe" ;
                     ns2:country "Germany" ;
                     a ns4:Person ;
                     ns1:label "York Sure" .

        ns2:abstractsDue a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                         ns1:domain ns4:Conference ;
                         ns1:label "abstracts due" ;
                         ns1:range ns3:date .

        ns2:acceptanceNotification a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                                   ns1:domain ns4:Conference ;
                                   ns1:label "acceptance Notification" ;
                                   ns1:range ns3:date .

        ns2:affiliation a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                        ns1:domain ns4:Person ;
                        ns1:label "affiliation" ;
                        ns1:range ns3:string .

        ns2:audience a ns0:DatatypeProperty ;
                     ns1:domain ns4:Conference ;
                     ns1:label "audience" ;
                     ns1:range ns3:string .

        ns2:auer-s-2006-736-a ns17:identifier ns18:pdf ;
                              ns17:publisher ns2:ISWC2006 ;
                              ns4:creator ns2:SrenAuer, ns2:SebastianDietzold, ns2:ThomasRiechert ;
                              ns4:describesProject ns2:OntoWiki ;
                              a ns4:InProceedings ;
                              ns1:label "OntoWiki – A Tool for Social, Semantic Collaboration" .

        ns2:camera-readySubmission a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                                   ns1:domain ns4:Conference ;
                                   ns1:label "camera-ready Submission" ;
                                   ns1:range ns3:date .

        ns2:conferenceChair a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                            ns1:domain ns4:Conference ;
                            ns1:label "Chair" ;
                            ns1:range ns3:string .

        ns2:conferenceFee a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                          ns1:domain ns4:Conference ;
                          ns1:label "Fee" ;
                          ns1:range ns3:string .

        ns2:conferenceFeeLate a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                              ns1:domain ns4:Conference ;
                              ns1:label "Fee (late)" ;
                              ns1:range ns3:string .

        ns2:conferenceFeeStudent a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                                 ns1:domain ns4:Conference ;
                                 ns1:label "Fee (student)" ;
                                 ns1:range ns3:string .

        ns2:conferenceFeeStudentLate a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                                     ns1:domain ns4:Conference ;
                                     ns1:label "Fee (student, late)" ;
                                     ns1:range ns3:string .

        ns2:country a ns0:DatatypeProperty ;
                    ns1:label "Country" .

        ns2:end a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                ns1:comment ns2:end ;
                ns1:domain ns4:Conference ;
                ns1:label "end" ;
                ns1:range ns3:date .

        ns2:inConjunctionWith a ns0:ObjectProperty ;
                              ns1:comment "inConjunctionWith" ;
                              ns1:domain ns4:Conference ;
                              ns1:label "inConjunctionWith"^^ns3:string ;
                              ns1:range ns4:Event .

        ns2:interval a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                     ns1:label "Interval" ;
                     ns1:range ns3:string .

        ns2:issn a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                 ns1:label "ISSN" ;
                 ns1:range ns3:string .

        ns2:localChair a ns0:DatatypeProperty, ns0:FunctionalProperty, ns0:ObjectProperty ;
                       ns1:domain ns4:Conference ;
                       ns1:label "Chair (local)" .

        ns2:logo a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                 ns1:label "Logo" ;
                 ns1:range ns3:anyURI .

        ns2:pcMember a ns0:DatatypeProperty, ns0:ObjectProperty ;
                     ns1:domain ns4:Conference ;
                     ns1:label "PC Member" .

        ns2:place a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                  ns1:domain ns4:Conference ;
                  ns1:label "Place" ;
                  ns1:range ns3:string .

        ns2:preRegistration a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                            ns1:domain ns4:Conference ;
                            ns1:label "preRegistration" ;
                            ns1:range ns3:anyURI .

        ns2:price a ns0:DatatypeProperty .

        ns2:programChair a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                         ns1:domain ns4:Conference ;
                         ns1:label "Chair (Program)" ;
                         ns1:range ns3:string .

        ns2:programmeCommittee a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                               ns1:domain ns4:Conference ;
                               ns1:label "Programme Committee" ;
                               ns1:range ns3:string .

        ns2:publicityChair a ns0:DatatypeProperty, ns0:FunctionalProperty, ns0:ObjectProperty ;
                           ns1:domain ns4:Conference ;
                           ns1:label "Chair (Publicity)" .

        ns2:start a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                  ns1:domain ns4:Conference ;
                  ns1:label "start" ;
                  ns1:range ns3:date .

        ns2:submissionsDue a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                           ns1:domain ns4:Conference ;
                           ns1:label "Submissions due" ;
                           ns1:range ns3:date .

        ns4:Conference a ns0:Class ;
                       ns1:label "Conference" ;
                       ns1:subClassOf ns4:Event .

        ns4:Event a ns0:Class ;
                  ns1:label "Event" .

        ns4:Journal a ns0:Class ;
                    ns1:label "Journal" .

        ns4:Person a ns0:Class ;
                   ns1:label "Person" .

        ns4:Topic a ns0:Class ;
                  ns1:label "Topic" .

        ns4:Workshop a ns0:Class ;
                     ns1:label "Workshop" ;
                     ns1:subClassOf ns4:Event .

        ns4:isAbout a ns0:ObjectProperty ;
                    ns1:domain ns4:Event ;
                    ns1:label "topics" ;
                    ns1:range ns4:Topic .

        ns4:title a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                  ns1:domain ns4:Conference ;
                  ns1:label "Title" .

        ns1:comment a ns0:AnnotationProperty ;
                    ns1:label "comment" .

        ns1:label a ns0:AnnotationProperty ;
                  ns1:label "label" .

        ns3:anyURI a ns1:Datatype .

        ns3:date a ns1:Datatype .

        ns3:string a ns1:Datatype .

        ns5:lat a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                ns1:domain ns4:Event ;
                ns1:label "latitude" .

        ns5:long a ns0:DatatypeProperty, ns0:FunctionalProperty ;
                 ns1:domain ns4:Event ;
                 ns1:label "longitude" .

        ns8:currentProject a ns0:FunctionalProperty, ns0:ObjectProperty ;
                           ns1:comment "http://xmlns.com/foaf/0.1/currentProject" ;
                           ns1:label "current Project"^^ns3:string .';
        
                           $result = $this->_object->parseFromDataString($data);

        $counter = 0;
        foreach ($result as $s => $pArray) {
            foreach ($pArray as $p => $oArray) {
                foreach ($oArray as $o) {
                    $counter++;
                }
            }
        }

        $this->assertEquals(1806, $counter);
        
    }
    
    public function testParseFromDataStringIssue421TurtleParserOnUpdateResturnsError()
    {
        $data = '<http://model.de#Class1> a <http://www.w3.org/2002/07/owl#Class> ;
        <http://www.w3.org/2000/01/rdf-schema#label> "classLabel"@de,
        "classLabel"@nl, "classLabel"@en ;
        <http://model.de#sort> "1" ;
        <http://www.w3.org/2000/01/rdf-schema#subClassOf> <http://model.de#Category> .';
        
        $result = $this->_object->parseFromDataString($data);

        $this->assertEquals(1, count($result));
        $this->assertEquals(4, count($result['http://model.de#Class1']));
    }
    
    public function testParseFromDataStringIssue446CorruptLanguageTags()
    {
        $turtle = '# Exported with the Erfurt API - http://aksw.org/Projects/Erfurt

        @base <http://bis.ontowiki.net/> .
        @prefix bis: <http://bis.ontowiki.net/> .
        @prefix dc: <http://purl.org/dc/elements/1.1/> .
        @prefix ldap: <http://purl.org/net/ldap#> .
        @prefix swrc: <http://swrc.ontoware.org/ontology#> .
        @prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
        @prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
        @prefix owl: <http://www.w3.org/2002/07/owl#> .
        @prefix ns: <http://www.w3.org/2003/06/sw-vocab-status/ns#> .
        @prefix foaf: <http://xmlns.com/foaf/0.1/> .
        @prefix wot: <http://xmlns.com/wot/0.1/> .

        bis:PeterPan ldap:mobile "+49 XXX 123456" ;
                         ldap:roomNumber "5-XX" ;
                         ldap:telephoneNumber "+49 341 12-345678" ;
                         a swrc:FacultyMember ;
                         rdfs:label "Peter Pan ü 2 de"@de, "Peter Pan ü 2 nl"@nl", "Peter Pan ü nl"@nl" ;
                         foaf:firstName "Peter" ;
                         foaf:icqChatID "123-456-789" ;
                         foaf:mbox <mailto:peter.pan@informatik.uni-leipzig.de> ;
                         foaf:surname "Pan ü" .';
        
        try {
            $result = $this->_object->parseFromDataString($turtle);
            $this->fail('Parsing should fail, but did not fail.');
        } catch (Erfurt_Syntax_RdfParserException $e) {
            
        }
    }
    
    public function testParseFromDataStringIssue449LanguageIsResourceObject()
    {
        $turtle = '@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
        
                    <http://example.org/ttt/> rdfs:label "123"@de, "456"@en, "789"@nl .';

        $result = $this->_object->parseFromDataString($turtle);
        
        $lang1 = $result['http://example.org/ttt/']['http://www.w3.org/2000/01/rdf-schema#label'][0]['lang'];
        $lang2 = $result['http://example.org/ttt/']['http://www.w3.org/2000/01/rdf-schema#label'][1]['lang'];
        $lang3 = $result['http://example.org/ttt/']['http://www.w3.org/2000/01/rdf-schema#label'][2]['lang'];
        
        $this->assertFalse(is_object($lang1));
        $this->assertFalse(is_object($lang2));
        $this->assertFalse(is_object($lang3));
        $this->assertTrue(is_string($lang1));
        $this->assertTrue(is_string($lang2));
        $this->assertTrue(is_string($lang3));
    }
}
