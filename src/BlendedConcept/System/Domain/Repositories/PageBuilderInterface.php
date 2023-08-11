<?php

namespace Src\BlendedConcept\System\Domain\Repositories;

interface PageBuilderInterface
{
    public function generalAssetUrl();

    public function useWebsiteManager();

    public function useRouter();

    public function uploadsUrl();
}
