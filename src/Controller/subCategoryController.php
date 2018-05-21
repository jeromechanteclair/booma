<?php

namespace App\Controller;
use App\Entity\SubCategory;
use App\Entity\Category;
use App\Forms\SubCategoryType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class subCategoryController extends Controller
{
  
  
	/**
     * @Route("/category/{id}/addsub", name="create_subcategory")
     */
  public function create(Request $request,$id){


    $subCategory = new SubCategory();

    $form = $this->createForm(SubCategoryType::class, $subCategory);
    $form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
      $category = $entityManager->getRepository(Category::class)->find($id);
      $subCategory->setCategory($category);
			$entityManager->persist($subCategory);
		
		

			$entityManager->flush();
			//scrapping infos from url
		
			





			  return new Response('Saved new category with id '.$subCategory->getId());
		}

     

        return $this->render('forms/addsub.html.twig',
        	['form'=>$form->createView(),]);
  }
/**
     * @Route("/subcategory/{id}", name="subcategory_show")
     */
  public function show($id){
  	$entityManager = $this->getDoctrine()->getManager();
  	$subCategory = $entityManager->getRepository(SubCategory::class)->find($id);
  

  return $this->render('category/single.html.twig',
        	['subCategory'=>$subCategory,]);

  }
}