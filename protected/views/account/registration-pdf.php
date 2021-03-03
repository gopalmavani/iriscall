<h1>Registration Details</h1>
<h3>----- Basic Details -----</h3>
<div style="border: 1px solid black">
    <table>
        <tbody>
        <tr>
            <td>Name: </td>
            <td><b><?= $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name; ?></b></td>
        </tr>
        <tr>
            <td>Email: </td>
            <td><b><?= $model->email; ?></b></td>
        </tr>
        <tr>
            <td>Gender: </td>
            <td><b><?php if($model->gender == 1) { ?>Male<?php } else { ?>Female<?php } ?></b></td>
        </tr>
        <tr>
            <td>Date Of Birth: </td>
            <td><b><?= $model->date_of_birth; ?></b>
            </td>
        </tr>
        <tr>
            <td>Additional Email: </td>
            <td><b><?= $model->extra_email; ?></b></td>
        </tr>
        <tr>
            <td>Phone Number: </td>
            <td><b><?= $model->phone; ?></b></td>
        </tr>
        <tr>
            <td>Landline Number: </td>
            <td><b><?= $model->landline_number; ?></b></td>
        </tr>
        </tbody>
    </table>
</div>
<?php if($model->business_name != '') { ?>
    <h3>----- Business Details -----</h3>
    <div style="border: 1px solid black">
        <table>
            <tbody>
            <tr>
                <td>Business Name: </td>
                <td><b><?= $model->business_name; ?></b></td>
            </tr>
            <tr>
                <td>Business Country: </td>
                <td><b><?= ServiceHelper::getCountryNameFromId($model->business_country); ?></b></td>
            </tr>
            <tr>
                <td>VAT Number: </td>
                <td><b><?= $model->vat_number; ?></b></td>
            </tr>
            <tr>
                <td>VAT Rate: </td>
                <td><b><?= $model->vat . '%'; ?></b></td>
            </tr>
            </tbody>
        </table>
    </div>
<?php } ?>
<h3>----- Address Details -----</h3>
<div style="border: 1px solid black">
    <table>
        <tbody>
        <tr>
            <td>Address Details: </td>
            <td><b><?= $model->building_num . ', '; ?>
                    <?= $model->street . ', ' . $model->city . ', '; ?>
                    <?= ServiceHelper::getCountryNameFromId($model->country) . '-' . $model->postcode; ?></b></td>
        </tr>
        <tr>
            <td>Nationality: </td>
            <td><b><?= ServiceHelper::getNationalityNameFromId($model->nationality); ?></b></td>
        </tr>
        <?php if($model->billing_name != '') { ?>
        <tr>
            <td>Billing Details: </td>
            <td><b><?= $model->billing_name; ?><br>
                    <?= $model->billing_building_num . ', '; ?>
                    <?= $model->billing_street . ', ' . $model->billing_city . ', '; ?>
                    <?= ServiceHelper::getCountryNameFromId($model->billing_country) . '-' . $model->billing_postcode; ?></b></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<h3>----- Payment Details -----</h3>
<div style="border: 1px solid black">
    <table>
        <tbody>
        <tr>
            <td>Payment Method: </td>
            <td><b><?= $model->payment_method; ?></b></td>
        </tr>
        <?php if($model->payment_method == 'SEPA') { ?>
            <tr>
                <td>Bank Name: </td>
                <td><b><?= $model->bank_name; ?></b></td>
            </tr>
            <tr>
                <td>Bank Address: </td>
                <td><b><?= $model->bank_building_num . ', '; ?>
                        <?= $model->bank_street . ', ' . $model->bank_city . ', '; ?>
                        <?= ServiceHelper::getCountryNameFromId($model->bank_country) . '-' . $model->bank_postcode; ?></b>
                </td>
            </tr>
            <tr>
                <td>Phone Number: </td>
                <td><b><?= $model->phone; ?></b></td>
            </tr>
            <tr>
                <td>Account Name: </td>
                <td><b><?= $model->account_name; ?></b></td>
            </tr>
            <tr>
                <td>iBAN: </td>
                <td><b><?= $model->iban; ?></b></td>
            </tr>
            <tr>
                <td>BIC Code: </td>
                <td><b><?= $model->bic_code; ?></b></td>
            </tr>
        <?php } ?>
        <?php if($model->payment_method == 'CreditCard') { ?>
            <tr>
                <td>Credit Card Name: </td>
                <td><b><?= $model->credit_card_name; ?></b></td>
            </tr>
            <tr>
                <td>Credit Card Number: </td>
                <td><b><?= $model->credit_card_number; ?></b></td>
            </tr>
            <tr>
                <td>Credit Card Expiration: </td>
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
<h3>----- Account Details -----</h3>
<div style="border: 1px solid black">
    <table>
        <tbody>
        <tr>
            <td>User Name: </td>
            <td><b><?= $account['user_name']; ?></b></td>
        </tr>
        <tr>
            <td>Tariff Plan: </td>
            <td><b><?= $account['name']; ?></b></td>
        </tr>
        <tr>
            <td>Account Type: </td>
            <td><b><?= $account['account_type']; ?></b></td>
        </tr>
        <tr>
            <td>Voice Mail: </td>
            <td><b><?php if($account['is_voice_mail_enabled'] == 1) { ?>Enabled<?php } else { ?>Disabled<?php } ?></b></td>
        </tr>
        <tr>
            <td>Comments: </td>
            <td><b><?= $account['comments']; ?></b></td>
        </tr>
        <tr>
            <td>New Phone Number: </td>
            <td><b><?= $account['phone_number']; ?></b></td>
        </tr>
        <tr>
            <td>Sim Card Number: </td>
            <td><b><?= $account['sim_card_number']; ?></b></td>
        </tr>
        </tbody>
    </table>
</div>
<h3  class="card-label">Signature:</h3>