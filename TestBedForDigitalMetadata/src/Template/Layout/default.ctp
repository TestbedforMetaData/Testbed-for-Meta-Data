<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$description = 'Testbed for Digital Metadata';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $description ?>
        <?= $this->fetch('title') ?>
    </title>

    <?= $this->Html->css('main.css') ?>
    <?= $this->Html->script('jquery-1.10.2.min') ?>
    <?= $this->Html->script('mainScript') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header>
        <div class="container">
            <a id="header-title" href="<?= $this->Url->build(["controller" => "Home","action" => "index"]) ?>">Testbed for Digital Metadata</a>
            <?php if($loggedOn){ ?>
            <a class="menu" id="logout" href="<?= $this->Url->build(["controller" => "User","action" => "logout"]) ?>">Log out</a>
            <a class="menu" href="<?= $this->Url->build(["controller" => "Admin","action" => "changePassword"]) ?>">Change Password</a>
            <?php } ?>
        </div>
    </header>
    <div class="container">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
