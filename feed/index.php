<?php
require_once 'FeedWriter.php';
require_once '../Spyc.php';
require_once '../functions.php';
require_once '../config.php';

$TestFeed = new FeedWriter(RSS2);
$TestFeed->setTitle('Ping! Very Private Sonar Feed.');
$TestFeed->setImage('Ping!', $address, $address . '/images/ping.png');
$TestFeed->setLink('http://'.$_SERVER['HTTP_HOST'].'/'.get_subdir($_SERVER[PHP_SELF],"").'/');
$TestFeed->setChannelElement('updated', date(DATE_RSS , time()));
$TestFeed->setChannelElement('author', array('name'=>$your_name));

$items = Spyc::YAMLLoad('../urls.yaml');
foreach ($items as $item)
{
  $newItem = $TestFeed->createNewItem();
  $newItem->setTitle($item['title']);
  $newItem->setLink($item['link']);
  $newItem->setDate($item['date']);
  $newItem->setDescription($item['description']);
  $newItem->setEncloser($item['enc_link'], $item['enc_length'], 'audio/mpeg');

  $TestFeed->addItem($newItem);
}

$TestFeed->genarateFeed();
