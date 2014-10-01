<?php
require_once(__DIR__ . "/../core/Database.php");

// The API endpoint that accepts the various API requests that can be made.
class APIEndpoint {

    // The API endpoint function to be executed.
    private $endpointFunction = NULL;
    private $baseShopifyURL = "https://redacted_api_key:redacted_password@jimbos-store.myshopify.com/";
    private $errors = FALSE;
    private $db = NULL;
    private $requestURI = NULL;

    // The API request parameters coming from the POST request body or the GET request parameters
    private $request;

    public function __construct($request, $endpointFunction, $requestURI) {
        $this->endpointFunction = $endpointFunction;
        $this->request = $request;
        $this->requestURI = $requestURI;

        $this->db = new Database();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function execute() {
        $endpointFunction = $this->endpointFunction;
        if ($endpointFunction === NULL) {
            $this->errors = TRUE;
            return FALSE;
        }

        return $this->$endpointFunction();
    }

    public function sync() {
        return $this->syncShopifyProducts();
    }

    public function getProducts() {
        $dataResponse = array ("products"=>array());
        $result = $this->db->query("SELECT * FROM products");
        while ($row = mysql_fetch_assoc($result)) {
            $dataResponse["products"][] = array(
                "sku"=>$row["product_sku"],
                "size"=>$row["product_size"],
                "price"=>$row["product_price"],
                "name"=>$row["product_name"],
                "quantity"=>$row["product_quantity"]
            );
        }

        return $dataResponse;
    }

    public function getProduct() {
        $pieces = explode("/", $this->requestURI);
        $sku = $pieces[3];

        $dataResponse = array ("products"=>array());
        $result = $this->db->query("SELECT * FROM products WHERE product_sku = '".$sku."' LIMIT 1");
        if ($row = mysql_fetch_assoc($result)) {
            $dataResponse["products"][] = array(
                "sku"=>$row["product_sku"],
                "size"=>$row["product_size"],
                "price"=>$row["product_price"],
                "name"=>$row["product_name"],
                "quantity"=>$row["product_quantity"]
            );
        } else {
            $dataResponse = array();
            $dataResponse["errors"] = array("code"=>1000, "message"=>"Product not found");
        }


        return $dataResponse;
    }

    // Get the products from Shopify and sync them:
    // 1) Import in any new products on Shopify to this system
    // 2) For already existing products, update quantities on Shopify with the quantity on this system.
    //    NOTE: updating of quantities NOT implemented
    private function syncShopifyProducts() {
        $shopifyProducts = $this->performCurl("GET", $this->baseShopifyURL, "admin/products.json");
        $dataResponse = array ("products"=>array());
        foreach ($shopifyProducts->products as $product) {
            foreach($product->variants as $variant) {
                $result = $this->db->query("SELECT * FROM products WHERE product_sku = '".$variant->sku."' LIMIT 1");

                if (mysql_num_rows($result) == 0) {
                    // NOTE: there is no scrubbing of the data being input here.
                    $this->db->query("INSERT INTO products (product_name, product_sku, product_quantity, product_price, product_size)
                                          VALUES('".$product->title."','".$variant->sku."','".$variant->inventory_quantity."','".$variant->price."','".$variant->title."')");
                    $dataResponse["products"][] = array(
                        "sku"=>$variant->sku,
                        "size"=>$variant->title,
                        "price"=>$variant->price,
                        "name"=>$product->title,
                        "quantity"=>$variant->inventory_quantity
                    );
                }
            }

        }

        return $dataResponse;
    }

    public function performCurl($method="POST", $baseURL, $action, $params=NULL,$content_type=NULL) {
        // These are set so the respective curl request strings can be output in unit test if desired.
        $url      = $baseURL.$action;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);

        if ($method == "POST") {
            curl_setopt($ch,CURLOPT_POST, 1);
        }

        curl_setopt($ch,CURLOPT_POSTFIELDS, ($params ? json_encode($params) : NULL));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $t_start    = microtime(TRUE);
        $result     = curl_exec($ch);

        $this->response_headers = curl_getinfo($ch);

        curl_close($ch);

        return json_decode($result);
    }
}
?>