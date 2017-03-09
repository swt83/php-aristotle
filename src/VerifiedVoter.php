<?php

namespace Travis\Aristotle;

use Travis\XML;

class VerifiedVoter
{
	public static function run($args)
	{
		$url = 'https://www.verifiedvoter.com/service/lookup/voterDetail?';

        // fix zip...
        if (isset($args['zip']))
        {
            $parts = explode('-', $args['zip']);
            $args['zip'] = $parts[0];
        }

        // build query string
		foreach ($args as $key => $value)
		{
            $url .= $key . '=' . urlencode($value) . '&';
		}

		// connect to api
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        #curl_setopt($ch, CURLOPT_POST, true);
        #curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        $response = curl_exec($ch);

        // catch errors...
        if (curl_errno($ch))
        {
            // catch errors
            #$errors = curl_error($ch);

            // close
            curl_close($ch);

            // bail
            return false;
        }

        // close
        curl_close($ch);

        // save
        $result = XML::from_string($response);

        // catch errors...
        $error = ex($result, 'array.Detail.ErrorDescription.value');
        if ($error)
        {
            throw new \Exception($error);
        }

        // foreach...
        $final = [];
        foreach (ex($result, 'array.Detail.Data.Element') as $data)
        {
            $final[trim(ex($data, 'Name.value'))] = trim(ex($data, 'Value.value'));
        }

        // return
        return $final;
	}
}