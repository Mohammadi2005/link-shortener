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

<form action="upload.php" method="post" class="mt-5" enctype="multipart/form-data">
    انتخاب تصویر :
    <span class="btn btn-primary btn-file m-3">
    انتخاب ...<input type="file">
    </span>
  <input type="submit" value="اپلود تصویر" class="btn btn-success" name="submit">
</form>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>

