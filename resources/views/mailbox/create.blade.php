@push('styles')
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}    ">
@endpush
<form
    action="{{ $mailbox->id == null ? route('main_mailbox.store') : route('main_mailbox.update', ['main_mailbox' => $mailbox->id]) }}"
    method="POST" id="mailboxForm" >
        @csrf
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="input-box">
                    <label for="mailer_id" class="input-label">Mailbox ID</label>
                    <input type="text" class="google-input" name="mailer_id"
                           id="mailer_id" value="{{ old('mailer_id', $mailbox->mailer_id) }}"/>
                </div>
                @error('mailer_id')
                <label id="mailer_id-error" class="error"
                       for="mailer_id">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="input-box">
                    <label for="mailbox_name" class="input-label">Mailbox Name</label>
                    <input type="text" class="google-input" name="mailbox_name"
                           id="mailbox_name" value="{{ old('mailbox_name', $mailbox->mailbox_name) }}"/>
                </div>
                @error('mailbox_name')
                <label id="mailbox_name-error" class="error"
                       for="mailbox_name">{{ $message }}</label>
                @enderror
            </div>
        </div>

        <hr class="mt-4 mb-4">
        <div class="form-heading">
            <h5>Incoming Mail (IMAP) Server</h5>
            <span>Configure your imap settings in order to fetch new mail from your inbox.</span>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="input-box">
                    <label for="imap" class="input-label">Mailer ID (IMAP)</label>
                    <div class="col-md-12">
                        <select class="SlectBox form-control" name="imap" id="imap"
                                data-placeholder="Select Mailer ID">
                            <option value="">Select</option>
                            @foreach ($smtps as $smtp)
                                <option value="{{ $smtp->id }}"
                                    {{ isset($mailbox->imap) && $mailbox->imap == $smtp->id ? 'selected' : '' }}>
                                    {{ $smtp->mailer_id }}
                                </option>
                            @endforeach
                        </select>
                        @error('imap')
                        <label id="imap-error" class="error" for="imap">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <hr class="mt-4 mb-4">
        <div class="form-heading">
            <h5>Outgoing Mail (SMTP) Server</h5>
            <span>Select the SwiftMailer config to use for sending emails through your account.</span>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="input-box">
                    <label for="imap" class="input-label">Mailer ID (SMTP)</label>
                    <div class="col-md-12">
                        <select class="SlectBox form-control" name="smtp" id="smtp"
                                data-placeholder="Select Mailer ID">
                            <option value="">Select</option>
                            @foreach ($smtps as $smtp)
                                <option value="{{ $smtp->id }}"
                                    {{ isset($mailbox->smtp) && $mailbox->smtp == $smtp->id ? 'selected' : '' }}>
                                    {{ $smtp->mailer_id }}
                                </option>
                            @endforeach
                        </select>
                        @error('smtp')
                        <label id="smtp-error" class="error" for="smtp">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

{{--        <hr class="mt-4 mb-4">--}}
{{--        <div class="form-heading">--}}
{{--            <h5>Assign Mailbox</h5>--}}
{{--            <span>Select any to manage mailbox.</span>--}}
{{--        </div>--}}
{{--        <div class="row">--}}
{{--            <div class="col-sm-6 col-md-6">--}}
{{--                <div class="input-box">--}}
{{--                    <label for="option_id" class="input-label">Option <span class="text-danger">*</span></label>--}}
{{--                    <div class="col-md-12">--}}
{{--                        <select class="SlectBox form-control" name="option_id" id="option_id">--}}
{{--                            <option value="">Select Option</option>--}}
{{--                            <option value="group" {{ !empty($mailbox->group_id) ? 'selected' : '' }}>Groups</option>--}}
{{--                            <option disabled value="role" {{ !empty($mailbox->role_id) ? 'selected' : '' }}>Roles</option>--}}
{{--                        </select>--}}
{{--                        @error('option_id')--}}
{{--                        <label id="option_id-error" class="error" for="option_id">{{ $message }}</label>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-6 col-md-6 group_section" style="{{ !empty($mailbox->group_id) ? '' : 'display:none;' }}">--}}
{{--                <div class="input-box">--}}
{{--                    <label for="group" class="input-label">Group</label>--}}
{{--                    <div class="col-md-12">--}}
{{--                        <select class="SlectBox form-control" name="group_id" id="group_id">--}}
{{--                            <option value="">Select Group</option>--}}
{{--                            @foreach ($groups as $group)--}}
{{--                                <option value="{{ $group->id }}"--}}
{{--                                    {{ isset($mailbox->group_id) && $mailbox->group_id == $group->id ? 'selected' : '' }}>--}}
{{--                                    {{ $group->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        @error('group')--}}
{{--                        <label id="group-error" class="error" for="group">{{ $message }}</label>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    <div class="modal-footer">
        <button class="btn btn-primary" type="submit">{{ $mailbox->id == null ? 'Save' : 'Update' }}</button>
        <a href="{{ route('main_mailbox.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
{{--@push('script')--}}
    <script type="text/javascript">
        // $(document).ready(function() {
        $("#mailboxForm").validate({
            onkeyup: function(el, e) {
                $(el).valid();
            },
            // errorClass: "invalid-feedback is-invalid",
            // validClass: 'valid-feedback is-valid',
            ignore: ":hidden",
            rules: {
                mailer_id: {
                    required: true,
                },
                mailbox_name:{
                    required:true,
                },
                imap:{
                    required:true,
                },
                smtp:{
                    required:true,
                },
                // option_id:{
                //     required:true,
                // },
                // group_id:{
                //     required:true,
                // },
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                error.insertAfter($(element).parent());
            },
        });

        $("input[type='text'], input[type='number'], input[type='password'], input[type='email'], input[type='tel']").on( "keyup", function() {
            var $input = $(this);
            if($input.val() != ''){
                $input.parents(".input-box").addClass("focus");
            }else{
                $input.parents(".input-box").removeClass("focus");
            }
        } );
        $("input[type='text'], input[type='number'], input[type='password'], input[type='email'], input[type='tel']").each(function(index, element) {
            var value = $(element).val();
            if(value != ''){
                $(this).parents('.input-box').addClass('focus');
            }else{
                $(this).parents('.input-box').removeClass('focus');
            }
        });
        // });
    </script>
{{--@endpush--}}
