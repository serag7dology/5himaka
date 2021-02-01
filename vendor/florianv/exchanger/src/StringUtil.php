<?php

declare(strict_types=1);

/*
 * This file is part of Exchanger.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Exchanger;

/**
 * Utility class to manipulate strings.
 *
 * @author GuzzleHttp
 */
final class StringUtil
{
    /**
     * Transforms an XML string to an element.
     *
     * @param string $string
     *
     * @throws \RuntimeException
     *
     * @return \SimpleXMLElement
     */
    public static function xmlToElement(string $string): \SimpleXMLElement
    {
        $disableEntities = libxml_disable_entity_loader(true);
        $internalErrors = libxml_use_internal_errors(true);

        try {
            // Allow XML to be retrieved even if there is no response body
            $xml = new \SimpleXMLElement($string ?: '<root />', LIBXML_NONET);

            libxml_disable_entity_loader($disableEntities);
            libxml_use_internal_errors($internalErrors);
        } catch (\Exception $e) {
            libxml_disable_entity_loader($disableEntities);
            libxml_use_internal_errors($internalErrors);

            throw new \RuntimeException('Unable to parse XML data: '.$e->getMessage());
        }

        return $xml;
    }

    /**
     * Transforms a JSON string to an array.
     *
     * @param string $string
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    public static function jsonToArray(string $string): array
    {
        static $jsonErrors = [
            JSON_ERROR_DEPTH => 'JSON_ERROR_DEPTH - Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'JSON_ERROR_STATE_MISMATCH - Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR => 'JSON_ERROR_CTRL_CHAR - Unexpected control character found',
            JSON_ERROR_SYNTAX => 'JSON_ERROR_SYNTAX - Syntax error, malformed JSON',
            JSON_ERROR_UTF8 => 'JSON_ERROR_UTF8 - Malformed UTF-8 characters, possibly incorrectly encoded',
        ];

        $data = json_decode($string, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            $last = json_last_error();

            throw new \RuntimeException('Unable to parse JSON data: '.(isset($jsonErrors[$last]) ? $jsonErrors[$last] : 'Unknown error'));
        }

        return $data;
    }
}
