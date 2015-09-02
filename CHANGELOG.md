# CHANGELOG

## develop branch

### New

* ExpandRange - now supports comma-separated ranges, and single numbers (e.g. "3, 6-8, 10")
* Filters\FilterForMatchingRegex - simple regex `grep` like utility class
* Filters\FilterOutMatchingRegex - simple regex `grep -v` like utility class
* Filters\FilterForMatchingString - simple non-regex `grep` like utility class
* Filters\FilterOutMatchingString - simple non-regex `grep -v` like utility class

## 1.0.0 - Tue Sep 1 2015

### New

* Filters/FilterColumns - PHP equiv of "awk { print $n }"
* ValueBuilders/ExpandRange - turns "n-m" into an array of [ n, n+1, n+2, ... m ]
