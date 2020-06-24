<?php


    $reids = new Redis();

     $reids->connect('127.0.0.1',6379);

     $k1 = 'name';

     echo $reids->get($k1);