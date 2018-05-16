# Fast routing

* 1-Router: Original router
* 2-Router: Supports id's in route

When we add multiple routes and IDs the matching is quite slow. 

> The basic idea is to avoid making separate preg_match() calls for each route and instead, combine all regular expressions into a single regular expression.