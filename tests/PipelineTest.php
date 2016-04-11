<?php

namespace Yuloh\Pipeline\Tests;

use function Yuloh\Pipeline\pipe;

class PipelineTest extends \PHPUnit_Framework_TestCase
{
    public function testPipe()
    {
        $pastTimes = pipe('{"name": "Matt", "pastTimes": ["playing Legend of Zelda", "programming"]}')
            ('json_decode', true)
            ('Yuloh\Pipeline\Tests\array_get', 'pastTimes')
            ('implode', ', ')
            ();

        $this->assertSame('playing Legend of Zelda, programming', $pastTimes);
    }
}

function array_get(array $array, $key, $default = null)
{
    return array_key_exists($key, $array) ? $array[$key] : $default;
}
