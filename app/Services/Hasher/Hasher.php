<?php namespace App\Services\Hasher;

/**
 * Class Hasher
 *
 * @author Justin Bevan justin@smokerschoiceusa.com
 * @package App\Services\Hasher
 */

use Exception;
use App\Library\Hash\Hashids;

class Hasher
{
	/**
	 * Laravel application
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	public $app;

	/**
	 * Create a new confide instance.
	 *
	 * @param \Illuminate\Foundation\Application $app
	 */
	public function __construct($app)
	{
		$this->app    = $app;
		$this->hasher = new Hashids('config.app.hashKey', 20);
	}

	/**
	 * Decode Value From Hasher
	 *
	 * @param $value
	 * @param bool|true $returnOriginal
	 * @return bool
	 */
	public function decode($value, $returnOriginal = true)
	{
		try
		{
			$decoded        = $this->hasher->decode($value);
			$decodedVal     = (isset($decoded[0]) ? $decoded[0] : false);
		}
		catch(Exception $e)
		{
			return false;
		}

		if($decodedVal)
		{
			return $decodedVal;
		}

		if($returnOriginal)
		{
			return $value;
		}

		return false;
	}

	/**
	 * Encode Value From Hasher
	 *
	 * @param $value
     * @param $nullOnEmpty
	 * @return bool
	 */
	public function encode($value, $nullOnEmpty = false)
	{
        if($nullOnEmpty && ($value == 0 || $value == '0'))
        {
            return null;
        }

		try
		{
			$encoded = $this->hasher->encode($value);
		}
		catch(Exception $e)
		{
			return false;
		}

		if($encoded)
		{
			return $encoded;
		}

		return false;
	}
}