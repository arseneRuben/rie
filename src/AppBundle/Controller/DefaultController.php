<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\EnquiryType;
use AppBundle\Entity\Enquiry;
use AppBundle\Entity\Film;
use AppBundle\Entity\Temoignage;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Application\Sonata\UserBundle\Entity\User;
use App\Repository\FilmRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller {

    /**
     * @Route("/{_locale}", requirements={"_locale": "en|fr"},defaults={"_locale" = "fr"}, name="homepage")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $query = $this->getDoctrine()->getEntityManager()
                        ->createQuery(
                                'SELECT u FROM ApplicationSonataUserBundle:User u WHERE u.roles LIKE :role ORDER BY u.username ASC' 
                        )
                ->setParameter('role', '%"ROLE_SONATA_ADMIN"%');

        $journalists = $query->getResult();
        return $this->render('default/index.html.twig', array(
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'journalists' => $journalists,
        ));
    }
  
 

    /**
     * @Route("/about/{_locale}", requirements={"_locale": "en|fr"},defaults={"_locale" = "fr"} , name="about")
     */
    public function aboutAction() {
        return $this->render('default/about.html.twig');
    }

    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
        // some logic to determine the $locale
        $request->getSession()->set('_locale', $locale);
    }

    /**
     * @Route("/contact/{_locale}", requirements={"_locale": "en|fr"},defaults={"_locale" = "fr"}, name="contact")
     */
    public function contactAction() {

        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                if ($this->getUser()) {
                    // Si l'emetteur est connecté
                    $enquiry->setEmetteur($this->getUser());
                    $enquiry->setEmail($this->getUser()->getEmail());
                    $message = (new \Swift_Message($enquiry->getBody()))
                            ->setFrom($enquiry->getAuditeur()->getEmail())
                            ->setTo('fopoar@gmail.com')
                            ->setBody(
                            $this->renderView(
                                    'default/contact.html.twig', array('name' => $enquiry->getName(), 'form' => $form->createView())
                            ), 'text/html'
                    );
                } else {
                    // Si l'émetteur n'est pas connecté      
                    $enquiry->setEmetteur($this->getUser());
                    $message = (new \Swift_Message($enquiry->getBody()))
                            ->setFrom($this->getUser()->getEmail())
                            ->setTo('fopoar@gmail.com')
                            ->setBody(
                            $this->renderView(
                                    'default/contact.html.twig', array('name' => $enquiry->getName(), 'form' => $form->createView())
                            ), 'text/html'
                    );
                }

                if ($enquiry->getSubject() == "temoignage") {
                    $em = $this->getDoctrine()->getManager();
                    $temoignage = new Temoignage();
                    // $auditeur = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $_POST['userid']));
                    $temoignage->setAuditeur($this->getUser());
                    $temoignage->setContenu($enquiry->getBody());
                    $temoignage->setVisibilite(false);
                    $em->persist($temoignage);
                    $em->flush();
                }
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('app_contact'));
            }
        }

        return $this->render('default/contact.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/fileuploadhandler", name="fileuploadhandler")
     */
    public function fileUploadHandler(Request $request) {
        $output = array('uploaded' => false);
        // get the file from the request object
        $file = $request->files->get('file');
        // generate a new filename (safer, better approach)
        // To use original filename, $fileName = $this->file->getClientOriginalName();
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        // set your uploads directory
        $uploadDir = $this->get('kernel')->getRootDir() . '/../web/uploads/';
        if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        if ($file->move($uploadDir, $fileName)) {
            // get entity manager
            $em = $this->getDoctrine()->getManager();

            // create and set this mediaEntity
            $mediaEntity = new mediaEntity();
            $mediaEntity->setFileName($fileName);

            // save the uploaded filename to database
            $em->persist($mediaEntity);
            $em->flush();
            $output['uploaded'] = true;
            $output['fileName'] = $fileName;
        }
        return new JsonResponse($output);
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit/{_locale}",defaults={"_locale" = "fr"} , requirements={"_locale": "en|fr"}, name="userprofiledit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (($user instanceof UserInterface ) && (isset($_POST['updateuser']))) {

            extract($_POST);

            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setLocale($country);
            $user->setGender($sex);

            if ($_FILES['avatar']['error'] > 0) {
                $erreur = "Erreur lors du transfert";

                return $this->render('ApplicationSonataUserBundle:Profile:show.html.twig', array(
                            'user' => $user,
                ));
            }
            if ($_FILES['avatar']['size'] > 2000000) {

                return $this->render('ApplicationSonataUserBundle:Profile:show.html.twig', array(
                            'user' => $user,
                ));
            }
            $extensions_valides = array('jpg', 'jpeg', 'gif', 'png', 'jfif');
            //1. strrchr renvoie l'extension avec le point (« . »).
            //2. substr(chaine,1) ignore le premier caractère de chaine.
            //3. strtolower met l'extension en minuscules.
            $extension_upload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
            if (in_array($extension_upload, $extensions_valides)) {

                $filename = "uploads/images/avatars/{$user->getId()}.{$extension_upload}";
                $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $filename);
                if ($resultat) {
                    $user->setToken("/" . $filename);
                }
            }

            $em->persist($user);
            $em->flush();
        }

        return $this->render('ApplicationSonataUserBundle:Profile:show.html.twig', array(
                    'user' => $user,
        ));
    }

}
