<?php
abstract class Erfurt_WebId_CertHandler
{
    abstract public function canHandleCertificates();
    abstract public function extractWebIdUris($certDataString);
    abstract public function extractRsaPublicKey($certDataString);
}
