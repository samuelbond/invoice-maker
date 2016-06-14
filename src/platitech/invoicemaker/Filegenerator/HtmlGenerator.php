<?php
/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Platitech\InvoiceMaker\Filegenerator;


use Platitech\InvoiceMaker\entity\Invoice;

class HtmlGenerator
{
    private $invoice;
    private $basePath;
    private $storageDir;
    private $generatedHtmlPath;

    /**
     * HtmlGenerator constructor.
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->basePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR;
        $this->storageDir = $this->basePath.'generated_htmls'.DIRECTORY_SEPARATOR;
    }

    private function createStorageDirectory(){
        if(!file_exists($this->storageDir)){
            mkdir($this->storageDir);
        }
    }

    public function generateHtmlInvoice(){
        $this->createStorageDirectory();
        $invoiceTemplate = $this->basePath.'invoice_template.html';
        $this->generatedHtmlPath = $this->storageDir.time().'-invoice.html';
        $templateContent = file_get_contents($invoiceTemplate);
        $startDelimiter = "StartInject";
        $endDelimiter = "EndInject";
        $startPosition = strpos($templateContent, $startDelimiter);
        $endPosition = strpos($templateContent, $endDelimiter);
        if($startPosition === false){
            throw new \UnexpectedValueException("Could not find html start or end delimiter");
        }
        $firstHalf = substr($templateContent, 0, ($startPosition-4));
        $secondHalf = substr($templateContent, ($endPosition+12));
        $content = $firstHalf.$this->getHtmlToUse().$secondHalf;
        file_put_contents($this->generatedHtmlPath, $content);
        return $this->generatedHtmlPath;
    }


    private function getHtmlToUse(){
        $items = '';
        foreach ($this->invoice->getItems()->getItems() as $item){
            $items.= '<tr>
                            <td class="text-center">'.$item->getQuantity().'</td>
                            <td>'.$item->getDescription().'</td>
                            <td class="text-right">'.$item->getAmount().'</td>
                            <td class="text-right">'.$item->getTotalAmount().'</td>
                        </tr>';
        }
        $html = '<tr>
                                <td>'.$this->invoice->getInvoiceNumber().'</td>
                                <td>'.$this->invoice->getInvoiceDate().'</td>
                            </tr>
                        </table>
                        <div class="mgbt-xs-20">
                            <h4>'.$this->invoice->getRecipient()->getCompanyName().'</h4>
                            <address>
                                '.$this->invoice->getRecipient()->getAddress().'<br>
                                '.$this->invoice->getRecipient()->getCity().', '.$this->invoice->getRecipient()->getPostCode().'<br>
                                '.$this->invoice->getRecipient()->getCountry().'<br>
                                '.$this->invoice->getRecipient()->getTelephone().'<br />
                                '.$this->invoice->getRecipient()->getEmail().'
                            </address>
                        </div>
                    </div>
                    <div class="mgbt-xs-20">
                        <h3>'.$this->invoice->getIssuer()->getCompanyName().'</h3>
                        <address>
                            '.$this->invoice->getIssuer()->getAddress().'<br>
                            '.$this->invoice->getIssuer()->getCity().', '.$this->invoice->getIssuer()->getPostCode().'<br>
                            '.$this->invoice->getIssuer()->getCountry().'<br>
                            '.$this->invoice->getIssuer()->getTelephone().'<br />
                            '.$this->invoice->getIssuer()->getEmail().'
                        </address>
                    </div>

                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <hr/>
                    <div class="pd-25">
                        <div class="row">
                            <div class="col-sm-12">
                                <b>'.$this->invoice->getBodyDescription()->getSalutation().'</b>,
                                <p>'.$this->invoice->getBodyDescription()->getDescription().'</p>
                                Many Thanks,
                                <p>'.$this->invoice->getBodyDescription()->getSignerName().'</p>
                            </div>
                        </div>
                    </div>
                    <table class="table table-condensed table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" style="width:20px;">QTY</th>
                            <th>DESCRIPTION</th>
                            <th class="text-right" style="width:120px;">PRICE</th>
                            <th class="text-right" style="width:120px;">TOTAL</th>
                        </tr>
                        </thead>
                        <tbody>
                        '.$items.'
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="2" rowspan="3" class="bdr">Note:
                                <p class="font-normal">'.$this->invoice->getBodyDescription()->getNotes().'</p></th>
                            <th class="text-right pd-10">Sub Total</th>
                            <th class="text-right pd-10">'.$this->invoice->getItems()->getNetAmount().'</th>
                        </tr>
                        <tr>
                            <th class="text-right  pd-10 no-bd">Discount</th>
                            <th class="text-right  pd-10 vd_red no-bd">0</th>
                        </tr>
                        <tr>
                            <th class="text-right  pd-10 no-bd">VAT</th>
                            <th class="text-right  pd-10 no-bd">'.$this->invoice->getItems()->getVATAmount().'</th>
                        </tr>
                        <tr>
                            <th colspan="2">'.$this->invoice->getBodyDescription()->getComments().'</th>
                            <th class="text-right  pd-10">Total</th>
                            <th class="text-right  pd-10 "><span class="vd_green font-sm font-normal">'.$this->invoice->getItems()->getCurrency().' '.$this->invoice->getItems()->getGrossAmount().'</span></th>';

        return $html;

    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return string
     */
    public function getStorageDir()
    {
        return $this->storageDir;
    }

    /**
     * @return mixed
     */
    public function getGeneratedHtmlPath()
    {
        return $this->generatedHtmlPath;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param string $storageDir
     */
    public function setStorageDir($storageDir)
    {
        $this->storageDir = $storageDir;
    }



}