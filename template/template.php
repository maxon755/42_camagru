<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru</title>

    <?php foreach(self::$components as $component): ?>
        <link rel="stylesheet" href="<?php echo $component['stylePath']; ?>">
        <link rel="stylesheet" href="<?php echo $renderUnit['style']; ?>">
    <?php endforeach; ?>

</head>
<body>

<?php
    include(self::$components['header']['path']);

    include($renderUnit['markUp']);
?>

</body>
</html>
