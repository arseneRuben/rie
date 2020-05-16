<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class EnquiryAdmin extends Admin {

    protected $baseRouteName = 'message';
    protected $baseRoutePattern = 'message';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('emetteur', 'entity', array('class' => 'Application\Sonata\UserBundle\Entity\User', 'label' => 'auditeur'))
                ->add('subject', 'choice', array(
                    'choices' => array(
                        'priere' => 'SUJET DE PRIERE',
                        'temoignage' => 'TEMOIGNAGE',
                        'participation' => 'PARTICIPER A L EMISSION EN COURS',
                        'suggestion' => 'SUGGESTION',
                        'don' => 'FAIRE UN DON',
                        'autres' => 'AUTRES'
                    ),
                    'label' => 'Objet'))
                ->add('body', 'text', array('label' => 'Message '))
                 ->add('dateEnvoie', 'sonata_type_date_picker', array('label' => 'Date d envoie'))
                
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('emetteur')
                ->add('subject')
                ->add('dateEnvoie')


        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('emetteur')
                
                ->add('subject')
                ->add('dateEnvoie')
                ->add('body', 'text', array('label' => 'Message') )
                ->add('_action', 'actions', array(
                    'actions' => array(
                       
                        'delete' => array(),
                    )
                ))

        ;
    }

}
