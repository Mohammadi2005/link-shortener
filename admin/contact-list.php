<?php
    $pdo = require_once "../config/database.php";

    $showMessage = true;
    $message = "";

    $sql = "select * from contact";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (isset($_GET['messageId'])) {
        $showMessage = false;
        $sql = "select * from contact where ID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $_GET['messageId']]);
        $result = $stmt->fetch(PDO::FETCH_UNIQUE);
        $message = $result['message'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>تماس ها</title>
    <style>
        *{
            direction: rtl;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($showMessage) { ?>
            <table class="table mt-3">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">نام</th>
                    <th scope="col">ایمیل</th>
                    <th scope="col">تلفن تماس</th>
                    <th scope="col">پیام</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $key => $value) { ?>
                    <tr>
                        <th scope="row"> <?php echo ++$key ?> </th>
                        <td> <?php echo $value->name ?></td>
                        <td> <?php echo $value->email?></td>
                        <td> <?php echo $value->subject ?></td>
                        <td>
                            <a class="btn btn-primary" href="./contact-list.php?messageId=<?php echo $value->ID ?>" >نمایش</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class=""><?php echo $message ?></p>
            <hr>
            <a class="btn btn-danger" href="contact-list.php" >بازگشت</a>
        <?php } ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>