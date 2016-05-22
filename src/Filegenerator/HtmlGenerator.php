<?php
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 21/05/2016
 * Time: 10:49
 */

namespace Filegenerator;


use Filegenerator\entity\Invoice;

class HtmlGenerator
{
    private $invoice;

    /**
     * HtmlGenerator constructor.
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function generateHtmlInvoice(){
        $file1 = dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'invoice.html';
        $mainFileName = time().'-invoice.html';
        $file2 = dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'generated_htmls'.DIRECTORY_SEPARATOR.$mainFileName;
        $file1Contents = file_get_contents($file1);
        $startDelimiter = "StartInject";
        $endDelimiter = "EndInject";
        $startPosition = strpos($file1Contents, $startDelimiter);
        $endPosition = strpos($file1Contents, $endDelimiter);
        if($startPosition === false){
            throw new \UnexpectedValueException("Could not find html start or end delimiter");
        }
        $firstHalf = substr($file1Contents, 0, $startPosition);
        $secondHalf = substr($file1Contents, $endPosition);
        $content = $firstHalf.$this->getHtmlToUse().$secondHalf;
        $handle = fopen($file2, "w+");
        fwrite($handle, $content);
        fclose($handle);
        return $file2;
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
}