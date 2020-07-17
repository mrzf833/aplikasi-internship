<?php
return [
  "driver" => "smtp",
  "host" => "smtp.mailtrap.io",
  "port" => 2525,
  "from" => array(
      "address" => "from@example.com",
      "name" => "Example"
  ),
  "username" => "blablabla" , //username mailtrap
  "password" => "blablabla", //password mailtrap
  "sendmail" => "/usr/sbin/sendmail -bs"
];