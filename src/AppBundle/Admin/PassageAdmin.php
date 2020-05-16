<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PassageAdmin extends Admin {

    protected $baseRouteName = 'passage';
    protected $baseRoutePattern = 'passage';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('dateDujour', 'sonata_type_date_picker', array('label' => 'Debut du jour'))
                ->add('emission', 'entity', array('class' => 'AppBundle\Entity\Emission', 'label' => 'Emission')) 
                ->add('espace', 'entity', array('class' => 'AppBundle\Entity\Espace', 'label' => 'Espace de l emission'))
                ->add('journalist', 'entity', array('class' => 'Application\Sonata\UserBundle\Entity\User', 'label' => 'Journalist presentateur'))
                ->add('file', 'file', array('required' => false))  
                ->add('keywords', 'text', array('label' => 'mots clés pour recherches '))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('dateDujour')
                ->add('emission')
                ->add('journalist')
                
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('emission')
                ->add('dateDujour')
                ->add('espace')
                 ->add('likeCount')
                ->add('dislikeCount')
                ->add('downloadCount')
                ->add('journalist')
                ->add('keywords')
                ->add('_action', 'actions', array(
                    'actions' => array(
                    
                        'edit' => array(),
                        'delete' => array(),
                    )
                ))
               
        ;
    }
    
     public function prePersist($passage) {
        $this->saveFile($passage);
    }

    public function preUpdate($passage) {
        $this->saveFile($passage);
    }

    public function saveFile($passage) {
        $basepath = $this->getRequest()->getBasePath();
        $passage->upload($basepath);
    }
   
}
