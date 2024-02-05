<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use GuzzleHttp\Psr7\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $category): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $cat = $category->findAllAlphabeticallyWithContactCount();
        dump($cat);
        return $this->render('category/index.html.twig', [
            'categories' => $cat
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show',requirements: ['id' => '\d+'])]
    #[ParamConverter('category', options: ['mapping'=>['id'=>'id']])]
    public function show(Category $category)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('contact/index.html.twig', [
            'lstContacts' => $category->getContacts(),
            'show_category'=>false,
        ]);
    }
}
