<?php

namespace Src\BlendedConcept\System\Application\Repositories\Eloquent;

use Src\BlendedConcept\System\Domain\Repositories\PageBuilderInterface;
use HansSchouten\LaravelPageBuilder\LaravelPageBuilder;


class PageBuilderRepository implements PageBuilderInterface
{

    public function generalAssetUrl()
    {
        $builder = new LaravelPageBuilder(config('pagebuilder'));
        $builder->handlePageBuilderAssetRequest();
    }
    public function useWebsiteManager()
    {
        $builder = new LaravelPageBuilder(config('pagebuilder'));
        $builder->handleAuthenticatedRequest();
    }

    public function useRouter()
    {
        $builder = new LaravelPageBuilder(config('pagebuilder'));
        $hasPageReturned = $builder->handlePublicRequest();

        if (request()->path() === '/bc' && !$hasPageReturned) {
            $builder->getWebsiteManager()->renderWelcomePage();
        }
    }
    public function uploadsUrl()
    {
        $builder = new LaravelPageBuilder(config('pagebuilder'));
        $builder->handleUploadedFileRequest();
    }
}
