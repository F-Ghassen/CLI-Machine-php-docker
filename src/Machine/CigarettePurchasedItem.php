<?php


namespace App\Machine;


class CigarettePurchasedItem implements PurchasedItemInterface
{
    /**
     * @var PurchaseTransactionInterface
     */
    private $purchaseTransaction;

    static private $coins = [
        0.01,
        0.02,
        0.05,
        0.10,
        0.20,
        0.50,
        1.00,
        2.00,
        5.00,
        10.00,
        20.00,
    ];

    /**
     * CigarettePurchasedItem constructor.
     * @param PurchaseTransactionInterface $purchaseTransaction
     */
    public function __construct(PurchaseTransactionInterface $purchaseTransaction)
    {
        $this->purchaseTransaction = $purchaseTransaction;
    }

    /**
     * @return integer
     */
    public function getItemQuantity(): int
    {
        return $this->purchaseTransaction->getItemQuantity();
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->purchaseTransaction->getItemQuantity() * CigaretteMachine::ITEM_PRICE;
    }

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     *
     * @return array
     */
    public function getChange(): array
    {
        $change = array();
        $coinsToPayBack = array();
        $amountToReturn = (ceil(($this->purchaseTransaction->getPaidAmount()*100)) - $this->getTotalAmount()*100)/100;
        $coins = array_reverse(self::$coins);
        foreach ($coins as $coin)
        {

            // multiplying by 100 to avoid computing floating numbers
            while (($coin*100 <= $amountToReturn*100))
            {
                $amountToReturn = ($amountToReturn*100 - $coin*100)/100;
                $coinsToPayBack [] = sprintf('%.2f', $coin);
            }
        }
        //count occurrences and map them as key => value
        $keyValueChange = array_count_values($coinsToPayBack);
        foreach ($keyValueChange as $value => $count){
            $change [] = [$value, $count];
        }
        return $change;
    }

    /**
     * returns the amount missing for the payment
     *
     * @return float
     */
    public function getAmountMissing(): float
    {
        $amountMissing = $this->getTotalAmount() - $this->purchaseTransaction->getPaidAmount();
        if ($amountMissing > 0) {
            return $amountMissing;
        }
        return 0;
    }

    /**
     * return true if some amount is missing
     *
     * @return bool
     */
    public function isSomeAmountMissing(): bool
    {
         if ( $this->getAmountMissing() > 0 )
             return true;
         return false;
    }
}