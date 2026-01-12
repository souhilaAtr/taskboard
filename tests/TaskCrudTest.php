<?php

namespace App\Tests;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TaskCrudTest extends WebTestCase
{
    public function testCreateTaskThroughCrudForm(): void
    {
        $client = static::createClient();

        // 1) Ouvrir la page "new"
        $crawler = $client->request('GET', '/task/new');
        $this->assertResponseIsSuccessful();

        // 2) Récupérer le formulaire via le bouton "Save"
        $form = $crawler->selectButton('Save')->form();

        // 3) Remplir le champ title (obligatoire)
        $form['task[title]'] = 'Test task';

        // 4) Soumettre
        $client->submit($form);

        // 5) Le CRUD redirige (souvent vers /task/)
        $this->assertResponseRedirects();

        // 6) Vérifier en base (DB test) que la tâche existe
        $repo = static::getContainer()->get(TaskRepository::class);
        $tasks = $repo->findBy(['title' => 'Test task']);

        $this->assertCount(1, $tasks);
    }
}
