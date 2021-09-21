<?php


namespace App\Services\Breadcrumbs;

use App\Services\BaseService;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

class BreadcrumbsService extends BaseService
{
    /**
     * @throws \Throwable
     */
    public function register(array $pages) : void
    {
        foreach ($pages as $key => $page) {
            $this->setBreadcrumbs($key, $page);
        }
    }

    /**
     * @param $pageKey
     * @param $page
     * @param array $parentPages
     * @throws \Throwable
     */
    private function setBreadcrumbs($pageKey, $page, $parentPages = []): void
    {
        $this->setBreadcrumb($pageKey, $page, $parentPages);

        if (isset($page['children'])) {
            foreach ($page['children'] as $childPageKey => $childPage) {
                $this->setBreadcrumbs($childPageKey, $childPage, [$pageKey => $page]);
            }
        }
    }

    private function setBreadcrumb($pageKey, $page, $parentPages = []): void
    {
        Breadcrumbs::for($pageKey, function (Trail $trail) use ($pageKey, $page, $parentPages) {
            foreach ($parentPages as $parentKey => $parentPage) {
                $trail->parent($parentKey);
            }
            $trail->push($page['name'], $page['uri'] ?? route($pageKey));
        });
    }
}
