

@section('title')
    Projet Météo - La station météo 2.0
@endsection

@section('content')
<div class="container">
    <div id="carouselExampleDark" class="carousel slide m-5" data-mdb-ride="carousel" data-mdb-carousel-init>
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active bg-secondary" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" class="bg-secondary" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" class="bg-secondary" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner rounded-5">
            <div class="carousel-item active">
                <div class="d-flex justify-content-between align-items-center px-5 gradient-custom" style="height: 230px">
                    <div>
                        <h2 class="text-dark display-2"><strong>23°C</strong></h2>
                        <p class="text-dark mb-0">Coimbra, Portugal</p>
                    </div>
                    <div>
                        <img src="{{ asset('img/ilu3.webp') }}"
                             width="150px">
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="d-flex justify-content-around text-center align-items-center px-5 bg-body-tertiary"
                     style="height: 230px">
                    <div class="flex-column">
                        <p class="small"><strong>21°C</strong></p>
                        <i class="fas fa-sun fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>12:00</strong></p>
                        <p class="mb-0 text-muted" style="font-size: .65rem;">PM</p>
                    </div>
                    <div class="flex-column">
                        <p class="small"><strong>2°C</strong></p>
                        <i class="fas fa-sun fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>1:00</strong></p>
                        <p class="mb-0 text-muted" style="font-size: .65rem;">PM</p>
                    </div>
                    <div class="flex-column">
                        <p class="small"><strong>20°C</strong></p>
                        <i class="fas fa-cloud fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>2:00</strong></p>
                        <p class="mb-0 text-muted" style="font-size: .65rem;">PM</p>
                    </div>
                    <div class="flex-column">
                        <p class="small"><strong>19°C</strong></p>
                        <i class="fas fa-cloud fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>3:00</strong></p>
                        <p class="mb-0 text-muted" style="font-size: .65rem;">PM</p>
                    </div>
                    <div class="flex-column">
                        <p class="small"><strong>18°C</strong></p>
                        <i class="fas fa-cloud-showers-heavy fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>4:00</strong></p>
                        <p class="mb-0 text-muted" style="font-size: .65rem;">PM</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="d-flex justify-content-around text-center align-items-center px-5 bg-body-tertiary"
                     style="height: 230px">
                    <div class="flex-column">
                        <p class="small"><strong>21°C</strong></p>
                        <i class="fas fa-sun fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>Mon</strong></p>
                    </div>
                    <div class="flex-column">
                        <p class="small"><strong>20°C</strong></p>
                        <i class="fas fa-sun fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>Tue</strong></p>
                    </div>
                    <div class="flex-column">
                        <p class="small"><strong>16°C</strong></p>
                        <i class="fas fa-cloud fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>Wed</strong></p>
                    </div>
                    <div class="flex-column">
                        <p class="small"><strong>17°C</strong></p>
                        <i class="fas fa-cloud fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>Thu</strong></p>
                    </div>
                    <div class="flex-column">
                        <p class="small"><strong>18°C</strong></p>
                        <i class="fas fa-cloud-showers-heavy fa-2x mb-3" style="color: #ddd;"></i>
                        <p class="mb-0"><strong>Fri</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
