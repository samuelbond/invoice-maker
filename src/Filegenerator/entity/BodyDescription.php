<?php
/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Filegenerator\entity;


class BodyDescription
{
    private $salutation;
    private $description;
    private $notes;
    private $signerName;
    private $comments;

    /**
     * BodyDescription constructor.
     * @param $salutation
     * @param $description
     */
    public function __construct($salutation, $description)
    {
        $this->salutation = $salutation;
        $this->description = $description;
    }


    /**
     * @return mixed
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * @param mixed $salutation
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return mixed
     */
    public function getSignerName()
    {
        return $this->signerName;
    }

    /**
     * @param mixed $signerName
     */
    public function setSignerName($signerName)
    {
        $this->signerName = $signerName;
    }



}