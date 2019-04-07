<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Experience;
use App\Entity\Researcher;
use App\Entity\Participant;
use App\Entity\ParticipationRequest;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ExperienceType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

     /**
     * @Route("/main/experience/{idExp}&{idParticipant}&{validated}", name="acceptRequest")
     */
    public function request($idExp, $idParticipant,$validated, ObjectManager $manager)
    {
        $test = true;
        dump($test);
        $repo = $this->getDoctrine()->getRepository(Participant::class);

        $participant = $repo->findOneBy(array("id" => $idExp));        
        //dump($participant)

        $repo = $this->getDoctrine()->getRepository(ParticipationRequest::class);

        $participationRq = $repo->findBy(array("IdExperience" => $idExp));
        
        $repo = $this->getDoctrine()->getRepository(Experience::class);

        $exp = $repo->findOneBy(array("id" => $idExp));
        if($validated == ("true"))
        {
            $participationRq[0]->setValidated(true);
        }
        else{
            $participationRq[0]->setValidated(false);
        }
        $manager->persist($participationRq[0]);
        $manager->flush();
        
        //dump($participationRq);

        return $this->render('main/experience.html.twig',[
            'authenticated' => true,
            'exp' => $exp,
            'participants' => $participationRq
        ]);
    }

    /**
     * @Route("/main/inscription", name="inscription")
     */
    public function inscription(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $researcher = new Researcher();

        $form = $this->createFormBuilder($researcher)
                     ->add('Mail')
                     ->add('Password', PasswordType::class)
                     ->add('ConfirmPassword', PasswordType::class)
                     ->add('FirstName')
                     ->add('LastName')
                     ->add('Department')
                     ->add('Status', ChoiceType::class, [
                         'choices' => [
                             'Etudiant'=>'Etudiant',
                             'Doctorant'=>'Doctorant',
                             'PostDoc'=>'PostDoc',
                             'Chercheur'=>'Chercheur',
                             'Enseignant'=>'Enseignant'
                         ]
                     ])
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $researcher->setId(1); //changer 
            $hash = $encoder->encodePassword($researcher, $researcher->getPassword());
            $researcher->setPAssword($hash);
            $manager->persist($researcher);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('main/inscription.html.twig',[
            'authenticated' => true,
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/main/experiences/{idResearcher}", name="experiences")
     */
    public function getAllExperienceByResearcher($idResearcher)
    {
        $repo = $this->getDoctrine()->getRepository(Experience::class);

        $exp = $repo->findBy(array("researcher" => $idResearcher));

        return $this->render('main/experiences.html.twig',[
            'experiences' => $exp,
        ]);
    }

     /**
     * @Route("/main/experience/{id}", name="displayExperience")
     */
    public function displayExperience($id)
    {
        $repo = $this->getDoctrine()->getRepository(ParticipationRequest::class);

        $participationRq = $repo->findBy(array("IdExperience" => $id));
        
        $repo = $this->getDoctrine()->getRepository(Experience::class);

        $exp = $repo->findOneBy(array("id" => $id));
        
        //dump($participationRq);

        return $this->render('main/experience.html.twig',[
            'exp' => $exp,
            'participants' => $participationRq
        ]);
    }

  

    /**
     * 
     * @Route("/main/experienceForm/{id}&{method}", name="modifyExp")
     * @Route("/main/experienceForm/{id}&{method}", name="createExp")
     */
    public function experience($id,$method, Request $request, Objectmanager $manager)
    {
        if($method == "create")
        {
            $repo = $this->getDoctrine()->getRepository(Researcher::class);

            $researcher = $repo->findOneBy(array("id"=>$id)); // a changer

            $exp = new Experience();
        }
        else
        {
            $repo = $this->getDoctrine()->getRepository(Experience::class);

            $exp = $repo->findOneBy(array("id"=>$id)); // a changer
        }
        
        //dump($researcher);

        $form = $this->createForm(ExperienceType::class, $exp);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($method == "create")
            {
                $exp->setResearcher($researcher);
            }
            $manager->persist($exp);
            $manager->flush();

            return $this->redirectToRoute('displayExperience', ['id'=> $exp->getId()]);
        }

        return $this->render('main/experienceForm.html.twig',[
            'authenticated' => true,
            'formExp' => $form->createView()
        ]);
    }

    /**
    * @Route("/main/connexion", name="security_login")
    */
    public function login()
    {
        return $this->render('main/connexion.html.twig');
    }
    
    /**
    * @Route("/main/deconnexion", name="security_logout")
    */
    public function logout()
    {
        
    }
   
}
