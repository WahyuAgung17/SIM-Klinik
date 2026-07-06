<nav class="navbar navbar-expand-lg bg-white">

    <div class="container-fluid">

        <div>

            <h4 class="fw-bold mb-0" style="font-family:'Fraunces',serif;">

                @yield('title','Dashboard')

            </h4>

            <span class="pulse-rule"></span>

            <small class="text-muted d-block mt-1">

                @yield('breadcrumb','Home')

            </small>

        </div>

        <div class="d-flex align-items-center">

            <!-- Jam -->
            <div class="me-4 text-end">

                <small class="text-muted">

                    <i class="bi bi-calendar-event"></i>

                    <span id="tanggal"></span>

                </small>

                <br>

                <strong id="jam" class="text-mono"></strong>

            </div>

            <!-- Notifikasi -->
            <button class="btn btn-light rounded-circle me-3">

                <i class="bi bi-bell"></i>

            </button>

            <!-- Profile -->
            <div class="dropdown">

                <a
                    class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    href="#"
                    data-bs-toggle="dropdown">

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=1F6F5C&color=fff"
                        width="45"
                        class="rounded-circle">

                    <div class="ms-3">

                        <strong class="d-block">

                            {{ auth()->user()->name ?? 'Administrator' }}

                        </strong>

                        <small class="text-muted">

                            SIM Klinik

                        </small>

                    </div>

                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-person"></i>

                            Profile

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-gear"></i>

                            Pengaturan

                        </a>

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <form action="{{ route('logout') }}" method="POST">

                            @csrf

                            <button type="submit" class="dropdown-item text-danger">

                                <i class="bi bi-box-arrow-right"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>

<script>

function updateClock(){

    const now=new Date();

    document.getElementById('jam').innerHTML=
        now.toLocaleTimeString('id-ID');

    document.getElementById('tanggal').innerHTML=
        now.toLocaleDateString('id-ID',{
            weekday:'long',
            year:'numeric',
            month:'long',
            day:'numeric'
        });

}

updateClock();

setInterval(updateClock,1000);

</script>
