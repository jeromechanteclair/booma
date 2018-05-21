<?php

namespace App\Controller;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Card;
use App\Forms\CategoryType;
use App\Forms\CardType;
use Goutte\Client;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\JsonResponse;
class categoryController  extends FOSRestController
{
  
  
	/**
     * @Route("/createcategory", name="create_category")
     */
  public function create(Request $request){


    $category = new Category();

    $form = $this->createForm(CategoryType::class, $category);
    $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($category);
		
		

			$entityManager->flush();
			//scrapping infos from url
		
			





			  return new Response('Saved new category with id '.$category->getId());
		}

     

        return $this->render('forms/create.html.twig',
        	['form'=>$form->createView(),]);
  }
   


    /**
     * @Route("/dashboard/{slug}/", name="display_category")
     */
    public function displayOneCategory(Request $request,$slug){
       
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)
        ->findOneBy(array('name' => $slug));
        // Create new cardForm
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //link new card to category
            $card->setCategory($category);
            //Scrap informations from url
            $url = $card->getUrl();
            $client = new Client();
            $crawler = $client->request('GET', $url);

            $image = $crawler->filterXpath('//meta[@property="og:image"]')->attr('content');
            $title = $crawler->filter('title')->text();
            $card->setName($title);
            $card->setImg($image);
            $em->persist($card);
            //Add new card to DB
            $em->flush(); 
        }
      

        return $this->render('category/single.html.twig',[

        'category'=>$category,
        'form'=>$form->createView()]
        );


   }

    /**
     * @Get(
     *     path = "/category/{id}/",
     *     name = "category_show",
     *     requirements = {"id"="\d+"}
     * )
     * 
     */


  public function showSingleData($id){
    $entityManager = $this->getDoctrine()->getManager();
    $category_items = $entityManager->getRepository(Category::class)->find($id);
    $serializer = $this->container->get('serializer');
    $response = new Response($serializer->serialize($category_items, 'json',array('groups' => array('category_items'))),Response::HTTP_OK);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }
  
    /**
     * @Get(
     *     path = "/categorylist",
     *     name = "category_list",
     * )
     */
  public function list(){

    $entityManager = $this->getDoctrine()->getManager();
    $category = $entityManager->getRepository(Category::class)->findAll();
    $serializer = $this->container->get('serializer');
    $response = new Response($serializer->serialize($category, 'json',array('groups' => array('category_list'))),Response::HTTP_OK);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }


}