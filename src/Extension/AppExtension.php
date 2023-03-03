<?php

namespace App\Extension;

use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private CategoryRepository $categoryRepository) {}
    public function getFunctions()
    {
        return [
            new TwigFunction('getCategories', [$this, 'getCategories']),
        ];
    }

    public function getCategories()
    {
        return $this->categoryRepository->findAll();
    }
}