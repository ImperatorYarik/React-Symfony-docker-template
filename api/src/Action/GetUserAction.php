<?php

namespace App\Action;

use App\Entity\User;
use App\Service\FileGetter;

readonly class GetUserAction
{

    /**
     * @param FileGetter $fileGetter
     */
    public function __construct(private FileGetter $fileGetter)
    {}

    /**
     * @param User $user
     * @return User
     */
    public function __invoke(User $user): User
    {
        $userAvatarName = $user->getAvatar();
        $s3Url = $this->fileGetter->getPresignedUrl($userAvatarName, User::BUCKET_NAME);
        $user->setAvatar($s3Url);
        return $user;
    }

}