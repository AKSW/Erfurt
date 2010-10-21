<?php
interface Erfurt_Owl_Structured_ITriples {

    public function toTriples();

    public function getPredicateString();

    public function isComplex();

    public function toArray();
}
