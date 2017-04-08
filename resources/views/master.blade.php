{{--
  Created by PhpStorm.
  User: Miracle
  Date: 2017/4/5
  Time: 16:55
 --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="css/weui.css" type="text/css">
    <link rel="stylesheet" href="css/book.css" type="text/css">
</head>
<body>
    <div class="page">
        @yield('content')
    </div>
    <!-- tooltips -->
    <div class="bk_toptips"><span></span></div>
</body>
<script src="js/jquery-1.11.2.min.js"></script>
@yield('my-js')
</html>