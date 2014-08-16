<?php

namespace RCatlin\CustomSearch\Search\Query;

use RCatlin\CustomSearch\Search\Exception\QueryBuilderException;

class Builder
{
    CONST ENCODING_UTF8 = 'utf8';

    // Search template parameters
    /**
     * API Key - REQUIRED
     */
    private $key;

    /**
     * The search expression
     */
    private $searchTerms;

    /**
     * Search terms to match within page titles
     */
    private $inTitleSearchTerms;

    /**
     * Number of search results to return.
     * unsigned integer
     */
    private $limit;

    /**
     * The index of the first result to return.
     * unsigned integer
     */
    private $offset;

    /**
     * Restricts the search to documents written in a particular language (e.g., lr=lang_ja).
     */
    private $language;

    /**
     * Search safety level.
     *
     * Acceptable values are:
     *  "high": Enables highest level of SafeSearch filtering.
     *  "medium": Enables moderate SafeSearch filtering.
     *  "off": Disables SafeSearch filtering. (default)
     */
    private $safe;

    /**
     * The custom search engine ID to use for this request.
     *
     * If both cx and cref are specified, the cx value is used.
     */
    private $cx;

    /**
     * The URL of a linked custom search engine
     * specification to use for this request.
     *
     * Does not apply for Google Site Search
     */
    private $cref;

    /**
     * The sort expression to apply to the results.
     */
    private $sort;

    /**
     * Controls turning on or off the duplicate content filter.
     *
     * Acceptable values are:
     *  "0": Turns off duplicate content filter.
    *   "1": Turns on duplicate content filter.
     */
    private $filter;

    /**
     * Geolocation of end user.
     *
     * The gl parameter value is a two-letter country code.
     * The gl parameter boosts search results whose country of origin matches the parameter value
     */
    private $gl;

    /**
     * The local Google domain (for example, google.com, google.de, or google.fr)
     * to use to perform the search.
     */
    private $googleHost;

    /**
     * Enables or disables Simplified and Traditional Chinese Search.
     */
    private $disableCnTwTranslation;

    /**
     * Appends the specified query terms to the query, as if they were
     * combined with a logical AND operator.
     */
    private $hq;

    /**
     * Sets the user interface language.
     *
     * Explicitly setting this parameter improves the
     * performance and the quality of your search results.
     */
    private $hl = 'en';

    /**
     * Specifies all search results should be pages from a given site.
     */
    private $siteSearch;

    /**
     * Controls whether to include or exclude results from the site named in the siteSearch parameter.
     *
     * Acceptable values are:
     *  "e": exclude
     *  "i": include
     */
    private $siteSearchFilter;

    /**
     * Identifies a phrase that all documents in the search results must contain.
     */
    private $exactTerms;

    /**
     * Identifies a word or phrase that should not appear in any documents in the search results.
     */
    private $excludeTerms;

    /**
     * Specifies that all search results should contain a link to a particular URL
     */
    private $linkSite;

    /**
     * Provides additional search terms to check for in a document,
     * where each document in the search results must contain at least
     * one of the additional search terms.
     */
    private $orTerms;

    /**
     * Specifies that all search results should be pages that are related to the specified URL.
     */
    private $relatedSite;

    /**
     * Restricts results to URLs based on date.
     *
     * Supported values include:
     *  d[number]: requests results from the specified number of past days.
     *  w[number]: requests results from the specified number of past weeks.
     *  m[number]: requests results from the specified number of past months.
     *  y[number]: requests results from the specified number of past years.
     */
    private $dateRestrict;

    /**
     * Specifies the starting value for a search range.
     *
     * Use lowRange and highRange to append an inclusive search range of lowRange...highRange  to the query.
     */
    private $lowRange;

    /**
     * Specifies the ending value for a search range.
     *
     * Use lowRange and highRange to append an inclusive search range of lowRange...highRange  to the query.
     */
    private $highRange;

    /**
     * Specifies the search type: image.  If unspecified, results are limited to webpages.
     *
     * Acceptable values are:
     *  "image": custom image search.
     */
    private $searchType;

    /**
     * Restricts results to files of a specified extension.
     */
    private $fileType;

    /**
     * Filters based on licensing.
     *
     * Supported values include:
     *  cc_publicdomain
     *  cc_attribute
     *  cc_sharealike
     *  cc_noncommercial
     *  cc_nonderived
     *  combinations of these.
     */
    private $rights;

    /**
     * Returns images of a specified size.
     *
     * Acceptable values are:
     *  "huge": huge
     *  "icon": icon
     *  "large": large
     *  "medium": medium
     *  "small": small
     *  "xlarge": xlarge
     *  "xxlarge": xxlarge
     */
    private $imgSize;

    /**
     * Returns images of a type.
     *
     * Acceptable values are:
     *  "clipart": clipart
     *  "face": face
     *  "lineart": lineart
     *  "news": news
     *  "photo": photo
     */
    private $imgType;

    /**
     * Returns black and white, grayscale, or color images: mono, gray, and color.
     *
     * Acceptable values are:
     *  "color": color
     *  "gray": gray
     *  "mono": mono
     */
    private $imgColorType;

    /**
     * Returns images of a specific dominant color.
     *
     * Acceptable values are:
     *  "black": black
     *  "blue": blue
     *  "brown": brown
     *  "gray": gray
     *  "green": green
     *  "pink": pink
     *  "purple": purple
     *  "teal": teal
     *  "white": white
     *  "yellow": yellow
     */
    private $imgDominantColor;

    /**
     * Name of the JavaScript callback function that handles the response.
     *
     * Used in JavaScript JSON-P requests.
     */
    private $callback;

    /**
     * If True, returns the response in a human-readable format.
     *
     * Google Defaults this value to "true" if not provided.
     * When this is "false", it can reduce the response payload size,
     * which might lead to better performance in some environments.
     */
    private $prettyPrint = "false";

    /**
     * Selector specifying a subset of fields to include in the response.
     * Use for better performance.
     *
     * See https://developers.google.com/custom-search/json-api/v1/performance#partial
     */
    private $fields;

    /**
     * Data format for the response.
     *
     * Valid values: json, atom
     * Default value: json
     */
    private $alt = 'json';

    /**
     * Lets you enforce per-user quotas from a server-side application even in cases when the
     * user's IP address is unknown. This can occur, for example, with applications that run cron jobs
     * on App Engine on a user's behalf.
     *
     * You can choose any arbitrary string that uniquely identifies a user, but it is limited to 40 characters.
     * Overrides userIp if both are provided.
     *
     * See https://developers.google.com/console/help/new/#cappingusage
     */
    private $quotaUser;

    /**
     * IP address of the end user for whom the API call is being made.
     *
     * Lets you enforce per-user quotas when calling the API from a server-side application.
     *
     * See https://developers.google.com/console/help/new/#cappingusage
     */
    private $userIp;

    /**
     * Refinements/labels results must contain.
     *
     * Defined in a Google Custom Search Engine.
     *
     * This is a custom field that is included in the
     * in the search terms when build() is called.
     */
    private $includedRefinements;

    /**
     * Refinements/labels to exclude from the search results.
     *
     * Defined in a Google Custom Search Engine.
     *
     * This is a custom field that is included in the
     * in the search terms when build() is called.
     */
    private $excludedRefinements;

    /**
     * Whether refinements should be AND-ed to the query expression
     */
    private $andIncludedRefinements = true;

    /**
     * Default input encoding is UTF-8
     */
    private $inputEncoding = self::ENCODING_UTF8;

    /**
     * Default output encoding is UTF-8
     */
    private $outputEncoding = self::ENCODING_UTF8;

    public static $validAltValues   = array('json', 'atom');
    public static $validSafeValues  = array('on', 'off');

    // dictionary: query-name => variable-name
    private $parameterMap = array(
        'key' => 'key',
        'q' => 'searchTerms',
        'num' => 'limit',
        'start' => 'offset',
        'lr' => 'language',
        'safe' => 'safe',
        'cx' => 'cx',
        'cref' => 'cref',
        'sort' => 'sort',
        'filter' => 'filter',
        'gl' => 'gl',
        'googlehost' => 'googleHost',
        'c2coff' => 'disableCnTwTranslation',
        'hq' => 'hq',
        'hl' => 'hl',
        'siteSearch' => 'siteSearch',
        'siteSearchFilter' => 'siteSearchFilter',
        'exactTerms' => 'exactTerms',
        'linkSite' => 'linkSite',
        'orTerms' => 'orTerms',
        'relatedSite' => 'relatedSite',
        'dateRestrict' => 'dateRestrict',
        'lowRange' => 'lowRange',
        'highRange' => 'highRange',
        'searchType' => 'searchType',
        'fileType' => 'fileType',
        'rights' => 'rights',
        'imgSize' => 'imgSize',
        'imgType' => 'imgType',
        'imgColorType' => 'imgColorType',
        'imgDominantColor' => 'imgDominantColor',
        'alt' => 'alt',
        'callback' => 'callback',
        'prettyPrint' => 'prettyPrint',
        'fields' => 'fields',
        'ie'    => 'inputEncoding',
        'oe'    => 'outputEncoding'
    );

    /**
     * Provide an associate array of matching parameters
     * @param  array                                   $params
     * @return RCatlin\CustomSearch\Search\Query\Query $this
     */
    public function set(array $params = array())
    {
        foreach ($params as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($key, $parameterMap) && function_exists($method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * @param  string                                  $key
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param  string                                  $searchTerms
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setSearchTerms($searchTerms)
    {
        $this->searchTerms = $searchTerms;

        return $this;
    }

    /**
     * Terms to match within page titles
     * @param  strnig                                  $titleSearchTerms
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setInTitleSearchTerms($inTitleSearchTerms)
    {
        $this->inTitleSearchTerms = $inTitleSearchTerms;

        return $this;
    }
    /**
     * @param  int                                     $limit
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setLimit($limit)
    {
        $this->limit = intval($limit);

        return $this;
    }

    /**
     * @param  int                                     $offset
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setOffset($offset)
    {
        $this->offset = intval($offset);

        return $this;
    }

    /**
     * @param  string                                  $language
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setSafe($safe)
    {
        $safe = strtolower($safe);
        if (!in_array($safe, self::$validSafeValues)) {
            throw new QueryBuilderException('safe must be \'on\' or \'off\'');
        }
        // "on" or "off"
        $this->safe = $safe;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setCx($cx)
    {
        $this->cx = $cx;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setCref($cref)
    {
        $this->cref = $cref;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setGl($gl)
    {
        $this->gl = $gl;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setGoogleHost($googleHost)
    {
        $this->googleHost = $googleHost;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setDisableCnTwTranslation($disableCnTwTranslation)
    {
        $this->disableCnTwTranslation = $disableCnTwTranslation;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setHq($hq)
    {
        $this->hq = $hq;

        return $this;
    }

    /**
     * Sets the Home Language
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setHl($hl)
    {
        $this->hl = $hl;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setSiteSearch($siteSearch)
    {
        $this->siteSearch = $siteSearch;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setSiteSearchFilter($siteSearchFilter)
    {
        $this->siteSearchFilter = $siteSearchFilter;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setExactTerms($exactTerms)
    {
        $this->exactTerms = $exactTerms;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setExcludeTerms($excludeTerms)
    {
        $this->excludeTerms = $excludeTerms;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setLinkSite($linkSite)
    {
        $this->linkSite = $linkSite;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setOrTerms($orTerms)
    {
        $this->orTerms = $orTerms;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setRelatedSite($relatedSite)
    {
        $this->relatedSite = $relatedSite;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setDateRestrict($dateRestrict)
    {
        $this->dateRestrict = $dateRestrict;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setLowRange($lowRange)
    {
        $this->lowRange = $lowRange;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setHighRange($highRange)
    {
        $this->highRange = $highRange;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setRights($rights)
    {
        $this->rights = $rights;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setImgSize($imgSize)
    {
        $this->imgSize = $imgSize;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setImgType($imgType)
    {
        $this->imgType = $imgType;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setImgColorType($imgColorType)
    {
        $this->imgColorType = $imgColorType;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setImgDominantColor($imgDominantColor)
    {
        $this->imgDominantColor = $imgDominantColor;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    // TODO Support alternate return types
    // public function setAlt($alt)
    // {
    //     if (!in_array($alt, self::$validAltValues)) {
    //         return;
    //     }
    //     $this->alt = $alt;

    //     return $this;
    // }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function enablePrettyPrint()
    {
        $this->prettyPrint = "true";

        return $this;
    }

    /**
     * Example: 'queries,items/labels,items/pagemap(pagemap,some-facet)'
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setSelectFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setQuotaUser($quotaUser)
    {
        $this->quotaUser = $quotaUser;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setUserIp($userIp)
    {
        $this->userIp = $userIp;

        return $this;
    }

    /**
     * Refinements are of the form "type:value"
     *
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setIncludedRefinements(array $includedRefinements)
    {
        $this->includedRefinements = $includedRefinements;

        return $this;
    }

    /**
     * Refinements are of the form "type:value"
     *
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function addIncludedRefinement($includedRefinement)
    {
        if (!isset($this->includedRefinements)) {
            $this->includedRefinements = array();
        }

        $this->includedRefinements[] = $includedRefinement;

        return $this;
    }

    /**
     * Refinements are of the form "type:value"
     *
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setExcludedRefinements(array $excludedRefinements)
    {
        $this->excludedRefinements = $excludedRefinements;

        return $this;
    }

    /**
     * Refinements are of the form "type:value"
     *
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function addExcludedRefinement($excludedRefinement)
    {
        if (!isset($this->excludedRefinements)) {
            $this->excludedRefinements = array();
        }
        $this->excludedRefinements[] = $excludedRefinement;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setInputEncoding($inputEncoding)
    {
        $this->inputEncoding = $inputEncoding;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setOutputEncoding($outputEncoding)
    {
        $this->outputEncoding = $outputEncoding;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function orIncludedRefinements()
    {
        $this->andIncludedRefinements = false;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query;
     */
    public function getQuery()
    {
        if (empty($this->cx) && empty($this->cref)) {
            throw new QueryBuilderException('cx or cref must be set');
        }

        // Build parameters that will form our query string
        $params = array();
        foreach ($this->parameterMap as $key => $name) {
            if (isset($this->$name) && $this->$name !== null) {
                $params[$key] = $key . '=' . urlencode($this->$name);
            }
        }

        // Ensure param 'q' is at least an empty string
        if (!isset($params['q'])) {
            $params['q'] = 'q=';
        }

        // Add refinements to searchTerms ('q')
        $refinements = array();
        $refinementPrefix = ($this->andIncludedRefinements) ? ' ' : ' OR ';

        // Add intitle search terms to 'q' param
        if (isset($this->inTitleSearchTerms)) {
            $params['q'] .= urlencode(
                sprintf(
                    ' intitle:%s',
                    $this->inTitleSearchTerms
                )
            );
        }

        // Add included refinements to 'q' param
        if (!empty($this->includedRefinements)) {
            foreach ($this->includedRefinements as $refinement) {
                $refinements[] = "more:" . $refinement;
            }
            $params['q'] .= urlencode(
                sprintf(
                    ' %s',
                    implode($refinementPrefix, $refinements)
                )
            );
        }

        // Add excluded refinements to 'q' param
        if (!empty($this->excludedRefinements)) {
            foreach ($this->excludedRefinements as $refinement) {
                $refinements[] = "-more:" . $refinement;
            }
            $params['q'] .= urlencode(
                sprintf(
                    ' %s',
                    implode($refinementPrefix, $refinements)
                )
            );
        }

        // Create Query String
        $queryString = '?' . implode('&', $params);

        return new Query($queryString);
    }
}
