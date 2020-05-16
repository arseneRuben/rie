<?php
namespace AppBundle\Admin;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Description of AnnonceAdmin
 *
 * @author ruben
 */
class AnnonceAdmin extends Admin {

    //put your code here
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->add('titre', 'text')
                ->add('annonceur', 'text')
                ->add('visibilite', 'checkbox', array(
                    'label' => 'Show this entry publicly?',
                    'required' => false,
                ))
                ->add('contenu', 'text')
                ->add('file', 'file', array('required' => false))
                  ->add('support', 'file', array('required' => false))
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('annonceur')
                ->add('titre');
                 
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('titre')
                ->add('imageName')
                 ->add('supportName')
                ->add('likeCount')
                ->add('dislikeCount')
                ->add('downloadCount')
                ->add('visibilite');
    }

    public function prePersist($annonce) {
        $this->saveFile($annonce);
        $this->saveSupport($annonce);
    }

    public function preUpdate($annonce) {
        $this->saveFile($annonce);
        $this->saveSupport($annonce);
    }

    public function saveFile($annonce) {
        $basepath = $this->getRequest()->getBasePath();
        $annonce->upload($basepath);
    }
     public function saveSupport($annonce) {
        $basepath = $this->getRequest()->getBasePath();
        $annonce->uploadSupport($basepath);
    }

}
