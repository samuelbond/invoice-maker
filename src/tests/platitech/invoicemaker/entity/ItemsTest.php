<?php
/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\platitech\invoicemaker\entity;
use Platitech\InvoiceMaker\entity\Item;
use Platitech\InvoiceMaker\entity\Items;

include_once getenv("BASE_TEST_CASE");

class ItemsTest extends  \InvoiceMakerTestCase
{

    public function testDiscountIsApplied(){
        $newItem = new Item("Service Charge", 2, 200.00);
        $underTestItems = new Items(array($newItem), "GBP", 20);
        $underTestItems->setDiscountAmount(100);
        $expectedNetAmount = 300;
        $this->assertEquals($expectedNetAmount, $underTestItems->getNetAmount(), "Discount not applied");
    }

    public function testItemsHasCorrectDetails(){
        $expectedItem = new Item("Service Charge", 3, 205.50);
        $expectedCurrency = "GBP";
        $expectedVatRate = 20;
        $expectedDiscountAmount = 20.5;
        $underTestItems = new Items(array($expectedItem), $expectedCurrency, $expectedVatRate);
        $underTestItems->setDiscountAmount($expectedDiscountAmount);
        $itemList = $underTestItems->getItems();
        $this->assertTrue($itemList[0] instanceof $expectedItem, "Item instance is different");
        $this->assertEquals($expectedCurrency, $underTestItems->getCurrency(), "Currency mismatch");
        $this->assertEquals($expectedVatRate, $underTestItems->getVatRate(), "VAT rate mismatch");
        $this->assertEquals($expectedDiscountAmount, $underTestItems->getDiscountAmount(), "Discount amount mismatch");
    }

    public function testItemsHasCorrectNetAmount(){
        $newItem = new Item("Service Charge", 2, 200.00);
        $underTestItems = new Items(array($newItem), "GBP", 20);
        $expectedNetAmount = 400.00;
        $this->assertEquals($expectedNetAmount, $underTestItems->getNetAmount(), "Incorrect net amount");
    }

    public function testItemsHasCorrectGrossAmount(){
        $newItem = new Item("Service Charge", 2, 50.00);
        $underTestItems = new Items(array($newItem), "GBP", 20);
        $expectedGrossAmount = 120.00;
        $this->assertEquals($expectedGrossAmount, $underTestItems->getGrossAmount(), "Incorrect gross amount");
    }

    public function testVATIsApplied(){
        $newItem = new Item("Service Charge", 2, 50.00);
        $underTestItems = new Items(array($newItem), "GBP", 20);
        $expectedVATAmount = 20.00;
        $this->assertEquals($expectedVATAmount, $underTestItems->getVATAmount(), "VAT rate applied incorrectly");
    }
}