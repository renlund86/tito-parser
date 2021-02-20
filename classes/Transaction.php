<?php

require __DIR__ . '/../classes/TransactionEntryDefinition.php';

/**
 * Description of Transaction
 *
 * @author Mathias Renlund | <renlund86@gmail.com>
 */
class Transaction {

    private $transactionAmountSign;
    private $transactionAmountInt;
    private $transactionAmountDec;
    private $rawDataRow;
    public $recordLength;
    public $transactionNo;
    public $archiveCode;
    public $entryDate;
    public $valueDate;
    public $paymentDate;
    public $transactionType;
    public $transactionReasonCode;
    public $transactionReasonCodeTranslation;
    public $transactionReasonDescription;
    public $transactionAmountFormatted;
    public $voucherCode;
    public $transmissionFacility;
    public $payerName;
    public $payerNameSource;
    public $payerAccount;
    public $payerAccountChanged;
    public $referenceNumber;
    public $formNumber;
    public $levelCode;

    public function __construct($transaction) {
        $this->rawDataRow = $transaction;
    }

    private function transformDate(&$date) {
        if ($date === "000000") {
            $date = "";
            return;
        }

        $splitDateArr = str_split($date, 2);
        $date = $splitDateArr[2] . "." . $splitDateArr[1] . ".20" . $splitDateArr[0];
    }

    private function transformMonetaryValue($sign, &$amountInt, $amountDec, &$amountFormatted) {
        $amountInt = ltrim($amountInt, "0");
        $floatRepresentation = floatval($amountInt . "." . $amountDec);
        $amountFormatted = trim($sign) . number_format($floatRepresentation, 2, ',', ' ') . "€"; //positive sign is whitespace so trimming
    }

    public function prettify() {
        $this->transformDate($this->entryDate);
        $this->transformDate($this->paymentDate);
        $this->transformDate($this->valueDate);
        $this->transformMonetaryValue(
            $this->transactionAmountSign, 
            $this->transactionAmountInt, 
            $this->transactionAmountDec, 
            $this->transactionAmountFormatted
        );
        
        //strip all whitespaces from public class-properties
        foreach($this as $key => &$value) {
            $value = rtrim($value);
        }

        return $this;
    }

    public function parseRaw() {
        $this->recordLength = substr($this->rawDataRow, 3, 3);
        $this->transactionNo = substr($this->rawDataRow, 6, 6);
        $this->archiveCode = substr($this->rawDataRow, 12, 18);
        $this->entryDate = substr($this->rawDataRow, 30, 6);
        $this->valueDate = substr($this->rawDataRow, 36, 6);
        $this->paymentDate = substr($this->rawDataRow, 42, 6);
        $this->transactionType = substr($this->rawDataRow, 48, 1);
        $this->transactionReasonCode = substr($this->rawDataRow, 49, 3);
        $this->transactionReasonDescription = substr($this->rawDataRow, 52, 35);
        $this->transactionAmountSign = substr($this->rawDataRow, 87, 1);
        $this->transactionAmountInt = substr($this->rawDataRow, 88, 16);
        $this->transactionAmountDec = substr($this->rawDataRow, 103, 2);
        $this->voucherCode = substr($this->rawDataRow, 105, 1);
        $this->transmissionFacility = substr($this->rawDataRow, 106, 1);
        $this->payerName = substr($this->rawDataRow, 108, 35);
        $this->payerNameSource = substr($this->rawDataRow, 141, 1);
        $this->payerAccount = substr($this->rawDataRow, 144, 14);
        $this->payerAccountChanged = substr($this->rawDataRow, 158, 1);
        $this->referenceNumber = substr($this->rawDataRow, 159, 20);
        $this->formNumber = substr($this->rawDataRow, 179, 8);
        $this->levelCode = substr($this->rawDataRow, 187, 1);
        
        //Code translation according to manual (transactionReasonDescription is bank-specific)
        $codeTranslation = new TransactionEntryDefinition($this->transactionReasonCode);
        $this->transactionReasonCodeTranslation = $codeTranslation->map()->getValue();
        
        return $this;
    }

    public function getObj() {
        return $this;
    }

}
