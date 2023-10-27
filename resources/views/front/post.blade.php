<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <meta property="og:title" content="{{ $data['title'] }}">
  <meta property="og:description" content="{{ $data['description'] }}">
  <meta property="og:image" content="{{ $data['image'] }}">

  <title>{{ $data['title'] }} - {{ env('APP_NAME') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/share.js') }}"></script>
  <style>
    #social-links ul li {
      display: inline-block;
    }

    #social-links ul li a {
      padding: 20px;
      margin: 2px;
      font-size: 30px;
      color: rgb(46, 41, 114);
      background-color: #ccc;
    }

    #social-links ul li a:hover {
      padding: 20px;
      margin: 2px;
      font-size: 30px;
      color: white;
      background-color: rgb(46, 41, 114);
    }
  </style>
</head>
<body>
  <div class="container mt-1 text-center">
    <h1 class="text-danger">
      Social Share Buttons in Laravel
    </h1>
    <hr>
    <h3>{{ $data['title'] }}</h3>
    <img src="{{ asset('images/front_images/ico/'.$data['image']) }}" width="200" alt="">
    <p class="my-5">{{ $data['description'] }}</p>
    {!! $shareButtons !!}
  </div>
</body>
</html>