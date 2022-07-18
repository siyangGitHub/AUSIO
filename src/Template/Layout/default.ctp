<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= "Vape Online" ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?php echo $this->Html->meta('favicon.ico','webroot/img/vapeIcon.png',array('type' => 'icon')); ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<nav class="top-bar expanded" data-topbar role="navigation">
    <ul class="title-area large-3 medium-4 columns">
        <li class="name">
            <h1><a href="<?php echo $this->Url->build([
                    "controller" => "vape-flavors",
                    "action" => "index",
                ]); ?>">Vape Online</a></h1>
        </li>
    </ul>
    <?php if($this->Session->read('Auth.User')&&$this->Session->read('Auth.User.user_role')==0){ ?>
        <div class="large-2 medium-2 columns" style="border-left: 2px solid gold">
            <?= $this->Html->link(__('Orders'), ['controller' => 'orders', 'action' => 'index'], ['style' => 'color: white;']) ?>
            <?php if($incompleteOrders!=0){ ?>
                <span style="color: red; font-weight: bold;">(<?php echo $incompleteOrders; ?>)</span>
            <?php } ?>
        </div>
        <div class="large-2 medium-2 columns" style="border-left: 2px solid gold">
            <?= $this->Html->link(__('Stock Records'), ['controller' => 'stockRecord', 'action' => 'index'], ['style' => 'color: white;']) ?>
        </div>
        <div class="large-2 medium-2 columns" style="border-left: 2px solid gold">
            <?= $this->Html->link(__('Vape Flavors'), ['controller' => 'vapeFlavors', 'action' => 'index'], ['style' => 'color: white;']) ?>
        </div>
        <div class="large-2 medium-2 columns" style="border-left: 2px solid gold">
            <?= $this->Html->link(__('Users'), ['controller' => 'users', 'action' => 'index'], ['style' => 'color: white;']) ?>
            <?php if($notActivatedUsers!=0){ ?>
            <span style="color: red; font-weight: bold;">(<?php echo $notActivatedUsers; ?>)</span>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="top-bar-section">
        <ul class="right">
            <li><a href='<?php echo $this->Url->build([
                    "controller" => "Users",
                    "action" => "logout",
                ]); ?>'>Log out</a></li>
        </ul>
    </div>
</nav>
<?= $this->Flash->render() ?>
<div class="container clearfix">
    <?= $this->fetch('content') ?>
</div>
<footer>
</footer>
</body>
</html>
