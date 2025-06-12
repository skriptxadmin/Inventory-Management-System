<?php
$router = service('router');
$options = $router->getMatchedRouteOptions();
$bodyClass = $options['bodyClass'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php echo $this->include('includes/styles')?>
    <?php echo $this->renderSection('styles')?>

</head>

<body class="layout-2 <?= esc($bodyClass) ?>">
    <div class="d-flex justify-content-start align-items-start flex-row">
        <?php echo $this->include('includes/aside')?>

        <main class="flex-grow-1">

            <?php echo $this->include('includes/header')?>

            <article class="p-2">
                <?php echo $this->renderSection('content')?>
            </article>


        </main>


    </div>

    <?php echo $this->include('includes/scripts')?>

    <?php echo $this->renderSection('scripts')?>

</body>

</html>