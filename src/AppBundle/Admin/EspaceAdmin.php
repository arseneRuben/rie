<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class EspaceAdmin extends Admin {

    protected $baseRouteName = 'espace';
    protected $baseRoutePattern = 'espace';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('debut', 'time', array('label' => 'Début de l emission H - Min','attr' => array('class' => 'fixed-time')))
                ->add('fin', 'time', array('label' => 'Fin de l emission  H - Min','attr' => array('class' => 'fixed-time')))
                ->add('journee', 'choice', array(
                    'choices' => array(
                        'dim' => 'Dimanche',
                        'lun' => 'Lundi',
                        'mar' => 'Mardi',
                        'mer' => 'Mercredi',
                        'jeu' => 'Jeudi',
                        'ven' => 'Vendredi',
                        'sam' => 'Samedi',
                    ),
                    
                    'label' => 'Journée'))
              
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('debut')
                ->add('fin')
                ->add('emission')
                ->add('journee')
                
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('emission')
                ->add('debut')
                ->add('fin')
                ->add('journee')

        ;
    }

   
}
