<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/error")
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
	/**
     * @Route("/", name="access_denied", methods={"GET"})
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        // ...

        return new Response('<h1>Oups.. Vous n\'avez pas les accès pour accéder à cette page</h1>
        					<a href="/">Home</a>', 403);


        // return new RedirectResponse($this->urlGenerator->generate('app_home'));

        // return $this->redirectToRoute('app_home');
        // return new RedirectResponse('/error/access-denied');
        // return $this->render('error/access-denied.html.twig');
    }
}

?>