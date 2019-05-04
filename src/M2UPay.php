<?php

namespace M2U;

class M2UPay 
{
	public function PKCS5_Padding($text, $blockSize)
	{
		$p = $blockSize - (strlen($text) % $blockSize);
		return $text . str_repeat(chr($p), $p);
	}
    
	public function EncryptData($v, $secretKey)
	{
		$v =  $this->PKCS5_Padding($v, mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'ecb'));
	    return rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128,$secretKey, $v, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND))), "\0");
	}

    public function getEncryptionData($data, $envType)
    {
		$amount = $data['amount'];
        $accountNumber = $data['accountNumber'];
        $payeeCode = $data['payeeCode'];
        $refNumber = $data['refNumber'];
        $redirect_url = $data['callbackUrl'];

        //Passed in parameter based on M2U requirment for send string
        $dataString = '';
        if (($accountNumber == null || $accountNumber == "") && ($refNumber != null &&  $refNumber != ""))
        {
        	$dataString = 'Login$' . $payeeCode. '$1$' . $amount . '$1$' . $refNumber . '$$$' . $redirect_url;
        }
        else if (($accountNumber != null && $accountNumber != "" ) && ($refNumber == null ||  $refNumber == ""))
        {
        	$dataString = 'Login$' . $payeeCode . '$1$' . $amount . '$$$1$' . $accountNumber . '$' . $redirect_url;
        }
        else
        {
        	$dataString = 'Login$' . $payeeCode . '$1$' . $amount . '$1$'. $refNumber.'$1$' . $accountNumber . '$' .$redirect_url;
        }

    	//------ Encryption -----
    	$Iterations = 2;
		$secretKey = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$salt = "Maybank2u simple encryption";
		for ($i=0; $i < $Iterations; $i++)
		{
			$dataString = $this->EncryptData($salt.$dataString, $secretKey);
		}
		$dataStringEncrypted = urlencode($dataString);

		// Endpoint URL (Based on Environement)
		if ($envType == 1)
		{
			// User Acceptance Test (UAT) Environment
			$actionUrl = "https://202.162.18.55:8443/testM2uPayment";
		}
		else if ($envType == 2)
		{
			// Production / Live Environment
			$actionUrl = "https://www.maybank2u.com.my/mbb/m2u/m9006_enc/m2uMerchantLogin.do";
		}
		else
		{
			// Sandbox or Playground Environment
			$actionUrl = "https://api.discotech.io/v1.0/testM2uPayment";
		}
		
		// Return the encrypted data and actionUrl as Merchant API response
		return json_encode(array('encryptedString' => $dataStringEncrypted, 'actionUrl' => $actionUrl));
    }
}
?>