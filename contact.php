<?php

    $old_name = "";
    $old_email = "";
    $old_phone = "";
    $old_subject = "";
    $old_message = "";

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // validation
        $validationMsg = [
            "message" => [],
            "class" => null,
        ];
        $validationError = false;

        // validation name
        if (empty($name)) {
            $msg = "نام خالی هست";
            array_push($validationMsg['message'],$msg);
        } elseif (strlen($name) < 3) {
            $msg = "طول نام حداقل باید 3 باشد";
            array_push($validationMsg['message'],$msg);
        }

        // validation email
        function validate_email($email)
        {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        if (empty($email)) {
            $msg = "ایمیل خالی هست";
            array_push($validationMsg['message'],$msg);
        } elseif (!validate_email($email)) {
            $msg = "فرمت ایمیل اشتباه است.";
            array_push($validationMsg['message'],$msg);
        }


        // validation phone
        function validate_mobile($mobile)
        {
            return preg_match('/^0[0-9]{10}+$/', $mobile);
        }

        if (empty($phone)) {
            $msg = "تلفن تماس خالی هست.";
            array_push($validationMsg['message'],$msg);
        } elseif (!validate_mobile($phone)) {
            $msg = "تلفن تماس باید 11 رقم باشد و با صفر شروع شود.";
            array_push($validationMsg['message'],$msg);
        }


        if (count($validationMsg['message']) > 0) {
            $validationMsg['class'] .= 'alert alert-danger';
            $validationError = true;
        }

        if (!$validationError) {
            $pdo = require_once "config/database.php";

            try {
                $sql = "insert into contact (name, email, phone, subject, message) values (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $email, $phone, $subject, $message]);

                if ($stmt) {
                    $msg = 'پیام با موفقیت ارسال شد';
                    array_push($validationMsg['message'],$msg);
                    $validationMsg['class'] = 'alert alert-success';
                }
            } catch (Exception $e) {
                $msg = 'Caught exception: ' . $e->getMessage();
                array_push($validationMsg['message'],$msg);
                $validationMsg['class'] = 'alert alert-danger';
            }
        } else {
            $old_name = $name;
            $old_email = $email;
            $old_phone = $phone;
            $old_subject = $subject;
            $old_message = $message;
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
    <div class="container w-50">
        <h2>تماس با ما</h2>

        <form id="shorten" method="post">
            <input type="text" class="form-control" name="name" id="endpointLink" value="<?php echo $old_name ?>" placeholder="نام">
            <input type="text" class="form-control" name="email" id="endpointLink" value="<?php echo $old_email ?>" placeholder="ایمیل">
            <input type="phone" class="form-control" name="phone" id="endpointLink" value="<?php echo $old_phone ?>" placeholder="تلفن تماس">
            <input type="subject" class="form-control" name="subject" id="endpointLink" value="<?php echo $old_subject ?>" placeholder="موضوع پیام">
            <textarea name="message" class="form-control" id="endpointLink" rows="4"><?php echo $old_message ?></textarea>
            <br>
            <button type="submit" name="submit" id="shorten-button">ارسال</button>
        </form>
        <div>
            <br>

            <?php if (isset($_POST['submit'])) { ?>
                <?php foreach ($validationMsg['message'] as $message) { ?>
                    <p class="<?php echo $validationMsg['class'] ?>" ><?php echo $message ?></p>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

<footer>
    <a href="index.php">بازگشت</a>
</footer>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>