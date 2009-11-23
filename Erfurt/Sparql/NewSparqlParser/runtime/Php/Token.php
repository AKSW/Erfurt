<?php

	require_once 'CommonToken.php';

	class TokenConst{
		public static $EOR_TOKEN_TYPE = 1;

		/** imaginary tree navigation type; traverse "get child" link */
		public static $DOWN = 2;
		/** imaginary tree navigation type; finish with a child list */
		public static $UP = 3;

		public static $MIN_TOKEN_TYPE;// = UP+1;

		public static $EOF;// = CharStream.EOF;
		public static $EOF_TOKEN;// = new CommonToken(EOF);

		public static $INVALID_TOKEN_TYPE = 0;
		public static $INVALID_TOKEN;// = new CommonToken(INVALID_TOKEN_TYPE);

		/** In an action, a lexer rule can set token to this SKIP_TOKEN and ANTLR
		 *  will avoid creating a token for this symbol and try to fetch another.
		 */
		public static $SKIP_TOKEN;// = new CommonToken(INVALID_TOKEN_TYPE);

		/** All tokens go to the parser (unless skip() is called in that rule)
		 *  on a particular "channel".  The parser tunes to a particular channel
		 *  so that whitespace etc... can go to the parser on a "hidden" channel.
		 */
		public static $DEFAULT_CHANNEL = 0;

		/** Anything on different channel than DEFAULT_CHANNEL is not parsed
		 *  by parser.
		 */
		public static $HIDDEN_CHANNEL = 99;
	}
	
	
	interface Token{
	}
	
	TokenConst::$DEFAULT_CHANNEL=0;
	TokenConst::$INVALID_TOKEN_TYPE=0;

	TokenConst::$EOF = CharStreamConst::$EOF;
	TokenConst::$EOF_TOKEN = CommonToken::forType(TokenConst::$EOF);
	
	TokenConst::$INVALID_TOKEN_TYPE = 0;
	TokenConst::$INVALID_TOKEN = CommonToken::forType(TokenConst::$INVALID_TOKEN_TYPE);
	/** In an action, a lexer rule can set token to this SKIP_TOKEN and ANTLR
	 *  will avoid creating a token for this symbol and try to fetch another.
	 */
	TokenConst::$SKIP_TOKEN = CommonToken::forType(TokenConst::$INVALID_TOKEN_TYPE);
	
	/** All tokens go to the parser (unless skip() is called in that rule)
	 *  on a particular "channel".  The parser tunes to a particular channel
	 *  so that whitespace etc... can go to the parser on a "hidden" channel.
	 */
	TokenConst::$DEFAULT_CHANNEL = 0;
	
	/** Anything on different channel than DEFAULT_CHANNEL is not parsed
	 *  by parser.
	 */
	TokenConst::$HIDDEN_CHANNEL = 99;
	
	
	
	TokenConst::$MIN_TOKEN_TYPE = TokenConst::$UP+1;
	
?>
