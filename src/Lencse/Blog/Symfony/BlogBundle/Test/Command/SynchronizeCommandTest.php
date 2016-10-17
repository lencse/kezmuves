<?php

namespace Lencse\Blog\Symfony\BlogBundle\Test\Command;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Bundle\FrameworkBundle\Client;

class SynchronizeCommandTest extends WebTestCase
{

    /**
     * @var Application
     */
    private $app;

    /**
     * @param Client $client
     * @param $command
     * @return StreamOutput|string
     */
    private function runCommand(Client $client, $command)
    {
        $this->app = new Application($client->getKernel());
        $this->app = new Application($client->getKernel());
        $this->app->setAutoExit(false);

        $fp = tmpfile();
        $input = new StringInput($command);
        $output = new StreamOutput($fp);

        $this->app->run($input, $output);

        fseek($fp, 0);
        $output = '';
        while (!feof($fp)) {
            $output = fread($fp, 4096);
        }
        fclose($fp);

        return $output;
    }

    /**
     * @group expensive
     */
    public function testSynchronize()
    {
        $client = self::createClient();
        $this->runCommand($client, 'lencse:sync');
        $this->assertFileExists($this->app->getKernel()->getRootDir() . '/../web/content/img');
    }

}