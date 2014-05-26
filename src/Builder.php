<?php

namespace Zckrs\GenDocApi;

use Zckrs\GenDocApi\Extractor;
use Zckrs\GenDocApi\Entity\OptionsBuilder;

class Builder
{
    /**
     * Version number
     *
     * @var string
     */
    const VERSION = '1.4';

    /**
     * Array of classes that contains annotations used to generate the output
     *
     * @var array
     */
    private $classes;

    /**
     * Options and configuration for the current job
     *
     * @var OptionsBuilder
     */
    private $options;

    /**
     * @param array                 $classes    Classes that contains annotations used to generate the output
     * @param Entity\OptionsBuilder $options    Options and configuration for the current job
     */
    public function __construct(array $classes, OptionsBuilder $options = null)
    {
        $this->classes = $classes;
        $this->options = $options ? $options : new OptionsBuilder();
    }

    public function getTemplate($filePath)
    {
        if (!file_exists($file = $this->options->getTemplateDir() . '/' . $filePath)) {
            $file = __DIR__ . '/Resources/views/' . $filePath;
        }

        return file_get_contents($file);
    }

    public function getAsset($filePath)
    {
        if (!file_exists($file = $this->options->getAssetDir() . '/' . $filePath)) {
            $file = __DIR__ . '/Resources/assets/' . $filePath;
        }

        return file_get_contents($file);
    }

    /**
     * Extract annotations
     *
     * @return array
     */
    private function extractAnnotations()
    {
        foreach ($this->classes as $class) {
            $st_output[] = Extractor::getAllClassAnnotations($class);
        }

        return end($st_output);
    }

    private function saveTemplate($content, $anchorMenu, $file)
    {
        $oldContent = $this->getTemplate('layout.html');

        $arrayCss = array();
        $arrayCss[] = $this->getAsset('css/css.css');

        $arrayJs = array();
        $arrayJs[] = $this->getAsset('js/js.js');

        $tr = array(
            '{{ app_name }}'        => $this->options->getApiName(),
            '{{ app_description }}' => $this->options->getApiDescription(),
            '{{ content }}'         => $content,
            '{{ anchor_menu }}'     => $anchorMenu,
            '{{ date }}'            => date('Y-m-d, H:i:s'),
            '{{ version }}'         => static::VERSION,
            '{{ css }}'             => implode(PHP_EOL, $arrayCss),
            '{{ js }}'              => implode(PHP_EOL, $arrayJs),
        );
        $newContent = strtr($oldContent, $tr);

        if (!is_dir($this->options->getOutputDir())) {
            if (!@mkdir($this->options->getOutputDir())) {
                throw new \Exception("Cannot create directory ".$this->options->getOutputDir()."\n");
            }
        }
        if (!@file_put_contents($this->options->getOutputDir() . '/' . $file, $newContent)) {
            throw new \Exception("Cannot save the content to ".$this->options->getOutputDir()."\n");
        }
    }

    /**
     * Generate the content of the documentation
     *
     * @return boolean
     */
    private function generateTemplate()
    {
        $st_annotations = $this->extractAnnotations();

        $template = array();
        $anchorMenu = array();

        $counter = 0;
        $currentSection = null;

        $contentMainTpl  = $this->getTemplate('content/contentMain.html');
        $sectionTitleTpl = $this->getTemplate('content/sectionTitle.html');

        $anchorTpl = $this->getTemplate('menu/anchor.html');

        foreach ($st_annotations as $class => $methods) {
            foreach ($methods as $name => $docs) {
                // No @Api define in current method
                if (0 === count($docs)) {
                    continue;
                }

                // Create a section title and entry menu if @ApiDescription change
                if (isset($docs['ApiDescription'][0]['section']) && $docs['ApiDescription'][0]['section'] !== $currentSection) {
                    $template[] = strtr($sectionTitleTpl, array(
                        '{{ elt_id }}'  => $counter,
                        '{{ section }}' => $docs['ApiDescription'][0]['section'],
                    ));

                    $anchorMenu[] = strtr($anchorTpl, array(
                        '{{ elt_id }}'  => $counter,
                        '{{ section }}' => $docs['ApiDescription'][0]['section'],
                    ));

                    $currentSection = $docs['ApiDescription'][0]['section'];
                }

                // Translate variables by values
                $tr = array(
                    '{{ elt_id }}'  => $counter,
                    '{{ method }}'  => $this->generateBadgeForMethod($docs),
                    '{{ route }}'   => $docs['ApiRoute'][0]['url'],
                    '{{ implementation_notes }}' => $this->generateImplementationNotes($docs, $counter),
                    '{{ response_classes }}'     => $this->generateResponseClasses($docs, $counter),
                    '{{ path_parameters }}'      => $this->generateParamsTemplate($docs, $counter),
                );
                $template[] = strtr($contentMainTpl, $tr);

                // Create a anchor for each ApiReturnObject['section']
                //$anchorMenu[] = $this->generateAnchorMenu($docs, $counter);

                $counter++;
            }
        }

        $this->saveTemplate(implode(PHP_EOL, $template), implode(PHP_EOL, $anchorMenu), $this->options->getOutputFile());

        return true;
    }

    /**
     * Generate the root sample JSON object
     *
     * @param  array   $st_params
     * @param  integer $counter
     * @return string
     */
    private function generateRootSample($st_params)
    {
        if (!isset($st_params['ApiReturnRootSample'][0])) {
            return '';
        }

        $rootSampleTpl = $this->getTemplate('content/responseClasses/rootSample.html');

        return strtr($rootSampleTpl, array(
            '{{ sample_root_object }}' => $st_params['ApiReturnRootSample'][0]['sample'],
        ));
    }

    /**
     * Generate anchor menu item
     *
     * @param  array   $st_params
     * @param  integer $counter
     * @return string
     * @todo Generate anchor menu based on different section (not ApiReturnObject)
     */
    /*private function generateAnchorMenu($st_params, $counter)
    {
        if (!isset($st_params['ApiReturnObject'][0])) {
            return '';
        }

        $ret = array();
        $sections = array();

        foreach ($st_params['ApiReturnObject'] as $params) {

            if (!in_array($params['section'], $sections)) {
                $ret[] = strtr('&nbsp;&nbsp;&nbsp;<a href="#{{ section }}_anchor_{{ elt_id }}">{{ section }}</a><br/>',
                    array(
                        '{{ elt_id }}'  => $counter,
                        '{{ section }}' => $params['section'],
                    )
                );
                array_push($sections, $params['section']);
            }
        }

        return implode(PHP_EOL, $ret);
    }
    */

   /**
     * Generates section "Implementation Notes" for one method
     *
     * @param  int         $id
     * @param  array       $st_params
     *
     * @return string
     */
    private function generateImplementationNotes($st_params, $counter)
    {
        if (!isset($st_params['ApiDescription']))
        {
            return '';
        }
        //$docs['ApiDescription'][0]['description']
        $descTpl  = $this->getTemplate('content/implementationNotes/main.html');

        return strtr($descTpl, array(
            '{{ elt_id }}'  => $counter,
            '{{ content }}' => $st_params['ApiDescription'][0]['description'],
        ));
    }

    /**
     * Generates section "Response Classes" for one method
     *
     * @param  array   $st_params
     * @param  integer $counter
     *
     * @return string
     */
    private function generateResponseClasses($st_params, $counter)
    {
        if (!isset($st_params['ApiReturnObject'])) {
            return '';
        }

        $mainTpl    = $this->getTemplate('content/responseClasses/main.html');
        $tHeaderTpl = $this->getTemplate('content/responseClasses/tableHeaderSection.html');
        $bodyTpl    = $this->getTemplate('content/responseClasses/body.html');
        $linkTpl    = $this->getTemplate('content/responseClasses/link.html');

        $ret = array();
        $sections = array();

        foreach ($st_params['ApiReturnObject'] as $params) {

            $tr = array(
                '{{ elt_id }}' => $counter,
                '{{ name }}'   => $params['name'],
                '{{ type }}'   => $params['type'],
                '{{ note }}'   => @$params['note'],
                '{{ desc }}'   => @$params['desc'],
            );

            if (isset($params['link'])) {
                $tr['{{ desc }}'] .= ' '.strtr($linkTpl, array(
                    '{{ elt_id }}' => $counter,
                    '{{ link }}'   => $params['link'],
                ));
            }

            if (!in_array($params['section'], $sections)) {
                $ret[] = strtr($tHeaderTpl, array(
                    '{{ elt_id }}'  => $counter,
                    '{{ section }}' => $params['section'],
                ));
                array_push($sections, $params['section']);
            }

            $ret[] = strtr($bodyTpl, $tr);
        }


        return strtr($mainTpl, array(
            '{{ elt_id }}' => $counter,
            '{{ responseTableBody }}'  => implode(PHP_EOL, $ret),
            '{{ sample_root_object }}' => $this->generateRootSample($st_params),
        ));
    }

    /**
     * Generates section "Path Parameters" for one method
     *
     * @param  int   $id
     * @param  array $st_params
     *
     * @return string
     */
    private function generateParamsTemplate($st_params, $counter)
    {
        $mainTpl    = $this->getTemplate('content/pathParameters/main.html');
        $tBodyTpl   = $this->getTemplate('content/pathParameters/tBody.html');
        $popoverTpl = $this->getTemplate('content/pathParameters/popover.html');

        $body = array();
        if (isset($st_params['ApiParams'])) {
            foreach ($st_params['ApiParams'] as $params) {
                $tr = array(
                    '{{ name }}'        => $params['name'],
                    '{{ type }}'        => $params['type'],
                    '{{ nullable }}'    => @$params['nullable'] == '1' ? 'optional' : 'required',
                    '{{ description }}' => @$params['description'],
                );
                if (isset($params['sample'])) {
                    $tr['{{ type }}'].= ' '.strtr($popoverTpl, array('{{ sample }}' => $params['sample']));
                }
                $body[] = strtr($tBodyTpl, $tr);
            }
        }

        return strtr($mainTpl, array(
            '{{ elt_id }}' => $counter,
            '{{ method }}' => $st_params['ApiMethod'][0]['type'],
            '{{ route }}'  => $st_params['ApiRoute'][0]['url'],
            '{{ tbody }}' => implode(PHP_EOL, $body),
        ));
    }

    /**
     * Generates a badge for method
     *
     * @param  array  $data
     * @return string
     */
    private function generateBadgeForMethod($data)
    {
        $method = strtoupper($data['ApiMethod'][0]['type']);
        $st_labels = array(
            'POST'   => 'label-primary',
            'GET'    => 'label-success',
            'PUT'    => 'label-warning',
            'DELETE' => 'label-danger'
        );

        return '<span class="label '.$st_labels[$method].'">'.$method.'</span>';
    }

    /**
     * Build the docs
     */
    public function generate()
    {
        return $this->generateTemplate();
    }

}
