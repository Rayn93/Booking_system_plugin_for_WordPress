<?php

require_once 'tcpdf/tcpdf.php';

function generatePDFAgreement($guestid){

    $GuestEntry = new Gertis_GuestEntry($guestid);
    $model = new Gertis_BookingSystem_Model();
    $event_turn = $GuestEntry->getField('event_turn');
    $event_id = $model->getEventTurnId($event_turn);

    $EventEntry = new Gertis_EventEntry($event_id);



    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Gertis - obozy-zeglarskie.pl');
    $pdf->SetTitle('Umowa dla klienta');
    $pdf->SetSubject('Umowa dla klientao id:'.$guestid);
    $pdf->SetKeywords('umowa, obozy, gertis, PDF');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
//    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetMargins(10, 10, 10, true);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set font
    $pdf->SetFont('freeserif', 12);

    // add a page
    $pdf->AddPage();



    ob_start();

    // HTML and CSS of agreement
    ?>

    <style>

        .font12{
            font-size: 12px;
        }

        .left{
            text-align: left;
            /*font-size: 12px;*/
            /*width: 48%;*/
            /*float: left;*/
        }

        .right{
            text-align: right;
            /*font-size: 12px;*/
            /*width: 48%;*/
            /*float: right;*/
        }

        .bg-grey{
            background-color: #9fa4a9;
        }


    </style>


    <table class="font12">
        <tr>
            <td class="left"> Róża Wiatrów </td>
            <td class="right"> Dane Agenta </td>
        </tr>
        <tr>
            <td class="left"> 90- 301 Łódź, ul. Wigury12/3 </td>
            <td class="right"> Biuro Turystyki Aktywnej „Gertis” </td>
        </tr>
        <tr>
            <td class="left"> tel: (42) 630 73 01; 631 18 16, fax: (42) 630 74 08 </td>
            <td class="right"> 11-500 Giżycko, Świdry 11 </td>
        </tr>
        <tr>
            <td class="left"> www.roza.pl - email: roza@roza.pl </td>
            <td class="right"> Tel. (87) 428 14 41, 501 742 657 </td>
        </tr>
        <tr>
            <td class="left">  </td>
            <td class="right"> <a href="www.obozy-zeglarskie.pl">www.Obozy-Zeglarskie.pl</a>, biuro@gertis.pl </td>
        </tr>
    </table>

    <h3 class="bg-grey">UMOWA - ZGŁOSZENIE Z DNIA <?php echo $GuestEntry->getField('register_date'); ?></h3>

    <h4 class="bg-grey">Dane uczestnika</h4>
    <p>Imię i nazwisko: <?php echo $GuestEntry->getField('guest_name').' '.$GuestEntry->getField('guest_surname'); ?><br />
       Adres zamieszkania:  <?php echo $GuestEntry->getField('street').' '.$GuestEntry->getField('city').' '.$GuestEntry->getField('zip_code'); ?><br />
       Numer PESEL: : <?php echo $GuestEntry->getField('personal_no'); ?><br />
       Telefon kontaktowy:  <?php echo $GuestEntry->getField('phone'); ?><br />
       Email:  <?php echo $GuestEntry->getField('email') ?>
    </p>

    <h4 class="bg-grey">Dane opiekuna</h4>
    <p>Imię i nazwisko: <?php echo $GuestEntry->getField('').' '.$GuestEntry->getField(''); ?><br />
        Adres zamieszkania:  <?php echo $GuestEntry->getField('').' '.$GuestEntry->getField('').' '.$GuestEntry->getField(''); ?><br />
        Telefon kontaktowy:  <?php echo $GuestEntry->getField(''); ?><br />
        Email:  <?php echo $GuestEntry->getField('') ?>
    </p>

    <h4 class="bg-grey">Dane Imprezy</h4>
    <p>Kod imprezy: <?php echo $event_turn;?><br />
       Data imprezy: <?php echo $model->getEventDate($event_turn);?><br />

    </p>






    <?php

    $html = ob_get_contents();
    ob_end_clean();


    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');


//        // print a block of text using Write()
//        $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

    $filename= "{$guestid}.pdf";

    if($_SERVER['HTTP_HOST']=='localhost') {
        $filelocation = "C:\\xampp\\htdocs\\obozy-zeglarskie\\wp-content\\plugins\\aaa_system_rezerwacji_Gertis\\umowy";
        $fileNL = $filelocation."\\".$filename;
    }

    else {
        $filelocation= $_ENV["DOCUMENT_ROOT"]."/umowy";
        $fileNL = $filelocation."/".$filename;
    }


    //Close and output PDF document
    ob_end_clean();
    $pdf->Output($fileNL,'FI');

    return $pdf;


}





?>