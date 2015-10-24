# CHANGELOG

## develop branch

Nothing yet.

## 1.4.0 - Sat Oct 24 2015

### New

* Operators\CompareTwoStrings - less than / greater than / both are equal calculation

## 1.3.0 - Wed Oct 7 2015

### New

* Filters\FilterOutEmptyValues - strip empty values from the input data

## 1.2.1 - Sat Sep 19 2015

### Test Fixes

* E4xx_UnsupportedType - fixed test to work with latest Exceptions release

## 1.2.0 - Thu Sep 17 2015

### New

* Editors\ReplaceMatchingRegex - search and replace using `preg_replace()`
* Editors\ReplaceMatchingString - search and replace using `str_replace()`
* Editors\TrimWhitespace - removes leading and trailing whitespace

## 1.1.2 - Wed Sep 2 2015

### Fixes

* Filters\FilterColumns - fix types in docblock

## 1.1.1 - Wed Sep 2 2015

### Fixes

* Filters\FilterColumns - resolve 'undefined offset' in PHP 5.5 and earlier

## 1.1.0 - Wed Sep 2 2015 

### New

* Exceptions\E4xx_InvalidPcreRegex - thrown whenever we are given a PCRE regex that does not compile
* Filters\FilterForMatchingRegex - simple regex `grep` like utility class
* Filters\FilterOutMatchingRegex - simple regex `grep -v` like utility class
* Filters\FilterForMatchingString - simple non-regex `grep` like utility class
* Filters\FilterOutMatchingString - simple non-regex `grep -v` like utility class

### Updated

* ValueBuilders\ExpandRange - now supports comma-separated ranges, and single numbers (e.g. "3, 6-8, 10")

## 1.0.0 - Tue Sep 1 2015

### New

* Filters/FilterColumns - PHP equiv of "awk { print $n }"
* ValueBuilders/ExpandRange - turns "n-m" into an array of [ n, n+1, n+2, ... m ]
