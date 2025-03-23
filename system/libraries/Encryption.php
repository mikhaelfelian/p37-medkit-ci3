<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 - 2022, CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniter Foundation (https://codeigniter.com/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 3.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Encryption Class
 *
 * Provides two-way keyed encryption via PHP's OpenSSL extension.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Andrey Andreev
 * @link		https://codeigniter.com/userguide3/libraries/encryption.html
 */
class CI_Encryption {

	/**
	 * Encryption cipher
	 *
	 * @var	string
	 */
	protected $_cipher = 'aes-256';

	/**
	 * Cipher mode
	 *
	 * @var	string
	 */
	protected $_mode = 'cbc';

	/**
	 * Cipher handle
	 *
	 * @var	string
	 */
	protected $_handle;

	/**
	 * Encryption key
	 *
	 * @var	string
	 */
	protected $_key;

	/**
	 * List of available modes
	 *
	 * @var	array
	 */
	protected $_modes = array(
		'openssl' => array(
			'cbc' => 'cbc',
			'ecb' => 'ecb',
			'ofb' => 'ofb',
			'cfb' => 'cfb',
			'cfb8' => 'cfb8',
			'ctr' => 'ctr',
			'stream' => '',
			'xts' => 'xts'
		)
	);

	/**
	 * List of supported HMAC algorithms
	 *
	 * name => digest size pairs
	 *
	 * @var	array
	 */
	protected $_digests = array(
		'sha224' => 28,
		'sha256' => 32,
		'sha384' => 48,
		'sha512' => 64
	);

	/**
	 * mbstring.func_overload flag
	 *
	 * @var	bool
	 */
	protected static $func_overload;

	// --------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 * @param	array	$params	Configuration parameters
	 * @return	void
	 */
	public function __construct(array $params = array())
	{
		if ( ! extension_loaded('openssl'))
		{
			show_error('Encryption: Unable to find the OpenSSL extension.');
		}

		isset(self::$func_overload) OR self::$func_overload = ( ! is_php('8.0') && extension_loaded('mbstring') && @ini_get('mbstring.func_overload'));
		
		// Set default cipher and mode
		$this->_cipher = 'aes-256';
		$this->_mode = 'cbc';
		
		// Initialize with provided parameters
		$this->initialize($params);

		// Set encryption key if not provided in params
		if ( ! isset($this->_key) && self::strlen($key = config_item('encryption_key')) > 0)
		{
			$this->_key = $key;
		}

		log_message('info', 'Encryption Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize
	 *
	 * @param	array	$params	Configuration parameters
	 * @return	CI_Encryption
	 */
	public function initialize(array $params)
	{
		// Set cipher if provided
		if ( ! empty($params['cipher']))
		{
			$this->_cipher = strtolower($params['cipher']);
		}

		// Set key if provided
		if ( ! empty($params['key']))
		{
			$this->_key = $params['key'];
		}

		// Set mode if provided
		if ( ! empty($params['mode']))
		{
			$params['mode'] = strtolower($params['mode']);
			if (isset($this->_modes['openssl'][$params['mode']]))
			{
				$this->_mode = $this->_modes['openssl'][$params['mode']];
			}
		}

		// Initialize OpenSSL
		$this->_openssl_initialize();
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize OpenSSL
	 *
	 * @return	void
	 */
	protected function _openssl_initialize()
	{
		// This is mostly for the stream mode, which doesn't get suffixed in OpenSSL
		$handle = empty($this->_mode)
			? $this->_cipher
			: $this->_cipher.'-'.$this->_mode;

		if ( ! in_array($handle, openssl_get_cipher_methods(), TRUE))
		{
			$this->_handle = NULL;
			log_message('error', 'Encryption: Unable to initialize OpenSSL with method '.strtoupper($handle).'.');
		}
		else
		{
			$this->_handle = $handle;
			log_message('info', 'Encryption: OpenSSL initialized with method '.strtoupper($handle).'.');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Create a random key
	 *
	 * @param	int	$length	Output length
	 * @return	string
	 */
	public function create_key($length)
	{
		if (function_exists('random_bytes'))
		{
			try
			{
				return random_bytes((int) $length);
			}
			catch (Exception $e)
			{
				log_message('error', $e->getMessage());
				return FALSE;
			}
		}

		$is_secure = NULL;
		$key = openssl_random_pseudo_bytes($length, $is_secure);
		return ($is_secure === TRUE)
			? $key
			: FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Encrypt
	 *
	 * @param	string	$data	Input data
	 * @param	array	$params	Input parameters
	 * @return	string
	 */
	public function encrypt($data, array $params = NULL)
	{
		if (($params = $this->_get_params($params)) === FALSE)
		{
			return FALSE;
		}

		isset($params['key']) OR $params['key'] = $this->hkdf($this->_key, 'sha512', NULL, self::strlen($this->_key), 'encryption');

		if (($data = $this->_openssl_encrypt($data, $params)) === FALSE)
		{
			return FALSE;
		}

		$params['base64'] && $data = base64_encode($data);

		if (isset($params['hmac_digest']))
		{
			isset($params['hmac_key']) OR $params['hmac_key'] = $this->hkdf($this->_key, 'sha512', NULL, NULL, 'authentication');
			return hash_hmac($params['hmac_digest'], $data, $params['hmac_key'], ! $params['base64']).$data;
		}

		return $data;
	}

	// --------------------------------------------------------------------

	/**
	 * Encrypt via OpenSSL
	 *
	 * @param	string	$data	Input data
	 * @param	array	$params	Input parameters
	 * @return	string
	 */
	protected function _openssl_encrypt($data, $params)
	{
		if (empty($params['handle']))
		{
			return FALSE;
		}

		$iv = ($iv_size = openssl_cipher_iv_length($params['handle']))
			? $this->create_key($iv_size)
			: '';

		$data = openssl_encrypt(
			$data,
			$params['handle'],
			$params['key'],
			1, // DO NOT TOUCH!
			$iv
		);

		if ($data === FALSE)
		{
			return FALSE;
		}

		return $iv.$data;
	}

	// --------------------------------------------------------------------

	/**
	 * Decrypt
	 *
	 * @param	string	$data	Encrypted data
	 * @param	array	$params	Input parameters
	 * @return	string
	 */
	public function decrypt($data, array $params = NULL)
	{
		if (($params = $this->_get_params($params)) === FALSE)
		{
			return FALSE;
		}

		if (isset($params['hmac_digest']))
		{
			// This might look illogical, but it is done during encryption as well ...
			// The 'base64' value is effectively an inverted "raw data" parameter
			$digest_size = ($params['base64'])
				? $this->_digests[$params['hmac_digest']] * 2
				: $this->_digests[$params['hmac_digest']];

			if (self::strlen($data) <= $digest_size)
			{
				return FALSE;
			}

			$hmac_input = self::substr($data, 0, $digest_size);
			$data = self::substr($data, $digest_size);

			isset($params['hmac_key']) OR $params['hmac_key'] = $this->hkdf($this->_key, 'sha512', NULL, NULL, 'authentication');
			$hmac_check = hash_hmac($params['hmac_digest'], $data, $params['hmac_key'], ! $params['base64']);

			// Time-attack-safe comparison
			$diff = 0;
			for ($i = 0; $i < $digest_size; $i++)
			{
				$diff |= ord($hmac_input[$i]) ^ ord($hmac_check[$i]);
			}

			if ($diff !== 0)
			{
				return FALSE;
			}
		}

		if ($params['base64'])
		{
			$data = base64_decode($data);
		}

		isset($params['key']) OR $params['key'] = $this->hkdf($this->_key, 'sha512', NULL, self::strlen($this->_key), 'encryption');

		return $this->_openssl_decrypt($data, $params);
	}

	// --------------------------------------------------------------------

	/**
	 * Decrypt via OpenSSL
	 *
	 * @param	string	$data	Encrypted data
	 * @param	array	$params	Input parameters
	 * @return	string
	 */
	protected function _openssl_decrypt($data, $params)
	{
		if ($iv_size = openssl_cipher_iv_length($params['handle']))
		{
			$iv = self::substr($data, 0, $iv_size);
			$data = self::substr($data, $iv_size);
		}
		else
		{
			$iv = '';
		}

		return empty($params['handle'])
			? FALSE
			: openssl_decrypt(
				$data,
				$params['handle'],
				$params['key'],
				1, // DO NOT TOUCH!
				$iv
			);
	}

	// --------------------------------------------------------------------

	/**
	 * Get params
	 *
	 * @param	array	$params	Input parameters
	 * @return	array
	 */
	protected function _get_params($params)
	{
		if (empty($params))
		{
			return isset($this->_cipher, $this->_mode, $this->_key, $this->_handle)
				? array(
					'handle' => $this->_handle,
					'cipher' => $this->_cipher,
					'mode' => $this->_mode,
					'key' => NULL,
					'base64' => TRUE,
					'hmac_digest' => 'sha512',
					'hmac_key' => NULL
				)
				: FALSE;
		}
		elseif ( ! isset($params['cipher'], $params['mode'], $params['key']))
		{
			return FALSE;
		}

		if (isset($params['mode']))
		{
			$params['mode'] = strtolower($params['mode']);
			if ( ! isset($this->_modes['openssl'][$params['mode']]))
			{
				return FALSE;
			}

			$params['mode'] = $this->_modes['openssl'][$params['mode']];
		}

		if (isset($params['hmac']) && $params['hmac'] === FALSE)
		{
			$params['hmac_digest'] = $params['hmac_key'] = NULL;
		}
		else
		{
			if ( ! isset($params['hmac_key']))
			{
				return FALSE;
			}
			elseif (isset($params['hmac_digest']))
			{
				$params['hmac_digest'] = strtolower($params['hmac_digest']);
				if ( ! isset($this->_digests[$params['hmac_digest']]))
				{
					return FALSE;
				}
			}
			else
			{
				$params['hmac_digest'] = 'sha512';
			}
		}

		$params = array(
			'handle' => NULL,
			'cipher' => $params['cipher'],
			'mode' => $params['mode'],
			'key' => $params['key'],
			'base64' => isset($params['raw_data']) ? ! $params['raw_data'] : FALSE,
			'hmac_digest' => $params['hmac_digest'],
			'hmac_key' => $params['hmac_key']
		);

		$params['handle'] = ($params['cipher'] !== $this->_cipher OR $params['mode'] !== $this->_mode)
			? $this->_openssl_get_handle($params['cipher'], $params['mode'])
			: $this->_handle;

		return $params;
	}

	// --------------------------------------------------------------------

	/**
	 * Get OpenSSL handle
	 *
	 * @param	string	$cipher	Cipher name
	 * @param	string	$mode	Encryption mode
	 * @return	string
	 */
	protected function _openssl_get_handle($cipher, $mode)
	{
		// OpenSSL methods aren't suffixed with '-stream' for this mode
		return ($mode === 'stream')
			? $cipher
			: $cipher.'-'.$mode;
	}

	// --------------------------------------------------------------------

	/**
	 * HKDF
	 *
	 * @link	https://tools.ietf.org/rfc/rfc5869.txt
	 * @param	$key	Input key
	 * @param	$digest	A SHA-2 hashing algorithm
	 * @param	$salt	Optional salt
	 * @param	$length	Output length (defaults to the selected digest size)
	 * @param	$info	Optional context/application-specific info
	 * @return	string	A pseudo-random key
	 */
	public function hkdf($key, $digest = 'sha512', $salt = NULL, $length = NULL, $info = '')
	{
		if ( ! isset($this->_digests[$digest]))
		{
			return FALSE;
		}

		if (empty($length) OR ! is_int($length))
		{
			$length = $this->_digests[$digest];
		}
		elseif ($length > (255 * $this->_digests[$digest]))
		{
			return FALSE;
		}

		self::strlen($salt) OR $salt = str_repeat("\0", $this->_digests[$digest]);

		$prk = hash_hmac($digest, $key, $salt, TRUE);
		$key = '';
		for ($key_block = '', $block_index = 1; self::strlen($key) < $length; $block_index++)
		{
			$key_block = hash_hmac($digest, $key_block.$info.chr($block_index), $prk, TRUE);
			$key .= $key_block;
		}

		return self::substr($key, 0, $length);
	}

	// --------------------------------------------------------------------

	/**
	 * __get() magic
	 *
	 * @param	string	$key	Property name
	 * @return	mixed
	 */
	public function __get($key)
	{
		// Because aliases
		if ($key === 'mode')
		{
			return array_search($this->_mode, $this->_modes['openssl'], TRUE);
		}
		elseif (in_array($key, array('cipher', 'digests'), TRUE))
		{
			return $this->{'_'.$key};
		}

		return NULL;
	}

	// --------------------------------------------------------------------

	/**
	 * Byte-safe strlen()
	 *
	 * @param	string	$str
	 * @return	int
	 */
	protected static function strlen($str)
	{
		return (self::$func_overload)
			? mb_strlen((string) $str, '8bit')
			: strlen((string) $str);
	}

	// --------------------------------------------------------------------

	/**
	 * Byte-safe substr()
	 *
	 * @param	string	$str
	 * @param	int	$start
	 * @param	int	$length
	 * @return	string
	 */
	protected static function substr($str, $start, $length = NULL)
	{
		if (self::$func_overload)
		{
			// mb_substr($str, $start, null, '8bit') returns an empty
			// string on PHP 5.3
			isset($length) OR $length = ($start >= 0 ? self::strlen($str) - $start : -$start);
			return mb_substr($str, $start, $length, '8bit');
		}

		return isset($length)
			? substr($str, $start, $length)
			: substr($str, $start);
	}
}
