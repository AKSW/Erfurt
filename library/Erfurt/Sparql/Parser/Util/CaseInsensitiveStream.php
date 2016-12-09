<?php
/**
* Extends the ANTLRStringStream to use case insensitive grammar for tokens.
* in the grammar the strings are compared in lowercase
*/

class Erfurt_Sparql_Parser_Util_CaseInsensitiveStream extends ANTLRStringStream
{	
	public function LA($i)
	{
		if ( $i==0 ) {
			return 0; // undefined
		}
		if ( $i<0 ) {
			$i++; // e.g., translate LA(-1) to use offset i=0; then data[p+0-1]
			if ( ($this->p+$i-1) < 0 ) {
				return CharStreamConst::$EOF; // invalid; no char before first char
			}
		}

		if ( ($this->p+$i-1) >= $this->n ) {
	        return CharStreamConst::$EOF;
	        }
		return ord(strtolower(chr($this->data[$this->p+$i-1])));
		
	}
}

?>