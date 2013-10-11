<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * An Eloquent Model: 'Feed'
 *
 * @property integer $id
 * @property integer $site_id
 * @property string $hash
 * @property string $name
 * @property string $url
 * @property integer $score
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Feed extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'feeds';
	
	
	/**
	 * add feed from site
	 */
	public static function addFeedFromSite($siteId)
	{
		if (!$site = Site::find($siteId)) {
			return NULL;
		}
		return self::addFromRssUrl($site->url_feed);
	}
	
	/**
	 * bulk add from url
	 */
	public static function addFromRssUrl($rssUrl)
	{
		if (!strlen($rssUrl)) {
			return FALSE;
		}
		try {
			$xmlString = file_get_contents($rssUrl);

		} catch (exception $excp) {
			echo $excp->getMessage();
			return NULL;
		}
		
		return self::addFromRssString($xmlString);
	}
	
	/**
	 * bulk add from url
	 */
	public static function addFromRssString($rssString)
	{
		if (!$xml = simplexml_load_string($rssString)) {
			echo "failed to load xml\n";
			return NULL;
		}
		$site = Site::where('url', '=', $xml->channel->link)->first();
		if (!$site) {
			$site = new Site();
			$site->name = $xml->channel->title;
			$site->url = $xml->channel->link;
			$site->save();
		}
		if (isset($xml->item)) {
			foreach ($xml->item as $item) {
				$hash = sha1($item->link);
				if (!Feed::where('hash', '=', $hash)->count()) {
					$feed = new Feed();
					$feed->name = $item->title;
					$feed->url  = $item->link;
					$feed->hash = $hash;
					$feed->site_id = $site->id;
					$feed->save();
				}
			}
		}
		return TRUE;
	}
}