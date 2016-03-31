<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Application;
use AppBundle\Form\ApplicationType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $application = new Application();

        $cities = [];
        $postData = $request->request->get('application');
        $zip = $postData['zip'];
        if ($zip){
            $citiesRepo = $this->getDoctrine()->getRepository("AppBundle:City");
            $cities = $citiesRepo->findBy(["zip" => $zip]);
        }

        $form = $this->createForm(ApplicationType::class, $application, ["cities" => $cities]);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if ($form->isValid()){

                $uploadedFile = $form['passport']['file']->getData();
                $newFilename = uniqid() . "." . $uploadedFile->guessExtension();
                $application->getPassport()->setFilename($newFilename);

                $dir = $this->get('kernel')->getRootDir() . '/../web/uploads/';

                $uploadedFile->move($dir, $newFilename);

                $em = $this->getDoctrine()->getManager();
                $em->persist($application);
                $em->flush();
            }
        }

        $data = [
            "form" => $form->createView()
        ];
        return $this->render('default/index.html.twig', $data);
    }

    /**
     * @Route("/cities", name="get_cities")
     */
    public function getCitiesAction(Request $request)
    {
        //récupère le zip qui est en $_GET
        $zip = $request->query->get('zip');

        //récupère les villes
        $citiesRepo = $this->getDoctrine()->getRepository("AppBundle:City");
        $cities = $citiesRepo->findBy(["zip" => $zip]);

        return new JsonResponse($cities);
    }
}
