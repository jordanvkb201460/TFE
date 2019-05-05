<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Entity\Researcher;
use App\Entity\Participant;
use App\Form\ExperienceType;
use App\Entity\ParticipationRequest;
use App\Repository\ResearcherRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        if($this->getUser())
        {
            if(!$this->getUser()->getIsActive())
            {
                $cache = new FilesystemCache();
                $cache->set("error", "Veuillez activer votre compte avant de vous logger" );
                return $this->redirectToRoute("security_logout");
            }
        }
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
        $repo = $this->getDoctrine()->getRepository(Participant::class);

        $participant = $repo->findOneBy(array("id" => $idParticipant));    

        $repo = $this->getDoctrine()->getRepository(ParticipationRequest::class);

        $participationRq = $repo->findBy(array("IdExperience" => $idExp));
        
        $repo = $this->getDoctrine()->getRepository(Experience::class);

        $exp = $repo->findOneBy(array("id" => $idExp));
        
        $participationRq[0]->setValidated($validated);

        if($validated == 1)
        {
            $participant->addExperience($exp);
            //$exp->addParticipant($participant);
        }
        $manager->persist($participationRq[0]);
        $manager->flush();
        

        return $this->render('main/experience.html.twig',[
            'exp' => $exp,
            'participants' => $participationRq
        ]);
    }

    /**
     * @Route("/main/inscription", name="inscription")
     */
    public function inscription(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
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
            $hash = $encoder->encodePassword($researcher, $researcher->getPassword());
            $researcher->setPAssword($hash);
            $manager->persist($researcher);
            $manager->flush();
            
            $this->addFlash("warning","Un mail de confirmation a été envoyé à l'adresse ".$researcher->getMail());
            $message = (new \Swift_Message("Confirmation d'inscription"))
                        ->setFrom("security@xpmobile.com")
                        ->setTo($researcher->getMail())
                        ->setBody($this->renderView("main/verifAccount.html.twig",["researcher"=>$researcher]),"text/html");
            $mailer->send($message);
            return $this->redirectToRoute('security_login');
        }

        return $this->render('main/inscription.html.twig',[
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
        $inactiveAccount = null;
        $cache = new FilesystemCache();
        if($cache->has("error"))
        {
            $inactiveAccount = $cache->get("error");
            $cache->delete("error");    
        }
        return $this->render('main/connexion.html.twig',[
        "inactiveAccount" => $inactiveAccount
        ]);
    }

     /**
    * @Route("/onsenfout", name="security_login_json")
    */
    public function loginJson(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $repo = $this->getDoctrine()->getRepository(Participant::class);
        $participant = $repo->findOneBy(array("id"=>$data['username']));
        $data = json_decode($request->getContent(), true);
        $mdp = $data['password'];
        $check = $encoder->isPasswordValid($participant,$mdp);
        if($check)
        {
            return($this->json($participant,200,[],[
                ]));
        }
        else
        {
            return ($this->json("error",400,[],[]));
        }
        
    }
    
    /**
    * @Route("/main/deconnexion", name="security_logout")
    */
    public function logout()
    {
        
    }
    
    /**
     * @Route("main/accountConfirm/{token}",name="account_confirm")
     */
    public function accountConfirm($token, ResearcherRepository $repo, ObjectManager $manager)
    {
        $researcher = $repo->findOneByToken($token);
        /*
            if(!$researcher)
            {
                return
            }
        */
        $researcher->setIsActive(true);
        $manager->persist($researcher);
        $manager->flush();
        $this->addFlash("success","Votre compte a été activé ");
        return $this->redirectToRoute("security_login");
    }

    /**
     * @Route("main/experience/close/{idExp}",name="closeExp")
     */
    public function closeExp($idExp, ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Experience::class);
        $exp = $repo->findOneById($idExp);
        $exp->setIsActive(false);
        dump($exp);
        $manager->persist($exp);
        $manager->flush();
        return $this->redirectToRoute('displayExperience', ['id'=> $exp->getId()]);
    }
}
