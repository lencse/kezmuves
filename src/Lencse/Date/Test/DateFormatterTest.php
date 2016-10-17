<?php

namespace Lencse\Date\Test;


use Lencse\Date\DateFormatter;
use Lencse\Test\TestCase;

class DateFormatterTest extends TestCase
{

    public function testPrettyDate()
    {
        $formatter = new DateFormatter();
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', '2016-03-15 18:00:00');
        $this->assertEquals('2016. március 15.', $formatter->prettyDate($date));
    }
    
}