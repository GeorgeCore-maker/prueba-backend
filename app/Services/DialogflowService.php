<?php

namespace App\Services;

use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;
use App\Services\ProductService;
use App\Services\CategoryService;
use Exception;
use Google\Cloud\Dialogflow\V2\Client\SessionsClient as ClientSessionsClient;
use Google\Cloud\Dialogflow\V2\DetectIntentRequest;

class DialogflowService
{
    protected $projectId;
    protected $sessionId;
    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->projectId = env('DIALOGFLOW_PROJECT_ID');
        $this->sessionId = uniqid();
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function sendTextQuery($text)
    {
        $sessionsClient = new ClientSessionsClient();
        $session = $sessionsClient->sessionName($this->projectId, $this->sessionId);

        // Convertir el texto a minúsculas para una comparación insensible a mayúsculas/minúsculas
        $text = strtolower($text);

        // Crear el TextInput
        $textInput = new TextInput();
        $textInput->setText($text);
        $textInput->setLanguageCode('es');

        // Crear el QueryInput
        $queryInput = new QueryInput();
        $queryInput->setText($textInput);

        // Crear el DetectIntentRequest
        $detectIntentRequest = new DetectIntentRequest();
        $detectIntentRequest->setSession($session);
        $detectIntentRequest->setQueryInput($queryInput);

        try {
            // Lista de saludos con patrones flexibles (por ejemplo, "ola", "hola", "buenas" etc.)
            $saludosPatrones = [
                '/\b(hola|ola|saludos|qué\s*tal|buenos?\s*(d(i|í)as|tardes|noches))\b/i', // Permite "dias" con o sin tilde
                '/\b(hey|saludos|bienvenido)\b/i' // Otros saludos comunes
            ];

            // Verificar si el texto coincide con cualquiera de los patrones de saludo
            foreach ($saludosPatrones as $patron) {
                if (preg_match($patron, $text)) {
                    // Si es un saludo, redirigirlo a Dialogflow
                    $response = $sessionsClient->detectIntent($detectIntentRequest);
                    $queryResult = $response->getQueryResult();

                    // DialogFlow intent para saludo
                    return $queryResult->getFulfillmentText();
                }
            }

            // Si se menciona "producto" o "productos", mostramos todos los productos
            if (stripos($text, 'producto') !== false || stripos($text, 'productos') !== false) {
                $products = $this->productService->getAllProducts();
                // Si no hay productos, no mostrar el mensaje fijo sino llamar a Dialogflow
                if ($products->isEmpty()) {
                    $response = $sessionsClient->detectIntent($detectIntentRequest);
                    $queryResult = $response->getQueryResult();
                    return $queryResult->getFulfillmentText(); // Respuesta general de Dialogflow
                }
                return $this->formatProductResponse($products);
            }

            // Si se menciona "categoria" o "categorias", mostramos todos las categorias
            if (stripos($text, 'categoria') !== false || stripos($text, 'categorias') !== false) {
                $categories = $this->categoryService->getAllCategories();
                return $this->formatCategoryResponse($categories);
            }

            // Buscar tanto en productos como en categorías
            $searchTerm = $this->extractSearchTerm($text);

            if ($searchTerm) {
                $products = $this->productService->getProductByName($searchTerm);
                $categories = $this->categoryService->getCategoryByName($searchTerm);

                return $this->formatDetailedResponse($products, $categories);
            }

            // Si no se menciona un producto específico, devolvemos la respuesta de Dialogflow
            $response = $sessionsClient->detectIntent($detectIntentRequest);
            $queryResult = $response->getQueryResult();
            return $queryResult->getFulfillmentText(); // Respuesta general de Dialogflow

        } catch (Exception $e) {
            return 'Error al procesar la solicitud: ' . $e->getMessage();
        }
    }


    private function extractSearchTerm($text)
    {
        // Capturar un término de búsqueda que podría estar en cualquier parte del texto
        $pattern = '/\b(?:producto|productos|categoria|categorias)?\s*([a-zA-Z0-9\s]+)/i';

        preg_match($pattern, $text, $matches);

        // Si encontramos una coincidencia, devolvemos el término
        if (isset($matches[1])) {
            $searchTerm = trim($matches[1]);

            // Filtrar términos que sean demasiado genéricos o cortos
            if (strlen($searchTerm) < 3 || !preg_match('/^[a-zA-Z0-9\s]+$/', $searchTerm)) {
                return null;
            }

            return $searchTerm;
        }

        return null;
    }

    private function formatCombinedResponse($searchTerm, $productCount, $categoryCount)
    {
        $response = "Resultados para '{$searchTerm}':<hr>";

        $response .= "Productos encontrados: {$productCount}<br>";
        $response .= "Categorías encontradas: {$categoryCount}<br>";

        if ($productCount === 0 && $categoryCount === 0) {
            $response .= "No se encontraron resultados para '{$searchTerm}'.<br>";
        }

        return $response;
    }

    private function extractCategoryName($text)
    {
        // Este patrón captura un nombre de categoría que podría estar en cualquier parte del texto
        $pattern = '/\b(?:categoria|categorias)?\s*([a-zA-Z0-9\s]+)/i';  // Patrón ajustado

        preg_match($pattern, $text, $matches);

        // Si encontramos una coincidencia, devolvemos el nombre de la categoría
        if (isset($matches[1])) {
            $categoryName = trim($matches[1]);

            // Filtramos nombres de categorías que son demasiado genéricos o cortos
            if (strlen($categoryName) < 3 || !preg_match('/^[a-zA-Z0-9\s]+$/', $categoryName)) {
                return null; // Si el nombre es demasiado corto o no es alfanumérico, lo descartamos
            }

            return $categoryName;
        }

        // Si no se encuentra una categoría, devolver null
        return null;
    }



    private function formatProductResponse($products)
    {
        // Inicia la respuesta con "Productos disponibles:" y luego un salto de línea
        $response = 'Productos disponibles: <hr>';

        // Recorrer los productos y añadirlos a la respuesta
        foreach ($products as $product) {
            $response .= "{$product->name}, con {$product->quantity} en stock.<br>";
        }

        return $response;
    }

    private function formatCategoryResponse($categories)
    {
        // Inicia la respuesta con "Categorías disponibles:" y luego un salto de línea
        $response = 'Categorías disponibles: <hr>';

        foreach ($categories as $category) {
            $response .= "{$category->name}: {$category->total_products} productos en total.<br>";
        }

        return $response;
    }

    private function formatDetailedResponse($products, $categories)
    {
        $response = "";

        // Detallar los productos encontrados
        if ($products->isNotEmpty()) {
            $response .= "Productos encontrados:<hr>";
            foreach ($products as $product) {
                $response .= "{$product->name} con {$product->quantity} unidades en stock.<br>";
            }
        } else {
            $response .= "No se encontraron productos con ese nombre.<br>";
        }

        // Detallar las categorías encontradas
        if ($categories->isNotEmpty()) {
            $response .= "<br>Categorías encontradas:<hr>";
            foreach ($categories as $category) {
                $totalUnits = $category->products->sum('quantity');
                $totalProducts = $category->products->count();
                $response .= "{$category->name} con {$totalUnits} unidades en total y {$totalProducts} productos disponibles.<br>";
            }
        } else {
            $response .= "No se encontraron categorías con ese nombre.<br>";
        }

        return $response;
    }

}
