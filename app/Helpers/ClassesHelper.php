// If the function does not exist, let's create it!
if (!\function_exists('obj_to_array')) {
    /**
     * Convert an object to an array
     *
     * @param $object
     *
     * @return array
     */
    function obj_to_array($object): array
    {
        $array = [
            // Intentionally left blank...
        ];
        foreach ($object as $key => $value) {
            if (\is_object($value)) {
                $array[$key] = obj_to_array($value);
            } elseif (\is_array($value)) {
                $array[$key] = obj_to_array($value);
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }
}
