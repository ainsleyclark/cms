<?php

namespace Core\Theme;

use Core\Support\Facades\Theme;
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
     */
    public function __construct(Filesystem $files, array $paths, array $extensions = null)
    {
        parent::__construct($files, $paths, $extensions);

        $this->paths = Theme::getViewPaths();

        $this->flush();
    }
}