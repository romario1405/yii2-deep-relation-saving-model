<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */
/**
 * @var $title        string
 * @var $headers      string
 * @var $items        string
 * @var $repeaterName string
 */

$title = isset($title) ? $title : '';
?>

<?= $title; ?>
<div class="header-block">
    <?= $headers; ?>
</div>
<div class="clearfix"></div>
<div data-repeater-list="<?= $repeaterName; ?>" class="repeater-box">
    <?= $items; ?>
</div>
<a data-repeater-create class="btn btn-success">Add</a>