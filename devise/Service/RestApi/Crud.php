<?php
    
namespace Xel\Devise\Service\RestApi;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Xel\Async\Router\Attribute\DELETE;
use Xel\Async\Router\Attribute\POST;
use Xel\Async\Router\Attribute\PUT;
use Xel\DB\QueryBuilder\QueryDML;
use Xel\Devise\AbstractService;
use Xel\Async\Http\Responses;
use Xel\Async\Router\Attribute\GET;
use Xel\Devise\Service\Gemstone\request\FileConstants;
class Crud extends AbstractService
{

    /******************************************************************************************************************
     * Display ui
     ******************************************************************************************************************/

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[GET("/crud")]
    public function index(): void
    {
        $this->return
        ->workSpace(function (Responses $response){
            $response->Display('crud/index.php');
        });  
    }
    /******************************************************************************************************************
     * Restfull Logic
     ******************************************************************************************************************/

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */

    #[GET("/crud/blog")]
    public function blog(): void
    {
        $this->return
            ->workSpace(function (Responses $response, QueryDML $queryDML){
               $data = $queryDML
                   ->select()
                   ->from('crud')
                   ->get();
               $response->json($data, 'false', 201);
            });
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[GET("/crud/blog/{id:\d+}")]
    public function blogById($id): void
    {
        $this->return
            ->workSpace(function (Responses $response, QueryDML $queryDML) use ($id){
                $data = $queryDML
                    ->select()
                    ->from('crud')->where('id', '=', $id)
                    ->get();
                $response->json($data, 'false', 201);
            });
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[POST("/crud/create")]
    public function create(): void
    {
        $this->return
            ->workSpace(function (Responses $response, QueryDML $queryDML){
                $data = $this->getRequestFromMultipart([
                    'name' => 'string',
                    'description' => 'string',
                ]);
                try {
                    $image = $this->FileHandlerMoveWithRuleRestFull(
                        [FileConstants::MIME_IMAGE_JPEG, FileConstants::MIME_IMAGE_PNG, FileConstants::MIME_IMAGE_WEBP],
                        5 * 1024 * 1024,
                        true,
                        'crud/images',
                        'images'
                    );
                    $data['image'] = $image[0]['with_endpoint'];

                    $queryDML->insert('crud', $data)->run();
                    $response->json([],'false', 201);

                }catch (Exception $e){
                    $response->json(["response" => $e->getMessage(), "code" => $e->getCode()],'false', 427);
                }

            });
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[PUT("/crud/update/{id:\d+}")]
    public function updateById(int $id): void
    {
        $this->return
            ->workSpace(function (Responses $response, QueryDML $queryDML) use ($id) {
                $data = $this->getRequestFromMultipart();

                $old = $queryDML
                    ->select()
                    ->from('crud')->where('id', '=', $id)
                    ->get();

                try {
                    // Update data first
                    $updateResult = $queryDML->update('crud', $data)->where('id', "=", $id)->run();

                    // Check if update was successful
                    if ($updateResult !== false) {
                        // If update successful, handle image operations
                        if ($old[0]['image'] !== null) {
                            $this->deleteFileFromSTR($old[0]['image'], 'images');
                        }

                        $image = $this->FileHandlerMoveWithRuleRestFull(
                            [FileConstants::MIME_IMAGE_JPEG, FileConstants::MIME_IMAGE_PNG, FileConstants::MIME_IMAGE_WEBP],
                            5 * 1024 * 1024,
                            true,
                            'crud/images',
                            'images'
                        );

                        if (is_array($image)) {
                            $imageData['image'] = $image[0]['with_endpoint'];
                            $imageUpdateResult = $queryDML->update('crud', $imageData)->where('id', "=", $id)->run();

                            if ($imageUpdateResult === false) {
                                throw new Exception("Failed to update image data");
                            }
                        }

                        $response->json(["status" => "success to update data"], false, 201);
                    } else {
                        throw new Exception("Failed to update data");
                    }
                } catch (Exception $e) {
                    $response->json(['error' => $e->getMessage()], false, 427);
                }
            });
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    #[DELETE("/crud/delete/{id:\d+}")]
    public function deleteImageById(int|float $id): void
    {
        $this->return
            ->workSpace(function (Responses $response,  QueryDML $queryDML) use ($id){
                $old = $queryDML
                    ->select()
                    ->from('crud')->where('id', '=', $id)
                    ->get();
                $this->deleteFileFromSTR($old[0]["image"], 'images');
                $queryDML->delete('crud')->where('id', '=', $id)->run();

                $response->json(['success delete data'], false, 201);
            });
    }



    /*******************************************************************************************************************
     * Image Server
     * @throws Exception
     *******************************************************************************************************************/
    #[GET("/crud/images/{name}")]
    public function ImageByName(string $name): void
    {
        $this->return
            ->workSpace(function (Responses $response) use ($name){
               $this->getFileRestfull($name, $response);
            });
    }
}
