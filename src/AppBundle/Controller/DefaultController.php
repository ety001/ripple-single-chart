<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Ripple;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Ripple::class);
        $data = $repository->findAll();
        var_dump($data);die();
    }

    /**
     * @Route("/getdata", name="getdata")
     */
    public function datagetAction(Request $request)
    {
        $balances = file_get_contents('https://data.ripple.com/v2/accounts/rKa5xscVXpX3SWGk48o295PmBDqSvpyco9/balances');
        $result = json_decode($balances, true);
        $data = [];
        foreach ($result['balances'] as $key => $val) {
            if ($val['currency'] === 'XRP') {
                $data['XRP'] = $val['value'];
            } else {
                $data['CNY'] = $val['value'];
            }
        }
        $price = file_get_contents('https://data.ripple.com/v2/exchange_rates/CNY+rKiCet8SdvWxPXnAgYarFUXMh1zCPz432Y/XRP');
        $result = json_decode($price, true);
        $data['price'] = round(1 / $result['rate'], 6);

        $em = $this->getDoctrine()->getManager();
        $rippleData = new Ripple();
        $rippleData->setXrp($data['XRP']);
        $rippleData->setCny($data['CNY']);
        $rippleData->setPrice($data['price']);
        $rippleData->setLogtime(time());
        $em->persist($rippleData);
        $em->flush();

        exit();
    }
}
