<?php

namespace App\Controller;
use App\Entity\Card;
use App\Entity\Tag;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Forms\CardType;
use App\Forms\LinkCategoryType;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Goutte\Client;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;



class cardController extends Controller
{
    public function index()
    {
      

      return $this->render('base.html.twig');

    }

  
	/**
     * @Route("/category/{id}/add_item", name="create_card")
     */
  public function create(Request $request,$id){


    $card = new Card();
    $tag = new Tag();
   
    $form = $this->createForm(CardType::class, $card);
    $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
		$entityManager = $this->getDoctrine()->getManager();
    $category = $entityManager->getRepository(Category::class)->find($id);
    $card->setCategory($category);

			$entityManager->persist($card);

			$url = $card->getUrl();
			$client = new Client();
			$crawler = $client->request('GET', $url);

			$image = $crawler->filterXpath('//meta[@property="og:image"]')->attr('content');
			$title = $crawler->filter('title')->text();
			$card->setName($title);
      $card->setImg($image);
		
		//	var_dump($image);

			$entityManager->flush();
			//scrapping infos from url
		
			  return new Response('Saved new card with id '.$card->getId());
		}
    //return new response(array('form' => $form->createView()));

        return $this->render('forms/create.html.twig',
        	['form'=>$form->createView()]);
  }


/**
 * @Route("card/{id}/{field}", name="demo_new")
 * @Method("GET")
 */
public function displayGeneriqForm(Request $request,$id,$field)
{

    $entityManager = $this->getDoctrine()->getManager();
    $card = $entityManager->getRepository(Card::class)->find($id);
    $form = $this->createForm(CardType::class, $card, array(
      
        'field' => $field,
    ));

    return $this->render('test.html.twig',
                    array(
                'card' => $card,
                'form' => $form->createView(),
                'field'=>$field
                    )
    );
}

/**
 
 * @Route("/test/{id}/{field}", name="demo_create")
 * @Method("POST")
 *
 */
public function submitGeneriqForm(Request $request,$id,$field)
{
    //This is optional. Do not do this check if you want to call the same action using a regular request.
   if (!$request->isXmlHttpRequest()) {
       return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
    }
   
    $entityManager = $this->getDoctrine()->getManager();
    $card = $entityManager->getRepository(Card::class)->find($id);
 


    $form = $this->createForm(CardType::class, $card, array(
      
        'field' => $field,
    ));
    $form->handleRequest($request);

    if ($form->isSubmitted()) {
        $em = $this->getDoctrine()->getManager();

         
        $em->persist($card);
        $em->flush();
         
        return new JsonResponse(array('message' => 'Success!'), 200);
    }

    $response = new JsonResponse(
            array(
        'message' => 'Error',
        'form' => $this->render('forms/'.$field.'.html.twig',
                array(
            'card' => $card,  
            'form' => $form->createView(),
            "id"=>$id,''
        ))), 400);

    return $response;
}






/**
     * @Route("category/{id}/card/{cardid}/editnotes", name="edit_notes")
     */
  public function editNotes(Request $request,$id,$cardid){

    $entityManager = $this->getDoctrine()->getManager();
    $card = $entityManager->getRepository(Card::class)->find($cardid);
    $category = $entityManager->getRepository(Category::class)->find($id);
    $form = $this->createFormBuilder($card)
            ->add('notes', TextAreaType::class,array('label' => false))
            ->add('save', SubmitType::class, array('label' => 'Valider'))
            ->getForm();
    $form->handleRequest($request);
     $status = "";
    if ($form->isSubmitted() && $form->isValid()) {
      
      $card->setNotes($form->getData()->getNotes());
      $entityManager->persist($card);
      $entityManager->flush();
 
    
        return new Response('Saved new card with id '.$card->getId());
    }

       return new JsonResponse(array('status' => $status));
  }

  


  
  /**
     * @Route("category/{id}/card/{cardid}/linksubcategory", name="link_subcategory")
     */
  public function linkSubCategory(Request $request,$id,$cardid){

   
    $entityManager = $this->getDoctrine()->getManager();
    $card = $entityManager->getRepository(Card::class)->find($cardid);

    $id = $card->getCategory()->getId();
   

    // find all subcategories
    $allCurrentSubCategories = $entityManager->getRepository(SubCategory::class)->findAll();
    $acscArray=[];
    foreach ($allCurrentSubCategories as $allCurrentSubCategory) {
      // add them to an array 
      $acscArray[]=$allCurrentSubCategory;
    }
 
    for ($i=0; $i <count($acscArray) ; $i++) { 
      //unlink allcurrentsubcategories $card->getSubcategories =[empty]
      $card->removeSubCategory($acscArray[$i]);

    }
    // create form
    $form = $this->createForm(LinkCategoryType::class, $card);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      // get submitted values to an array
  
      $subcategoryvalues = $card->getSubCategories()->getValues();
      $allsubcategories=[];

      foreach ($subcategoryvalues as $subcategoryvalue ) {
   
        $subcategory= $entityManager->getRepository(SubCategory::class)->find($subcategoryvalue);
        $allsubcategories[]=$subcategory;

      }
    dump($acscArray);
    dump($allsubcategories);

   
      if (!empty($allsubcategories)) {

       

         foreach($allsubcategories as $key =>$value) {

    $card->setSubCategories($allsubcategories[$key]);



         }
   /*
        for ($i=0; $i <count($allsubcategories) ; $i++) { 
          // Link submitted values
        if (array_key_exists($i, $allsubcategories)) {
                unset($allsubcategories[$i]);
                dump($allsubcategories[$i]);
            }
         
          $card->setSubCategories($allsubcategories[$i]);

        }*/
         
      }  
  $entityManager->persist($card);
    
      $entityManager->flush();

      return new Response('Saved card with id '.$card->getId());
    }

        return $this->render('forms/card_step1.html.twig',
          ['form'=>$form->createView(),]);
  }



/**
     * @Route("card/{cardid}", name="create_show")
     */
  public function show($cardid){
  	$entityManager = $this->getDoctrine()->getManager();
  	$card = $entityManager->getRepository(Card::class)->find($cardid);
    $id = $card->getCategory();
    

  return $this->render('cards/card.html.twig',
        	['card'=>$card,
          'subcategories'=>$card->getSubcategories(),
          'category'=>$card->getCategory()]);

  }
}