# Ping! Very Private Podcast Feed.

*Ping! Very Private Podcast Feed.* lets you add M4A or MP3 files from a web site to a feed for listening later. You can keep it private and subscribe to it in your favorite podcast app. 

It is very much like [HuffDuffer](http://huffduffer.com), but private and hosted by you.

## Installation
*Ping! Very Private Podcast Feed.* is written in PHP and should run on almost every server. It’s required that your PHP installation has cURL support. There are no other dependencies or databases.

1. Edit `config.php` and ensure that the `server` and `folder` variables are correct for your installation.
1. Copy the whole folder to the web server.
2. Change permissions of `urls.yaml` to be either writable by the web-server or world-writable (`chmod 666 urls.yaml`).
3. Visit the just copied folder and drag the bookmarklets to your bookmarks bar.
4. Subscribe to the feed via one of the links on that page.

## Usage

When you visit a web page that has either a link to a M4A or MP3 file you just click on the bookmarklet. *Ping!* will parse the visited site and use the first found M4A or MP3 file (in that order) as the media enclosure for the feed.

You can select some text before clicking on the bookmarklet and your selection will be used as the description for the feed item.

*Ping!* will detect duplicates and don’t add them to your feed, unless you use the manual `/post` method. 

After the file was successfully added to your feed, you’ll be able to get back to the referring site.

## Gotchas

There is not much error handling. This means that when there are links that don’t end with `.m4a` or `.mp3` they won’t be detected (e.g. NPR or SoundCloud are not supported), you may have luck using the `/reader` feature.

## Code Used

- [F*ck-Huff-Duff](https://github.com/rbugajewski/fuck-huff-duff)
- [PHP Universal Feed Generator](https://github.com/mibe/FeedWriter)
- [Simple HTML DOM Parser](http://simplehtmldom.sourceforge.net)
- [Spyc](https://github.com/mustangostang/spyc/)
- [PicoFeed](https://github.com/fguillot/picoFeed)
- [Bootstrap](http://getbootstrap.com)
