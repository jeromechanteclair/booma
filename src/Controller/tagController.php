<?php

namespace App\Controller;
use App\Entity\Tag;
use App\Forms\TagType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Goutte\Client;
use FOS\RestBundle\Controller\Annotations\Get;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
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
		
			





			  return new Response('Saved new tag with id '.$tag->getId());
		}

     

        return $this->render('forms/create.html.twig',
        	['form'=>$form->createView(),]);
  }
    /**
     * @Route("/tag/{id}/list", name="tag_list")
     */
  public function getalltaggedcards($id){

  	$entityManager = $this->getDoctrine()->getManager();
  	$tag = $entityManager->getRepository(Tag::class)->find();
    $tagitems = $tag->getCards();
   // var_dump($tagitems);

  return $this->render('tags/list.html.twig',
        	['tagitems'=>$tagitems,]);

  }
     /**
     * @Get(
     *     path = "/tags/",
     *     name = "tags_list",
     *  
     * )
     * 
     */


  public function list(){
    $entityManager = $this->getDoctrine()->getManager();
    $tags = $entityManager->getRepository(Tag::class)->findAll();
    $serializer = SerializerBuilder::create()->build();


    $response = new Response( $serializer->serialize($tags, 'json', SerializationContext::create()->setGroups(array('tags'))),Response::HTTP_OK);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }



}