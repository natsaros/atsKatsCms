<?php
preserveFormData();
$name = $_POST['name'];
$email_address = $_POST['email'];
$interested = $_POST['interested'];
$phone = $_POST['phone'];
$goal = $_POST['goal'];

if (isEmpty(trim($name)) || isEmpty(trim($email_address)) || isEmpty(trim($interested))) {
    addErrorMessage("Παρακαλώ συμπληρώστε όλες τις απαιτούμενες πληροφορίες");
}

if (isNotEmpty(trim($email_address)) && !isValidMail($email_address)) {
    addErrorMessage('Μη έγκυρη διεύθυνση email');
}

if (isNotEmpty(trim($phone)) && !is_numeric($phone)) {
    addErrorMessage('Μη έγκυρος αριθμός τηλεφώνου');
}

if(hasErrors()) {
    if (!empty($_POST)) {
        foreach($_POST as $key => $value) {
            $_SESSION['sendEmailForm'][$key] = $value;
        }
        $_SESSION['sendEmailForm'][$key] = $value;
    }
    Redirect(getRootUri() . "contact");
}

try {
    EmailHandler::sendFitnessHouse($name, $email_address, $interested, $goal, $phone);
} catch (SystemException $ex) {
    logError($ex);
    addErrorMessage(ErrorMessages::GENERIC_ERROR_GR);
}

if (!hasErrors()) {
    consumeFormData();
    addInfoMessage('Λάβαμε το email σας και θα επικοινωνήσουμε άμεσα μαζί σας! Ευχαριστούμε!');
}
Redirect(getRootUri() . "contact");