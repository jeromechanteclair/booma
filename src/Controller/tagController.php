<?php

namespace App\Controller;
use App\Entity\Tag;
use App\Forms\TagType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Goutte\Client;
class tagController extends Controller
{
    public function index()
    {
      

      return $this->render('base.html.twig');

    }

  
	/**
     * @Route("/createtag", name="create_tag")
     */
  public function create(Request $request){


        $tag = new tag();
        $form = $this->createForm(TagType::class, $tag);
		    $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($tag);
			

			$entityManager->flush();
			//scrapping infos from url
		
			





			  return new Response('Saved new card with id '.$tag->getId());
		}

     

        return $this->render('forms/create.html.twig',
        	['form'=>$form->createView(),]);
  }
    /**
     * @Route("/tag/{id}/list", name="tag_list")
     */
  public function list($id){

  	$entityManager = $this->getDoctrine()->getManager();
  	$tag = $entityManager->getRepository(Tag::class)->find($id);
    $tagitems = $tag->getCards();
   // var_dump($tagitems);

  return $this->render('tags/list.html.twig',
        	['tagitems'=>$tagitems,]);

  }
}