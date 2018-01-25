<?php

//Skrypt odpowiedzialny za automatyczną zmianę przeterminowanych turnusów na nieaktualne

function wpcronEventStatusChange(){

$model = new Gertis_BookingSystem_Model();
$model->changeOldEventsStatus();
}

add_action('GertisBookingSystemCronJob', 'wpcronEventStatusChange');

if(!wp_next_scheduled('GertisBookingSystemCronJob')){
    wp_schedule_event(time(), 'daily', 'GertisBookingSystemCronJob');
}

//wp_clear_scheduled_hook( 'GertisBookingSystemCronJob' );