<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <div>
    <h2>Dear {{ $userDetails['name'] }}!</h2>
    <p>
      Your return request for Order # {{ $returnDetails['order_id'] }} with E-commerce Website status: {{ $return_status }}
    </p>
    <p>Thanks & Regards!</p>
    <h4>E-commerce Ukrainian Sector</h4>
  </div>
</body>
</html>