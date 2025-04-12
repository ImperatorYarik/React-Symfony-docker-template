<?php

namespace App\Action;

use ApiPlatform\Doctrine\Orm\Paginator;
use App\Entity\User;
use App\Service\FileGetter;

readonly class GetCollectionUserAction
{

    /**
     * @param FileGetter $fileGetter
     */
    public function __construct(private FileGetter $fileGetter)
    {
    }

    /**
     * @param Paginator $data
     * @return Paginator
     */
    public function __invoke(Paginator $data): Paginator
    {
        /** @var User $user */
        foreach ($data as $user) {
            $imageUrl = $this->fileGetter->getPresignedUrl($user->getAvatar(), User::BUCKET_NAME);
            $user->setAvatar($imageUrl);
        }

        return $data;
    }

}