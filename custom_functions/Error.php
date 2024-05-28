<?php

function abort_and_redirect($abort_message, $redirect_target)
{
    setCookieMessage($abort_message);
    redirect($redirect_target);
}

?>