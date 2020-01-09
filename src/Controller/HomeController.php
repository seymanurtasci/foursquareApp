<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $client = new Client(['base_uri' => 'https://api.foursquare.com/']);
        $response = $client->request('GET', 'v2/venues/categories?v=20170801&ll=41.01,28.97&client_id=P3PHL5BERJPSCFUKQQ200YJPXRKAE250XD5MB3NIQPXXUIGS&client_secret=2T0EB20PPSGM5DFG3BGRUS5E5KBFRITUFCDSO3E5WKI1NIFL', ['verify' => false]);

        $all_categories = \GuzzleHttp\json_decode($response->getBody());


        return $this->render('home/index.html.twig',array(
            'all_categories' => $all_categories
        ));
    }



    /**
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {

       $query = $request->query->get('query');


       $clientVenues = new Client(['base_uri' => 'https://api.foursquare.com/']);
       $responseVenues = $clientVenues->request('GET', 'v2/venues/explore/',[
           'query' => [
               'query' => $query,
               'client_id' => 'P3PHL5BERJPSCFUKQQ200YJPXRKAE250XD5MB3NIQPXXUIGS',
               'client_secret' => '2T0EB20PPSGM5DFG3BGRUS5E5KBFRITUFCDSO3E5WKI1NIFL',
               'v' => '20170801',
               'near' => 'İstanbul',
           ],
           'verify' => false,
       ]);

       $all_venues = \GuzzleHttp\json_decode($responseVenues->getBody());


        $clientCategory = new Client(['base_uri' => 'https://api.foursquare.com/']);
        $responseCategory = $clientCategory->request('GET', 'v2/venues/categories?v=20170801&ll=41.01,28.97&client_id=P3PHL5BERJPSCFUKQQ200YJPXRKAE250XD5MB3NIQPXXUIGS&client_secret=2T0EB20PPSGM5DFG3BGRUS5E5KBFRITUFCDSO3E5WKI1NIFL', ['verify' => false]);

        $all_categories = \GuzzleHttp\json_decode($responseCategory->getBody());

        return $this->render('home/new.html.twig',array(
            'all_venues' => $all_venues,
            'all_categories' => $all_categories,
        ));
    }


}
