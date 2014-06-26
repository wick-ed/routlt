<?php

/**
 * AppserverIo\Routlt\ControllerServletTest
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category  Library
 * @package   Routlt
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/routlt
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Routlt;

/**
 * This is test implementation for the controller servlet implementation.
 *
 * @category  Library
 * @package   Routlt
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://github.com/appserver-io/routlt
 * @link      http://www.appserver.io
 */
class ControllerServletTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The controller servlet instance to test.
     *
     * @var \AppserverIo\Routlt\ControllerServlet
     */
    protected $controller;

    /**
     * Initializes the controller servlet to test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->controller = $this->getMockForAbstractClass('AppserverIo\Routlt\ControllerServlet');
    }

    /**
     * This tests the doGet() method with a request, prepared with a path info.
     *
     * @return void
     */
    public function testDoGetWithPathInfo()
    {

        // create a mock servlet request instance
        $servletRequest = $this->getMock('TechDivision\Servlet\Http\HttpServletRequest');
        $servletRequest->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue('/test'));

        // create a mock servlet response instance
        $servletResponse = $this->getMock('TechDivision\Servlet\Http\HttpServletResponse');

        // create a mock action instance
        $action = $this->getMock('AppserverIo\Routlt\Action');
        $action->expects($this->once())->method('preDispatch');
        $action->expects($this->once())->method('perform');
        $action->expects($this->once())->method('postDispatch');

        // create an array with available routes
        $routes = array('/test*' => $action);

        // assert that the array with the routes will be loaded
        $this->controller->expects($this->once())
            ->method('getRoutes')
            ->will($this->returnValue($routes));

        // invoke the method we want to test
        $this->controller->doGet($servletRequest, $servletResponse);
    }

    /**
     * This tests the doGet() method with a request without any path info.
     *
     * @return void
     */
    public function testDoGetWithoutPathInfo()
    {

        // create a mock servlet request instance
        $servletRequest = $this->getMock('TechDivision\Servlet\Http\HttpServletRequest');

        // create a mock servlet response instance
        $servletResponse = $this->getMock('TechDivision\Servlet\Http\HttpServletResponse');

        // create a mock action instance
        $action = $this->getMock('AppserverIo\Routlt\Action');
        $action->expects($this->once())->method('preDispatch');
        $action->expects($this->once())->method('perform');
        $action->expects($this->once())->method('postDispatch');

        // create an array with available routes
        $routes = array('/index*' => $action);

        // assert that the array with the routes will be loaded
        $this->controller->expects($this->once())
            ->method('getRoutes')
            ->will($this->returnValue($routes));

        // invoke the method we want to test
        $this->controller->doGet($servletRequest, $servletResponse);
    }

    /**
     * This tests the doGet() method with a request without any registered routes.
     *
     * @expectedException TechDivision\Server\Exceptions\ModuleException
     * @return void
     */
    public function testDoGetWithModuleExceptionExpected()
    {

        // create a mock servlet request instance
        $servletRequest = $this->getMock('TechDivision\Servlet\Http\HttpServletRequest');

        // create a mock servlet response instance
        $servletResponse = $this->getMock('TechDivision\Servlet\Http\HttpServletResponse');

        // assert that the array with the routes will be loaded
        $this->controller->expects($this->once())
            ->method('getRoutes')
            ->will($this->returnValue(array()));

        // invoke the method we want to test
        $this->controller->doGet($servletRequest, $servletResponse);
    }

    /**
     * This tests the doPost() method with a request, prepared with a path info.
     *
     * @return void
     */
    public function testDoPostWithPathInfo()
    {
        $servletRequest = $this->getMock('TechDivision\Servlet\Http\HttpServletRequest');
        $servletResponse = $this->getMock('TechDivision\Servlet\Http\HttpServletResponse');

        // create a mock servlet request instance
        $servletRequest = $this->getMock('TechDivision\Servlet\Http\HttpServletRequest');
        $servletRequest->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue('/test'));

        // create a mock servlet response instance
        $servletResponse = $this->getMock('TechDivision\Servlet\Http\HttpServletResponse');

        // create a mock action instance
        $action = $this->getMock('AppserverIo\Routlt\Action');
        $action->expects($this->once())->method('preDispatch');
        $action->expects($this->once())->method('perform');
        $action->expects($this->once())->method('postDispatch');

        // create an array with available routes
        $routes = array('/test*' => $action);

        // assert that the array with the routes will be loaded
        $this->controller->expects($this->once())
            ->method('getRoutes')
            ->will($this->returnValue($routes));

        // invoke the method we want to test
        $this->controller->doPost($servletRequest, $servletResponse);
    }

    /**
     * This tests the init method with mocked servlet configuration.
     *
     * @return void
     */
    public function testInit()
    {

        // initialize the servlet configuration
        $servletConfig = $this->getMock('TechDivision\Servlet\ServletConfig');

        // assert that the array with the routes will be loaded
        $this->controller->expects($this->once())
            ->method('initMappings');
        $this->controller->expects($this->once())
            ->method('initRoutes');

        // invoke the method we want to test
        $this->controller->init($servletConfig);
    }
}
