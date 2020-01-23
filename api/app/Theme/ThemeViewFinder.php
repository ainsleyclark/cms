<?php

namespace App\Theme;

use App\Theme\Theme;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\View\FileViewFinder;

class ThemeViewFinder extends FileViewFinder
{
    /**
     * ThemeViewFinder constructor.
     *
     * @param Filesystem $files
     * @param array $paths
     * @param array|null $extensions
     * @throws Exceptions\ThemeNotFoundException
     */
    public function __construct(Filesystem $files, array $paths, array $extensions = null)
    {
        parent::__construct($files, $paths, $extensions);

        $theme = new Theme();

        $this->paths = $theme->getViewPaths();

        $this->flush();
    }
}