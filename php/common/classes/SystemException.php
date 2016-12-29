<?php

class SystemException extends Exception {
    public function errorMessage() {
        //error message
        $errorMsg = 'Error on line ' . $this->getLine() . ' in ' . $this->getFile()
            . ": \r\n" . $this->getMessage();
        return $errorMsg;
    }
}