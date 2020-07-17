<?php
return [
  "driver" => "smtp",
  "host" => "smtp.mailtrap.io",
  "port" => 2525,
  "from" => array(
      "address" => "from@example.com",
      "name" => "Example"
  ),
  "username" => "18722003092269" , //username mailtrap
  "password" => "d091354c2149ce", //password mailtrap
  "sendmail" => "/usr/sbin/sendmail -bs"
];