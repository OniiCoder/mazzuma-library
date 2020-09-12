<?php

namespace Peter\Mazzuma\Exception;

class InvalidAmountException {
    public function errorMessage() {
        $errorMsg = 'Amount is not a valid number';
    }
}