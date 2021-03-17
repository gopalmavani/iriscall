<h2>Registratie details</h2>
<h3 style="margin-top:20px;">----- Basisgegevens -----</h3>
<div style="border: 1px solid black">
    <table width="100%" style="font-family: Helvetica;">
        <tbody>
        <tr>
            <td width="50%">Naam: </td>
            <td><b><?= $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name; ?></b></td>
        </tr>
        <tr>
            <td width="50%">E-mail: </td>
            <td><b><?= $model->email; ?></b></td>
        </tr>
        <tr>
            <td width="50%">Geslacht: </td>
            <td><b><?php if($model->gender == 1) { ?>Mannetje<?php } else { ?>Vrouw<?php } ?></b></td>
        </tr>
        <tr>
            <td width="50%">Geboortedatum: </td>
            <td><b><?= $model->date_of_birth; ?></b>
            </td>
        </tr>
        <tr>
            <td width="50%">Extra E-mail: </td>
            <td><b><?= $model->extra_email; ?></b></td>
        </tr>
        <tr>
            <td width="50%">Telefoonnummer: </td>
            <td><b><?= $model->phone; ?></b></td>
        </tr>
        <tr>
            <td width="50%">Vaste nummer: </td>
            <td><b><?= $model->landline_number; ?></b></td>
        </tr>
        </tbody>
    </table>
</div>
<?php if($model->business_name != '') { ?>
    <h3 style="margin-top:30px;">----- Bedrijfsgegevens -----</h3>
    <div style="border: 1px solid black">
        <table width="100%" style="font-family: Helvetica;">
            <tbody>
            <tr>
                <td width="50%">Bedrijfsnaam: </td>
                <td><b><?= $model->business_name; ?></b></td>
            </tr>
            <tr>
                <td width="50%">Zakelijk land: </td>
                <td><b><?= ServiceHelper::getCountryNameFromId($model->business_country); ?></b></td>
            </tr>
            <tr>
                <td width="50%">Btw-nummer: </td>
                <td><b><?= $model->vat_number; ?></b></td>
            </tr>
            <tr>
                <td width="50%">BTW-tarief: </td>
                <td><b><?= $model->vat . '%'; ?></b></td>
            </tr>
            </tbody>
        </table>
    </div>
<?php } ?>
<h3 style="margin-top:30px;">----- Adresgegevens -----</h3>
<div style="border: 1px solid black">
    <table width="100%" style="font-family: Helvetica;">
        <tbody>
        <tr>
            <td width="50%">Adresgegevens: </td>
            <td><b><?= $model->building_num . ', '; ?>
                    <?= $model->street . ', ' . $model->city . ', '; ?>
                    <?= ServiceHelper::getCountryNameFromId($model->country) . '-' . $model->postcode; ?></b></td>
        </tr>
        <tr>
            <td width="50%">Nationaliteit: </td>
            <td><b><?= ServiceHelper::getNationalityNameFromId($model->nationality); ?></b></td>
        </tr>
        <?php if($model->billing_name != '') { ?>
        <tr>
            <td width="50%">Factuurgegevens: </td>
            <td><b><?= $model->billing_name; ?><br>
                    <?= $model->billing_building_num . ', '; ?>
                    <?= $model->billing_street . ', ' . $model->billing_city . ', '; ?>
                    <?= ServiceHelper::getCountryNameFromId($model->billing_country) . '-' . $model->billing_postcode; ?></b></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<h3 style="margin-top:20px;">----- Betalingsdetails -----</h3>
<div style="border: 1px solid black">
    <table width="100%" style="font-family: Helvetica;">
        <tbody>
        <tr>
            <td width="50%">Betalingsmiddel: </td>
            <td><b><?= $model->payment_method; ?></b></td>
        </tr>
        <?php if($model->payment_method == 'SEPA') { ?>
            <tr>
                <td width="50%">Banknaam: </td>
                <td><b><?= $model->bank_name; ?></b></td>
            </tr>
            <tr>
                <td width="50%">Bank adres: </td>
                <td><b><?= $model->bank_building_num . ', '; ?>
                        <?= $model->bank_street . ', ' . $model->bank_city . ', '; ?>
                        <?= ServiceHelper::getCountryNameFromId($model->bank_country) . '-' . $model->bank_postcode; ?></b>
                </td>
            </tr>
            <tr>
                <td width="50%">Telefoonnummer: </td>
                <td><b><?= $model->phone; ?></b></td>
            </tr>
            <tr>
                <td width="50%">Accountnaam: </td>
                <td><b><?= $model->account_name; ?></b></td>
            </tr>
            <tr>
                <td width="50%">iBAN: </td>
                <td><b><?= $model->iban; ?></b></td>
            </tr>
            <tr>
                <td width="50%">BIC Code: </td>
                <td><b><?= $model->bic_code; ?></b></td>
            </tr>
        <?php } ?>
        <?php if($model->payment_method == 'CreditCard') { ?>
            <tr>
                <td width="50%">Creditcardnaam: </td>
                <td><b><?= $model->credit_card_name; ?></b></td>
            </tr>
            <tr>
                <td width="50%">creditcardnummer: </td>
                <td><b><?= $model->credit_card_number; ?></b></td>
            </tr>
            <tr>
                <td width="50%">Vervaldatum creditcard: </td>
                <td><b><?= $model->expiry_date_month . '/' . $model->expiry_date_year; ?></b></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<br>
<br>
<br>
<br>
<h3 style="margin-top:20px;">----- Accountgegevens -----</h3>
<div style="border: 1px solid black">
    <table width="100%" style="font-family: Helvetica;">
        <tbody>
        <tr>
            <td width="50%">Gebruikersnaam: </td>
            <td><b><?= $account['user_name']; ?></b></td>
        </tr>
        <tr>
            <td width="50%">Tariefplan: </td>
            <td><b><?= $account['name']; ?></b></td>
        </tr>
        <tr>
            <td width="50%">Account Type: </td>
            <td><b><?= $account['account_type']; ?></b></td>
        </tr>
        <tr>
            <td width="50%">Voice Mail: </td>
            <td><b><?php if($account['is_voice_mail_enabled'] == 1) { ?>Enabled<?php } else { ?>Disabled<?php } ?></b></td>
        </tr>
        <tr>
            <td width="50%">Opmerkingen: </td>
            <td><b><?= $account['comments']; ?></b></td>
        </tr>
        <tr>
            <td width="50%">Nieuw telefoonnummer: </td>
            <td><b><?= $account['phone_number']; ?></b></td>
        </tr>
        <tr>
            <td width="50%">Simkaartnummer: </td>
            <td width="50%"><b><?= $account['sim_card_number']; ?></b></td>
        </tr>
        </tbody>
    </table>
</div>
<h3 style="margin-top:20px;" class="card-label">Handtekening:</h3>
<img style="width: 350px" src="<?php echo $model->signature; ?>"/>