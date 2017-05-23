<?php

class SystemException extends Exception {
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0) {
        // some code
        // make sure everything is assigned properly
        parent::__construct($message, $code);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function errorMessage() {
        $dateTime = new DateTime();
        $errorMsg = $dateTime->format('y:m:d h:i:s') - " - Error on line " . $this->getLine() . " in " . $this->getFile() . ": \r\n" . $this->getMessage() . "\n";
        return $errorMsg;
    }
}