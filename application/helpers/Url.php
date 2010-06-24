<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka_ThemeHelpers
 * @subpackage Omeka_View_Helper
 **/

/**
 * @package Omeka
 * @copyright Center for History and New Media, 2007-2010
 **/
class Omeka_View_Helper_Url extends Zend_View_Helper_Url
{
    /**
     * Generate a URL for use in one of Omeka's view templates.
     * 
     * There are two ways to use this method.  The first way is for backwards compatibility
     * with older versions of Omeka as well as ease of use for theme writers.
     * 
     * Here is an example of what URLs are generated by calling the function in different ways.
     * The output from these examples assume that Omeka is running on the root of 
     * a particular domain, though that is of no importance to how the function works.
     * 
     * <code>echo $this->url('items/browse') // --> /items/browse
     * 
     * echo $this->url('items/browse', array('tags'=>'foo')); // --> /items/browse?tags=foo
     * 
     * echo $this->url(array('controller'=>'items', 'action'=>'browse')); // --> /items/browse
     * 
     * echo $this->url(array('controller'=>'items', 'action'=>'browse'), 'otherRoute', array('tags'=>'foo'));
     *      // --> /miscellaneous?tags=foo</code>
     * 
     * The first example takes a URL string exactly as one would expect it to be.  
     * This primarily exists for ease of use by theme writers.  The second example
     * appends a query string to the URL by passing it as an array.  Note that
     * in both examples, the first string must be properly URL-encoded in order to
     * work.  url('foo bar') would not work because of the space.
     * 
     * In the third example, the URL is being built directly from parameters passed to it.
     * For more details on this, please see the Zend Framework's documentation.
     * 
     * In the last example, 'otherRoute' is the name of the route being used, as
     * defined either in the routes.ini file or via a plugin. For examples of how
     * to add routes via a plugin, please see Omeka's documentation.
     * 
     * @internal Note that the argument list for this function is almost exactly the same as
     * Zend_View_Helper_Url::url(), except that a $queryParams argument has been inserted
     * as the 3rd argument, in between $name and $reset.  This allows the theme writer
     * to pass in an array of parameters that will be appended to the query string
     * and properly encoded. 
     * 
     * @param string|array $options
     * @param string|null|array $name Optional If $options is an array, $name should be
     * the route name (string) or null.  If $options is a string, $name should
     * be the set of query string parameters (array) or null.
     * @param array $queryParams Optional Set of query string parameters.
     * @param boolean $reset Optional Whether or not to reset the route 
     * parameters implied by the current request, e.g. if the current controller
     * is 'items', then 'controller'=>'items' will be inferred when assembling
     * the route.
     * @param boolean $encode
     * @return string
     **/
    public function url($options = array(), $name = null, array $queryParams=array(), $reset = false, $encode = true)
    {
        $url = '';

        $front = Zend_Controller_Front::getInstance();
        
        //If it's a string, just append it
        if(is_string($options)) {
            $url = rtrim($front->getBaseUrl(), '/') . '/';
        	$url .= $options;
        }
        //If it's an array, assemble the URL with Zend_View_Helper_Url
        elseif(is_array($options)) {
            $url = parent::url($options, $name, $reset, $encode);
        }
        
        //If the first argument is a string, then the second is a set of parameters
        // to append to the query string.  If the first argument is an array, then
        // the query parameters are the 3rd argument.
        if (is_string($options)) {
            $queryParams = $name;
        }
        
        if($queryParams) {
            $url .= '?' . http_build_query($queryParams);
        }

        return $url;        
    }
}
