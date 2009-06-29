<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Amazon
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Item.php 8064 2008-02-16 10:58:39Z thomas $
 */


/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Amazon
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_Amazon_Item
{
    public $ASIN;
    public $DetailPageURL;
    public $SalesRank;
    public $SmallImage;
    public $MediumImage;
    public $LargeImage;
    public $Subjects;
    public $Offers;
    public $CustomerReviews;
    public $SimilarProducts;
    public $Accessories;
    public $Tracks;
    public $ListmaniaLists;
    public $PromotionalTag;

    protected $_dom;


    /**
     * Parse the given <Item> element
     *
     * @param  DOMElement $dom
     * @return void
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('az', 'http://webservices.amazon.com/AWSECommerceService/2005-10-05');
        $this->ASIN = $xpath->query('./az:ASIN/text()', $dom)->item(0)->data;

        $result = $xpath->query('./az:DetailPageURL/text()', $dom);
        if ($result->length == 1) {
            $this->DetailPageURL = $result->item(0)->data;
        }

        if ($xpath->query('./az:ItemAttributes/az:ListPrice', $dom)->length >= 1) {
            $this->CurrencyCode = (string) $xpath->query('./az:ItemAttributes/az:ListPrice/az:CurrencyCode/text()', $dom)->item(0)->data;
            $this->Amount = (int) $xpath->query('./az:ItemAttributes/az:ListPrice/az:Amount/text()', $dom)->item(0)->data;
            $this->FormattedPrice = (string) $xpath->query('./az:ItemAttributes/az:ListPrice/az:FormattedPrice/text()', $dom)->item(0)->data;
        }

        $result = $xpath->query('./az:ItemAttributes/az:*/text()', $dom);
        if ($result->length >= 1) {
            foreach ($result as $v) {
                if (isset($this->{$v->parentNode->tagName})) {
                    if (is_array($this->{$v->parentNode->tagName})) {
                        array_push($this->{$v->parentNode->tagName}, (string) $v->data);
                    } else {
                        $this->{$v->parentNode->tagName} = array($this->{$v->parentNode->tagName}, (string) $v->data);
                    }
                } else {
                    $this->{$v->parentNode->tagName} = (string) $v->data;
                }
            }
        }

        foreach (array('SmallImage', 'MediumImage', 'LargeImage') as $im) {
            $result = $xpath->query("./az:ImageSets/az:ImageSet[position() = 1]/az:$im", $dom);
            if ($result->length == 1) {
                /**
                 * @see Zend_Service_Amazon_Image
                 */
                require_once 'Zend/Service/Amazon/Image.php';
                $this->$im = new Zend_Service_Amazon_Image($result->item(0));
            }
        }

        $result = $xpath->query('./az:SalesRank/text()', $dom);
        if ($result->length == 1) {
            $this->SalesRank = (int) $result->item(0)->data;
        }

        $result = $xpath->query('./az:CustomerReviews/az:Review', $dom);
        if ($result->length >= 1) {
            /**
             * @see Zend_Service_Amazon_CustomerReview
             */
            require_once 'Zend/Service/Amazon/CustomerReview.php';
            foreach ($result as $review) {
                $this->CustomerReviews[] = new Zend_Service_Amazon_CustomerReview($review);
            }
            $this->AverageRating = (float) $xpath->query('./az:CustomerReviews/az:AverageRating/text()', $dom)->item(0)->data;
            $this->TotalReviews = (int) $xpath->query('./az:CustomerReviews/az:TotalReviews/text()', $dom)->item(0)->data;
        }

        $result = $xpath->query('./az:EditorialReviews/az:*', $dom);
        if ($result->length >= 1) {
            /**
             * @see Zend_Service_Amazon_EditorialReview
             */
            require_once 'Zend/Service/Amazon/EditorialReview.php';
            foreach ($result as $r) {
                $this->EditorialReviews[] = new Zend_Service_Amazon_EditorialReview($r);
            }
        }

        $result = $xpath->query('./az:SimilarProducts/az:*', $dom);
        if ($result->length >= 1) {
            /**
             * @see Zend_Service_Amazon_SimilarProduct
             */
            require_once 'Zend/Service/Amazon/SimilarProduct.php';
            foreach ($result as $r) {
                $this->SimilarProducts[] = new Zend_Service_Amazon_SimilarProduct($r);
            }
        }

        $result = $xpath->query('./az:ListmaniaLists/*', $dom);
        if ($result->length >= 1) {
            /**
             * @see Zend_Service_Amazon_ListmaniaList
             */
            require_once 'Zend/Service/Amazon/ListmaniaList.php';
            foreach ($result as $r) {
                $this->ListmaniaLists[] = new Zend_Service_Amazon_ListmaniaList($r);
            }
        }

        $result = $xpath->query('./az:Tracks/az:Disc', $dom);
        if ($result->length > 1) {
            foreach ($result as $disk) {
                foreach ($xpath->query('./*/text()', $disk) as $t) {
                    $this->Tracks[$disk->getAttribute('number')] = (string) $t->data;
                }
            }
        } else if ($result->length == 1) {
            foreach ($xpath->query('./*/text()', $result->item(0)) as $t) {
                $this->Tracks[] = (string) $t->data;
            }
        }

        $result = $xpath->query('./az:Offers', $dom);
        $resultSummary = $xpath->query('./az:OfferSummary', $dom);
        if ($result->length > 1 || $resultSummary->length == 1) {
            /**
             * @see Zend_Service_Amazon_OfferSet
             */
            require_once 'Zend/Service/Amazon/OfferSet.php';
            $this->Offers = new Zend_Service_Amazon_OfferSet($dom);
        }

        $result = $xpath->query('./az:Accessories/*', $dom);
        if ($result->length > 1) {
            /**
             * @see Zend_Service_Amazon_Accessories
             */
            require_once 'Zend/Service/Amazon/Accessories.php';
            foreach ($result as $r) {
                $this->Accessories[] = new Zend_Service_Amazon_Accessories($r);
            }
        }

        $this->_dom = $dom;
    }


    /**
     * Returns the item's original XML
     *
     * @return string
     */
    public function asXml()
    {
        return $this->_dom->ownerDocument->saveXML($this->_dom);
    }
}
