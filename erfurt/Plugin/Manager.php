<?

/**
  * Erfurt plug-in manager
  *
  * @package Plugin
  * @author Norman Heino <norman@feedface.de>
  * @version $Id$
  */
class Erfurt_Plugin_Manager {
	
	/**
	  * @var An array of plug-ins found and loaded.
	  */
	protected $_activePlugins;
	
	/**
	  * @var An array of plug-in dirs to be scanned.
	  */
	protected $_pluginDirs;
	
	/**
	  * Constructs an erfurt plug-in manager object.
	  *
	  * @param array|string $pluginDirs One ore more directories to be
	  * scanned for plug-ins.
	  */
	public function __contruct($pluginDirs = array()) {
		$this->_activePlugins = array();
		$this->_activeWidgets = array();
		
		if (is_array($pluginDirs)) {
			$this->_pluginDirs = $pluginDirs();
		} elseif (is_string($pluginDirs)) {
			$this->_pluginDirs[] = $pluginDirs;
		}
	}
	
	/**
	  * Add a plug-in directory to be searched.
	  *
	  * @param string $path The path to a plug-in directory. 
	  */
	public function addPluginDir($path) {
		if (file_exists($path)) {
			$this->_pluginDirs[] = $path;
		}
	}
	
	/**
	  * Returns an array of plug-in class names found in the plug-in directories.
	  *
	  * @return array
	  */
	public function getActivePlugins() {
		if (empty($this->_activePlugins)) {
			$this->_scanPluginDirs();
		}
		return $this->_activePlugins;
	}
	
	/**
	  * Returns true iff the given plug-in class name has been found and
	  * can be instantiated.
	  *
	  * @param string $className The name of a plug-in class.
	  */
	public function isPluginActive($className) {
		if (empty($this->_activePlugins)) {
			$this->_scanPluginDirs();
		}
		return in_array($className, $this->_activePlugins);
	}
	
	/**
	  * Scans directories for plug-ins and stores their class names
	  * in an array.
	  */
	private function _scanPluginDirs() {
		foreach ($this->_pluginDirs as $directory) {
			$contents = scandir($directory);
			
			// scan dir contens
			foreach ($contents as $fileName) {
				$searchPath = $directory . $fileName;
				$pathInfo = pathinfo($searchPath);
				
				if (is_dir($searchPath)) {
					// if it's a directory, scan its contents for a file of the same name
					// but with a .php extension
					if (file_exists($searchPath . DIRECTORY_SEPARATOR . $fileName . '.php')) {
						if (!class_exists($fileName)) {
							include_once $searchPath . DIRECTORY_SEPARATOR . $fileName . '.php';
							$className = $fileName;
						} else {
							throw new Erfurt_Exception('Class ' . $fileName . ' already exists!');
						}
					}
				// scan for file-only plug-ins
				} elseif ($pathInfo['extension'] === 'php') {
					if (!class_exists($fileName)) {
						include_once $searchPath;
						$className = substr($fileName, 0, strlen($fileName) - 4);
					} else {
						throw new Erfurt_Exception('Class ' . $fileName . ' already exists!');
					}
				}
				
				// add class found
				if ($className && class_exists($className)) {
					$this->_activePlugins[] = $className;
					unset($className);
				}
			}
		}
	}
}

?>
