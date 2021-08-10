# Senior Developer Pre-Interview Test Assignment
Requirement:  Read more [here](./Senior_Dev_Test.pdf)
## Part 1
Please run `composer install` before testing

Please run this command to init system: `php -S 127.0.0.1:8000 -t public`

You can use Postman or any HTTP client to test API.

Endpoint: `http://localhost/test`.

Basic Auth: `demo/pwd1234`

Rrun unit test: `php bin/phpunit`

### Service description
#### Add additional mapping for calculation method
To add mapping for product type id = 4 and calculation method is volume, Go to `config/services.yaml`. Add config for product type id = 4 like below
```
App\Service\TotalCalculatorService:
        arguments:
            $formulaByTypeConfig:
                ...
                3
                    - '@app.calculator_method.by_weight'
                4: 
                    - '@app.calculator_method.by_volume'
                ...
```
You can also apply multi calculation method for each product type like below
```
App\Service\TotalCalculatorService:
        arguments:
            $formulaByTypeConfig:
                ...
                3
                    - '@app.calculator_method.by_weight'
                4: 
                    - '@app.calculator_method.by_volume'
                    - '@app.calculator_method.by_weight'
                ...

```
To add another calculation method (might be by height or something else). Please create Calculator class implement ` App\Service\Calculators\CalculatorInterface`
```
namespace App\Service\Calculators;


use App\Entity\PurchaseOrderProduct;

class HeighCalculator implements CalculatorInterface
{
    public function calculate(PurchaseOrderProduct $purchaseOrderProduct)
    {
        //TODO: add your rule here
    }
}
```
Define your new calculation method as a service in `config/services.yaml`
```
services
    ...
    app.calculator_method.by_heigh:
            class: App\Service\Calculators\HeighCalculator
```

## Part 2
Please see `src/BearClaw/Warehousing/PurchaseOrderService.php`. It's my result.

Please replace `src/BearClaw/Warehousing/TotalCalculator.php` with your code to test.

You can also run `php bin/console app:generate-total-report` to test.

Please remember to start the system before doing any test (`php -S 127.0.0.1:8000 -t public`)
