<?php
/**
 * Yireo XmlLayoutHints for Magento
 *
 * @author Yireo
 * @copyright Copyright 2015
 * @license Open Source License
 * @link https://www.yireo.com
 */

/*
 * Observer
 */
class Yireo_XmlLayoutHints_Model_Observer
{
    public function coreBlockAbstractToHtmlAfter($observer)
    {
        if (Mage::app()->getStore()->isAdmin()) {
            return $this;
        }

        if ((bool)Mage::getStoreConfig('advanced/modules_disable_output/Yireo_XmlLayoutHints')) {
            return $this;
        }

        $block = $observer->getEvent()->getBlock();
        $transport = $observer->getTransport();
        $layoutName = $block->getNameInLayout();

        $originalHtml = $transport->getHtml();
        $originalHtml = $this->getHtml($layoutName, $originalHtml);

        $transport->setHtml($originalHtml);

        return $this;
    }

    protected function getHtml($title, $content)
    {
        $firstStyle = 'position:relative; border:1px dotted blue; margin:6px 2px; font-size:70%; padding:18px 2px 2px 2px; zoom:1;';
        $secondStyle = 'position:absolute; left:0; top:0; padding:2px 5px; background:blue; color:white; z-index:998;';

        $html = array();
        $html[] = '<div style="'.$firstStyle.'">';
        $html[] = '<div style="'.$secondStyle.'" onmouseover="this.style.zIndex=\'999\'" onmouseout="this.style.zIndex=\'998\'">';
        $html[] = $title;
        $html[] = '</div>';
        $html[] = $content;
        $html[] = '</div>';

        return implode('', $html);
    }
}
