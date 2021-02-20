<?php

require __DIR__ . '/../classes/Transaction.php';

/**
 * Description of TITO
 *
 * @author Mathias Renlund | <renlund86@gmail.com>
 */
class TITO {

    private $titoArr = "";
    private $extraArr = "";
    private $transactions = "";

    public function __construct($input) {
        $this->titoArr = $input;
        $this->extraArr = array();
        $this->transactions = array();
    }

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
