<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\Reservation;

class ReservationController extends Controller
{
	/**
     * @Route("/reservation", name="reservation")
     */
    public function newReservation()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $reservation = new Reservation();
        $reservation->setinitialDate(new \Datetime());
        $reservation->setinalDate(new \Datetime());
        $reservation->setinitialHour(new \time());
        $reservation->setfinalHour (new \time());
        $reservation->setreservationDate(new \datatime());
        $reservation->setallDay(new \bool());
        $reservation->setquantityAssistant(new \int());
        $reservation->setname(new \string());
        $reservation->setdescription(new \string());
        $reservation->setstate(new \string());


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($reservation);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

	/**
     * @Route("/myreservation", name="myreservation")
     */
	public function userReservation()
	{
		//Obtengo el encoder
		$encoders = array(new JsonEncoder());
		//Obtengo el normalizer
        $normalizers = array(new ObjectNormalizer());
        //Creo el serializer
        $serializer = new Serializer($normalizers, $encoders);
        //Obtengo el repositorio de la clase user para hacer las consultas
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        //Hago la consulta del usuario que cumpla con el email y password
        $reservations = $repository->FindBy([]);
        if($reservations)
        {
        	//Convierto el objeto user obtenido en la consulta a json
            $jsonReservations = $serializer->serialize($reservations, 'json');
            //retorno el json con un success true
            return $this->json(array("success" => true, "data" => $jsonReservations));
        }
        else
        {
        	//retorno el json cuando el usuario no existe
            return $this->json(array("success" => false, "data" => array()));
        }
	}


    public function updateReservation($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $repoReservation = $this->getDoctrine()->getRepository(Reservation::class);
        if (!$reservation) {
            throw $this->createNotFoundException(
                'El reservation con ID '.$Idperson.' no existe'
            );
        }
        
        $em->flush();
        
        return new Response('Se actualizo entrada con ID:'.$id);
    } 
    
    /**
     * @Route("/delete/reservation/{id}", name="delete_reservation")
     */
    public function deleteReservation($id)
    {   
    $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('aulaCloud:reservation')->find($id);
        if (!$reservation) {
            throw $this->createNotFoundException(
                'la reservation con ID '.$Idperson.' no existe'
            );
        }
        $em->remove($reservation);
        $em->flush();
        
        return new Response('Se borro la entrada con ID:'.$id);
    } 
}

?>