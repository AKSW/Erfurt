<?php

	class CommonToken implements Token {

		/*	public CommonToken(int type) {
			$this->type = type;
		}
		*/
		public function __construct($input=null, $type, $channel=0, $start=0, $stop=0) {
			/*if (is_object($type) && instanceof Token) 
			{

			} */
			$this->input = $input;
			$this->charPositionInLine=$start;		
			$this->type = $type;
			$this->index = 0;
			$this->text = null;
			
			if (is_int($channel)) {
				$this->channel = $channel;
			} else if (is_string($channel)) {			
				$this->channel = TokenConst::$DEFAULT_CHANNEL;
				$this->text = $channel;
			}
			
			$this->start = $start;
			$this->stop = $stop;
			$this->line = 0;
		}
		
		public static function forType($type){
			return new CommonToken($input=null, $type);
		}

		public function FromToken(Token $oldToken) {
			$text = $oldToken->getText();
			$type = $oldToken->getType();
			$line = $oldToken->getLine();
			$index = $oldToken->getTokenIndex();
			$charPositionInLine = $oldToken->getCharPositionInLine();
			$channel = $oldToken->getChannel();
			if ( $oldToken instanceof CommonToken ) {
				$start = $oldToken->start;
				$stop = $oldToken->stop;
			}
			$token = new CommonToken(null, $type, $channel, $start, $stop);
			$token->text = $text;
			$token->line = $line;
			$token->index = $index;
			$token->charPositionInLine = $charPositionInLine;
			return $token;
		}
		
		public function getType() {
			return $this->type;
		}

		public function setLine($line) {
			$this->line = $line;
		}

		public function getText() {
			if ( $this->text!=null ) {
				return $this->text;
			}
			if ( $this->input==null ) {
				return null;
			}
			$this->text = $this->input->substring($this->start,$this->stop);
			return $this->text;
		}

		/** Override the text for this token.  getText() will return this text
		 *  rather than pulling from the buffer.  Note that this does not mean
		 *  that start/stop indexes are not valid.  It means that that input
		 *  was converted to a new string in the token object.
		 */
		public function setText($text) {
			$this->text = $text;
		}

		public function getLine() {
			return $this->line;
		}

		public function getCharPositionInLine() {
			return $this->charPositionInLine;
		}

		public function setCharPositionInLine($charPositionInLine) {
			$this->charPositionInLine = $charPositionInLine;
		}

		public function getChannel() {
			return $this->channel;
		}

		public function setChannel($channel) {
			$this->channel = $channel;
		}

		public function setType($type) {
			$this->type = $type;
		}

		public function getStartIndex() {
			return $this->start;
		}

		public function setStartIndex($start) {
			$this->start = $start;
		}

		public function getStopIndex() {
			return $this->stop;
		}

		public function setStopIndex($stop) {
			$this->stop = $stop;
		}

		public function getTokenIndex() {
			return $this->index;
		}

		public function setTokenIndex($index) {
			$this->index = $index;
		}

		public function getInputStream() {
			return $this->input;
		}

		public function setInputStream($input) {
			$this->input = $input;
		}

		public function toString() {
			$channelStr = "";
			if ( $this->channel>0 ) {
				$channelStr=",channel=".$this->channel;
			}
			$txt = $this->getText();
			if ( $txt!=null ) {
				$txt = str_replace("\n",'\n', $txt);
				$txt = str_replace("\r",'\r', $txt);
				$txt = str_replace("\t",'\t', $txt);
			}
			else {
				$txt = "<no text>";
			}
			return "[@".$this->getTokenIndex().",".$this->start.":".$this->stop."='".$txt."',<".$this->type.">".$channelStr.",".$this->line.":".$this->getCharPositionInLine()."]";
		}
		
		public function __toString(){
			return $this->toString();
		}
	}
	
?>
