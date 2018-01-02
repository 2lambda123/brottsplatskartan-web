<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Blog extends Model
{
    protected $table = 'blog';

    public function getCreatedAtFormatted($format = '%d %B %Y')
    {
        return Carbon::parse($this->created_at)->formatLocalized($format);
    }

    public function getCreatedAtAsW3cString()
    {
        return Carbon::parse($this->created_at)->toW3cString();
    }

    public function getExcerpt($length = 50)
    {
        $str = $this->content;
        $str = \Markdown::parse($str);

        // Behöver köra tweet-embedningen, även om vi inte ska visa tweets,
        // annars riskerar vi att det står "AMPTWEET: [...]" i utdraget.
        $str = $this->embedTweets($str);

        $str = strip_tags($str);
        $str = Str::words($str, $length);

        return $str;
    }

    public function getPermalink()
    {
        return route(
            'blogItem',
            [
                'year' => date('Y', $this->created_at->timestamp),
                'slug' => $this->slug
            ]
        );
    }

    public function getContentFormatted()
    {
        $str = $this->content;
        $str = \Markdown::parse($str);
        $str = $this->embedTweets($str);
        return $str;
    }

    /**
     * Convert lines like
     * AMPTWEET: https://twitter.com/eskapism/status/944609719179796480
     *
     * to
     *
     * <amp-twitter
     *    width="375"
     *    height="472"
     *    layout="responsive"
     *    data-tweetid="944609719179796480">
     * </amp-twitter>
    */
    public static function embedTweets($str)
    {
        $lines = preg_split('/\R/', $str);

        foreach ($lines as $key => $val) {
            #if (starts_with($val, 'https://twitter.com/')) {
            if (starts_with($val, '<p>AMPTWEET:')) {
                preg_match('!/status/(\d+)!', $val, $matches);
                if (sizeof($matches) === 2) {
                    $tweetId = $matches[1];
                    $lines[$key] = sprintf(
                        '<amp-twitter
                             width="375"
                             height="472"
                             layout="responsive"
                             data-tweetid="%1$s">
                            </amp-twitter>
                        ',
                        $tweetId
                    );
                }
            }
        }

        return implode("\n", $lines);
    }
}
