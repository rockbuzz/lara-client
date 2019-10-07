<?php

namespace Tests;

use Rockbuzz\LaraClient\StrGenerate;

class StrGenerateTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldStringWith32Characters()
    {
        $string = StrGenerate::publicKey();

        $this->assertEquals(32, strlen($string));
    }

    /**
     * @test
     */
    public function itShouldStringWith64Characters()
    {
        $string = StrGenerate::secretKey();

        $this->assertEquals(64, strlen($string));
    }
}
