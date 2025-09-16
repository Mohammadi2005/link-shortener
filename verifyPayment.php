<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>تائید پرداخت</title>
    <style>
        *{
    font-family: DanaFaNum !important;
        }
        body {
    font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        #shorten-form {
            max-width: 400px;
            margin: auto;
        }

        #customLink , #endpointLink, #typeLink {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        #shorten-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        #shorten-button-shop {
            background-color: #017ccb;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        #shorten-result {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body class="container">

    <?php
    $success = $_GET['success'];
    $status = $_GET['status'];
    $message = "";
    if ($success == 1) {
        ?>
        <p class="alert alert-success">پرداخت شده - تاییدشده</p>

        <?php
    } else {
        switch ($status) {
            case -2:
                $message = "خطای داخلی";
                break;
            case -1:
                $message = "در انتظار پردخت";
                break;
            case 2:
                $message = "پرداخت شده - تاییدنشده";
                break;
            case 3:
                $message = "لغوشده توسط کاربر";
                break;
            case 4:
                $message = "شماره کارت نامعتبر می‌باشد.";
                break;
            case 5:
                $message = "موجودی حساب کافی نمی‌باشد.";
                break;
            case 6:
                $message = "رمز واردشده اشتباه می‌باشد.";
                break;
            case 7:
                $message = "تعداد درخواست‌ها بیش از حد مجاز می‌باشد.";
                break;
            case 8:
                $message = "‌تعداد پرداخت اینترنتی روزانه بیش از حد مجاز می‌باشد";
                break;
            default:
                $message = "پرداخت ناموفق";
        }
        ?>
        <p class="alert alert-danger">تراکنش نا موفق - <?php echo $message ?></p>
    <?php
    }
    ?>
    <a href="index.php" class="btn btn-primary">برگشت به سایت</a>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>
