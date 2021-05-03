<?php

namespace App\Command;

use App\Machine\CigarettePurchaseTransaction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Machine\CigaretteMachine;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));

        $purchaseTransaction = new CigarettePurchaseTransaction($itemCount, $amount);
        $cigaretteMachine = new CigaretteMachine();
        $purchasedItem = $cigaretteMachine->execute($purchaseTransaction);


        //todo handle the output logic in separate class
        if (is_array($purchasedItem) && array_key_exists('AmountNotEnough', $purchasedItem)){
            $failedMsg = sprintf($cigaretteMachine::FAILURE_MSG, $amount, $itemCount, $purchasedItem['AmountNotEnough']);
            $output->writeln($failedMsg);
            return 0;
        }

        $successMsg = sprintf($cigaretteMachine::SUCCESS_MSG, $itemCount, $purchasedItem->getTotalAmount(), CigaretteMachine::ITEM_PRICE);
        $output->writeln($successMsg);
        $output->writeln('Your change is:');
        $table = new Table($output);
        $table
            ->setHeaders(array('Coins', 'Count'))
            ->setRows($purchasedItem->getChange())
        ;
        $table->render();
        return 0;
    }
}