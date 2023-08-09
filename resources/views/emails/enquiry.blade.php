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
    <h2>Dear Admin!</h2>
    <p>
      User Enquiry from E-commerce Website.
    </p>
    <p>
      Details are as below:
    </p>
    <table>
      <tr>
        <th style="text-align: left;">Name: </th>
        <td> {{ $name }}</td>
      </tr>
      <tr>
        <th style="text-align: left;">Email: </th>
        <td> {{ $email }}</td>
      </tr>
      <tr>
        <th style="text-align: left;">Subject: </th>
        <td> {{ $subject }}</td>
      </tr>
      <tr>
        <th style="text-align: left;">Message: </th>
        <td> {{ $comment }}</td>
      </tr>
    </table>
    <p>Thanks & Regards!</p>
    <h4>E-commerce Ukrainian Sector</h4>
  </div>
</body>
</html>