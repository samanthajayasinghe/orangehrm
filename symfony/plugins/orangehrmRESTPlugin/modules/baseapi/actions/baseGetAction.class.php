<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
use Orangehrm\Rest\Http\Request;
use Orangehrm\Rest\Http\Response;
use Orangehrm\Rest\Api\Exception\RecordNotFoundException;
use Orangehrm\Rest\Api\Exception\InvalidParamException;

abstract class baseGetAction extends baseOAuthAction {

    /**
     * Check token validation
     */
    public function preExecute() {


        parent::preExecute();

        $server = $this->getOAuthServer();
        $oauthRequest = $this->getOAuthRequest();
        $oauthResponse = $this->getOAuthResponse();
        if (!$server->verifyResourceRequest($oauthRequest, $oauthResponse)) {
            $server->getResponse()->send();
            exit;
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    abstract protected function handleRequest(Request $request);

    /**
     * @param sfRequest $request
     * @return string
     */
    public function execute($request) {

        $httpRequest = new Request($request);
        $response = $this->getResponse();
        $response->setHttpHeader('Content-type', 'application/json');
        try{
            $response->setContent($this->handleRequest($httpRequest)->format());
        } catch (RecordNotFoundException $e){
            $response->setContent(Response::formatError(
                array('error'=>array('status'=>'404','text'=>'Record not found')))
            );
            $response->setStatusCode(404);
        } catch (InvalidParamException $e){
            $response->setContent(Response::formatError(
                array('error'=>array('status'=>'202','text'=>'Invalid Parameter')))
            );
            $response->setStatusCode(202);
        }

        return sfView::NONE;
    }
}
