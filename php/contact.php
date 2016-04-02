<?php

$errors = '';

if (isset($_POST['submit'])) {
    $myemail = 'natsaros@gmail.com';

    $name = $_POST['name'];
    $email_address = $_POST['email'];
    $interested = $_POST['interested'];

    if (empty($name)
        || empty($email_address)
        || empty($interested)
    ) {
        $errors .= "\n Error: all fields are required";
    }

    $goal = $_POST['goal'];

    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email_address)) {
        $errors .= "\n Error: Invalid email address";
    }

    //TODO-FIXME : server side error handling,now only html5 form handling
    if (empty($errors)) {
        $to = $myemail;
        $email_subject = "Fitness house Contact from: $name";
        $email_body = "\n
        Name: $name \n
        Email: $email_address\n\n";
        if (!empty($goal)) {
            $email_body .= "\tGoals: \n \t$goal\n\n";
        }
        $email_body .= "\tInterested in : \n \t $interested \n";


        $headers = "From: $myemail\n";
        $headers .= "Reply-To: $email_address";
        mail($to, $email_subject, $email_body, $headers);

        header('Location: ../html/contact.html');
    }
}
?>