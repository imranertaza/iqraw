<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Templates
     * --------------------------------------------------------------------------
     *
     * Pagination links are rendered out using views to configure their
     * appearance. This array contains aliases and the view names to
     * use when rendering the links.
     *
     * Within each view, the Pager object will be available as $pager,
     * and the desired group as $pagerGroup;
     *
     * @var array<string, string>
     */
    public $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
        'custom_full'   => 'CodeIgniter\Pager\Views\custom_full',
        'custom_quiz'   => 'CodeIgniter\Pager\Views\custom_quiz',
        'custom_mcq'   => 'CodeIgniter\Pager\Views\custom_mcq',
        'custom_voc'   => 'CodeIgniter\Pager\Views\custom_voc',
        'custom_course'   => 'CodeIgniter\Pager\Views\custom_course',
    ];

    /**
     * --------------------------------------------------------------------------
     * Items Per Page
     * --------------------------------------------------------------------------
     *
     * The default number of results shown in a single page.
     *
     * @var int
     */
    public $perPage = 20;
}
