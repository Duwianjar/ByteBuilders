<section>
    <h2>
        Profile Information
    </h2>
    <p class="mt-1">
        Update your account's profile information and email address.
    </p>
    @if (session('status') === 'profile-updated')
        <div class="message">
            <p class="text-success mt-2">
                Update Profile successful.
            </p>
        </div>
    @endif
    <form method="post" action="{{ route('profile.update') }}" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="patch">
        <div class="form-group">
            <label for="name">Name</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            <small class="form-text text-danger">{{ $errors->first('name') }}</small>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            <small class="form-text text-danger">{{ $errors->first('email') }}</small>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</section>

