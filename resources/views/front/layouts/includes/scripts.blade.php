<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('front') }}/js/home.js"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script defer src="{{ asset('front') }}/js/details.js"></script>
<script>
    const player = new Plyr('#player', {
        controls: ['play-large'],
        speed: {selected: 1}
    });

    const playBtn = document.getElementById("playBtn");
    let played = false

    playBtn.addEventListener("click", () => {
        if(!played){
            player.play();
            played = true;
        }
        else{
            player.pause();
            played = false;
        }
    });
</script>