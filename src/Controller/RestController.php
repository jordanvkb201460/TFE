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
     * @Route("test/{token}",name="test")
     */
    public function test(Request $request, $token, ExperienceRepository $repo)
    {
        if($_POST["json"] && $_POST["json"] == $token)
        {
            $exp = $repo->findAll();
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            
            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($exp, 'json');
            return new Response($jsonContent);
        }
        else{
            return null;
        }
    }
}
