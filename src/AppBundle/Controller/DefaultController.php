<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Ripple;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/{addr}", name="homepage")
     */
    public function indexAction(Request $request, $addr='rKa5xscVXpX3SWGk48o295PmBDqSvpyco9')
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'addr' => $addr
        ]);
    }

    /**
     * @Route("/getdata/{addr}/{gateway}", name="getdata")
     */
    public function datagetAction(Request $request, $addr='rKa5xscVXpX3SWGk48o295PmBDqSvpyco9', $gateway='rKiCet8SdvWxPXnAgYarFUXMh1zCPz432Y')
    {
        $balances = file_get_contents('https://data.ripple.com/v2/accounts/'.$addr.'/balances');
        // var_dump($balances);die();
        $result = json_decode($balances, true);
        $data = [];
        foreach ($result['balances'] as $key => $val) {
            if ($val['currency'] === 'XRP') {
                $data['XRP'] = $val['value'];
            } else {
                $data['CNY'] = $val['value'];
            }
        }
        $price = file_get_contents('https://data.ripple.com/v2/exchange_rates/CNY+'.$gateway.'/XRP');
        $result = json_decode($price, true);
        // var_dump($result);die();
        $data['price'] = round(1 / $result['rate'], 6);

        $em = $this->getDoctrine()->getManager();
        $rippleData = new Ripple();
        $rippleData->setAddr($addr);
        $rippleData->setXrp($data['XRP']);
        $rippleData->setCny($data['CNY']);
        $rippleData->setPrice($data['price']);
        $rippleData->setLogtime(date('Y-m-d H:i:s',time()));
        $em->persist($rippleData);
        $em->flush();
        exit();
    }

    /**
     * @Route("/detail/{addr}", name="detail")
     */
    public function detailAction(Request $request, $addr='rKa5xscVXpX3SWGk48o295PmBDqSvpyco9')
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT r
            FROM AppBundle:Ripple r
            WHERE r.addr = :addr
            ORDER BY r.id DESC'
        )->setParameter('addr', $addr)
        ->setFirstResult(0)
        ->setMaxResults(24*5);
        $data = $query->getArrayResult();
        return new JsonResponse(array_reverse($data));
    }
}
