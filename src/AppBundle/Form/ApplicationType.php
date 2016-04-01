<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Form\PassportType;

class ApplicationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userNumber', null, array(
                "label" => "label.user.number"
            ))
            ->add('birthdate', DateType::class, array(
                'widget' => 'text',
                'format' => 'dd-MM-yyyy',
            ))
            ->add('activity', EntityType::class, array(
                'class' => 'AppBundle:Activity',
                'choice_label' => 'name'
            ))
            ->add('zip', TextType::class, array(
                "mapped" => false
            ))
            ->add('city', EntityType::class, array(
                'class'       => 'AppBundle:City',
                'placeholder' => '',
                'choice_label' => 'name',
                'choices'     => $options['cities'],
            ))

            ->add('receiveNews')
            ->add('email')
            ->add('passport', PassportType::class, array(
                "label" => false
            ))
        ;

        /*
        $formModifier = function (FormInterface $form, $cities) {
            $form->add('city', EntityType::class, array(
                'class'       => 'AppBundle:City',
                'placeholder' => '',
                'choice_label' => 'name',
                'choices'     => $cities,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formModifier($event->getForm(), array());
            }
        );

        $builder->get('zip')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $zip = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $zip);
            }
        );
        */
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Application',
            'cities' => null
        ));
    }
}
