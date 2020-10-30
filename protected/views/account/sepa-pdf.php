<h3 class="card-label">Bank Details</h3>
<div style="border: 1px solid black">
    <table>
        <tbody>
        <tr>
            <td>Bank Name: </td>
            <td><b><?= $model->bank_name; ?></b></td>
        </tr>
        <tr>
            <td>Bank Address: </td>
            <td><b><?= $model->bank_building_num . ', '; ?>
                    <?= $model->bank_street . ', ' . $model->bank_city . ', '; ?>
                    <?= $model->bank_country . '-' . $model->bank_postcode; ?></b>
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
        </tbody>
    </table>
</div>
<br>
<table>
    <tbody>
    <tr>
        <td>Authorized Person:</td>
        <td><b><?= $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name; ?></b></td>
    </tr>
    <tr>
        <td>Place:</td>
        <td><b><?= $model->city; ?></b></td>
    </tr>
    <tr>
        <td>Date:</td>
        <td><?= date('d M, Y', strtotime($model->created_at)); ?></td>
    </tr>
    </tbody>
</table>
<h3  class="card-label">Signature:</h3>