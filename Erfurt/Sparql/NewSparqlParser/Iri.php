<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 Iri.g 2009-11-26 02:23:24


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

 
function Iri_DFA29_static(){
    $eotS =
        "\x5\xff";
    $eofS =
        "\x5\xff";
    $minS =
        "\x2\x2e\x3\xff";
    $maxS =
        "\x1\x39\x1\x65\x3\xff";
    $acceptS =
        "\x2\xff\x1\x2\x1\x3\x1\x1";
    $specialS =
        "\x5\xff}>";
    $transitionS = array(
        "\x1\x2\x1\xff\xa\x1",
        "\x1\x4\x1\xff\xa\x1\xb\xff\x1\x3\x1f\xff\x1\x3",
        "",
        "",
        ""
    );
    $arr = array();
    $arr['eot'] = DFA::unpackEncodedString($eotS);
    $arr['eof'] = DFA::unpackEncodedString($eofS);
    $arr['min'] = DFA::unpackEncodedStringToUnsignedChars($minS);
    $arr['max'] = DFA::unpackEncodedStringToUnsignedChars($maxS);
    $arr['accept'] = DFA::unpackEncodedString($acceptS);
    $arr['special'] = DFA::unpackEncodedString($specialS);


    $numStates = sizeof($transitionS);
    $arr['transition'] = array();
    for ($i=0; $i<$numStates; $i++) {
        $arr['transition'][$i] = DFA::unpackEncodedString($transitionS[$i]);
    }
    return $arr;
}
$Iri_DFA29 = Iri_DFA29_static();

class Iri_DFA29 extends DFA {

    public function __construct($recognizer) {
        global $Iri_DFA29;
        $DFA = $Iri_DFA29;
        $this->recognizer = $recognizer;
        $this->decisionNumber = 29;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "364:2: DOUBLE : ( ( DIGIT )+ DOT ( DIGIT )* EXPONENT | DOT ( DIGIT )+ EXPONENT | ( DIGIT )+ EXPONENT );";
    }
}
function Iri_DFA32_static(){
    $eotS =
        "\x1\xff\x1\x2d\x7\xff\x1\x3e\xb\xff\x1\x4d\x1\xff\x1\x4f\x1\x51".
    "\x1\x54\x10\xff\x1\x5b\x5\xff\x1\x5f\x1f\xff\x1\x7e\x1\xff\x1\x7f\x2".
    "\xff\x1\x83\x1\xff\x1\x58\x1\xff\x1\x5a\x3\xff\x1\x7e\x5\xff\x1\x8e".
    "\x7\xff\x1\x96\x1\x97\x14\xff\x2\xa9\x2\xff\x2\xab\x2\xff\x1\x7e\x1".
    "\xad\x6\xff\x1\xb4\x6\xff\x1\xb9\x8\xff\x1\xc3\x6\xff\x1\xca\x1\xff".
    "\x1\xa9\x1\xff\x1\xab\x1\xff\x1\xcb\x8\xff\x1\xd3\x3\xff\x1\xd6\x1\xd7".
    "\x1\xd8\x1\xd9\x2\xff\x1\xdc\x2\xff\x1\xde\x1\xdf\x1\xe0\x1\xe1\x4\xff".
    "\x1\xe4\x1\xe5\x7\xff\x1\xec\x4\xff\x1\xed\xf\xff\x1\xf6\x5\xff\x1\xfa".
    "\x1\xff\x1\xfc\x1\xfd\x1\xfe\x1\xff\x2\xff\x1\x1\x7\xff\x1\x4\x2\xff".
    "\x1\x6\x3\xff\x1\x8\x1\xff";
    $eofS =
        "\x9\xff";
    $minS =
        "\x1\x9\x1\x21\x1\xff\x12\x2d\x1\x30\x1\xff\x1\x30\x2\x2e\xa\xff".
    "\x2\x0\x4\xff\x1\x2e\x4\xff\xf\x2d\x1\xff\xe\x2d\x3\xff\x1\x30\x1\xff".
    "\x1\x2e\x1\x30\x1\xff\x1\x2e\x1\x30\x1\x27\x1\xff\x1\x22\x3\xff\x1\x30".
    "\x1\x2d\x1\xff\x1e\x2d\x3\xff\x2\x30\x2\xff\x2\x30\x2\xff\x1\x30\x4".
    "\x2d\x1\xff\x7\x2d\x2\xff\x11\x2d\x1\xff\x1\x30\x1\xff\x1\x30\x1\xff".
    "\x6\x2d\x1\xff\x4\x2d\x1\xff\x9\x2d\x1\xff\x6\x2d\x2\xff\x7\x2d\x1\xff".
    "\x2\x2d\x4\xff\x2\x2d\x1\xff\x1\x2d\x4\xff\x2\x2d\x2\xff\x6\x2d\x2\xff".
    "\x8\x2d\x1\xff\x3\x2d\x1\xff\x1\x2d\x4\xff\x1\x2d\x1\xff\x2\x2d\x1\xff".
    "\x1\x2d\x1\xff\x1\x2d\x1\xff";
    $maxS =
        "\x1\xfd\x1\xff\x1\xff\x13\xfd\x1\xff\x3\x39\xa\xff\x2\xff\x4\xff".
    "\x1\x65\x4\xff\xf\xfd\x1\xff\xe\xfd\x3\xff\x1\x65\x1\xff\x1\x65\x1\x39".
    "\x1\xff\x1\x65\x1\x39\x1\x27\x1\xff\x1\x22\x3\xff\x1\x65\x1\xfd\x1\xff".
    "\x1e\xfd\x3\xff\x2\x65\x2\xff\x2\x65\x2\xff\x1\x65\x4\xfd\x1\xff\x7".
    "\xfd\x2\xff\x11\xfd\x1\xff\x1\x65\x1\xff\x1\x65\x1\xff\x6\xfd\x1\xff".
    "\x4\xfd\x1\xff\x9\xfd\x1\xff\x6\xfd\x2\xff\x7\xfd\x1\xff\x2\xfd\x4\xff".
    "\x2\xfd\x1\xff\x1\xfd\x4\xff\x2\xfd\x2\xff\x6\xfd\x2\xff\x8\xfd\x1\xff".
    "\x3\xfd\x1\xff\x1\xfd\x4\xff\x1\xfd\x1\xff\x2\xfd\x1\xff\x1\xfd\x1\xff".
    "\x1\xfd\x1\xff";
    $acceptS =
        "\x2\xff\x1\x2\x13\xff\x1\x28\x3\xff\x1\x2c\x1\x2d\x1\x2e\x1\x2f".
    "\x1\x30\x1\x32\x1\x33\x1\x34\x1\x35\x1\x36\x2\xff\x1\x3b\x1\x3c\x1\x3d".
    "\x1\x3e\x1\xff\x1\x48\x1\x49\x1\x31\x1\x1\xf\xff\x1\x18\xe\xff\x1\x27".
    "\x1\x26\x1\x29\x1\xff\x1\x2a\x2\xff\x1\x2b\x3\xff\x1\x37\x1\xff\x1\x38".
    "\x1\x3f\x1\x41\x2\xff\x1\xf\x1e\xff\x1\x40\x1\x42\x1\x44\x2\xff\x1\x45".
    "\x1\x47\x2\xff\x1\x39\x1\x3a\x5\xff\x1\x19\x7\xff\x1\xa\x1\x10\x11\xff".
    "\x1\x43\x1\xff\x1\x46\x1\xff\x1\x3\x6\xff\x1\x11\x4\xff\x1\xb\x9\xff".
    "\x1\x1a\x6\xff\x1\x24\x1\x1d\x7\xff\x1\x23\x2\xff\x1\x25\x1\xc\x1\xd".
    "\x1\xe\x2\xff\x1\x12\x1\xff\x1\x15\x1\x16\x1\x1f\x1\x20\x2\xff\x1\x4".
    "\x1\x5\x6\xff\x1\x17\x1\x13\x8\xff\x1\x7\x3\xff\x1\x21\x1\xff\x1\x1e".
    "\x1\x6\x1\x9\x1\x1c\x1\xff\x1\x14\x2\xff\x1\x8\x1\xff\x1\x22\x1\xff".
    "\x1\x1b";
    $specialS =
        "\x24\xff\x1\x0\x1\x1\xe3\xff}>";
    $transitionS = array(
        "\x2\x2\x2\xff\x1\x2\x12\xff\x1\x2\x1\x1c\x1\x25\x1\xff\x1\x23\x2".
        "\xff\x1\x24\x1\x26\x1\x27\x1\x1a\x1\x18\x1\x1b\x1\x19\x1\x17\x1".
        "\x1d\xa\x2a\x1\x15\x1\x16\x1\x1\x1\x1e\x1\x1f\x1\x22\x1\x29\x1\x11".
        "\x1\x3\x1\x8\x1\x6\x1\x14\x1\xa\x1\xf\x1\x14\x1\x12\x2\x14\x1\xe".
        "\x1\x14\x1\xb\x1\xd\x1\x4\x1\x14\x1\x7\x1\x5\x1\x13\x1\x10\x1\x14".
        "\x1\xc\x3\x14\x1\x2b\x1\xff\x1\x2c\x1\xff\x1\x28\x1\xff\x1\x9\x1".
        "\x3\x1\x8\x1\x6\x1\x14\x1\xa\x1\xf\x1\x14\x1\x12\x2\x14\x1\xe\x1".
        "\x14\x1\xb\x1\xd\x1\x4\x1\x14\x1\x7\x1\x5\x1\x13\x1\x10\x1\x14\x1".
        "\xc\x3\x14\x1\x20\x1\xff\x1\x21\x42\xff\x17\x14\x1\xff\x1f\x14\x1".
        "\xff\x8\x14\x70\xff\xe\x14\x1\xff\x81\x14\xc\xff\x2\x14\x62\xff".
        "\x20\x14\x70\xff\xf0\x14\x11\xff\xff\x14\x0\xff\xd0\x14\x20\xff".
        "\xe\x14",
        "\x1\x2e\x1\xff\x19\x2e\x1\xff\x1f\x2e\x1\xff\x1\x2e\x1\xff\x1\x2e".
        "\x1\xff\x1a\x2e\x3\xff\x82\x2e",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x2f\xd\x32\x1\x31".
        "\x9\x32\x1\x30\x1\x32\x4\xff\x1\x32\x1\xff\x1\x2f\xd\x32\x1\x31".
        "\x9\x32\x1\x30\x1\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32".
        "\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f".
        "\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20".
        "\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\x34\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\x34\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x37\x3\x32\x1\x35".
        "\xe\x32\x1\x36\x6\x32\x4\xff\x1\x32\x1\xff\x1\x37\x3\x32\x1\x35".
        "\xe\x32\x1\x36\x6\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32".
        "\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f".
        "\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20".
        "\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x3a\x3\x32\x1\x39".
        "\x3\x32\x1\x38\x11\x32\x4\xff\x1\x32\x1\xff\x1\x3a\x3\x32\x1\x39".
        "\x3\x32\x1\x38\x11\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f".
        "\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32".
        "\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32".
        "\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x3b\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x3b\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xe\x32\x1\x3c\xb\x32".
        "\x4\xff\x1\x32\x1\xff\xe\x32\x1\x3c\xb\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x3d\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x3d\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x41\x7\x32\x1\x40".
        "\x8\x32\x1\x3f\x8\x32\x4\xff\x1\x32\x1\xff\x1\x41\x7\x32\x1\x40".
        "\x8\x32\x1\x3f\x8\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32".
        "\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f".
        "\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20".
        "\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x42\x19\x32\x4\xff".
        "\x1\x32\x1\xff\x1\x42\x19\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff".
        "\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2".
        "\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0".
        "\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x7\x32\x1\x43\x12\x32".
        "\x4\xff\x1\x32\x1\xff\x7\x32\x1\x43\x12\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x5\x32\x1\x45\x9\x32".
        "\x1\x46\x1\x32\x1\x44\x8\x32\x4\xff\x1\x32\x1\xff\x5\x32\x1\x45".
        "\x9\x32\x1\x46\x1\x32\x1\x44\x8\x32\x3c\xff\x1\x32\x8\xff\x17\x32".
        "\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31".
        "\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff".
        "\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x48\x7\x32\x1\x47".
        "\x11\x32\x4\xff\x1\x32\x1\xff\x1\x48\x7\x32\x1\x47\x11\x32\x3c\xff".
        "\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81".
        "\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32".
        "\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\x49\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\x49\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xd\x32\x1\x4a\xc\x32".
        "\x4\xff\x1\x32\x1\xff\xd\x32\x1\x4a\xc\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x3d\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x3d\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x4b\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x4b\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\x4c\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\x4c\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\xa\x4e\x7\xff\x1a\x4e\x4\xff\x1\x4e\x1\xff\x1a\x4e\x45\xff\x17".
        "\x4e\x1\xff\x1f\x4e\x1\xff\x8\x4e\x70\xff\xe\x4e\x1\xff\x81\x4e".
        "\xc\xff\x2\x4e\x62\xff\x20\x4e\x70\xff\xf0\x4e\x11\xff\xff\x4e\x0".
        "\xff\xd0\x4e\x20\xff\xe\x4e",
        "",
        "\xa\x50",
        "\x1\x53\x1\xff\xa\x52",
        "\x1\x56\x1\xff\xa\x55",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "\xa\x58\x1\xff\x2\x58\x1\xff\x19\x58\x1\x57\xd8\x58",
        "\xa\x5a\x1\xff\x2\x5a\x1\xff\x14\x5a\x1\x59\xdd\x5a",
        "",
        "",
        "",
        "",
        "\x1\x5d\x1\xff\xa\x2a\xb\xff\x1\x5c\x1f\xff\x1\x5c",
        "",
        "",
        "",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x5e\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x5e\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x14\x32\x1\x60\x5\x32".
        "\x4\xff\x1\x32\x1\xff\x14\x32\x1\x60\x5\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x7\xff\x1a\x32\x4\xff\x1\x32\x1\xff".
        "\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1\xff\x86".
        "\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff\x20\x32".
        "\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x61\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x61\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xb\x32\x1\x62\xe\x32".
        "\x4\xff\x1\x32\x1\xff\xb\x32\x1\x62\xe\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\x63\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\x63\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xc\x32\x1\x64\xd\x32".
        "\x4\xff\x1\x32\x1\xff\xc\x32\x1\x64\xd\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x65\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x65\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x66\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x66\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\x67\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\x67\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x3\x32\x1\x68\x2\x32".
        "\x1\x69\x13\x32\x4\xff\x1\x32\x1\xff\x3\x32\x1\x68\x2\x32\x1\x69".
        "\x13\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1\xff\x86".
        "\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff\x20\x32".
        "\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xd\x32\x1\x6a\xc\x32".
        "\x4\xff\x1\x32\x1\xff\xd\x32\x1\x6a\xc\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x2\x32\x1\x6c\x7\x32".
        "\x1\x6b\xf\x32\x4\xff\x1\x32\x1\xff\x2\x32\x1\x6c\x7\x32\x1\x6b".
        "\xf\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1\xff\x86".
        "\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff\x20\x32".
        "\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xe\x32\x1\x6d\xb\x32".
        "\x4\xff\x1\x32\x1\xff\xe\x32\x1\x6d\xb\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xb\x32\x1\x6e\xe\x32".
        "\x4\xff\x1\x32\x1\xff\xb\x32\x1\x6e\xe\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xb\x32\x1\x6f\xe\x32".
        "\x4\xff\x1\x32\x1\xff\xb\x32\x1\x6f\xe\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xc\x32\x1\x70\xd\x32".
        "\x4\xff\x1\x32\x1\xff\xc\x32\x1\x70\xd\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x71\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x71\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x3\x32\x1\x72\x16\x32".
        "\x4\xff\x1\x32\x1\xff\x3\x32\x1\x72\x16\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x5\x32\x1\x73\x14\x32".
        "\x4\xff\x1\x32\x1\xff\x5\x32\x1\x73\x14\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\x74\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\x74\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xc\x32\x1\x75\xd\x32".
        "\x4\xff\x1\x32\x1\xff\xc\x32\x1\x75\xd\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xd\x32\x1\x76\xc\x32".
        "\x4\xff\x1\x32\x1\xff\xd\x32\x1\x76\xc\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x77\x19\x32\x4\xff".
        "\x1\x32\x1\xff\x1\x77\x19\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff".
        "\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2".
        "\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0".
        "\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x8\x32\x1\x78\x11\x32".
        "\x4\xff\x1\x32\x1\xff\x8\x32\x1\x78\x11\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x32\x1\x7b\x6\x32".
        "\x1\x79\x2\x32\x1\x7c\x8\x32\x1\x7a\x5\x32\x4\xff\x1\x32\x1\xff".
        "\x1\x32\x1\x7b\x6\x32\x1\x79\x2\x32\x1\x7c\x8\x32\x1\x7a\x5\x32".
        "\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1".
        "\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff".
        "\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x14\x32\x1\x7d\x5\x32".
        "\x4\xff\x1\x32\x1\xff\x14\x32\x1\x7d\x5\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "",
        "",
        "\xa\x50\xb\xff\x1\x5c\x1f\xff\x1\x5c",
        "",
        "\x1\x81\x1\xff\xa\x52\xb\xff\x1\x80\x1f\xff\x1\x80",
        "\xa\x82",
        "",
        "\x1\x85\x1\xff\xa\x55\xb\xff\x1\x84\x1f\xff\x1\x84",
        "\xa\x86",
        "\x1\x87",
        "",
        "\x1\x88",
        "",
        "",
        "",
        "\xa\x89\xb\xff\x1\x5c\x1f\xff\x1\x5c",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x8a\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x8a\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xd\x32\x1\x8b\xc\x32".
        "\x4\xff\x1\x32\x1\xff\xd\x32\x1\x8b\xc\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x5\x32\x1\x8c\x14\x32".
        "\x4\xff\x1\x32\x1\xff\x5\x32\x1\x8c\x14\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x8d\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x8d\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x8f\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x8f\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\x90\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\x90\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x2\x32\x1\x91\x17\x32".
        "\x4\xff\x1\x32\x1\xff\x2\x32\x1\x91\x17\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x92\x19\x32\x4\xff".
        "\x1\x32\x1\xff\x1\x92\x19\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff".
        "\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2".
        "\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0".
        "\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x14\x32\x1\x93\x5\x32".
        "\x4\xff\x1\x32\x1\xff\x14\x32\x1\x93\x5\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x94\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x94\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x95\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x95\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xc\x32\x1\x98\xd\x32".
        "\x4\xff\x1\x32\x1\xff\xc\x32\x1\x98\xd\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\x99\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\x99\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x9a\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x9a\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x9b\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x9b\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\x9c\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\x9c\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x9d\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x9d\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x9e\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x9e\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x8\x32\x1\x9f\x11\x32".
        "\x4\xff\x1\x32\x1\xff\x8\x32\x1\x9f\x11\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x8\x32\x1\xa0\x11\x32".
        "\x4\xff\x1\x32\x1\xff\x8\x32\x1\xa0\x11\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x6\x32\x1\xa1\x13\x32".
        "\x4\xff\x1\x32\x1\xff\x6\x32\x1\xa1\x13\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xf\x32\x1\xa2\xa\x32".
        "\x4\xff\x1\x32\x1\xff\xf\x32\x1\xa2\xa\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xe\x32\x1\xa3\xb\x32".
        "\x4\xff\x1\x32\x1\xff\xe\x32\x1\xa3\xb\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\xa4\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\xa4\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\xa5\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\xa5\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xb\x32\x1\xa6\xe\x32".
        "\x4\xff\x1\x32\x1\xff\xb\x32\x1\xa6\xe\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x8\x32\x1\xa7\x11\x32".
        "\x4\xff\x1\x32\x1\xff\x8\x32\x1\xa7\x11\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xa8\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xa8\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "",
        "",
        "\xa\xaa\xb\xff\x1\x80\x1f\xff\x1\x80",
        "\xa\x82\xb\xff\x1\x80\x1f\xff\x1\x80",
        "",
        "",
        "\xa\xac\xb\xff\x1\x84\x1f\xff\x1\x84",
        "\xa\x86\xb\xff\x1\x84\x1f\xff\x1\x84",
        "",
        "",
        "\xa\x89\xb\xff\x1\x5c\x1f\xff\x1\x5c",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x3\x32\x1\xae\x16\x32".
        "\x4\xff\x1\x32\x1\xff\x3\x32\x1\xae\x16\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x8\x32\x1\xaf\x11\x32".
        "\x4\xff\x1\x32\x1\xff\x8\x32\x1\xaf\x11\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x2\x32\x1\xb0\x17\x32".
        "\x4\xff\x1\x32\x1\xff\x2\x32\x1\xb0\x17\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\xb1\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\xb1\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x8\x32\x1\xb2\x11\x32".
        "\x4\xff\x1\x32\x1\xff\x8\x32\x1\xb2\x11\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\xb3\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\xb3\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\xb5\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\xb5\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x2\x32\x1\xb6\x17\x32".
        "\x4\xff\x1\x32\x1\xff\x2\x32\x1\xb6\x17\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x17\x32\x1\xb7\x2\x32".
        "\x4\xff\x1\x32\x1\xff\x17\x32\x1\xb7\x2\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\xb8\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\xb8\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xba\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xba\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xbb\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xbb\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x3\x32\x1\xbc\x16\x32".
        "\x4\xff\x1\x32\x1\xff\x3\x32\x1\xbc\x16\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xbd\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xbd\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\xbe\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\xbe\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xbf\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xbf\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xe\x32\x1\xc0\xb\x32".
        "\x4\xff\x1\x32\x1\xff\xe\x32\x1\xc0\xb\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\xc1\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\xc1\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xc\x32\x1\xc2\xd\x32".
        "\x4\xff\x1\x32\x1\xff\xc\x32\x1\xc2\xd\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x7\x32\x1\xc4\x12\x32".
        "\x4\xff\x1\x32\x1\xff\x7\x32\x1\xc4\x12\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xd\x32\x1\xc5\xc\x32".
        "\x4\xff\x1\x32\x1\xff\xd\x32\x1\xc5\xc\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x8\x32\x1\xc6\x11\x32".
        "\x4\xff\x1\x32\x1\xff\x8\x32\x1\xc6\x11\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x8\x32\x1\xc7\x11\x32".
        "\x4\xff\x1\x32\x1\xff\x8\x32\x1\xc7\x11\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\xc8\x19\x32\x4\xff".
        "\x1\x32\x1\xff\x1\xc8\x19\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff".
        "\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2".
        "\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0".
        "\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\xc9\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\xc9\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "",
        "\xa\xaa\xb\xff\x1\x80\x1f\xff\x1\x80",
        "",
        "\xa\xac\xb\xff\x1\x84\x1f\xff\x1\x84",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x17\x32\x1\xcc\x2\x32".
        "\x4\xff\x1\x32\x1\xff\x17\x32\x1\xcc\x2\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\xcd\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\xcd\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xce\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xce\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xd\x32\x1\xcf\xc\x32".
        "\x4\xff\x1\x32\x1\xff\xd\x32\x1\xcf\xc\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x8\x32\x1\xd0\x11\x32".
        "\x4\xff\x1\x32\x1\xff\x8\x32\x1\xd0\x11\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x18\x32\x1\xd1\x1\x32".
        "\x4\xff\x1\x32\x1\xff\x18\x32\x1\xd1\x1\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xd2\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xd2\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\xd4\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\xd4\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\xd5\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\xd5\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\xda\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\xda\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xd\x32\x1\xdb\xc\x32".
        "\x4\xff\x1\x32\x1\xff\xd\x32\x1\xdb\xc\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\xdd\x19\x32\x4\xff".
        "\x1\x32\x1\xff\x1\xdd\x19\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff".
        "\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2".
        "\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0".
        "\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xd\x32\x1\xe2\xc\x32".
        "\x4\xff\x1\x32\x1\xff\xd\x32\x1\xe2\xc\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xe3\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xe3\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\xe6\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\xe6\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x2\x32\x1\xe7\x17\x32".
        "\x4\xff\x1\x32\x1\xff\x2\x32\x1\xe7\x17\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\x32\x1\xe8\x18\x32".
        "\x4\xff\x1\x32\x1\xff\x1\x32\x1\xe8\x18\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xf\x32\x1\xe9\xa\x32".
        "\x4\xff\x1\x32\x1\xff\xf\x32\x1\xe9\xa\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x3\x32\x1\xea\x16\x32".
        "\x4\xff\x1\x32\x1\xff\x3\x32\x1\xea\x16\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x14\x32\x1\xeb\x5\x32".
        "\x4\xff\x1\x32\x1\xff\x14\x32\x1\xeb\x5\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "",
        "",
        "",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\xee\x19\x32\x4\xff".
        "\x1\x32\x1\xff\x1\xee\x19\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff".
        "\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2".
        "\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0".
        "\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\xef\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\xef\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "",
        "",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xa\x32\x1\xf0\xf\x32".
        "\x4\xff\x1\x32\x1\xff\xa\x32\x1\xf0\xf\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x11\x32\x1\xf1\x8\x32".
        "\x4\xff\x1\x32\x1\xff\x11\x32\x1\xf1\x8\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xc\x32\x1\xf2\xd\x32".
        "\x4\xff\x1\x32\x1\xff\xc\x32\x1\xf2\xd\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\xf3\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\xf3\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xf4\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xf4\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\xf5\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\xf5\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x2\x32\x1\xf7\x17\x32".
        "\x4\xff\x1\x32\x1\xff\x2\x32\x1\xf7\x17\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xb\x32\x1\xf8\xe\x32".
        "\x4\xff\x1\x32\x1\xff\xb\x32\x1\xf8\xe\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x2\x32\x1\xf9\x17\x32".
        "\x4\xff\x1\x32\x1\xff\x2\x32\x1\xf9\x17\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1\xfb\x19\x32\x4\xff".
        "\x1\x32\x1\xff\x1\xfb\x19\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff".
        "\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2".
        "\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0".
        "\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x13\x32\x1\x0\x6\x32".
        "\x4\xff\x1\x32\x1\xff\x13\x32\x1\x0\x6\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x7\x32\x1\x2\x12\x32".
        "\x4\xff\x1\x32\x1\xff\x7\x32\x1\x2\x12\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\xb\x32\x1\x3\xe\x32".
        "\x4\xff\x1\x32\x1\xff\xb\x32\x1\x3\xe\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "",
        "",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x4\x32\x1\x5\x15\x32".
        "\x4\xff\x1\x32\x1\xff\x4\x32\x1\x5\x15\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x12\x32\x1\x7\x7\x32".
        "\x4\xff\x1\x32\x1\xff\x12\x32\x1\x7\x7\x32\x3c\xff\x1\x32\x8\xff".
        "\x17\x32\x1\xff\x1f\x32\x1\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2".
        "\x32\x31\xff\x2\x32\x2f\xff\x20\x32\x70\xff\xf0\x32\x11\xff\xff".
        "\x32\x0\xff\xd0\x32\x20\xff\xe\x32",
        "",
        "\x1\x32\x1\x33\x1\xff\xa\x32\x1\x15\x6\xff\x1a\x32\x4\xff\x1\x32".
        "\x1\xff\x1a\x32\x3c\xff\x1\x32\x8\xff\x17\x32\x1\xff\x1f\x32\x1".
        "\xff\x86\x32\x1\xff\x81\x32\xc\xff\x2\x32\x31\xff\x2\x32\x2f\xff".
        "\x20\x32\x70\xff\xf0\x32\x11\xff\xff\x32\x0\xff\xd0\x32\x20\xff".
        "\xe\x32",
        ""
    );
    $arr = array();
    $arr['eot'] = DFA::unpackEncodedString($eotS);
    $arr['eof'] = DFA::unpackEncodedString($eofS);
    $arr['min'] = DFA::unpackEncodedStringToUnsignedChars($minS);
    $arr['max'] = DFA::unpackEncodedStringToUnsignedChars($maxS);
    $arr['accept'] = DFA::unpackEncodedString($acceptS);
    $arr['special'] = DFA::unpackEncodedString($specialS);


    $numStates = sizeof($transitionS);
    $arr['transition'] = array();
    for ($i=0; $i<$numStates; $i++) {
        $arr['transition'][$i] = DFA::unpackEncodedString($transitionS[$i]);
    }
    return $arr;
}
$Iri_DFA32 = Iri_DFA32_static();

class Iri_DFA32 extends DFA {

    public function __construct($recognizer) {
        global $Iri_DFA32;
        $DFA = $Iri_DFA32;
        $this->recognizer = $recognizer;
        $this->decisionNumber = 32;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "1:1: Tokens : ( IRI_REF | WS | BASE | PREFIX | SELECT | DISTINCT | REDUCED | CONSTRUCT | DESCRIBE | ASK | FROM | NAMED | WHERE | ORDER | BY | ASC | DESC | LIMIT | OFFSET | OPTIONAL | GRAPH | UNION | FILTER | A | STR | LANG | LANGMATCHES | DATATYPE | BOUND | SAMETERM | ISIRI | ISURI | ISBLANK | ISLITERAL | REGEX | TRUE | FALSE | PNAME_LN | PNAME_NS | SEMICOLON | DOT | PLUS | MINUS | ASTERISK | COMMA | NOT | DIVIDE | EQUAL | LESS | GREATER | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | VAR1 | VAR2 | STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 | OPEN_BRACE | CLOSE_BRACE | BLANK_NODE_LABEL | LANGTAG | INTEGER | DECIMAL | DOUBLE | INTEGER_POSITIVE | DECIMAL_POSITIVE | DOUBLE_POSITIVE | INTEGER_NEGATIVE | DECIMAL_NEGATIVE | DOUBLE_NEGATIVE | OPEN_SQUARE_BRACE | CLOSE_SQUARE_BRACE );";
    }
    public function specialStateTransition($s, IntStream $_input) {
        $input = $_input;
    	$_s = $s;
        switch ( $s ) {
                case 0 : 
                    $LA32_36 = $input->LA(1);

                    $s = -1;
                    if ( ($LA32_36==$this->getToken('39')) ) {$s = 87;}

                    else if ( (($LA32_36>=$this->getToken('0') && $LA32_36<=$this->getToken('9'))||($LA32_36>=$this->getToken('11') && $LA32_36<=$this->getToken('12'))||($LA32_36>=$this->getToken('14') && $LA32_36<=$this->getToken('38'))||($LA32_36>=$this->getToken('40') && $LA32_36<=$this->getToken('65535'))) ) {$s = 88;}

                    if ( $s>=0 ) return $s;
                    break;
                case 1 : 
                    $LA32_37 = $input->LA(1);

                    $s = -1;
                    if ( ($LA32_37==$this->getToken('34')) ) {$s = 89;}

                    else if ( (($LA32_37>=$this->getToken('0') && $LA32_37<=$this->getToken('9'))||($LA32_37>=$this->getToken('11') && $LA32_37<=$this->getToken('12'))||($LA32_37>=$this->getToken('14') && $LA32_37<=$this->getToken('33'))||($LA32_37>=$this->getToken('35') && $LA32_37<=$this->getToken('65535'))) ) {$s = 90;}

                    if ( $s>=0 ) return $s;
                    break;
        }
        $nvae =
            new NoViableAltException($this->getDescription(), 32, $_s, $input);
        $this->error($nvae);
        throw $nvae;        
    }
}
      

class Iri extends AntlrLexer {
    static $PREFIX=12;
    static $EXPONENT=83;
    static $CLOSE_SQUARE_BRACE=92;
    static $GRAPH=29;
    static $REGEX=43;
    static $PNAME_LN=48;
    static $CONSTRUCT=16;
    static $NOT=61;
    static $EOF=-1;
    static $VARNAME=55;
    static $ISLITERAL=42;
    static $GREATER=5;
    static $EOL=9;
    static $NOT_EQUAL=76;
    static $LESS=4;
    static $LANGMATCHES=35;
    static $DOUBLE=84;
    static $BASE=11;
    static $PN_CHARS_U=53;
    static $OPEN_CURLY_BRACE=6;
    static $SELECT=13;
    static $CLOSE_CURLY_BRACE=7;
    static $DOUBLE_POSITIVE=87;
    static $BOUND=37;
    static $DIVIDE=62;
    static $ISIRI=39;
    static $A=32;
    static $ASC=24;
    static $ASK=18;
    static $BLANK_NODE_LABEL=79;
    static $SEMICOLON=57;
    static $ISBLANK=41;
    static $WS=10;
    static $NAMED=20;
    static $INTEGER_POSITIVE=85;
    static $STRING_LITERAL2=68;
    static $OR=78;
    static $FILTER=31;
    static $DESCRIBE=17;
    static $STRING_LITERAL1=67;
    static $PN_CHARS=51;
    static $DATATYPE=36;
    static $LESS_EQUAL=74;
    static $DOUBLE_NEGATIVE=90;
    static $FROM=19;
    static $FALSE=45;
    static $DISTINCT=14;
    static $LANG=34;
    static $WHERE=21;
    static $IRI_REF=8;
    static $ORDER=22;
    static $LIMIT=26;
    static $AND=77;
    static $ASTERISK=59;
    static $ISURI=40;
    static $STR=33;
    static $SAMETERM=38;
    static $COMMA=60;
    static $OFFSET=27;
    static $EQUAL=63;
    static $DECIMAL_POSITIVE=86;
    static $PLUS=58;
    static $DIGIT=54;
    static $DOT=52;
    static $INTEGER=81;
    static $BY=23;
    static $REDUCED=15;
    static $INTEGER_NEGATIVE=88;
    static $PN_LOCAL=47;
    static $PNAME_NS=46;
    static $REFERENCE=73;
    static $CLOSE_BRACE=72;
    static $MINUS=56;
    static $TRUE=44;
    static $UNION=30;
    static $OPEN_SQUARE_BRACE=91;
    static $ECHAR=66;
    static $OPTIONAL=28;
    static $PN_CHARS_BASE=50;
    static $STRING_LITERAL_LONG2=70;
    static $DECIMAL=82;
    static $VAR1=64;
    static $VAR2=65;
    static $STRING_LITERAL_LONG1=69;
    static $DECIMAL_NEGATIVE=89;
    static $PN_PREFIX=49;
    static $DESC=25;
    static $OPEN_BRACE=71;
    static $GREATER_EQUAL=75;
    static $LANGTAG=80;

    // delegates
    // delegators

    function __construct($input, $state=null){
        parent::__construct($input,$state);

        
            $this->dfa29 = new Iri_DFA29($this);
            $this->dfa32 = new Iri_DFA32($this);
    }
    function getGrammarFileName() { return "Iri.g"; }

    // $ANTLR start "IRI_REF"
    function mIRI_REF(){
        try {
            $_type = Iri::$IRI_REF;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:13:5: ( LESS ( options {greedy=false; } : ~ ( LESS | GREATER | '\"' | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | '|' | '^' | '\\\\' | '`' | ( '\\u0000' .. '\\u0020' ) ) )* GREATER ) 
            // Iri.g:13:7: LESS ( options {greedy=false; } : ~ ( LESS | GREATER | '\"' | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | '|' | '^' | '\\\\' | '`' | ( '\\u0000' .. '\\u0020' ) ) )* GREATER 
            {
            $this->mLESS(); 
            // Iri.g:13:12: ( options {greedy=false; } : ~ ( LESS | GREATER | '\"' | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | '|' | '^' | '\\\\' | '`' | ( '\\u0000' .. '\\u0020' ) ) )* 
            //loop1:
            do {
                $alt1=2;
                $LA1_0 = $this->input->LA(1);

                if ( ($LA1_0==$this->getToken('33')||($LA1_0>=$this->getToken('35') && $LA1_0<=$this->getToken('59'))||$LA1_0==$this->getToken('61')||($LA1_0>=$this->getToken('63') && $LA1_0<=$this->getToken('91'))||$LA1_0==$this->getToken('93')||$LA1_0==$this->getToken('95')||($LA1_0>=$this->getToken('97') && $LA1_0<=$this->getToken('122'))||($LA1_0>=$this->getToken('126') && $LA1_0<=$this->getToken('65535'))) ) {
                    $alt1=1;
                }
                else if ( ($LA1_0==$this->getToken('62')) ) {
                    $alt1=2;
                }


                switch ($alt1) {
            	case 1 :
            	    // Iri.g:13:40: ~ ( LESS | GREATER | '\"' | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | '|' | '^' | '\\\\' | '`' | ( '\\u0000' .. '\\u0020' ) ) 
            	    {
            	    if ( $this->input->LA(1)==$this->getToken('33')||($this->input->LA(1)>=$this->getToken('35') && $this->input->LA(1)<=$this->getToken('59'))||$this->input->LA(1)==$this->getToken('61')||($this->input->LA(1)>=$this->getToken('63') && $this->input->LA(1)<=$this->getToken('91'))||$this->input->LA(1)==$this->getToken('93')||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||($this->input->LA(1)>=$this->getToken('126') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;

            	default :
            	    break 2;//loop1;
                }
            } while (true);

            $this->mGREATER(); 
              $this->setText(substr($this->getText(), 1, strlen($this->getText()) - 2)); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "IRI_REF"

    // $ANTLR start "WS"
    function mWS(){
        try {
            $_type = Iri::$WS;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:19:5: ( ( ' ' | '\\t' | EOL )+ ) 
            // Iri.g:19:7: ( ' ' | '\\t' | EOL )+ 
            {
            // Iri.g:19:7: ( ' ' | '\\t' | EOL )+ 
            $cnt2=0;
            //loop2:
            do {
                $alt2=2;
                $LA2_0 = $this->input->LA(1);

                if ( (($LA2_0>=$this->getToken('9') && $LA2_0<=$this->getToken('10'))||$LA2_0==$this->getToken('13')||$LA2_0==$this->getToken('32')) ) {
                    $alt2=1;
                }


                switch ($alt2) {
            	case 1 :
            	    // Iri.g: 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('9') && $this->input->LA(1)<=$this->getToken('10'))||$this->input->LA(1)==$this->getToken('13')||$this->input->LA(1)==$this->getToken('32') ) {
            	        $this->input->consume();

            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;

            	default :
            	    if ( $cnt2 >= 1 ) break 2;//loop2;
                        $eee =
                            new EarlyExitException(2, $this->input);
                        throw $eee;
                }
                $cnt2++;
            } while (true);

               $_channel=HIDDEN; 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "WS"

    // $ANTLR start "EOL"
    function mEOL(){
        try {
            // Iri.g:25:5: ( '\\n' | '\\r' ) 
            // Iri.g: 
            {
            if ( $this->input->LA(1)==$this->getToken('10')||$this->input->LA(1)==$this->getToken('13') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "EOL"

    // $ANTLR start "BASE"
    function mBASE(){
        try {
            $_type = Iri::$BASE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:31:5: ( ( 'B' | 'b' ) ( 'A' | 'a' ) ( 'S' | 's' ) ( 'E' | 'e' ) ) 
            // Iri.g:31:7: ( 'B' | 'b' ) ( 'A' | 'a' ) ( 'S' | 's' ) ( 'E' | 'e' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('66')||$this->input->LA(1)==$this->getToken('98') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "BASE"

    // $ANTLR start "PREFIX"
    function mPREFIX(){
        try {
            $_type = Iri::$PREFIX;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:35:5: ( ( 'P' | 'p' ) ( 'R' | 'r' ) ( 'E' | 'e' ) ( 'F' | 'f' ) ( 'I' | 'i' ) ( 'X' | 'x' ) ) 
            // Iri.g:35:7: ( 'P' | 'p' ) ( 'R' | 'r' ) ( 'E' | 'e' ) ( 'F' | 'f' ) ( 'I' | 'i' ) ( 'X' | 'x' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('80')||$this->input->LA(1)==$this->getToken('112') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('70')||$this->input->LA(1)==$this->getToken('102') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('88')||$this->input->LA(1)==$this->getToken('120') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PREFIX"

    // $ANTLR start "SELECT"
    function mSELECT(){
        try {
            $_type = Iri::$SELECT;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:39:5: ( ( 'S' | 's' ) ( 'E' | 'e' ) ( 'L' | 'l' ) ( 'E' | 'e' ) ( 'C' | 'c' ) ( 'T' | 't' ) ) 
            // Iri.g:39:7: ( 'S' | 's' ) ( 'E' | 'e' ) ( 'L' | 'l' ) ( 'E' | 'e' ) ( 'C' | 'c' ) ( 'T' | 't' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('67')||$this->input->LA(1)==$this->getToken('99') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "SELECT"

    // $ANTLR start "DISTINCT"
    function mDISTINCT(){
        try {
            $_type = Iri::$DISTINCT;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:43:5: ( ( 'D' | 'd' ) ( 'I' | 'i' ) ( 'S' | 's' ) ( 'T' | 't' ) ( 'I' | 'i' ) ( 'N' | 'n' ) ( 'C' | 'c' ) ( 'T' | 't' ) ) 
            // Iri.g:43:7: ( 'D' | 'd' ) ( 'I' | 'i' ) ( 'S' | 's' ) ( 'T' | 't' ) ( 'I' | 'i' ) ( 'N' | 'n' ) ( 'C' | 'c' ) ( 'T' | 't' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('68')||$this->input->LA(1)==$this->getToken('100') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('67')||$this->input->LA(1)==$this->getToken('99') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DISTINCT"

    // $ANTLR start "REDUCED"
    function mREDUCED(){
        try {
            $_type = Iri::$REDUCED;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:47:5: ( ( 'R' | 'r' ) ( 'E' | 'e' ) ( 'D' | 'd' ) ( 'U' | 'u' ) ( 'C' | 'c' ) ( 'E' | 'e' ) ( 'D' | 'd' ) ) 
            // Iri.g:47:7: ( 'R' | 'r' ) ( 'E' | 'e' ) ( 'D' | 'd' ) ( 'U' | 'u' ) ( 'C' | 'c' ) ( 'E' | 'e' ) ( 'D' | 'd' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('68')||$this->input->LA(1)==$this->getToken('100') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('85')||$this->input->LA(1)==$this->getToken('117') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('67')||$this->input->LA(1)==$this->getToken('99') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('68')||$this->input->LA(1)==$this->getToken('100') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "REDUCED"

    // $ANTLR start "CONSTRUCT"
    function mCONSTRUCT(){
        try {
            $_type = Iri::$CONSTRUCT;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:51:5: ( ( 'C' | 'c' ) ( 'O' | 'o' ) ( 'N' | 'n' ) ( 'S' | 's' ) ( 'T' | 't' ) ( 'R' | 'r' ) ( 'U' | 'u' ) ( 'C' | 'c' ) ( 'T' | 't' ) ) 
            // Iri.g:51:7: ( 'C' | 'c' ) ( 'O' | 'o' ) ( 'N' | 'n' ) ( 'S' | 's' ) ( 'T' | 't' ) ( 'R' | 'r' ) ( 'U' | 'u' ) ( 'C' | 'c' ) ( 'T' | 't' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('67')||$this->input->LA(1)==$this->getToken('99') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('79')||$this->input->LA(1)==$this->getToken('111') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('85')||$this->input->LA(1)==$this->getToken('117') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('67')||$this->input->LA(1)==$this->getToken('99') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "CONSTRUCT"

    // $ANTLR start "DESCRIBE"
    function mDESCRIBE(){
        try {
            $_type = Iri::$DESCRIBE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:55:5: ( ( 'D' | 'd' ) ( 'E' | 'e' ) ( 'S' | 's' ) ( 'C' | 'c' ) ( 'R' | 'r' ) ( 'I' | 'i' ) ( 'B' | 'b' ) ( 'E' | 'e' ) ) 
            // Iri.g:55:7: ( 'D' | 'd' ) ( 'E' | 'e' ) ( 'S' | 's' ) ( 'C' | 'c' ) ( 'R' | 'r' ) ( 'I' | 'i' ) ( 'B' | 'b' ) ( 'E' | 'e' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('68')||$this->input->LA(1)==$this->getToken('100') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('67')||$this->input->LA(1)==$this->getToken('99') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('66')||$this->input->LA(1)==$this->getToken('98') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DESCRIBE"

    // $ANTLR start "ASK"
    function mASK(){
        try {
            $_type = Iri::$ASK;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:59:5: ( ( 'A' | 'a' ) ( 'S' | 's' ) ( 'K' | 'k' ) ) 
            // Iri.g:59:7: ( 'A' | 'a' ) ( 'S' | 's' ) ( 'K' | 'k' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('75')||$this->input->LA(1)==$this->getToken('107') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ASK"

    // $ANTLR start "FROM"
    function mFROM(){
        try {
            $_type = Iri::$FROM;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:63:5: ( ( 'F' | 'f' ) ( 'R' | 'r' ) ( 'O' | 'o' ) ( 'M' | 'm' ) ) 
            // Iri.g:63:7: ( 'F' | 'f' ) ( 'R' | 'r' ) ( 'O' | 'o' ) ( 'M' | 'm' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('70')||$this->input->LA(1)==$this->getToken('102') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('79')||$this->input->LA(1)==$this->getToken('111') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('77')||$this->input->LA(1)==$this->getToken('109') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "FROM"

    // $ANTLR start "NAMED"
    function mNAMED(){
        try {
            $_type = Iri::$NAMED;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:67:5: ( ( 'N' | 'n' ) ( 'A' | 'a' ) ( 'M' | 'm' ) ( 'E' | 'e' ) ( 'D' | 'd' ) ) 
            // Iri.g:67:7: ( 'N' | 'n' ) ( 'A' | 'a' ) ( 'M' | 'm' ) ( 'E' | 'e' ) ( 'D' | 'd' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('77')||$this->input->LA(1)==$this->getToken('109') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('68')||$this->input->LA(1)==$this->getToken('100') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "NAMED"

    // $ANTLR start "WHERE"
    function mWHERE(){
        try {
            $_type = Iri::$WHERE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:71:5: ( ( 'W' | 'w' ) ( 'H' | 'h' ) ( 'E' | 'e' ) ( 'R' | 'r' ) ( 'E' | 'e' ) ) 
            // Iri.g:71:7: ( 'W' | 'w' ) ( 'H' | 'h' ) ( 'E' | 'e' ) ( 'R' | 'r' ) ( 'E' | 'e' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('87')||$this->input->LA(1)==$this->getToken('119') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('72')||$this->input->LA(1)==$this->getToken('104') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "WHERE"

    // $ANTLR start "ORDER"
    function mORDER(){
        try {
            $_type = Iri::$ORDER;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:75:5: ( ( 'O' | 'o' ) ( 'R' | 'r' ) ( 'D' | 'd' ) ( 'E' | 'e' ) ( 'R' | 'r' ) ) 
            // Iri.g:75:7: ( 'O' | 'o' ) ( 'R' | 'r' ) ( 'D' | 'd' ) ( 'E' | 'e' ) ( 'R' | 'r' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('79')||$this->input->LA(1)==$this->getToken('111') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('68')||$this->input->LA(1)==$this->getToken('100') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ORDER"

    // $ANTLR start "BY"
    function mBY(){
        try {
            $_type = Iri::$BY;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:79:5: ( ( 'B' | 'b' ) ( 'Y' | 'y' ) ) 
            // Iri.g:79:7: ( 'B' | 'b' ) ( 'Y' | 'y' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('66')||$this->input->LA(1)==$this->getToken('98') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('89')||$this->input->LA(1)==$this->getToken('121') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "BY"

    // $ANTLR start "ASC"
    function mASC(){
        try {
            $_type = Iri::$ASC;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:83:5: ( ( 'A' | 'a' ) ( 'S' | 's' ) ( 'C' | 'c' ) ) 
            // Iri.g:83:7: ( 'A' | 'a' ) ( 'S' | 's' ) ( 'C' | 'c' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('67')||$this->input->LA(1)==$this->getToken('99') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ASC"

    // $ANTLR start "DESC"
    function mDESC(){
        try {
            $_type = Iri::$DESC;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:87:5: ( ( 'D' | 'd' ) ( 'E' | 'e' ) ( 'S' | 's' ) ( 'C' | 'c' ) ) 
            // Iri.g:87:7: ( 'D' | 'd' ) ( 'E' | 'e' ) ( 'S' | 's' ) ( 'C' | 'c' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('68')||$this->input->LA(1)==$this->getToken('100') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('67')||$this->input->LA(1)==$this->getToken('99') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DESC"

    // $ANTLR start "LIMIT"
    function mLIMIT(){
        try {
            $_type = Iri::$LIMIT;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:91:5: ( ( 'L' | 'l' ) ( 'I' | 'i' ) ( 'M' | 'm' ) ( 'I' | 'i' ) ( 'T' | 't' ) ) 
            // Iri.g:91:7: ( 'L' | 'l' ) ( 'I' | 'i' ) ( 'M' | 'm' ) ( 'I' | 'i' ) ( 'T' | 't' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('77')||$this->input->LA(1)==$this->getToken('109') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LIMIT"

    // $ANTLR start "OFFSET"
    function mOFFSET(){
        try {
            $_type = Iri::$OFFSET;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:95:5: ( ( 'O' | 'o' ) ( 'F' | 'f' ) ( 'F' | 'f' ) ( 'S' | 's' ) ( 'E' | 'e' ) ( 'T' | 't' ) ) 
            // Iri.g:95:7: ( 'O' | 'o' ) ( 'F' | 'f' ) ( 'F' | 'f' ) ( 'S' | 's' ) ( 'E' | 'e' ) ( 'T' | 't' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('79')||$this->input->LA(1)==$this->getToken('111') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('70')||$this->input->LA(1)==$this->getToken('102') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('70')||$this->input->LA(1)==$this->getToken('102') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "OFFSET"

    // $ANTLR start "OPTIONAL"
    function mOPTIONAL(){
        try {
            $_type = Iri::$OPTIONAL;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:99:5: ( ( 'O' | 'o' ) ( 'P' | 'p' ) ( 'T' | 't' ) ( 'I' | 'i' ) ( 'O' | 'o' ) ( 'N' | 'n' ) ( 'A' | 'a' ) ( 'L' | 'l' ) ) 
            // Iri.g:99:7: ( 'O' | 'o' ) ( 'P' | 'p' ) ( 'T' | 't' ) ( 'I' | 'i' ) ( 'O' | 'o' ) ( 'N' | 'n' ) ( 'A' | 'a' ) ( 'L' | 'l' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('79')||$this->input->LA(1)==$this->getToken('111') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('80')||$this->input->LA(1)==$this->getToken('112') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('79')||$this->input->LA(1)==$this->getToken('111') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "OPTIONAL"

    // $ANTLR start "GRAPH"
    function mGRAPH(){
        try {
            $_type = Iri::$GRAPH;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:103:5: ( ( 'G' | 'g' ) ( 'R' | 'r' ) ( 'A' | 'a' ) ( 'P' | 'p' ) ( 'H' | 'h' ) ) 
            // Iri.g:103:7: ( 'G' | 'g' ) ( 'R' | 'r' ) ( 'A' | 'a' ) ( 'P' | 'p' ) ( 'H' | 'h' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('71')||$this->input->LA(1)==$this->getToken('103') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('80')||$this->input->LA(1)==$this->getToken('112') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('72')||$this->input->LA(1)==$this->getToken('104') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "GRAPH"

    // $ANTLR start "UNION"
    function mUNION(){
        try {
            $_type = Iri::$UNION;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:107:5: ( ( 'U' | 'u' ) ( 'N' | 'n' ) ( 'I' | 'i' ) ( 'O' | 'o' ) ( 'N' | 'n' ) ) 
            // Iri.g:107:7: ( 'U' | 'u' ) ( 'N' | 'n' ) ( 'I' | 'i' ) ( 'O' | 'o' ) ( 'N' | 'n' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('85')||$this->input->LA(1)==$this->getToken('117') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('79')||$this->input->LA(1)==$this->getToken('111') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "UNION"

    // $ANTLR start "FILTER"
    function mFILTER(){
        try {
            $_type = Iri::$FILTER;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:111:5: ( ( 'F' | 'f' ) ( 'I' | 'i' ) ( 'L' | 'l' ) ( 'T' | 't' ) ( 'E' | 'e' ) ( 'R' | 'r' ) ) 
            // Iri.g:111:7: ( 'F' | 'f' ) ( 'I' | 'i' ) ( 'L' | 'l' ) ( 'T' | 't' ) ( 'E' | 'e' ) ( 'R' | 'r' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('70')||$this->input->LA(1)==$this->getToken('102') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "FILTER"

    // $ANTLR start "A"
    function mA(){
        try {
            $_type = Iri::$A;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:115:5: ( ( 'a' ) ) 
            // Iri.g:115:7: ( 'a' ) 
            {
            // Iri.g:115:7: ( 'a' ) 
            // Iri.g:115:8: 'a' 
            {
            $this->matchChar(97); 

            }


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "A"

    // $ANTLR start "STR"
    function mSTR(){
        try {
            $_type = Iri::$STR;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:119:5: ( ( 'S' | 's' ) ( 'T' | 't' ) ( 'R' | 'r' ) ) 
            // Iri.g:119:7: ( 'S' | 's' ) ( 'T' | 't' ) ( 'R' | 'r' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "STR"

    // $ANTLR start "LANG"
    function mLANG(){
        try {
            $_type = Iri::$LANG;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:123:5: ( ( 'L' | 'l' ) ( 'A' | 'a' ) ( 'N' | 'n' ) ( 'G' | 'g' ) ) 
            // Iri.g:123:7: ( 'L' | 'l' ) ( 'A' | 'a' ) ( 'N' | 'n' ) ( 'G' | 'g' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('71')||$this->input->LA(1)==$this->getToken('103') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LANG"

    // $ANTLR start "LANGMATCHES"
    function mLANGMATCHES(){
        try {
            $_type = Iri::$LANGMATCHES;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:127:5: ( ( 'L' | 'l' ) ( 'A' | 'a' ) ( 'N' | 'n' ) ( 'G' | 'g' ) ( 'M' | 'm' ) ( 'A' | 'a' ) ( 'T' | 't' ) ( 'C' | 'c' ) ( 'H' | 'h' ) ( 'E' | 'e' ) ( 'S' | 's' ) ) 
            // Iri.g:127:7: ( 'L' | 'l' ) ( 'A' | 'a' ) ( 'N' | 'n' ) ( 'G' | 'g' ) ( 'M' | 'm' ) ( 'A' | 'a' ) ( 'T' | 't' ) ( 'C' | 'c' ) ( 'H' | 'h' ) ( 'E' | 'e' ) ( 'S' | 's' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('71')||$this->input->LA(1)==$this->getToken('103') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('77')||$this->input->LA(1)==$this->getToken('109') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('67')||$this->input->LA(1)==$this->getToken('99') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('72')||$this->input->LA(1)==$this->getToken('104') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LANGMATCHES"

    // $ANTLR start "DATATYPE"
    function mDATATYPE(){
        try {
            $_type = Iri::$DATATYPE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:131:5: ( ( 'D' | 'd' ) ( 'A' | 'a' ) ( 'T' | 't' ) ( 'A' | 'a' ) ( 'T' | 't' ) ( 'Y' | 'y' ) ( 'P' | 'p' ) ( 'E' | 'e' ) ) 
            // Iri.g:131:7: ( 'D' | 'd' ) ( 'A' | 'a' ) ( 'T' | 't' ) ( 'A' | 'a' ) ( 'T' | 't' ) ( 'Y' | 'y' ) ( 'P' | 'p' ) ( 'E' | 'e' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('68')||$this->input->LA(1)==$this->getToken('100') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('89')||$this->input->LA(1)==$this->getToken('121') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('80')||$this->input->LA(1)==$this->getToken('112') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DATATYPE"

    // $ANTLR start "BOUND"
    function mBOUND(){
        try {
            $_type = Iri::$BOUND;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:135:5: ( ( 'B' | 'b' ) ( 'O' | 'o' ) ( 'U' | 'u' ) ( 'N' | 'n' ) ( 'D' | 'd' ) ) 
            // Iri.g:135:7: ( 'B' | 'b' ) ( 'O' | 'o' ) ( 'U' | 'u' ) ( 'N' | 'n' ) ( 'D' | 'd' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('66')||$this->input->LA(1)==$this->getToken('98') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('79')||$this->input->LA(1)==$this->getToken('111') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('85')||$this->input->LA(1)==$this->getToken('117') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('68')||$this->input->LA(1)==$this->getToken('100') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "BOUND"

    // $ANTLR start "SAMETERM"
    function mSAMETERM(){
        try {
            $_type = Iri::$SAMETERM;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:139:5: ( ( 'S' | 's' ) ( 'A' | 'a' ) ( 'M' | 'm' ) ( 'E' | 'e' ) ( 'T' | 't' ) ( 'E' | 'e' ) ( 'R' | 'r' ) ( 'M' | 'm' ) ) 
            // Iri.g:139:7: ( 'S' | 's' ) ( 'A' | 'a' ) ( 'M' | 'm' ) ( 'E' | 'e' ) ( 'T' | 't' ) ( 'E' | 'e' ) ( 'R' | 'r' ) ( 'M' | 'm' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('77')||$this->input->LA(1)==$this->getToken('109') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('77')||$this->input->LA(1)==$this->getToken('109') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "SAMETERM"

    // $ANTLR start "ISIRI"
    function mISIRI(){
        try {
            $_type = Iri::$ISIRI;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:143:5: ( ( 'I' | 'i' ) ( 'S' | 's' ) ( 'I' | 'i' ) ( 'R' | 'r' ) ( 'I' | 'i' ) ) 
            // Iri.g:143:7: ( 'I' | 'i' ) ( 'S' | 's' ) ( 'I' | 'i' ) ( 'R' | 'r' ) ( 'I' | 'i' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ISIRI"

    // $ANTLR start "ISURI"
    function mISURI(){
        try {
            $_type = Iri::$ISURI;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:147:5: ( ( 'I' | 'i' ) ( 'S' | 's' ) ( 'U' | 'u' ) ( 'R' | 'r' ) ( 'I' | 'i' ) ) 
            // Iri.g:147:7: ( 'I' | 'i' ) ( 'S' | 's' ) ( 'U' | 'u' ) ( 'R' | 'r' ) ( 'I' | 'i' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('85')||$this->input->LA(1)==$this->getToken('117') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ISURI"

    // $ANTLR start "ISBLANK"
    function mISBLANK(){
        try {
            $_type = Iri::$ISBLANK;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:151:5: ( ( 'I' | 'i' ) ( 'S' | 's' ) ( 'B' | 'b' ) ( 'L' | 'l' ) ( 'A' | 'a' ) ( 'N' | 'n' ) ( 'K' | 'k' ) ) 
            // Iri.g:151:7: ( 'I' | 'i' ) ( 'S' | 's' ) ( 'B' | 'b' ) ( 'L' | 'l' ) ( 'A' | 'a' ) ( 'N' | 'n' ) ( 'K' | 'k' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('66')||$this->input->LA(1)==$this->getToken('98') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('78')||$this->input->LA(1)==$this->getToken('110') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('75')||$this->input->LA(1)==$this->getToken('107') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ISBLANK"

    // $ANTLR start "ISLITERAL"
    function mISLITERAL(){
        try {
            $_type = Iri::$ISLITERAL;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:155:5: ( ( 'I' | 'i' ) ( 'S' | 's' ) ( 'L' | 'l' ) ( 'I' | 'i' ) ( 'T' | 't' ) ( 'E' | 'e' ) ( 'R' | 'r' ) ( 'A' | 'a' ) ( 'L' | 'l' ) ) 
            // Iri.g:155:7: ( 'I' | 'i' ) ( 'S' | 's' ) ( 'L' | 'l' ) ( 'I' | 'i' ) ( 'T' | 't' ) ( 'E' | 'e' ) ( 'R' | 'r' ) ( 'A' | 'a' ) ( 'L' | 'l' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('73')||$this->input->LA(1)==$this->getToken('105') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ISLITERAL"

    // $ANTLR start "REGEX"
    function mREGEX(){
        try {
            $_type = Iri::$REGEX;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:159:5: ( ( 'R' | 'r' ) ( 'E' | 'e' ) ( 'G' | 'g' ) ( 'E' | 'e' ) ( 'X' | 'x' ) ) 
            // Iri.g:159:7: ( 'R' | 'r' ) ( 'E' | 'e' ) ( 'G' | 'g' ) ( 'E' | 'e' ) ( 'X' | 'x' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('71')||$this->input->LA(1)==$this->getToken('103') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('88')||$this->input->LA(1)==$this->getToken('120') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "REGEX"

    // $ANTLR start "TRUE"
    function mTRUE(){
        try {
            $_type = Iri::$TRUE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:163:5: ( ( 'T' | 't' ) ( 'R' | 'r' ) ( 'U' | 'u' ) ( 'E' | 'e' ) ) 
            // Iri.g:163:7: ( 'T' | 't' ) ( 'R' | 'r' ) ( 'U' | 'u' ) ( 'E' | 'e' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('84')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('82')||$this->input->LA(1)==$this->getToken('114') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('85')||$this->input->LA(1)==$this->getToken('117') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "TRUE"

    // $ANTLR start "FALSE"
    function mFALSE(){
        try {
            $_type = Iri::$FALSE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:167:5: ( ( 'F' | 'f' ) ( 'A' | 'a' ) ( 'L' | 'l' ) ( 'S' | 's' ) ( 'E' | 'e' ) ) 
            // Iri.g:167:7: ( 'F' | 'f' ) ( 'A' | 'a' ) ( 'L' | 'l' ) ( 'S' | 's' ) ( 'E' | 'e' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('70')||$this->input->LA(1)==$this->getToken('102') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('65')||$this->input->LA(1)==$this->getToken('97') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('76')||$this->input->LA(1)==$this->getToken('108') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('83')||$this->input->LA(1)==$this->getToken('115') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "FALSE"

    // $ANTLR start "PNAME_LN"
    function mPNAME_LN(){
        try {
            $_type = Iri::$PNAME_LN;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:173:5: ( PNAME_NS PN_LOCAL ) 
            // Iri.g:173:7: PNAME_NS PN_LOCAL 
            {
            $this->mPNAME_NS(); 
            $this->mPN_LOCAL(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PNAME_LN"

    // $ANTLR start "PNAME_NS"
    function mPNAME_NS(){
        try {
            $_type = Iri::$PNAME_NS;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            $p=null;

            // Iri.g:177:5: ( (p= PN_PREFIX )? ':' ) 
            // Iri.g:177:7: (p= PN_PREFIX )? ':' 
            {
            // Iri.g:177:8: (p= PN_PREFIX )? 
            $alt3=2;
            $LA3_0 = $this->input->LA(1);

            if ( (($LA3_0>=$this->getToken('65') && $LA3_0<=$this->getToken('90'))||($LA3_0>=$this->getToken('97') && $LA3_0<=$this->getToken('122'))||($LA3_0>=$this->getToken('192') && $LA3_0<=$this->getToken('214'))||($LA3_0>=$this->getToken('216') && $LA3_0<=$this->getToken('246'))||($LA3_0>=$this->getToken('248') && $LA3_0<=$this->getToken('767'))||($LA3_0>=$this->getToken('880') && $LA3_0<=$this->getToken('893'))||($LA3_0>=$this->getToken('895') && $LA3_0<=$this->getToken('8191'))||($LA3_0>=$this->getToken('8204') && $LA3_0<=$this->getToken('8205'))||($LA3_0>=$this->getToken('8304') && $LA3_0<=$this->getToken('8591'))||($LA3_0>=$this->getToken('11264') && $LA3_0<=$this->getToken('12271'))||($LA3_0>=$this->getToken('12289') && $LA3_0<=$this->getToken('55295'))||($LA3_0>=$this->getToken('63744') && $LA3_0<=$this->getToken('64975'))||($LA3_0>=$this->getToken('65008') && $LA3_0<=$this->getToken('65533'))) ) {
                $alt3=1;
            }
            switch ($alt3) {
                case 1 :
                    // Iri.g:177:8: p= PN_PREFIX 
                    {
                    $pStart1731 = $this->getCharIndex();
                    $this->mPN_PREFIX(); 
                    $p = new CommonToken($this->input, TokenConst::$INVALID_TOKEN_TYPE, TokenConst::$DEFAULT_CHANNEL, $pStart1731, $this->getCharIndex()-1);

                    }
                    break;

            }

            $this->matchChar(58); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PNAME_NS"

    // $ANTLR start "PN_PREFIX"
    function mPN_PREFIX(){
        try {
            // Iri.g:184:5: ( PN_CHARS_BASE ( ( PN_CHARS | DOT )* PN_CHARS )? ) 
            // Iri.g:184:7: PN_CHARS_BASE ( ( PN_CHARS | DOT )* PN_CHARS )? 
            {
            $this->mPN_CHARS_BASE(); 
            // Iri.g:184:21: ( ( PN_CHARS | DOT )* PN_CHARS )? 
            $alt5=2;
            $LA5_0 = $this->input->LA(1);

            if ( (($LA5_0>=$this->getToken('45') && $LA5_0<=$this->getToken('46'))||($LA5_0>=$this->getToken('48') && $LA5_0<=$this->getToken('57'))||($LA5_0>=$this->getToken('65') && $LA5_0<=$this->getToken('90'))||$LA5_0==$this->getToken('95')||($LA5_0>=$this->getToken('97') && $LA5_0<=$this->getToken('122'))||$LA5_0==$this->getToken('183')||($LA5_0>=$this->getToken('192') && $LA5_0<=$this->getToken('214'))||($LA5_0>=$this->getToken('216') && $LA5_0<=$this->getToken('246'))||($LA5_0>=$this->getToken('248') && $LA5_0<=$this->getToken('893'))||($LA5_0>=$this->getToken('895') && $LA5_0<=$this->getToken('8191'))||($LA5_0>=$this->getToken('8204') && $LA5_0<=$this->getToken('8205'))||($LA5_0>=$this->getToken('8255') && $LA5_0<=$this->getToken('8256'))||($LA5_0>=$this->getToken('8304') && $LA5_0<=$this->getToken('8591'))||($LA5_0>=$this->getToken('11264') && $LA5_0<=$this->getToken('12271'))||($LA5_0>=$this->getToken('12289') && $LA5_0<=$this->getToken('55295'))||($LA5_0>=$this->getToken('63744') && $LA5_0<=$this->getToken('64975'))||($LA5_0>=$this->getToken('65008') && $LA5_0<=$this->getToken('65533'))) ) {
                $alt5=1;
            }
            switch ($alt5) {
                case 1 :
                    // Iri.g:184:22: ( PN_CHARS | DOT )* PN_CHARS 
                    {
                    // Iri.g:184:22: ( PN_CHARS | DOT )* 
                    //loop4:
                    do {
                        $alt4=2;
                        $LA4_0 = $this->input->LA(1);

                        if ( ($LA4_0==$this->getToken('45')||($LA4_0>=$this->getToken('48') && $LA4_0<=$this->getToken('57'))||($LA4_0>=$this->getToken('65') && $LA4_0<=$this->getToken('90'))||$LA4_0==$this->getToken('95')||($LA4_0>=$this->getToken('97') && $LA4_0<=$this->getToken('122'))||$LA4_0==$this->getToken('183')||($LA4_0>=$this->getToken('192') && $LA4_0<=$this->getToken('214'))||($LA4_0>=$this->getToken('216') && $LA4_0<=$this->getToken('246'))||($LA4_0>=$this->getToken('248') && $LA4_0<=$this->getToken('893'))||($LA4_0>=$this->getToken('895') && $LA4_0<=$this->getToken('8191'))||($LA4_0>=$this->getToken('8204') && $LA4_0<=$this->getToken('8205'))||($LA4_0>=$this->getToken('8255') && $LA4_0<=$this->getToken('8256'))||($LA4_0>=$this->getToken('8304') && $LA4_0<=$this->getToken('8591'))||($LA4_0>=$this->getToken('11264') && $LA4_0<=$this->getToken('12271'))||($LA4_0>=$this->getToken('12289') && $LA4_0<=$this->getToken('55295'))||($LA4_0>=$this->getToken('63744') && $LA4_0<=$this->getToken('64975'))||($LA4_0>=$this->getToken('65008') && $LA4_0<=$this->getToken('65533'))) ) {
                            $LA4_1 = $this->input->LA(2);

                            if ( (($LA4_1>=$this->getToken('45') && $LA4_1<=$this->getToken('46'))||($LA4_1>=$this->getToken('48') && $LA4_1<=$this->getToken('57'))||($LA4_1>=$this->getToken('65') && $LA4_1<=$this->getToken('90'))||$LA4_1==$this->getToken('95')||($LA4_1>=$this->getToken('97') && $LA4_1<=$this->getToken('122'))||$LA4_1==$this->getToken('183')||($LA4_1>=$this->getToken('192') && $LA4_1<=$this->getToken('214'))||($LA4_1>=$this->getToken('216') && $LA4_1<=$this->getToken('246'))||($LA4_1>=$this->getToken('248') && $LA4_1<=$this->getToken('893'))||($LA4_1>=$this->getToken('895') && $LA4_1<=$this->getToken('8191'))||($LA4_1>=$this->getToken('8204') && $LA4_1<=$this->getToken('8205'))||($LA4_1>=$this->getToken('8255') && $LA4_1<=$this->getToken('8256'))||($LA4_1>=$this->getToken('8304') && $LA4_1<=$this->getToken('8591'))||($LA4_1>=$this->getToken('11264') && $LA4_1<=$this->getToken('12271'))||($LA4_1>=$this->getToken('12289') && $LA4_1<=$this->getToken('55295'))||($LA4_1>=$this->getToken('63744') && $LA4_1<=$this->getToken('64975'))||($LA4_1>=$this->getToken('65008') && $LA4_1<=$this->getToken('65533'))) ) {
                                $alt4=1;
                            }


                        }
                        else if ( ($LA4_0==$this->getToken('46')) ) {
                            $alt4=1;
                        }


                        switch ($alt4) {
                    	case 1 :
                    	    // Iri.g: 
                    	    {
                    	    if ( ($this->input->LA(1)>=$this->getToken('45') && $this->input->LA(1)<=$this->getToken('46'))||($this->input->LA(1)>=$this->getToken('48') && $this->input->LA(1)<=$this->getToken('57'))||($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||$this->input->LA(1)==$this->getToken('183')||($this->input->LA(1)>=$this->getToken('192') && $this->input->LA(1)<=$this->getToken('214'))||($this->input->LA(1)>=$this->getToken('216') && $this->input->LA(1)<=$this->getToken('246'))||($this->input->LA(1)>=$this->getToken('248') && $this->input->LA(1)<=$this->getToken('893'))||($this->input->LA(1)>=$this->getToken('895') && $this->input->LA(1)<=$this->getToken('8191'))||($this->input->LA(1)>=$this->getToken('8204') && $this->input->LA(1)<=$this->getToken('8205'))||($this->input->LA(1)>=$this->getToken('8255') && $this->input->LA(1)<=$this->getToken('8256'))||($this->input->LA(1)>=$this->getToken('8304') && $this->input->LA(1)<=$this->getToken('8591'))||($this->input->LA(1)>=$this->getToken('11264') && $this->input->LA(1)<=$this->getToken('12271'))||($this->input->LA(1)>=$this->getToken('12289') && $this->input->LA(1)<=$this->getToken('55295'))||($this->input->LA(1)>=$this->getToken('63744') && $this->input->LA(1)<=$this->getToken('64975'))||($this->input->LA(1)>=$this->getToken('65008') && $this->input->LA(1)<=$this->getToken('65533')) ) {
                    	        $this->input->consume();

                    	    }
                    	    else {
                    	        $mse = new MismatchedSetException(null,$this->input);
                    	        $this->recover($mse);
                    	        throw $mse;}


                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop4;
                        }
                    } while (true);

                    $this->mPN_CHARS(); 

                    }
                    break;

            }


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PN_PREFIX"

    // $ANTLR start "PN_LOCAL"
    function mPN_LOCAL(){
        try {
            // Iri.g:189:5: ( ( PN_CHARS_U | DIGIT ) ( ( PN_CHARS | DOT )* PN_CHARS )? ) 
            // Iri.g:189:7: ( PN_CHARS_U | DIGIT ) ( ( PN_CHARS | DOT )* PN_CHARS )? 
            {
            if ( ($this->input->LA(1)>=$this->getToken('48') && $this->input->LA(1)<=$this->getToken('57'))||($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||($this->input->LA(1)>=$this->getToken('192') && $this->input->LA(1)<=$this->getToken('214'))||($this->input->LA(1)>=$this->getToken('216') && $this->input->LA(1)<=$this->getToken('246'))||($this->input->LA(1)>=$this->getToken('248') && $this->input->LA(1)<=$this->getToken('767'))||($this->input->LA(1)>=$this->getToken('880') && $this->input->LA(1)<=$this->getToken('893'))||($this->input->LA(1)>=$this->getToken('895') && $this->input->LA(1)<=$this->getToken('8191'))||($this->input->LA(1)>=$this->getToken('8204') && $this->input->LA(1)<=$this->getToken('8205'))||($this->input->LA(1)>=$this->getToken('8304') && $this->input->LA(1)<=$this->getToken('8591'))||($this->input->LA(1)>=$this->getToken('11264') && $this->input->LA(1)<=$this->getToken('12271'))||($this->input->LA(1)>=$this->getToken('12289') && $this->input->LA(1)<=$this->getToken('55295'))||($this->input->LA(1)>=$this->getToken('63744') && $this->input->LA(1)<=$this->getToken('64975'))||($this->input->LA(1)>=$this->getToken('65008') && $this->input->LA(1)<=$this->getToken('65533')) ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            // Iri.g:189:30: ( ( PN_CHARS | DOT )* PN_CHARS )? 
            $alt7=2;
            $LA7_0 = $this->input->LA(1);

            if ( (($LA7_0>=$this->getToken('45') && $LA7_0<=$this->getToken('46'))||($LA7_0>=$this->getToken('48') && $LA7_0<=$this->getToken('57'))||($LA7_0>=$this->getToken('65') && $LA7_0<=$this->getToken('90'))||$LA7_0==$this->getToken('95')||($LA7_0>=$this->getToken('97') && $LA7_0<=$this->getToken('122'))||$LA7_0==$this->getToken('183')||($LA7_0>=$this->getToken('192') && $LA7_0<=$this->getToken('214'))||($LA7_0>=$this->getToken('216') && $LA7_0<=$this->getToken('246'))||($LA7_0>=$this->getToken('248') && $LA7_0<=$this->getToken('893'))||($LA7_0>=$this->getToken('895') && $LA7_0<=$this->getToken('8191'))||($LA7_0>=$this->getToken('8204') && $LA7_0<=$this->getToken('8205'))||($LA7_0>=$this->getToken('8255') && $LA7_0<=$this->getToken('8256'))||($LA7_0>=$this->getToken('8304') && $LA7_0<=$this->getToken('8591'))||($LA7_0>=$this->getToken('11264') && $LA7_0<=$this->getToken('12271'))||($LA7_0>=$this->getToken('12289') && $LA7_0<=$this->getToken('55295'))||($LA7_0>=$this->getToken('63744') && $LA7_0<=$this->getToken('64975'))||($LA7_0>=$this->getToken('65008') && $LA7_0<=$this->getToken('65533'))) ) {
                $alt7=1;
            }
            switch ($alt7) {
                case 1 :
                    // Iri.g:189:31: ( PN_CHARS | DOT )* PN_CHARS 
                    {
                    // Iri.g:189:31: ( PN_CHARS | DOT )* 
                    //loop6:
                    do {
                        $alt6=2;
                        $LA6_0 = $this->input->LA(1);

                        if ( ($LA6_0==$this->getToken('45')||($LA6_0>=$this->getToken('48') && $LA6_0<=$this->getToken('57'))||($LA6_0>=$this->getToken('65') && $LA6_0<=$this->getToken('90'))||$LA6_0==$this->getToken('95')||($LA6_0>=$this->getToken('97') && $LA6_0<=$this->getToken('122'))||$LA6_0==$this->getToken('183')||($LA6_0>=$this->getToken('192') && $LA6_0<=$this->getToken('214'))||($LA6_0>=$this->getToken('216') && $LA6_0<=$this->getToken('246'))||($LA6_0>=$this->getToken('248') && $LA6_0<=$this->getToken('893'))||($LA6_0>=$this->getToken('895') && $LA6_0<=$this->getToken('8191'))||($LA6_0>=$this->getToken('8204') && $LA6_0<=$this->getToken('8205'))||($LA6_0>=$this->getToken('8255') && $LA6_0<=$this->getToken('8256'))||($LA6_0>=$this->getToken('8304') && $LA6_0<=$this->getToken('8591'))||($LA6_0>=$this->getToken('11264') && $LA6_0<=$this->getToken('12271'))||($LA6_0>=$this->getToken('12289') && $LA6_0<=$this->getToken('55295'))||($LA6_0>=$this->getToken('63744') && $LA6_0<=$this->getToken('64975'))||($LA6_0>=$this->getToken('65008') && $LA6_0<=$this->getToken('65533'))) ) {
                            $LA6_1 = $this->input->LA(2);

                            if ( (($LA6_1>=$this->getToken('45') && $LA6_1<=$this->getToken('46'))||($LA6_1>=$this->getToken('48') && $LA6_1<=$this->getToken('57'))||($LA6_1>=$this->getToken('65') && $LA6_1<=$this->getToken('90'))||$LA6_1==$this->getToken('95')||($LA6_1>=$this->getToken('97') && $LA6_1<=$this->getToken('122'))||$LA6_1==$this->getToken('183')||($LA6_1>=$this->getToken('192') && $LA6_1<=$this->getToken('214'))||($LA6_1>=$this->getToken('216') && $LA6_1<=$this->getToken('246'))||($LA6_1>=$this->getToken('248') && $LA6_1<=$this->getToken('893'))||($LA6_1>=$this->getToken('895') && $LA6_1<=$this->getToken('8191'))||($LA6_1>=$this->getToken('8204') && $LA6_1<=$this->getToken('8205'))||($LA6_1>=$this->getToken('8255') && $LA6_1<=$this->getToken('8256'))||($LA6_1>=$this->getToken('8304') && $LA6_1<=$this->getToken('8591'))||($LA6_1>=$this->getToken('11264') && $LA6_1<=$this->getToken('12271'))||($LA6_1>=$this->getToken('12289') && $LA6_1<=$this->getToken('55295'))||($LA6_1>=$this->getToken('63744') && $LA6_1<=$this->getToken('64975'))||($LA6_1>=$this->getToken('65008') && $LA6_1<=$this->getToken('65533'))) ) {
                                $alt6=1;
                            }


                        }
                        else if ( ($LA6_0==$this->getToken('46')) ) {
                            $alt6=1;
                        }


                        switch ($alt6) {
                    	case 1 :
                    	    // Iri.g: 
                    	    {
                    	    if ( ($this->input->LA(1)>=$this->getToken('45') && $this->input->LA(1)<=$this->getToken('46'))||($this->input->LA(1)>=$this->getToken('48') && $this->input->LA(1)<=$this->getToken('57'))||($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||$this->input->LA(1)==$this->getToken('183')||($this->input->LA(1)>=$this->getToken('192') && $this->input->LA(1)<=$this->getToken('214'))||($this->input->LA(1)>=$this->getToken('216') && $this->input->LA(1)<=$this->getToken('246'))||($this->input->LA(1)>=$this->getToken('248') && $this->input->LA(1)<=$this->getToken('893'))||($this->input->LA(1)>=$this->getToken('895') && $this->input->LA(1)<=$this->getToken('8191'))||($this->input->LA(1)>=$this->getToken('8204') && $this->input->LA(1)<=$this->getToken('8205'))||($this->input->LA(1)>=$this->getToken('8255') && $this->input->LA(1)<=$this->getToken('8256'))||($this->input->LA(1)>=$this->getToken('8304') && $this->input->LA(1)<=$this->getToken('8591'))||($this->input->LA(1)>=$this->getToken('11264') && $this->input->LA(1)<=$this->getToken('12271'))||($this->input->LA(1)>=$this->getToken('12289') && $this->input->LA(1)<=$this->getToken('55295'))||($this->input->LA(1)>=$this->getToken('63744') && $this->input->LA(1)<=$this->getToken('64975'))||($this->input->LA(1)>=$this->getToken('65008') && $this->input->LA(1)<=$this->getToken('65533')) ) {
                    	        $this->input->consume();

                    	    }
                    	    else {
                    	        $mse = new MismatchedSetException(null,$this->input);
                    	        $this->recover($mse);
                    	        throw $mse;}


                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop6;
                        }
                    } while (true);

                    $this->mPN_CHARS(); 

                    }
                    break;

            }


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PN_LOCAL"

    // $ANTLR start "PN_CHARS_BASE"
    function mPN_CHARS_BASE(){
        try {
            // Iri.g:194:5: ( 'A' .. 'Z' | 'a' .. 'z' | '\\u00C0' .. '\\u00D6' | '\\u00D8' .. '\\u00F6' | '\\u00F8' .. '\\u02FF' | '\\u0370' .. '\\u037D' | '\\u037F' .. '\\u1FFF' | '\\u200C' .. '\\u200D' | '\\u2070' .. '\\u218F' | '\\u2C00' .. '\\u2FEF' | '\\u3001' .. '\\uD7FF' | '\\uF900' .. '\\uFDCF' | '\\uFDF0' .. '\\uFFFD' ) 
            // Iri.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||($this->input->LA(1)>=$this->getToken('192') && $this->input->LA(1)<=$this->getToken('214'))||($this->input->LA(1)>=$this->getToken('216') && $this->input->LA(1)<=$this->getToken('246'))||($this->input->LA(1)>=$this->getToken('248') && $this->input->LA(1)<=$this->getToken('767'))||($this->input->LA(1)>=$this->getToken('880') && $this->input->LA(1)<=$this->getToken('893'))||($this->input->LA(1)>=$this->getToken('895') && $this->input->LA(1)<=$this->getToken('8191'))||($this->input->LA(1)>=$this->getToken('8204') && $this->input->LA(1)<=$this->getToken('8205'))||($this->input->LA(1)>=$this->getToken('8304') && $this->input->LA(1)<=$this->getToken('8591'))||($this->input->LA(1)>=$this->getToken('11264') && $this->input->LA(1)<=$this->getToken('12271'))||($this->input->LA(1)>=$this->getToken('12289') && $this->input->LA(1)<=$this->getToken('55295'))||($this->input->LA(1)>=$this->getToken('63744') && $this->input->LA(1)<=$this->getToken('64975'))||($this->input->LA(1)>=$this->getToken('65008') && $this->input->LA(1)<=$this->getToken('65533')) ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PN_CHARS_BASE"

    // $ANTLR start "DIGIT"
    function mDIGIT(){
        try {
            // Iri.g:211:5: ( '0' .. '9' ) 
            // Iri.g:211:7: '0' .. '9' 
            {
            $this->matchRange(48,57); 

            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DIGIT"

    // $ANTLR start "PN_CHARS_U"
    function mPN_CHARS_U(){
        try {
            // Iri.g:216:6: ( PN_CHARS_BASE | '_' ) 
            // Iri.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||($this->input->LA(1)>=$this->getToken('192') && $this->input->LA(1)<=$this->getToken('214'))||($this->input->LA(1)>=$this->getToken('216') && $this->input->LA(1)<=$this->getToken('246'))||($this->input->LA(1)>=$this->getToken('248') && $this->input->LA(1)<=$this->getToken('767'))||($this->input->LA(1)>=$this->getToken('880') && $this->input->LA(1)<=$this->getToken('893'))||($this->input->LA(1)>=$this->getToken('895') && $this->input->LA(1)<=$this->getToken('8191'))||($this->input->LA(1)>=$this->getToken('8204') && $this->input->LA(1)<=$this->getToken('8205'))||($this->input->LA(1)>=$this->getToken('8304') && $this->input->LA(1)<=$this->getToken('8591'))||($this->input->LA(1)>=$this->getToken('11264') && $this->input->LA(1)<=$this->getToken('12271'))||($this->input->LA(1)>=$this->getToken('12289') && $this->input->LA(1)<=$this->getToken('55295'))||($this->input->LA(1)>=$this->getToken('63744') && $this->input->LA(1)<=$this->getToken('64975'))||($this->input->LA(1)>=$this->getToken('65008') && $this->input->LA(1)<=$this->getToken('65533')) ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PN_CHARS_U"

    // $ANTLR start "VARNAME"
    function mVARNAME(){
        try {
            // Iri.g:221:5: ( ( PN_CHARS_U | DIGIT ) ( PN_CHARS_U | DIGIT | '\\u00B7' | '\\u0300' .. '\\u036F' | '\\u203F' .. '\\u2040' )* ) 
            // Iri.g:221:7: ( PN_CHARS_U | DIGIT ) ( PN_CHARS_U | DIGIT | '\\u00B7' | '\\u0300' .. '\\u036F' | '\\u203F' .. '\\u2040' )* 
            {
            if ( ($this->input->LA(1)>=$this->getToken('48') && $this->input->LA(1)<=$this->getToken('57'))||($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||($this->input->LA(1)>=$this->getToken('192') && $this->input->LA(1)<=$this->getToken('214'))||($this->input->LA(1)>=$this->getToken('216') && $this->input->LA(1)<=$this->getToken('246'))||($this->input->LA(1)>=$this->getToken('248') && $this->input->LA(1)<=$this->getToken('767'))||($this->input->LA(1)>=$this->getToken('880') && $this->input->LA(1)<=$this->getToken('893'))||($this->input->LA(1)>=$this->getToken('895') && $this->input->LA(1)<=$this->getToken('8191'))||($this->input->LA(1)>=$this->getToken('8204') && $this->input->LA(1)<=$this->getToken('8205'))||($this->input->LA(1)>=$this->getToken('8304') && $this->input->LA(1)<=$this->getToken('8591'))||($this->input->LA(1)>=$this->getToken('11264') && $this->input->LA(1)<=$this->getToken('12271'))||($this->input->LA(1)>=$this->getToken('12289') && $this->input->LA(1)<=$this->getToken('55295'))||($this->input->LA(1)>=$this->getToken('63744') && $this->input->LA(1)<=$this->getToken('64975'))||($this->input->LA(1)>=$this->getToken('65008') && $this->input->LA(1)<=$this->getToken('65533')) ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            // Iri.g:221:30: ( PN_CHARS_U | DIGIT | '\\u00B7' | '\\u0300' .. '\\u036F' | '\\u203F' .. '\\u2040' )* 
            //loop8:
            do {
                $alt8=2;
                $LA8_0 = $this->input->LA(1);

                if ( (($LA8_0>=$this->getToken('48') && $LA8_0<=$this->getToken('57'))||($LA8_0>=$this->getToken('65') && $LA8_0<=$this->getToken('90'))||$LA8_0==$this->getToken('95')||($LA8_0>=$this->getToken('97') && $LA8_0<=$this->getToken('122'))||$LA8_0==$this->getToken('183')||($LA8_0>=$this->getToken('192') && $LA8_0<=$this->getToken('214'))||($LA8_0>=$this->getToken('216') && $LA8_0<=$this->getToken('246'))||($LA8_0>=$this->getToken('248') && $LA8_0<=$this->getToken('893'))||($LA8_0>=$this->getToken('895') && $LA8_0<=$this->getToken('8191'))||($LA8_0>=$this->getToken('8204') && $LA8_0<=$this->getToken('8205'))||($LA8_0>=$this->getToken('8255') && $LA8_0<=$this->getToken('8256'))||($LA8_0>=$this->getToken('8304') && $LA8_0<=$this->getToken('8591'))||($LA8_0>=$this->getToken('11264') && $LA8_0<=$this->getToken('12271'))||($LA8_0>=$this->getToken('12289') && $LA8_0<=$this->getToken('55295'))||($LA8_0>=$this->getToken('63744') && $LA8_0<=$this->getToken('64975'))||($LA8_0>=$this->getToken('65008') && $LA8_0<=$this->getToken('65533'))) ) {
                    $alt8=1;
                }


                switch ($alt8) {
            	case 1 :
            	    // Iri.g: 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('48') && $this->input->LA(1)<=$this->getToken('57'))||($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||$this->input->LA(1)==$this->getToken('183')||($this->input->LA(1)>=$this->getToken('192') && $this->input->LA(1)<=$this->getToken('214'))||($this->input->LA(1)>=$this->getToken('216') && $this->input->LA(1)<=$this->getToken('246'))||($this->input->LA(1)>=$this->getToken('248') && $this->input->LA(1)<=$this->getToken('893'))||($this->input->LA(1)>=$this->getToken('895') && $this->input->LA(1)<=$this->getToken('8191'))||($this->input->LA(1)>=$this->getToken('8204') && $this->input->LA(1)<=$this->getToken('8205'))||($this->input->LA(1)>=$this->getToken('8255') && $this->input->LA(1)<=$this->getToken('8256'))||($this->input->LA(1)>=$this->getToken('8304') && $this->input->LA(1)<=$this->getToken('8591'))||($this->input->LA(1)>=$this->getToken('11264') && $this->input->LA(1)<=$this->getToken('12271'))||($this->input->LA(1)>=$this->getToken('12289') && $this->input->LA(1)<=$this->getToken('55295'))||($this->input->LA(1)>=$this->getToken('63744') && $this->input->LA(1)<=$this->getToken('64975'))||($this->input->LA(1)>=$this->getToken('65008') && $this->input->LA(1)<=$this->getToken('65533')) ) {
            	        $this->input->consume();

            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;

            	default :
            	    break 2;//loop8;
                }
            } while (true);


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "VARNAME"

    // $ANTLR start "PN_CHARS"
    function mPN_CHARS(){
        try {
            // Iri.g:226:5: ( PN_CHARS_U | MINUS | DIGIT | '\\u00B7' | '\\u0300' .. '\\u036F' | '\\u203F' .. '\\u2040' ) 
            // Iri.g: 
            {
            if ( $this->input->LA(1)==$this->getToken('45')||($this->input->LA(1)>=$this->getToken('48') && $this->input->LA(1)<=$this->getToken('57'))||($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||$this->input->LA(1)==$this->getToken('183')||($this->input->LA(1)>=$this->getToken('192') && $this->input->LA(1)<=$this->getToken('214'))||($this->input->LA(1)>=$this->getToken('216') && $this->input->LA(1)<=$this->getToken('246'))||($this->input->LA(1)>=$this->getToken('248') && $this->input->LA(1)<=$this->getToken('893'))||($this->input->LA(1)>=$this->getToken('895') && $this->input->LA(1)<=$this->getToken('8191'))||($this->input->LA(1)>=$this->getToken('8204') && $this->input->LA(1)<=$this->getToken('8205'))||($this->input->LA(1)>=$this->getToken('8255') && $this->input->LA(1)<=$this->getToken('8256'))||($this->input->LA(1)>=$this->getToken('8304') && $this->input->LA(1)<=$this->getToken('8591'))||($this->input->LA(1)>=$this->getToken('11264') && $this->input->LA(1)<=$this->getToken('12271'))||($this->input->LA(1)>=$this->getToken('12289') && $this->input->LA(1)<=$this->getToken('55295'))||($this->input->LA(1)>=$this->getToken('63744') && $this->input->LA(1)<=$this->getToken('64975'))||($this->input->LA(1)>=$this->getToken('65008') && $this->input->LA(1)<=$this->getToken('65533')) ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PN_CHARS"

    // $ANTLR start "SEMICOLON"
    function mSEMICOLON(){
        try {
            $_type = Iri::$SEMICOLON;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:236:5: ( ';' ) 
            // Iri.g:236:7: ';' 
            {
            $this->matchChar(59); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "SEMICOLON"

    // $ANTLR start "DOT"
    function mDOT(){
        try {
            $_type = Iri::$DOT;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:240:5: ( '.' ) 
            // Iri.g:240:7: '.' 
            {
            $this->matchChar(46); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DOT"

    // $ANTLR start "PLUS"
    function mPLUS(){
        try {
            $_type = Iri::$PLUS;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:244:5: ( '+' ) 
            // Iri.g:244:7: '+' 
            {
            $this->matchChar(43); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PLUS"

    // $ANTLR start "MINUS"
    function mMINUS(){
        try {
            $_type = Iri::$MINUS;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:248:5: ( '-' ) 
            // Iri.g:248:7: '-' 
            {
            $this->matchChar(45); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "MINUS"

    // $ANTLR start "ASTERISK"
    function mASTERISK(){
        try {
            $_type = Iri::$ASTERISK;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:252:5: ( '*' ) 
            // Iri.g:252:7: '*' 
            {
            $this->matchChar(42); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ASTERISK"

    // $ANTLR start "COMMA"
    function mCOMMA(){
        try {
            $_type = Iri::$COMMA;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:256:5: ( ',' ) 
            // Iri.g:256:7: ',' 
            {
            $this->matchChar(44); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "COMMA"

    // $ANTLR start "NOT"
    function mNOT(){
        try {
            $_type = Iri::$NOT;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:260:5: ( '!' ) 
            // Iri.g:260:7: '!' 
            {
            $this->matchChar(33); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "NOT"

    // $ANTLR start "DIVIDE"
    function mDIVIDE(){
        try {
            $_type = Iri::$DIVIDE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:263:5: ( '/' ) 
            // Iri.g:263:7: '/' 
            {
            $this->matchChar(47); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DIVIDE"

    // $ANTLR start "EQUAL"
    function mEQUAL(){
        try {
            $_type = Iri::$EQUAL;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:267:5: ( '=' ) 
            // Iri.g:267:7: '=' 
            {
            $this->matchChar(61); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "EQUAL"

    // $ANTLR start "LESS"
    function mLESS(){
        try {
            $_type = Iri::$LESS;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:271:2: ( '<' ) 
            // Iri.g:271:4: '<' 
            {
            $this->matchChar(60); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LESS"

    // $ANTLR start "GREATER"
    function mGREATER(){
        try {
            $_type = Iri::$GREATER;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:275:2: ( '>' ) 
            // Iri.g:275:4: '>' 
            {
            $this->matchChar(62); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "GREATER"

    // $ANTLR start "OPEN_CURLY_BRACE"
    function mOPEN_CURLY_BRACE(){
        try {
            $_type = Iri::$OPEN_CURLY_BRACE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:279:2: ( '{' ) 
            // Iri.g:279:4: '{' 
            {
            $this->matchChar(123); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "OPEN_CURLY_BRACE"

    // $ANTLR start "CLOSE_CURLY_BRACE"
    function mCLOSE_CURLY_BRACE(){
        try {
            $_type = Iri::$CLOSE_CURLY_BRACE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:282:2: ( '}' ) 
            // Iri.g:282:4: '}' 
            {
            $this->matchChar(125); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "CLOSE_CURLY_BRACE"

    // $ANTLR start "VAR1"
    function mVAR1(){
        try {
            $_type = Iri::$VAR1;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            $v=null;

            // Iri.g:286:6: ( '?' v= VARNAME ) 
            // Iri.g:286:8: '?' v= VARNAME 
            {
            $this->matchChar(63); 
            $vStart2332 = $this->getCharIndex();
            $this->mVARNAME(); 
            $v = new CommonToken($this->input, TokenConst::$INVALID_TOKEN_TYPE, TokenConst::$DEFAULT_CHANNEL, $vStart2332, $this->getCharIndex()-1);
              $this->setText(($v!=null?$v->getText():null)); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "VAR1"

    // $ANTLR start "VAR2"
    function mVAR2(){
        try {
            $_type = Iri::$VAR2;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            $v=null;

            // Iri.g:290:6: ( '$' v= VARNAME ) 
            // Iri.g:290:8: '$' v= VARNAME 
            {
            $this->matchChar(36); 
            $vStart2358 = $this->getCharIndex();
            $this->mVARNAME(); 
            $v = new CommonToken($this->input, TokenConst::$INVALID_TOKEN_TYPE, TokenConst::$DEFAULT_CHANNEL, $vStart2358, $this->getCharIndex()-1);
              $this->setText(($v!=null?$v->getText():null)); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "VAR2"

    // $ANTLR start "STRING_LITERAL1"
    function mSTRING_LITERAL1(){
        try {
            $_type = Iri::$STRING_LITERAL1;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:294:7: ( '\\'' ( options {greedy=false; } : ~ ( '\\u0027' | '\\u005C' | '\\u000A' | '\\u000D' ) | ECHAR )* '\\'' ) 
            // Iri.g:294:9: '\\'' ( options {greedy=false; } : ~ ( '\\u0027' | '\\u005C' | '\\u000A' | '\\u000D' ) | ECHAR )* '\\'' 
            {
            $this->matchChar(39); 
            // Iri.g:294:14: ( options {greedy=false; } : ~ ( '\\u0027' | '\\u005C' | '\\u000A' | '\\u000D' ) | ECHAR )* 
            //loop9:
            do {
                $alt9=3;
                $LA9_0 = $this->input->LA(1);

                if ( (($LA9_0>=$this->getToken('0') && $LA9_0<=$this->getToken('9'))||($LA9_0>=$this->getToken('11') && $LA9_0<=$this->getToken('12'))||($LA9_0>=$this->getToken('14') && $LA9_0<=$this->getToken('38'))||($LA9_0>=$this->getToken('40') && $LA9_0<=$this->getToken('91'))||($LA9_0>=$this->getToken('93') && $LA9_0<=$this->getToken('65535'))) ) {
                    $alt9=1;
                }
                else if ( ($LA9_0==$this->getToken('92')) ) {
                    $alt9=2;
                }
                else if ( ($LA9_0==$this->getToken('39')) ) {
                    $alt9=3;
                }


                switch ($alt9) {
            	case 1 :
            	    // Iri.g:294:42: ~ ( '\\u0027' | '\\u005C' | '\\u000A' | '\\u000D' ) 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('9'))||($this->input->LA(1)>=$this->getToken('11') && $this->input->LA(1)<=$this->getToken('12'))||($this->input->LA(1)>=$this->getToken('14') && $this->input->LA(1)<=$this->getToken('38'))||($this->input->LA(1)>=$this->getToken('40') && $this->input->LA(1)<=$this->getToken('91'))||($this->input->LA(1)>=$this->getToken('93') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;
            	case 2 :
            	    // Iri.g:294:89: ECHAR 
            	    {
            	    $this->mECHAR(); 

            	    }
            	    break;

            	default :
            	    break 2;//loop9;
                }
            } while (true);

            $this->matchChar(39); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "STRING_LITERAL1"

    // $ANTLR start "STRING_LITERAL2"
    function mSTRING_LITERAL2(){
        try {
            $_type = Iri::$STRING_LITERAL2;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:298:7: ( '\"' ( options {greedy=false; } : ~ ( '\\u0022' | '\\u005C' | '\\u000A' | '\\u000D' ) | ECHAR )* '\"' ) 
            // Iri.g:298:9: '\"' ( options {greedy=false; } : ~ ( '\\u0022' | '\\u005C' | '\\u000A' | '\\u000D' ) | ECHAR )* '\"' 
            {
            $this->matchChar(34); 
            // Iri.g:298:14: ( options {greedy=false; } : ~ ( '\\u0022' | '\\u005C' | '\\u000A' | '\\u000D' ) | ECHAR )* 
            //loop10:
            do {
                $alt10=3;
                $LA10_0 = $this->input->LA(1);

                if ( (($LA10_0>=$this->getToken('0') && $LA10_0<=$this->getToken('9'))||($LA10_0>=$this->getToken('11') && $LA10_0<=$this->getToken('12'))||($LA10_0>=$this->getToken('14') && $LA10_0<=$this->getToken('33'))||($LA10_0>=$this->getToken('35') && $LA10_0<=$this->getToken('91'))||($LA10_0>=$this->getToken('93') && $LA10_0<=$this->getToken('65535'))) ) {
                    $alt10=1;
                }
                else if ( ($LA10_0==$this->getToken('92')) ) {
                    $alt10=2;
                }
                else if ( ($LA10_0==$this->getToken('34')) ) {
                    $alt10=3;
                }


                switch ($alt10) {
            	case 1 :
            	    // Iri.g:298:42: ~ ( '\\u0022' | '\\u005C' | '\\u000A' | '\\u000D' ) 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('9'))||($this->input->LA(1)>=$this->getToken('11') && $this->input->LA(1)<=$this->getToken('12'))||($this->input->LA(1)>=$this->getToken('14') && $this->input->LA(1)<=$this->getToken('33'))||($this->input->LA(1)>=$this->getToken('35') && $this->input->LA(1)<=$this->getToken('91'))||($this->input->LA(1)>=$this->getToken('93') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	        $this->input->consume();

            	    }
            	    else {
            	        $mse = new MismatchedSetException(null,$this->input);
            	        $this->recover($mse);
            	        throw $mse;}


            	    }
            	    break;
            	case 2 :
            	    // Iri.g:298:89: ECHAR 
            	    {
            	    $this->mECHAR(); 

            	    }
            	    break;

            	default :
            	    break 2;//loop10;
                }
            } while (true);

            $this->matchChar(34); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "STRING_LITERAL2"

    // $ANTLR start "STRING_LITERAL_LONG1"
    function mSTRING_LITERAL_LONG1(){
        try {
            $_type = Iri::$STRING_LITERAL_LONG1;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:302:7: ( '\\'\\'\\'' ( options {greedy=false; } : ( '\\'' | '\\'\\'' )? (~ ( '\\'' | '\\\\' ) | ECHAR ) )* '\\'\\'\\'' ) 
            // Iri.g:302:11: '\\'\\'\\'' ( options {greedy=false; } : ( '\\'' | '\\'\\'' )? (~ ( '\\'' | '\\\\' ) | ECHAR ) )* '\\'\\'\\'' 
            {
            $this->matchString("'''"); 

            // Iri.g:302:20: ( options {greedy=false; } : ( '\\'' | '\\'\\'' )? (~ ( '\\'' | '\\\\' ) | ECHAR ) )* 
            //loop13:
            do {
                $alt13=2;
                $LA13_0 = $this->input->LA(1);

                if ( ($LA13_0==$this->getToken('39')) ) {
                    $LA13_1 = $this->input->LA(2);

                    if ( ($LA13_1==$this->getToken('39')) ) {
                        $LA13_3 = $this->input->LA(3);

                        if ( ($LA13_3==$this->getToken('39')) ) {
                            $alt13=2;
                        }
                        else if ( (($LA13_3>=$this->getToken('0') && $LA13_3<=$this->getToken('38'))||($LA13_3>=$this->getToken('40') && $LA13_3<=$this->getToken('65535'))) ) {
                            $alt13=1;
                        }


                    }
                    else if ( (($LA13_1>=$this->getToken('0') && $LA13_1<=$this->getToken('38'))||($LA13_1>=$this->getToken('40') && $LA13_1<=$this->getToken('65535'))) ) {
                        $alt13=1;
                    }


                }
                else if ( (($LA13_0>=$this->getToken('0') && $LA13_0<=$this->getToken('38'))||($LA13_0>=$this->getToken('40') && $LA13_0<=$this->getToken('65535'))) ) {
                    $alt13=1;
                }


                switch ($alt13) {
            	case 1 :
            	    // Iri.g:302:48: ( '\\'' | '\\'\\'' )? (~ ( '\\'' | '\\\\' ) | ECHAR ) 
            	    {
            	    // Iri.g:302:48: ( '\\'' | '\\'\\'' )? 
            	    $alt11=3;
            	    $LA11_0 = $this->input->LA(1);

            	    if ( ($LA11_0==$this->getToken('39')) ) {
            	        $LA11_1 = $this->input->LA(2);

            	        if ( ($LA11_1==$this->getToken('39')) ) {
            	            $alt11=2;
            	        }
            	        else if ( (($LA11_1>=$this->getToken('0') && $LA11_1<=$this->getToken('38'))||($LA11_1>=$this->getToken('40') && $LA11_1<=$this->getToken('65535'))) ) {
            	            $alt11=1;
            	        }
            	    }
            	    switch ($alt11) {
            	        case 1 :
            	            // Iri.g:302:50: '\\'' 
            	            {
            	            $this->matchChar(39); 

            	            }
            	            break;
            	        case 2 :
            	            // Iri.g:302:57: '\\'\\'' 
            	            {
            	            $this->matchString("''"); 


            	            }
            	            break;

            	    }

            	    // Iri.g:302:67: (~ ( '\\'' | '\\\\' ) | ECHAR ) 
            	    $alt12=2;
            	    $LA12_0 = $this->input->LA(1);

            	    if ( (($LA12_0>=$this->getToken('0') && $LA12_0<=$this->getToken('38'))||($LA12_0>=$this->getToken('40') && $LA12_0<=$this->getToken('91'))||($LA12_0>=$this->getToken('93') && $LA12_0<=$this->getToken('65535'))) ) {
            	        $alt12=1;
            	    }
            	    else if ( ($LA12_0==$this->getToken('92')) ) {
            	        $alt12=2;
            	    }
            	    else {
            	        $nvae = new NoViableAltException("", 12, 0, $this->input);

            	        throw $nvae;
            	    }
            	    switch ($alt12) {
            	        case 1 :
            	            // Iri.g:302:69: ~ ( '\\'' | '\\\\' ) 
            	            {
            	            if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('38'))||($this->input->LA(1)>=$this->getToken('40') && $this->input->LA(1)<=$this->getToken('91'))||($this->input->LA(1)>=$this->getToken('93') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	                $this->input->consume();

            	            }
            	            else {
            	                $mse = new MismatchedSetException(null,$this->input);
            	                $this->recover($mse);
            	                throw $mse;}


            	            }
            	            break;
            	        case 2 :
            	            // Iri.g:302:84: ECHAR 
            	            {
            	            $this->mECHAR(); 

            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop13;
                }
            } while (true);

            $this->matchString("'''"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "STRING_LITERAL_LONG1"

    // $ANTLR start "STRING_LITERAL_LONG2"
    function mSTRING_LITERAL_LONG2(){
        try {
            $_type = Iri::$STRING_LITERAL_LONG2;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:306:7: ( '\"\"\"' ( options {greedy=false; } : ( '\"' | '\"\"' )? (~ ( '\"' | '\\\\' ) | ECHAR ) )* '\"\"\"' ) 
            // Iri.g:306:11: '\"\"\"' ( options {greedy=false; } : ( '\"' | '\"\"' )? (~ ( '\"' | '\\\\' ) | ECHAR ) )* '\"\"\"' 
            {
            $this->matchString("\"\"\""); 

            // Iri.g:306:17: ( options {greedy=false; } : ( '\"' | '\"\"' )? (~ ( '\"' | '\\\\' ) | ECHAR ) )* 
            //loop16:
            do {
                $alt16=2;
                $LA16_0 = $this->input->LA(1);

                if ( ($LA16_0==$this->getToken('34')) ) {
                    $LA16_1 = $this->input->LA(2);

                    if ( ($LA16_1==$this->getToken('34')) ) {
                        $LA16_3 = $this->input->LA(3);

                        if ( ($LA16_3==$this->getToken('34')) ) {
                            $alt16=2;
                        }
                        else if ( (($LA16_3>=$this->getToken('0') && $LA16_3<=$this->getToken('33'))||($LA16_3>=$this->getToken('35') && $LA16_3<=$this->getToken('65535'))) ) {
                            $alt16=1;
                        }


                    }
                    else if ( (($LA16_1>=$this->getToken('0') && $LA16_1<=$this->getToken('33'))||($LA16_1>=$this->getToken('35') && $LA16_1<=$this->getToken('65535'))) ) {
                        $alt16=1;
                    }


                }
                else if ( (($LA16_0>=$this->getToken('0') && $LA16_0<=$this->getToken('33'))||($LA16_0>=$this->getToken('35') && $LA16_0<=$this->getToken('65535'))) ) {
                    $alt16=1;
                }


                switch ($alt16) {
            	case 1 :
            	    // Iri.g:306:45: ( '\"' | '\"\"' )? (~ ( '\"' | '\\\\' ) | ECHAR ) 
            	    {
            	    // Iri.g:306:45: ( '\"' | '\"\"' )? 
            	    $alt14=3;
            	    $LA14_0 = $this->input->LA(1);

            	    if ( ($LA14_0==$this->getToken('34')) ) {
            	        $LA14_1 = $this->input->LA(2);

            	        if ( ($LA14_1==$this->getToken('34')) ) {
            	            $alt14=2;
            	        }
            	        else if ( (($LA14_1>=$this->getToken('0') && $LA14_1<=$this->getToken('33'))||($LA14_1>=$this->getToken('35') && $LA14_1<=$this->getToken('65535'))) ) {
            	            $alt14=1;
            	        }
            	    }
            	    switch ($alt14) {
            	        case 1 :
            	            // Iri.g:306:47: '\"' 
            	            {
            	            $this->matchChar(34); 

            	            }
            	            break;
            	        case 2 :
            	            // Iri.g:306:53: '\"\"' 
            	            {
            	            $this->matchString("\"\""); 


            	            }
            	            break;

            	    }

            	    // Iri.g:306:61: (~ ( '\"' | '\\\\' ) | ECHAR ) 
            	    $alt15=2;
            	    $LA15_0 = $this->input->LA(1);

            	    if ( (($LA15_0>=$this->getToken('0') && $LA15_0<=$this->getToken('33'))||($LA15_0>=$this->getToken('35') && $LA15_0<=$this->getToken('91'))||($LA15_0>=$this->getToken('93') && $LA15_0<=$this->getToken('65535'))) ) {
            	        $alt15=1;
            	    }
            	    else if ( ($LA15_0==$this->getToken('92')) ) {
            	        $alt15=2;
            	    }
            	    else {
            	        $nvae = new NoViableAltException("", 15, 0, $this->input);

            	        throw $nvae;
            	    }
            	    switch ($alt15) {
            	        case 1 :
            	            // Iri.g:306:63: ~ ( '\"' | '\\\\' ) 
            	            {
            	            if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('33'))||($this->input->LA(1)>=$this->getToken('35') && $this->input->LA(1)<=$this->getToken('91'))||($this->input->LA(1)>=$this->getToken('93') && $this->input->LA(1)<=$this->getToken('65535')) ) {
            	                $this->input->consume();

            	            }
            	            else {
            	                $mse = new MismatchedSetException(null,$this->input);
            	                $this->recover($mse);
            	                throw $mse;}


            	            }
            	            break;
            	        case 2 :
            	            // Iri.g:306:77: ECHAR 
            	            {
            	            $this->mECHAR(); 

            	            }
            	            break;

            	    }


            	    }
            	    break;

            	default :
            	    break 2;//loop16;
                }
            } while (true);

            $this->matchString("\"\"\""); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "STRING_LITERAL_LONG2"

    // $ANTLR start "ECHAR"
    function mECHAR(){
        try {
            // Iri.g:311:7: ( '\\\\' ( 't' | 'b' | 'n' | 'r' | 'f' | '\\\\' | '\"' | '\\'' ) ) 
            // Iri.g:311:9: '\\\\' ( 't' | 'b' | 'n' | 'r' | 'f' | '\\\\' | '\"' | '\\'' ) 
            {
            $this->matchChar(92); 
            if ( $this->input->LA(1)==$this->getToken('34')||$this->input->LA(1)==$this->getToken('39')||$this->input->LA(1)==$this->getToken('92')||$this->input->LA(1)==$this->getToken('98')||$this->input->LA(1)==$this->getToken('102')||$this->input->LA(1)==$this->getToken('110')||$this->input->LA(1)==$this->getToken('114')||$this->input->LA(1)==$this->getToken('116') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ECHAR"

    // $ANTLR start "OPEN_BRACE"
    function mOPEN_BRACE(){
        try {
            $_type = Iri::$OPEN_BRACE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:315:8: ( '(' ) 
            // Iri.g:315:10: '(' 
            {
            $this->matchChar(40); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "OPEN_BRACE"

    // $ANTLR start "CLOSE_BRACE"
    function mCLOSE_BRACE(){
        try {
            $_type = Iri::$CLOSE_BRACE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:319:8: ( ')' ) 
            // Iri.g:319:10: ')' 
            {
            $this->matchChar(41); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "CLOSE_BRACE"

    // $ANTLR start "REFERENCE"
    function mREFERENCE(){
        try {
            // Iri.g:323:9: ( '^^' ) 
            // Iri.g:323:11: '^^' 
            {
            $this->matchString("^^"); 


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "REFERENCE"

    // $ANTLR start "LESS_EQUAL"
    function mLESS_EQUAL(){
        try {
            // Iri.g:327:9: ( '<=' ) 
            // Iri.g:327:11: '<=' 
            {
            $this->matchString("<="); 


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LESS_EQUAL"

    // $ANTLR start "GREATER_EQUAL"
    function mGREATER_EQUAL(){
        try {
            // Iri.g:331:9: ( '>=' ) 
            // Iri.g:331:11: '>=' 
            {
            $this->matchString(">="); 


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "GREATER_EQUAL"

    // $ANTLR start "NOT_EQUAL"
    function mNOT_EQUAL(){
        try {
            // Iri.g:335:9: ( '!=' ) 
            // Iri.g:335:11: '!=' 
            {
            $this->matchString("!="); 


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "NOT_EQUAL"

    // $ANTLR start "AND"
    function mAND(){
        try {
            // Iri.g:339:9: ( '&&' ) 
            // Iri.g:339:11: '&&' 
            {
            $this->matchString("&&"); 


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "AND"

    // $ANTLR start "OR"
    function mOR(){
        try {
            // Iri.g:343:9: ( '||' ) 
            // Iri.g:343:11: '||' 
            {
            $this->matchString("||"); 


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "OR"

    // $ANTLR start "BLANK_NODE_LABEL"
    function mBLANK_NODE_LABEL(){
        try {
            $_type = Iri::$BLANK_NODE_LABEL;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            $t=null;

            // Iri.g:347:5: ( '_:' t= PN_LOCAL ) 
            // Iri.g:347:7: '_:' t= PN_LOCAL 
            {
            $this->matchString("_:"); 

            $tStart2928 = $this->getCharIndex();
            $this->mPN_LOCAL(); 
            $t = new CommonToken($this->input, TokenConst::$INVALID_TOKEN_TYPE, TokenConst::$DEFAULT_CHANNEL, $tStart2928, $this->getCharIndex()-1);
              $this->setText(($t!=null?$t->getText():null)); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "BLANK_NODE_LABEL"

    // $ANTLR start "LANGTAG"
    function mLANGTAG(){
        try {
            $_type = Iri::$LANGTAG;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:350:5: ( '@' ( PN_CHARS_BASE )+ ( MINUS ( PN_CHARS_BASE DIGIT )+ )* ) 
            // Iri.g:350:7: '@' ( PN_CHARS_BASE )+ ( MINUS ( PN_CHARS_BASE DIGIT )+ )* 
            {
            $this->matchChar(64); 
            // Iri.g:350:11: ( PN_CHARS_BASE )+ 
            $cnt17=0;
            //loop17:
            do {
                $alt17=2;
                $LA17_0 = $this->input->LA(1);

                if ( (($LA17_0>=$this->getToken('65') && $LA17_0<=$this->getToken('90'))||($LA17_0>=$this->getToken('97') && $LA17_0<=$this->getToken('122'))||($LA17_0>=$this->getToken('192') && $LA17_0<=$this->getToken('214'))||($LA17_0>=$this->getToken('216') && $LA17_0<=$this->getToken('246'))||($LA17_0>=$this->getToken('248') && $LA17_0<=$this->getToken('767'))||($LA17_0>=$this->getToken('880') && $LA17_0<=$this->getToken('893'))||($LA17_0>=$this->getToken('895') && $LA17_0<=$this->getToken('8191'))||($LA17_0>=$this->getToken('8204') && $LA17_0<=$this->getToken('8205'))||($LA17_0>=$this->getToken('8304') && $LA17_0<=$this->getToken('8591'))||($LA17_0>=$this->getToken('11264') && $LA17_0<=$this->getToken('12271'))||($LA17_0>=$this->getToken('12289') && $LA17_0<=$this->getToken('55295'))||($LA17_0>=$this->getToken('63744') && $LA17_0<=$this->getToken('64975'))||($LA17_0>=$this->getToken('65008') && $LA17_0<=$this->getToken('65533'))) ) {
                    $alt17=1;
                }


                switch ($alt17) {
            	case 1 :
            	    // Iri.g:350:11: PN_CHARS_BASE 
            	    {
            	    $this->mPN_CHARS_BASE(); 

            	    }
            	    break;

            	default :
            	    if ( $cnt17 >= 1 ) break 2;//loop17;
                        $eee =
                            new EarlyExitException(17, $this->input);
                        throw $eee;
                }
                $cnt17++;
            } while (true);

            // Iri.g:350:26: ( MINUS ( PN_CHARS_BASE DIGIT )+ )* 
            //loop19:
            do {
                $alt19=2;
                $LA19_0 = $this->input->LA(1);

                if ( ($LA19_0==$this->getToken('45')) ) {
                    $alt19=1;
                }


                switch ($alt19) {
            	case 1 :
            	    // Iri.g:350:27: MINUS ( PN_CHARS_BASE DIGIT )+ 
            	    {
            	    $this->mMINUS(); 
            	    // Iri.g:350:33: ( PN_CHARS_BASE DIGIT )+ 
            	    $cnt18=0;
            	    //loop18:
            	    do {
            	        $alt18=2;
            	        $LA18_0 = $this->input->LA(1);

            	        if ( (($LA18_0>=$this->getToken('65') && $LA18_0<=$this->getToken('90'))||($LA18_0>=$this->getToken('97') && $LA18_0<=$this->getToken('122'))||($LA18_0>=$this->getToken('192') && $LA18_0<=$this->getToken('214'))||($LA18_0>=$this->getToken('216') && $LA18_0<=$this->getToken('246'))||($LA18_0>=$this->getToken('248') && $LA18_0<=$this->getToken('767'))||($LA18_0>=$this->getToken('880') && $LA18_0<=$this->getToken('893'))||($LA18_0>=$this->getToken('895') && $LA18_0<=$this->getToken('8191'))||($LA18_0>=$this->getToken('8204') && $LA18_0<=$this->getToken('8205'))||($LA18_0>=$this->getToken('8304') && $LA18_0<=$this->getToken('8591'))||($LA18_0>=$this->getToken('11264') && $LA18_0<=$this->getToken('12271'))||($LA18_0>=$this->getToken('12289') && $LA18_0<=$this->getToken('55295'))||($LA18_0>=$this->getToken('63744') && $LA18_0<=$this->getToken('64975'))||($LA18_0>=$this->getToken('65008') && $LA18_0<=$this->getToken('65533'))) ) {
            	            $alt18=1;
            	        }


            	        switch ($alt18) {
            	    	case 1 :
            	    	    // Iri.g:350:34: PN_CHARS_BASE DIGIT 
            	    	    {
            	    	    $this->mPN_CHARS_BASE(); 
            	    	    $this->mDIGIT(); 

            	    	    }
            	    	    break;

            	    	default :
            	    	    if ( $cnt18 >= 1 ) break 2;//loop18;
            	                $eee =
            	                    new EarlyExitException(18, $this->input);
            	                throw $eee;
            	        }
            	        $cnt18++;
            	    } while (true);


            	    }
            	    break;

            	default :
            	    break 2;//loop19;
                }
            } while (true);


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LANGTAG"

    // $ANTLR start "INTEGER"
    function mINTEGER(){
        try {
            $_type = Iri::$INTEGER;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:356:6: ( ( DIGIT )+ ) 
            // Iri.g:356:8: ( DIGIT )+ 
            {
            // Iri.g:356:8: ( DIGIT )+ 
            $cnt20=0;
            //loop20:
            do {
                $alt20=2;
                $LA20_0 = $this->input->LA(1);

                if ( (($LA20_0>=$this->getToken('48') && $LA20_0<=$this->getToken('57'))) ) {
                    $alt20=1;
                }


                switch ($alt20) {
            	case 1 :
            	    // Iri.g:356:8: DIGIT 
            	    {
            	    $this->mDIGIT(); 

            	    }
            	    break;

            	default :
            	    if ( $cnt20 >= 1 ) break 2;//loop20;
                        $eee =
                            new EarlyExitException(20, $this->input);
                        throw $eee;
                }
                $cnt20++;
            } while (true);


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "INTEGER"

    // $ANTLR start "DECIMAL"
    function mDECIMAL(){
        try {
            $_type = Iri::$DECIMAL;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:360:6: ( ( DIGIT )+ DOT ( DIGIT )* | DOT ( DIGIT )+ ) 
            $alt24=2;
            $LA24_0 = $this->input->LA(1);

            if ( (($LA24_0>=$this->getToken('48') && $LA24_0<=$this->getToken('57'))) ) {
                $alt24=1;
            }
            else if ( ($LA24_0==$this->getToken('46')) ) {
                $alt24=2;
            }
            else {
                $nvae = new NoViableAltException("", 24, 0, $this->input);

                throw $nvae;
            }
            switch ($alt24) {
                case 1 :
                    // Iri.g:360:8: ( DIGIT )+ DOT ( DIGIT )* 
                    {
                    // Iri.g:360:8: ( DIGIT )+ 
                    $cnt21=0;
                    //loop21:
                    do {
                        $alt21=2;
                        $LA21_0 = $this->input->LA(1);

                        if ( (($LA21_0>=$this->getToken('48') && $LA21_0<=$this->getToken('57'))) ) {
                            $alt21=1;
                        }


                        switch ($alt21) {
                    	case 1 :
                    	    // Iri.g:360:8: DIGIT 
                    	    {
                    	    $this->mDIGIT(); 

                    	    }
                    	    break;

                    	default :
                    	    if ( $cnt21 >= 1 ) break 2;//loop21;
                                $eee =
                                    new EarlyExitException(21, $this->input);
                                throw $eee;
                        }
                        $cnt21++;
                    } while (true);

                    $this->mDOT(); 
                    // Iri.g:360:19: ( DIGIT )* 
                    //loop22:
                    do {
                        $alt22=2;
                        $LA22_0 = $this->input->LA(1);

                        if ( (($LA22_0>=$this->getToken('48') && $LA22_0<=$this->getToken('57'))) ) {
                            $alt22=1;
                        }


                        switch ($alt22) {
                    	case 1 :
                    	    // Iri.g:360:19: DIGIT 
                    	    {
                    	    $this->mDIGIT(); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop22;
                        }
                    } while (true);


                    }
                    break;
                case 2 :
                    // Iri.g:361:8: DOT ( DIGIT )+ 
                    {
                    $this->mDOT(); 
                    // Iri.g:361:12: ( DIGIT )+ 
                    $cnt23=0;
                    //loop23:
                    do {
                        $alt23=2;
                        $LA23_0 = $this->input->LA(1);

                        if ( (($LA23_0>=$this->getToken('48') && $LA23_0<=$this->getToken('57'))) ) {
                            $alt23=1;
                        }


                        switch ($alt23) {
                    	case 1 :
                    	    // Iri.g:361:12: DIGIT 
                    	    {
                    	    $this->mDIGIT(); 

                    	    }
                    	    break;

                    	default :
                    	    if ( $cnt23 >= 1 ) break 2;//loop23;
                                $eee =
                                    new EarlyExitException(23, $this->input);
                                throw $eee;
                        }
                        $cnt23++;
                    } while (true);


                    }
                    break;

            }
            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DECIMAL"

    // $ANTLR start "DOUBLE"
    function mDOUBLE(){
        try {
            $_type = Iri::$DOUBLE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:365:6: ( ( DIGIT )+ DOT ( DIGIT )* EXPONENT | DOT ( DIGIT )+ EXPONENT | ( DIGIT )+ EXPONENT ) 
            $alt29=3;
            $alt29 = $this->dfa29->predict($this->input);
            switch ($alt29) {
                case 1 :
                    // Iri.g:365:8: ( DIGIT )+ DOT ( DIGIT )* EXPONENT 
                    {
                    // Iri.g:365:8: ( DIGIT )+ 
                    $cnt25=0;
                    //loop25:
                    do {
                        $alt25=2;
                        $LA25_0 = $this->input->LA(1);

                        if ( (($LA25_0>=$this->getToken('48') && $LA25_0<=$this->getToken('57'))) ) {
                            $alt25=1;
                        }


                        switch ($alt25) {
                    	case 1 :
                    	    // Iri.g:365:8: DIGIT 
                    	    {
                    	    $this->mDIGIT(); 

                    	    }
                    	    break;

                    	default :
                    	    if ( $cnt25 >= 1 ) break 2;//loop25;
                                $eee =
                                    new EarlyExitException(25, $this->input);
                                throw $eee;
                        }
                        $cnt25++;
                    } while (true);

                    $this->mDOT(); 
                    // Iri.g:365:19: ( DIGIT )* 
                    //loop26:
                    do {
                        $alt26=2;
                        $LA26_0 = $this->input->LA(1);

                        if ( (($LA26_0>=$this->getToken('48') && $LA26_0<=$this->getToken('57'))) ) {
                            $alt26=1;
                        }


                        switch ($alt26) {
                    	case 1 :
                    	    // Iri.g:365:19: DIGIT 
                    	    {
                    	    $this->mDIGIT(); 

                    	    }
                    	    break;

                    	default :
                    	    break 2;//loop26;
                        }
                    } while (true);

                    $this->mEXPONENT(); 

                    }
                    break;
                case 2 :
                    // Iri.g:366:8: DOT ( DIGIT )+ EXPONENT 
                    {
                    $this->mDOT(); 
                    // Iri.g:366:12: ( DIGIT )+ 
                    $cnt27=0;
                    //loop27:
                    do {
                        $alt27=2;
                        $LA27_0 = $this->input->LA(1);

                        if ( (($LA27_0>=$this->getToken('48') && $LA27_0<=$this->getToken('57'))) ) {
                            $alt27=1;
                        }


                        switch ($alt27) {
                    	case 1 :
                    	    // Iri.g:366:12: DIGIT 
                    	    {
                    	    $this->mDIGIT(); 

                    	    }
                    	    break;

                    	default :
                    	    if ( $cnt27 >= 1 ) break 2;//loop27;
                                $eee =
                                    new EarlyExitException(27, $this->input);
                                throw $eee;
                        }
                        $cnt27++;
                    } while (true);

                    $this->mEXPONENT(); 

                    }
                    break;
                case 3 :
                    // Iri.g:367:8: ( DIGIT )+ EXPONENT 
                    {
                    // Iri.g:367:8: ( DIGIT )+ 
                    $cnt28=0;
                    //loop28:
                    do {
                        $alt28=2;
                        $LA28_0 = $this->input->LA(1);

                        if ( (($LA28_0>=$this->getToken('48') && $LA28_0<=$this->getToken('57'))) ) {
                            $alt28=1;
                        }


                        switch ($alt28) {
                    	case 1 :
                    	    // Iri.g:367:8: DIGIT 
                    	    {
                    	    $this->mDIGIT(); 

                    	    }
                    	    break;

                    	default :
                    	    if ( $cnt28 >= 1 ) break 2;//loop28;
                                $eee =
                                    new EarlyExitException(28, $this->input);
                                throw $eee;
                        }
                        $cnt28++;
                    } while (true);

                    $this->mEXPONENT(); 

                    }
                    break;

            }
            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DOUBLE"

    // $ANTLR start "INTEGER_POSITIVE"
    function mINTEGER_POSITIVE(){
        try {
            $_type = Iri::$INTEGER_POSITIVE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:371:6: ( PLUS INTEGER ) 
            // Iri.g:371:8: PLUS INTEGER 
            {
            $this->mPLUS(); 
            $this->mINTEGER(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "INTEGER_POSITIVE"

    // $ANTLR start "DECIMAL_POSITIVE"
    function mDECIMAL_POSITIVE(){
        try {
            $_type = Iri::$DECIMAL_POSITIVE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:375:6: ( PLUS DECIMAL ) 
            // Iri.g:375:8: PLUS DECIMAL 
            {
            $this->mPLUS(); 
            $this->mDECIMAL(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DECIMAL_POSITIVE"

    // $ANTLR start "DOUBLE_POSITIVE"
    function mDOUBLE_POSITIVE(){
        try {
            $_type = Iri::$DOUBLE_POSITIVE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:379:6: ( PLUS DOUBLE ) 
            // Iri.g:379:8: PLUS DOUBLE 
            {
            $this->mPLUS(); 
            $this->mDOUBLE(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DOUBLE_POSITIVE"

    // $ANTLR start "INTEGER_NEGATIVE"
    function mINTEGER_NEGATIVE(){
        try {
            $_type = Iri::$INTEGER_NEGATIVE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:383:6: ( MINUS INTEGER ) 
            // Iri.g:383:8: MINUS INTEGER 
            {
            $this->mMINUS(); 
            $this->mINTEGER(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "INTEGER_NEGATIVE"

    // $ANTLR start "DECIMAL_NEGATIVE"
    function mDECIMAL_NEGATIVE(){
        try {
            $_type = Iri::$DECIMAL_NEGATIVE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:387:6: ( MINUS DECIMAL ) 
            // Iri.g:387:8: MINUS DECIMAL 
            {
            $this->mMINUS(); 
            $this->mDECIMAL(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DECIMAL_NEGATIVE"

    // $ANTLR start "DOUBLE_NEGATIVE"
    function mDOUBLE_NEGATIVE(){
        try {
            $_type = Iri::$DOUBLE_NEGATIVE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:391:6: ( MINUS DOUBLE ) 
            // Iri.g:391:8: MINUS DOUBLE 
            {
            $this->mMINUS(); 
            $this->mDOUBLE(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DOUBLE_NEGATIVE"

    // $ANTLR start "EXPONENT"
    function mEXPONENT(){
        try {
            // Iri.g:396:6: ( ( 'e' | 'E' ) ( PLUS | MINUS )? ( DIGIT )+ ) 
            // Iri.g:396:8: ( 'e' | 'E' ) ( PLUS | MINUS )? ( DIGIT )+ 
            {
            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            // Iri.g:396:18: ( PLUS | MINUS )? 
            $alt30=2;
            $LA30_0 = $this->input->LA(1);

            if ( ($LA30_0==$this->getToken('43')||$LA30_0==$this->getToken('45')) ) {
                $alt30=1;
            }
            switch ($alt30) {
                case 1 :
                    // Iri.g: 
                    {
                    if ( $this->input->LA(1)==$this->getToken('43')||$this->input->LA(1)==$this->getToken('45') ) {
                        $this->input->consume();

                    }
                    else {
                        $mse = new MismatchedSetException(null,$this->input);
                        $this->recover($mse);
                        throw $mse;}


                    }
                    break;

            }

            // Iri.g:396:32: ( DIGIT )+ 
            $cnt31=0;
            //loop31:
            do {
                $alt31=2;
                $LA31_0 = $this->input->LA(1);

                if ( (($LA31_0>=$this->getToken('48') && $LA31_0<=$this->getToken('57'))) ) {
                    $alt31=1;
                }


                switch ($alt31) {
            	case 1 :
            	    // Iri.g:396:32: DIGIT 
            	    {
            	    $this->mDIGIT(); 

            	    }
            	    break;

            	default :
            	    if ( $cnt31 >= 1 ) break 2;//loop31;
                        $eee =
                            new EarlyExitException(31, $this->input);
                        throw $eee;
                }
                $cnt31++;
            } while (true);


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "EXPONENT"

    // $ANTLR start "OPEN_SQUARE_BRACE"
    function mOPEN_SQUARE_BRACE(){
        try {
            $_type = Iri::$OPEN_SQUARE_BRACE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:400:7: ( '[' ) 
            // Iri.g:400:9: '[' 
            {
            $this->matchChar(91); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "OPEN_SQUARE_BRACE"

    // $ANTLR start "CLOSE_SQUARE_BRACE"
    function mCLOSE_SQUARE_BRACE(){
        try {
            $_type = Iri::$CLOSE_SQUARE_BRACE;
            $_channel = Iri::$DEFAULT_TOKEN_CHANNEL;
            // Iri.g:404:7: ( ']' ) 
            // Iri.g:404:9: ']' 
            {
            $this->matchChar(93); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "CLOSE_SQUARE_BRACE"

    function mTokens(){
        // Iri.g:1:8: ( IRI_REF | WS | BASE | PREFIX | SELECT | DISTINCT | REDUCED | CONSTRUCT | DESCRIBE | ASK | FROM | NAMED | WHERE | ORDER | BY | ASC | DESC | LIMIT | OFFSET | OPTIONAL | GRAPH | UNION | FILTER | A | STR | LANG | LANGMATCHES | DATATYPE | BOUND | SAMETERM | ISIRI | ISURI | ISBLANK | ISLITERAL | REGEX | TRUE | FALSE | PNAME_LN | PNAME_NS | SEMICOLON | DOT | PLUS | MINUS | ASTERISK | COMMA | NOT | DIVIDE | EQUAL | LESS | GREATER | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | VAR1 | VAR2 | STRING_LITERAL1 | STRING_LITERAL2 | STRING_LITERAL_LONG1 | STRING_LITERAL_LONG2 | OPEN_BRACE | CLOSE_BRACE | BLANK_NODE_LABEL | LANGTAG | INTEGER | DECIMAL | DOUBLE | INTEGER_POSITIVE | DECIMAL_POSITIVE | DOUBLE_POSITIVE | INTEGER_NEGATIVE | DECIMAL_NEGATIVE | DOUBLE_NEGATIVE | OPEN_SQUARE_BRACE | CLOSE_SQUARE_BRACE ) 
        $alt32=73;
        $alt32 = $this->dfa32->predict($this->input);
        switch ($alt32) {
            case 1 :
                // Iri.g:1:10: IRI_REF 
                {
                $this->mIRI_REF(); 

                }
                break;
            case 2 :
                // Iri.g:1:18: WS 
                {
                $this->mWS(); 

                }
                break;
            case 3 :
                // Iri.g:1:21: BASE 
                {
                $this->mBASE(); 

                }
                break;
            case 4 :
                // Iri.g:1:26: PREFIX 
                {
                $this->mPREFIX(); 

                }
                break;
            case 5 :
                // Iri.g:1:33: SELECT 
                {
                $this->mSELECT(); 

                }
                break;
            case 6 :
                // Iri.g:1:40: DISTINCT 
                {
                $this->mDISTINCT(); 

                }
                break;
            case 7 :
                // Iri.g:1:49: REDUCED 
                {
                $this->mREDUCED(); 

                }
                break;
            case 8 :
                // Iri.g:1:57: CONSTRUCT 
                {
                $this->mCONSTRUCT(); 

                }
                break;
            case 9 :
                // Iri.g:1:67: DESCRIBE 
                {
                $this->mDESCRIBE(); 

                }
                break;
            case 10 :
                // Iri.g:1:76: ASK 
                {
                $this->mASK(); 

                }
                break;
            case 11 :
                // Iri.g:1:80: FROM 
                {
                $this->mFROM(); 

                }
                break;
            case 12 :
                // Iri.g:1:85: NAMED 
                {
                $this->mNAMED(); 

                }
                break;
            case 13 :
                // Iri.g:1:91: WHERE 
                {
                $this->mWHERE(); 

                }
                break;
            case 14 :
                // Iri.g:1:97: ORDER 
                {
                $this->mORDER(); 

                }
                break;
            case 15 :
                // Iri.g:1:103: BY 
                {
                $this->mBY(); 

                }
                break;
            case 16 :
                // Iri.g:1:106: ASC 
                {
                $this->mASC(); 

                }
                break;
            case 17 :
                // Iri.g:1:110: DESC 
                {
                $this->mDESC(); 

                }
                break;
            case 18 :
                // Iri.g:1:115: LIMIT 
                {
                $this->mLIMIT(); 

                }
                break;
            case 19 :
                // Iri.g:1:121: OFFSET 
                {
                $this->mOFFSET(); 

                }
                break;
            case 20 :
                // Iri.g:1:128: OPTIONAL 
                {
                $this->mOPTIONAL(); 

                }
                break;
            case 21 :
                // Iri.g:1:137: GRAPH 
                {
                $this->mGRAPH(); 

                }
                break;
            case 22 :
                // Iri.g:1:143: UNION 
                {
                $this->mUNION(); 

                }
                break;
            case 23 :
                // Iri.g:1:149: FILTER 
                {
                $this->mFILTER(); 

                }
                break;
            case 24 :
                // Iri.g:1:156: A 
                {
                $this->mA(); 

                }
                break;
            case 25 :
                // Iri.g:1:158: STR 
                {
                $this->mSTR(); 

                }
                break;
            case 26 :
                // Iri.g:1:162: LANG 
                {
                $this->mLANG(); 

                }
                break;
            case 27 :
                // Iri.g:1:167: LANGMATCHES 
                {
                $this->mLANGMATCHES(); 

                }
                break;
            case 28 :
                // Iri.g:1:179: DATATYPE 
                {
                $this->mDATATYPE(); 

                }
                break;
            case 29 :
                // Iri.g:1:188: BOUND 
                {
                $this->mBOUND(); 

                }
                break;
            case 30 :
                // Iri.g:1:194: SAMETERM 
                {
                $this->mSAMETERM(); 

                }
                break;
            case 31 :
                // Iri.g:1:203: ISIRI 
                {
                $this->mISIRI(); 

                }
                break;
            case 32 :
                // Iri.g:1:209: ISURI 
                {
                $this->mISURI(); 

                }
                break;
            case 33 :
                // Iri.g:1:215: ISBLANK 
                {
                $this->mISBLANK(); 

                }
                break;
            case 34 :
                // Iri.g:1:223: ISLITERAL 
                {
                $this->mISLITERAL(); 

                }
                break;
            case 35 :
                // Iri.g:1:233: REGEX 
                {
                $this->mREGEX(); 

                }
                break;
            case 36 :
                // Iri.g:1:239: TRUE 
                {
                $this->mTRUE(); 

                }
                break;
            case 37 :
                // Iri.g:1:244: FALSE 
                {
                $this->mFALSE(); 

                }
                break;
            case 38 :
                // Iri.g:1:250: PNAME_LN 
                {
                $this->mPNAME_LN(); 

                }
                break;
            case 39 :
                // Iri.g:1:259: PNAME_NS 
                {
                $this->mPNAME_NS(); 

                }
                break;
            case 40 :
                // Iri.g:1:268: SEMICOLON 
                {
                $this->mSEMICOLON(); 

                }
                break;
            case 41 :
                // Iri.g:1:278: DOT 
                {
                $this->mDOT(); 

                }
                break;
            case 42 :
                // Iri.g:1:282: PLUS 
                {
                $this->mPLUS(); 

                }
                break;
            case 43 :
                // Iri.g:1:287: MINUS 
                {
                $this->mMINUS(); 

                }
                break;
            case 44 :
                // Iri.g:1:293: ASTERISK 
                {
                $this->mASTERISK(); 

                }
                break;
            case 45 :
                // Iri.g:1:302: COMMA 
                {
                $this->mCOMMA(); 

                }
                break;
            case 46 :
                // Iri.g:1:308: NOT 
                {
                $this->mNOT(); 

                }
                break;
            case 47 :
                // Iri.g:1:312: DIVIDE 
                {
                $this->mDIVIDE(); 

                }
                break;
            case 48 :
                // Iri.g:1:319: EQUAL 
                {
                $this->mEQUAL(); 

                }
                break;
            case 49 :
                // Iri.g:1:325: LESS 
                {
                $this->mLESS(); 

                }
                break;
            case 50 :
                // Iri.g:1:330: GREATER 
                {
                $this->mGREATER(); 

                }
                break;
            case 51 :
                // Iri.g:1:338: OPEN_CURLY_BRACE 
                {
                $this->mOPEN_CURLY_BRACE(); 

                }
                break;
            case 52 :
                // Iri.g:1:355: CLOSE_CURLY_BRACE 
                {
                $this->mCLOSE_CURLY_BRACE(); 

                }
                break;
            case 53 :
                // Iri.g:1:373: VAR1 
                {
                $this->mVAR1(); 

                }
                break;
            case 54 :
                // Iri.g:1:378: VAR2 
                {
                $this->mVAR2(); 

                }
                break;
            case 55 :
                // Iri.g:1:383: STRING_LITERAL1 
                {
                $this->mSTRING_LITERAL1(); 

                }
                break;
            case 56 :
                // Iri.g:1:399: STRING_LITERAL2 
                {
                $this->mSTRING_LITERAL2(); 

                }
                break;
            case 57 :
                // Iri.g:1:415: STRING_LITERAL_LONG1 
                {
                $this->mSTRING_LITERAL_LONG1(); 

                }
                break;
            case 58 :
                // Iri.g:1:436: STRING_LITERAL_LONG2 
                {
                $this->mSTRING_LITERAL_LONG2(); 

                }
                break;
            case 59 :
                // Iri.g:1:457: OPEN_BRACE 
                {
                $this->mOPEN_BRACE(); 

                }
                break;
            case 60 :
                // Iri.g:1:468: CLOSE_BRACE 
                {
                $this->mCLOSE_BRACE(); 

                }
                break;
            case 61 :
                // Iri.g:1:480: BLANK_NODE_LABEL 
                {
                $this->mBLANK_NODE_LABEL(); 

                }
                break;
            case 62 :
                // Iri.g:1:497: LANGTAG 
                {
                $this->mLANGTAG(); 

                }
                break;
            case 63 :
                // Iri.g:1:505: INTEGER 
                {
                $this->mINTEGER(); 

                }
                break;
            case 64 :
                // Iri.g:1:513: DECIMAL 
                {
                $this->mDECIMAL(); 

                }
                break;
            case 65 :
                // Iri.g:1:521: DOUBLE 
                {
                $this->mDOUBLE(); 

                }
                break;
            case 66 :
                // Iri.g:1:528: INTEGER_POSITIVE 
                {
                $this->mINTEGER_POSITIVE(); 

                }
                break;
            case 67 :
                // Iri.g:1:545: DECIMAL_POSITIVE 
                {
                $this->mDECIMAL_POSITIVE(); 

                }
                break;
            case 68 :
                // Iri.g:1:562: DOUBLE_POSITIVE 
                {
                $this->mDOUBLE_POSITIVE(); 

                }
                break;
            case 69 :
                // Iri.g:1:578: INTEGER_NEGATIVE 
                {
                $this->mINTEGER_NEGATIVE(); 

                }
                break;
            case 70 :
                // Iri.g:1:595: DECIMAL_NEGATIVE 
                {
                $this->mDECIMAL_NEGATIVE(); 

                }
                break;
            case 71 :
                // Iri.g:1:612: DOUBLE_NEGATIVE 
                {
                $this->mDOUBLE_NEGATIVE(); 

                }
                break;
            case 72 :
                // Iri.g:1:628: OPEN_SQUARE_BRACE 
                {
                $this->mOPEN_SQUARE_BRACE(); 

                }
                break;
            case 73 :
                // Iri.g:1:646: CLOSE_SQUARE_BRACE 
                {
                $this->mCLOSE_SQUARE_BRACE(); 

                }
                break;

        }

    }



}
?>