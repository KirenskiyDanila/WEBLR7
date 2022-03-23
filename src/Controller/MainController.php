<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\News;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $news = $doctrine->getRepository(News::class)->findAll();
        $data = array();
        for ($i = 0; $i < count($news); $i++) {
            $comments = $news[$i]->getComments();
            $data[$i]['name'] = $news[$i]->getName();
            $data[$i]['annotation'] = $news[$i]->getAnnotation();
            $data[$i]['date'] = $news[$i]->getDate();
            $data[$i]['commentCount'] = count($comments);
            $data[$i]['id'] = $news[$i]->getId();
        }

        $session = TemplateController::loadSession();

        $data = LogicController::sortDate($data);

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'data' => $data,
            'session' => $session
        ]);
    }

    #[Route('/news/{id}', name: 'app_news')]
    public function news(News $news, ManagerRegistry $doctrine): Response
    {
        $data = array();
        $comments = $news->getComments();
        $data['name'] = $news->getName();
        $data['text'] = $news->getText();
        $data['date'] = $news->getDate();
        $data['views'] = $news->getViews();
        $news->setViews($data['views'] + 1);
        $data['comments'] = array();
        for ($i = 0; $i < count($comments); $i++) {
            $data['comments'][$i]['date'] = $comments[$i]->getDate();
            $data['comments'][$i]['text'] = $comments[$i]->getText();
            $data['comments'][$i]['author'] = $comments[$i]->getAuthor()->getName();
            $data['comments'][$i]['role'] = $comments[$i]->getAuthor()->getRole();
        }

        $session = TemplateController::loadSession();

        $data['comments'] = LogicController::sortDate($data['comments']);

        $data['authorized'] = false;

        $entityManager = $doctrine->getManager();
        $entityManager->persist($news);
        $entityManager->flush();

        return $this->render('main/news.html.twig', [
            'controller_name' => 'MainController',
            'data' => $data,
            'session' => $session
        ]);
    }
}
