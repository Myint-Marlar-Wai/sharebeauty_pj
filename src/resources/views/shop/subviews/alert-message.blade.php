@php
    assert(isset($vr) && $vr instanceof \App\Http\ViewResources\ViewResource);
    $alertErrorMessage = $vr->getAlertErrorMessage();
    $alertSuccessMessage = $vr->getAlertSuccessMessage();
    if ($alertErrorMessage !== null) {
        $alertIsSuccess = false;
        $alertMessage = $alertErrorMessage;
    } else if ($alertSuccessMessage !== null) {
        $alertIsSuccess = true;
        $alertMessage = $alertSuccessMessage;
    } else {
        $alertIsSuccess = false;
        $alertMessage = null;
    }
@endphp
<!-- Begin Alert Message -->
<div @class(['alt_msg', 'alt_msg-success' => $alertIsSuccess, 'hide' => $alertMessage === null ])>
    @foreach(explode(PHP_EOL, $alertMessage) as $messageLine)
        {{ $messageLine }}<br>
    @endforeach
</div>
<!-- End Alert Message -->
