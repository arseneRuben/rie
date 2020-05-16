<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Sonata\UserBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Annonce controller.
 *
 * @Route("user")
 */
class UserController extends Controller {

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="userprofiledit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request) {


        if (isset($_POST['updateuser'])) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            extract($_POST);

            // The file property can be empty if the field is not required
            if (null === $user->getAvatar()) {
                return;
            }

            if (null !== $user->getAvatar()) {
                $filename = sha1(uniqid(mt_rand(), true));
                $user->$filename . '.' . $user->getAvatar()->guessExtension();
            }
            $user->setAvatar($avatar);
         
          
            $user->getAvatar()->move(
                    $user->getUploadRootDir(), $user->avatarPath
            );
        }

        return $this->render('Application/Sonata/UserBundle/profile.html.twig', array(
                    'user' => $user,
                    
        ));
    }

    /**
     * @Template()
     */
    public function whoIsOnlineAction() {
        $users = $this->getDoctrine()->getManager()->getRepository('ApplicationSonataUserBundle:User')->getActive();

        return array('users' => $users);
    }

}
