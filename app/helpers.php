<?php

/**
 * We check against the top list of SQL Injection commands used for 'admin' Auth exploitation
 *
 * @param string $payload
 * @return bool
 */
if (!function_exists('is_challenge_sqlinjection')) {
    function is_challenge_sqlinjection(string $payload): bool
    {
        $payloads = [
            "admin' --",
            "admin' #",
            "admin'/*",
            "admin' or '1'='1",
            "admin' or '1'='1'--",
            "admin' or '1'='1'#",
            "admin' or '1'='1'/*",
            "admin'or 1=1 or ''='",
            "admin' or 1=1",
            "admin' or 1=1--",
            "admin' or 1=1#",
            "admin' or 1=1/*",
            "admin') or ('1'='1",
            "admin') or ('1'='1'--",
            "admin') or ('1'='1'#",
            "admin') or ('1'='1'/*",
            "admin') or '1'='1",
            "admin') or '1'='1'--",
            "admin') or '1'='1'#",
            "admin') or '1'='1'/*",
            "1234 ' AND 1=0 UNION ALL SELECT 'admin',
            '81dc9bdb52d04dc20036dbd8313ed055",
            "admin\" --",
            "admin\" #",
            "admin\"/*",
            "admin\" or \"1\"=\"1",
            "admin\" or \"1\"=\"1\"--",
            "admin\" or \"1\"=\"1\"#",
            "admin\" or \"1\"=\"1\"/*",
            "admin\"or 1=1 or \"\"=\"",
            "admin\" or 1=1",
            "admin\" or 1=1--",
            "admin\" or 1=1#",
            "admin\" or 1=1/*",
            "admin\") or (\"1\"=\"1",
            "admin\") or (\"1\"=\"1\"--",
            "admin\") or (\"1\"=\"1\"#",
            "admin\") or (\"1\"=\"1\"/*",
            "admin\") or \"1\"=\"1",
            "admin\") or \"1\"=\"1\"--",
            "admin\") or \"1\"=\"1\"#",
            "admin\") or \"1\"=\"1\"/*",
            "1234 \" AND 1=0 UNION ALL SELECT \"admin\",
            \"81dc9bdb52d04dc20036dbd8313ed055"
        ];

        return in_array($payload, $payloads);
    }
}

/**
 * We detect XSS by asking the DOM engine if the loaded string loads children
 *
 * @param $string
 * @return bool
 */
if (!function_exists('is_challenge_xss')) {
    function is_challenge_xss($string): bool
    {
        libxml_use_internal_errors(true);

        if ($xml = simplexml_load_string("<root>$string</root>")) {
            return $xml->children()->count() !== 0;
        }

        return false;
    }
}
