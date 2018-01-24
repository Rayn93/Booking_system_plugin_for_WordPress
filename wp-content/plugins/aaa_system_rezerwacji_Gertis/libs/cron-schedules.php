<?php


function wpcronEventStatusChange(){

    $model = new Gertis_BookingSystem_Model();
    $model->changeOldEventsStatus();
}

add_action('GertisBookingSystemCronJob', 'wpcronEventStatusChange');

if(!wp_next_scheduled('GertisBookingSystemCronJob')){
    wp_schedule_event(time(), 'hourly', 'GertisBookingSystemCronJob');
}