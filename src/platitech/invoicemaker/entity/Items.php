<?php
/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Platitech\InvoiceMaker\entity;


class Items
{
    private $items;
    private $currency;
    private $vatRate;
    private $discountAmount = 0;

    /**
     * @param array $items
     * @param string $currency
     * @param int $vat
     */
    public function __construct(array $items, string $currency, int $vat)
    {
        $this->items = $items;
        $this->currency = $currency;
        $this->vatRate = $vat;
    }

    /**
     * @return mixed
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * @param mixed $discountAmount
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
    }

    public function getGrossAmount(){
        $amount = $this->getNetAmount();
        return (($this->vatRate/100) *$amount) + $amount;
    }

    public function getNetAmount(){
        $amount = 0;
        foreach($this->items as $item){
            $amount = $amount+$item->getTotalAmount();
        }
        return ($amount - $this->discountAmount);
    }

    public function getVATAmount(){
        return ($this->vatRate/100) *$this->getNetAmount();
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return string|string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string|string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int|int
     */
    public function getVatRate()
    {
        return $this->vatRate;
    }

    /**
     * @param int|int $vatRate
     */
    public function setVatRate($vatRate)
    {
        $this->vatRate = $vatRate;
    }


}