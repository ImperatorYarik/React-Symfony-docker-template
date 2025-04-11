<?php

namespace App\Service;

use Aws\S3\S3Client;
use Exception;

readonly class FileGetter
{

    /**
     * @param S3Client $s3Client
     */
    public function __construct(private S3Client $s3Client)
    {}

    /**
     * @param string $filename
     * @param string $bucket
     * @return string|null
     */
    public function getPresignedUrl(string $filename, string $bucket): ?string
    {
        try {
            $cmd = $this->s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key' => $filename,
            ]);

            $request = $this->s3Client->createPresignedRequest($cmd, '+20 minutes');
            return (string)$request->getUri();
        }catch (Exception $exception){
            return (string)$exception;
        }
    }

}