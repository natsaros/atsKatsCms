<?php
/*//TODO - server side validation
$error = "";
$action = $isCreate ? getAdminActionRequestUri() . "user" . DS . "create" : getAdminActionRequestUri() . "user" . DS . "update";
if(isset($_POST['submit'])):*/?><!--
    <script>
        var $form2Submit = $('form[name="updateUserForm"]');
        $form2Submit.attr('action', '<?/*=$action*/?>');
        $form2Submit.submit();
    </script>
--><?php /*endif; */?>