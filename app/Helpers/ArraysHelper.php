
/*
*    هادي مهمة بزاف ا زبي
*    شحال ونتا كاتقلب عليها
*/

function array_group(array $data, $by_column)
{
    $result = [];

    foreach ($data as $item) {
        $column = $item[$by_column];
        unset($item[$by_column]);
        if (isset($result[$column])) {
            $result[$column][] = $item;
        } else {
            $result[$column] = array($item);
        }
    }

    return $result;
}










Returns the last element in an array.

function last($items)
{
    return end($items);
}

Returns the head of a list.

function head($items)
{
    return reset($items);
}


Retrieves all of the values for a given key:

function pluck($items, $key)
{
    return array_map( function($item) use ($key) {
        return is_object($item) ? $item->$key : $item[$key];
    }, $items);
}


Returns all elements in an array except for the first one.

function tail($items)
{
    return count($items) > 1 ? array_slice($items, 1) : $items;
}


Returns an array with n elements removed from the beginning.

function take($items, $n = 1)
{
    return array_slice($items, 0, $n);
}


Checks a flat list for duplicate values. Returns true if duplicate values exists and false if values are all unique.

function hasDuplicates($items)
{
    return count($items) > count(array_unique($items));
}



Sorts a collection of arrays or objects by key.

function orderBy($items, $attr, $order)
{
    $sortedItems = [];
    foreach ($items as $item) {
        $key = is_object($item) ? $item->{$attr} : $item[$attr];
        $sortedItems[$key] = $item;
    }
    if ($order === 'desc') {
        krsort($sortedItems);
    } else {
        ksort($sortedItems);
    }

    return array_values($sortedItems);
}