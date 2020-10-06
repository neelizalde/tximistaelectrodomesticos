<?php

namespace App\Libraries\GObject;

/**
 * La clase GObject
 *
 * Permite convertir las "entidades" de Tximista
 * que son arrays asociativos en objetos
 *
 * Esta clase facilita tarbajar en un entorno orientado a objetos dentro de Tximista
 *
 * Para ello se implenta el método create que toma un array asociativo y lo convierte en
 * un objeto
 *
 * @example
 *
 *      Si tenemos:
 *
 *              $usuario= [
 *                  'usuario_id' => 1,
 *                  'usuario_nombre' => 'joe',
 *                  ...
 *              ];
 *
 *      Entonces:
 *
 *              $user= GObject::create($usuario);
 *
 *      Crea un objeto usuario con las propiedades:
 *
 *              $user->id
 *              $user->nombre
 *              ...
 *
 * @copyright 
 * @author 
 * @api 
 */
class GObject
{
    /**
     * Crea un objeto o un array de objetos según el tipo de entrada recibida
     *
     * @param  array  $array                    Un array asociativo
     * @return mixed                            Un objeto o un array de objetos
     */
    public static function create(array $array)
    {
        // Convierte un array simple a objeto
        if (!isset($array[0])) {
            if (empty($array)) {
                return [];
            } else {
                return self::getObject($array);
            }
        } else {
            $object=[];
            foreach ($array as $item) {
                if (is_array($item)) {
                    $object[]=self::getObject($item);
                } else {
                    $object[]= $item;
                }
            }
            return $object;
        }
    }

    /**
     * Convierte un array a objeto estándar
     *
     * @param  array   $array                    Un array asociativo simple
     *
     * @return object                            Un objeto de la clase StdClass
     */
    private static function getObject(array $array):object
    {
        $object= new \stdClass;
        foreach ($array as $key => $value) {
            if (strpos($key, '_') !== false) {
                $property=explode('_', $key)[1];
            } else {
                $property=$key;
            }

            if (is_array($value)) {
                $value= self::create($value);
            }

            if (property_exists($object, $property)) {
                $object->$key= $value;  // Evita dos propiedades con el mismo nombre
            } else {
                $object->$property= $value;
            }
        }
        return $object;
    }
}
