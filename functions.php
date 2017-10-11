<?php

require_once 'assets/lib/Spyc.php';
require_once 'assets/lib/simple_html_dom.php';

# http://stackoverflow.com/questions/2747508/php-extract-direct-sub-directory-from-path-string
function get_subdir($dir, $sub)
{
  $dir = array_slice(array_diff(explode('/', $dir), explode('/', $sub)), 0, 1);
  return $dir[0];
}

# http://stackoverflow.com/questions/5958725/get-size-of-remote-file-from-url
function remote_filesize($url)
{
  $contentLength = 0;
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

  $data = curl_exec($ch);
  curl_close($ch);

  if (preg_match('/Content-Length: (\d+)/', $data, $matches))
  {
    $contentLength = (int)$matches[1];
  }

  return $contentLength;
}

# https://gist.github.com/1196916
function resolve_url($url)
{
  $headers = get_headers($url);
  $headers = array_reverse($headers);
  foreach($headers as $header)
  {
    if (strpos($header, 'Location: ') === 0)
    {
      $url = str_replace('Location: ', '', $header);
      break;
    }
  }
  
  return $url;
}


function write_url($url, $title, $enclosure, $description) 
{

  $items = Spyc::YAMLLoad('urls.yaml');
  $item = array();

  $item['title'] = normalize_str($title);
  $item['link'] = $url;
  $item['date'] = time();
  $item['description'] = normalize_str($description);
  $item['enc_link'] = $enclosure;
  $item['enc_length'] = remote_filesize($enclosure);

  array_unshift($items, $item);
  file_put_contents('urls.yaml', Spyc::YAMLDump($items));

}

# http://www.phpdevtips.com/2011/08/using-php-to-replace-special-characters-with-their-equivalents/
function normalize_str($str)
{
  $invalid = array('Å '=>'S', 'Å¡'=>'s', 'Ä�'=>'Dj', 'Ä�'=>'dj', 'Å½'=>'Z', 'Å¾'=>'z', 'Ä�'=>'C', 'Ä�'=>'c', 'Ä�'=>'C', 'Ä�'=>'c', 'Ã�'=>'A', 'Ã�'=>'A', 'Ã�'=>'A', 'Ã�'=>'A', 'Ã�'=>'A', 'Ã�'=>'A', 'Ã�'=>'A', 'Ã�'=>'C', 'Ã�'=>'E', 'Ã�'=>'E', 'Ã�'=>'E', 'Ã�'=>'E', 'Ã�'=>'I', 'Ã�'=>'I', 'Ã�'=>'I', 'Ã�'=>'I', 'Ã�'=>'N', 'Ã�'=>'O', 'Ã�'=>'O', 'Ã�'=>'O', 'Ã�'=>'O', 'Ã�'=>'O', 'Ã�'=>'O', 'Ã�'=>'U', 'Ã�'=>'U', 'Ã�'=>'U', 'Ã�'=>'U', 'Ã�'=>'Y', 'Ã�'=>'B', 'Ã�'=>'Ss', 'Ã '=>'a', 'Ã¡'=>'a', 'Ã¢'=>'a', 'Ã£'=>'a', 'Ã¤'=>'a', 'Ã¥'=>'a', 'Ã¦'=>'a', 'Ã§'=>'c', 'Ã¨'=>'e', 'Ã©'=>'e', 'Ãª'=>'e', 'Ã«'=>'e', 'Ã¬'=>'i', 'Ã­'=>'i', 'Ã®'=>'i', 'Ã¯'=>'i', 'Ã°'=>'o', 'Ã±'=>'n', 'Ã²'=>'o', 'Ã³'=>'o', 'Ã´'=>'o', 'Ãµ'=>'o', 'Ã¶'=>'o', 'Ã¸'=>'o', 'Ã¹'=>'u', 'Ãº'=>'u', 'Ã»'=>'u', 'Ã½'=>'y',  'Ã½'=>'y', 'Ã¾'=>'b', 'Ã¿'=>'y', 'Å�'=>'R', 'Å�'=>'r', "`" => "'", "Â´" => "'", "â��" => ",", "`" => "'", "Â´" => "'", "â��" => "\"", "â��" => "\"", "Â´" => "'", "&acirc;â�¬â�¢" => "'", "{" => "", "~" => "", "â��" => "-", "â��" => "'", '—' => '-');

  $str = str_replace(array_keys($invalid), array_values($invalid), $str);

  return $str;
}

function display_message($result, $result_message, $title, $url)
{

  $messages = array(1 =>  'Success! I have added the episode: "' . $title . '" to your feed.',
                          'Hmm… I can\'t find any audio files, is this on SoundCloud?',
                          'I think I already have this one.' );

  if($result == true) {
    $header = 'Success';
    $redirect = '<p>Go back to <a href="' . $url . '">' . $url . '</a></p>';
    $result_css = 'alert-success';
  } else {
    $header = 'Failure';
    $redirect = '<div class="row">
	  <div class="btn-group btn-group-justified btn-group-sm">
    <a class="btn btn-default btn-lg" href="' . $address . 'reader/"><span class="glyphicon glyphicon-search"></span> Search the feed?</a>
    <a class="btn btn-default btn-lg" href="' . $address . 'post/"><span class="glyphicon glyphicon-edit"></span> Manually Post</a>
  </div>
	</div>';
    $result_css = 'alert-danger';
  }
  $message = '<!DOCTYPE html>
<html>
  <head>
    <title>Ping. A Private Sonar Feed.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
  </head>
  <body>
	<div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">';
  $message .= '<h1>Ping! <small>' . $header . '</small></h1><h4 class="alert ' . $result_css . '">' . $messages[$result_message] . '</h4>' . $redirect;
  $message .= '</div>
    </div>
	</div>
  </body>
</html>';
  return $message;
}

function get_page_html($url)
{
  return file_get_html($url);
}

function find_audio_file($url)
{

  $media_url = '';
  $search_url = urldecode($url);
  $html = get_page_html($url);

  // Search for .m4a files
  $media_url = $html->find('a[href$=.m4a]', 0);

  // If no .m4a files are found, then search for .mp3
  if ($media_url == '')
  {
    $media_url = $html->find('a[href$=.mp3]', 0);
  }

  return $media_url;

}

function check_for_duplicates($duplicate_check_url)
{
  $items = Spyc::YAMLLoad('urls.yaml');
  foreach ($items as $i)
  {
    if ($i['enc_link'] == $duplicate_check_url)
    {
      return true;
    } else {
      return false;
    }
    
  }
}