<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

final class MercureController extends AbstractController
{
    public function __construct(public HubInterface $hub) {}

    #[Route('/push', name: 'app_push')]
    public function index(): Response
    {
        $update = new Update(
            'https://example.com/books/1',
            json_encode(['status' => 'OutOfStock']),
            // true
        );

        $this->hub->publish($update);

        return new Response('published!');
    }
}
