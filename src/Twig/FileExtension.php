<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * This Twig extension adds a new 'file_exist' filter to easily check exist file.
 */
class FileExtension extends AbstractExtension
{

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('file_exists', 'file_exists')
        ];
    }
}
