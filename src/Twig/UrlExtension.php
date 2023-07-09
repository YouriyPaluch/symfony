<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UrlExtension extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('faviconImage', [$this, 'getFaviconImgUrl']),
        ];
    }

    public function getFaviconImgUrl(string $url): string
    {
        $path = parse_url($url);
        return $path['scheme'] . '://' . $path['host'] . '/favicon.ico';
    }

}