<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php echo $this->include('includes/styles')?>
<?php echo $this->renderSection('styles')?>

</head>
<body>
    <?php echo $this->renderSection('content')?>

    <?php echo $this->include('includes/scripts')?>

<?php echo $this->renderSection('scripts')?>

</body>
</html>