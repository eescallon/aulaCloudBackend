<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use App\Entity\Room;
use App\Entity\Sede;
use App\Entity\User;

class RoomController extends Controller
{
       /**
     * @Route("/consult/room/{idSede}", name="Consulter_room")
     */
    public function consultRoom($idSede)
    {   
        $em = $this->getDoctrine()->getManager();
        $repoRoom = $this->getDoctrine()->getRepository(Room::class);
        $repoSede = $this->getDoctrine()->getRepository(Sede::class);
        $sede = $repoSede->find($idSede);
        $rooms = $repoRoom->findBy(["idSede" => $sede]);
        $array = array();
        foreach($rooms as $room)
        {
            $temp = array();
            $temp["id"] = $room->getId();
            $temp["name"] = $room->getName();
            $temp["code"] = $room->getCode();
            $temp["type"] = $room->getType();
            $temp["capacity"] = $room->getCapacity();
            $array[] = $temp;
        }
        return $this->json(array("success" => true, "data" => $array));
    }
}
?>