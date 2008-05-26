<?php
class Erfurt_Sparql_QueryResultVariable
{
    public $variable = null;
    public $datatype = null;
    public $language = null;
    public $alias    = null;
    public $func     = null;


    public function __construct($variable)
    {
        $this->variable = $variable;
        $this->language = Erfurt_Sparql_Query::getLanguageTag($variable);
    }



    public function setAlias($alias)
    {
        $this->alias = $alias;
    }



    public function setFunc($func)
    {
        $this->func = $func;
    }



    public function setDatatype($datatype)
    {
        $this->datatype = $datatype;
    }



    public function getId()
    {
        //FIXME
        return $this->variable;
    }



    public function getFunc()
    {
        return $this->func;
    }



    public function getLanguage()
    {
        return $this->language;
    }



    public function getDatatype()
    {
        return $this->datatype;
    }



    public function getName()
    {
        if ($this->alias !== null) {
            return $this->alias;
        }
        //FIXME: support for nested(functions())
        return $this->variable;
    }



    public function getVariable()
    {
        return $this->variable;
    }



    public function __toString()
    {
        return $this->getName();
    }

}//class Query_ResultVariable
?>