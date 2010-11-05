<?php
// $ANTLR 3.1.3 “ˆŽ 06, 2009 18:28:01 ManchesterTokenizer.g 2010-11-05 08:17:52


# for convenience in actions
if (!defined('HIDDEN')) define('HIDDEN', BaseRecognizer::$HIDDEN);

 
class Erfurt_Syntax_Manchester_ManchesterTokenizer_DFA20_static {
	static function getValues(){
		$eot = array(1, 65535, 1, 38, 5, 39, 1, 50, 1, 55, 1, 56, 1, 58, 1, 39, 
    1, 65535, 1, 64, 1, 67, 2, 65535, 6, 39, 3, 65535, 1, 39, 1, 38, 1, 
    65535, 1, 39, 4, 65535, 2, 39, 1, 81, 1, 39, 2, 65535, 10, 39, 3, 65535, 
    1, 93, 3, 65535, 1, 93, 3, 65535, 1, 54, 1, 39, 1, 98, 4, 65535, 1, 
    99, 8, 39, 1, 78, 1, 65535, 1, 39, 1, 81, 2, 65535, 3, 39, 1, 113, 1, 
    115, 4, 39, 2, 65535, 1, 120, 2, 65535, 1, 121, 2, 65535, 1, 39, 1, 
    123, 6, 39, 1, 130, 4, 39, 1, 65535, 1, 39, 1, 65535, 1, 39, 1, 141, 
    2, 39, 2, 65535, 1, 144, 1, 65535, 1, 145, 2, 39, 1, 148, 2, 39, 2, 
    65535, 3, 130, 1, 151, 5, 39, 1, 65535, 2, 39, 2, 65535, 1, 39, 1, 160, 
    1, 65535, 2, 39, 1, 65535, 1, 163, 6, 39, 1, 170, 1, 65535, 2, 39, 1, 
    65535, 3, 39, 1, 176, 1, 177, 1, 178, 1, 65535, 1, 179, 1, 180, 3, 39, 
    5, 65535, 1, 39, 1, 185, 1, 186, 1, 39, 2, 65535, 1, 188, 1, 65535);
		$eof = array(189, 65535);
		$min = array(1, 9, 7, 45, 1, 48, 1, 46, 2, 45, 1, 65535, 1, 0, 1, 61, 
    2, 65535, 5, 45, 1, 43, 3, 65535, 2, 45, 1, 65535, 1, 45, 4, 65535, 
    1, 43, 1, 45, 1, 65, 1, 45, 2, 65535, 10, 45, 1, 65535, 3, 45, 3, 65535, 
    1, 46, 1, 65535, 1, 48, 1, 43, 2, 45, 1, 0, 4, 65535, 10, 45, 1, 65535, 
    1, 45, 1, 65, 2, 65535, 10, 45, 1, 65535, 1, 48, 3, 45, 2, 65535, 13, 
    45, 1, 65535, 1, 45, 1, 65535, 4, 45, 2, 65535, 1, 45, 1, 65535, 6, 
    45, 1, 65535, 10, 45, 1, 65535, 2, 45, 2, 65535, 2, 45, 1, 65535, 2, 
    45, 1, 65535, 8, 45, 1, 65535, 2, 45, 1, 65535, 6, 45, 1, 65535, 5, 
    45, 5, 65535, 4, 45, 2, 65535, 1, 45, 1, 65535);
		$max = array(1, 125, 7, 122, 2, 57, 2, 122, 1, 65535, 1, 65535, 1, 61, 
    2, 65535, 6, 122, 3, 65535, 2, 122, 1, 65535, 1, 122, 4, 65535, 4, 122, 
    2, 65535, 10, 122, 1, 65535, 3, 122, 3, 65535, 1, 102, 1, 65535, 1, 
    57, 3, 122, 1, 65535, 4, 65535, 10, 122, 1, 65535, 2, 122, 2, 65535, 
    10, 122, 1, 65535, 1, 102, 3, 122, 2, 65535, 13, 122, 1, 65535, 1, 122, 
    1, 65535, 4, 122, 2, 65535, 1, 122, 1, 65535, 6, 122, 1, 65535, 10, 
    122, 1, 65535, 2, 122, 2, 65535, 2, 122, 1, 65535, 2, 122, 1, 65535, 
    8, 122, 1, 65535, 2, 122, 1, 65535, 6, 122, 1, 65535, 5, 122, 5, 65535, 
    4, 122, 2, 65535, 1, 122, 1, 65535);
		$accept = array(12, 65535, 1, 14, 2, 65535, 1, 19, 1, 20, 6, 65535, 1, 
    30, 1, 31, 1, 32, 2, 65535, 1, 37, 1, 65535, 1, 40, 1, 41, 1, 42, 1, 
    43, 4, 65535, 1, 1, 1, 47, 10, 65535, 1, 9, 3, 65535, 1, 50, 1, 10, 
    1, 11, 1, 65535, 1, 12, 5, 65535, 1, 17, 1, 38, 1, 16, 1, 18, 10, 65535, 
    1, 44, 2, 65535, 1, 45, 1, 46, 10, 65535, 1, 48, 4, 65535, 1, 15, 1, 
    21, 13, 65535, 1, 27, 1, 65535, 1, 28, 4, 65535, 1, 49, 1, 13, 1, 65535, 
    1, 22, 6, 65535, 1, 39, 10, 65535, 1, 7, 2, 65535, 1, 24, 1, 23, 2, 
    65535, 1, 26, 2, 65535, 1, 34, 8, 65535, 1, 25, 2, 65535, 1, 2, 6, 65535, 
    1, 36, 5, 65535, 1, 5, 1, 8, 1, 35, 1, 29, 1, 33, 4, 65535, 1, 3, 1, 
    4, 1, 65535, 1, 6);
		$special = array(13, 65535, 1, 1, 49, 65535, 1, 0, 125, 65535);
		$transitionS = array(array(2, 12, 2, 65535, 1, 12, 18, 65535, 1, 12, 1, 
    65535, 1, 32, 5, 65535, 1, 24, 1, 25, 1, 65535, 1, 9, 1, 23, 1, 7, 1, 
    8, 1, 65535, 10, 10, 1, 36, 1, 65535, 1, 13, 1, 65535, 1, 14, 1, 65535, 
    1, 33, 4, 35, 1, 34, 1, 27, 12, 35, 1, 21, 7, 35, 1, 30, 1, 65535, 1, 
    31, 1, 28, 1, 29, 1, 65535, 1, 18, 2, 35, 1, 26, 1, 22, 1, 1, 2, 35, 
    1, 6, 2, 35, 1, 2, 1, 3, 1, 11, 1, 17, 1, 4, 2, 35, 1, 19, 1, 5, 1, 
    35, 1, 20, 4, 35, 1, 15, 1, 65535, 1, 16), array(1, 41, 1, 39, 1, 65535, 
    10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 11, 40, 
    1, 37, 14, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 1, 44, 3, 40, 1, 43, 21, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    1, 46, 7, 40, 1, 45, 17, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 
    6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 1, 47, 25, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    7, 40, 1, 48, 18, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 13, 40, 1, 49, 12, 40), array(1, 
    52, 1, 54, 1, 65535, 10, 53, 1, 36, 6, 65535, 26, 51, 4, 65535, 1, 51, 
    1, 65535, 26, 51), array(10, 54), array(1, 54, 1, 65535, 10, 57), array(
    1, 52, 1, 59, 1, 65535, 10, 10, 1, 36, 6, 65535, 4, 51, 1, 60, 1, 61, 
    20, 51, 4, 65535, 1, 51, 1, 65535, 4, 51, 1, 60, 1, 61, 20, 51), array(
    1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 
    65535, 14, 40, 1, 62, 11, 40), array(), array(32, 65, 1, 65535, 1, 65, 
    1, 65535, 25, 65, 1, 65535, 1, 63, 30, 65, 1, 65535, 1, 65, 1, 65535, 
    1, 65, 1, 65535, 26, 65, 3, 65535, 65410, 65), array(1, 66), array(), 
    array(), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 
    65535, 1, 40, 1, 65535, 13, 40, 1, 69, 3, 40, 1, 68, 8, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    13, 40, 1, 70, 12, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 14, 40, 1, 71, 4, 40, 1, 72, 6, 40), 
    array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 
    40, 1, 65535, 1, 73, 25, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 
    6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 4, 40, 1, 74, 21, 40), 
    array(1, 78, 1, 65535, 1, 76, 2, 65535, 10, 77, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 23, 40, 1, 75, 2, 40), array(), array(
    ), array(), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 
    4, 65535, 1, 40, 1, 65535, 4, 40, 1, 79, 21, 40), array(1, 41, 1, 39, 
    1, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    26, 40), array(), array(1, 41, 2, 65535, 10, 42, 1, 80, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(), array(), array(), array(
    ), array(1, 78, 1, 65535, 1, 76, 2, 65535, 10, 77, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(
    26, 82, 4, 65535, 1, 82, 1, 65535, 26, 82), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 14, 40, 1, 83, 
    11, 40), array(), array(), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 
    65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 2, 65535, 
    10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), 
    array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 
    40, 1, 65535, 26, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 13, 40, 1, 84, 12, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    13, 40, 1, 85, 12, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 13, 40, 1, 86, 12, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    23, 40, 1, 87, 2, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 19, 40, 1, 88, 6, 40), array(1, 41, 
    2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    1, 89, 25, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 19, 40, 1, 91, 1, 40, 1, 90, 4, 40), 
    array(), array(1, 52, 2, 65535, 10, 92, 1, 36, 6, 65535, 26, 51, 4, 
    65535, 1, 51, 1, 65535, 26, 51), array(1, 52, 2, 65535, 10, 92, 1, 36, 
    6, 65535, 26, 51, 4, 65535, 1, 51, 1, 65535, 26, 51), array(1, 52, 1, 
    59, 1, 65535, 10, 53, 1, 36, 6, 65535, 4, 51, 1, 60, 1, 61, 20, 51, 
    4, 65535, 1, 51, 1, 65535, 4, 51, 1, 60, 1, 61, 20, 51), array(), array(
    ), array(), array(1, 59, 1, 65535, 10, 57, 11, 65535, 2, 54, 30, 65535, 
    2, 54), array(), array(10, 94), array(1, 54, 1, 65535, 1, 95, 2, 65535, 
    10, 96, 1, 36, 6, 65535, 26, 51, 4, 65535, 1, 51, 1, 65535, 26, 51), 
    array(1, 52, 2, 65535, 10, 92, 1, 36, 6, 65535, 26, 51, 4, 65535, 1, 
    51, 1, 65535, 26, 51), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 19, 40, 1, 97, 6, 40), array(32, 
    65, 1, 65535, 1, 65, 1, 65535, 25, 65, 1, 65535, 31, 65, 1, 65535, 1, 
    65, 1, 65535, 1, 65, 1, 65535, 26, 65, 3, 65535, 65410, 65), array(), 
    array(), array(), array(), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 
    36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 
    2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    11, 40, 1, 100, 14, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 3, 40, 1, 101, 22, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    12, 40, 1, 102, 13, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 17, 40, 1, 103, 8, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    11, 40, 1, 104, 14, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 11, 40, 1, 105, 14, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    1, 106, 25, 40), array(1, 41, 2, 65535, 10, 77, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 1, 39, 1, 65535, 
    10, 77, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), 
    array(), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 
    65535, 1, 40, 1, 65535, 2, 40, 1, 107, 23, 40), array(26, 108, 4, 65535, 
    1, 108, 1, 65535, 26, 108), array(), array(), array(1, 41, 2, 65535, 
    10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 1, 109, 
    25, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 
    65535, 1, 40, 1, 65535, 6, 40, 1, 110, 19, 40), array(1, 41, 2, 65535, 
    10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 6, 40, 1, 
    111, 19, 40), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 
    11, 40, 1, 112, 14, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 
    41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 11, 40, 1, 114, 14, 40, 
    4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 2, 65535, 10, 42, 1, 
    36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 19, 40, 1, 116, 6, 
    40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 
    1, 40, 1, 65535, 19, 40, 1, 117, 6, 40), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 4, 40, 1, 118, 
    21, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 
    65535, 1, 40, 1, 65535, 4, 40, 1, 119, 21, 40), array(1, 52, 2, 65535, 
    10, 92, 1, 36, 6, 65535, 26, 51, 4, 65535, 1, 51, 1, 65535, 26, 51), 
    array(), array(10, 94, 11, 65535, 2, 54, 30, 65535, 2, 54), array(1, 
    52, 2, 65535, 10, 96, 1, 36, 6, 65535, 26, 51, 4, 65535, 1, 51, 1, 65535, 
    26, 51), array(1, 52, 2, 65535, 10, 96, 1, 36, 6, 65535, 5, 51, 1, 61, 
    20, 51, 4, 65535, 1, 51, 1, 65535, 5, 51, 1, 61, 20, 51), array(1, 41, 
    1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 
    65535, 26, 40), array(), array(), array(1, 41, 2, 65535, 10, 42, 1, 
    36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 24, 40, 1, 122, 1, 
    40), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 
    4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 2, 65535, 10, 42, 1, 
    36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 4, 40, 1, 124, 21, 
    40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 
    1, 40, 1, 65535, 8, 40, 1, 125, 17, 40), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 20, 40, 1, 126, 
    5, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 
    1, 40, 1, 65535, 5, 40, 1, 127, 20, 40), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 2, 40, 1, 128, 
    23, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 
    65535, 1, 40, 1, 65535, 8, 40, 1, 129, 17, 40), array(1, 133, 1, 131, 
    1, 65535, 10, 134, 7, 65535, 26, 132, 4, 65535, 1, 132, 1, 65535, 26, 
    132), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 
    1, 40, 1, 65535, 19, 40, 1, 135, 6, 40), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 19, 40, 1, 136, 
    6, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 15, 40, 1, 137, 
    10, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 4, 40, 1, 138, 
    21, 40), array(), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 4, 40, 1, 139, 21, 40), array(), array(
    1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 
    65535, 4, 40, 1, 140, 21, 40), array(1, 41, 1, 39, 1, 65535, 10, 42, 
    1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    17, 40, 1, 142, 8, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 6, 40, 1, 143, 19, 40), array(), 
    array(), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(), array(1, 41, 1, 39, 
    1, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    26, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 
    65535, 1, 40, 1, 65535, 13, 40, 1, 146, 12, 40), array(1, 41, 2, 65535, 
    10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 4, 40, 1, 
    147, 21, 40), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 19, 40, 1, 149, 
    6, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 
    1, 40, 1, 65535, 12, 40, 1, 150, 13, 40), array(), array(1, 133, 2, 
    65535, 10, 134, 7, 65535, 26, 132, 4, 65535, 1, 132, 1, 65535, 26, 132), 
    array(1, 133, 1, 131, 1, 65535, 10, 134, 7, 65535, 26, 132, 4, 65535, 
    1, 132, 1, 65535, 26, 132), array(1, 133, 1, 131, 1, 65535, 10, 134, 
    7, 65535, 26, 132, 4, 65535, 1, 132, 1, 65535, 26, 132), array(1, 133, 
    1, 131, 1, 65535, 10, 134, 7, 65535, 26, 132, 4, 65535, 1, 132, 1, 65535, 
    26, 132), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 2, 65535, 10, 42, 
    1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 7, 40, 1, 152, 18, 
    40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 
    1, 40, 1, 65535, 1, 153, 25, 40), array(1, 41, 2, 65535, 10, 42, 1, 
    36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 13, 40, 1, 154, 12, 
    40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 
    1, 40, 1, 65535, 13, 40, 1, 155, 12, 40), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 17, 40, 1, 156, 
    8, 40), array(), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 18, 40, 1, 157, 7, 40), array(1, 41, 
    2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    4, 40, 1, 158, 21, 40), array(), array(), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 6, 40, 1, 159, 
    19, 40), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(), array(1, 41, 2, 65535, 
    10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 11, 40, 
    1, 161, 14, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 1, 162, 25, 40), array(), array(1, 41, 
    1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 
    65535, 26, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 19, 40, 1, 164, 6, 40), array(1, 41, 
    2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    6, 40, 1, 165, 19, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 6, 40, 1, 166, 19, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    13, 40, 1, 167, 12, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 4, 40, 1, 168, 21, 40), array(1, 
    41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 
    17, 40, 1, 169, 8, 40), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 
    6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(), array(
    1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 
    65535, 24, 40, 1, 171, 1, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 
    6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 11, 40, 1, 172, 14, 40), 
    array(), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 
    65535, 1, 40, 1, 65535, 19, 40, 1, 173, 6, 40), array(1, 41, 2, 65535, 
    10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 19, 40, 
    1, 174, 6, 40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 19, 40, 1, 175, 6, 40), array(1, 41, 
    1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 
    65535, 26, 40), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 1, 39, 1, 65535, 
    10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), 
    array(), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 1, 39, 1, 65535, 
    10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), 
    array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 
    40, 1, 65535, 4, 40, 1, 181, 21, 40), array(1, 41, 2, 65535, 10, 42, 
    1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 7, 40, 1, 182, 18, 
    40), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 
    1, 40, 1, 65535, 7, 40, 1, 183, 18, 40), array(), array(), array(), 
    array(), array(), array(1, 41, 2, 65535, 10, 42, 1, 36, 6, 65535, 26, 
    40, 4, 65535, 1, 40, 1, 65535, 17, 40, 1, 184, 8, 40), array(1, 41, 
    1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 
    65535, 26, 40), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 36, 6, 65535, 
    26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array(1, 41, 2, 65535, 10, 
    42, 1, 36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 13, 40, 1, 187, 
    12, 40), array(), array(), array(1, 41, 1, 39, 1, 65535, 10, 42, 1, 
    36, 6, 65535, 26, 40, 4, 65535, 1, 40, 1, 65535, 26, 40), array());
		
		$arr = array();
		$arr['eot'] = DFA::unpackRLE($eot);
		$arr['eof'] = DFA::unpackRLE($eof);
		$arr['min'] = DFA::unpackRLE($min, true);
		$arr['max'] = DFA::unpackRLE($max, true);
		$arr['accept'] = DFA::unpackRLE($accept);
		$arr['special'] = DFA::unpackRLE($special);
		
		
		$numStates = sizeof($transitionS);
		$arr['transition'] = array();
		for ($i=0; $i<$numStates; $i++) {
		    $arr['transition'][$i] = DFA::unpackRLE($transitionS[$i]);
		}
		return $arr;
	}
}
//$Erfurt_Syntax_Manchester_ManchesterTokenizer_DFA20 = Erfurt_Syntax_Manchester_ManchesterTokenizer_DFA20_static();

class Erfurt_Syntax_Manchester_ManchesterTokenizer_DFA20 extends DFA {

    public function __construct($recognizer) {
//        global $Erfurt_Syntax_Manchester_ManchesterTokenizer_DFA20;
//        $DFA = $Erfurt_Syntax_Manchester_ManchesterTokenizer_DFA20;
		$DFA = Erfurt_Syntax_Manchester_ManchesterTokenizer_DFA20_static::getValues();
        $this->recognizer = $recognizer;
        $this->decisionNumber = 20;
        $this->eot = $DFA['eot'];
        $this->eof = $DFA['eof'];
        $this->min = $DFA['min'];
        $this->max = $DFA['max'];
        $this->accept = $DFA['accept'];
        $this->special = $DFA['special'];
        $this->transition = $DFA['transition'];
    }
    public function getDescription() {
        return "1:1: Tokens : ( F_LABEL | LENGTH_LABEL | MIN_LENGTH_LABEL | MAX_LENGTH_LABEL | PATTERN_LABEL | LANG_PATTERN_LABEL | THAT_LABEL | INVERSE_LABEL | MINUS | DOT | PLUS | DIGITS | NOT_LABEL | WS | LESS_EQUAL | GREATER_EQUAL | LESS | GREATER | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | OR_LABEL | AND_LABEL | SOME_LABEL | ONLY_LABEL | VALUE_LABEL | SELF_LABEL | MIN_LABEL | MAX_LABEL | EXACTLY_LABEL | COMMA | OPEN_BRACE | CLOSE_BRACE | DECIMAL_LABEL | FLOAT_LABEL | INTEGER_LABEL | STRING_LABEL | REFERENCE | FULL_IRI | NODE_ID | OPEN_SQUARE_BRACE | CLOSE_SQUARE_BRACE | QUOTED_STRING | LANGUAGE_TAG | EXPONENT | PREFIX_NAME | ABBREVIATED_IRI | SIMPLE_IRI | ILITERAL_HELPER | DLITERAL_HELPER | FPLITERAL_HELPER );";
    }
    public function specialStateTransition($s, IntStream $_input) {
        $input = $_input;
    	$_s = $s;
        switch ( $s ) {
                case 0 : 
                    $LA20_63 = $input->LA(1);

                    $s = -1;
                    if ( (($LA20_63>=$this->getToken('0') && $LA20_63<=$this->getToken('31'))||$LA20_63==$this->getToken('33')||($LA20_63>=$this->getToken('35') && $LA20_63<=$this->getToken('59'))||($LA20_63>=$this->getToken('61') && $LA20_63<=$this->getToken('91'))||$LA20_63==$this->getToken('93')||$LA20_63==$this->getToken('95')||($LA20_63>=$this->getToken('97') && $LA20_63<=$this->getToken('122'))||($LA20_63>=$this->getToken('126') && $LA20_63<=$this->getToken('65535'))) ) {$s = 65;}

                    else $s = 98;

                    if ( $s>=0 ) return $s;
                    break;
                case 1 : 
                    $LA20_13 = $input->LA(1);

                    $s = -1;
                    if ( ($LA20_13==$this->getToken('61')) ) {$s = 63;}

                    else if ( (($LA20_13>=$this->getToken('0') && $LA20_13<=$this->getToken('31'))||$LA20_13==$this->getToken('33')||($LA20_13>=$this->getToken('35') && $LA20_13<=$this->getToken('59'))||($LA20_13>=$this->getToken('62') && $LA20_13<=$this->getToken('91'))||$LA20_13==$this->getToken('93')||$LA20_13==$this->getToken('95')||($LA20_13>=$this->getToken('97') && $LA20_13<=$this->getToken('122'))||($LA20_13>=$this->getToken('126') && $LA20_13<=$this->getToken('65535'))) ) {$s = 65;}

                    else $s = 64;

                    if ( $s>=0 ) return $s;
                    break;
        }
        $nvae =
            new NoViableAltException($this->getDescription(), 20, $_s, $input);
        $this->error($nvae);
        throw $nvae;        
    }
}
      

class Erfurt_Syntax_Manchester_ManchesterTokenizer extends AntlrLexer {
    static $MAX_LENGTH_LABEL=7;
    static $EXPONENT=54;
    static $CLOSE_SQUARE_BRACE=50;
    static $DECIMAL_LABEL=37;
    static $ONLY_LABEL=28;
    static $DIGITS=15;
    static $MAX_LABEL=32;
    static $FPLITERAL_HELPER=59;
    static $EOF=-1;
    static $STRING_LABEL=40;
    static $LANG_PATTERN_LABEL=9;
    static $FLOAT_LABEL=38;
    static $ABBREVIATED_IRI=56;
    static $INVERSE_LABEL=11;
    static $INTEGER_LABEL=39;
    static $GREATER=22;
    static $EOL=17;
    static $F_LABEL=4;
    static $OR_LABEL=25;
    static $COMMA=34;
    static $LESS=21;
    static $PN_CHARS_U=45;
    static $QUOTED_STRING=52;
    static $PLUS=14;
    static $DOT=13;
    static $DLITERAL_HELPER=58;
    static $OPEN_CURLY_BRACE=23;
    static $CLOSE_CURLY_BRACE=24;
    static $PATTERN_LABEL=8;
    static $SIMPLE_IRI=47;
    static $PREFIX_NAME=55;
    static $AND_LABEL=26;
    static $REFERENCE=41;
    static $FULL_IRI=46;
    static $CLOSE_BRACE=36;
    static $ILITERAL_HELPER=57;
    static $MINUS=12;
    static $LENGTH_LABEL=5;
    static $SOME_LABEL=27;
    static $Tokens=61;
    static $NODE_ID=48;
    static $ITFUCKINDOESNTWORK=60;
    static $OPEN_SQUARE_BRACE=49;
    static $ECHAR=51;
    static $WS=18;
    static $MIN_LABEL=31;
    static $PN_CHARS_BASE=44;
    static $THAT_LABEL=10;
    static $NOT_LABEL=16;
    static $PN_PREFIX=43;
    static $SELF_LABEL=30;
    static $PN_CHARS=42;
    static $MIN_LENGTH_LABEL=6;
    static $VALUE_LABEL=29;
    static $EXACTLY_LABEL=33;
    static $LESS_EQUAL=19;
    static $LANGUAGE_TAG=53;
    static $OPEN_BRACE=35;
    static $GREATER_EQUAL=20;

    // delegates
    // delegators
    /**
    * @param Erfurt_Syntax_ManchesterLexer $gErfurt_Syntax_Manchester
    */
    public $gErfurt_Syntax_Manchester;
    /**
    * @param Erfurt_Syntax_ManchesterLexer $gErfurt_Syntax_Manchester
    */
    public $gParent;

    function __construct($input, $state=null){
        parent::__construct($input,$state);

        $this->gErfurt_Syntax_Manchester = $this->gErfurt_Syntax_Manchester;
        $this->gParent = $this->gErfurt_Syntax_Manchester;
        
            $this->dfa20 = new Erfurt_Syntax_Manchester_ManchesterTokenizer_DFA20($this);
    }
    function getGrammarFileName() { return "ManchesterTokenizer.g"; }

    // $ANTLR start "F_LABEL"
    function mF_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$F_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:4:9: ( ( 'f' | 'F' ) ) 
            // ManchesterTokenizer.g:4:11: ( 'f' | 'F' ) 
            {
            if ( $this->input->LA(1)==$this->getToken('70')||$this->input->LA(1)==$this->getToken('102') ) {
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
    // $ANTLR end "F_LABEL"

    // $ANTLR start "LENGTH_LABEL"
    function mLENGTH_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$LENGTH_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:5:14: ( 'length' ) 
            // ManchesterTokenizer.g:5:16: 'length' 
            {
            $this->matchString("length"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LENGTH_LABEL"

    // $ANTLR start "MIN_LENGTH_LABEL"
    function mMIN_LENGTH_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$MIN_LENGTH_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:6:18: ( 'minLength' ) 
            // ManchesterTokenizer.g:6:20: 'minLength' 
            {
            $this->matchString("minLength"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "MIN_LENGTH_LABEL"

    // $ANTLR start "MAX_LENGTH_LABEL"
    function mMAX_LENGTH_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$MAX_LENGTH_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:7:18: ( 'maxLength' ) 
            // ManchesterTokenizer.g:7:20: 'maxLength' 
            {
            $this->matchString("maxLength"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "MAX_LENGTH_LABEL"

    // $ANTLR start "PATTERN_LABEL"
    function mPATTERN_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$PATTERN_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:8:15: ( 'pattern' ) 
            // ManchesterTokenizer.g:8:17: 'pattern' 
            {
            $this->matchString("pattern"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PATTERN_LABEL"

    // $ANTLR start "LANG_PATTERN_LABEL"
    function mLANG_PATTERN_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$LANG_PATTERN_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:9:20: ( 'langPattern' ) 
            // ManchesterTokenizer.g:9:22: 'langPattern' 
            {
            $this->matchString("langPattern"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LANG_PATTERN_LABEL"

    // $ANTLR start "THAT_LABEL"
    function mTHAT_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$THAT_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:10:12: ( 'that' ) 
            // ManchesterTokenizer.g:10:14: 'that' 
            {
            $this->matchString("that"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "THAT_LABEL"

    // $ANTLR start "INVERSE_LABEL"
    function mINVERSE_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$INVERSE_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:11:15: ( 'inverse' ) 
            // ManchesterTokenizer.g:11:17: 'inverse' 
            {
            $this->matchString("inverse"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "INVERSE_LABEL"

    // $ANTLR start "MINUS"
    function mMINUS(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$MINUS;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:12:7: ( '-' ) 
            // ManchesterTokenizer.g:12:9: '-' 
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

    // $ANTLR start "DOT"
    function mDOT(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DOT;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:13:5: ( '.' ) 
            // ManchesterTokenizer.g:13:7: '.' 
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
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$PLUS;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:14:6: ( '+' ) 
            // ManchesterTokenizer.g:14:8: '+' 
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

    // $ANTLR start "DIGITS"
    function mDIGITS(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DIGITS;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:15:8: ( ( '0' .. '9' )+ ) 
            // ManchesterTokenizer.g:15:10: ( '0' .. '9' )+ 
            {
            // ManchesterTokenizer.g:15:10: ( '0' .. '9' )+ 
            $cnt1=0;
            //loop1:
            do {
                $alt1=2;
                $LA1_0 = $this->input->LA(1);

                if ( (($LA1_0>=$this->getToken('48') && $LA1_0<=$this->getToken('57'))) ) {
                    $alt1=1;
                }


                switch ($alt1) {
            	case 1 :
            	    // ManchesterTokenizer.g:15:11: '0' .. '9' 
            	    {
            	    $this->matchRange(48,57); 

            	    }
            	    break;

            	default :
            	    if ( $cnt1 >= 1 ) break 2;//loop1;
                        $eee =
                            new EarlyExitException(1, $this->input);
                        throw $eee;
                }
                $cnt1++;
            } while (true);


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DIGITS"

    // $ANTLR start "NOT_LABEL"
    function mNOT_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$NOT_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:16:11: ( 'not' ) 
            // ManchesterTokenizer.g:16:13: 'not' 
            {
            $this->matchString("not"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "NOT_LABEL"

    // $ANTLR start "WS"
    function mWS(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$WS;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:17:4: ( ( ' ' | '\\t' | EOL )+ ) 
            // ManchesterTokenizer.g:17:6: ( ' ' | '\\t' | EOL )+ 
            {
            // ManchesterTokenizer.g:17:6: ( ' ' | '\\t' | EOL )+ 
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
            	    // ManchesterTokenizer.g: 
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

              $_channel = HIDDEN;

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "WS"

    // $ANTLR start "LESS_EQUAL"
    function mLESS_EQUAL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$LESS_EQUAL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:18:12: ( '<=' ) 
            // ManchesterTokenizer.g:18:14: '<=' 
            {
            $this->matchString("<="); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LESS_EQUAL"

    // $ANTLR start "GREATER_EQUAL"
    function mGREATER_EQUAL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$GREATER_EQUAL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:19:15: ( '>=' ) 
            // ManchesterTokenizer.g:19:17: '>=' 
            {
            $this->matchString(">="); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "GREATER_EQUAL"

    // $ANTLR start "LESS"
    function mLESS(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$LESS;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:20:6: ( '<' ) 
            // ManchesterTokenizer.g:20:8: '<' 
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
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$GREATER;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:21:9: ( '>' ) 
            // ManchesterTokenizer.g:21:11: '>' 
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
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$OPEN_CURLY_BRACE;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:22:18: ( '{' ) 
            // ManchesterTokenizer.g:22:20: '{' 
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
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$CLOSE_CURLY_BRACE;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:23:19: ( '}' ) 
            // ManchesterTokenizer.g:23:21: '}' 
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

    // $ANTLR start "OR_LABEL"
    function mOR_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$OR_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:24:10: ( 'or' ) 
            // ManchesterTokenizer.g:24:12: 'or' 
            {
            $this->matchString("or"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "OR_LABEL"

    // $ANTLR start "AND_LABEL"
    function mAND_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$AND_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:25:11: ( 'and' ) 
            // ManchesterTokenizer.g:25:13: 'and' 
            {
            $this->matchString("and"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "AND_LABEL"

    // $ANTLR start "SOME_LABEL"
    function mSOME_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$SOME_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:26:12: ( 'some' ) 
            // ManchesterTokenizer.g:26:14: 'some' 
            {
            $this->matchString("some"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "SOME_LABEL"

    // $ANTLR start "ONLY_LABEL"
    function mONLY_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$ONLY_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:27:12: ( 'only' ) 
            // ManchesterTokenizer.g:27:14: 'only' 
            {
            $this->matchString("only"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ONLY_LABEL"

    // $ANTLR start "VALUE_LABEL"
    function mVALUE_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$VALUE_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:28:13: ( 'value' ) 
            // ManchesterTokenizer.g:28:15: 'value' 
            {
            $this->matchString("value"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "VALUE_LABEL"

    // $ANTLR start "SELF_LABEL"
    function mSELF_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$SELF_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:29:12: ( 'Self' ) 
            // ManchesterTokenizer.g:29:14: 'Self' 
            {
            $this->matchString("Self"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "SELF_LABEL"

    // $ANTLR start "MIN_LABEL"
    function mMIN_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$MIN_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:30:11: ( 'min' ) 
            // ManchesterTokenizer.g:30:13: 'min' 
            {
            $this->matchString("min"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "MIN_LABEL"

    // $ANTLR start "MAX_LABEL"
    function mMAX_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$MAX_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:31:11: ( 'max' ) 
            // ManchesterTokenizer.g:31:13: 'max' 
            {
            $this->matchString("max"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "MAX_LABEL"

    // $ANTLR start "EXACTLY_LABEL"
    function mEXACTLY_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$EXACTLY_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:32:15: ( 'exactly' ) 
            // ManchesterTokenizer.g:32:17: 'exactly' 
            {
            $this->matchString("exactly"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "EXACTLY_LABEL"

    // $ANTLR start "COMMA"
    function mCOMMA(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$COMMA;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:33:7: ( ',' ) 
            // ManchesterTokenizer.g:33:9: ',' 
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

    // $ANTLR start "OPEN_BRACE"
    function mOPEN_BRACE(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$OPEN_BRACE;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:34:12: ( '(' ) 
            // ManchesterTokenizer.g:34:14: '(' 
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
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$CLOSE_BRACE;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:35:13: ( ')' ) 
            // ManchesterTokenizer.g:35:15: ')' 
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

    // $ANTLR start "DECIMAL_LABEL"
    function mDECIMAL_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DECIMAL_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:36:15: ( 'decimal' ) 
            // ManchesterTokenizer.g:36:17: 'decimal' 
            {
            $this->matchString("decimal"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DECIMAL_LABEL"

    // $ANTLR start "FLOAT_LABEL"
    function mFLOAT_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$FLOAT_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:37:13: ( 'float' ) 
            // ManchesterTokenizer.g:37:15: 'float' 
            {
            $this->matchString("float"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "FLOAT_LABEL"

    // $ANTLR start "INTEGER_LABEL"
    function mINTEGER_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$INTEGER_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:38:15: ( 'integer' ) 
            // ManchesterTokenizer.g:38:17: 'integer' 
            {
            $this->matchString("integer"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "INTEGER_LABEL"

    // $ANTLR start "STRING_LABEL"
    function mSTRING_LABEL(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$STRING_LABEL;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:39:14: ( 'string' ) 
            // ManchesterTokenizer.g:39:16: 'string' 
            {
            $this->matchString("string"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "STRING_LABEL"

    // $ANTLR start "REFERENCE"
    function mREFERENCE(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$REFERENCE;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:40:11: ( '^^' ) 
            // ManchesterTokenizer.g:40:13: '^^' 
            {
            $this->matchString("^^"); 


            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "REFERENCE"

    // $ANTLR start "PN_PREFIX"
    function mPN_PREFIX(){
        try {
            // ManchesterTokenizer.g:96:11: ( ( PN_CHARS )* ) 
            // ManchesterTokenizer.g:96:13: ( PN_CHARS )* 
            {
            // ManchesterTokenizer.g:96:13: ( PN_CHARS )* 
            //loop3:
            do {
                $alt3=2;
                $LA3_0 = $this->input->LA(1);

                if ( ($LA3_0==$this->getToken('45')||($LA3_0>=$this->getToken('48') && $LA3_0<=$this->getToken('57'))||($LA3_0>=$this->getToken('65') && $LA3_0<=$this->getToken('90'))||$LA3_0==$this->getToken('95')||($LA3_0>=$this->getToken('97') && $LA3_0<=$this->getToken('122'))) ) {
                    $alt3=1;
                }


                switch ($alt3) {
            	case 1 :
            	    // ManchesterTokenizer.g:96:14: PN_CHARS 
            	    {
            	    $this->mPN_CHARS(); 

            	    }
            	    break;

            	default :
            	    break 2;//loop3;
                }
            } while (true);


            }

        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PN_PREFIX"

    // $ANTLR start "EOL"
    function mEOL(){
        try {
            // ManchesterTokenizer.g:98:5: ( '\\n' | '\\r' ) 
            // ManchesterTokenizer.g: 
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

    // $ANTLR start "PN_CHARS_BASE"
    function mPN_CHARS_BASE(){
        try {
            // ManchesterTokenizer.g:100:15: ( 'A' .. 'Z' | 'a' .. 'z' ) 
            // ManchesterTokenizer.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122')) ) {
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

    // $ANTLR start "PN_CHARS_U"
    function mPN_CHARS_U(){
        try {
            // ManchesterTokenizer.g:114:12: ( PN_CHARS_BASE | '_' ) 
            // ManchesterTokenizer.g: 
            {
            if ( ($this->input->LA(1)>=$this->getToken('65') && $this->input->LA(1)<=$this->getToken('90'))||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122')) ) {
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

    // $ANTLR start "FULL_IRI"
    function mFULL_IRI(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$FULL_IRI;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:115:10: ( LESS ( options {greedy=false; } : ~ ( LESS | GREATER | '\"' | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | '|' | '^' | '\\\\' | '`' | ' ' ) )* GREATER ) 
            // ManchesterTokenizer.g:115:12: LESS ( options {greedy=false; } : ~ ( LESS | GREATER | '\"' | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | '|' | '^' | '\\\\' | '`' | ' ' ) )* GREATER 
            {
            $this->mLESS(); 
            // ManchesterTokenizer.g:115:17: ( options {greedy=false; } : ~ ( LESS | GREATER | '\"' | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | '|' | '^' | '\\\\' | '`' | ' ' ) )* 
            //loop4:
            do {
                $alt4=2;
                $LA4_0 = $this->input->LA(1);

                if ( (($LA4_0>=$this->getToken('0') && $LA4_0<=$this->getToken('31'))||$LA4_0==$this->getToken('33')||($LA4_0>=$this->getToken('35') && $LA4_0<=$this->getToken('59'))||$LA4_0==$this->getToken('61')||($LA4_0>=$this->getToken('63') && $LA4_0<=$this->getToken('91'))||$LA4_0==$this->getToken('93')||$LA4_0==$this->getToken('95')||($LA4_0>=$this->getToken('97') && $LA4_0<=$this->getToken('122'))||($LA4_0>=$this->getToken('126') && $LA4_0<=$this->getToken('65535'))) ) {
                    $alt4=1;
                }
                else if ( ($LA4_0==$this->getToken('62')) ) {
                    $alt4=2;
                }


                switch ($alt4) {
            	case 1 :
            	    // ManchesterTokenizer.g:116:5: ~ ( LESS | GREATER | '\"' | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | '|' | '^' | '\\\\' | '`' | ' ' ) 
            	    {
            	    if ( ($this->input->LA(1)>=$this->getToken('0') && $this->input->LA(1)<=$this->getToken('31'))||$this->input->LA(1)==$this->getToken('33')||($this->input->LA(1)>=$this->getToken('35') && $this->input->LA(1)<=$this->getToken('59'))||$this->input->LA(1)==$this->getToken('61')||($this->input->LA(1)>=$this->getToken('63') && $this->input->LA(1)<=$this->getToken('91'))||$this->input->LA(1)==$this->getToken('93')||$this->input->LA(1)==$this->getToken('95')||($this->input->LA(1)>=$this->getToken('97') && $this->input->LA(1)<=$this->getToken('122'))||($this->input->LA(1)>=$this->getToken('126') && $this->input->LA(1)<=$this->getToken('65535')) ) {
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
    // $ANTLR end "FULL_IRI"

    // $ANTLR start "NODE_ID"
    function mNODE_ID(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$NODE_ID;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            $t=null;

            // ManchesterTokenizer.g:120:9: ( '_:' t= SIMPLE_IRI ) 
            // ManchesterTokenizer.g:120:11: '_:' t= SIMPLE_IRI 
            {
            $this->matchString("_:"); 

            $tStart544 = $this->getCharIndex();
            $this->mSIMPLE_IRI(); 
            $t = new CommonToken($this->input, TokenConst::$INVALID_TOKEN_TYPE, TokenConst::$DEFAULT_CHANNEL, $tStart544, $this->getCharIndex()-1);
              $this->setText(($t!=null?$t->getText():null)); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "NODE_ID"

    // $ANTLR start "PN_CHARS"
    function mPN_CHARS(){
        try {
            // ManchesterTokenizer.g:122:10: ( PN_CHARS_U | MINUS | DIGITS ) 
            $alt5=3;
            $LA5 = $this->input->LA(1);
            if($this->getToken('65')== $LA5||$this->getToken('66')== $LA5||$this->getToken('67')== $LA5||$this->getToken('68')== $LA5||$this->getToken('69')== $LA5||$this->getToken('70')== $LA5||$this->getToken('71')== $LA5||$this->getToken('72')== $LA5||$this->getToken('73')== $LA5||$this->getToken('74')== $LA5||$this->getToken('75')== $LA5||$this->getToken('76')== $LA5||$this->getToken('77')== $LA5||$this->getToken('78')== $LA5||$this->getToken('79')== $LA5||$this->getToken('80')== $LA5||$this->getToken('81')== $LA5||$this->getToken('82')== $LA5||$this->getToken('83')== $LA5||$this->getToken('84')== $LA5||$this->getToken('85')== $LA5||$this->getToken('86')== $LA5||$this->getToken('87')== $LA5||$this->getToken('88')== $LA5||$this->getToken('89')== $LA5||$this->getToken('90')== $LA5||$this->getToken('95')== $LA5||$this->getToken('97')== $LA5||$this->getToken('98')== $LA5||$this->getToken('99')== $LA5||$this->getToken('100')== $LA5||$this->getToken('101')== $LA5||$this->getToken('102')== $LA5||$this->getToken('103')== $LA5||$this->getToken('104')== $LA5||$this->getToken('105')== $LA5||$this->getToken('106')== $LA5||$this->getToken('107')== $LA5||$this->getToken('108')== $LA5||$this->getToken('109')== $LA5||$this->getToken('110')== $LA5||$this->getToken('111')== $LA5||$this->getToken('112')== $LA5||$this->getToken('113')== $LA5||$this->getToken('114')== $LA5||$this->getToken('115')== $LA5||$this->getToken('116')== $LA5||$this->getToken('117')== $LA5||$this->getToken('118')== $LA5||$this->getToken('119')== $LA5||$this->getToken('120')== $LA5||$this->getToken('121')== $LA5||$this->getToken('122')== $LA5)
                {
                $alt5=1;
                }
            else if($this->getToken('45')== $LA5)
                {
                $alt5=2;
                }
            else if($this->getToken('48')== $LA5||$this->getToken('49')== $LA5||$this->getToken('50')== $LA5||$this->getToken('51')== $LA5||$this->getToken('52')== $LA5||$this->getToken('53')== $LA5||$this->getToken('54')== $LA5||$this->getToken('55')== $LA5||$this->getToken('56')== $LA5||$this->getToken('57')== $LA5)
                {
                $alt5=3;
                }
            else{
                $nvae =
                    new NoViableAltException("", 5, 0, $this->input);

                throw $nvae;
            }

            switch ($alt5) {
                case 1 :
                    // ManchesterTokenizer.g:122:12: PN_CHARS_U 
                    {
                    $this->mPN_CHARS_U(); 

                    }
                    break;
                case 2 :
                    // ManchesterTokenizer.g:122:25: MINUS 
                    {
                    $this->mMINUS(); 

                    }
                    break;
                case 3 :
                    // ManchesterTokenizer.g:122:33: DIGITS 
                    {
                    $this->mDIGITS(); 

                    }
                    break;

            }
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PN_CHARS"

    // $ANTLR start "OPEN_SQUARE_BRACE"
    function mOPEN_SQUARE_BRACE(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$OPEN_SQUARE_BRACE;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:127:19: ( '[' ) 
            // ManchesterTokenizer.g:127:21: '[' 
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
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$CLOSE_SQUARE_BRACE;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:128:20: ( ']' ) 
            // ManchesterTokenizer.g:128:22: ']' 
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

    // $ANTLR start "QUOTED_STRING"
    function mQUOTED_STRING(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$QUOTED_STRING;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:129:15: ( '\"' ( options {greedy=false; } : ~ ( '\\u0022' | '\\u005C' | '\\u000A' | '\\u000D' ) | ECHAR )* '\"' ) 
            // ManchesterTokenizer.g:129:17: '\"' ( options {greedy=false; } : ~ ( '\\u0022' | '\\u005C' | '\\u000A' | '\\u000D' ) | ECHAR )* '\"' 
            {
            $this->matchChar(34); 
            // ManchesterTokenizer.g:129:21: ( options {greedy=false; } : ~ ( '\\u0022' | '\\u005C' | '\\u000A' | '\\u000D' ) | ECHAR )* 
            //loop6:
            do {
                $alt6=3;
                $LA6_0 = $this->input->LA(1);

                if ( (($LA6_0>=$this->getToken('0') && $LA6_0<=$this->getToken('9'))||($LA6_0>=$this->getToken('11') && $LA6_0<=$this->getToken('12'))||($LA6_0>=$this->getToken('14') && $LA6_0<=$this->getToken('33'))||($LA6_0>=$this->getToken('35') && $LA6_0<=$this->getToken('91'))||($LA6_0>=$this->getToken('93') && $LA6_0<=$this->getToken('65535'))) ) {
                    $alt6=1;
                }
                else if ( ($LA6_0==$this->getToken('92')) ) {
                    $alt6=2;
                }
                else if ( ($LA6_0==$this->getToken('34')) ) {
                    $alt6=3;
                }


                switch ($alt6) {
            	case 1 :
            	    // ManchesterTokenizer.g:129:48: ~ ( '\\u0022' | '\\u005C' | '\\u000A' | '\\u000D' ) 
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
            	    // ManchesterTokenizer.g:129:95: ECHAR 
            	    {
            	    $this->mECHAR(); 

            	    }
            	    break;

            	default :
            	    break 2;//loop6;
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
    // $ANTLR end "QUOTED_STRING"

    // $ANTLR start "ECHAR"
    function mECHAR(){
        try {
            // ManchesterTokenizer.g:131:7: ( '\\\\' ( 't' | 'b' | 'n' | 'r' | 'f' | '\\\\' | '\"' | '\\'' ) ) 
            // ManchesterTokenizer.g:131:9: '\\\\' ( 't' | 'b' | 'n' | 'r' | 'f' | '\\\\' | '\"' | '\\'' ) 
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

    // $ANTLR start "LANGUAGE_TAG"
    function mLANGUAGE_TAG(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$LANGUAGE_TAG;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:132:14: ( '@' ( ( 'a' .. 'z' ) | ( 'A' .. 'Z' ) )+ ( MINUS ( ( 'a' .. 'z' ) ( 'A' .. 'Z' ) DIGITS )+ )* ) 
            // ManchesterTokenizer.g:132:16: '@' ( ( 'a' .. 'z' ) | ( 'A' .. 'Z' ) )+ ( MINUS ( ( 'a' .. 'z' ) ( 'A' .. 'Z' ) DIGITS )+ )* 
            {
            $this->matchChar(64); 
            // ManchesterTokenizer.g:132:20: ( ( 'a' .. 'z' ) | ( 'A' .. 'Z' ) )+ 
            $cnt7=0;
            //loop7:
            do {
                $alt7=3;
                $LA7_0 = $this->input->LA(1);

                if ( (($LA7_0>=$this->getToken('97') && $LA7_0<=$this->getToken('122'))) ) {
                    $alt7=1;
                }
                else if ( (($LA7_0>=$this->getToken('65') && $LA7_0<=$this->getToken('90'))) ) {
                    $alt7=2;
                }


                switch ($alt7) {
            	case 1 :
            	    // ManchesterTokenizer.g:132:21: ( 'a' .. 'z' ) 
            	    {
            	    // ManchesterTokenizer.g:132:21: ( 'a' .. 'z' ) 
            	    // ManchesterTokenizer.g:132:22: 'a' .. 'z' 
            	    {
            	    $this->matchRange(97,122); 

            	    }


            	    }
            	    break;
            	case 2 :
            	    // ManchesterTokenizer.g:132:34: ( 'A' .. 'Z' ) 
            	    {
            	    // ManchesterTokenizer.g:132:34: ( 'A' .. 'Z' ) 
            	    // ManchesterTokenizer.g:132:35: 'A' .. 'Z' 
            	    {
            	    $this->matchRange(65,90); 

            	    }


            	    }
            	    break;

            	default :
            	    if ( $cnt7 >= 1 ) break 2;//loop7;
                        $eee =
                            new EarlyExitException(7, $this->input);
                        throw $eee;
                }
                $cnt7++;
            } while (true);

            // ManchesterTokenizer.g:132:47: ( MINUS ( ( 'a' .. 'z' ) ( 'A' .. 'Z' ) DIGITS )+ )* 
            //loop9:
            do {
                $alt9=2;
                $LA9_0 = $this->input->LA(1);

                if ( ($LA9_0==$this->getToken('45')) ) {
                    $alt9=1;
                }


                switch ($alt9) {
            	case 1 :
            	    // ManchesterTokenizer.g:132:49: MINUS ( ( 'a' .. 'z' ) ( 'A' .. 'Z' ) DIGITS )+ 
            	    {
            	    $this->mMINUS(); 
            	    // ManchesterTokenizer.g:132:55: ( ( 'a' .. 'z' ) ( 'A' .. 'Z' ) DIGITS )+ 
            	    $cnt8=0;
            	    //loop8:
            	    do {
            	        $alt8=2;
            	        $LA8_0 = $this->input->LA(1);

            	        if ( (($LA8_0>=$this->getToken('97') && $LA8_0<=$this->getToken('122'))) ) {
            	            $alt8=1;
            	        }


            	        switch ($alt8) {
            	    	case 1 :
            	    	    // ManchesterTokenizer.g:132:56: ( 'a' .. 'z' ) ( 'A' .. 'Z' ) DIGITS 
            	    	    {
            	    	    // ManchesterTokenizer.g:132:56: ( 'a' .. 'z' ) 
            	    	    // ManchesterTokenizer.g:132:57: 'a' .. 'z' 
            	    	    {
            	    	    $this->matchRange(97,122); 

            	    	    }

            	    	    // ManchesterTokenizer.g:132:67: ( 'A' .. 'Z' ) 
            	    	    // ManchesterTokenizer.g:132:68: 'A' .. 'Z' 
            	    	    {
            	    	    $this->matchRange(65,90); 

            	    	    }

            	    	    $this->mDIGITS(); 

            	    	    }
            	    	    break;

            	    	default :
            	    	    if ( $cnt8 >= 1 ) break 2;//loop8;
            	                $eee =
            	                    new EarlyExitException(8, $this->input);
            	                throw $eee;
            	        }
            	        $cnt8++;
            	    } while (true);


            	    }
            	    break;

            	default :
            	    break 2;//loop9;
                }
            } while (true);

              $this->setText(substr($this->getText(), 1, strlen($this->getText()) - 1)); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "LANGUAGE_TAG"

    // $ANTLR start "EXPONENT"
    function mEXPONENT(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$EXPONENT;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:133:10: ( ( 'e' | 'E' ) ( PLUS | MINUS )? DIGITS ) 
            // ManchesterTokenizer.g:133:12: ( 'e' | 'E' ) ( PLUS | MINUS )? DIGITS 
            {
            if ( $this->input->LA(1)==$this->getToken('69')||$this->input->LA(1)==$this->getToken('101') ) {
                $this->input->consume();

            }
            else {
                $mse = new MismatchedSetException(null,$this->input);
                $this->recover($mse);
                throw $mse;}

            // ManchesterTokenizer.g:133:25: ( PLUS | MINUS )? 
            $alt10=2;
            $LA10_0 = $this->input->LA(1);

            if ( ($LA10_0==$this->getToken('43')||$LA10_0==$this->getToken('45')) ) {
                $alt10=1;
            }
            switch ($alt10) {
                case 1 :
                    // ManchesterTokenizer.g: 
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

            $this->mDIGITS(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "EXPONENT"

    // $ANTLR start "PREFIX_NAME"
    function mPREFIX_NAME(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$PREFIX_NAME;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:134:13: ( PN_PREFIX ':' ) 
            // ManchesterTokenizer.g:134:15: PN_PREFIX ':' 
            {
            $this->mPN_PREFIX(); 
            $this->matchChar(58); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "PREFIX_NAME"

    // $ANTLR start "ABBREVIATED_IRI"
    function mABBREVIATED_IRI(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$ABBREVIATED_IRI;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:135:17: ( PREFIX_NAME SIMPLE_IRI ) 
            // ManchesterTokenizer.g:135:19: PREFIX_NAME SIMPLE_IRI 
            {
            $this->mPREFIX_NAME(); 
            $this->mSIMPLE_IRI(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ABBREVIATED_IRI"

    // $ANTLR start "SIMPLE_IRI"
    function mSIMPLE_IRI(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$SIMPLE_IRI;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:136:12: ( ( PN_CHARS_U ) ( ( DOT )? PN_CHARS )* ) 
            // ManchesterTokenizer.g:136:14: ( PN_CHARS_U ) ( ( DOT )? PN_CHARS )* 
            {
            // ManchesterTokenizer.g:136:14: ( PN_CHARS_U ) 
            // ManchesterTokenizer.g:136:15: PN_CHARS_U 
            {
            $this->mPN_CHARS_U(); 

            }

            // ManchesterTokenizer.g:136:27: ( ( DOT )? PN_CHARS )* 
            //loop12:
            do {
                $alt12=2;
                $LA12_0 = $this->input->LA(1);

                if ( (($LA12_0>=$this->getToken('45') && $LA12_0<=$this->getToken('46'))||($LA12_0>=$this->getToken('48') && $LA12_0<=$this->getToken('57'))||($LA12_0>=$this->getToken('65') && $LA12_0<=$this->getToken('90'))||$LA12_0==$this->getToken('95')||($LA12_0>=$this->getToken('97') && $LA12_0<=$this->getToken('122'))) ) {
                    $alt12=1;
                }


                switch ($alt12) {
            	case 1 :
            	    // ManchesterTokenizer.g:136:28: ( DOT )? PN_CHARS 
            	    {
            	    // ManchesterTokenizer.g:136:28: ( DOT )? 
            	    $alt11=2;
            	    $LA11_0 = $this->input->LA(1);

            	    if ( ($LA11_0==$this->getToken('46')) ) {
            	        $alt11=1;
            	    }
            	    switch ($alt11) {
            	        case 1 :
            	            // ManchesterTokenizer.g:136:28: DOT 
            	            {
            	            $this->mDOT(); 

            	            }
            	            break;

            	    }

            	    $this->mPN_CHARS(); 

            	    }
            	    break;

            	default :
            	    break 2;//loop12;
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
    // $ANTLR end "SIMPLE_IRI"

    // $ANTLR start "ILITERAL_HELPER"
    function mILITERAL_HELPER(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$ILITERAL_HELPER;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            $s=null;

            // ManchesterTokenizer.g:138:17: ( (s= PLUS | s= MINUS )? DIGITS ) 
            // ManchesterTokenizer.g:138:19: (s= PLUS | s= MINUS )? DIGITS 
            {
            // ManchesterTokenizer.g:138:19: (s= PLUS | s= MINUS )? 
            $alt13=3;
            $LA13_0 = $this->input->LA(1);

            if ( ($LA13_0==$this->getToken('43')) ) {
                $alt13=1;
            }
            else if ( ($LA13_0==$this->getToken('45')) ) {
                $alt13=2;
            }
            switch ($alt13) {
                case 1 :
                    // ManchesterTokenizer.g:138:20: s= PLUS 
                    {
                    $sStart800 = $this->getCharIndex();
                    $this->mPLUS(); 
                    $s = new CommonToken($this->input, TokenConst::$INVALID_TOKEN_TYPE, TokenConst::$DEFAULT_CHANNEL, $sStart800, $this->getCharIndex()-1);

                    }
                    break;
                case 2 :
                    // ManchesterTokenizer.g:138:29: s= MINUS 
                    {
                    $sStart806 = $this->getCharIndex();
                    $this->mMINUS(); 
                    $s = new CommonToken($this->input, TokenConst::$INVALID_TOKEN_TYPE, TokenConst::$DEFAULT_CHANNEL, $sStart806, $this->getCharIndex()-1);

                    }
                    break;

            }

            $this->mDIGITS(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "ILITERAL_HELPER"

    // $ANTLR start "DLITERAL_HELPER"
    function mDLITERAL_HELPER(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DLITERAL_HELPER;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:139:17: ( ( PLUS | MINUS )? DIGITS DOT DIGITS ) 
            // ManchesterTokenizer.g:139:19: ( PLUS | MINUS )? DIGITS DOT DIGITS 
            {
            // ManchesterTokenizer.g:139:19: ( PLUS | MINUS )? 
            $alt14=2;
            $LA14_0 = $this->input->LA(1);

            if ( ($LA14_0==$this->getToken('43')||$LA14_0==$this->getToken('45')) ) {
                $alt14=1;
            }
            switch ($alt14) {
                case 1 :
                    // ManchesterTokenizer.g: 
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

            $this->mDIGITS(); 
            $this->mDOT(); 
            $this->mDIGITS(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "DLITERAL_HELPER"

    // $ANTLR start "FPLITERAL_HELPER"
    function mFPLITERAL_HELPER(){
        try {
            $_type = Erfurt_Syntax_Manchester_ManchesterTokenizer::$FPLITERAL_HELPER;
            $_channel = Erfurt_Syntax_Manchester_ManchesterTokenizer::$DEFAULT_TOKEN_CHANNEL;
            // ManchesterTokenizer.g:140:18: ( ( PLUS | MINUS )? ( ( DIGITS ( DOT DIGITS )? ( EXPONENT )? ) | DOT DIGITS ( EXPONENT )? ) F_LABEL ) 
            // ManchesterTokenizer.g:140:20: ( PLUS | MINUS )? ( ( DIGITS ( DOT DIGITS )? ( EXPONENT )? ) | DOT DIGITS ( EXPONENT )? ) F_LABEL 
            {
            // ManchesterTokenizer.g:140:20: ( PLUS | MINUS )? 
            $alt15=2;
            $LA15_0 = $this->input->LA(1);

            if ( ($LA15_0==$this->getToken('43')||$LA15_0==$this->getToken('45')) ) {
                $alt15=1;
            }
            switch ($alt15) {
                case 1 :
                    // ManchesterTokenizer.g: 
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

            // ManchesterTokenizer.g:140:38: ( ( DIGITS ( DOT DIGITS )? ( EXPONENT )? ) | DOT DIGITS ( EXPONENT )? ) 
            $alt19=2;
            $LA19_0 = $this->input->LA(1);

            if ( (($LA19_0>=$this->getToken('48') && $LA19_0<=$this->getToken('57'))) ) {
                $alt19=1;
            }
            else if ( ($LA19_0==$this->getToken('46')) ) {
                $alt19=2;
            }
            else {
                $nvae = new NoViableAltException("", 19, 0, $this->input);

                throw $nvae;
            }
            switch ($alt19) {
                case 1 :
                    // ManchesterTokenizer.g:140:40: ( DIGITS ( DOT DIGITS )? ( EXPONENT )? ) 
                    {
                    // ManchesterTokenizer.g:140:40: ( DIGITS ( DOT DIGITS )? ( EXPONENT )? ) 
                    // ManchesterTokenizer.g:140:41: DIGITS ( DOT DIGITS )? ( EXPONENT )? 
                    {
                    $this->mDIGITS(); 
                    // ManchesterTokenizer.g:140:48: ( DOT DIGITS )? 
                    $alt16=2;
                    $LA16_0 = $this->input->LA(1);

                    if ( ($LA16_0==$this->getToken('46')) ) {
                        $alt16=1;
                    }
                    switch ($alt16) {
                        case 1 :
                            // ManchesterTokenizer.g:140:49: DOT DIGITS 
                            {
                            $this->mDOT(); 
                            $this->mDIGITS(); 

                            }
                            break;

                    }

                    // ManchesterTokenizer.g:140:62: ( EXPONENT )? 
                    $alt17=2;
                    $LA17_0 = $this->input->LA(1);

                    if ( ($LA17_0==$this->getToken('69')||$LA17_0==$this->getToken('101')) ) {
                        $alt17=1;
                    }
                    switch ($alt17) {
                        case 1 :
                            // ManchesterTokenizer.g:140:62: EXPONENT 
                            {
                            $this->mEXPONENT(); 

                            }
                            break;

                    }


                    }


                    }
                    break;
                case 2 :
                    // ManchesterTokenizer.g:140:75: DOT DIGITS ( EXPONENT )? 
                    {
                    $this->mDOT(); 
                    $this->mDIGITS(); 
                    // ManchesterTokenizer.g:140:86: ( EXPONENT )? 
                    $alt18=2;
                    $LA18_0 = $this->input->LA(1);

                    if ( ($LA18_0==$this->getToken('69')||$LA18_0==$this->getToken('101')) ) {
                        $alt18=1;
                    }
                    switch ($alt18) {
                        case 1 :
                            // ManchesterTokenizer.g:140:86: EXPONENT 
                            {
                            $this->mEXPONENT(); 

                            }
                            break;

                    }


                    }
                    break;

            }

            $this->mF_LABEL(); 

            }

            $this->state->type = $_type;
            $this->state->channel = $_channel;
        }
        catch(Exception $e){
            throw $e;
        }
    }
    // $ANTLR end "FPLITERAL_HELPER"

    function mTokens(){
        // ManchesterTokenizer.g:1:8: ( F_LABEL | LENGTH_LABEL | MIN_LENGTH_LABEL | MAX_LENGTH_LABEL | PATTERN_LABEL | LANG_PATTERN_LABEL | THAT_LABEL | INVERSE_LABEL | MINUS | DOT | PLUS | DIGITS | NOT_LABEL | WS | LESS_EQUAL | GREATER_EQUAL | LESS | GREATER | OPEN_CURLY_BRACE | CLOSE_CURLY_BRACE | OR_LABEL | AND_LABEL | SOME_LABEL | ONLY_LABEL | VALUE_LABEL | SELF_LABEL | MIN_LABEL | MAX_LABEL | EXACTLY_LABEL | COMMA | OPEN_BRACE | CLOSE_BRACE | DECIMAL_LABEL | FLOAT_LABEL | INTEGER_LABEL | STRING_LABEL | REFERENCE | FULL_IRI | NODE_ID | OPEN_SQUARE_BRACE | CLOSE_SQUARE_BRACE | QUOTED_STRING | LANGUAGE_TAG | EXPONENT | PREFIX_NAME | ABBREVIATED_IRI | SIMPLE_IRI | ILITERAL_HELPER | DLITERAL_HELPER | FPLITERAL_HELPER ) 
        $alt20=50;
        $alt20 = $this->dfa20->predict($this->input);
        switch ($alt20) {
            case 1 :
                // ManchesterTokenizer.g:1:10: F_LABEL 
                {
                $this->mF_LABEL(); 

                }
                break;
            case 2 :
                // ManchesterTokenizer.g:1:18: LENGTH_LABEL 
                {
                $this->mLENGTH_LABEL(); 

                }
                break;
            case 3 :
                // ManchesterTokenizer.g:1:31: MIN_LENGTH_LABEL 
                {
                $this->mMIN_LENGTH_LABEL(); 

                }
                break;
            case 4 :
                // ManchesterTokenizer.g:1:48: MAX_LENGTH_LABEL 
                {
                $this->mMAX_LENGTH_LABEL(); 

                }
                break;
            case 5 :
                // ManchesterTokenizer.g:1:65: PATTERN_LABEL 
                {
                $this->mPATTERN_LABEL(); 

                }
                break;
            case 6 :
                // ManchesterTokenizer.g:1:79: LANG_PATTERN_LABEL 
                {
                $this->mLANG_PATTERN_LABEL(); 

                }
                break;
            case 7 :
                // ManchesterTokenizer.g:1:98: THAT_LABEL 
                {
                $this->mTHAT_LABEL(); 

                }
                break;
            case 8 :
                // ManchesterTokenizer.g:1:109: INVERSE_LABEL 
                {
                $this->mINVERSE_LABEL(); 

                }
                break;
            case 9 :
                // ManchesterTokenizer.g:1:123: MINUS 
                {
                $this->mMINUS(); 

                }
                break;
            case 10 :
                // ManchesterTokenizer.g:1:129: DOT 
                {
                $this->mDOT(); 

                }
                break;
            case 11 :
                // ManchesterTokenizer.g:1:133: PLUS 
                {
                $this->mPLUS(); 

                }
                break;
            case 12 :
                // ManchesterTokenizer.g:1:138: DIGITS 
                {
                $this->mDIGITS(); 

                }
                break;
            case 13 :
                // ManchesterTokenizer.g:1:145: NOT_LABEL 
                {
                $this->mNOT_LABEL(); 

                }
                break;
            case 14 :
                // ManchesterTokenizer.g:1:155: WS 
                {
                $this->mWS(); 

                }
                break;
            case 15 :
                // ManchesterTokenizer.g:1:158: LESS_EQUAL 
                {
                $this->mLESS_EQUAL(); 

                }
                break;
            case 16 :
                // ManchesterTokenizer.g:1:169: GREATER_EQUAL 
                {
                $this->mGREATER_EQUAL(); 

                }
                break;
            case 17 :
                // ManchesterTokenizer.g:1:183: LESS 
                {
                $this->mLESS(); 

                }
                break;
            case 18 :
                // ManchesterTokenizer.g:1:188: GREATER 
                {
                $this->mGREATER(); 

                }
                break;
            case 19 :
                // ManchesterTokenizer.g:1:196: OPEN_CURLY_BRACE 
                {
                $this->mOPEN_CURLY_BRACE(); 

                }
                break;
            case 20 :
                // ManchesterTokenizer.g:1:213: CLOSE_CURLY_BRACE 
                {
                $this->mCLOSE_CURLY_BRACE(); 

                }
                break;
            case 21 :
                // ManchesterTokenizer.g:1:231: OR_LABEL 
                {
                $this->mOR_LABEL(); 

                }
                break;
            case 22 :
                // ManchesterTokenizer.g:1:240: AND_LABEL 
                {
                $this->mAND_LABEL(); 

                }
                break;
            case 23 :
                // ManchesterTokenizer.g:1:250: SOME_LABEL 
                {
                $this->mSOME_LABEL(); 

                }
                break;
            case 24 :
                // ManchesterTokenizer.g:1:261: ONLY_LABEL 
                {
                $this->mONLY_LABEL(); 

                }
                break;
            case 25 :
                // ManchesterTokenizer.g:1:272: VALUE_LABEL 
                {
                $this->mVALUE_LABEL(); 

                }
                break;
            case 26 :
                // ManchesterTokenizer.g:1:284: SELF_LABEL 
                {
                $this->mSELF_LABEL(); 

                }
                break;
            case 27 :
                // ManchesterTokenizer.g:1:295: MIN_LABEL 
                {
                $this->mMIN_LABEL(); 

                }
                break;
            case 28 :
                // ManchesterTokenizer.g:1:305: MAX_LABEL 
                {
                $this->mMAX_LABEL(); 

                }
                break;
            case 29 :
                // ManchesterTokenizer.g:1:315: EXACTLY_LABEL 
                {
                $this->mEXACTLY_LABEL(); 

                }
                break;
            case 30 :
                // ManchesterTokenizer.g:1:329: COMMA 
                {
                $this->mCOMMA(); 

                }
                break;
            case 31 :
                // ManchesterTokenizer.g:1:335: OPEN_BRACE 
                {
                $this->mOPEN_BRACE(); 

                }
                break;
            case 32 :
                // ManchesterTokenizer.g:1:346: CLOSE_BRACE 
                {
                $this->mCLOSE_BRACE(); 

                }
                break;
            case 33 :
                // ManchesterTokenizer.g:1:358: DECIMAL_LABEL 
                {
                $this->mDECIMAL_LABEL(); 

                }
                break;
            case 34 :
                // ManchesterTokenizer.g:1:372: FLOAT_LABEL 
                {
                $this->mFLOAT_LABEL(); 

                }
                break;
            case 35 :
                // ManchesterTokenizer.g:1:384: INTEGER_LABEL 
                {
                $this->mINTEGER_LABEL(); 

                }
                break;
            case 36 :
                // ManchesterTokenizer.g:1:398: STRING_LABEL 
                {
                $this->mSTRING_LABEL(); 

                }
                break;
            case 37 :
                // ManchesterTokenizer.g:1:411: REFERENCE 
                {
                $this->mREFERENCE(); 

                }
                break;
            case 38 :
                // ManchesterTokenizer.g:1:421: FULL_IRI 
                {
                $this->mFULL_IRI(); 

                }
                break;
            case 39 :
                // ManchesterTokenizer.g:1:430: NODE_ID 
                {
                $this->mNODE_ID(); 

                }
                break;
            case 40 :
                // ManchesterTokenizer.g:1:438: OPEN_SQUARE_BRACE 
                {
                $this->mOPEN_SQUARE_BRACE(); 

                }
                break;
            case 41 :
                // ManchesterTokenizer.g:1:456: CLOSE_SQUARE_BRACE 
                {
                $this->mCLOSE_SQUARE_BRACE(); 

                }
                break;
            case 42 :
                // ManchesterTokenizer.g:1:475: QUOTED_STRING 
                {
                $this->mQUOTED_STRING(); 

                }
                break;
            case 43 :
                // ManchesterTokenizer.g:1:489: LANGUAGE_TAG 
                {
                $this->mLANGUAGE_TAG(); 

                }
                break;
            case 44 :
                // ManchesterTokenizer.g:1:502: EXPONENT 
                {
                $this->mEXPONENT(); 

                }
                break;
            case 45 :
                // ManchesterTokenizer.g:1:511: PREFIX_NAME 
                {
                $this->mPREFIX_NAME(); 

                }
                break;
            case 46 :
                // ManchesterTokenizer.g:1:523: ABBREVIATED_IRI 
                {
                $this->mABBREVIATED_IRI(); 

                }
                break;
            case 47 :
                // ManchesterTokenizer.g:1:539: SIMPLE_IRI 
                {
                $this->mSIMPLE_IRI(); 

                }
                break;
            case 48 :
                // ManchesterTokenizer.g:1:550: ILITERAL_HELPER 
                {
                $this->mILITERAL_HELPER(); 

                }
                break;
            case 49 :
                // ManchesterTokenizer.g:1:566: DLITERAL_HELPER 
                {
                $this->mDLITERAL_HELPER(); 

                }
                break;
            case 50 :
                // ManchesterTokenizer.g:1:582: FPLITERAL_HELPER 
                {
                $this->mFPLITERAL_HELPER(); 

                }
                break;

        }

    }



}
?>