<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EmissionAdmin extends Admin {

    protected $baseRouteName = 'emission_admin';
    protected $baseRoutePattern = 'emission_admin';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('nom', 'text', array('label' => 'Nom de l emission'))
                ->add('espaces', EntityType::class, array('class' => 'AppBundle\Entity\Espace',
                    'label' => 'Espace horaire de l émission',
                    'multiple' => true,
                    'by_reference' => false
                ))
                ->add('description', 'text', array('label' => 'Description de l émission'))
                ->add('file', 'file', array('required' => false))
                ->add('interactif', 'choice', array(
                    'choices' => array(
                        0 => 'NON',
                        1 => 'OUI',
                    ),
                    'label' => 'Emission interactif ?'))


        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('nom')
                ->add('espaces')
                ->add('interactif')

        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('nom')
                ->add('interactif')
                ->add('imageName')
                ->add('espaces', 'sonata_type_collection', array(
                    'by_reference' => false
                ))
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                      
                        'delete' => array(),
                    )
                ))


        ;
    }

    public function prePersist($emission) {
        $this->saveFile($emission);
    }

    public function preUpdate($emission) {
        $this->saveFile($emission);
    }

    public function saveFile($emission) {
        $basepath = $this->getRequest()->getBasePath();
        $emission->upload($basepath);
    }

     private function manageFileUpload($emission)
    {
        if ($emission->getFile()) {
            $emission->refreshUpdated();
        }
    }


}
