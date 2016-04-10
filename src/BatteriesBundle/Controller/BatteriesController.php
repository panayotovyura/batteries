<?php

namespace BatteriesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use BatteriesBundle\Form\BatteryType;
use BatteriesBundle\Services\BatteriesService;

class BatteriesController extends Controller
{
    /**
     * Batteries statistic action.
     *
     * @Route("/", name="batteries_statistic")
     * @Method({"GET"})
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'batteries' => $this->getBatteriesService()->getStatistic()
        ];
    }

    /**
     * Add new battery action.
     *
     * @Route("/add", name="batteries_add")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(BatteryType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getBatteriesService()->saveBattery($form->getData());

            return $this->redirectToRoute('batteries_statistic');
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @return BatteriesService
     */
    private function getBatteriesService()
    {
        return $this->get('batteries_service');
    }
}
