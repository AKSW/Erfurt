<?php

class Erfurt_Owl_Structured_Literal_IntegerLiteral extends Erfurt_Owl_Structured_Literal {

    public function getDataType() {
        return "integer";
    }

    public function getDatatypeString() {
        return "xsd:integer";
    }
}
