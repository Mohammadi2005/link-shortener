<?php
    $pdo = require_once "config/database.php";

    // save image
    if(isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $name_saved = time() . "-" . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $name_saved;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<p class='alert alert-danger'>" . "Sorry, your file was not uploaded." . "</p>";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<p class='alert alert-success'>" . "فایل شما با نام : " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . "با موفقیت اپلود شد." . "</p>";

            try {
                $sql = "insert into files (name, create_time) values (?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name_saved, time()]);

            } catch (Exception $e) {
                echo '<p class="alert alert-danger">Caught exception: ' . $e->getMessage() . '</p>';
            }

        } else {
            echo "<p class='alert alert-danger'>" . "Sorry, there was an error uploading your file." . "</p>";
        }
    }
}

    // delete image
    if (isset($_GET["deleteId"])) {
        $queryDelete = "delete from files where ID = ?";
        $stmtDelete = $pdo->prepare($queryDelete);
        $stmtDelete->execute([$_GET["deleteId"]]);
    }

    // get all 
    $query = "select * from files";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>اپلود فایل</title>
    <style>
        *{
            text-align: center;
            direction: rtl;
        },
        input[type="file"] {
            border: 1px solid #e5e5e5;
        }

        input[type=file]::file-selector-button {
            border: 1px solid #e5e5e5;
            background-color: #fff;
            color: #000;
            border: 0px;
            border-right: 1px solid #e5e5e5;
            padding: 10px 15px;
            margin-right: 20px;
            transition: .5s;
        }

        input[type=file]::file-selector-button:hover {
            border: 1px solid #e5e5e5;
            background-color: #eee;
            border: 0px;
            border-right: 1px solid #e5e5e5;
        }
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
    </style>
</head>

<html>
<body>
    <div class="container">
        <form action="upload.php" method="post" class="mt-5" enctype="multipart/form-data">
            انتخاب تصویر :
            <span class="btn btn-primary btn-file m-3">
    انتخاب ...<input type="file" name="fileToUpload" id="fileToUpload">
    </span>
            <input type="submit" value="اپلود تصویر" class="btn btn-success" name="submit">
        </form>

        <table class="table mt-3">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">نام</th>
                <th scope="col">تصویر</th>
                <th scope="col">عملیات</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $item) { ?>
                <tr>
                    <th scope="row"> <?php echo $item["id"] ?> </th>
                    <td> <?php echo $item['name'] ?></td>
                    <td>
                        <img style="width: 40px; height: 40px " src="./uploads/<?php echo $item['name'] ?>">
                    </td>
                    <td>
                        <a class="btn btn-primary" href="./uploads/<?php echo $item['name'] ?>" >نمایش</a>
                        <a class="btn btn-danger" href="./upload.php?deleteId=<?php echo $item['id'] ?>" >حذف</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>

