<?php

/**
 * Converter that accepts a SimpleXml object and converts it to a boolean.
 *
 * The XML should have the structure of an ASK query result:
 *
 *     <?xml version='1.0' encoding='UTF-8'?>
 *     <sparql xmlns='http://www.w3.org/2005/sparql-results#'>
 *         <head>
 *         </head>
 *         <boolean>true</boolean>
 *     </sparql>
 *
 * Other XML structures will always be converted to false.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 03.03.14
 */
class Erfurt_Store_Adapter_Stardog_ResultConverter_XmlToBooleanConverter
    implements \Erfurt_Store_Adapter_ResultConverter_ResultConverterInterface
{

    /**
     * Converts the provided XML (as SimpleXml object) to boolean.
     *
     * @param SimpleXMLElement|mixed $resultSet
     * @return boolean
     */
    public function convert($resultSet)
    {
        // TODO: Implement convert() method.
    }

}
