<?php
if (!defined('ERFURT_TEST_CONFIG')) {
	require_once '../../config.php';
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	define('PHPUnit_MAIN_METHOD', 'Erfurt_Rdfs_TestSuite::main');
}

class Erfurt_Rdfs_TestSuite {
	
	public static function main() {
		
		echo "<pre>";
		PHPUnit_TextUI_TestRunner::run(self::suite());
		echo "</pre>";
	}
	
	public static function suite() {
		
		$suite = new PHPUnit_Framework_TestSuite();
		
		$suite->addTest(RDFSModelTest::suite());
		$suite->addTest(Erfurt_Rdfs_Property_DefaultTest::suite());
		$suite->addTest(Erfurt_Rdfs_Resource_DefaultTest::suite());
		
		return $suite;
	}
}

if (PHPUnit_MAIN_METHOD == 'Erfurt_Rdfs_TestSuite::main') {
	Erfurt_Rdfs_TestSuite::main();
}
?>
