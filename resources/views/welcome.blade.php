<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Backend API | FE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .bgMinsal {
            background-color: #2f3032;
        }

        .doc-container {
            width: 100%;
            position: absolute;
            height: 100%;
        }

        .doc-button {
            padding-left: 1rem;
            padding-right: 1rem;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            font-weight: 700;
            border-radius: 0.25rem;
            border-color: #fff;
            background-color: #fff;
            color: #5a5a55;
            font-size: 18px;
            border: 1px solid #fff;
            cursor: pointer;
            -webkit-transition: all .35s ease-in-out;
            -moz-transition: all .35s ease-in-out;
            -ms-transition: all .35s ease-in-out;
            -o-transition: all .35s ease-in-out;
            transition: all .35s ease-in-out;
        }

        .doc-line {
            border: 0;
            height: 1px;
            background: #ccc;
            background-image: linear-gradient(to right, #333, #ccc, #333);
        }

        .doc-title {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 200;
            font-size: 22px;
        }
    </style>
</head>

<body class="bgMinsal">
    <div class="d-flex align-items-center justify-content-center flex-column doc-container">
        <div class="d-flex jutify-content-center w-25">
            <img src="./icons/gobierno.png"
                alt="MINSAL" class="img-responsive" style="
    width: 100%;">
        </div>
        <hr class="w-50 doc-line">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <p class="text-white doc-title">Backend de franquicias presidenciales</p>
            <a href="/docs">
                <button class="btn doc-button">
                    Documentación
                </button>
            </a>
        </div>
</body>

</html>
