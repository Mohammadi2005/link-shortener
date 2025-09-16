<?php

    $isCreatedLink = false;
    if (isset($_POST['shortener'])) {
    try {
        $pdo = require_once "./config/database.php";

        $customLink = $_POST['customLink'];
        $endpointLink = $_POST['endpointLink'];
        $typeLink = $_POST['type'];

        $select = "SELECT * FROM links WHERE custom_link = :customLink";
        $hasRow = $pdo->prepare($select);
        $hasRow->bindParam(':customLink', $customLink);
        $hasRow->execute();
        $isCreatedLink = true;
        if (!$hasRow->rowCount() and $typeLink == '0') {
            $sql = "INSERT INTO links (custom_link, endpoint_link) VALUES (:customLink, :endpointLink)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':customLink', $customLink);
            $stmt->bindParam(':endpointLink', $endpointLink);
            $stmt->execute();
            echo '<p class="alert alert-success">created successfully : <a href="'.$endpointLink.'">'. $customLink .'</a></p>';
        }else if (!$hasRow->rowCount() and $typeLink == '1') {
            header("location: $endpointLink");
        }else {
            echo '<p class="alert alert-danger">created already link</p>';
        }

    } catch (Exception $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

    if (isset($_POST['payment'])) {
        $vip = $_POST['vip'];
        $price = 0;
        switch ($vip) {
            case '7':  $price = 20000;  break;
            case '30': $price = 60000;  break;
            case '365': $price = 600000; break;
        }

        if ($price > 0) {
            $curl = curl_init();

            $data = [
                "merchant"    => "zibal",
                "amount"      => $price,
                "callbackUrl" => "https://yourwebsite.com/payment/callback.php"
            ];

            curl_setopt_array($curl, [
                CURLOPT_URL            => 'https://gateway.zibal.ir/v1/request',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => json_encode($data),
                CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                echo 'Curl error: ' . curl_error($curl);
            } else {
                $result = json_decode($response, true);
                if (isset($result['trackId'])) {
                    header("Location: https://gateway.zibal.ir/start/" . $result['trackId']);
                    exit;
                } else {
                    echo "Error: " . $result['message'];
                }
            }

            curl_close($curl);
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
<body>
    <div class="container w-50">
        <?php if(!$isCreatedLink){?>
            <h2>لینک کوتاه کننده</h2>

            <form id="shorten" method="post">
                <input type="url" class="form-control" name="endpointLink" style="text-align: right" id="endpointLink" placeholder="لینک خود را وارد کنید" required>
                <input type="url" class="form-control" name="customLink" value="http://localhost/link?url=" id="customLink" required>
                <select name="type" class="form-select text-start" id="typeLink">
                    <option value="1">مستقیم</option>
                    <option value="0">غیر مستقیم</option>
                </select>
                <button type="submit" name="shortener" id="shorten-button" onclick="shortenLink()">کوتاه کن</button>
            </form>
        <?php } else {?>
            <div>
                <img src="https://biz-cdn.varzesh3.com/banners/2025/09/06/B/sq0inioq.gif">
                <img src="https://biz-cdn.varzesh3.com/banners/2025/08/30/C/old3qoas.gif">
            </div>
        <?php } ?>
        <br>
        <hr>

        <!--   payment gateway   -->
        <div id="shorten-result">
            <form id="shorten" method="post">
                <label for="vip7">خرید اشتراک 7 روزه (20,000):</label>
                <input  type="radio" id="vip7" name="vip" value="7">
                <br>
                <br>
                <label for="vip30">خرید اشتراک 30 روزه (60,000):</label>
                <input type="radio" id="vip30" name="vip" value="30">
                <br>
                <br>
                <label for="vip1">خرید اشتراک 1 ساله (600,000):</label>
                <input type="radio" id="vip1" name="vip" value="365">
                <br><br>
                <button type="submit" name="payment" id="shorten-button-shop">خرید</button>
            </form>
        </div>
        <br>
        <hr>
<!--        <br>-->
        <footer>
            <a href="contact.php">تماس با ما</a>
        </footer>
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>