<?php 

function get_current_timestamp()
{
    $dt = new DateTime("now", new DateTimeZone("Australia/Melbourne"));
    
    return $dt->format("Y/m/d H:i:s");
}

?>