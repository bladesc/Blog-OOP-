<!doctype html>

<html lang="pl">
<head>
    <meta charset="utf-8">

    <title>Simple Blog OOP</title>
    <meta name="description" content="This is blog based on php objected model.">
    <meta name="author" content="Damian Szczęsny">

    <link rel="stylesheet" href="<?= str_replace("\\","/",dirname( __DIR__))?>/assets/css/style.css">

</head>
<body>
<div id="box-page">
    <?= dirname( __DIR__) ?>
    <pre>
        <?PHP print_r($_SERVER); ?>
    </pre>
