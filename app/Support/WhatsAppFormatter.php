<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Helpers for composing WhatsApp messages.
 *
 * WhatsApp uses a lightweight markup:
 *   *bold*   _italic_   ~strikethrough~   ```monospace```
 *
 * These helpers make it safe and readable to build templated messages for
 * notifications, Starsender / WA gateway integrations, etc.
 */
final class WhatsAppFormatter
{
    /**
     * Wrap text in *bold* markup.
     */
    public static function bold(string $text): string
    {
        return '*'.$text.'*';
    }

    /**
     * Wrap text in _italic_ markup.
     */
    public static function italic(string $text): string
    {
        return '_'.$text.'_';
    }

    /**
     * Wrap text in ~strikethrough~ markup.
     */
    public static function strike(string $text): string
    {
        return '~'.$text.'~';
    }

    /**
     * Wrap text in ```monospace``` markup.
     */
    public static function mono(string $text): string
    {
        return '```'.$text.'```';
    }

    /**
     * Render a bullet list, one item per line.
     *
     * @param  array<int, string>  $items
     */
    public static function bulletList(array $items, string $bullet = '•'): string
    {
        return implode("\n", array_map(
            static fn (string $item): string => $bullet.' '.$item,
            $items,
        ));
    }

    /**
     * Fill a template, replacing {{key}} placeholders with the given values.
     *
     *   WhatsAppFormatter::template('Halo {{nama}}!', ['nama' => 'Febrian'])
     *   → 'Halo Febrian!'
     *
     * Whitespace inside the braces is tolerated: {{ nama }} works too.
     *
     * @param  array<string, string|int|float>  $vars
     */
    public static function template(string $template, array $vars): string
    {
        return (string) preg_replace_callback(
            '/\{\{\s*([a-zA-Z0-9_.]+)\s*\}\}/',
            static fn (array $m): string => array_key_exists($m[1], $vars)
                ? (string) $vars[$m[1]]
                : $m[0],
            $template,
        );
    }

    /**
     * Turn bare URLs into a slightly tidier presentation. WhatsApp already
     * auto-links URLs, so this mostly guarantees a scheme is present so links
     * become tappable.
     */
    public static function linkify(string $text): string
    {
        return (string) preg_replace_callback(
            '/(?<![\w\/])((?:https?:\/\/)?(?:www\.)[^\s]+|https?:\/\/[^\s]+)/i',
            static function (array $m): string {
                $url = $m[1];

                if (! preg_match('#^https?://#i', $url)) {
                    $url = 'https://'.$url;
                }

                return $url;
            },
            $text,
        );
    }
}
