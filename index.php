<?php

require_once 'config.php';
require 'functions.php';

if (isset($_GET['add']))
{
  $url = urldecode($_GET['url']);

  // Search for m4a or mp3 file
  if (find_audio_file($url) == '') {
    die(display_message(false,2,'',$url));
  }
  
  $resolved_media_url = resolve_url($url);

  if (check_for_duplicates($resolved_media_url)) {
	  die(display_message(false,3,'',$url)); 
  }

  $title = normalize_str(get_page_html($url)->find('head title', 0)->innertext);


  // If any text is selected on the page, it will be used as the description
  $description = $title . '<br /><br />' . urldecode($_GET['description']);

  // If not, the description will contain the originating page and a link back.
  $description .= '<br /><br />Originally posted: <a href="' . $url . '">' . $url . '</a><br/><br/>Added by <a href="http://jeredb.com/">Jered\'s</a> awesome Ping service.<br/><br/>MP3 Source: <a href="' . $resolved_media_url . '">' . $resolved_media_url . '</a>';

  $description = normalize_str($description);
  $enclosure = htmlspecialchars($resolved_media_url);

  write_url($url, $title, $enclosure, $description);

  die(display_message(true, 1, $title, $url));
}

if (isset($_GET['post']))
{

  $url = urldecode($_GET['url']);
  $title = urldecode($_GET['title']);
  $description = $title . '<br /><br />' . urldecode($_GET['description']);
  $enclosure = urldecode($_GET['enclosure']);
  
  $description .= '<br/><br/>Originally posted: <a href="' . $url . '">' . $url . '</a><br/><br/>Added by <a href="http://jeredb.com/">Jered\'s</a> awesome Ping service.<br/><br/>MP3 Source: <a href="' . $resolved_media_url . '">' . $resolved_media_url . '</a>';

  write_url($url, normalize_str($title), htmlspecialchars($enclosure), normalize_str($description));

  die(display_message(true, 1, $title, $url));
  
}

$bookmarklet = "javascript:location.href='" . $address . "index.php?add&url='+encodeURIComponent(location.href)+'&description='+encodeURIComponent(window.getSelection?window.getSelection():(document.getSelection?document.getSelection():(document.selection?document.selection.createRange().text:'')));";

$manual_bookmarklet = "javascript:location.href='" . $address . "/post/index.php?add&title='+encodeURIComponent(window.document.title)+'&url='+encodeURIComponent(location.href)+'&description='+encodeURIComponent(window.getSelection?window.getSelection():(document.getSelection?document.getSelection():(document.selection?document.selection.createRange().text:'')));";



?>

<!DOCTYPE html>
<html>
  <head>
    <title>Ping! A Private Sonar Feed.</title>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <h1>Ping! <small>A Very Private Podcast Feed.</small></h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
		    <p class="lead">Ping! is a Very Private Podcast Feed and lets you add M4A or MP3 files from a web site to a feed for listening later. You can keep it private and subscribe to it in your favorite podcast app.</p>
        <p>Drag the <a class="badge" href="<?php echo $bookmarklet ?>">Ping</a> bookmarklet to your favorites.</p>
        <p>Drag the <a class="badge" href="<?php echo $manual_bookmarklet ?>">Manual Ping</a> bookmarklet to your favorites to add a stubborn podcast.</p>
      </div>
    </div>
    <div class="row">
		  <div class="col-md-4 col-md-offset-4">
	      <p>On a mobile device? Use this code for the bookmarklet.</p>
          <div class="form-group">
            <textarea class="form-control" rows="6"><?php echo $bookmarklet ?></textarea>
          </div>
    	</div>
    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <p>Subscribe:
          <ul class="list-unstyled">
            <?php $feed_url = '://' . $server . '/' . $folder . '/feed/'; ?>
            <li><a href="http<?php echo $feed_url; ?>"><span class="glyphicon glyphicon-globe"></span> Classic RSS/Atom Reader</a></li>
            <li><a href="itpc<?php echo $feed_url; ?>"><span class="glyphicon glyphicon-volume-up"></span> iTunes</a></li>
            <li><a href="pcast<?php echo $feed_url; ?>"><span class="glyphicon glyphicon-phone"></span> Podcast app</a></li>
          </ul>
        </p>
      </div>
    </div>
  </body>
</html>