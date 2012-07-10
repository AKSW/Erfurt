<?php
abstract class Erfurt_WebId_Consumer_Storage
{
    abstract public function addUserWithProfile(Erfurt_WebId_Profile $profile);
    
    abstract public function hasUserWithProfile(Erfurt_WebId_Profile $profile);
    
    abstract public function userUriForProfile(Erfurt_WebId_Profile $profile);
}
