<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Libraries\FormulaParser;

class calculationFormulaTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testParserCalculatesWhenFormulaAndVariablesAreGiven(){
        $parser = new FormulaParser();
        $vars = ['x1' => '2', 'x2' => '1', 'x3' => '3'];
        $result =  $parser->set([
            'variables'=> $vars,
            'formula'=> 'x1 / x2 + x2 * x3 ',
        ])->run();
        $this->assertEquals($result, 5);
    }

    public function testParserReturnsMessageWhenFormulaIsNotSet(){
        $parser = new FormulaParser();
        $vars = ['x1' => '2', 'x2' => '1', 'x3' => '3'];
        $result =  $parser->set([
            'variables'=> $vars,
            'formula'=>''
        ])->run();
        $this->assertEquals($result, "formula not set");
    }
}
