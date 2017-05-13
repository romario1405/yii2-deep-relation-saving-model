<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 *
 * @var $images array
 */

use sonrac\relations\widgets\helpers\FileHelper;

?>

<?php $count = 1; ?>
<?php foreach ($images as $image): ?>
    <div class="fileDiv col-xs-6 col-md-3"
         onclick="showEditBar('<?= $url; ?><?= FileHelper::getName($image); ?>','<?= FileHelper::getHeight($image); ?>','<?= $count; ?>');"
         ondblclick="showImage('<?php echo $url; ?><?= FileHelper::getName($image); ?>','<?= File::getHeight($image); ?>');"
         data-imgid="<?php echo $count; ?>">
        <div class="imgDiv">
            <img class="fileImg lazy" data-original="<?php echo $url; ?><?= FileHelper::getName($image); ?>">
        </div>
        <p class="fileDescription">
            <span class="fileMime"><?= FileHelper::getName($image); ?>
        </p>
        <p class="fileTime"><?= FileHelper::getCreatedDate($image) ?></p>
        <p class="fileTime"><?= FileHelper::getSize($image); ?></p>
    </div>
    <?php $count++; ?>
<?php endforeach; ?>