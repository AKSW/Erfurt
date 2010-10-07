<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 27, 2010
 * Time: 4:12:28 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Axiom_AnnotationAxiom_AnnotationPropertyRange extends Erfurt_Owl_Structured_Axiom_AnnotationAxiom {

    private $range;

    function __construct($annotationProperty, $range) {
        parent::__construct($annotationProperty);
        $this->range = $range;
    }

}
