<?php
$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$text = $_POST['text'];

if (isEmpty(trim($name)) || isEmpty(trim($email_address)) || isEmpty(trim($text))) {
    addErrorMessage("Παρακαλώ συμπληρώστε όλες τις απαιτούμενες πληροφορίες");
}

if (isNotEmpty(trim($email_address)) && !isValidMail($email_address)) {
    addErrorMessage('Μη έγκυρη διεύθυνση email');
}

if (isNotEmpty(trim($phone)) && !is_numeric($phone)) {
    addErrorMessage('Μη έγκυρος αριθμός τηλεφώνου');
}

if(hasErrors()) {
    FormHandler::setSessionForm('sendEmailForm');
    Redirect(getRootUri() . "contact");
}

try {
    EmailHandler::sendEmailToSellinofos($name, $email_address, $text, $phone);
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR_GR);
}

if (!hasErrors()) {
    addInfoMessage('Λάβαμε το email σας και θα επικοινωνήσουμε άμεσα μαζί σας! Ευχαριστούμε!');
}
Redirect(getRootUri() . "contact");