<?php

namespace App\Service;

use Aws\S3\S3Client;

class FileUploader
{
    public function __construct(private S3Client $s3Client)
    {}

    public function uploadFile($file, string $bucket)
    {
        if ($file && $file->isValid() !== null && $file->getSize() > 0) {
            $fileName = $file->getClientOriginalName();
            $serverFileName = md5(uniqid(rand(), true)) . '.' . $file->getClientOriginalExtension();

            $file = fopen($file->getPathName(), 'r');
            if ($file) {
                $this->s3Client->putObject([
                   'Bucket' => $bucket,
                   'Key' => $serverFileName,
                   'Body' => $file,
                ]);

                fclose($file);

                return [
                    'Title' => 'File with name' . $serverFileName . ' uploaded successfully!',
                    'FileName' => $serverFileName,
                    'IsTrue' => true,
                ];
            }else{
                return [
                    'Title' => 'File with name' . $fileName . ' is not uploaded!',
                    'IsTrue' => false,
                ];
            }
        }

        return [
            'Title' => 'File did not opened!',
            'IsTrue' => false,
        ];
    }
}