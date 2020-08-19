<?php
$this->pageTitle = 'Test Cases';
?>
<div class="block">
    <h3 class="block-title">Back-Office Test Cases</h3>
    <div class="block-content">
        <table id="demo-foo-row-toggler" class="table toggle-circle table-hover">
            <thead>
            <tr>
                <th>Test Case Name</th>
                <th>Status</th>
                <th data-hide="all"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($testCases as $case) { ?>
                <tr>
                    <td>
                        <span class="test-case-row <?php if($case['status']) { ?> text-success <?php } else { ?> text-danger <?php } ?>">
                            <?= $case['name']; ?>
                        </span>
                        <p class="text-muted"><?= $case['description']; ?></p>
                    </td>
                    <td>
                        <?php if($case['status']) { ?>
                            <span class='label label-success test-case-row'>Passed</span>
                        <?php } else { ?>
                            <span class='label label-danger test-case-row'>Failed</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?= $case['details']; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $('#demo-foo-row-toggler').footable();
    jQuery('.js-table-sections').each(function () {
        var $table = jQuery(this);

        // When a row is clicked in tbody.js-table-sections-header
        jQuery('.js-table-sections-header > tr', $table).on('click', function (e) {
            var $row = jQuery(this);
            var $tbody = $row.parent('tbody');

            if (!$tbody.hasClass('open')) {
                jQuery('tbody', $table).removeClass('open');
            }

            $tbody.toggleClass('open');
        });
    });
</script>