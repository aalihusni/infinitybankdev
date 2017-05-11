<?php
namespace App\Classes;

use App\BitcoinWallet;
use App\BitcoinWalletReceiving;
use App\BitcoinBlockioWalletReceiving;
use Validator;
use Carbon\Carbon;

class BitcoinWalletClass
{
    public static function generateSecret()
    {
        $secret = "";

        for ($x = 1; $x <= 10; $x++) {
            $type = rand(0, 1);

            switch ($type) {
                case 0:
                    $secret = $secret . self::generateNumberKey();
                    break;
                case 1:
                    $secret = $secret .  self::generateRandomAlphaCaseKey();
                    break;
            }
        }

        $rules = array(
            'key' => array('Regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/')
        );

        $validator = Validator::make(array('key' => $secret), $rules);
        if ($validator->fails())
        {
            return self::generateSecret();
        } else {
            if (empty($secret))
            {
                return self::generateSecret();
            } else {
                return Carbon::now()->format('ym').$secret;
            }
        }
    }

    public static function generatePassword()
    {
        $password = "";

        for ($x = 1; $x <= 32; $x++) {
            $type = rand(0, 2);

            switch ($type) {
                case 0:
                    $password = $password . self::generateNumberKey();
                    break;
                case 1:
                    $password = $password .  self::generateRandomAlphaCaseKey();
                    break;
                case 2:
                    $password = $password .  self::generateRandomCharacter();
                    break;
            }
        }

        return $password;
    }

    public static function generatePrivateKey()
    {
        $privatekey = "";

        for ($x = 1; $x <= 8; $x++) {
            if ($privatekey == "") {
                $privatekey = self::generatePartialKey();
            } else {
                $privatekey = $privatekey . self::generatePartialKey();
            }
        }

        return $privatekey;
    }

    public static function generatePartialKey()
    {
        $privatekey = "";

        for ($x = 1; $x <= 4; $x++) {
            if ($privatekey == "") {
                $privatekey = self::generatePairKey();
            } else {
                $privatekey = $privatekey . self::generatePairKey();
            }
        }

        $rules = array(
            'key' => array('Regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/')
        );

        $validator = Validator::make(array('key' => $privatekey), $rules);
        if ($validator->fails())
        {
            return self::generatePartialKey();
        } else {
            return $privatekey;
        }
    }

    public static function generatePairKey()
    {
        return self::generateRandomKey().self::generateRandomKey();
    }

    public static function generateRandomKey()
    {
        $type = rand(0, 1);

        switch ($type) {
            case 0:
                return self::generateNumberKey();
                break;
            case 1:
                return self::generateAlphaKey();
                break;
        }
    }

    public static function generateNumberKey()
    {
        return $type = chr(rand(48, 57));
    }

    public static function generateAlphaKey()
    {
        return self::generateRandomAlphaCaseKey();
        //return $type = chr(rand(65, 70)); //Upper
        //return $type = chr(rand(97, 102)); //Lower
    }

    public static function generateRandomAlphaCaseKey()
    {
        $type = rand(0, 1);

        switch ($type) {
            case 0:
                return $type = chr(rand(65, 70));
                break;
            case 1:
                return $type = chr(rand(97, 102));
                break;
        }
    }

    public static function generateRandomCharacter()
    {
        $characters = "!@#$%^&*()_+-=";
        $select = rand(0,(strlen($characters)-1));
        return substr($characters,$select,1);
    }

    /**
     * Determine if a string is a valid Bitcoin address
     *
     * @author theymos
     * @param string $addr String to test
     * @param string $addressversion
     * @return boolean
     * @access public
     */
    public static function validBitcoinAddress($address) {
        $addressversion = "00";
        $addr = self::decodeBase58($address);
        if (strlen($addr) != 50) {
            return false;
        }
        $version = substr($addr, 0, 2);
        if (hexdec($version) > hexdec($addressversion)) {
            return false;
        }
        $check = substr($addr, 0, strlen($addr) - 8);
        $check = pack("H*", $check);
        $check = strtoupper(hash("sha256", hash("sha256", $check, true)));
        $check = substr($check, 0, 8);
        if (self::isNotReceivingAddress($address))
        {
            return $check == substr($addr, strlen($addr) - 8);
        } else {
            return false;
        }
    }

    private static function encodeHex($dec) {
        $hexchars = "0123456789ABCDEF";
        $return = "";
        while (bccomp($dec, 0) == 1) {
            $dv = (string) bcdiv($dec, "16", 0);
            $rem = (integer) bcmod($dec, "16");
            $dec = $dv;
            $return = $return . $hexchars[$rem];
        }
        return strrev($return);
    }

    /**
     * Convert a Base58-encoded integer into the equivalent hex string representation
     *
     * @param string $base58
     * @return string
     * @access private
     */
    private static function decodeBase58($base58) {
        $origbase58 = $base58;
        $base58chars = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
        $return = "0";
        for ($i = 0; $i < strlen($base58); $i++) {
            $current = (string) strpos($base58chars, $base58[$i]);
            $return = (string) bcmul($return, "58", 0);
            $return = (string) bcadd($return, $current, 0);
        }
        $return = self::encodeHex($return);
        //leading zeros
        for ($i = 0; $i < strlen($origbase58) && $origbase58[$i] == "1"; $i++) {
            $return = "00" . $return;
        }
        if (strlen($return) % 2 != 0) {
            $return = "0" . $return;
        }
        return $return;
    }

    private static function isNotReceivingAddress($address)
    {
        $wallet_receiving = BitcoinBlockioWalletReceiving::where('receiving_address','=',$address)
            ->count();
        if ($wallet_receiving) {
            return false;
        } else {
            return true;
        }
    }
}