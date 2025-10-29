<?php

namespace App\Data;

enum LinkType: string
{
    case TWITTER = 'twitter';
    case BLUESKY = 'bluesky';
    case PIXIV = 'pixiv';
    case TWITCH = 'twitch';
    case YOUTUBE = 'youtube';
    case VGEN = 'vgen';
    case INSTAGRAM = 'instagram';
    case EMAIL = 'email';
    case WEBSITE = 'website';

    public static function values(): array
    {
        return [
            self::TWITTER->value,
            self::BLUESKY->value,
            self::PIXIV->value,
            self::TWITCH->value,
            self::YOUTUBE->value,
            self::VGEN->value,
            self::INSTAGRAM->value,
            self::EMAIL->value,
            self::WEBSITE->value,
        ];
    }

    public static function getUrlPattern(self $type): string
    {
        return match ($type) {
            self::TWITTER => 'https://twitter.com/%s',
            self::BLUESKY => 'https://bsky.app/profile/%s',
            self::PIXIV => 'https://pixiv.net/en/users/%s',
            self::TWITCH => 'https://twitch.tv/%s',
            self::YOUTUBE => 'https://youtube.com/%s',
            self::VGEN => 'https://vgen.co/%s',
            self::INSTAGRAM => 'https://instagram.com/%s',
            default => '%s',
        };
    }
}
