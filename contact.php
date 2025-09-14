<?php
    if(isset($_POST['send'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $pdo = require_once "config/database.php";

        try {
            $sql = "insert into contact (name, email, phone, subject, message) values (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $email, $phone, $subject, $message]);

            if ($stmt) {
                echo '<p class="alert alert-success text-center">پیام با موفقیت ارسال شد</p>';
            }
        } catch (Exception $e) {
            echo '<p class="alert alert-danger">Caught exception: ' . $e->getMessage() . '</p>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>لینک کوتاه کننده</title>
    <style>
        *{
            font-family: DanaFaNum !important;
            text-align: center;
        }
        body {
            font-family: Arial, sans-serif;
            /*text-align: center;*/
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
            text-align: right;
        }

        #shorten-button {
            background-color: #4CAF50;
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
<body>
<h2>تماس با ما</h2>

    <form id="shorten" method="post">
        <input type="text" class="form-control" name="name" id="endpointLink" placeholder="نام" required>
        <input type="email" class="form-control" name="email" id="endpointLink" placeholder="ایمیل" required>
        <input type="phone" class="form-control" name="phone" id="endpointLink" placeholder="تلفن تماس">
        <input type="subject" class="form-control" name="subject" id="endpointLink" placeholder="موضوع پیام" required>
        <textarea name="message" class="form-control" id="endpointLink" required rows="4"></textarea>
        <br>
        <button type="submit" name="send" id="shorten-button">ارسال</button>
    </form>
<div id="shorten-result"></div>

<footer>
    <a href="index.php">بازگشت</a>
</footer>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>