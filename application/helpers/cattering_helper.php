<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Mirel
 * Date: 11/12/2018
 * Time: 3:08 PM
 */

/**
 * Method to redirect to the previous page
 *
 * Add to one of your helpers
 *
 * USEAGE: redirectPreviousPage();
 */
if ( ! function_exists('redirectPreviousPage'))
{
    function redirectPreviousPage()
    {
        if (isset($_SERVER['HTTP_REFERER']))
        {
            $url = $_SERVER['HTTP_REFERER'];
        }
        else
        {
            $url = $_SERVER['SERVER_NAME'];
        }

        return $url;
    }
}
