<?php

namespace App\Controller;

use App\Repository\HistoricRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Historic;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HistoricController extends AbstractController
{
    private $historicRepository;

    public function __construct(HistoricRepository $historicRepository)
    {
        $this->historicRepository = $historicRepository;
    }

/* ===========================
  Adds historic to database
=========================== */
    public function addHistoric()
    {

    }

/* ============================
  Update historic in database
============================ */
    public function updateHistoric()
    {

    }

/* ==============================
  Delete historic from database
============================== */
    public function deleteHistoric()
    {

    }

/* ======================================
  list User's all historics in database
======================================= */
    public function listUserHistoric()
    {

    }


}
