<?php
foreach ($this->data as $data){ ?>
<li>
    <div class="list-timeline-time"><?php echo $this->dateArray[$data['id']]; ?></div>
    <i class="fa fa-facebook list-timeline-icon bg-default"></i>
    <div class="list-timeline-content">
        <p class="font-w600"><?php echo $data['title']; ?></p>
        <p class="font-s13"><?php echo $data['description']; ?></p>
    </div>
</li>
<?php
}
?>

