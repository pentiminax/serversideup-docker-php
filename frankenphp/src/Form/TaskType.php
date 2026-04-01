<?php

namespace App\Form;

use App\Entity\Task;
use App\Enum\TaskPriority;
use App\Enum\TaskStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Ex: Réviser la documentation API',
                    'class' => 'input-field',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Décrivez la tâche en détail...',
                    'class' => 'input-field',
                ],
            ])
            ->add('status', EnumType::class, [
                'label' => 'Statut',
                'class' => TaskStatus::class,
                'choice_label' => fn(TaskStatus $status) => $status->label(),
                'attr' => ['class' => 'input-field'],
            ])
            ->add('priority', EnumType::class, [
                'label' => 'Priorité',
                'class' => TaskPriority::class,
                'choice_label' => fn(TaskPriority $priority) => $priority->label(),
                'attr' => ['class' => 'input-field'],
            ])
            ->add('dueDate', DateType::class, [
                'label' => 'Date d\'échéance',
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'input-field'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
