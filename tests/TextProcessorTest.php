<?php

use App\Models\CubeProcessor\TextProcessor;
use App\Models\Entities\Input;
use App\Models\Entities\Operation;
use App\Models\Entities\UserCase;

class TextProcessorTest extends TestCase
{
	public function test_InputCreation(){
		$text = "1\n4 2\nUPDATE 2 2 2 4\nQUERY 1 1 1 3 3 3";
		$processor = new TextProcessor();
		$this->assertInstanceOf('App\Models\Entities\Input',$processor->ValidateText($text));
	}

}