<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Entity\Researcher;
use App\Entity\Participant;
use App\Form\ExperienceType;
use App\Entity\ParticipationRequest;
use App\Repository\ExperienceRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("test",name="test")
     */
    public function test(Request $request,  ExperienceRepository $repo)
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
}
