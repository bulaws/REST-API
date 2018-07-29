<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleType;
use App\Entity\Article;

class ArticleController extends AbstractController
{
    /**
     * Rendering article page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showArticles() : Response
    {

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render("article/articles.html.twig", [
            'articles' => $articles
        ]);
    }

    /**
     * Rendering article page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showArticle($id) : Response
    {

        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        return $this->render("article/article.html.twig", [
            'article' => $article,
        ]);
    }

    public function createArticle(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class,  $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var $newArticle Article */
            $newArticle = $form->getData();
            $newArticle->setUpdateAt();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newArticle);
            $em->flush();
            return $this->redirectToRoute('blog');
        }
        return $this->render('article/createArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function updateArticle(Request $request,Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('blog');
        }
        return $this->render('article/updateArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
}