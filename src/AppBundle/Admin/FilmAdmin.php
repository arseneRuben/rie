<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FilmAdmin extends Admin {

    protected $baseRouteName = 'film_admin';
    protected $baseRoutePattern = 'film_admin';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
               
             ->add('title', 'text', array('label' => 'Titre de la video'))
              
		    ->add('journalist', 'entity', array('class' => 'Application\Sonata\UserBundle\Entity\User', 'label' => 'Journalist presentateur'))

		  // ->add('category', 'entity', array('class' => 'AppBundle\Entity\Category','label' => 'Categorie de la video'))
		        ->add('path', 'text', array('label' => 'url source'))
		        ->add('keywords', 'text', array('label' => 'mots clés pour recherches '))
               


        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('title')
		       
		        ->add('journalist')
		   
                

        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('title')
		    ->add('dateDujour')
		        ->add('journalist')
		   ->add('path')
		    ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                      
                        'delete' => array(),
                    )
                ))


        ;
    }

   
    


}
