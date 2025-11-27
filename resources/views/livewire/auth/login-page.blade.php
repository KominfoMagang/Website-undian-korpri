<div class="page page-center">
    <div class="container container-tight py-4">
        
        <div class="text-center mb-4">
            <a href="." class="navbar-brand navbar-brand-autodark">
                <img src="{{ asset('static/images/logo-asnday1.png') }}" height="36" alt="Logo">
            </a>
        </div>

        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Login Admin</h2>
                
                @if ($errors->has('username'))
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first('username') }}
                    </div>
                @endif

                <form wire:submit="login" autocomplete="off">
                    
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                               placeholder="Masukkan username" 
                               wire:model="username"
                               autofocus>
                        </div>

                    <div class="mb-2">
                        <label class="form-label">
                            Password
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="{{ $showPassword ? 'text' : 'password' }}" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Password" 
                                   wire:model="password">
                            
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Show password" 
                                   wire:click.prevent="togglePassword">
                                    
                                    @if($showPassword)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 3.145 -3.594 5.257 -4.197" /><path d="M22 12c-1.457 2.43 -4.013 4.422 -7.139 5.485" /><path d="M19.986 19.995l-15.972 -15.99" /></svg>
                                    @endif
                                </a>
                            </span>
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="login">Sign in</span>
                            <span wire:loading wire:target="login">Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>