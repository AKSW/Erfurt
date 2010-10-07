<?php
/**
 * Created by PhpStorm.
 * User: roll
 * Date: Aug 27, 2010
 * Time: 4:12:22 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Erfurt_Owl_Structured_Axiom_AnnotationAxiom_AnnotationPropertyDomain extends Erfurt_Owl_Structured_Axiom_AnnotationAxiom {
    private $domain;

    function __construct($annotationProperty, $domain) {
        parent::__construct($annotationProperty);
        $this->domain = $domain;
    }

}
