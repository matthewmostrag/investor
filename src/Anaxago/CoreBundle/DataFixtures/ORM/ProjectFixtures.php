<?php declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 14/07/18
 * Time: 15:21
 */

namespace Anaxago\CoreBundle\DataFixtures\ORM;

use Anaxago\CoreBundle\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @licence proprietary anaxago.com
 * Class ProjectFixtures
 * @package Anaxago\CoreBundle\DataFixtures\ORM
 */
class ProjectFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getProjects() as $project) {
            $projectToPersist = (new Project())
                ->setTitle($project['name'])
                ->setDescription($project['description'])
                ->setSlug($project['slug'])
                ->setCover($project['cover'])
                ->setFundingLimit($project['funding_limit'])
                ->setArchived($project['archived'] ?? false);
            $manager->persist($projectToPersist);
        }
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getProjects(): array
    {
        return [
            [
                'name' => 'Fred de la compta',
                'description' => 'Dépoussiérer la comptabilité grâce à l\'intelligence artificielle',
                'slug' => 'fred-compta',
                'cover' => '2018/07/9ab89c0cce6c4b2b0fc387fa1312b3fa.png',
                'funding_limit' => 4000000
            ],
            [
                'name' => 'Mojjo',
                'description' => 'L\'intelligence artificielle au service du tennis : Mojjo transforme l\'expérience des joueurs et des fans de tennis grâce à une technologie unique de captation et de traitement de la donnée',
                'slug' => 'mojjo',
                'cover' => '2018/07/3ce260323c4eb7d090f7fc940cacfe37.png',
                'funding_limit' => 600000
            ],
            [
                'name' => 'Eole',
                'description' => 'Projet de construction d\'une résidence de 80 logements sociaux à Petit-Bourg en Guadeloupe par le promoteur Orion.',
                'slug' => 'eole',
                'cover' => '2018/07/ac3a0d9c09ee0a44df1a5925951b02eb.png',
                'funding_limit' => 800000,
                'archived' => true
            ],
            [
                'name' => 'The Graduates II',
                'description' => '[Éligible Réduction IR] The Graduates II est une holding participative qui vous permet d’investir dans...',
                'slug' => 'the-graduates',
                'cover' => '2018/07/421fb2db6fd218f43bb68f3f9a68063d.jpeg',
                'funding_limit' => 1000000
            ],
        ];
    }
}
