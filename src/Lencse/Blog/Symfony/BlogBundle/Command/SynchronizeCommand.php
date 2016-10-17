<?php

namespace Lencse\Blog\Symfony\BlogBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SynchronizeCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('lencse:sync')->setDescription('Synchronize blog content from GitHub');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('lencse.blog.content_downloader')->download();
        $output->writeln('Content synchronized');

        return 0;
    }


}