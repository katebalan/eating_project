<?php

namespace Tests\EatingBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DoctrineTestCase
 * @package Tests\IMS
 *
 * This is the base class to load doctrine fixtures using the symfony configuration
 */
class DoctrineTestCase extends WebTestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $environment = 'test';

    /**
     * @var bool
     */
    protected $debug = true;

    /**
     * @var string
     */
    protected $entityManagerServiceId = 'doctrine.orm.entity_manager';

    /**
     * Constructor
     *
     * @param string|null $name     Test name
     * @param array       $data     Test data
     * @param string      $dataName Data name
     */
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        if (!static::$kernel) {
            static::$kernel = self::createKernel(array(
                'environment' => $this->environment,
                'debug'       => $this->debug
            ));
            static::$kernel->boot();
        }

        $this->container = static::$kernel->getContainer();
        $this->em = $this->getEntityManager();
    }

    /**
     * Returns the doctrine orm entity manager
     *
     * @return object
     */
    protected function getEntityManager()
    {
        return $this->container->get($this->entityManagerServiceId);
    }
}
