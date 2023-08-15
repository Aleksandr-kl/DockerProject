<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('test', name: 'app_test')]
    public function index(Request $request): JsonResponse
    {
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/TestController.php',
//        ]);
        //$test=['test'=>1];
        $requestData=json_decode($request->getContent(),true);

        return new JsonResponse();
    }

}
