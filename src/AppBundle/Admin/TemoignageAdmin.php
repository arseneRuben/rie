<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TemoignageAdmin extends Admin {

    protected $baseRouteName = 'temoignage';
    protected $baseRoutePattern = 'temoignage';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
               
                ->add('auditeur', 'entity', array('class' => 'Application\Sonata\UserBundle\Entity\User', 'label' => 'auditeur'))
                ->add('contenu', 'text', array('label' => 'Contenu '))
                ->add('visibilite', 'choice', array(
                    'choices' => array(
                        0 => 'NON',
                        1 => 'OUI',
                    ),
                    'label' => 'Visibilité ?'))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('auditeur')
                ->add('visibilite')
               
                
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('auditeur')
                  ->add('contenu', 'text', array('label' => 'Contenu '))
                ->add('visibilite')
                 ->add('likeCount')
                ->add('dislikeCount')
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
                ))
               
        ;
    }
    
   
}
