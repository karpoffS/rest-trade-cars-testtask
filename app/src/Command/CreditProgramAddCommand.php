<?php

namespace App\Command;


use App\Entity\CreditProgram;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreditProgramAddCommand extends Command
{
    protected static $defaultName = 'app:credit-program:add';
    protected static $defaultDescription = 'Add credit program for your app';
    private ManagerRegistry $doctrine;

    public function __construct(?string $name = null, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct($name);
    }


    protected function configure(): void
    {
        $this
            ->addOption('title', null, InputOption::VALUE_REQUIRED, 'The Title', 'Program 1')
            ->addOption('price', null, InputOption::VALUE_REQUIRED, 'The Price', 1000000)
            ->addOption('loan_term', null, InputOption::VALUE_REQUIRED, 'The Loan Term', 60)
            ->addOption('initial_payment', null, InputOption::VALUE_REQUIRED, 'The Initial payment', 200000)
            ->addOption('monthly_payment', null, InputOption::VALUE_REQUIRED, 'The Monthly payment', 24536)
            ->addOption('interest_rate', null, InputOption::VALUE_REQUIRED, 'The Interest rat. ex. 12.3 * 100 = 1230', 1230)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $title = $input->getOption('title');
            $price = $input->getOption('price');
            $loanTerm = $input->getOption('loan_term');
            $initialPayment = $input->getOption('initial_payment');
            $monthlyPayment = $input->getOption('monthly_payment');
            $interestRate = $input->getOption('interest_rate');

            $em = $this->doctrine->getManager();
            $program = new CreditProgram();
            $program->setTitle($title);
            $program->setPrice($price);
            $program->setLoanTerm($loanTerm);
            $program->setInitialPayment((int) $initialPayment);
            $program->setMonthlyPayment((int) $monthlyPayment);
            $program->setInterestRate((int) $interestRate);
            $em->persist($program);
            $em->flush();
        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success('OK');
        return Command::SUCCESS;
    }
}
