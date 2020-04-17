<?php

namespace AdBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('ads', [Runtime::class, 'retrieveAds']),
        ];
    }
}
