<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Contract;
use App\Form\ReservationType;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;



class ReservationController extends AbstractController
{
    protected $requestStack;
    public function __construct(RequestStack $request)
    {
        $this->requestStack = $request;
    }
    

    #[Route('/reservation', name: 'reservation')]
    public function reservation(
        Request $request, 
        EntityManagerInterface $entityManager, 
        UserRepository $userRepository
    ):Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(ReservationType::class, $user);
        $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid())
            {
                if($this->checkNumberPhone($request->get('numeroPortable'))===false){
                    echo "le numéro de téléphone renseigné n'est pas correct.";
                }elseif($this->checkNumberPermis($request->get('numeroPermisConduire')===false)){
                    echo"Le numéro de permis renseigné n'est pas valide";
                }elseif($this->checkPostalCode($request->get('codePostal'))===false){
                    echo"Merci de renseigner un code postal valide";
                }else{
                    $entityManager->persist($user);
                    $entityManager->flush();
                    //return $this->redirectToRoute('home');
                }  
            }
            return $this->render('reservation/index.html.twig', [
                'form' => $form->createView(),
                'currentUser' => $user
            ]);             
    }
    
    protected function checkNumberPhone($phone):bool
    {
        $regex = '#^0[6-7]{1}\d{8}$#'; 

    if( !preg_match( $regex, $phone ) || strlen($phone<10)) { 
        return false ;
       }  return true;
    
    }
    
    protected function isEmailExist(string $emailUser, UserRepository $userRepository):bool
    {
        $databaseEmail=$userRepository->findOneBy(['email' => $emailUser]);
        if(!empty($databaseEmail))
        {
            return true;
        }return false;
    }
    protected function checkNumberPermis($numeroPermis):bool
    {
        $numero=preg_match('@[0-9]@', $numeroPermis);
        if(strlen($numeroPermis)<12 ||strlen($numeroPermis)>12 || !$numero)
        {
            return false;
        }
                return true;
    }
    protected function checkPostalCode($codePostal):bool
    {
        $codePostal=preg_match('@[0-9]@', $codePostal);
        if(strlen($codePostal)!=5 || !$codePostal)
        {
            return false;
        }
                return true;
    }

    
           
}