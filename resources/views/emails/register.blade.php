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
    <h2>Dear {{ $name }}!</h2>
    <p>
      Welcome to Stack Developers E-Commerce! Your Account has been successfully created!<br>Now you can login and buy products.
    </p>
    <p>
      Your User Account Details are as below:
    </p>
    <table>
      <tr>
        <th style="text-align: left;">Name: </th>
        <td> {{ $name }}</td>
      </tr>
      <tr>
        <th style="text-align: left;">Mobile: </th>
        <td> {{ $mobile }}</td>
      </tr>
      <tr>
        <th style="text-align: left;">Email: </th>
        <td> {{ $email }}</td>
      </tr>
      <tr>
        <th style="text-align: left;">Password: </th>
        <td> ****** (as chosen by you)</td>
      </tr>
    </table>
    <p>Thanks & Regards!</p>
    <h4 style="text-align: center;">E-commerce Ukraine Sector</h4>
  </div>
</body>
</html>