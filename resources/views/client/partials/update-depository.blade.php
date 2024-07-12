<section>
    <div class="row justify-content-between d-flex">
        <div class="col-auto">
            <h3>{{ $depository->name }} Rp. {{ number_format($depository->balance, 0, ',', '.') }}</h3>
        </div>
        <div class="col-auto">
            <p class="edit text-white bg-primary rounded px-2" id="editButton">
                <i class="fas fa-pencil-alt"></i> Edit
            </p>
        </div>
    </div>

    <p class="mt-1">
        {{ $depository->information }}
    </p>
    @if(session('success-depository'))
        <div class="message">
            <p class="text-success mt-2">
                {{ session('success-depository') }}
            </p>
        </div>
    @elseif(session('error-depository'))
        <div class="message">
            <p class="text-danger mt-2">
                {{ session('error-depository') }}
            </p>
        </div>
    @endif
    <form class="d-hidden d-fade" id="editForm" method="POST" action="{{ route('depositories.update', $depository->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $depository->name) }}" required autofocus autocomplete="name">
            <small class="form-text text-danger">{{ $errors->first('name') }}</small>
        </div>
        <div class="form-group">
            <label for="information">Information</label>
            <input id="information" name="information" type="text" class="form-control" value="{{ old('information', $depository->information) }}" required autocomplete="information">
            <small class="form-text text-danger">{{ $errors->first('information') }}</small>
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input id="color" name="color" type="color" class="form-control" value="{{ old('color', $depository->color) }}" required>
            <small class="form-text text-danger">{{ $errors->first('color') }}</small>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</section>

