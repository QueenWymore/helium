<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php $this->import('title'); ?></title>
    <?php $this->style('app'); ?>
    <?php $this->import('style'); ?>
</head>
<body>
APP INDEX

<?php $this->renderContent(); ?>

</body>
</html>