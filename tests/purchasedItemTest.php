<?php

namespace App\Machine;

use PHPUnit\Framework\TestCase;

class purchasedItemTest extends TestCase
{
    public function testPurchasedItem()
    {
        $itemCount = 2;
        $amount = 10.00;
        $purchaseTransaction = new CigarettePurchaseTransaction($itemCount, $amount);
        $purchasedItem = new CigarettePurchasedItem($purchaseTransaction);
        $this->assertEquals(2, $purchasedItem->getItemQuantity());
        $this->assertEquals(9.98, $purchasedItem->getTotalAmount());
        $this->assertEquals(0, $purchasedItem->getAmountMissing());
        $this->assertEquals(false, $purchasedItem->isSomeAmountMissing());
    }
}