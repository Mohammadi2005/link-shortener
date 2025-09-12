<?php

$isCreatedLink = false;
//if(isset($_GET['url'])){
//    $isCreatedLink = true;
//}

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

        #shorten-result {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
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

<div id="shorten-result"></div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>