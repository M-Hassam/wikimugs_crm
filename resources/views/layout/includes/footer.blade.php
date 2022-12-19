<div class="container-fluid">
    <div class="nk-footer-wrap">
        <div class="nk-footer-copyright"> &copy; {{ date('Y') }} All right reserved</div>
        <div class="nk-footer-links">
            <ul class="nav nav-sm">
                {{-- <li class="nav-item"><a class="nav-link" href="#">Terms</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Privacy</a></li> --}}
                <li class="nav-item"><a class="nav-link" href="javascript::">Help</a></li>
            </ul>
        </div>
    </div>
</div>
<audio id="chatAudio" >
    {{-- <source src="https://media.geeksforgeeks.org/wp-content/uploads/20190531135120/beep.mp3"  --}}
    <source src="{{ asset('template/src/audio/beep.mp3') }}" 
    type="audio/mpeg">
</audio>
<button class="d-none" onclick="play()" id="btn_press">Press</button>