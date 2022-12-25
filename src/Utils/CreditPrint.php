<?php

namespace App\Utils;

use DOMDocument;
use SimpleXMLElement;
use XSLTProcessor;

class CreditPrint
{
    public function print(array $data): string
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->arrayToXml($data));
        $xsl = new DOMDocument;
        $xsl->load(__DIR__ . '/../../templates/xsl/payment_table.xsl');
        $proc = new XSLTProcessor;
        $proc->importStyleSheet($xsl);

        return $proc->transformToXML($xml);
    }

    private function arrayToXml(array $data)
    {
        $xml = new SimpleXMLElement('<root/>');
        $root = $xml->addChild('payments');
        foreach ($data as $item) {
            $parent = $root->addChild('payment');

            foreach ($item as $key => $value) {
                $parent->addChild($key, $value);
            }
        }

        return $xml->asXML();
    }
}