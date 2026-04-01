<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Enum\TaskPriority;
use App\Enum\TaskStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tasks = [
            [
                'title' => 'Mettre en place le CI/CD avec GitHub Actions',
                'description' => 'Configurer les pipelines pour les tests automatiques, le linting et le déploiement continu sur staging et production.',
                'status' => TaskStatus::Done,
                'priority' => TaskPriority::High,
                'dueDate' => '-5 days',
            ],
            [
                'title' => 'Concevoir la maquette de la page d\'accueil',
                'description' => 'Créer des wireframes et prototypes Figma pour la nouvelle landing page. Prévoir les versions desktop, tablette et mobile.',
                'status' => TaskStatus::Done,
                'priority' => TaskPriority::Medium,
                'dueDate' => '-10 days',
            ],
            [
                'title' => 'Refactoriser le module d\'authentification',
                'description' => 'Migrer de l\'ancienne implémentation vers Symfony Security 7 avec support OAuth2 et 2FA.',
                'status' => TaskStatus::InProgress,
                'priority' => TaskPriority::High,
                'dueDate' => '+3 days',
            ],
            [
                'title' => 'Rédiger la documentation de l\'API REST',
                'description' => 'Documenter tous les endpoints avec OpenAPI 3.0. Inclure les exemples de requêtes et réponses.',
                'status' => TaskStatus::InProgress,
                'priority' => TaskPriority::Medium,
                'dueDate' => '+7 days',
            ],
            [
                'title' => 'Optimiser les requêtes SQL lentes',
                'description' => 'Analyser les requêtes identifiées dans les logs (> 500ms). Ajouter des index et optimiser les jointures.',
                'status' => TaskStatus::InProgress,
                'priority' => TaskPriority::High,
                'dueDate' => '+2 days',
            ],
            [
                'title' => 'Écrire les tests d\'intégration pour le panier',
                'description' => 'Couvrir les scénarios : ajout produit, suppression, calcul des totaux avec TVA et promotions.',
                'status' => TaskStatus::Todo,
                'priority' => TaskPriority::Medium,
                'dueDate' => '+14 days',
            ],
            [
                'title' => 'Mettre à jour les dépendances PHP',
                'description' => 'Auditer et mettre à jour composer.json. Tester la compatibilité après mise à jour.',
                'status' => TaskStatus::Todo,
                'priority' => TaskPriority::Low,
                'dueDate' => '+21 days',
            ],
            [
                'title' => 'Implémenter la recherche full-text',
                'description' => 'Intégrer Meilisearch pour la recherche produits. Configurer l\'indexation automatique et les filtres.',
                'status' => TaskStatus::Todo,
                'priority' => TaskPriority::High,
                'dueDate' => '+10 days',
            ],
            [
                'title' => 'Réviser la politique de mots de passe',
                'description' => 'Mettre en conformité avec les recommandations ANSSI : longueur minimum, entropie, rotation.',
                'status' => TaskStatus::Todo,
                'priority' => TaskPriority::Medium,
                'dueDate' => '+5 days',
            ],
            [
                'title' => 'Créer le tableau de bord analytics',
                'description' => 'Visualisation des métriques clés : taux de conversion, panier moyen, funnel d\'achat. Utiliser Chart.js.',
                'status' => TaskStatus::Todo,
                'priority' => TaskPriority::Low,
                'dueDate' => null,
            ],
            [
                'title' => 'Configurer le monitoring avec Prometheus',
                'description' => 'Exposer les métriques applicatives et infrastructure. Configurer les alertes Grafana.',
                'status' => TaskStatus::Todo,
                'priority' => TaskPriority::Medium,
                'dueDate' => '+30 days',
            ],
            [
                'title' => 'Préparer la présentation technique pour le client',
                'description' => 'Slides de 20 min sur l\'architecture, les choix techniques et la roadmap Q3.',
                'status' => TaskStatus::InProgress,
                'priority' => TaskPriority::High,
                'dueDate' => '+1 days',
            ],
            [
                'title' => 'Auditer l\'accessibilité WCAG 2.1',
                'description' => 'Vérifier la conformité AA sur les pages principales. Générer le rapport et prioriser les corrections.',
                'status' => TaskStatus::Todo,
                'priority' => TaskPriority::Medium,
                'dueDate' => '+15 days',
            ],
            [
                'title' => 'Migrer la base de données vers PostgreSQL 17',
                'description' => 'Planifier la migration depuis v16. Tester les nouvelles fonctionnalités JSON et les index logiques.',
                'status' => TaskStatus::Todo,
                'priority' => TaskPriority::Low,
                'dueDate' => null,
            ],
            [
                'title' => 'Mettre en place le cache Redis',
                'description' => 'Configurer Redis pour les sessions, le cache Doctrine et les résultats de requêtes fréquentes.',
                'status' => TaskStatus::Done,
                'priority' => TaskPriority::High,
                'dueDate' => '-15 days',
            ],
            [
                'title' => 'Créer les emails transactionnels',
                'description' => 'Templates Twig pour : confirmation commande, réinitialisation mdp, bienvenue, facture PDF.',
                'status' => TaskStatus::Todo,
                'priority' => TaskPriority::Medium,
                'dueDate' => '+20 days',
            ],
            [
                'title' => 'Review de code du module paiement',
                'description' => 'Analyser l\'intégration Stripe. Vérifier la gestion des webhooks et la conformité PCI-DSS.',
                'status' => TaskStatus::InProgress,
                'priority' => TaskPriority::High,
                'dueDate' => '+0 days',
            ],
        ];

        foreach ($tasks as $data) {
            $task = new Task();
            $task->setTitle($data['title']);
            $task->setDescription($data['description']);
            $task->setStatus($data['status']);
            $task->setPriority($data['priority']);

            if ($data['dueDate'] !== null) {
                $task->setDueDate(new \DateTimeImmutable($data['dueDate']));
            }

            $manager->persist($task);
        }

        $manager->flush();
    }
}
