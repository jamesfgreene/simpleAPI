<?php
namespace simpleAPI\API;

class APIRequest {

    private $server;
    private $request;
    private $response;

    public function __construct($server, $request) {
        $this->server   = $server;
        $this->request  = $request;

        $router = new APIRouter($this);
        if ($router->hasErrors()) {
            echo "Invalid API Request route";
        } else {
            $endpoint = new APIEndpoint($request, $router->getEndpointFunction(), $server["REQUEST_URI"]);

            // Execute the API endpoint request
            $responseData = $endpoint->execute();

            // Take the data in associative array format and build it in JSON format.
            echo $this->buildResponseJSON($responseData);
        }
    }

    public function getResponse() {
        return $this->response->getResponse();
    }


    public function setResponse($response) {
        $this->response($response);
    }


    //
    public function buildResponseJSON($responseData) {

        header("Content-Type:application/json");
        $dataResponse = array ();
        $dataResponse = $responseData;

        $dataResponse["success"] = array_key_exists("errors", $dataResponse) ? false : true;

        return json_encode($dataResponse);
    }

    public function getServer() {
        return $this->server;
    }

    public function getRequest() {
        return $this->request;
    }
}

?>