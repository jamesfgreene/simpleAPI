<?php
namespace simpleAPI\API;

class APIRouter {

    private $APIRequest         = NULL;
    private $endpointFunction   = NULL;
    private $errors             = FALSE;

    public function __construct($APIRequest) {
        $server = $APIRequest->getServer();

        if ($server["REQUEST_METHOD"] === "GET") {


			$server["REQUEST_URI"] = array_shift(explode("?", $server["REQUEST_URI"]));
			
			switch ($server["REQUEST_URI"]) {
			    case "/api/checksum":
                    $this->setEndpointFunction("generateChecksum");
                break;

				case "/api/checkchecksum":
                    $this->setEndpointFunction("checkChecksum");
                break;
				
				case "/api/products":
                    $this->setEndpointFunction("getProducts");
                break;

                // For routes that match /api/products/<product_id>
                case preg_match("/^\/api\/products\/[a-zA-Z0-9\-_]+$/", $server["REQUEST_URI"]) == TRUE:
                    $this->setEndpointFunction("getProduct");
                break;

                default:
                    $this->errors = TRUE;
                break;
            }
        }
        elseif ($server["REQUEST_METHOD"] === "POST") {
            if ($server["REQUEST_URI"] === "/api/sync") {
                $this->setEndpointFunction("sync");
            } else {
                $this->errors = TRUE;
            }
        } else {
            $this->errors = TRUE;
        }

    }

    public function hasErrors() {
        return $this->errors;
    }

    public function getEndpointFunction() {
        return $this->endpointFunction;
    }

    public function setEndpointFunction($endpointFunction) {
        $this->endpointFunction = $endpointFunction;
    }
}
?>