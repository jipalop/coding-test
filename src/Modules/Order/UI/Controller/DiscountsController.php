<?php
declare(strict_types=1);

namespace App\Modules\Order\UI\Controller;

use App\Exceptions\DomainException;
use App\Modules\Order\Application\Discounts\ApplyDiscounts\ApplyDiscountsCommand;
use App\Modules\Order\Application\OrderResponseConverter;
use App\Modules\Order\Domain\Order;
use App\Modules\Shared\Domain\Bus\Command\CommandBus;
use Swaggest\JsonSchema\InvalidValue;
use Swaggest\JsonSchema\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Swaggest\JsonSchema\Exception as SwaggestJsonException;

class DiscountsController extends AbstractController
{
    public function __construct(private readonly CommandBus $bus)
    {
    }

    private const string JSON_SCHEMA = <<<'JSON'
        {
            "$schema": "http://json-schema.org/draft-07/schema#",
              "type": "object",
              "properties": {
                "id": {
                  "type": "string"
                },
                "customer-id": {
                  "type": "string"
                },
                "items": {
                  "type": "array",
                  "items": {
                    "type": "object",
                    "properties": {
                      "product-id": {
                        "type": "string"
                      },
                      "quantity": {
                        "type": "string",
                        "pattern": "^[0-9]+$"
                      },
                      "unit-price": {
                        "type": "string",
                        "pattern": "^[0-9]+(.[0-9]{1,2})?$"
                      },
                      "total": {
                        "type": "string",
                        "pattern": "^[0-9]+(.[0-9]{1,2})?$"
                      }
                    },
                    "required": ["product-id", "quantity", "unit-price", "total"]
                  }
                },
                "total": {
                  "type": "string",
                  "pattern": "^[0-9]+(.[0-9]{1,2})?$"
                }
              },
              "required": ["id", "customer-id", "items", "total"]
        }
        JSON;

    #[Route('/discounts', name: 'app_discounts')]
    public function apply(Request $request): Response
    {
        $body = $request->getContent();

        try {

            Schema::import(json_decode(self::JSON_SCHEMA))->in(json_decode($body));
            $order = Order::fromJson($body);
            $this->bus->dispatch(new ApplyDiscountsCommand($order));
            $orderResponse = (new OrderResponseConverter())($order);

            return JsonResponse::fromJsonString(json_encode($orderResponse->toPlain()));

        } catch (InvalidValue|JsonException| SwaggestJsonException $e) {
            return new Response("JSON validation error: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        catch (DomainException $e) {
            return new Response("Invalid request: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        catch (Exception $e) {
            return new Response("Unhandled error: " . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
