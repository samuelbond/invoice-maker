Feature: Invoice maker
  As a user i want to create invoice
  Be able to download invoice in different formats such as PDF
  I should also be able to save an invoice and retrieve it later
  For download, printing or as an attachment for an email

  Background:
    Given My company name is "My Company Ltd"
    And My address is "21 Baker Street" with postcode "EC12NTY7"
    And Located in city of "London" in the "United Kingdom"
    And Can be emailed via "info@mycompany.com"
    And can be called on "020111222333"
    And I want to process some invoice for "Some Company Ltd"
    And Their address is "22 Jump Street" with postcode "NY001M"
    And They are located in "New York" city in the "United States"
    And They can be emailed via "info@somecompany.com"
    And They can also be reached by phone on "01000111222"

  Scenario: Create a new invoice
    Given I want to raise a "consultancy services" invoice for a one time service
    And Which i carried out on the "12/05/2016" and it costs "250" "GBP"
    And My vat rate is "20"% with a discount of "50" GBP
    When I create an invoice
    Then The invoice should contain the correct details