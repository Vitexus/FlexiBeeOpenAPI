<?php

namespace FlexiBee;

use Ease\Atom;
use FlexiPeeHP\EvidenceList;
use FlexiPeeHP\FlexiBeeRO;
use erasys\OpenApi\Spec\v3 as OASv3;

/**
 * Description of Struct
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class Struct extends FlexiBeeRO
{

    function describe($suffix = '')
    {
        return 'FlexiBee '.str_replace('://', '://'.$this->user.'@',
                $this->getApiUrl()).' FlexiBeeHP v'.self::$libVersion.' (FlexiBee '.EvidenceList::$version.') EasePHP Framework v'.Atom::$frameworkVersion.' '.
            $suffix;
    }

    public function getPathItems()
    {
        $pathItems = [];
        $pathItems = \array_merge($pathItems, $this->getPathEvidenceItems());
        return $pathItems;
    }

    public function getServers()
    {
        $variables = ['company' =>  new OASv3\ServerVariable($this->company, 'company used')];
        return ['servers' => [ new OASv3\Server($this->url.'/c/{company}',
                'FlexiBee '.EvidenceList::$version, $variables)]];
    }

    public function getPathEvidenceItems()
    {
        $evidenceItems = [];
        foreach (array_keys(EvidenceList::$evidences) as $path) {
            $evidenceItems['/c/'.$this->company.'/'.$path] = new OASv3\PathItem($this->getEvidenceOperations($path));
        }
        return $evidenceItems;
    }

    public function getEvidenceOperations($path)
    {
        return [
            'get' => new OASv3\Operation(
                [
                '200' => new OASv3\Response('Evidence Listing'),
                'default' => new OASv3\Response('Default response.'),
                ]
            ),
            'put' => new OASv3\Operation(
                [
                '201' => new OASv3\Response('Item was inserted into evedence.'),
                'default' => new OASv3\Response('Default error response.'),
                ]
            ),
            'post' => new OASv3\Operation(
                [
                '201' => new OASv3\Response('Item was inserted into evidence'),
                'default' => new OASv3\Response('Default error response.'),
                ]
            ),
            'delete' => new OASv3\Operation(
                [
                '200' => new OASv3\Response('Item was removed'),
                'default' => new OASv3\Response('Default error response.'),
                ]
            )
        ];
    }
}
