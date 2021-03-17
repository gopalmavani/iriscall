<h3 class="card-label">Bankgegevens</h3>
<div style="border: 1px solid black">
    <table>
        <tbody>
        <tr>
            <td>Banknaam:</td>
            <td><b><?= $model->bank_name; ?></b></td>
        </tr>
        <tr>
            <td>Bank adres: </td>
            <td><b><?= $model->bank_building_num . ', '; ?>
                    <?= $model->bank_street . ', ' . $model->bank_city . ', '; ?>
                    <?= $model->bank_country . '-' . $model->bank_postcode; ?></b>
            </td>
        </tr>
        <tr>
            <td>Telefoonnummer: </td>
            <td><b><?= $model->phone; ?></b></td>
        </tr>
        <tr>
            <td>Accountnaam: </td>
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
        </tbody>
    </table>
</div>
<br>
<table>
    <tbody>
    <tr>
        <td>Geautoriseerd persoon:</td>
        <td><b><?= $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name; ?></b></td>
    </tr>
    <tr>
        <td>Plaats:</td>
        <td><b><?= $model->city; ?></b></td>
    </tr>
    <tr>
        <td>Datum:</td>
        <td><?= date('d M, Y', strtotime($model->created_at)); ?></td>
    </tr>
    </tbody>
</table>
<h3  class="card-label">Handtekening:</h3>