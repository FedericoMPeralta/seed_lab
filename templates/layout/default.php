<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        SEED LAB - INASE
        <?= $this->fetch('title') ?>
    </title>

    <?= $this->Html->css(['custom', 'home', 'reporte', 'datepicker', 'variables']) ?>
</head>
<body>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>

    <?= $this->Html->script(['datepicker', 'clickable-row', 'autocomplete']) ?>
    <?= $this->fetch('script') ?>
</body>
</html>
