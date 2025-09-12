<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لینک کوتاه کننده</title>
    <style>
        *{
            font-family: DanaFaNum !important;
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;        }

        #shorten-form {
            max-width: 400px;
            margin: auto;
        }

        #shorten-input {
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
<h2>لینک کوتاه کننده</h2>

<form id="shorten-form">
    <input type="url" style="text-align: right" id="shorten-input" placeholder="لینک خود را وارد کنید" required>
    <button type="button" id="shorten-button" onclick="shortenLink()">کوتاه کن</button>
</form>

<div id="shorten-result"></div>

</body>
</html>