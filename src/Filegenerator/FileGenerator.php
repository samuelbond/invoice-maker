<?php

/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Filegenerator;


class FileGenerator
{
    private $outputDir;
    private $fileName;
    const PDF = 'pdf';
    const PLAIN_TXT = 'txt';
    private $format;

    /**
     * FileGenerator constructor.
     * @param $outputDir
     * @param $fileName
     * @param $format
     */
    public function __construct($outputDir, $fileName, $format)
    {
        $this->outputDir = $outputDir;
        $this->fileName = $fileName;
        $this->format = $this->isFormat($format) ?? $format;
    }

    private function defaults(){
        $this->outputDir = "/tmp/";
        $this->fileName = random_bytes(10);
    }

    /**
     * @param $format
     * @return null
     */
    private function isFormat($format){
        if($format == self::PDF && $format == self::PLAIN_TXT){
            return null;
        }
        throw new \InvalidArgumentException("expected pdf, txt found ".$format);
    }




}