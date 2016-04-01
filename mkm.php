<?php
	/** Api configuration */
	$api			= "https://www.mkmapi.eu/ws/v1.1";
	$appToken       = "FTiBvXliIVGJYVWM";
	$appSecret      = "SOp2VZwl5KRvGZ4d5yAkObRz99HSaN1m";
	$accessToken    = "82QknOtVb57k9IEERVJHEig337GM5t3m";
	$accessSecret   = "cSNjy850YUlEoWvjUMEXe53ak86MAbSO";

	$url="$api/user/holalluis";

	/** Authenticate and retrieve stock */
	function mkmapi($url)
	{
		/**
		* Declare and assign all needed variables for the request and the header
		*
		* @var $method string Request method
		* @var $url string Full request URI
		* @var $appToken string App token found at the profile page
		* @var $appSecret string App secret found at the profile page
		* @var $accessToken string Access token found at the profile page (or retrieved from the /access request)
		* @var $accessSecret string Access token secret found at the profile page (or retrieved from the /access request)
		* @var $nonce string Custom made unique string, you can use uniqid() for this
		* @var $timestamp string Actual UNIX time stamp, you can use time() for this
		* @var $signatureMethod string Cryptographic hash function used for signing the base string with the signature, always HMAC-SHA1
		* @var version string OAuth version, currently 1.0
		*/
		
		global $appToken,$appSecret,$accessToken,$accessSecret;

		$method             = "GET";
		$nonce              = uniqid();
		$timestamp          = time();
		$signatureMethod    = "HMAC-SHA1";
		$version            = "1.0";

		/**
		* Gather all parameters that need to be included in the Authorization header and are know yet
		*
		* @var $params array|string[] Associative array of all needed authorization header parameters
		*/
		$params = array(
				'realm'                     => $url,
				'oauth_consumer_key'        => $appToken,
				'oauth_token'               => $accessToken,
				'oauth_nonce'               => $nonce,
				'oauth_timestamp'           => $timestamp,
				'oauth_signature_method'    => $signatureMethod,
				'oauth_version'             => $version,
				);

		/**
		* Start composing the base string from the method and request URI
		*
		* @var $baseString string Finally the encoded base string for that request, that needs to be signed
		*/
		$baseString         = strtoupper($method) . "&";
		$baseString        .= rawurlencode($url) . "&";

		/*
		* Gather, encode, and sort the base string parameters
		*/
		$encodedParams      = array();
		foreach ($params as $key => $value)
		{
			if ("realm" != $key)
			{
				$encodedParams[rawurlencode($key)] = rawurlencode($value);
			}
		}
		ksort($encodedParams);

		/*
		* Expand the base string by the encoded parameter=value pairs
		*/
		$values             = array();
		foreach ($encodedParams as $key => $value)
		{
			$values[] = $key . "=" . $value;
		}
		$paramsString       = rawurlencode(implode("&", $values));
		$baseString        .= $paramsString;

		/*
		* Create the signingKey
		*/
		$signatureKey       = rawurlencode($appSecret) . "&" . rawurlencode($accessSecret);

		/**
		* Create the OAuth signature
		* Attention: Make sure to provide the binary data to the Base64 encoder
		*
		* @var $oAuthSignature string OAuth signature value
		*/
		$rawSignature       = hash_hmac("sha1", $baseString, $signatureKey, true);
		$oAuthSignature     = base64_encode($rawSignature);

		/*
		* Include the OAuth signature parameter in the header parameters array
		*/
		$params['oauth_signature'] = $oAuthSignature;

		/*
		* Construct the header string
		*/
		$header             = "Authorization: OAuth ";
		$headerParams       = array();
		foreach ($params as $key => $value)
		{
			$headerParams[] = $key . "=\"" . $value . "\"";
		}
		$header            .= implode(", ", $headerParams);

		/*
		 * Get the cURL handler from the library function
		 */
		$curlHandle         = curl_init();

		/*
		 * Set the required cURL
		 options to successfully fire a request to MKM's API
		 *
		 * For more information about cURL options refer to PHP's cURL manual:
		 * http://php.net/manual/en/function.curl-setopt.php
		 */
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlHandle, CURLOPT_URL, $url);
		curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array($header));
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);

		/**
		 * Execute the request, retrieve information about the request and response, and close the connection
		 *
		 * @var $content string Response to the request
		 * @var $info array Array with information about the last request on the $curlHandle
		 */
		$content            = curl_exec($curlHandle);
		$info               = curl_getinfo($curlHandle);
		curl_close($curlHandle);
		/*
		 * Convert the response string into an object
		 *
		 * If you have chosen XML as response format (which is standard) use simplexml_load_string
		 * If you have chosen JSON as response format use json_decode
		 *
		 * @var $decoded \SimpleXMLElement|\stdClass Converted Object (XML|JSON)
		 */
		$xml  = simplexml_load_string($content);
		$json = json_encode($xml);
		return $json;//string
	}
	function curl($url,$header)
	{
		/*
		 * Get the cURL handler from the library function
		 */
		$curlHandle         = curl_init();

		/*
		 * Set the required cURL options to successfully fire a request to MKM's API
		 *
		 * For more information about cURL options refer to PHP's cURL manual:
		 * http://php.net/manual/en/function.curl-setopt.php
		 */
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlHandle, CURLOPT_URL, $url);
		curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array($header));
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);

		/**
		 * Execute the request, retrieve information about the request and response, and close the connection
		 *
		 * @var $content string Response to the request
		 * @var $info array Array with information about the last request on the $curlHandle
		 */
		$content            = curl_exec($curlHandle);
		$info               = curl_getinfo($curlHandle);
		curl_close($curlHandle);

		return $content;
	}
?>
