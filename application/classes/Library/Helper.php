<?php
/**
 * Copyright (c) 2013 All Rights Reserved - Leeka Media http://www.leeka.ca/
 *
 * @copyright Leeka Media 2013
 * @author Chris Hopewell <chris.hopewell@leeka.ca>
 */
?>

<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Library_Helper
 */
class Library_Helper
{


    /**
     * Helps create a dropdown menu on click. Mostly used on div's
     *
     * @param string $questiontem
     * @param null $link
     * @param null $questioncon
     * @return string
     */
    static public function  dropdownMenu($questiontem, $link = null, $questioncon = null)
    {
        $txt = '';


        switch ($questiontem) {
            case '*start*':
                $txt .= "<div id=dropdown-$link class=dropdown2 dropdown2-tip><ul class=dropdown2-menu>";
                break;
            case '*end*':
                $txt .= "</ul></div>";
                break;
            case '*title*':
                if (strlen($link) > 20) $link = substr($link, 0, 18) . "...";
                $txt .= "<li>";
                $txt .= "<p style='font-weight: bold; margin-left:18px; padding-top: 5px;'>$link</p>";
                $txt .= "</li>";
                break;
            case '*contact*':
                $txt .= "<li>";
                $txt .= "<a href='" . $link . "'>" . HTML::image("images/icon/$questioncon.png", array('title' => ''));
                $txt .= " Send Email</a>";
                $txt .= "</li>";
                break;
            case '*divider*':
                $txt .= '<li class="dropdown2-divider"></li>';
                break;
            default:
                $txt .= "<li>";
                $txt .= "<a href='" . URL::base() . $link . "'>" . HTML::image("images/icon/$questioncon.png", array('title' => ''));
                $txt .= " $questiontem</a>";
                $txt .= "</li>";
                break;
        }
        return $txt;

    }


    /**
     * Displays how many days ago x happened
     *
     * @param $date
     * @return string
     */
    static public function daysAgo($date)
    {

        if (is_null($date)) return "Never";

        $granularity = 2;
        $seconds = time() - $date;
        $units = array(
            '1 day|:count days ago' => 86400);
        $output = '';
        foreach ($units as $key => $value) {
            $key = explode('|', $key);
            if ($seconds >= $value) {
                $count = floor($seconds / $value);
                $output .= ($output ? ' ' : '');
                if ($count == 1) {
                    $output .= $key[0];
                } else {
                    $output .= str_replace(':count', $count, $key[1]);
                }
                $seconds %= $value;
                $granularity--;
            }
            if ($granularity == 0) {
                break;
            }
        }

        if ($output == '1 day') $output = 'Yesterday';

        return $output ? $output : 'Today';
    }

    /**
     * Used to see if something is true or false, and then return the correct image to display (checkmark or x)
     *
     * @param int $item
     * @param null $smaller
     * @return string
     */
    static public function trueOrFalse($item = 0, $smaller = NULL)
    {

        $small = (!is_null($smaller)) ? 'style="width: 10px"' : '';

        if ($item > 0) return "<img src='/images/icon/check.png' $small alt='Yes'>";
        else return "<img src='/images/icon/x.png' $small alt='No'>";

    }

    /**
     * Helps display which menu item is active, depending on which section the user is in
     *
     * @param $controller
     * @param $menu
     * @return string
     */
    static public function menuActive($controller, $menu)
    {
        return (Arr::get($controller, $menu)) ? "active" : "";

    }

    /**
     * Helps display which menu item is active, depending on which section the user is in
     *
     * @param $controller
     * @param $menu
     * @return string
     */
    static public function menuIcon($controller, $menu)
    {

        return (Arr::get($controller, $menu)) ? "<span class='glyphicon glyphicon-folder-open'></span>" :
        "<span class='glyphicon glyphicon-folder-close'></span>";




    }
}