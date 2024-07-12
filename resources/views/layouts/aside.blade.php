
<img src="{{ asset('assets/img/user.png') }}" alt="user" class="img-circle">
<h5 class=" bg-dark name text-center text-white">{{ Auth::user()->name }}</h5>
<h5 class="pararel justify-items-center d-flex">
    <a href="{{ route('profile.edit') }}" class="text-center text-white btn btn-secondary  px-3 py-2 mr-0 a-profile">Profile</a>
    <a class="text-center text-white bg-danger btn btn-primary px-3 py-2 ml-0 a-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</h5>
<hr>
<h4 class="text-start">
    Depository
</h4>

<div class="row d-flex justify-content-center">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show col-12" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show col-12" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @foreach($depositoried as $item)
        <a href="{{ url('depositories/' . $item->id) }}" class="bank py-1 px-2 text-white rounded col-3 m-2" style="background: {{ $item->color }}">{{ $item->name }} Rp. {{ number_format($item->balance, 0, ',', '.') }}</a>
    @endforeach
        <a href="#" data-toggle="modal" data-target="#exampleModal"  class="bank m-2 py-1 px-2 text-white rounded btn btn-secondary col-3" ><i class="fas fa-plus"></i> Add New</a>

</div>


