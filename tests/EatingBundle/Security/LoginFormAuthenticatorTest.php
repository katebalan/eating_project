<?php

namespace EatingBundle\Security;;

use EatingBundle\Security;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Test\DoctrineTestHelper;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\Routing\RouterInterface;
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//use EatingBundle\Entity\User;
use EatingBundle\Security\LoginFormAuthenticator;
use EatingBundle\Test\ContainerDependableTestCase;
//use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
//use AppBundle\Test\ContainerDependableTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;

class LoginFormAuthenticatorTest extends  WebTestCase
{
	// private $client = null;
	// private $_container= null;
	protected $_container;
	private $em;

    private function mockEntityManager()
    {
        //mock the entityManager
        $emMock = $this->getMock('\Doctrine\ORM\EntityManager',['getEventManager', 'persist', 'update','remove', 'flush'],  [],  '', false  );

        return $emMock;
    }


    public function testAdd()
    {
            
      /*  self::bootKernel();
        $this->_container = static::$kernel->getContainer();
	
 //$em = DoctrineTestHelper::createTestEntityManager();

        $em = $this->getDoctrine()->getManager();
	$loginAuthenticator = new LoginFormAuthenticator(
            $this->_container->get('form.factory'),
            $this->_container->get(/*'em'/$em ),
            $this->_container->get('router'),
            $this->_container->get('security.password_encoder')
        );

/*       $user = new User();
        $user->setEmail('bar@foo.com')
            ->setPlainPassword('barfoo')
            ->setDefaultTwoFactorMethod('email')
            ->setTwoFactorCode('1234')
            ->setTwoFactorAuthentication(false)
            ->setRoles(['ROLE_USER']);

        $this->_container->get('doctrine')->getManager()->persist($user);
        $this->_container->get('doctrine')->getManager()->flush();

        $post = ['login_form' => ['_username' => 'bar@foo.com', '_password' => 'barfoo']];
        $request = new Request([], $post);
        $request->setSession($this->_container->get('session'));
        $request->server->set('REQUEST_URI', '/login');
        $request->setMethod('POST');

        $credentials = $loginAuthenticator->getCredentials($request);
        $this->assertInternalType('array', $credentials);
        $this->assertArrayHasKey('_username', $credentials);
        $this->assertArrayHasKey('_password', $credentials);

        $authUser = $loginAuthenticator->getUser(
            $credentials,
            $this->_container->get('security.user.provider.concrete.our_users')
        );

        $this->assertNotNull($authUser);
        $this->assertInstanceOf('AppBundle\Entity\User', $authUser);

        $this->assertTrue($loginAuthenticator->checkCredentials($credentials, $authUser));

        $anotherUser = new User();
        $anotherUser->setEmail('admin@foo.com')
            ->setPlainPassword('adminfoo')
            ->setDefaultTwoFactorMethod('email')
            ->setTwoFactorCode('1234')
            ->setTwoFactorAuthentication(false)
            ->setRoles(['ROLE_ADMIN']);

        $this->assertFalse($loginAuthenticator->checkCredentials($credentials, $anotherUser));

        $nonLoginRequest = new Request();
        $credentials = $loginAuthenticator->getCredentials($nonLoginRequest);

        $this->assertNull($credentials);
*/
	   }
}
