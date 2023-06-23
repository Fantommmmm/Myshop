<?php

namespace App\Test\Controller;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MembreControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MembreRepository $repository;
    private string $path = '/membre/crud/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Membre::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Membre index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'membre[email]' => 'Testing',
            'membre[roles]' => 'Testing',
            'membre[password]' => 'Testing',
            'membre[pseudo]' => 'Testing',
            'membre[nom]' => 'Testing',
            'membre[prenom]' => 'Testing',
            'membre[civilite]' => 'Testing',
            'membre[date_enregistrement]' => 'Testing',
        ]);

        self::assertResponseRedirects('/membre/crud/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Membre();
        $fixture->setEmail('My Title');
        $fixture->setRoles('My Title');
        $fixture->setPassword('My Title');
        $fixture->setPseudo('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setCivilite('My Title');
        $fixture->setDate_enregistrement('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Membre');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Membre();
        $fixture->setEmail('My Title');
        $fixture->setRoles('My Title');
        $fixture->setPassword('My Title');
        $fixture->setPseudo('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setCivilite('My Title');
        $fixture->setDate_enregistrement('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'membre[email]' => 'Something New',
            'membre[roles]' => 'Something New',
            'membre[password]' => 'Something New',
            'membre[pseudo]' => 'Something New',
            'membre[nom]' => 'Something New',
            'membre[prenom]' => 'Something New',
            'membre[civilite]' => 'Something New',
            'membre[date_enregistrement]' => 'Something New',
        ]);

        self::assertResponseRedirects('/membre/crud/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getRoles());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getPseudo());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getCivilite());
        self::assertSame('Something New', $fixture[0]->getDate_enregistrement());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Membre();
        $fixture->setEmail('My Title');
        $fixture->setRoles('My Title');
        $fixture->setPassword('My Title');
        $fixture->setPseudo('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setCivilite('My Title');
        $fixture->setDate_enregistrement('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/membre/crud/');
    }
}
