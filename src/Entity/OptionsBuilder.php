<?php

namespace Zckrs\GenDocApi\Entity;

/**
 * This class represents all options that can be used with the "Builder" service.
 * Options are defined here to avoid lots of parameters in the "Builder" constructor.
 *
 * @package Zckrs\GenDocApi\Entity
 */
class OptionsBuilder
{
    /**
     * @var string The API name displayed in the html output
     */
    protected $apiName;

    /**
     * @var string The API description. Will be displayed at the top of ressources in the output.
     */
    protected $apiDescription;

    /**
     * @var string Name of the output file, without slash (eg: index.html)
     */
    protected $output_file;

    /**
     * @var string The output file will be generated in this directory. Do not required a slash (eg: /www/output)
     */
    protected $output_dir;

    /**
     * @var string Directory that contains all templates used to generate the output
     */
    protected $template_dir;

    /**
     * @var string Directory that contains all assets (like CSS or JS files), included in the output
     */
    protected $asset_dir;

    public function __construct()
    {
        $this->apiName = 'php-gen-doc-api';
        $this->apiDescription = '';
        $this->output_file = 'index.html';
        $this->output_dir = __DIR__ . '/../../web';
        $this->template_dir = __DIR__ . '/../Resources/views';
        $this->asset_dir = __DIR__ . '/../Ressources/assets';
    }

    /**
     * @param string $appDescription
     */
    public function setApiDescription($appDescription)
    {
        $this->apiDescription = $appDescription;
    }

    /**
     * @return string
     */
    public function getApiDescription()
    {
        return $this->apiDescription;
    }

    /**
     * @param string $appName
     */
    public function setApiName($appName)
    {
        $this->apiName = $appName;
    }

    /**
     * @return string
     */
    public function getApiName()
    {
        return $this->apiName;
    }

    /**
     * @param string $asset_dir
     */
    public function setAssetDir($asset_dir)
    {
        $this->asset_dir = $asset_dir;
    }

    /**
     * @return string
     */
    public function getAssetDir()
    {
        return $this->asset_dir;
    }

    /**
     * @param string $output_dir
     */
    public function setOutputDir($output_dir)
    {
        $this->output_dir = $output_dir;
    }

    /**
     * @return string
     */
    public function getOutputDir()
    {
        return $this->output_dir;
    }

    /**
     * @param string $output_file
     */
    public function setOutputFile($output_file)
    {
        $this->output_file = $output_file;
    }

    /**
     * @return string
     */
    public function getOutputFile()
    {
        return $this->output_file;
    }

    /**
     * @param string $template_dir
     */
    public function setTemplateDir($template_dir)
    {
        $this->template_dir = $template_dir;
    }

    /**
     * @return string
     */
    public function getTemplateDir()
    {
        return $this->template_dir;
    }
}
