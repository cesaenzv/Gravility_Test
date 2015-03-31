<?php

use App\Models\TextManager\TextProcessor;

class TextProcessorTest extends TestCase
{
	public function test_InputCreation(){
		$text = "1\n4 2\nUPDATE 2 2 2 4\nQUERY 1 1 1 3 3 3";
		$processor = new TextProcessor();
		$this->assertInstanceOf('App\Models\Entities\Input',$processor->ValidateText($text));
	}

	public function test_WrongLinePassedFalse(){
		$text = "0\n4 2\nUPDATE 2 2 2 4\nQUERY 1 1 1 3 3 3";
		$processor = new TextProcessor();
		$this->assertFalse($processor->ValidateText($text)->passed);
		$text = "0\n4 \nUPDATE 2 2 2 4\nQUERY 1 1 1 3 3 3";
		$processor = new TextProcessor();
		$this->assertFalse($processor->ValidateText($text)->passed);
		$text = "0\n4 2\nUPDATE 2 2 4\nQUERY 1 1 1 3 3 3";
		$processor = new TextProcessor();
		$this->assertFalse($processor->ValidateText($text)->passed);
	}

}