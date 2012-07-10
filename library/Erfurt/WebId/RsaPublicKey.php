<?php
class Erfurt_WebId_RsaPublicKey
{
    protected $_modulus = null;
    protected $_exponent = null;
    
    public function __construct($modulus, $exponent)
    {
        $this->_modulus = strtolower(trim($modulus));
        $this->_exponent = (int)$exponent;
    }
    
    public function modulus()
    {
        return $this->_modulus;
    }
    
    public function exponent()
    {
        return $this->_exponent;
    }
    
    public function isEqual(Erfurt_WebId_RsaPublicKey $otherKey)
    {
        return (($this->exponent() === $otherKey->exponent()) &&  ($this->modulus() === $otherKey->modulus()));
    }
}
