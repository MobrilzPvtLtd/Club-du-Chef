<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Oswald:700|Source+Sans+Pro:300,400,600,700&display=swap"
        rel="stylesheet">
    <link rel="preload" as="font" href="css/icon.woff2" type="font/woff2" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--== CSS FILES ==-->
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Thank You</title>
    <style>
        /* Popup Styling */
        body {
            background-image: url(images/3261288129ex2.jpg);
            padding: 0 0 255px;
            margin-bottom: 50px;
            background-size: cover;
            background-position: center;
        }

        body:before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background:rgba(20, 20, 20, 0.83);
        }

        .thank-you-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #F4F4F4;
            padding: 50px;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 400px;
            text-align: center;
            border-radius: 10px;
        }

        .thank-you-container h1 {
            color: rgb(243, 147, 22);
        }
        .thank-you-container p {
            color: #555;
        }
        .btn {
            background-color: rgb(243, 147, 22); 
            color:white;
            padding: 8px;
            width: 60%;
            border-radius: 50px;
            border: none;
            font-weight: 600;
        }
        .btn:hover {
            background-color:rgb(247, 134, 4);
            color: white;
        }
        p {
            color: #5c5b59;
        }
    </style>
</head>
<body>

<div class="thank-you-container">
    <h1>Thank You!</h1>
    <p>Thank you for booking. <br> We will get back to you very soon.</p>
    <button onclick="history.back()" class="btn">Back to Home</button>
</div>

</body>
</html>
