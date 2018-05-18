<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Sede;

class SedeController extends Controller
{
	/**
     * @Route("/insertarsede", name="insertarsede")
     */
    public function index()
    {   
        $em = $this->getDoctrine()->getManager();
        $sede = new Sede();
        $sede->setAddress("Direccion");
        $sede->setCity("Ciutdad");
        $em->persist($sede);
        $em->flush();
       	return $this->json(array("success" => true, "data" => array()));
    }

 	/**
     * @Route("/sede", name="consultasede")
     */
    public function getAllSede()
    {   
        $em = $this->getDoctrine()->getManager();
        $repoSede = $this->getDoctrine()->getRepository(Sede::class);
        $sedes = $repoSede->findAll();
       	return $this->json(array("success" => true, "data" => $sedes));
    }
}

?>