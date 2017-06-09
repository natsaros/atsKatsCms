<?php
preserveFormData();
$name = $_POST['name'];
$email_address = $_POST['email'];
$interested = $_POST['interested'];
$phone = $_POST['phone'];
$goal = $_POST['goal'];

if (isEmpty($name) || isEmpty($email_address) || isEmpty($interested)) {
    addInfoMessage("Παρακαλώ συμπληρώστε όλες τις απαιτούμενες πληροφορίες");
}


if (!isValidMail($email_address)) {
    addErrorMessage('Μη έγκυρη διεύθυνση email');
}

if (!is_numeric($phone)) {
    addErrorMessage('Μη έγκυρος αριθμός τηλεφώνου');
}

try {
    EmailHandler::sendFitnessHouse($name, $email_address, $interested, $goal, $phone);
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR_GR);
}

if (!hasErrors()) {
    consumeFormData();
    addInfoMessage('Λαβαμε το email σας και θα επικοινωνησουμε αμεσα μαζι σας! Ευχαριστουμε');
}
Redirect(getRootUri() . "contact");