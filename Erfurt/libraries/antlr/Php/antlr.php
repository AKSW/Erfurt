<?php
	set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__));

	require_once 'util.php';
	require_once 'Set.php';
	
	require_once 'IntStream.php';
	require_once 'CharStream.php';
	require_once 'RecognizerSharedState.php';
	require_once 'CharStreamState.php';
	require_once 'ANTLRStringStream.php';
	require_once 'ANTLRFileStream.php';
	require_once 'Token.php';
	require_once 'CommonToken.php';
	require_once 'TokenStream.php';
	require_once 'CommonTokenStream.php';

	# Exceptions
	require_once 'RecognitionException.php';
	require_once 'MismatchedTokenException.php';
	require_once 'MissingTokenException.php';
	require_once 'NoViableAltException.php';
	require_once 'EarlyExitException.php';
	require_once 'MismatchedRangeException.php';
	require_once 'MismatchedSetException.php';
	require_once 'FailedPredicateException.php';
	require_once 'UnwantedTokenException.php';

	# Recogizers
	require_once 'DFA.php';
	require_once 'BaseRecognizer.php';
	require_once 'Lexer.php';
	require_once 'Parser.php';
	
?>
