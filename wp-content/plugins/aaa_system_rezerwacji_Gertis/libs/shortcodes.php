<?php

//Shortcode z formularzem frontend

add_shortcode('gertis_main_form', 'gertisMainForm');
function gertisMainForm(){

    $action_token = 'gertis-bs-action';
    $event_turn = $_GET['code'];
    $model = new Gertis_BookingSystem_Model();

    //$main_object = new Gertis_booking_system();

    ob_start();

    ?>

    <div id="booking_system_form" class="container">
        <div class="row">

            <div class="my_errors"><?php echo isset($_SESSION['form_error']) ? $_SESSION['form_error'] : ''; unset($_SESSION['form_error']); ?></div>

            <form class="form-horizontal" action="../Gertis_booking_system.php" data-toggle="validator" role="form" method="post">

                <?php wp_nonce_field($action_token); ?>

                <div class="form-group">
                    <label for="event_turn" class="col-sm-3 control-label">Kod imprezy *</label>
                    <div class="col-sm-4">
                        <select id="event_turn" class="form-control" name="front_entry[event_turn]" data-error="To pole nie może zostać puste" required>

                            <?php if(!empty($event_turn) && $model->checkEventTurn($event_turn) && $event_turn != 'all' ): ?>

                                <option value="<?php echo $event_turn ?>"><?php echo $event_turn ?> (Termin: <?php echo $model->getEventDate($event_turn); ?>)</option>

                            <?php elseif ($event_turn == 'all'): ?>
                                <option selected disabled>Wybierz kod imprezy</option>
                                <?php $event_list = $model->getAllPossibleEventTurns(); ?>
                                <?php foreach ($event_list as $i=>$item): ?>
                                    <option value="<?php echo $item['event_turn'] ?>"><?php echo $item['event_turn'] ?></option>
                                <?php endforeach; ?>

                            <?php else: ?>
                                <option value="0" selected disabled>Nie wybrano odpowieniego kodu imprezy</option>
                            <?php endif; ?>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <!--                <div class="form-group">-->
                <!--                    <label for="event_date" class="col-sm-3 control-label">Termin imprezy *</label>-->
                <!--                    <div class="col-sm-4">-->
                <!--                        <select id="event_date" class="form-control">-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                            <option>12 VI - 28 VI 2017</option>-->
                <!--                        </select>-->
                <!--                    </div>-->
                <!--                </div>-->

                <div class="form-group">
                    <label for="guest_name" class="col-sm-3 control-label">Imię*</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[guest_name]" id="guest_name" placeholder="Imię uczestnika"
                               data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="guest_surname" class="col-sm-3 control-label">Nazwisko*</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[guest_surname]" id="guest_surname" placeholder="Nazwisko uczestnika"
                               data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="birth_date" class="col-sm-3 control-label">Data urodzenia *</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="front_entry[birth_date]" id="birth_date" placeholder="rrrr-mm-dd" pattern="^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$"
                               data-error="Data musi zostać podana i musi mieć format: rrrr-mm-dd np. 1993-05-30" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email *</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="front_entry[email]" id="email" placeholder="Adres Email"
                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$"
                               data-error="Podaj prawidłowy adres E-mail" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-3 control-label">Nr telefonu * </label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="front_entry[phone]" id="phone" placeholder="Numer telefonu" min="0"
                               data-error="Podaj aktualny nr telefonu (musi się składać z samych liczb)" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="personal_no" class="col-sm-3 control-label">Pesel lub nr Dowodu osobistego *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[personal_no]" id="personal_no" placeholder="Pesel lub nr dowodu osobistego" data-minlength="9"
                               data-error="Podaj min 9 znaków" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="street" class="col-sm-3 control-label">Ulica i nr budynku / mieszkania *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[street]" id="street" placeholder="Ulica i numer budynku zamieszkania np. Piłsudzkiego 14b/26"
                               data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="zip_code" class="col-sm-3 control-label">Kod pocztowy *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[zip_code]" id="zip_code" pattern="^\d{2}(?:[-]\d{3})?$"
                               placeholder="Kod pocztowy miejsca zamieszkania"
                               data-error="Wprowadzona wartość musi mieć format xx-xxx np. 41-400" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="city" class="col-sm-3 control-label">Miasto *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="front_entry[city]" id="city" placeholder="Miejscowość zamieszkania np. Poznań"
                               data-error="To pole nie może zostać puste" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="from_who" class="col-sm-3 control-label">Skąd o nas wiesz?</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="front_entry[from_who]" id="from_who" placeholder="Np. znajomi, internet, gazeta itp." maxlength="499" data-error="Maksymalna ilość znaków: 500"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="more_info" class="col-sm-3 control-label">Uwagi dodatkowe</label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="front_entry[more_info]" id="more_info" placeholder="Twoje pytania, faktura VAT, dojazd itp." maxlength="499" data-error="Maksymalna ilość znaków: 500"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">

                        <?php
                        //Localhost
                        if($_SERVER['HTTP_HOST']=='localhost') {
                            echo '<div class="g-recaptcha" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback" data-sitekey="6LcesSATAAAAAKLNFstcDb6fhWKvXNvshHJSnXNC"></div>';
                        }
                        //Production server
                        else {
                           echo '<div class="g-recaptcha" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback" data-sitekey="6LcXvxgUAAAAAKQ-zHtE8Lw59insDi6rXFTREY43"></div>';
                        }
                        ?>

                        <input type="hidden" class="form-control" data-recaptcha="true" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

<!--                Validation captcha-->
                <script>
                    var originalInputSelector = $.fn.validator.Constructor.INPUT_SELECTOR
                    $.fn.validator.Constructor.INPUT_SELECTOR = originalInputSelector + ', input[data-recaptcha]'

                    window.verifyRecaptchaCallback = function (response) {
                        $('input[data-recaptcha]').val(response).trigger('change')
                    }

                    window.expiredRecaptchaCallback = function () {
                        $('input[data-recaptcha]').val("").trigger('change')
                    }

                    $('form[data-toggle="validator"]')
                        .validator({
                            custom: {
                                recaptcha: function ($el) {
                                    if (!$el.val()) {
                                        return "Please complete the captcha"
                                    }
                                }
                            }
                        })
                </script>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required> Znam i akceptuję <a class="credential" href="https://www.obozy-zeglarskie.pl/ogolne-warunki-uczestnictwa/" target="_blank">warunki uczestnictwa w imprezie</a>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required> Informujemy, że przetwarzamy Twoje dane osobowe w związku z zawarciem umowy zgodnie z <a class="credential" href="https://www.obozy-zeglarskie.pl/polityka-prywatnosci/" target="_blank">polityką prywatności</a>
                            </label>
                        </div>
                    </div>
                </div>

<!--                <div class="form-group">-->
<!--                    <div class="col-sm-offset-3 col-sm-9">-->
<!--                        <div class="checkbox">-->
<!--                            <label>-->
<!--                                <input type="checkbox" required>  Wyrażam zgodę na otrzymywanie newslettera i informacji handlowych od BTA Gertis. Zgoda jest dobrowolna. Mam prawo cofnąć zgodę w każdym czasie (dane przetwarzane są do czasu cofnięcia zgody). Mam prawo dostępu do danych, sprostowania, usunięcia lub ograniczenia przetwarzania, prawo sprzeciwu, prawo wniesienia skargi do organu nadzorczego lub przeniesienia danych. Administratorem danych jest BTA Gertis Marek Makowski.</a>-->
<!--                            </label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <?php if(!empty($event_turn) && $model->checkEventTurn($event_turn)): ?>
                            <button type="submit" class="btn btn-default">Zapisz mnie</button>
                        <?php endif; ?>
                        <?php if($event_turn == 'all'): ?>
                            <button type="submit" class="btn btn-default">Zapisz mnie</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php

    $form = ob_get_contents();
    ob_end_clean();

    return $form;

}

//Shortcode z tabelą wydarzenia

add_shortcode('gertis_oboz', 'gertisPrintEventTable');
function gertisPrintEventTable($args){

    $event_code = shortcode_atts(array('kod_obozu' => 'OPT'), $args);

    $model = new Gertis_BookingSystem_Model();
    $event_list = $model->getEventTurn($event_code['kod_obozu']);


    ob_start();

    ?>

    <table class="event_table">
        <tr>
            <th>Kod imprezy</th>
            <th>Początek</th>
            <th>Koniec</th>
            <th>Cena</th>
            <th>Wolne miejsca</th>
            <th>Link do rezerwacji</th>
        </tr>

        <?php if(!empty($event_list)): ?>
            <?php foreach ($event_list as $i=>$item): ?>
                <?php $free_seats = ((int)$item['seat_no'] - (int)$item['taken_seats']); ?>

                <tr>
                    <td><?php echo $item['event_turn']; ?></td>
                    <td><?php $start_date = date_create($item['start_date']); echo date_format($start_date, 'd-m-Y');?></td>
                    <td><?php $end_date = date_create($item['end_date']); echo date_format($end_date, 'd-m-Y');?></td>
                    <td><?php echo $item['price']; ?> zł</td>
                    <td><?php echo $free_seats;?></td>

                    <?php if($free_seats > 0): ?>
                        <td><a class="booking" href="<?php echo get_site_url().'/a-system-rezerwacji/?code='.$item['event_turn']; ?>" >Rezerwuj</a></td>
                    <?php else: ?>
                        <td> Brak wolnych miejsc </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Brak obozów tego typu</td>
            </tr>
        <?php endif; ?>
    </table>


    <?php

    $table = ob_get_contents();
    ob_end_clean();

    return $table;

}





add_action('init', 'my_init');
function my_init() {
    if (!session_id()) {
        session_start();
    }
}
