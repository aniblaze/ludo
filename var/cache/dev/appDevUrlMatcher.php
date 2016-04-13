<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/defaults')) {
            // euro_default_jackpot_results_per_year
            if (preg_match('#^/defaults/(?P<year>[^/]++)/jackpot/results/per/year/euro$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_euro_default_jackpot_results_per_year;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'euro_default_jackpot_results_per_year')), array (  '_controller' => 'Ludo\\Bundles\\Chance\\LotteryBundle\\Controller\\DefaultController::euroJackpotResultsPerYearAction',  '_format' => 'json',));
            }
            not_euro_default_jackpot_results_per_year:

            if (0 === strpos($pathinfo, '/defaults/jackpots')) {
                // euro_default_jackpot_results
                if ($pathinfo === '/defaults/jackpots/results/euro') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_euro_default_jackpot_results;
                    }

                    return array (  '_controller' => 'Ludo\\Bundles\\Chance\\LotteryBundle\\Controller\\DefaultController::euroJackpotResultsAction',  '_format' => 'json',  '_route' => 'euro_default_jackpot_results',);
                }
                not_euro_default_jackpot_results:

                // euro_default_jackpot_prediction
                if ($pathinfo === '/defaults/jackpots/predictions/euro') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_euro_default_jackpot_prediction;
                    }

                    return array (  '_controller' => 'Ludo\\Bundles\\Chance\\LotteryBundle\\Controller\\DefaultController::euroJackpotPredictionAction',  '_format' => 'json',  '_route' => 'euro_default_jackpot_prediction',);
                }
                not_euro_default_jackpot_prediction:

            }

        }

        if (0 === strpos($pathinfo, '/eurojackpot')) {
            if (0 === strpos($pathinfo, '/eurojackpot/results')) {
                // eurojackpot_results
                if ($pathinfo === '/eurojackpot/results') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_eurojackpot_results;
                    }

                    return array (  '_controller' => 'Ludo\\Bundles\\Chance\\LotteryBundle\\Controller\\DefaultController::euroJackpotResultsAction',  '_format' => 'json',  '_route' => 'eurojackpot_results',);
                }
                not_eurojackpot_results:

                // eurojackpot_result_year
                if (preg_match('#^/eurojackpot/results/(?P<year>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_eurojackpot_result_year;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'eurojackpot_result_year')), array (  '_controller' => 'Ludo\\Bundles\\Chance\\LotteryBundle\\Controller\\DefaultController::euroJackpotResultsPerYearAction',  '_format' => 'json',));
                }
                not_eurojackpot_result_year:

            }

            // eurojackpot_prediction
            if ($pathinfo === '/eurojackpot/prediction') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_eurojackpot_prediction;
                }

                return array (  '_controller' => 'Ludo\\Bundles\\Chance\\LotteryBundle\\Controller\\DefaultController::euroJackpotPredictionAction',  '_format' => 'json',  '_route' => 'eurojackpot_prediction',);
            }
            not_eurojackpot_prediction:

        }

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
