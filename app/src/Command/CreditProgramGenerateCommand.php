<?php

namespace App\Command;

use App\Entity\CreditProgram;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreditProgramGenerateCommand extends Command
{
    protected static $defaultName = 'app:credit-program:generate';
    protected static $defaultDescription = 'Generate credit programs for your app';
    private ManagerRegistry $doctrine;

    public function __construct(?string $name = null, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $manager = $this->doctrine->getManager();

            $items = [
                ['title' => 'Alfa Energy', 'Conditions' => ['loanTerm' => [1, 60], 'initialPayment' => [200000, null]], 'interestRate' => [1230, 1230]],
                ['title' => 'Betta Energy', 'Conditions' => ['loanTerm' => [61, 90], 'initialPayment' => [200000 * 2, null]], 'interestRate' => [1240, 1800]],
                ['title' => 'Gamma Energy', 'Conditions' => ['loanTerm' => [91, 120], 'initialPayment' => [200000 * 3, null]], 'interestRate' => [1810, 2400]],
                ['title' => 'Delta Energy', 'Conditions' => ['loanTerm' => [121, 150], 'initialPayment' => [200000 * 4, null]], 'interestRate' => [2410, 2800]],
                ['title' => 'Tetta Energy', 'Conditions' => ['loanTerm' => [151, 180], 'initialPayment' => [200000 * 5, null]], 'interestRate' => [2810, 3600]],
                ['title' => 'Omega Energy', 'Conditions' => ['loanTerm' => [181, 210], 'initialPayment' => [200000 * 6, null]], 'interestRate' => [3610, 4200]],
                ['title' => 'Septum Energy', 'Conditions' => ['loanTerm' => [211, 240], 'initialPayment' => [200000 * 7, null]], 'interestRate' => [4210, 5600]],
            ];

            $batchSize = 50;
            $current = 0;
            foreach ($items as $item) {
                $program = new CreditProgram();
                $program->setTitle($item['title']);
                $program->setConditions($item['Conditions']);
                $program->setInterestRate($item['interestRate']);
                $manager->persist($program);
                $manager->flush();
                if (($current % $batchSize) === 0) {
                    $manager->flush();
                    $manager->clear(); // Detaches all objects from Doctrine!
                }
                $current++;
            }
            $manager->flush(); // Persist objects that did not make up an entire batch
            $manager->clear(); // Detaches all objects from Doctrine!

        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success('OK');
        return Command::SUCCESS;

    }
}
