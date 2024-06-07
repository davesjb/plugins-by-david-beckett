<?php

/*
 * Plugin Name: Random Quote Generator David
 * Description: This plugin display random quote in wp admin panel
 * Version: 1.0
 * Author: David Beckett
 * 
 */


// $quotes = [
//     "If you correct your mind, the rest of your life will fall into place.",
//     "Life's challenges are not supposed to paralyse you, they're supposed to help you discover who you are.  Bernice Reagon",
//     "It is on our failures that we base a new and different and better success.  Havelock Ellis"
// ];


// function display_random_quote()
// {
//     global $quotes;
//     $random = array_rand($quotes);
//     $quote = $quotes[$random];
//     echo "<p>$quote</p>";
// }

// add_action("admin_notices", "display_random_quote");

function display_api_response()
{
    $response = wp_remote_get("https://api.ipify.org");
    $data = wp_remote_retrieve_body($response);
    echo "<p> your ip adddress is $data</p>";
}

// display_api_response();

add_action("admin_notices", "display_api_response");
