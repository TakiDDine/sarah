# jnjxp.pagination
Generate pagination menus

## Usage


```php
$totalItems  = 1000;
$perPage     = 10;
$currentPage = 13;
$neighbors   = 3;


$helper = new Jnjxp\Pagination\Helper();

echo $helper
    ->totalItems($totalItems)
    ->perPage($perPage)
    ->currentPage($currentPage)
    ->neighbors($neighbors);
```

```html
<ul class="pagination">
<li class="page-rel-previous page-item"><a aria-label="Previous" class="page-link" href="?page=12"><span aria-hidden="true">&laquo;</span></a></li>
<li class="pager_first pager_head page-item"><a class="page-link" href="?page=1">1</a></li>
<li class="disabled page-item"><a class="page-link" href="#">&hellip;</a></li>
<li class="pager_head pager_ceiling page-item"><a class="page-link" href="?page=9">9</a></li>
<li class="pager_head page-item"><a class="page-link" href="?page=10">10</a></li>
<li class="pager_head page-item"><a class="page-link" href="?page=11">11</a></li>
<li class="pager_head page-item"><a class="page-link" href="?page=12">12</a></li>
<li class="pager_current active page-item"><a class="page-link" href="?page=13">13 <span class="sr-only">(current)</span></a></li>
<li class="pager_tail page-item"><a class="page-link" href="?page=14">14</a></li>
<li class="pager_tail page-item"><a class="page-link" href="?page=15">15</a></li>
<li class="pager_tail page-item"><a class="page-link" href="?page=16">16</a></li>
<li class="pager_tail pager_floor page-item"><a class="page-link" href="?page=17">17</a></li>
<li class="disabled page-item"><a class="page-link" href="#">&hellip;</a></li>
<li class="pager_last pager_tail page-item"><a class="page-link" href="?page=100">100</a></li>
<li class="page-rel-next page-item"><a aria-label="Next" class="page-link" href="?page=14"><span aria-hidden="true">&raquo;</span></a></li>
</ul>
```
