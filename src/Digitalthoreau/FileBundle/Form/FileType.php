<?php

namespace Digitalthoreau\FileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('manuscript_image')  
            ->add('manuscript_image', 'entity', array('class' => 'DigitalthoreauFileBundle:File','property'=>'name', 'query_builder' => 
                 function(\Digitalthoreau\FileBundle\Entity\FileRepository $er) {
                 return $er->createQueryBuilder('f')
                 ->where('f.type=4')        
                 ->orderBy('f.name', 'ASC');
                 }))    
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Digitalthoreau\FileBundle\Entity\File'
        ));
    }

    public function getName()
    {
        return 'digitalthoreau_filebundle_filetype';
    }
}
