<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 24, 2010
 * Time: 2:38:36 PM
 * To change this template use File | Settings | File Templates.
 */

interface Erfurt_Owl_Structured_IRdfPhp {

    public function toRdfArray();

    public function getValue();

    public function __toString();
}
