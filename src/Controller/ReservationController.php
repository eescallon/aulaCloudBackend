<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Room;
use App\Entity\Sede;

class ReservationController extends Controller
{
	/**
     * @Route("/reservation", name="reservation")
     */
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
		$request = Request::createFromGlobals();
        $idUser = $request->get("idUser");
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $repoReservation = $this->getDoctrine()->getRepository(Reservation::class);
        $user = $repoUser->Find($idUser);
        $reservations = $repoReservation->findBy(["idUser" => $user, "state" => "Activo"]);
        $jsonReservation = array();
        foreach($reservations as $reservation)
        {
            $json = array();
            $json["initialDate"] = $reservation->getInitialDate()->format("Y-m-d");
            $json["finalDate"] = $reservation->getFinalDate()->format("Y-m-d");
            $json["initialHour"] = $reservation->getInitialHour()->format("H:i:s");
            $json["finalHour"] = $reservation->getFinalHour()->format("H:i:s");
            $json["reservationDate"] = $reservation->getReservationDate()->format("Y-m-d");
            $json["allDay"] = $reservation->getAllDay();
            $json["quantityAssistant"] = $reservation->getQuantityAssistant();
            $json["name"] = $reservation->getName();
            $json["description"] = $reservation->getDescription();
            $jsonRoom = array();
            $room = $reservation->getIdRoom();
            if($room)
            {
                $jsonRoom["id"] = $room->getId();
                $jsonRoom["name"] = $room->getName();
                $jsonRoom["code"] = $room->getCode();
                $jsonRoom["type"] = $room->getType();
                $jsonRoom["capacity"] = $room->getCapacity();
            }
            $json["room"] = $jsonRoom;
            $jsonReservation[] = $json;
        }
        return $this->json(array("success" => true, "total" => count($jsonReservation), "data" => $jsonReservation));

	}

    /**
     * @Route("/historyreservation", name="historyreservation")
     */
    public function historyReservation()
    {
        $request = Request::createFromGlobals();
        $idUser = $request->get("idUser");
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $repoReservation = $this->getDoctrine()->getRepository(Reservation::class);
        $user = $repoUser->Find($idUser);
        $reservations = $repoReservation->findBy(["idUser" => $user, "state" => "Finalizado"]);
        $jsonReservation = array();
        foreach($reservations as $reservation)
        {
            $json = array();
            $json["initialDate"] = $reservation->getInitialDate()->format("Y-m-d");
            $json["finalDate"] = $reservation->getFinalDate()->format("Y-m-d");
            $json["initialHour"] = $reservation->getInitialHour()->format("H:i:s");
            $json["finalHour"] = $reservation->getFinalHour()->format("H:i:s");
            $json["reservationDate"] = $reservation->getReservationDate()->format("Y-m-d");
            $json["allDay"] = $reservation->getAllDay();
            $json["quantityAssistant"] = $reservation->getQuantityAssistant();
            $json["name"] = $reservation->getName();
            $json["description"] = $reservation->getDescription();
            $jsonRoom = array();
            $room = $reservation->getIdRoom();
            if($room)
            {
                $jsonRoom["id"] = $room->getId();
                $jsonRoom["name"] = $room->getName();
                $jsonRoom["code"] = $room->getCode();
                $jsonRoom["type"] = $room->getType();
                $jsonRoom["capacity"] = $room->getCapacity();
            }
            $json["room"] = $jsonRoom;
            $jsonReservation[] = $json;
        }
        return $this->json(array("success" => true, "total" => count($jsonReservation), "data" => $jsonReservation));

    }
}

?>