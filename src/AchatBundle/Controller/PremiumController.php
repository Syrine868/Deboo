<?php

namespace AchatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PremiumController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function paymentAction(Request $request)
    {
        $form = $this->get('form.factory')
            ->createNamedBuilder('payment-form')
            ->add('token', HiddenType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('submit', SubmitType::class)
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                // TODO: charge the card
            }
        }

        try {
            $this->get('app.client.stripe')->createPremiumCharge($this->getUser(), $form->get('token')->getData());
            $redirect = $this->get('session')->get('premium_redirect');
        } catch (\Stripe\Error\Base $e) {
            $this->addFlash('warning', sprintf('Unable to take payment, %s', $e instanceof \Stripe\Error\Card ? lcfirst($e->getMessage()) : 'please try again.'));
            $redirect = $this->generateUrl('premium_payment');
        } finally {
            return $this->redirect($redirect);
        }

        return $this->render('@Achat/Premuim/paiement.html.twig', [
            'form' => $form->createView(),
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
        ]);
    }
}
