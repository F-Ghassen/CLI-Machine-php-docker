<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;
    const FAILURE_MSG = 'You tried to buy <info>%d</info> packs but you paid <info>%.2f</info>€, you have to pay more <info>%.2f</info>€.';
    const SUCCESS_MSG = 'You bought <info>%d</info> packs of cigarettes for <info>%.2f</info>€, each for <info>%.2f</info>€.';

    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        $cigarretePurchasedItem = new CigarettePurchasedItem($purchaseTransaction);
        if ($cigarretePurchasedItem->isSomeAmountMissing()) {
            return  ['AmountNotEnough' => $cigarretePurchasedItem->getAmountMissing()];
        }

        return $cigarretePurchasedItem;
    }
}