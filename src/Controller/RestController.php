<?php

namespace App\Controller;

use \Datetime;
use App\Entity\Experience;
use App\Entity\Researcher;
use App\Entity\Participant;
use App\Form\ExperienceType;
use App\Service\RandomString;
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
     * @Route("/logoutjson", name="security_logout_json")
     */
    public function logoutJson(Request $request, Objectmanager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Participant::class);
        $data = json_decode($request->getContent(), true);
        $participant = $repo->findOneBy(array("token"=>$data['token']));
        $participant->setToken("");
        $manager->persist($participant);
        $manager->flush();
        return ($this->json("succes",200,[],[]));
    }


    /**
    * @Route("/loginjson", name="security_login_json")
    */
    public function loginJson(Objectmanager $manager, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $repo = $this->getDoctrine()->getRepository(Participant::class);
        $data = json_decode($request->getContent(), true);
        $participant = $repo->findOneBy(array("Mail"=>$data['username']));
       
        $mdp = $data['password'];
        $check = $encoder->isPasswordValid($participant,$mdp);
        if($check)
        {
            $rdmstr = new RandomString();
            $participant->setToken($rdmstr->Generate());
            $manager->persist($participant);
            $manager->flush();
            return($this->json($participant,200,[],[ObjectNormalizer::ATTRIBUTES => [
                'id',
                'Lastname',
                'Firstname',
                'Age',
                'Sex',
                'Mail',
                'experiences' =>[
                    'id',
                ],
                'Message' => [
                    'id'
                ],
                'participationRequests' => [
                    'id',
                    'IdExperience'=>[
                        'id'
                        
                    ],
                    'Status'
                ],
                'token',
                'BirthDate'
            ]
                ]));
        }
        else
        {
            return ($this->json("error",400,[],[]));
        }
        
    }


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
                    'isActive',
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
                        'id',
                        'Validated'
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
    public function inscriptionParticipant(Request $request,  ParticipantRepository $repo, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $request->getContent();
        $data = json_decode($request->getContent(), true);
        $participant = new Participant();
        $participant->setFirstname($data["Firstname"]);
        $participant->setLastname($data["Lastname"]);
        $participant->setMail($data["Mail"]);
        $participant->setSex($data["Sex"]);
        $participant->setBirthDate(new Datetime($data["BirthDate"]));
        $participant->setPassword($data["Password"]);
        $participant->setAge(0);
        $participant->setRegisterExperience(0);
        $participant->setParticipatedExperience(0);
        $hash = $encoder->encodePassword($participant, $participant->getPassword());
        $participant->setPAssword($hash);

        
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
        $participant = $repo->findOneBy(['token' => $tmp]);
        $participantRq->setIdParticipant($participant);
        $participantRq->setValidated($data["Validated"]);
        $participantRq->setStatus($data["Status"]);


        
        $manager->persist($participantRq);
        $manager->flush();
       //$participant = $_POST["participant"];
       return($this->json("test",200,[],[
    ]));
    }
}
