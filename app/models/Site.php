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
class Site extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sites';
}