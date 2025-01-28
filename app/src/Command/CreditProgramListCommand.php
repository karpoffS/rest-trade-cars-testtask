<?php

namespace App\Command;


use App\Entity\CreditProgram;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreditProgramListCommand extends Command
{
    protected static $defaultName = 'app:credit-program:list';
    protected static $defaultDescription = 'Add credit program for your app';
    private ManagerRegistry $doctrine;

    public function __construct(?string $name = null, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $em = $this->doctrine->getManager();
        $repo = $em->getRepository(CreditProgram::class);
        $io->title('List of Credit programs.');
        $io->table(
            ['ID', 'Title', 'Conditions', 'InterestRate'],
            array_map(
                static function(CreditProgram $p){
                    return [
                        $p->getId(),
                        $p->getTitle(),
                        json_encode($p->getConditions()),
                        json_encode(array_map(static function ($ir) {
                            return $ir / 100;
                        }, $p->getInterestRate()))
                    ];
                },
                $repo->findAll()
            )
        );

        $io->success('OK');
        return Command::SUCCESS;

    }
}
