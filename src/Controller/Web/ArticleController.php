<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

        return $this->render("article/article.html.twig", [
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

        return $this->render("bikeBlog/article.html.twig", [
            'article' => $article,
        ]);
    }
}