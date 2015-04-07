<?php

/**
 * AppserverIo\Routlt\Description\WorkflowInterceptor
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/routlt
 * @link       http://www.appserver.io
 */

namespace AppserverIo\Routlt\Interceptors;

use AppserverIo\Routlt\ActionInterface;
use AppserverIo\Routlt\Util\Validateable;
use AppserverIo\Routlt\Util\ValidationAware;
use AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface;

/**
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/routlt
 * @link       http://www.appserver.io
 */
class WorkflowInterceptor extends AbstractInterceptor
{

    /**
     * Method that implements the interceptors functionality.
     *
     * @param AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface $methodInvocation Initially invoked method
     *
     * @return string|null The action result
     */
    protected function execute(MethodInvocationInterface $methodInvocation)
    {

        // get the action, methods and servlet request
        $action = $this->getAction();

        // query whether we want to validate
        if ($action instanceof Validateable) {
            $action->validate();
        }

        // query whether the action is validation aware
        if ($action instanceof ValidationAware) {
            if ($action->hasErrors()) {
                return ActionInterface::FAILURE;
            }
        }

        // proceed invocation chain
        return $methodInvocation->proceed();
    }
}