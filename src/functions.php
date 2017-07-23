<?php

if (!function_exists('fnGet')) {
    /**
     * Safely get child value from an array or an object
     *
     * Usage:
     *
     * Assume you want to get value from a multidimensional array like: <code>$array = ['l1' => ['l2' => 'value']]</code>,<br>
     * then you can try following:
     *
     * <code>
     * $l1 = fnGet($array, 'l1'); // returns ['l2' => 'value']
     * $l2 = fnGet($array, 'l1.l2'); // returns 'value'
     * $undefined = fnGet($array, 'l3'); // returns null
     * </code>
     *
     * You can specify default value for undefined keys, and the key separator:
     *
     * <code>
     * $l2 = fnGet($array, 'l1/l2', null, '/'); // returns 'value'
     * $undefined = fnGet($array, 'l3', 'default value'); // returns 'default value'
     * </code>
     *
     * @param array|object $array Subject array or object
     * @param string $key Indicates the data element of the target value
     * @param mixed $default Default value if key not found in subject
     * @param string $separator Key level separator, default '.'
     * @param bool $hasObject Indicates that the subject may contains object, default false
     *
     * @return mixed
     */
    function fnGet(&$array, $key, $default = null, $separator = '.', $hasObject = false)
    {
        $tmp =& $array;
        if ($hasObject) {
            foreach (explode($separator, $key) as $subKey) {
                if (isset($tmp->$subKey)) {
                    $tmp =& $tmp->$subKey;
                } else if (is_array($tmp) && isset($tmp[$subKey])) {
                    $tmp =& $tmp[$subKey];
                } else {
                    return $default;
                }
            }
            return $tmp;
        }
        foreach (explode($separator, $key) as $subKey) {
            if (isset($tmp[$subKey])) {
                $tmp =& $tmp[$subKey];
            } else {
                return $default;
            }
        }
        return $tmp;
    }
}
