<?php
/** When walking ahead with cyclic DFA or for syntactic predicates,
 *  we need to record the state of the input stream (char index,
 *  line, etc...) so that we can rewind the state after scanning ahead.
 *
 *  This is the complete state of a stream.
 */
class CharStreamState {
	/** Index into the char stream of next lookahead char */
	public $p;

	/** What line number is the scanner at before processing buffer[p]? */
	public $line;
	
	/** What char position 0..n-1 in line is scanner before processing buffer[p]? */
	public $charPositionInLine;
}

?>
