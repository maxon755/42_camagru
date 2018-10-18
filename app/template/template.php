<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,900" rel="stylesheet">

    <title>Camagru</title>

    <link rel="stylesheet" href="/template/template.css">
    <?php if ($useComponents): ?>
        <?php foreach(self::$components as $component): ?>
            <link rel="stylesheet" href="<?php echo $component['stylePath']; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo $renderUnit['style']; ?>">

</head>
<body>

<?php
    if ($useComponents)
        include(self::$components['header']['path']);
    include($renderUnit['markUp']);

?>

    <script src="<?php echo $renderUnit['script'] ?>"></script>
</body>
</html>
