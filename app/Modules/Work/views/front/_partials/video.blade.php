<div class="{{ $columnMixer($content) }}">
    <h3>{{ $content->title }}</h3>
    <p>
        <video id="example_video_{{ rand(1,99999999) }}" class="video-js vjs-default-skin"
               controls preload="auto" width="640" height="264"
               poster="http://video-js.zencoder.com/oceans-clip.png"
               data-setup='{ "controls": true, "autoplay": false, "preload": "auto" }'>
            <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4' />
            <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
            <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />
            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
        </video>
    </p>
</div>