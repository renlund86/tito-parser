<?php

/**
 * Description of TransactionEntryDefinition
 *
 * @author Mathias Renlund
 */
class TransactionEntryDefinition {
    
    private $code;
    private $value;
    
    public function __construct($code) {
        $this->code = $code;
    }
    
    public function map() {
        $mapping = array(
            700 => "Transaction processed in some payment service",
            701 => "Debiting of salaries and pensions",
            702 => "Debit entry processed in Corporate Payments Service",
            703 => "Settlement of payment terminal service",
            704 => "Automatic payment service",
            705 => "Joint credit entry of incoming reference payments",
            706 => "Payment debited on the basis of a payment service order",
            710 => "Deposit",
            720 => "Withdrawal",
            721	=> "Card payment",
            722 => "Cheque",
            730 => "Fee",
            740 => "Interest debit entry",
            750 => "Interest credit entry",
            760 => "Loan debit entry including instalment, interest and fee",
            761 => "Amortisation",
            780 => "Zero Balancing",
            781 => "Sweeping",
            782 => "Topping"
        );
        
        $this->value = $mapping[$this->code];
        return $this;
    }
    
    public function getValue() {
        return $this->value;
    }
    
    public function getCode() {
        return $this->code;
    }
    
}
