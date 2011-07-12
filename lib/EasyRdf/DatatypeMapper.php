<?php

/**
 * EasyRdf
 *
 * LICENSE
 *
 * Copyright (c) 2009-2011 Nicholas J Humfrey.  All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 * 3. The name of the author 'Nicholas J Humfrey" may be used to endorse or
 *    promote products derived from this software without specific prior
 *    written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    EasyRdf
 * @copyright  Copyright (c) 2009-2011 Nicholas J Humfrey
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @version    $Id$
 */

/**
 * Class to map between RDF Datatypes and PHP Classes
 *
 * This allows you to map a datatype, such as xsd:date, to
 * a PHP object, such as Zend_Date.
 *
 * @package    EasyRdf
 * @copyright  Copyright (c) 2009-2011 Nicholas J Humfrey
 * @license    http://www.opensource.org/licenses/bsd-license.php
 */
class EasyRdf_DatatypeMapper
{
    private static $_classMap = array();
    private static $_datatypeMap = array();


    /** Get the registered class for an RDF datatype
     *
     * If a datatype is not registered, then this method will return null.
     *
     * @param  string  $class   The PHP class name (e.g. DateTime)
     * @return string           The RDF datatype (e.g. xsd:DateTime)
     */
    public static function datatypeForClass($class)
    {
        if (!is_string($class) or $class == null or $class == '') {
            throw new InvalidArgumentException(
                "\$class should be a string and cannot be null or empty"
            );
        }

        if (array_key_exists($class, self::$_classMap)) {
            return self::$_classMap[$class];
        } else {
            return null;
        }
    }

    /** Get the registered RDF datatype for a PHP class
     *
     * If a datatype is not registered, then this method will return null.
     *
     * @param  string  $datatype The RDF datatype (e.g. xsd:DateTime)
     * @return string            The PHP class name (e.g. DateTime)
     */
    public static function classForDatatype($datatype)
    {
        if (!is_string($datatype) or $datatype == null or $datatype == '') {
            throw new InvalidArgumentException(
                "\$datatype should be a string and cannot be null or empty"
            );
        }

        $datatype = EasyRdf_Namespace::expand($datatype);
        if (array_key_exists($datatype, self::$_datatypeMap)) {
            return self::$_datatypeMap[$datatype];
        } else {
            return null;
        }
    }

    /** Register an RDF datatype with a PHP Class name
     *
     * @param  string  $datatype   The RDF datatype (e.g. xsd:DateTime)
     * @param  string  $class      The PHP class name (e.g. DateTime)
     */
    public static function set($datatype, $class)
    {
        if (!is_string($datatype) or $datatype == null or $datatype == '') {
            throw new InvalidArgumentException(
                "\$datatype should be a string and cannot be null or empty"
            );
        }

        if (!is_string($class) or $class == null or $class == '') {
            throw new InvalidArgumentException(
                "\$class should be a string and cannot be null or empty"
            );
        }

        $datatype = EasyRdf_Namespace::expand($datatype);
        self::$_datatypeMap[$datatype] = $class;
        self::$_classMap[$class] = $datatype;
    }

    /**
      * Delete an existing RDF datatype mapping.
      *
      * @param  string  $datatype   The RDF datatype (e.g. xsd:DateTime)
      */
    public static function delete($datatype)
    {
        if (!is_string($datatype) or $datatype == null or $datatype == '') {
            throw new InvalidArgumentException(
                "\$datatype should be a string and cannot be null or empty"
            );
        }

        $datatype = EasyRdf_Namespace::expand($datatype);
        if (isset(self::$_datatypeMap[$datatype])) {
            $class = self::$_datatypeMap[$datatype];
            unset(self::$_datatypeMap[$datatype]);
            unset(self::$_classMap[$class]);
        }
    }
}