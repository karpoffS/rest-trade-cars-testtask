<?php

namespace App\Command;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Model;
use App\Utils\ConvertCsvToArray;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Factory as FakerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportDataCommand extends Command
{
    protected static $defaultName = 'app:import-data';
    protected static $defaultDescription = 'Add a short description for your command';
    private ManagerRegistry $doctrine;

    public function __construct(?string $name = null, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to file')
            ->addOption('brand', null, InputOption::VALUE_OPTIONAL, 'поле для Бренда автомобиля', 'Марка')
            ->addOption('model', null, InputOption::VALUE_OPTIONAL, 'поле для Модели автомобиля', 'Модель')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $filePath = $input->getArgument('file');
            $brandColumn = $input->getOption('brand');
            $modelColumn = $input->getOption('model');

            $em = $this->doctrine->getManager();
            $brandRepository = $em->getRepository(Brand::class);
            $modelRepository = $em->getRepository(Model::class);
            $faker = FakerFactory::create();

            $prices = range(1000000, 10000000, 125000);

            if ($filePath) {
                $io->note(sprintf('Parsing a file: %s', $filePath));
                $io->progressStart(ConvertCsvToArray::countLines($filePath));
            }

            $batchSize = 50;
            $current = 0;
            foreach (ConvertCsvToArray::convertIteration($filePath) as $item) {
                $brandValue = $item[$brandColumn];
                if(is_null($brand = $brandRepository->findOneBy(['name' => $brandValue]))){
                    $brand = (new Brand())->setName($brandValue);
                    $em->persist($brand);
                    $em->flush();
                }

                $modelValue = $item[$modelColumn];
                if(is_null($model = $modelRepository->findOneBy(['name' => $modelValue]))){
                    $model = (new Model())->setName($modelValue);
                    $em->persist($model);
                    $em->flush();
                }

                $car = new Car();
                $car->setBrand($brand);
                $car->setModel($model);
                $car->setPhoto($faker->imageUrl());
                $price = $prices[array_rand($prices)];
                $car->setPrice($price);
                $em->persist($car);
                if (($current % $batchSize) === 0) {
                    $em->flush();
                    $em->clear(); // Detaches all objects from Doctrine!
                }
                $current++;
                $io->progressAdvance();
            }
            $em->flush(); // Persist objects that did not make up an entire batch
            $em->clear(); // Detaches all objects from Doctrine!
            $io->progressFinish();
        } catch (\Exception $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success('OK');
        return Command::SUCCESS;

    }
}
