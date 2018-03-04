<?php
preserveFormData();
$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$text = $_POST['text'];

if (isEmpty($name) || isEmpty($email_address) || isEmpty($text)) {
    addInfoMessage("Παρακαλώ συμπληρώστε όλες τις απαιτούμενες πληροφορίες");
}


if (!isValidMail($email_address)) {
    addErrorMessage('Μη έγκυρη διεύθυνση email');
}

if (!is_numeric($phone)) {
    addErrorMessage('Μη έγκυρος αριθμός τηλεφώνου');
}

try {
    EmailHandler::sendEmailToSellinofos($name, $email_address, $text, $phone);
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR_GR);
}

if (!hasErrors()) {
    consumeFormData();
    addInfoMessage('Λάβαμε το email σας και θα επικοινωνήσουμε άμεσα μαζί σας! Ευχαριστούμε!');
}
Redirect(getRootUri() . "contact");