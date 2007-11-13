<?php
interface Erfurt_Store_DataInterface {
	
	public function executeAdd();
	public function executeRemove();
	public function executeFind();
	
	public function listModels();
	public function modelExists($modelURI);
	public function countAvailableModels();
	public function getModel($modelURI);
	public function getNewModel($modelURI,$baseURI=NULL);
	public function loadModel($modelURI,$file=NULL,$loadImports=false,$stream=false,$filetype=NULL);
	public function deleteModel($modelURI);
}
?>
