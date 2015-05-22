<?php

namespace MyBuilder\Conductor\Command;

use Herrera\Phar\Update\Manager;
use Herrera\Phar\Update\Manifest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfUpdateCommand extends Command
{
    const MANIFEST_FILE = 'http://eddmann.github.io/conductor/manifest.json';

    protected function configure()
    {
        $this
            ->setName('self-update')
            ->setAliases(array('selfupdate'))
            ->setDescription('Updates conductor.phar to the latest version.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = new Manager(Manifest::loadFile(self::MANIFEST_FILE));
        $version = $this->getApplication()->getVersion();

        if ($manager->update($this->getApplication()->getVersion(), true)) {
            $output->writeln('<info>Successfully updated conductor.phar</info>');
        } else {
            $output->writeln("<info>Currently running the latest version: $version</info>");
        }
    }
}
