<section>
    <h2>
        Update Password
    </h2>
    <p class="mt-1">
        Ensure your account is using a long, random password to stay secure.
    </p>
    @if (session('status') === 'password-updated')
        <div class="message">
            <p class="text-success mt-2">
                Update Password successful.
            </p>
        </div>
    @endif
    @if (session('error'))
        <div class="message">
            <p class="text-danger mt-2">
                {{ $message }} pppp
            </p>
        </div>
    @endif
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">@lang('Current Password')</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control mt-1" autocomplete="current-password">
            @error('current_password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password">@lang('New Password')</label>
            <input id="update_password_password" name="password" type="password" class="form-control mt-1" autocomplete="new-password">
            @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">@lang('Confirm Password')</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control mt-1" autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</section>
