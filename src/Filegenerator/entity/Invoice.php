<?php
/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Filegenerator\entity;


class Invoice
{
    private $issuer;
    private $recipient;
    private $bodyDescription;
    private $items;

    /**
     * Invoice constructor.
     * @param Issuer $issuer
     * @param Recipient $recipient
     * @param BodyDescription $bodyDescription
     * @param Items $items
     */
    public function __construct(Issuer $issuer, Recipient $recipient, BodyDescription $bodyDescription, Items $items)
    {
        $this->issuer = $issuer;
        $this->recipient = $recipient;
        $this->bodyDescription = $bodyDescription;
        $this->items = $items;
    }

    /**
     * @return Issuer
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param mixed $issuer
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }

    /**
     * @return Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param mixed $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return BodyDescription
     */
    public function getBodyDescription()
    {
        return $this->bodyDescription;
    }

    /**
     * @param mixed $bodyDescription
     */
    public function setBodyDescription($bodyDescription)
    {
        $this->bodyDescription = $bodyDescription;
    }

    /**
     * @return Items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }


}