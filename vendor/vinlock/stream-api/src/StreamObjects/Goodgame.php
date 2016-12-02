<?php
/**
 * Created by PhpStorm.
 * User: egor
 * Date: 01.12.2016
 * Time: 12:49
 */

namespace Vinlock\StreamAPI\StreamObjects;

use Vinlock\StreamAPI\StreamInterface;

class Goodgame extends Stream implements StreamInterface
{
    protected $service = 'goodgame';

    const STREAM_KEY = "";

    const GAMES_KEY = "";

    const STREAM_API = "http://goodgame.ru/api/getchannelstatus?fmt=json&id=";

    const GAMES_API = "http://goodgame.ru/api/getchannelsbygame?game=";

    const ALL_GAMES_API = "";

    const STREAM_IMG = "http://edge.sf.hitbox.tv";

    const STREAM_URL = "http://goodgame.ru/";

    public function __construct($array) {
        $this->stream = $array;
    }

    /**
     * Stream Username
     *
     * @return string
     */
    public function username() {
        return $this->stream['media_user_name'];
    }

    /**
     * Stream Display Name
     *
     * @return string
     */
    public function display_name() {
        return $this->stream['media_user_name'];
    }

    /**
     * Stream Game
     *
     * @return string
     */
    public function game() {
        return $this->stream['category_name'];
    }

    /**
     * URL to Large Game Preview
     * @return string
     */
    public function largeGamePreview() {
        return self::STREAM_IMG.stripslashes($this->stream['category_logo_large']);
    }

    /**
     * URL to Medium Game Preview
     * @return string
     */
    public function mediumGamePreview() {

    }

    /**
     * URL to Small Game Preview
     * @return string
     */
    public function smallGamePreview() {
        return self::STREAM_IMG.stripslashes($this->stream['category_logo_small']);
    }

    /**
     * URL to Large Stream Preview
     *
     * @return string
     */
    public function largePreview() {
        return self::STREAM_IMG.stripslashes($this->stream['media_thumbnail_large']);
    }

    /**
     * URL to Medium Stream Preview
     *
     * @return string
     */
    public function mediumPreview() {
        return self::STREAM_IMG.stripslashes($this->stream['media_thumbnail_large']);
    }

    /**
     * URL to Small Stream Preview
     *
     * @return string
     */
    public function smallPreview() {
        return self::STREAM_IMG.stripslashes($this->stream['media_thumbnail']);
    }

    /**
     * Stream Status
     *
     * @return string
     */
    public function status() {
        $status = $this->stream['media_status'];
        $status = htmlspecialchars($status);
        $status = html_entity_decode($status, ENT_QUOTES);
        $status = preg_replace("/\r|\n/", "", $status);
        return $status;
    }

    /**
     * Stream URL
     *
     * @return string
     */
    public function url() {
        return stripslashes($this->stream['embed']);
    }

    /**
     * Stream Viewers
     *
     * @return integer
     */
    public function viewers() {
        return $this->stream['media_views'];
    }

    /**
     * Stream ID
     *
     * @return string
     */
    public function id() {
        return $this->stream['media_id'];
    }

    /**
     * Stream Avatar URL
     *
     * @return string
     */
    public function avatar() {
        return self::STREAM_IMG.stripcslashes($this->stream['channel']['user_logo']);
    }

    public function bio() {
        return "";
    }

    public function created_at() {
        return $this->stream['media_date_added'];
    }

    public function updated_at() {
        return $this->stream['media_live_since'];
    }

    public function followers() {
        return $this->stream['channel']['followers'];
    }

}