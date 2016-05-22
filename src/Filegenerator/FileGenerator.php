<?php

/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Filegenerator;


use Filegenerator\entity\Invoice;
use Knp\Snappy\Pdf;

class FileGenerator
{
    const PDF = 'pdf';
    const PLAIN_TXT = 'txt';
    private $format;

    /**
     * @param $format
     */
    public function __construct($format)
    {
        $this->format = $this->isFormatSupported($format) ?? $format;
    }

    /**
     * @param $format
     * @return null
     */
    private function isFormatSupported($format){
        if($format == self::PDF || $format == self::PLAIN_TXT){
            return null;
        }
        throw new \InvalidArgumentException("expected pdf, txt found ".$format);
    }


    public function generateInvoiceFile(Invoice $invoice){
       if($this->format == self::PDF){
           return $this->generatePdfInvoice($invoice);
       }

        return null;
    }

    private function generatePdfInvoice(Invoice $invoice){
        $snappy = new Pdf("/usr/local/bin/wkhtmltopdf");
        $html = new HtmlGenerator($invoice);
        return $snappy->getOutput($html->generateHtmlInvoice());
    }

}