<?php

namespace Src\BlendedConcept\Organization\Domain\Repositories;

interface PageBuilderInterface
{
    public function generalAssetUrl();
    public function useWebsiteManager();

    public function useRouter();
    public function uploadsUrl();


}
