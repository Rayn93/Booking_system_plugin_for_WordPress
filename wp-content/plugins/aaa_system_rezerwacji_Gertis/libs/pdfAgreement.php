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
    $pdf->SetMargins(5, 4, 5, true);

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

        ul,
        ol,
        li{
            font-size: 10.5px;
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
            background-color: #bbc0c5;
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
    <table>
        <tr>
            <td>
                <h4 class="bg-grey">Dane uczestnika</h4>
                <p><strong>Imię i nazwisko:</strong> <?php echo $GuestEntry->getField('guest_name').' '.$GuestEntry->getField('guest_surname'); ?><br />
                   <strong>Adres:</strong>  <?php echo $GuestEntry->getField('street').' '.$GuestEntry->getField('city').' '.$GuestEntry->getField('zip_code'); ?><br />
                   <strong>Numer PESEL / dowodu:</strong> <?php echo $GuestEntry->getField('personal_no'); ?><br />
                   <strong>Telefon kontaktowy:</strong>  <?php echo $GuestEntry->getField('phone'); ?><br />
                   <strong>Email:</strong>  <?php echo $GuestEntry->getField('email') ?>
                </p>
            </td>
            <td>
                <h4 class="bg-grey">Dane opiekuna</h4>
                <p><strong>Imię i nazwisko:</strong> <?php echo $GuestEntry->getField('').' '.$GuestEntry->getField(''); ?><br />
                   <strong>Adres:</strong>  <?php echo $GuestEntry->getField('').' '.$GuestEntry->getField('').' '.$GuestEntry->getField(''); ?><br />
                   <strong>Telefon kontaktowy:</strong>  <?php echo $GuestEntry->getField(''); ?><br />
                   <strong>Email:</strong>  <?php echo $GuestEntry->getField('') ?>
                </p>
            </td>
        </tr>
    </table>

    <h4 class="bg-grey">Dane Imprezy</h4>
    <p><strong>Kod imprezy:</strong> <?php echo $event_turn;?><br />
       <strong>Data imprezy:</strong> <?php echo $model->getEventDate($event_turn);?>
    </p>

    <h4 class="bg-grey">Informacje o transporcie</h4>
    <p><strong>Dojazd:</strong> <?php echo $dates[0]; ?> – dokładne informacje zostaną przesłane do Państwa na 5-7 dni przed wyjazdem. <br />
       <strong>Powrót:</strong> <?php echo $dates[1];?> – dokładne informacje zostaną przesłane do Państwa na 5-7 dni przed wyjazdem.
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

    <p><strong>Wpłata:</strong> <?php echo $GuestEntry->getField('money'); ?> <br />
       <strong>Dnia:</strong> <?php echo 'brak pola';?> <br />
       <strong>Pozostało do zapłaty:</strong> <?php echo ($EventEntry->getField('price')-$GuestEntry->getField('money'));?><br />
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
        <br /><br />
        <tr>
            <td class="text-center" colspan="2">Podpis zgłaszającego</td>
        </tr>
    </table>

    <br pagebreak="true"/>

    <h5 class="text-center">Szczegółowe Warunki Uczestnictwa w Imprezach Biura Turystyki Żeglarskiej Róża Wiatrów Sp. z o.o.</h5>

    <ol>
        <li>Biuro Turystyki Żeglarskiej Róża Wiatrów sp. z.o.o. wpisane jest do Rejestru Organizatorów i Pośredników Turystycznych prowadzonego przez Marszałka Województwa Łódzkiego pod numerem 291. BTŻ Róża Wiatrów  sp. z o.o. posiada gwarancję ubezpieczeniową w zakresie odpowiedzialności cywilnej z tytułu prowadzenia działalności organizatora turystyki w TUiR AXA S.A. z siedzibą w Warszawie ul. Chłodna 51 o numerze 00.795.321 ważna od 27.03.2013 do 26.03.2014 (gwarancja obejmuje pokrycie kosztów powrotu do kraju Uczestników, oraz kwoty niezbędne na pokrycie zwrotu wpłat wniesionych przez Uczestników w razie niewykonania zobowiązań umownych). Zawarcie umowy następuje po przez wypełnienie druku zgłoszenia w biurze lub na stronie internetowej przez uczestnika (jeżeli jest pełnoletni) lub jego opiekuna i przez wpłatę zaliczki. Organizator wystawia uczestnikowi po otrzymaniu wpłaty zaliczki umowę w formie pisemnej i przesyła podpisaną przez upoważnionego pracownika pocztą na podany w zgłoszeniu adres. Przy wypełnianiu druku zgłoszenia (umowy) uczestnik otrzymuje lub ma możliwość zapoznania się (wydrukowania ze strony internetowej) ze Szczegółowymi Warunkami Uczestnictwa w Imprezach i Certyfikatem OC organizatora.</li>
        <li>Umowa obowiązuje po otrzymaniu przez organizatora wpłaty zaliczki. Uczestnik (opiekun) wpłaca zaliczkę w wysokości ustalonej dla danej imprezy. Pozostałą należność uczestnik (opiekun) jest zobowiązany wpłacić najpóźniej na 21 dni przed rozpoczęciem imprezy pod rygorem skreślenia z listy uczestników. W przypadku podpisywania umowy w terminie krótszym niż 21 dni do dnia rozpoczęcia umowy, wymagana jest pełna wpłata. Wpłat należy dokonywać:</li>
        <ul>
            <li>gotówką w Biurze Turystyki Żeglarskiej Róża Wiatrów sp. z o.o.  90-301 Łódź, ul. Wigury 12/3,</li>
            <li>przelewem na konto bankowe Biura Turystyki Żeglarskiej Róża Wiatrów sp. z o.o. 90-301 Łódź, ul. Wigury 12/3, Credit Agricole 60 1940 1076 3068 6351 0000 0000,</li>
            <li>przekazem pocztowym na adres: Biuro Turystyki Żeglarskiej Róża Wiatrów sp. z o.o. 90-301 Łódź, ul. Wigury 12/3.</li>
            <li>Przy wpłacie z podpunktu b i c za datę wpłaty przyjmuje się datę wpływu wpłaty do organizatora.</li>
        </ul>
        <li>Informujemy, iż faktury vat dla uczestnika lub zakładu pracy wystawiamy niezwłocznie po zgłoszeniu BTŻ Róża Wiatrów Sp. z o.o. zapotrzebowania i przekazania wszystkich danych niezbędnych do jej wystawienia. Jednocześnie przypominamy, iż nieprzekraczalny termin wystawienia faktury vat wynosi 14 dni od daty zakończenia imprezy zgodnie z ustawą o podatku od towarów i usług oraz podatku dochodowym oraz Rozporządzeniem Ministra Finansów w sprawie niektórych przepisów ustawy o podatku od towarów i usług oraz podatku akcyzowym. Po upływie tego terminu faktury vat nie będą wystawiane.</li>
        <li>Po zawarciu umowy uczestnik otrzymuje kartę obozową i inne niezbędne przy danej imprezie dokumenty. Organizator zaleca zawarcie dodatkowego ubezpieczenia z tytułu rezygnacji z imprezy z przyczyn losowych, a także wcześniejszego z niej powrotu. Ubezpieczenie to jest dobrowolne i nie jest wliczone w cenę imprezy. Ubezpieczenie z tytułu rezygnacji można wykupić tylko i wyłącznie w dniu zawierania umowy (opcje dodatkowe w formularzu rezerwacyjnym).</li>
        <li>Organizator zastrzega sobie prawo do odwołania imprezy lub imprezy fakultatywnej z powodu zbyt małej liczby uczestników (poniżej 10 osób).</li>
        <li>W przypadku rozwiązania umowy (odwołania imprezy) z winy organizatora uczestnik otrzymuje niezwłocznie zwrot pełnej wpłaconej do tego czasu kwoty lub - do wyboru - skierowanie na inną imprezę zaproponowaną przez organizatora, nie przysługuje z tego powodu żadne odszkodowanie ani odsetki.</li>
        <li>Rezygnacja udziału uczestnika w imprezie następuje w momencie złożenia rezygnacji w formie pisemnej lub w dzień niewykonania przez uczestnika określonych w n.n. Warunkach Uczestnictwa czynności. Organizator ma prawo obciążyć uczestnika faktycznymi kosztami, jakie poniesie w związku z rezygnacją uczestnika z imprezy. Oszacowanie faktycznie poniesionych kosztów może nastąpić najpóźniej w ciągu 3 dni roboczych od dnia zakończenia imprezy turystycznej z której rezygnuje uczestnik. Takie samo uprawnienie zachowuje Organizator w sytuacji, gdy niewykonanie lub nienależyte wykonanie umowy spowodowane jest wyłącznie działaniem lub zaniechaniem uczestnika. Organizator nie będzie żądać żadnych kwot z tytułu odstąpienia od umowy, jeżeli uczestnik odstępujący od umowy wskaże osobę której przekaże uprawnienia i która przejmie obowiązki wynikające z umowy. Za nieuiszczoną część ceny imprezy turystycznej oraz koszty poniesione przez organizatora w wyniku zmiany uczestnika, uczestnik i osoba przejmująca jego uprawnienia odpowiadają solidarnie.</li>
        <li>W przypadku sprzedaży agencyjnej uczestnika obowiązują warunki uczestnictwa bezpośredniego organizatora imprezy.</li>
        <li>Życie na obozie lub rejsie reguluje regulamin oraz codzienne informacje podawane rano podczas odprawy załóg.</li>
        <li>Organizator zastrzega sobie prawo do zmiany miejsca rozpoczęcia i zakończenia rejsu oraz przesunięć w terminach. W takiej sytuacji uczestnik zostanie poinformowany pocztą lub mailem. Bez wcześniejszego poinformowania uczestników nastąpić mogą zmiany godzin rozpoczęcia i zakończenia imprezy w szczególności uzależnione od godzin przyjazdu autokarów. Organizator nie odpowiada za zakłócenia w przebiegu programu imprezy spowodowane siłą wyższą.</li>
        <li>Uczestnik (opiekun) jest zobowiązany do zapoznania się z warunkami bytowymi oferowanymi na danej imprezie (zakwaterowanie, wyżywienie, konieczność ponoszenia wysiłku podczas wiosłowania, jazdy rowerem, pracy na jachcie itp.). Podpisując zgłoszenie uczestnik (opiekun) akceptuje te warunki i uciążliwości związane z nimi nie mogą stanowić podstawy reklamacji.</li>
        <li>Organizator nie ponosi odpowiedzialności za utratę, uszkodzenia rzeczy uczestników w szczególności sprzętu elektronicznego (aparaty fotograficzne, telefoniczne itp.). Organizator nie ponosi odpowiedzialności odszkodowawczej w stosunku do uczestników ponad kwotę rzeczywistej szkody i ogranicza ją do dwukrotności ceny imprezy.</li>
        <li>Ewentualne reklamacje - jeżeli to możliwe - należy składać bezpośrednio na miejscu w trakcie trwania imprezy lub najpóźniej w ciągu 30 dni po jej zakończeniu w formie pisemnej pod rygorem nieważności.</li>
        <li>Uczestnik jest zobowiązany do posiadania następujących dokumentów: dokumentu tożsamości (dowód, legitymacja), całkowicie wypełnionej karty obozowej, dokumentu zaświadczającego o posiadaniu uprawnień do korzystania z bezpłatnych usług medycznych lub polisy ubezpieczeniowej od kosztów leczenia. Brak któregokolwiek z ww. dokumentów może zostać potraktowany jak zerwanie umowy z winy uczestnika i spowodować nie przyjęcie uczestnika na imprezę.</li>
        <li>Organizator zastrzega sobie możliwość wydalenia uczestnika z imprezy z powodu naruszenia przepisów obowiązującego prawa, regulaminów (w szczególności dotyczy spożywania i posiadania alkoholu, narkotyków i innych środków odurzających oraz samowolnych kąpieli i oddaleń) lub szczegółowych warunków uczestnictwa w imprezach. Kosztami wydalenia obciążony będzie uczestnik (opiekun).</li>
        <li>Informujemy, że podczas kolonii, obozów i rejsów organizowanych przez Biuro Turystyki Żeglarskiej Róża Wiatrów sp. z o.o. wykonywane są pamiątkowe fotografie uczestników. W związku z tym każdy uczestnik (opiekun prawny) poprzez podpisanie niniejszych warunków uczestnictwa wyraża zgodę na nieodpłatne utrwalenie wizerunku uczestnika w formie filmu lub fotografii analogowej i cyfrowej oraz wyraża nieodpłatną zgodę na rozpowszechnianie tych materiałów za pośrednictwem dowolnego medium. W przypadku braku zgody prosimy o złożenie pisemnego oświadczenia.</li>
        <li>W sprawach nieuregulowanych  niniejszą umową zastosowanie mają przepisy Kodeksu Cywilnego i Ustawy o Usługach Turystycznych (D.U. 2001 poz. 55.578.).</li>
    </ol>


    <?php

    $html = ob_get_contents();
    ob_end_clean();


    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');


    $filename= "{$guestid}-{$GuestEntry->getField('guest_name')}-{$GuestEntry->getField('guest_surname')}.pdf";

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


function sendGeneratedPDF($guestid){

    $GuestEntry = new Gertis_GuestEntry($guestid);

    $to = $GuestEntry->getField('email');
    $message = '<p>Cześć w załączniku wysyłamy umowę</p>';
    $subject = 'Gertis - Obozy żeglarskie: Wysłanie umowy';

    if($_SERVER['HTTP_HOST']=='localhost') {
        $attachments = 'C:\\xampp\\htdocs\\obozy-zeglarskie\\wp-content\\plugins\\aaa_system_rezerwacji_Gertis\\umowy\\'.$GuestEntry->getField('id').'-'.$GuestEntry->getField('guest_name').'-'.$GuestEntry->getField('guest_surname').'.pdf';
    }
    else {
        $attachments = $_ENV["DOCUMENT_ROOT"]."/umowy".$GuestEntry->getField('id').'-'.$GuestEntry->getField('guest_name').'-'.$GuestEntry->getField('guest_surname').'.pdf';
    }

    return (wp_mail($to, $subject, $message, $headers = '', $attachments));

}





?>