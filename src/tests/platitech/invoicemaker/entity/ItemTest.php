<?php
/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\platitech\invoicemaker\entity;
include_once getenv("BASE_TEST_CASE");

use Platitech\InvoiceMaker\entity\Item;

class ItemTest extends \InvoiceMakerTestCase
{

    public function testItemHasCorrectTotalAmount(){
        $underTestItem = new Item("A blue book", 5, 10.0);
        $expectedTotalAmount = 50.0;
        $this->assertEquals($expectedTotalAmount, $underTestItem->getTotalAmount());
    }

    public function testItemHasCorrectDetails(){
        $expectedDescription = "Transfer and cleaning services charge";
        $expectedUnitPrice = 50.0;
        $expectedQuantity = 10;
        $underTestItem = new Item($expectedDescription, $expectedQuantity, $expectedUnitPrice);
        $this->assertEquals($expectedDescription, $underTestItem->getDescription());
        $this->assertEquals($expectedQuantity, $underTestItem->getQuantity());
        $this->assertEquals($expectedUnitPrice, $underTestItem->getAmount());
    }
}