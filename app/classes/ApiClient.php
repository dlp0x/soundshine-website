<?php

namespace App\Classes;

/**
 * Thin HTTP client for the radiodj-api Local API.
 *
 * Replaces direct RadioDJ MySQL access on public-facing pages (see issue #1).
 * All calls are GET requests authenticated with the site API key, and all
 * failures (network errors, timeouts, non-2xx responses, invalid JSON) are
 * handled gracefully by returning null instead of throwing, so calling code
 * can fall back to a "Nothing found" state instead of crashing the page.
 */
class ApiClient
{
    /**
     * Perform a GET request against the radiodj-api and return the decoded
     * JSON body as an associative array, or null on any failure.
     *
     * @param string $path  API path, e.g. '/now-playing' or '/shows/12'
     * @param array  $query Optional query string parameters
     */
    public static function get(string $path, array $query = []): ?array
    {
        $baseUrl = rtrim((string) RADIODJ_API_URL, '/');
        $url = $baseUrl . $path;
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => defined('RADIODJ_API_TIMEOUT') ? RADIODJ_API_TIMEOUT : 5,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_HTTPHEADER     => [
                'X-Api-Key: ' . RADIODJ_API_KEY,
                'Accept: application/json',
            ],
        ]);

        $body   = curl_exec($ch);
        $errno  = curl_errno($ch);
        $error  = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($errno !== 0) {
            error_log("[ApiClient] GET $path failed: $error");
            return null;
        }

        if ($status < 200 || $status >= 300) {
            error_log("[ApiClient] GET $path returned HTTP $status: " . (string) $body);
            return null;
        }

        $decoded = json_decode((string) $body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("[ApiClient] GET $path returned invalid JSON: " . json_last_error_msg());
            return null;
        }

        return $decoded;
    }

    /**
     * Shared "Nothing found" / error widget, used whenever the API is
     * unreachable or returns no data, matching the previous DB-driven markup.
     */
    public static function emptyWidget(): void
    {
        echo '<div id="widget" style="padding: 20px;">';
        echo '<div class="bd-callout bd-callout-info">';
        echo '<p>' . _('Nothing found.') . '</p>';
        echo '</div>';
        echo '</div>';
    }
}
