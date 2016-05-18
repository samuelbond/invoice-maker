<?php
/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Filegenerator\entity;


class Item
{

    private $description;
    private $quantity;
    private $amount;

    /**
     * @param string $description
     * @param int $quantity
     * @param float $amount
     */
    public function __construct(string $description, int $quantity, float $amount)
    {
        $this->description = $description;
        $this->quantity = $quantity;
        $this->amount = $amount;
    }

    /**
     * @return string|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int|int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int|int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float|float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float|float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }


}