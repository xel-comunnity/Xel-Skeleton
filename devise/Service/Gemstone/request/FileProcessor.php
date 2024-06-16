<?php

namespace Xel\Devise\Service\Gemstone\request;
use Exception;
use Xel\Async\Http\Responses;

trait FileProcessor
{
    protected string $path = __DIR__."/../../../../TempSTR/";
    protected array $data = [];
    protected  array $mimeTypes = [
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // MS Office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    ];

    /**
     * @throws Exception
     */

    public function GetFile():array|null
    {
        return $this->serverRequest->files;
    }

    /**
     * @throws Exception
     */
    public function FileHandlerMove(string $path ='')
    {
        $data = $this->serverRequest->files;

        if (isset($data)){
            if (!is_dir($this->path.$path)) {
                mkdir($this->path.$path, 0777, true);
            }

            try {
                foreach ($data as $file){
                    move_uploaded_file($file['tmp_name'], $this->path.$path."/".$file['name']);
                }
                return $data;

            }catch (Exception $e){
                throw new  Exception($e->getMessage());
            }
        }else{
            throw new Exception("file not found");
        }
    }

    /**
     * @throws Exception
     */
    public function FileHandlerMoveWithRule(array $allowedMimetypes, int $maxSize, bool $randomizeName, string $path = ''): array|false
    {
        $data = $this->serverRequest->files;
        if (empty($data)) {
            throw new Exception("No files uploaded");
        }

        if (!is_dir($this->path . $path)) {
            if (!mkdir($this->path . $path, 0777, true)) {
                throw new Exception("Failed to create directory");
            }
        }

        $processedFiles = [];

        foreach ($data as $file) {
            // Validate file
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Upload error: " . $this->getUploadErrorMessage($file['error']));
            }

            if (!in_array($file['type'], $allowedMimetypes)) {
                throw new Exception("Invalid file type: " . $file['type']);
            }

            if ($file['size'] > $maxSize) {
                throw new Exception("File too large: " . $file['size'] . " bytes");
            }

            // Generate new filename if required
            $filename = $randomizeName ? $this->generateRandomFilename($file['name']) : $file['name'];


            $destination = $this->path . $path . "/" . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $processedFiles[] = [
                    'original_name' => $file['name'],
                    'new_name' => $filename,
                    'type' => $file['type'],
                    'size' => $file['size'],
                    'with_path' => $path."/".$filename
                ];
            } else {
                throw new Exception("Failed to move uploaded file");
            }
        }

        return $processedFiles;
    }


    /**
     * @throws Exception
     */
    public function FileHandlerMoveWithRuleRestFull(array $allowedMimetypes, int $maxSize, bool $randomizeName, string $endpoint, string $path ='images/'): array|false
    {
        $data = $this->serverRequest->files;
        if (empty($data)) {
           return false;
        }

        if (!is_dir($this->path . $path)) {
            if (!mkdir($this->path . $path, 0777, true)) {
                throw new Exception("Failed to create directory");
            }
        }

        $processedFiles = [];

        foreach ($data as $file) {
            // Validate file
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Upload error: " . $this->getUploadErrorMessage($file['error']));
            }

            if (!in_array($file['type'], $allowedMimetypes)) {
                throw new Exception("Invalid file type: " . $file['type']);
            }

            if ($file['size'] > $maxSize) {
                throw new Exception("File too large: " . $file['size'] . " bytes");
            }

            // Generate new filename if required
            $filename = $randomizeName ? $this->generateRandomFilename($file['name']) : $file['name'];


            $destination = $this->path . $path . "/" . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $processedFiles[] = [
                    'original_name' => $file['name'],
                    'new_name' => $filename,
                    'type' => $file['type'],
                    'size' => $file['size'],
                    'with_path' => $path."/".$filename,
                    'with_endpoint' => $_ENV['HOST']."/".$endpoint."/".$filename
                ];
            } else {
                throw new Exception("Failed to move uploaded file");
            }
        }

        return $processedFiles;
    }

    private function generateRandomFilename($originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid() . '.' . $extension;
    }

    private function getUploadErrorMessage($errorCode): string
    {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
            UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
            UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
            UPLOAD_ERR_NO_FILE => "No file was uploaded",
            UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
            UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload",
        ];

        return $errorMessages[$errorCode] ?? "Unknown upload error";
    }

    public function getFileFromSTR(string $path, Responses $response): void
    {
        $file = $this->path.$path;
        if (file_exists($file)) {
            // Get file extension
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            // Determine MIME type
            $mimeType = $this->mimeTypes[$extension] ?? 'application/octet-stream';
            // Send the file as response
            $response->customResponse()->header("Content-Type", $mimeType); // Adjust content type based on your image type
            $response->customResponse()->sendfile($file);
        } else {
            $response->json(["File not found"],false, 404);
        }
    }


    public function getFileRestfull(string $name, Responses $response, string $path = 'images'): void
    {
        $file = $this->path.$path."/".$name;
        if (file_exists($file)) {
            // Get file extension
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            // Determine MIME type
            $mimeType = $this->mimeTypes[$extension] ?? 'application/octet-stream';
            // Send the file as response
            $response->customResponse()->header("Content-Type", $mimeType); // Adjust content type based on your image type
            $response->customResponse()->sendfile($file);
        } else {
            $response->json(["File not found"],false, 404);
        }
    }

    /**
     * Delete a file from the storage
     *
     * @param string $nameFile
     * @param string $dir
     * @return bool|array True if the file was successfully deleted, false otherwise
     */
    public function deleteFileFromSTR(string $nameFile, string $dir): bool|array
    {
        $basename = basename($nameFile);
        $file = $this->path.$dir."/".$basename;
        if (!file_exists($file)) {
           return ["status" => false, "file not found", "code" => 404];
        }

        if (unlink($file)) {
            return true;
        } else {
            return ["status" => false, "file not found", "code" => 404];
        }
    }

}