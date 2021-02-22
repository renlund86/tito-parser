<?php

require __DIR__ . '/../classes/Transaction.php';

/**
 * TITO Class
 *
 * @author Mathias Renlund | <renlund86@gmail.com>
 */
class TITO {

    private $titoArr = "";
    private $extraArr = "";
    private $transactions = "";
    
    /**
     * Constructor
     * 
     * @param array $input
     */
    public function __construct($input) {
        $this->titoArr = $input;
        $this->extraArr = array();
        $this->transactions = array();
    }
    
    /**
     * TITO implmentation logic, filters out T10 records (skipping others for now) and initiates the parsing.
     * 
     * @return string JSON-encoded
     */
    public function categorize() {
        foreach ($this->titoArr as $key => $row) {
            $recordType = mb_substr($row, 0, 3);

            if ($recordType === "T10") {
                $transaction = new Transaction($row);
                $this->transactions[] = $transaction->parseRaw()->prettify()->getObj();
            }
        }

        return json_encode($this->transactions, JSON_UNESCAPED_UNICODE);
    }

}
