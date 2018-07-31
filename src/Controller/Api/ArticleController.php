<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use App\Entity\Article;

class ArticleController extends FosRestController
{

    /**
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\Post("/article")
     */
    public function postArticle(Request $request): View
    {
        $article = new Article();
        $article->setName($request->get('name'));
        $article->setText($request->get('text'));
        $article->setUpdateAt($request->get('updateAt'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return View::create($article, Response::HTTP_CREATED);
    }

    /**
     * @param  $id
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\Get("/article/{id}")
     */
    public function getArticle(int $id): View
    {

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneById($id);

        return View::create($article, Response::HTTP_OK);
    }

}