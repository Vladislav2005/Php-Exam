<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\NewsType;



class NewsController extends AbstractController
{
    #[IsGranted('ROLE_MANAGER')]
    #[Route('/news/create', name: 'news_create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $news->setSlug(str_replace(" ","_",$news->getTitle()));
            $em->persist($news);
            $em->flush();
            return $this->redirectToRoute('news', [
            ]);
        }

        return $this->render('news_create.html.twig', [
            'news' => $em->getRepository(News::class)->findAll(),
            'form' => $form->createView(),
        ]);
    }


    #[Route('/news', name: 'news', methods: ['GET'])]
    public function view(EntityManagerInterface $em)
    {

        return $this->render('news.html.twig', [
            'form'     => $this->createForm(NewsType::class)->createView(),
            "news" => $em ->getRepository(News::class)->findAll()
        ]);
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new/delete/{new}', name: 'new_delete', requirements: ['new' => '\d+'])]
    public function delete(News $new, EntityManagerInterface $em)
    {
        $em->remove($new);
        $em->flush();
        return $this->redirectToRoute('news');
    }


    #[IsGranted('ROLE_MANAGER')]
    #[Route('/news/edit/{news}', name: 'news_edit', requirements: ['news' => '\d+'])]
    public function edit(News $new, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ChatType::class, $new);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($new);
            $em->flush();
            return $this->redirectToRoute('news');
        }

        return $this->render('news_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/news/category/{slug}', name: 'news_category', methods: ['GET'])]
    public function viewCategory(EntityManagerInterface $em, Category $category) // показывает новости на определенную категорию
    {
        return $this->render('category_news.html.twig', [
            'form'     => $this->createForm(NewsType::class)->createView(),
            "news" => $em ->getRepository(News::class)->findBy(['category' => $category]),
        ]);
    }

    #[Route('/news/exact/{slug}', name: 'exact_news', requirements: ['news' => '\d+'])]
    public function exact_news(EntityManagerInterface $em, News $news)
    {
        return $this->render('exact_news.html.twig', [
            'form' => $this->createForm(NewsType::class)->createView(),
            "news" => $news,
        ]);
    }

}