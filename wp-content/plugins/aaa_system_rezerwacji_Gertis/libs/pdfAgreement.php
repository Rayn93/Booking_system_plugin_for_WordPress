<?php

require_once 'tcpdf/tcpdf.php';

function generatePDFAgreement($guestid){

    $GuestEntry = new Gertis_GuestEntry($guestid);
    $model = new Gertis_BookingSystem_Model();
    $event_turn = $GuestEntry->getField('event_turn');
    $event_id = $model->getEventTurnId($event_turn);

    $EventEntry = new Gertis_EventEntry($event_id);

    $dates = $model->getEventDate($event_turn);
    $dates = explode(" - ", $dates);



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
    $pdf->SetMargins(6, 5, 6, true);

    $pdf->SetAutoPageBreak(TRUE, 0);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set font
    $pdf->SetFont('freeserif', 10);

    // add a page
    $pdf->AddPage();



    ob_start();

    // HTML and CSS of agreement
    ?>

    <style>

        p,
        table{
            font-size: 13px;
        }

        .font10{
            font-size: 10px;
        }

        .font12{
            font-size: 12px;
        }

        .font22{
            font-size: 16px;
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

        h3{
            font-size: 15px;
        }
        h4{
            font-size: 13px;
        }

        .text-center{
            text-align: center;
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

    <h4 class="bg-grey">Informacje o transporcie</h4>
    <p>Dojazd: <?php echo $dates[0]; ?> – dokładne informacje zostaną przesłane do Państwa na 5-7 dni przed wyjazdem. <br />
       Powrót: <?php echo $dates[1];?> – dokładne informacje zostaną przesłane do Państwa na 5-7 dni przed wyjazdem.
    </p>

    <h4 class="bg-grey">Płatności</h4>
    <br />
    <table>
        <tr>
            <td>Cena imprezy: <?php echo $EventEntry->getField('price'); ?> </td>
            <td>Cena dojazdu: <?php echo 'brak pola';?> </td>
            <td>Cena powrotu: <?php echo 'brak pola';?> </td>
        </tr>
        <tr>
            <td><strong>Cena łączna: <?php echo $GuestEntry->getField('');?>  2212 </strong></td>
        </tr>
    </table>

    <p>Wpłata: <?php echo $GuestEntry->getField('money'); ?> <br />
       Dnia: <?php echo 'brak pola';?><br />
       Pozostało do zapłaty: <?php echo ($EventEntry->getField('price')-$GuestEntry->getField('money'));?>
       <strong>Płatne do: Pozostałą należność należy uregulować na 21 dni przed wyjazdem.</strong>
    </p>
    <p class="font10">Uczestnik (opiekun) poprzez wypełnienie i podpisanie Umowy Zgłoszenia oświadcza, że w  imieniu własnym i osób zgłaszanych zapoznał się z programem imprezy oraz ze stanowiącymi integralną  cześć niniejszej umowy "Szczegółowymi warunkami uczestnictwa w imprezach turystycznych organizowanych przez Biuro Turystyki Żeglarskiej Róża Wiatrów Sp. z o.o." i zobowiązuje się do ich przestrzegania. Uczestnik (opiekun) potwierdza także, że został zapoznany z informacjami dotyczącymi: przeciwwskazań zdrowotnych związanych z uczestnictwem w imprezie, możliwości ubezpieczenia się od rezygnacji. W sprawach nieuregulowanych niniejszą umową stosowane będą postanowienia Ustawy z dnia 29 sierpnia 1997r. o usługach turystycznych oraz Kodeksu Cywilnego. Podpisanie przez Uczestnika (opiekuna) niniejszego Zgłoszenia Uczestnictwa jest równoznaczne z wyrażeniem przez niego zgody na przetwarzanie danych osobowych przez Biuro Turystyki Żeglarskiej Róża Wiatrów sp. z o.o.  zgodnie z Ustawą z dnia 29 sierpnia 1997r. Dz.U.133, pozycja 833. Biuro Turystyki Żeglarskiej Róża Wiatrów Sp. z o.o.  wpisane jest do Rejestru Organizatorów i Pośredników Turystycznych prowadzonego przez Marszałka Województwa Łódzkiego pod numerem 291. BTŻ Róża Wiatrów posiada gwarancję ubezpieczeniową w zakresie odpowiedzialności cywilnej z tytułu prowadzenia działalności organizatora turystyki w TUiR AXA S.A. o numerze 00.795.321 ważna od 27.03.2012 do 26.03.2013 (gwarancja obejmuje pokrycie kosztów  powrotu do kraju Klientów oraz kwoty niezbędne na pokrycie zwrotu wpłat wniesionych przez Klientów w razie niewykonania zobowiązań umownych).</p>

    <table>
        <tr>
            <td></td>
            <td><img src="http://www.zdrojowainvest.pl/images/stories/Jan%20Wroblewski%20-%20skan%20podpisu%20odrecznego_08.11.2010_1.jpg" width="150" height="40" ></td>
        </tr>
        <tr>
            <td>Podpis zgłaszającego</td>
            <td>Podpis przyjmującego zgłoszenie</td>
        </tr>
        <br />
        <tr>
            <td class="text-center font10" colspan="2">Wyrażam zgodę na przetwarzanie danych osobowych w celach marketingowych zgodnie z Ustawą z dnia 29 sierpnia 1997r. Dz.U.133, pozycja 833 (wysyłka  wydawnictw reklamowych).
            </td>
        </tr>

        <tr>
            <td class="text-center" colspan="2">Podpis zgłaszającego</td>
        </tr>
    </table>









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