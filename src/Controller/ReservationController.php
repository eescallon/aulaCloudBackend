<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Room;
use App\Entity\Sede;

class ReservationController extends Controller
{
    public function Reservation()
    {
        $em = $this->getDoctrine()->getManager();
        $repoRoom = $this->getDoctrine()->getRepository(Room::class);


        /*$sede = new Sede();
        $sede->setAddress("Direccion sede");
        $sede->setCIty("Bogota");
        $em->persist($sede);

        $room = new Room();
        $room->setName("Sala 1");
        $room->setCode("01");
        $room->setType("Auditorio");
        $room->setCapacity(100);
        $room->setIdSede($sede);
        $em->persist($room);*/

        $room = $repoRoom->Find(1);

        $reservation = new Reservation();
        $reservation->setinitialDate(new \Datetime());
        $reservation->setfinalDate(new \Datetime());
        $reservation->setinitialHour(new \Datetime());
        $reservation->setfinalHour(new \Datetime());
        $reservation->setreservationDate(new \Datetime());
        $reservation->setallDay(false);
        $reservation->setquantityAssistant(4);
        $reservation->setname("Nombre");
        $reservation->setdescription("descripcion");
        $reservation->setstate("Finalizado");
        $reservation->setIdRoom($room);
        $em->persist($reservation);
 


        // tell Doctrine you want to (eventually) save the Product (no queries yet)

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return $this->json([
            'message' => 'Reservacion guardada con exito!',
            "success" => true,
        ]);
    }

    /**
     * @Route("/newreservation", name="newreservation")
     */
    public function newReservation()
    {
        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        $content = $request->getContent();
        $data = json_decode($content, true);
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $repoRoom = $this->getDoctrine()->getRepository(Room::class);
        $user = $repoUser->Find($data["idUser"]);
        $room = $repoRoom->Find($data["room"]["id"]);
        $reservation = new Reservation();
        if($data["initialDate"] == "" || $data["initialDate"] == null)
        {
            return $this->json(array("success" => false, "message" => "Falta la fecha inicial"));
        }
        if($data["finalDate"] == "" || $data["finalDate"] == null)
        {
            return $this->json(array("success" => false, "message" => "Falta la fecha final"));
        }
        if($data["initialHour"] == "" || $data["initialHour"] == null)
        {
            return $this->json(array("success" => false, "message" => "Falta la hora inicial"));
        }
        if($data["quantityAssistant"] == "" || $data["quantityAssistant"] == null)
        {
            return $this->json(array("success" => false, "message" => "Falta la cantidad de asistentes"));
        }
        $reservation->setinitialDate(new \Datetime($data["initialDate"]));
        $reservation->setfinalDate(new \Datetime($data["finalDate"]));
        if($data["initialHour"] != "" || $data["initialHour"] != null)
        {
            $reservation->setinitialHour(new \Datetime($data["initialHour"]));
        }
        if($data["finalHour"] != "" || $data["finalHour"] != null)
        {
            $reservation->setFinalHour(new \Datetime($data["finalHour"]));
        }
        $reservation->setreservationDate(new \Datetime());
        $reservation->setallDay($data["allDay"]);
        $reservation->setquantityAssistant($data["quantityAssistant"]);
        $reservation->setname($data["name"]);
        $reservation->setdescription($data["description"]);
        $reservation->setstate("Activo");
        $reservation->setIdRoom($room);
        $reservation->setIdUser($user);
        $em->persist($reservation);
        $em->flush();
        return $this->json(array("success" => true, "message" => "Reservacion creada con exito"));
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

    /**
     * @Route("/update/reservation/{id}", name="update_reservation")
     */
    public function updateReservation($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $repoReservation = $this->getDoctrine()->getRepository(Reservation::class);
        $reservation = $repoReservation->find($id);
        if (!$reservation) {
            throw $this->createNotFoundException(
                'El reservation con ID '.$Idperson.' no existe'
            );
        }
        $actualDate = new \Datetime();
        if($reservation->getInitialDate() > $actualDate)
        {
            $request = Request::createFromGlobals();
            $content = $request->getContent();
            $data = json_decode($content, true);
            $reservation->setinitialDate(new \Datetime($data["initialDate"]));
            $reservation->setfinalDate(new \Datetime($data["finalDate"]));
            if($data["initialHour"] != "" || $data["initialHour"] != null)
            {
                $reservation->setinitialHour(new \Datetime($data["initialHour"]));
            }
            if($data["finalHour"] != "" || $data["finalHour"] != null)
            {
                $reservation->setFinalHour(new \Datetime($data["finalHour"]));
            }
            $reservation->setAllDay($data["allDay"]);
            $reservation->setQuantityAssistant($data["quantityAssistant"]);
            $reservation->setName($data["name"]);
            $reservation->setDescription($data["description"]);
            $reservation->setState("Activo");
            $reservation->setIdRoom($room);
            $em->flush();
        
            return new Response('Se actualizo entrada con ID:'.$id);
            return $this->json(array("success" => true, "message" => "Reserva actualizada con exito"));
        }
        else
        {
            return $this->json(array("success" => false, "message" => "La fecha inicial de la reservacion es menor o igual a la actual"));
        }
    } 
    
    /**
     * @Route("/delete/reservation/{id}", name="delete_reservation")
     */
    public function deleteReservation($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $repoReservation = $this->getDoctrine()->getRepository(Reservation::class);
        $reservation = $repoReservation->find($id);
        if (!$reservation) {
            return $this->json(array("success" => false, "message" => "No se encontro ninguna reservacion con el id ".$id));
        }
        $actualDate = new  \Datetime();
        if($reservation->getInitialDate() > $actualDate)
        {
            $em->remove($reservation);
            $em->flush();
            return $this->json(array("success" => true, "message" => "Reservacion eliminada con exito"));
        }
        else
        {
            return $this->json(array("success" => false, "message" => "La fecha inicial de la reservacion es menor o igual a la actual"));
        }
    } 
}

?>