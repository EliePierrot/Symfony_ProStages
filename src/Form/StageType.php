<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Formation;


class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idStage')
            ->add('intitule')
            ->add('description')
            ->add('dateDebut')
            ->add('duree')
            ->add('competencesRequises')
            ->add('experienceRequise')
            ->add('entreprises', EntrepriseType::class)
            ->add('formations', EntityType::class, array(
                'class' => Formation::class,
                'choice_label' => function(Formation $formation)
                {return $formation->getIntitule();},

                // used to render a select box, check boxes or radios
                'multiple' => false,
                'expanded' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
