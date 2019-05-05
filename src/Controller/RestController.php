<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Entity\Researcher;
use App\Entity\Participant;
use App\Form\ExperienceType;
use App\Entity\ParticipationRequest;
use App\Repository\ExperienceRepository;
use App\Repository\ParticipantRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ParticipationRequestRepository;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RestController extends AbstractController
{
    /**
     * @Route("getExperiences",name="getExperiences")
     */
    public function getExperiences(ExperienceRepository $repo)
    {
       // if($_POST["json"] && $_POST["json"] == $token)
        //{
            $exp = $repo->findAll();
            return($this->json($exp,200,[],[
                ObjectNormalizer::ATTRIBUTES => [
                    'id',
                    'Compensation',
                    'Place',
                    'Feedback',
                    'FreeReq',
                    'AgeReq',
                    'SexReq',
                    'SpecifiqReq',
                    'IsActive',
                    'researcher' =>[
                        'id',
                    ],
                    'participants' => [
                        'id'
                    ],
                    'messages' => [
                        'id'
                    ],
                    'Name',
                    'DateDebut',
                    'datefin',
                    'participationRequest' => [
                        'id'
                    ],
                ]
            ]));
       // else{
       //     return null;
        //}
    }


     /**
     * @Route("inscriptionParticipant",name="inscriptionParticipant")
     */
    public function inscriptionParticipant(Request $request,  ParticipantRepository $repo, ObjectManager $manager)
    {
        $request->getContent();
        $data = json_decode($request->getContent(), true);
        dump($data["Mail"]);
        $participant = new Participant();
        $participant->setFirstname($data["Firstname"]);
        $participant->setLastname($data["Lastname"]);
        $participant->setMail($data["Mail"]);
        $participant->setSex($data["Sex"]);
        $participant->setAge($data["Age"]);

        
        $manager->persist($participant);
        $manager->flush();
       //$participant = $_POST["participant"];
       return $this->json($data,200,[],[]);
    }

      /**
     * @Route("participationRequest",name="participationRequest")
     */
    public function participationRequest(Request $request, ObjectManager $manager)
    {
        $request->getContent();
        $data = json_decode($request->getContent(), true);
        $participantRq = new ParticipationRequest();
        $repo = $this->getDoctrine()->getRepository(Experience::class);
        $tmp = $data["IdExperience"];
        $exp = $repo->findOneBy(['id' => $tmp]);
        $participantRq->setIdExperience($exp);
        $repo = $this->getDoctrine()->getRepository(Participant::class);
        $tmp = $data["IdParticipant"];
        $participant = $repo->findOneBy(['id' => $tmp]);
        $participantRq->setIdParticipant($participant);
        $participantRq->setValidated($data["Validated"]);


        
        $manager->persist($participantRq);
        $manager->flush();
       //$participant = $_POST["participant"];
       return($this->json("test",200,[],[
    ]));
    }
}
