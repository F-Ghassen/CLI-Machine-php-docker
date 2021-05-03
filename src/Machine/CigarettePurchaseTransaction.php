<?php


namespace App\Machine;


class CigarettePurchaseTransaction implements PurchaseTransactionInterface
{
    /**
     * @var int
     */
    private $itemCount;

    /**
     * @var float
     */
    private $amount;

    /**
     * CigarretePurchaseTransaction constructor.
     * @param int $itemCount
     * @param int $amount
     */
    public function __construct($itemCount, $amount)
    {
        $this->itemCount = $itemCount;
        $this->amount = $amount;
    }

    /**
     * @return integer
     */
    public function getItemQuantity(): int
    {
        return $this->itemCount;
    }

    /**
     * @return float
     */
    public function getPaidAmount(): float
    {
        return $this->amount;
    }
}