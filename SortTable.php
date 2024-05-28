<?php
    include('Functions.php');

    if(isset($_GET['Sort']) && isset($_GET['Query']) && isset($_GET['Path']))
    {
        $path = $_GET['Path'];
        $old_query = urldecode($_GET['Query']);
        print_r($old_query);
        $sort_type = $_GET['Sort'];

        $new_query_arr = [];
        parse_str($old_query, $new_query_arr);

        $new_redirect_str = array_merge($new_query_arr, ['Sort' => $sort_type]);
        
        $redirect = $path . '.php?' . http_build_query($new_redirect_str);

        redirect($redirect);
    }
?>