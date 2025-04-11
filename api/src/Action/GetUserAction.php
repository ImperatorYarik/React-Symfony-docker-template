<?php

namespace App\Action;

use App\Entity\User;
use App\Service\FileGetter;

readonly class GetUserAction
{
    public function __construct(private FileGetter $fileGetter)
    {}

    public function __invoke(User $user): User
    {
        $userAvatarName = $user->getAvatar();
        $s3Url = $this->fileGetter->getPresignedUrl($userAvatarName, User::BUCKET_NAME);
        $user->setAvatar($s3Url);
        return $user;
    }

}