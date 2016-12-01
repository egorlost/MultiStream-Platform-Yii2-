<?php
/**
 * Website: vinlock-twitch-api
 * Created By: Vinlock
 * Date: 5/29/16 5:29 PM
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Vinlock\StreamAPI\StreamObjects;


use Vinlock\StreamAPI\StreamInterface;

class Twitch extends Stream implements StreamInterface {

    public $service = 'twitch';

    const STREAM_KEY = "streams";

    const GAMES_KEY = "top";

    const STREAM_API = "https://api.twitch.tv/kraken/streams?channel=";

    const GAMES_API = "https://api.twitch.tv/kraken/streams?game=";

    const ALL_GAMES_API = "https://api.twitch.tv/kraken/games/top";

    const USERS_API = "https://api.twitch.tv/kraken/users/";

    const STREAM_URL = "http://www.twitch.tv/";

    const DEFAULT_AVATAR = "http://static-cdn.jtvnw.net/jtv_user_pictures/xarth/404_user_150x150.png";

    public function __construct($array) {
        $this->stream = $array;
    }

    /**
     * Stream Username
     *
     * @return string
     */
    public function username() {
        return $this->stream['channel']['name'];
    }

    /**
     * Stream Display Name
     *
     * @return string
     */
    public function display_name() {
        return $this->stream['channel']['display_name'];
    }

    /**
     * Stream Game
     *
     * @return string
     */
    public function game() {
        return $this->stream['game']['name'];
    }

    /**
     * URL to Large Game Preview
     * @return string
     */
    public function largeGamePreview() {
        return $this->stream['game']['box']['large'];
    }

    /**
     * URL to Medium Game Preview
     * @return string
     */
    public function mediumGamePreview() {
        return $this->stream['game']['box']['medium'];
    }

    /**
     * URL to Small Game Preview
     * @return string
     */
    public function smallGamePreview() {
        return $this->stream['game']['box']['small'];
    }

    /**
     * URL to Large Stream Preview
     *
     * @return string
     */
    public function largePreview() {
        return $this->stream['preview']['large'];
    }

    /**
     * URL to Medium Stream Preview
     *
     * @return string
     */
    public function mediumPreview() {
        return $this->stream['preview']['medium'];
    }

    /**
     * URL to Small Stream Preview
     *
     * @return string
     */
    public function smallPreview() {
        return $this->stream['preview']['small'];
    }

    /**
     * Stream Status
     *
     * @return string
     */
    public function status() {
        return $this->stream['channel']['status'];
    }

    /**
     * Stream URL
     *
     * @return string
     */
    public function url() {
        return $this->stream['channel']['url'];
    }

    /**
     * Stream Viewers
     *
     * @return integer
     */
    public function viewers() {
        return $this->stream['viewers'];
    }

    /**
     * Stream ID
     *
     * @return string
     */
    public function id() {
        return $this->stream['channel']['_id'];
    }

    /**
     * Stream Avatar URL
     *
     * @return string
     */
    public function avatar() {
        $avatar = $this->stream['channel']['logo'];
        return (is_null($avatar)) ? self::DEFAULT_AVATAR : $avatar;
    }

    public function bio() {
        $json = json_decode(\Requests::get(self::USERS_API.$this->username())->body, true);
        return self::FilterBio($json['bio']);
    }

    public function created_at() {
        return new \DateTime($this->stream['channel']['created_at']);
    }

    public function updated_at() {
        return new \DateTime($this->stream['channel']['updated_at']);
    }

    public function followers() {
        return $this->stream['channel']['followers'];
    }


}