<?php

namespace AppBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnquiryType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nameEmetteur','text', array('label' => 'Nom', 'required'=>'required'))
                ->add('emailEmetteur', 'email',array('label' => 'Adresse email', 'required'=>'required'))
                ->add('subject', ChoiceType::class, array(
                    'choices' => array(
                        'priere' => 'SUJET DE PRIERE',
                        'temoignage' => 'TEMOIGNAGE',
                        'participation' => 'PARTICIPER A L EMISSION EN COURS',
                        'suggestion' => 'SUGGESTION',
                         'don' => 'FAIRE UN DON',
                        'autres' => 'AUTRES'
                       
                    ),'label' => 'Objet'))
                ->add('body', 'textarea', array('label' => 'Message', 'required'=>'required'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Enquiry'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_enquiry';
    }

}
