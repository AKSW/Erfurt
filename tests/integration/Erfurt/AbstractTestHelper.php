<?php

/**
 * Base class for test helper implementations.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 02.03.14
 */
abstract class Erfurt_AbstractTestHelper
{

    /**
     * Contains task callbacks that must be executed on tear down.
     *
     * @var array(mixed)
     */
    protected $cleanUpTasks = array();

    /**
     * Cleans up the environment.
     */
    public function cleanUp()
    {
        foreach (array_reverse($this->cleanUpTasks) as $task) {
            call_user_func($task);
        }
    }

    /**
     * Registers a task that must be executed on cleanup.
     *
     * @param mixed $callback
     */
    protected function addCleanUpTask($callback)
    {
        $this->cleanUpTasks[] = $callback;
    }

    /**
     * Loads the configuration for the adapter.
     *
     * @return array(mixed)
     * @throws \PHPUnit_Framework_SkippedTestError If the config does not exist.
     */
    protected function getConfig()
    {
        $file = strtolower($this->getHelperName()) . '.ini';
        $path = __DIR__ . '/../../' . $file;
        if (!is_file($path)) {
            $message = 'This test requires a connection configuration in the file '
                     . $file . ' in the test root. Use ' . $file . '.dist as a template.';
            throw new PHPUnit_Framework_SkippedTestError($message);
        }
        $config = new Zend_Config_Ini($path);
        return $config->toArray();
    }

    /**
     * Returns the name of this helper.
     *
     * The name is used to determine the corresponding config file.
     *
     * @return string
     */
    protected function getHelperName()
    {
        $class = get_class($this);
        $name  = substr($class, strlen('Erfurt_'), -strlen('TestHelper'));
        return $name;
    }

}
