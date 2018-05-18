<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Person;

class UserController extends Controller
{
	/**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $person  = new Person();
        $person->setIdentification("12345");
        $person->setTypeIdentification("cedula");
        $person->setName("Eduardo");
        $person->setLastName("Escallon");
        $person->setBirthDay(new \Datetime("1990-08-01"));
        $person->setPhone("1234567890");
        $person->setAddress("Direccion");
        $person->setSex("Masculino");
        $em->persist($person);

        $user = new User();
        $user->setEmail('eduard.escallon@gmail.com');
        $user->setPassword("password123");
        $user->setIdPerson($person);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return $this->json([
            'message' => 'Usuario creado con exito',
            'success' => true
        ]);
    }

	/**
     * @Route("/login", name="login")
     */
	public function login()
	{
		$request = Request::createFromGlobals();
        $content = $request->getContent();
        $data = json_decode($content, true);

        $repository = $this->getDoctrine()->getRepository(User::class);
        //Hago la consulta del usuario que cumpla con el email y password
        $user = $repository->FindOneBy(["email" => "user", "password" => "pass"]);
        if($user)
        {
            $jsonUser = array();
            $jsonUser["id"] = $user->getId();
            $jsonUser["email"] = $user->getEmail();
            $person = $user->getIdPerson();
            $jsonPerson = array();
            if($person)
            {
                $jsonPerosn["id"] = $person->getId();
                $jsonPerson["name"] = $person->getName();
                $jsonPerson["lastName"] = $person->getLastname();
            }
            $jsonUser["person"] = $jsonPerson;
            return $this->json(array("success" => true, "data" => $jsonUser));
        }
        else
        {
            return $this->json(array("success" => false, "message" => "No se encuentra un usuario con ese email y contraseña"));
        }
	}
}

?>