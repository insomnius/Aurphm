<?php
use PHPUnit\Framework\TestCase;
use Aurphm\Aurphm;

class AurphmTest extends TestCase
{

    /**
     * @dataProvider additionProvider
     */
    public function testHash($hash, $check, $expected)
    {
        $hash   = Aurphm::hash($hash[0], $hash[1]);
        $check  = Aurphm::authenticate($check[0], $check[1], $hash);

        $this->assertEquals($expected, $check);
    }

    public function additionProvider()
    {
        return [
            [
                ['credential', 'password'],
                ['credential', 'password'],
                1
            ],
            [
                ['username', 'key'],
                ['Username', 'key'],
                0
            ],
            [
                ['crendetial', 'password'],
                ['credential', 'key'],
                0
            ],
            [
                ['credential', 'key'],
                ['key', 'credential'],
                0
            ],
        ];
    }

}