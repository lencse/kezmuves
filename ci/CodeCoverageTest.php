<?php

define('MIN_COVERAGE', 90);

class CodeCoverageTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        if (defined('HHVM_VERSION')) {
            $this->markTestSkipped('Code coverage test is skipped on HHVM');
        }
    }

    public function testCoverage()
    {
        $xml = new SimpleXMLElement(file_get_contents(__DIR__ . '/../build/logs/clover.xml'));
        $metrics = $xml->xpath('//metrics');
        $total = 0;
        $covered = 0;
        foreach ($metrics as $metric) {
            $total += (int) $metric['elements'];
            $covered += (int) $metric['coveredelements'];
        }
        $this->assertGreaterThanOrEqual(MIN_COVERAGE, $covered / $total * 100);
    }

}
