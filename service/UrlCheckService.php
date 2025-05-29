<?php

namespace app\service;

/**
 * Код для этих двух функций я взял от ChatGPT, чтобы кириллические ссылки работали
 */
class UrlCheckService
{
    public function isValidUrlWithIDN($url)
    {
        $parsed = parse_url($url);

        // Проверим наличие хоста
        if (!isset($parsed['host'])) {
            return false;
        }

        // Преобразуем домен в ASCII (Punycode)
        $asciiHost = idn_to_ascii($parsed['host'], IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
        if (!$asciiHost) {
            return false;
        }

        // Собираем URL заново с ASCII-доменом
        $scheme = isset($parsed['scheme']) ? $parsed['scheme'] : 'wrong';
        $user = isset($parsed['user']) ? $parsed['user'] : '';
        $pass = isset($parsed['pass']) ? ':' . $parsed['pass'] : '';
        $auth = $user || $pass ? "$user$pass@" : '';
        $port = isset($parsed['port']) ? ':' . $parsed['port'] : '';
        $path = isset($parsed['path']) ? $parsed['path'] : '';
        $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
        $fragment = isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '';

        if (!in_array($scheme, ['http', 'https'])) {
            return false;
        }

        $reconstructedUrl = "$scheme://$auth$asciiHost$port$path$query$fragment";
        // Проверяем валидность преобразованного URL
        return filter_var($reconstructedUrl, FILTER_VALIDATE_URL) !== false;
    }

    public function isAccessible($url)
    {
        // Преобразуем кириллический домен в Punycode
        $parsed = parse_url($url);

        if (!isset($parsed['host'])) {
            return false;
        }

        $host = idn_to_ascii($parsed['host'], IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
        if (!$host) {
            return false;
        }

        // Собираем URL заново с Punycode-доменом
        $scheme = isset($parsed['scheme']) ? $parsed['scheme'] : 'http';
        $path   = isset($parsed['path']) ? $parsed['path'] : '';
        $query  = isset($parsed['query']) ? '?' . $parsed['query'] : '';
        $url_ascii = $scheme . '://' . $host . $path . $query;

        // Настройки для HEAD-запроса
        $context = stream_context_create([
            $scheme => [
                'method' => 'HEAD',
                'timeout' => 5,
            ]
        ]);

        $headers = @get_headers($url_ascii, false, $context);

        if ($headers && isset($headers[0])) {
            preg_match('/HTTP\/\d+\.\d+\s+(\d+)/', $headers[0], $matches);
            if (isset($matches[1])) {
                $httpCode = (int)$matches[1];
                return ($httpCode >= 200 && $httpCode < 400);
            }
        }

        return false;
    }
}
