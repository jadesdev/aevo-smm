@if (auth()->user()->kyc != 1)
<div class="alert alert-danger">
    Please Verify Your KYC before you use this Service. <a href="{{route('user.kyc')}}" class="text-info w-100">Submit KYC Details Now</a>
</div>
@endif