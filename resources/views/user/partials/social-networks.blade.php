<div class="panel panel-default">
    <div class="panel-heading">@lang('app.social_networks')</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="facebook">Facebook</label>
                    <div class="input-icon">
                        <i class="fa fa-facebook"></i>
                        <input type="text" class="form-control" id="facebook"
                               name="socials[facebook]" placeholder="Facebook"
                               value="{{ $edit ? $socials->facebook : '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="twitter">Twitter</label>
                    <div class="input-icon">
                        <i class="fa fa-twitter"></i>
                        <input type="text" class="form-control" id="twitter"
                               name="socials[twitter]" placeholder="Twitter"
                               value="{{ $edit ? $socials->twitter : '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="google_plus">Google+</label>
                    <div class="input-icon">
                        <i class="fa fa-google-plus"></i>
                        <input type="text" class="form-control" id="google_plus"
                               name="socials[google_plus]" placeholder="Google+"
                               value="{{ $edit ? $socials->google_plus : '' }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="linkedin">LinkedIn</label>
                    <div class="input-icon">
                        <i class="fa fa-linkedin"></i>
                        <input type="text" class="form-control" id="linkedin"
                               name="socials[linked_in]" placeholder="LinkedIn"
                               value="{{ $edit ? $socials->linked_in : '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="dribbble">Dribbble</label>
                    <div class="input-icon">
                        <i class="fa fa-dribbble"></i>
                        <input type="text" class="form-control" id="dribbble"
                               name="socials[dribbble]" placeholder="Dribbble"
                               value="{{ $edit ? $socials->dribbble : '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Skype">Skype</label>
                    <div class="input-icon">
                        <i class="fa fa-skype"></i>
                        <input type="text" class="form-control" id="skype"
                               name="socials[skype]" placeholder="Skype ID"
                               value="{{ $edit ? $socials->skype : '' }}">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-refresh"></i>
            @lang('app.update_social_networks')
        </button>
    </div>
</div>