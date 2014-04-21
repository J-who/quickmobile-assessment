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
 * Class Library_Javascript
 *
 * Various onclick javascripts
 */
class Library_Javascript
{

    static public function onClickDelete($name, $url, $class)
    {
        $txt = '';

        $txt .= "function $name(Category) {

        var r = confirm(\"Are you sure you want to delete this item?\");
        if (r == true) {
            $.ajax({
                type: \"POST\",
                url: \" ".URL::site("$url")."/\" + Category,

        success: function (result) {
        $(\".$class-\" + Category).html(result);
        }
        });
        }
        };

        ";

        return $txt;

    }


    // Single = true ignores the $class-number option
    static public function onClickOpen($name, $url, $class, $single = null)
    {
        $txt = '';

        $txt .= "function $name(Category) {

            $.ajax({
                type: \"GET\",
                url: \" ".URL::site("$url")."/\" + Category,

        success: function (result) {";

        if (is_null($single)) {
            $txt .= "$(\".$class-\" + Category).html(result);";
        } else {
            $txt .= "$(\".$class\").html(result);";
        }

        $txt .= "
        }
        });
        };

        ";

        return $txt;

    }

    static public function onClickAppend($name, $url, $class)
    {
        $txt = '';

        $txt .= "function $name(Category) {

            $.ajax({
                type: \"GET\",
                url: \" ".URL::site("$url")."/\" + Category,

        success: function (result) {

        $(\".$class\").append(result);
        }
        });
        };

        ";

        return $txt;

    }

}