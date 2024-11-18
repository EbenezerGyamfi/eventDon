<section id="demo" class="pt-5 mt-5 pb-5">
    <div id="container"
        class="d-flex flex-column flex-lg-row justify-content-between align-items-center position-relative gap-5">
        <div id="video-container" onclick="showNotifier()"
            class="bg-danger* text-center d-flex justify-content-center align-items-center col-12* col-md-6* position-relative">
            <svg width="150" height="150" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M0.666687 0.555542H16.884C17.2549 0.555542 17.5556 0.856231 17.5556 1.22714C17.5556 2.6181 16.428 3.74567 15.0371 3.74567H1.55558C1.06466 3.74567 0.666687 3.3477 0.666687 2.85679V0.555542ZM2.16793 6.37283H13.1309C13.5018 6.37283 13.8025 6.67352 13.8025 7.04443C13.8025 8.43536 12.6749 9.56294 11.284 9.56294H3.05682C2.56589 9.56294 2.16793 9.16499 2.16793 8.67405V6.37283ZM16.1334 12.1901H2.16793V14.4913C2.16793 14.9823 2.56589 15.3802 3.05682 15.3802H14.2864C15.6774 15.3802 16.8049 14.2527 16.8049 12.8617C16.8049 12.4908 16.5042 12.1901 16.1334 12.1901Z"
                    fill="#E79D0F" />
            </svg>

            <div
                class="playButton rounded-pill bg-white position-absolute d-flex justfy-content-between align-items-center gap-4 py-2 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                    class="bi bi-play-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path
                        d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z" />
                </svg>

                <div class="d-flex flex-column justfy-content-center align-items-center p-0 gap-0"
                    style="cursor: pointer;" onclick="showNotifier()">
                    <h6 class="fw-bolder p-0 m-0">Play Video</h6>
                    <small>1 min : 08 secs</small>
                </div>
            </div>
        </div>

        <div class="text-center col-lg-6 col-md-6*">
            <h2 class="fw-bolder text-center">We've got just what you're looking for</h2>
            <p class="h4">Watch the video to find out how EventsDon can make your next event to
                the
                next level!</p>
        </div>



    </div>


    <div class="position-fixed bottom-0* notifier p-2 " id="notifier">
        <div class="positon-relative p-3">
            <div class="text-end position-absolute top-0 end-0 mx-3" style="cursor: pointer;" onclick="closeNotifier()">
                <i class="bi bi-x h2 text-light"></i>
            </div>
        </div>

        <div class="text-white text-center">

        </div>
        <div class="mx-auto text-center d-flex justify-content-center align-items-center">
            <iframe class="pt-5 mt-5" width="940" height="529" src="https://www.youtube.com/embed/bTwgX5RDxMs"
                title="EventsDon Is Here!!!" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>

    </div>
</section>
