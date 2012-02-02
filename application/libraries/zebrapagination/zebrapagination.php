<?php namespace ZebraPagination;

/**
 *  A generic pagination class that automatically generates navigation links given the total number of items and the
 *  number of items per page.
 *
 *  Please note that this is a *generic* pagination class, meaning that it does not display any records! It is up to
 *  developer to fetch the actual data and displaying it based on the information returned by this class. The advantage
 *  is that it can be used to paginate over records coming from any source (arrays, database, etc).
 *
 *  The appearance is customizable through CSS.
 *
 *  The code is heavily commented and generates no warnings/errors/notices when PHP's error reporting level is set to
 *  E_ALL.
 *
 *  Visit {@link http://stefangabos.ro/php-libraries/zebra-pagination/} for more information.
 *
 *  For more resources visit {@link http://stefangabos.ro/}
 *
 *  @author     Stefan Gabos <contact@stefangabos.ro>
 *  @version    1.1c (last revision: May 05, 2011)
 *  @copyright  (c) 2009 - 2011 Stefan Gabos
 *  @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU LESSER GENERAL PUBLIC LICENSE
 *  @package    Zebra_Pagination
 */

class ZebraPagination
{

    /**
     *  Constructor of the class.
     *
     *  Initializes the class and the default properties.
     *
     *  @return void
     */
    function __construct()
    {

        // set default starting page
        $this->page = 1;

        // number of selectable pages
        $this->selectable_pages(11);

        // records per page
        $this->records_per_page(10);

        // by default, we assume there are no records
        // we expect this number to be set after the class is instantiated
        $this->records(0);

        // by default, prefix page number with zeroes
        $this->padding();

        // this is the variable name to be used in the URL for propagating the page number
        $this->variable_name('page');

        // default method for page propagation
        $this->method('get');

        // set the base url
        $this->base_url();

    }

    /**
     *  The base URL to be used when generating the navigation links.
     *
     *  This is helpful for the case when, for example, the URL where the records are paginated may have parameters that
     *  are needed only once and need to be removed for any subsequent requests generated by pagination.
     *
     *  For example, suppose some records are paginated at <i>http://youwebsite/mypage/</i>. When a record from the list
     *  is updated, the URL could become something like <i>http://youwebsite/mypage/?action=updated</i>. Based on the
     *  value of <i>action</i> a message would be shown to the user.
     *
     *  Because of the way this script works, the pagination links would become:
     *
     *  -   <i>http://youwebsite/mypage/?action=updated&page=[page number]</i> when {@link method()} is "get" and
     *      {@link variable_name()} is "page";
     *
     *  -   <i>http://youwebsite/mypage/page/1/?action=updated</i> when {@link method()} is "url" and
     *      {@link variable_name()} is "page").
     *
     *  Because of this, whenever theuser would paginate, the message would be shown to him again and again because
     *  <i>action</i> will be preserved in the URL!
     *
     *  The solution is to set the <i>base_url</i> to <i>http://youwebsite/mypage/</i> and in this way, regardless of
     *  however will the URL be changed, the pagination links will always be in the form of
     *
     *  -   <i>http://youwebsite/mypage/?page=[page number]</i> when {@link method()} is "get" and {@link variable_name()}
     *      is "page";
     *
     *  -   <i>http://youwebsite/mypage/page/1/</i> when {@link method()} is "url" and {@link variable_name()} is "page").
     *
     *  @param  string      $base_url   (Optional) The base URL to be used when generating the navigation links
     *
     *                                  Defaults is whatever returned by
     *                                  {@link http://www.php.net/manual/en/reserved.variables.server.php $_SERVER}['REQUEST_URI']
     *
     *  @return void
     */
    function base_url($base_url = '')
    {

        // set the base URL
        $this->base_url = ($base_url == '' ? $_SERVER['REQUEST_URI'] : $base_url);

    }

    /**
     *  Returns the current page's number.
     *
     *  <code>
     *  // echoes the current page
     *  echo $pagination->get_page();
     *  </code>
     *
     *  @return integer     Returns the current page's number
     */
    function get_page()
    {

        // if page was not already set through the "set_page" method
        if (!isset($this->page_set)) {

            // if
            if (

                // page propagation is SEO friendly
                $this->method == 'url' &&

                // the current page is set in the URL
                preg_match('/\b' . preg_quote($this->variable_name) . '([0-9]+)\b/i', $_SERVER['REQUEST_URI'], $matches) > 0

            ) {

                // set the current page to whatever it is indicated in the URL
                $this->set_page((int)$matches[1]);

            // if page propagation is done through GET and the current page is set in $_GET
            } elseif (isset($_GET[$this->variable_name])) {

                // set the current page to whatever it was set to
                $this->set_page((int)$_GET[$this->variable_name]);

            }

        }

        // get the total number of pages
        $this->_total_pages = ceil($this->records / $this->records_per_page);

        // if there are any pages
        if ($this->_total_pages > 0) {

            // if current page is beyond the total number pages
            /// make the current page be the last page
            if ($this->page > $this->_total_pages) $this->page = $this->_total_pages;

            // if current page is smaller than 1
            // make the current page 1
            elseif ($this->page < 1) $this->page = 1;

        }

        // return the current page
        return $this->page;

    }

    /**
     *  Set the method to be used for page propagation.
     *
     *  <code>
     *  // set the method to the SEO friendly way
     *  $pagination->method('url');
     *  </code>
     *
     *  @param  string  $method     The method to be used for page propagation.
     *
     *                              Values can be:
     *
     *                              - <b>url</b> - page propagation is done in a SEO friendly way;
     *
     *                              This method requires the {@link http://httpd.apache.org/docs/current/mod/mod_rewrite.html mod_rewrite}
     *                              module to be enabled on your Apache server (or the equivalent for other webservers);
     *
     *                              When using this method, the current page will be passed in the URL as
     *                              <i>http://youwebsite.com/yourpage/[variable name]/[page number]/</i> where
     *                              <i>[variable name]</i> is set by {@link variable_name()} and <i>[page number]</i>
     *                              represents the current page.
     *
     *                              - <b>get</b> - page propagation is done through GET;
     *
     *                              When using this method, the current page will be passed in the URL as
     *                              <i>http://youwebsite.com/yourpage?[variable name]=[page number]</i> where
     *                              <i>[variable name]</i> is set by {@link variable_name()} and <i>[page number]</i>
     *                              represents the current page.
     *
     *                              Default is "get".
     *
     *  @returns void
     */
    function method($method)
    {

        // by default, we assume page propagation is done through GET
        $this->method = 'get';

        // make sure method is lowercase
        $method = strtolower($method);

        // if a valid method was specified
        // set the page propagation method
        if ($method == 'get' || $method == 'url') $this->method = $method;

    }

    /**
     *  Sets whether page numbers should be prefixed by zeroes.
     *
     *  This is useful to keep the layout consistent by having the same number of characters for each page number.
     *
     *  <code>
     *  // disable padding numbers with zeroes
     *  $pagination->padding(false);
     *  </code>
     *
     *  @param  boolean     $enabled    (Optional) Setting this property to FALSE will disable padding rather than
     *                                  enabling it.
     *
     *                                  Default is TRUE.
     *
     *  @return void
     */
    function padding($enabled = true)
    {

        // set padding
        $this->padding = $enabled;

    }

    /**
     *  Sets the total number of records that need to be paginated.
     *
     *  Based on this and on the value of {@link records_per_page()}, the script will know how many pages there are.
     *
     *  The total number of pages is given by the fraction between the total number records (set through {@link records()})
     *  and the number of records that are shown on a page (set through {@link records_per_page()}).
     *
     *  <code>
     *  // tell the script that there are 100 total records
     *  $pagination->records(100);
     *  </code>
     *
     *  @param  integer     $records    The total number of records that need to be paginated
     *
     *  @return void
     */
    function records($records)
    {

        // the number of records
        // make sure we save it as an integer
        $this->records = (int)$records;

    }

    /**
     *  Sets the number of records that are displayed on one page.
     *
     *  Based on this and on the value of {@link records()}, the script will know how many pages there are: the total
     *  number of pages is given by the fraction between the total number of records and the number of records that are
     *  shown on one page.
     *
     *  <code>
     *  //  tell the class that there are 20 records displayed on one page
     *  $pagination->records_per_page(20);
     *  </code>
     *
     *  @param  integer     $records_per_page   The number of records displayed on one page.
     *
     *                      Default is 10.
     *
     *  @return void
     */
    function records_per_page($records_per_page)
    {

        // the number of records displayed on one page
        // make sure we save it as an integer
        $this->records_per_page = (int)$records_per_page;

    }

    /**
     *  Generates the output.
     *
     *  <i>Make sure your script references the CSS file!</i>
     *
     *  <code>
     *  //  generate output but don't echo it
     *  //  but return it instead
     *  $output = $pagination->render(true);
     *  </code>
     *
     *  @param  boolean     $return_output      Setting this argument to TRUE will instruct the script to return the
     *                                          generated output rather than outputting it to the screen.
     *
     *                                          Default is FALSE.
     *
     *  @return void
     */
    function render($return_output = false)
    {

        // get some properties of the class
        $this->get_page();

        // if there is a single page, or no pages at all, don't display anything
        if ($this->_total_pages <= 1) return '';

        // start building output
        $output = '<div class="pagination">';

        // if the number of total pages available is greater than the number of selectable pages
        // it means we can show the "previous page" link
        if ($this->_total_pages > $this->selectable_pages) {

            $output .= '<a href="' .

                // the href is different if we're on the first page
                ($this->page == 1 ? 'javascript:void(0)' : $this->_build_uri($this->page - 1)) .

                // if we're on the first page, the link is disabled
                '" class="navigation left' . ($this->page == 1 ? ' disabled' : '') . '"' .

                '>previous page</a>';

        }

        // if the total number of pages is lesser than the number of selectable pages
        if ($this->_total_pages <= $this->selectable_pages) {

            // iterate through the available pages
            for ($i = 1; $i <= $this->_total_pages; $i++) {

                // render the link for each page
                $output .= '<a href="' . $this->_build_uri($i) . '" ' .

                    // make sure to highlight the currently selected page
                    ($this->page == $i ? 'class="current"' : '') . '>' .

                    // apply padding if required
                    ($this->padding ? str_pad($i, strlen($this->_total_pages), '0', STR_PAD_LEFT) : $i) .

                    '</a>';

            }

        // if the total number of pages is greater than the number of selectable pages
        } else {

            // put a link to the first page
            $output .= '<a href="' . $this->_build_uri(1) . '" ' .

                // highlight if it is the currently selected page
                ($this->page == 1 ? 'class="current"' : '') . '>' .

                // apply padding if required
                ($this->padding ? str_pad('1', strlen($this->_total_pages), '0', STR_PAD_LEFT) : '1') .

                '</a>';

            // compute the number of pages to display to the left of the currently selected page
            // so that the current page is always centered
            // (when at the first and the last pages this will not be possible and we'll make some adjustments on the fly)
            $adjacent = floor(($this->selectable_pages - 3) / 2);

            // this number must be at least "1"
            $adjacent = ($adjacent == 0 ? 1 : $adjacent);

            // compute the page after which to show "..." after the link to the first page
            $scroll_from = $this->selectable_pages - $adjacent;

            // this is the number from where we should start rendering selectable pages
            // it's "2" because we have already rendered the first page
            $starting_page = 2;

            // if we need to show "..." after the link to the first page
            if ($this->page >= $scroll_from) {

                // by default, the starting_page should be whatever the current page minus $adjacent
                $starting_page = $this->page - $adjacent;

                // but if that would cause us to display less navigation links than specified in $this->selectable_pages
                if ($this->_total_pages - $starting_page < ($this->selectable_pages - 2)) {

                    // adjust it
                    $starting_page -= ($this->selectable_pages - 2) - ($this->_total_pages - $starting_page);

                }

                // put the "..." after the link to the first page
                $output .= '<span>&hellip;</span>';

            }

            // this is the number where we should stop rendering selectable pages
            // by default, this value is the sum of the starting page plus whatever the number of $this->selectable_pages
            // minus 3 (first page, last page and current page)
            $ending_page = $starting_page + $this->selectable_pages - 3;

            // if ending page would be greater than the total number of pages minus 1
            // (minus one because we don't take into account the very last page which we output automatically)
            // adjust the ending page
            if ($ending_page > $this->_total_pages - 1) $ending_page = $this->_total_pages - 1;

            // place links for each page
            for ($i = $starting_page; $i <= $ending_page; $i++) {

                $output .= '<a href="' . $this->_build_uri($i) . '" ' .

                    // highlight the currently selected page
                    ($this->page == $i ? 'class="current"' : '') . '>' .

                    // apply padding if required
                    ($this->padding ? str_pad($i, strlen($this->_total_pages), '0', STR_PAD_LEFT) : $i) .

                    '</a>';

            }

            // place the "..." before the link to the last page, if it is the case
            if ($this->_total_pages - $ending_page > 1) $output .= '<span>&hellip;</span>';

            // put a link to the last page
            $output .= '<a href="' . $this->_build_uri($this->_total_pages) . '" ' .

                // highlight if it is the currently selected page
                ($this->page == $i ? 'class="current"' : '') . '>' .

                $this->_total_pages .

                '</a>';

            // if the total number of available pages is greater than the number of pages to be displayed at once
            // it means we can show the "next page" link
            if ($this->_total_pages > $this->selectable_pages) {

                $output .= '<a href="' .

                    // the href is different if we're on the last page
                    ($this->page == $this->_total_pages ? 'javascript:void(0)' : $this->_build_uri($this->page + 1)) .

                    // if we're on the last page, the link is disabled
                    '" class="navigation right' . ($this->page == $this->_total_pages ? ' disabled' : '') . '"' .

                    '>next page</a>';

            }

        }

        // finish generating the output
        $output .= '</div>';

        // if $return_output is TRUE
        // return the generated content
        if ($return_output) return $output;

        // if script gets this far, print generated content to the screen
        return $output;

    }

    /**
     *  Sets the number of links to be displayed at once (besides the "previous" and "next" buttons)
     *
     *  <code>
     *  // display links to 15 pages
     *  $pagination->selectable_pages(15);
     *  </code>
     *
     *  @param  integer     $selectable_pages   The number of links to be displayed at once (besides the "previous" and
     *                                          "next" buttons).
     *
     *                                          Default is 10.
     *
     *  @return void
     */
    function selectable_pages($selectable_pages)
    {

        // the number of selectable pages
        // make sure we save it as an integer
        $this->selectable_pages = (int)$selectable_pages;

    }

    /**
     *  Sets the current page.
     *
     *  <code>
     *  // sets the fifth page as the current page
     *  $pagination->set_page(5);
     *  </code>
     *
     *  @param  integer     $page           The page's number.
     *
     *                                      A number lower than <b>1</b> will be interpreted as <b>1</b>, while a number
     *                                      greater than the total number of pages will be interpreted as the last page.
     *
     *                                      The total number of pages is given by the fraction between the total number
     *                                      records (set through {@link records()}) and the number of records that are
     *                                      shown on one page (set through {@link records_per_page()}).
     *
     *  @return void
     */
    function set_page($page)
    {

        // set the current page
        // make sure we save it as an integer
        $this->page = (int)$page;

        // if the number is lower than one
        // make it '1'
        if ($this->page < 1) $this->page = 1;

        // set a flag so that the "get_page" method doesn't change this value
        $this->page_set = true;

    }

    /**
     *  Sets the variable name to be used for page propagation.
     *
     *  <code>
     *  //  sets the variable name to "foo"
     *  //  now, in the URL, the current page will be passed either as "foo=[page number]" (if method is "get") or
     *  //  as "/foo/[page number]" (if method is "url")
     *  $pagination->variable_name('foo');
     *  </code>
     *
     *  @param  string  $variable_name      A string representing the variable name to be used for page propagation.
     *
     *                                      Default is "page".
     *
     *  @return void
     */
    function variable_name($variable_name)
    {

        // set the variable name
        $this->variable_name = strtolower($variable_name);

    }

    /**
     *  Generate the links for the page buttons
     *
     *  @access private
     *
     *  @return void
     */
    function _build_uri($page)
    {

        // if page propagation method is through SEO friendly URLs
        if ($this->method == 'url') {

            // see if the current page is already set in the URL
            if (preg_match('/\b' . $this->variable_name . '([0-9]+)\b/i', $this->base_url, $matches) > 0) {

                // set the current page to whatever it was set to
                return preg_replace(

                    '/\b' . $this->variable_name . '([0-9]+)\b/i',

                    $this->variable_name . $page,

                    $this->base_url

                );

            // if the current page is not yet in the URL
            } else {

                // set the current page to whatever it was set to
                return rtrim($this->base_url, '/') . '/' . $this->variable_name . $page . '/';

            }

        // if page propagation is to be done through GET
        } else {

            // extract the base path from the REQUEST_URI
            $base_path = substr(

                $this->base_url,

                0,

                (

                    strpos($this->base_url, '?') !== false ?

                        strpos($this->base_url, '?') :

                        strlen($this->base_url)

                )

            );

            $url = preg_replace('/(subdomain=[a-zA-Z-0-9&]+)/', false, $_SERVER['QUERY_STRING']);
            print_r($url);
            // if the current page is already set in GET
            if (isset($_GET[$this->variable_name])) {

                // set the current page to whatever it was set to
                $query_string = preg_replace(

                    '/' . $this->variable_name . '=([^\&]*)[\&]*?/i',

                    $this->variable_name . '=' . $page,

                    $url//$_SERVER['QUERY_STRING']

                );

            // if the current page is not already set in GET
            } else {

                // set the current page to whatever it was set to
                $query_string = $url/*$_SERVER['QUERY_STRING']*/ .

                    //(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '' ? '&' : '') .
                    (isset($url) && $url != '' ? '&' : '') .

                    $this->variable_name . '=' . $page;

            }

            // make sure the returned HTML is W3C compliant
            return htmlspecialchars($base_path . '?' . $query_string);

        }

    }

}

?>
