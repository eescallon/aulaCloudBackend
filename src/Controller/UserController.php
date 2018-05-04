<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\User;

class UserController extends Controller
{
	/**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setEmail('user');
        $user->setPassword("pass");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

	/**
     * @Route("/login", name="login")
     */
	public function login()
	{
		//Obtengo el encoder
		$encoders = array(new JsonEncoder());
		//Obtengo el normalizer
        $normalizers = array(new ObjectNormalizer());
        //Creo el serializer
        $serializer = new Serializer($normalizers, $encoders);
        //Obtengo el repositorio de la clase user para hacer las consultas
        $repository = $this->getDoctrine()->getRepository(User::class);
        //Hago la consulta del usuario que cumpla con el email y password
        $user = $repository->FindOneBy(["email" => "user2", "password" => "pass"]);
        if($user)
        {
        	//Convierto el objeto user obtenido en la consulta a json
            $jsonUser = $serializer->serialize($user, 'json');
            //retorno el json con un success true
            return $this->json(array("success" => true, "data" => $jsonUser));
        }
        else
        {
        	//retorno el json cuando el usuario no existe
            return $this->json(array("success" => false, "data" => array()));
        }
	}
}

?>