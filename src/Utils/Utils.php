<?php declare(strict_types=1);

namespace Surda\Adldap\Utils;

class Utils
{
    public static function SIDtoString(string $binSid): string
    {
        $sid = "S-";
        $sidinhex = str_split(bin2hex($binSid), 2);
        // Byte 0 = Revision Level
        $sid = $sid . hexdec($sidinhex[0]) . "-";
        // Byte 1-7 = 48 Bit Authority
        $sid = $sid . hexdec($sidinhex[6] . $sidinhex[5] . $sidinhex[4] . $sidinhex[3] . $sidinhex[2] . $sidinhex[1]);
        // Byte 8 count of sub authorities - Get number of sub-authorities
        $subauths = hexdec($sidinhex[7]);
        //Loop through Sub Authorities
        for ($i = 0; $i < $subauths; $i++) {
            $start = 8 + (4 * $i);
            // X amount of 32Bit (4 Byte) Sub Authorities
            $sid = $sid . "-" . hexdec($sidinhex[$start + 3] . $sidinhex[$start + 2] . $sidinhex[$start + 1] . $sidinhex[$start]);
        }

        return $sid;
    }

    /**
     * Converts a binary attribute to a string
     * https://github.com/php/web-wiki/blob/master/dokuwiki/lib/plugins/authad/adLDAP/classes/adLDAPUtils.php
     */
    public static function GUIDtoString(string $binGuid): string
    {
        $hex_guid = bin2hex($binGuid);
        $hex_guid_to_guid_str = '';
        for ($k = 1; $k <= 4; ++$k) {
            $hex_guid_to_guid_str .= substr($hex_guid, 8 - 2 * $k, 2);
        }
        $hex_guid_to_guid_str .= '-';
        for ($k = 1; $k <= 2; ++$k) {
            $hex_guid_to_guid_str .= substr($hex_guid, 12 - 2 * $k, 2);
        }
        $hex_guid_to_guid_str .= '-';
        for ($k = 1; $k <= 2; ++$k) {
            $hex_guid_to_guid_str .= substr($hex_guid, 16 - 2 * $k, 2);
        }
        $hex_guid_to_guid_str .= '-' . substr($hex_guid, 16, 4);
        $hex_guid_to_guid_str .= '-' . substr($hex_guid, 20);

        return strtoupper($hex_guid_to_guid_str);
    }

    public static function wintime2Unixtime(int $wintime): int
    {
        //round the win timestamp down to seconds and remove the seconds between 1601-01-01 and 1970-01-01
        return (int)round($wintime / 10000000) - 11644477200;
    }
}