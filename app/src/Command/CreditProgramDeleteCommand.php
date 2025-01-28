<?php

namespace App\Command;

use App\Entity\CreditProgram;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreditProgramDeleteCommand extends Command
{
    protected static $defaultName = 'app:credit-program:remove';
    protected static $defaultDescription = 'Remove credit program for your app';
    private ManagerRegistry $doctrine;

    public function __construct(?string $name = null, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct($name);
    }


    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'id credit program')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $idProgram = $input->getArgument('id');

        $em = $this->doctrine->getManager();
        $repo = $em->getRepository(CreditProgram::class);
        $repo->remove($idProgram, true);

        $io->success('OK');
        return Command::SUCCESS;
    }
}
