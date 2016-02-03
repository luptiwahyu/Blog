<?php 

/**
 * Days
 * @return array number of days
 */
function days() {
    $days = array(
        '01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
        '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
        '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'
    );

    return $days;
}

/**
 * Months
 * @return array number of months
 */
function months() {
    $months = array(
        '01' => 'January', 
        '02' => 'February', 
        '03' => 'March', 
        '04' => 'April', 
        '05' => 'May', 
        '06' => 'June', 
        '07' => 'July', 
        '08' => 'August', 
        '09' => 'September', 
        '10' => 'October', 
        '11' => 'November', 
        '12' => 'December'
    );

    return $months;
}


function sluggify($url)
{
    # Prep string with some basic normalization
    $url = strtolower($url);
    $url = strip_tags($url);
    $url = stripslashes($url);
    $url = html_entity_decode($url);

    # Remove quotes (can't, etc.)
    $url = str_replace('\'', '', $url);

    # Replace non-alpha numeric with hyphens
    $match = '/[^a-z0-9]+/';
    $replace = '-';
    $url = preg_replace($match, $replace, $url);

    $url = trim($url, '-');

    return $url;
}