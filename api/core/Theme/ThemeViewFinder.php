<?php

namespace Core\Theme;

use Illuminate\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;

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