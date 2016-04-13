<?php

namespace Ludo\Framework\Controller;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

/**
 * Class BaseController
 *
 * @package Ludo\Framework\Controller
 */
abstract class BaseController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Helper method to get the entity manager
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }
}