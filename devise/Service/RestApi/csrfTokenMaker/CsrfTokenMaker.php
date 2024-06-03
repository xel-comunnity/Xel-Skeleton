<?php
namespace Xel\Devise\Service\RestApi\csrfTokenMaker;
use Xel\Async\Http\Responses;
use Xel\Async\Router\Attribute\GET;
use Xel\Devise\AbstractService;

class CsrfTokenMaker extends AbstractService
{
    #[GET("/xel-csrf")]
    public function test(){
        $this->return
            ->workSpace(function(Responses $responses){
                $csrfToken = $this->xelCsrfManager()->generateCSRFToken();
                $responses->json(['X-CSRF-Token' => $csrfToken], false, 200);
            }
        );
    }
}
