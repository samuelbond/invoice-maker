<?php
include_once getenv("VENDOR_DIR");
include_once getenv("BASE_TEST_CASE");
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Platitech\InvoiceMaker\entity\Invoice;
use Platitech\InvoiceMaker\entity\Issuer;
use Platitech\InvoiceMaker\entity\Item;
use Platitech\InvoiceMaker\entity\Items;
use Platitech\InvoiceMaker\entity\Recipient;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends InvoiceMakerTestCase implements Context, SnippetAcceptingContext
{
    /**
     * @var Items
     */
    private $items;
    /**
     * @var Item
     */
    private $item;
    /**
     * @var Issuer
     */
    private $issuer;
    /**
     * @var Recipient
     */
    private $recipient;
    /**
     * @var Invoice
     */
    private $invoice;
    /**
     * @var \Platitech\InvoiceMaker\entity\BodyDescription
     */
    private $bodyDescription;
    const INV_MSG = "Nice doing business";
    const MSG_SALUTATION = "Hello";
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->bodyDescription = new \Platitech\InvoiceMaker\entity\BodyDescription(self::MSG_SALUTATION, self::INV_MSG);
    }

    /**
     * @Given My company name is :companyName
     */
    public function myCompanyNameIs($companyName)
    {
        $this->issuer = new \Platitech\InvoiceMaker\entity\Issuer("", $companyName, "", "", "", "", "");
    }

    /**
     * @Given My address is :address with postcode :postCode
     */
    public function myAddressIsWithPostcode($address, $postCode)
    {
        $this->issuer->setAddress($address);
        $this->issuer->setPostCode($postCode);
    }

    /**
     * @Given Located in city of :city in the :country
     */
    public function locatedInCityOfInThe($city, $country)
    {
        $this->issuer->setCity($city);
        $this->issuer->setCountry($country);
    }

    /**
     * @Given Can be emailed via :email
     */
    public function canBeEmailedVia($email)
    {
        $this->issuer->setEmail($email);
    }

    /**
     * @Given can be called on :telephone
     */
    public function canBeCalledOn($telephone)
    {
        $this->issuer->setTelephone($telephone);
    }

    /**
     * @Given I want to process some invoice for :companyName
     */
    public function iWantToProcessSomeInvoiceFor($companyName)
    {
        $this->recipient = new Recipient("", $companyName, "", "", "", "", "");
    }

    /**
     * @Given Their address is :address with postcode :postCode
     */
    public function theirAddressIsWithPostcode($address, $postCode)
    {
        $this->recipient->setAddress($address);
        $this->recipient->setPostCode($postCode);
    }

    /**
     * @Given They are located in :city city in the :country
     */
    public function theyAreLocatedInCityInThe($city, $country)
    {
        $this->recipient->setCity($city);
        $this->recipient->setCountry($country);
    }

    /**
     * @Given They can be emailed via :email
     */
    public function theyCanBeEmailedVia($email)
    {
        $this->recipient->setEmail($email);
    }

    /**
     * @Given They can also be reached by phone on :telephone
     */
    public function theyCanAlsoBeReachedByPhoneOn($telephone)
    {
        $this->recipient->setTelephone($telephone);
    }

    /**
     * @Given I want to raise a :invoiceDescription invoice for a one time service
     */
    public function iWantToRaiseAInvoiceForAOneTimeService($invoiceDescription)
    {
        $this->item = new Item($invoiceDescription, 1, 0);
    }

    /**
     * @Given Which i carried out on the :invoiceDate and it costs :price :currency
     */
    public function whichICarriedOutOnTheAndItCosts($invoiceDate, $price, $currency)
    {
        $this->item->setAmount($price);
        $this->items = new Items(array(), $currency, 0);
        $this->invoice = new Invoice($this->issuer, $this->recipient, $this->bodyDescription, $this->items);
        $this->invoice->setInvoiceDate($invoiceDate);
    }

    /**
     * @Given My vat rate is :vatRate% with a discount of :discountAmount GBP
     */
    public function myVatRateIsWithADiscountOfGbp($vatRate, $discountAmount)
    {
        $this->items->setVatRate($vatRate);
        $this->items->setDiscountAmount($discountAmount);
    }

    /**
     * @When I create an invoice
     */
    public function iCreateAnInvoice()
    {
        $this->items->setItems(array($this->item));
        $this->invoice->setIssuer($this->issuer);
        $this->invoice->setRecipient($this->recipient);
        $this->invoice->setBodyDescription($this->bodyDescription);
        $this->invoice->setItems($this->items);
    }

    /**
     * @Then The invoice should contain the correct details
     */
    public function theInvoiceShouldContainTheCorrectDetails()
    {
        $this->expects($this->item->getDescription(), $this->invoice->getItems()->getItems()[0]->getDescription());
        $this->expects($this->item->getAmount(), $this->invoice->getItems()->getItems()[0]->getAmount());
        $this->expects($this->item->getQuantity(), $this->invoice->getItems()->getItems()[0]->getQuantity());
    }
}
