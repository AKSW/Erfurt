<?php
interface Erfurt_Cache {
	
	public function load(DbModel $model, $function, $args, $resource);
	public function save(DbModel $model, $function, $args, $resource, $value, $triggers);
	public function expire(DbModel $model, Statement $stm = null);
	public function emptyCache(DbModel $model);
	public function expireFunction(DbModel $model, $function);
	
}
?>
