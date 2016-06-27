<?php
define('QUERY_REPEAT_COUNT', 100);

define('_TESTROOT', rtrim(dirname(dirname(__FILE__)), '\\/') . '/');
define('_BASE', rtrim(realpath(_TESTROOT . '../'), '\\/') . '/');

// add Erfurt lib to include path
$includePath  = get_include_path()          . PATH_SEPARATOR;
$includePath .= _BASE                       . PATH_SEPARATOR;
$includePath .= _BASE . 'Erfurt/libraries/' . PATH_SEPARATOR;
$includePath .= _BASE . 'Erfurt/libraries/antlr/Php' . PATH_SEPARATOR;
$includePath .= _BASE . '../' . PATH_SEPARATOR;
set_include_path($includePath);

// We need a session for authentication
require_once 'Zend/Session/Namespace.php';
$session = new Zend_Session_Namespace('Erfurt_Test');


// Zend_Loader for class autoloading
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Erfurt_');

$queryFiles = array();
$queryDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'queries';
$files = scandir($queryDir);
foreach ($files as $file) {
    if ($file[0] === '.') {
        continue;
    }
    $queryFiles[$file] = $queryDir . DIRECTORY_SEPARATOR . $file;
}

if (is_readable(_TESTROOT . 'config.ini')) {
    require_once 'Zend/Config/Ini.php';
    $testConfig = new Zend_Config_Ini((_TESTROOT . 'config.ini'), 'private', true);
    
    Erfurt_App::getInstance()->loadConfig($testConfig);
}

$erfurt = Erfurt_App::getInstance();
$store = $erfurt->getStore();

// We don't want authentication here!
$dbUser = $store->getDbUser();
$dbPass = $store->getDbPassword();
Erfurt_App::getInstance()->authenticate($dbUser, $dbPass);

foreach ($queryFiles as $name=>$queryFile) {
    echo "Query $name: " . PHP_EOL;
    $query = trim(file_get_contents($queryFile));
    
    $durationSum = 0;
    $durationMin = 1000000;
    $durationMax = 0;
    
    $allStart = microtime(true);
    for ($j=0; $j<QUERY_REPEAT_COUNT; ++$j) {
        $start = microtime(true);
        $result = $store->sparqlQuery($query);
        #var_dump($result);exit;
        $end = microtime (true);
        
        $duration = $end - $start;
        if ($duration < $durationMin) {
            $durationMin = $duration;
        }
        if ($duration > $durationMax) {
            $durationMax = $duration;
        }
        
        $durationSum += $duration;
    }
    $allEnd = microtime(true);
    $allSum = $allEnd - $allStart;
    
    $durationAvg = $durationSum / QUERY_REPEAT_COUNT;
    $echoStr = sprintf('AVG: %.2f secs, MIN: %.2f secs, MAX: %.2f secs', $durationAvg, $durationMin, $durationMax);
    echo $echoStr . PHP_EOL;
    $echoStr = sprintf('Duration for %d rounds: %.2f secs', QUERY_REPEAT_COUNT, $allSum);
    echo $echoStr . PHP_EOL . PHP_EOL;
}
