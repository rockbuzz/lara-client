<?php

namespace Tests;

use Rockbuzz\LaraClient\Token;

class TokenTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldStringWith32Characters()
    {
        $string = Token::publicKey();

        $this->assertEquals(32, strlen($string));
    }

    /**
     * @test
     */
    public function itShouldStringWith64Characters()
    {
        $string = Token::secretKey();

        dd($string);

        $this->assertEquals(64, strlen($string));
    }
}
