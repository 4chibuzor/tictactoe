<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .content {
            width: 60vw;
            margin: 5em auto;
            padding: 1em;
            border: 1px solid black;
            display: flex;
            justify-content: center;
        }

        .message {
            text-align: center;
            padding: 0.5em;
            font-size: 24px;
            max-width: 60vw;
            margin: 0.5em auto;
            color: steelblue;
        }


        td>[type="submit"],
        td>div {
            width: 100%;
            height: 100%;
            padding: 0.5em;
            text-align: center;
            vertical-align: center;
            font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
            font-size: 70px;
            cursor: pointer;
        }

        td>[type="submit"]:hover,
        td>div {
            background-color: yellowgreen;
            ;
        }
    </style>
</head>

<body>
    <?= $_SESSION["message"] ?? '' ?>
    <section class="content">
        <form method="post"> <?= $output; ?></form>
    </section>
</body>

</html>